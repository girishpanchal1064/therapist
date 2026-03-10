<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AssessmentResource;
use App\Http\Resources\UserAssessmentResource;
use App\Models\Assessment;
use App\Models\AssessmentQuestion;
use App\Models\User;
use App\Models\UserAssessment;
use App\Models\UserAssessmentAnswer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssessmentController extends Controller
{
    /**
     * List active assessments for the app.
     */
    public function index(Request $request): JsonResponse
    {
        $assessments = Assessment::query()
            ->active()
            ->ordered()
            ->get();

        return response()->json([
            'success' => true,
            'data' => AssessmentResource::collection($assessments),
        ]);
    }

    /**
     * Show a single assessment with its ordered questions.
     */
    public function show(int $id, Request $request): JsonResponse
    {
        $assessment = Assessment::query()
            ->active()
            ->with(['questions' => function ($query) {
                $query->ordered();
            }])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => new AssessmentResource($assessment),
        ]);
    }

    /**
     * Submit answers for an assessment and compute a simple score.
     */
    public function submit(int $id, Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $assessment = Assessment::query()
            ->active()
            ->with(['questions' => function ($query) {
                $query->ordered();
            }])
            ->findOrFail($id);

        $validated = $request->validate([
            'answers' => ['required', 'array'],
        ]);

        $answersInput = $validated['answers'];

        DB::beginTransaction();

        try {
            $userAssessment = UserAssessment::create([
                'user_id' => $user->id,
                'assessment_id' => $assessment->id,
                'status' => 'completed',
                'started_at' => now(),
                'completed_at' => now(),
            ]);

            $totalScore = 0;
            $maxScore = 0;

            foreach ($assessment->questions as $question) {
                $answerData = $answersInput[$question->id] ?? null;

                if ($answerData === null && $question->required) {
                    DB::rollBack();

                    return response()->json([
                        'success' => false,
                        'message' => 'Missing answer for required question: ' . $question->id,
                    ], 422);
                }

                if ($answerData === null) {
                    continue;
                }

                $answerText = is_array($answerData) ? json_encode($answerData) : (string) $answerData;
                $answerValue = null;
                $score = 0;

                if (is_numeric($answerData)) {
                    $answerValue = (int) $answerData;
                    $score = $answerValue * ($question->weight ?? 1);
                }

                UserAssessmentAnswer::create([
                    'user_assessment_id' => $userAssessment->id,
                    'question_id' => $question->id,
                    'answer_text' => $answerText,
                    'answer_value' => $answerValue,
                    'score' => $score,
                ]);

                $totalScore += $score;
                $maxScore += (int) ($question->weight ?? 1) * 5;
            }

            $percentage = $maxScore > 0 ? ($totalScore / $maxScore) * 100 : null;

            $userAssessment->update([
                'total_score' => $totalScore,
                'max_score' => $maxScore,
                'percentage' => $percentage,
                'result_summary' => [
                    'total_score' => $totalScore,
                    'max_score' => $maxScore,
                    'percentage' => $percentage,
                ],
            ]);

            DB::commit();

            $userAssessment->load(['assessment', 'answers.question']);

            return response()->json([
                'success' => true,
                'message' => 'Assessment submitted successfully.',
                'data' => new UserAssessmentResource($userAssessment),
            ], 201);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to submit assessment.',
            ], 500);
        }
    }

    /**
     * List assessment responses for the authenticated user.
     */
    public function responses(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $query = UserAssessment::query()
            ->where('user_id', $user->id)
            ->with('assessment')
            ->orderByDesc('created_at');

        $perPage = (int) $request->get('per_page', 10);
        $responses = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => [
                'items' => UserAssessmentResource::collection($responses),
                'pagination' => [
                    'current_page' => $responses->currentPage(),
                    'last_page' => $responses->lastPage(),
                    'per_page' => $responses->perPage(),
                    'total' => $responses->total(),
                ],
            ],
        ]);
    }

    /**
     * Show a single assessment response for the authenticated user.
     */
    public function showResponse(int $id, Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $response = UserAssessment::query()
            ->where('user_id', $user->id)
            ->with(['assessment', 'answers.question'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => new UserAssessmentResource($response),
        ]);
    }
}

