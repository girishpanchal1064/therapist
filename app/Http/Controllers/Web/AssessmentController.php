<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Services\AssessmentSubmissionService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;

class AssessmentController extends Controller
{
    public function index()
    {
        $assessments = Assessment::active()
            ->ordered()
            ->withCount(['questions', 'userAssessments as completion_count' => function ($query) {
                $query->where('status', 'completed');
            }])
            ->get();

        $assessmentHistory = null;
        $user = auth()->user();

        if ($user && $user->isClient()) {
            $latest = $user->assessments()
                ->completed()
                ->with('assessment')
                ->orderByDesc('completed_at')
                ->orderByDesc('created_at')
                ->first();

            $assessmentHistory = [
                'count' => $user->assessments()->completed()->count(),
                'latest' => $latest,
            ];
        }

        return view('web.assessments.index', compact('assessments', 'assessmentHistory'));
    }

    public function show($slug)
    {
        $assessment = Assessment::where('slug', $slug)
            ->where('is_active', true)
            ->with(['questions' => function ($query) {
                $query->ordered();
            }])
            ->firstOrFail();

        return view('web.assessments.show', compact('assessment'));
    }

    public function start($slug)
    {
        $assessment = Assessment::where('slug', $slug)
            ->where('is_active', true)
            ->with(['questions' => function ($query) {
                $query->ordered();
            }])
            ->firstOrFail();

        return view('web.assessments.take', compact('assessment'));
    }

    public function submit(Request $request, string $slug, AssessmentSubmissionService $submissionService): JsonResponse|RedirectResponse
    {
        $user = $request->user();

        $assessment = Assessment::query()
            ->where('slug', $slug)
            ->active()
            ->with(['questions' => fn ($query) => $query->ordered()])
            ->firstOrFail();

        $validated = $request->validate([
            'answers' => ['required', 'array'],
        ]);

        try {
            $answersByQuestionId = $submissionService->normalizeAnswers($validated['answers']);
            $userAssessment = $submissionService->submit($user, $assessment, $answersByQuestionId);
        } catch (AuthorizationException $e) {
            return $this->submitError($request, $e->getMessage(), 403);
        } catch (InvalidArgumentException $e) {
            return $this->submitError($request, $e->getMessage(), 422);
        } catch (\Throwable $e) {
            report($e);

            return $this->submitError($request, 'Failed to save your assessment. Please try again.', 500);
        }

        $redirectUrl = route('client.assessments.history.show', $userAssessment);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Assessment submitted successfully.',
                'redirect_url' => $redirectUrl,
                'result' => [
                    'id' => $userAssessment->id,
                    'total_score' => $userAssessment->total_score,
                    'max_score' => $userAssessment->max_score,
                    'percentage' => $userAssessment->percentage,
                ],
            ], 201);
        }

        return redirect()
            ->to($redirectUrl)
            ->with('success', 'Assessment completed! View your score below.');
    }

    private function submitError(Request $request, string $message, int $status): JsonResponse|RedirectResponse
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $message,
            ], $status);
        }

        return back()->with('error', $message);
    }
}
