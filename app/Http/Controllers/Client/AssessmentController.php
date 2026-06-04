<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\UserAssessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    public function history(Request $request)
    {
        $user = Auth::user();

        $query = $user->assessments()
            ->with('assessment')
            ->orderByDesc('completed_at')
            ->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('assessment_id')) {
            $query->where('assessment_id', $request->assessment_id);
        }

        $responses = $query->paginate(12)->withQueryString();

        $stats = [
            'total' => $user->assessments()->count(),
            'completed' => $user->assessments()->where('status', 'completed')->count(),
            'in_progress' => $user->assessments()->whereIn('status', ['started', 'in_progress'])->count(),
        ];

        $assessmentFilters = Assessment::query()
            ->whereIn('id', $user->assessments()->select('assessment_id')->distinct())
            ->orderBy('title')
            ->get(['id', 'title']);

        return view('client.assessments.history', compact('responses', 'stats', 'assessmentFilters'));
    }

    public function show(UserAssessment $userAssessment)
    {
        if ($userAssessment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $userAssessment->load(['assessment', 'answers.question']);

        return view('client.assessments.show', compact('userAssessment'));
    }
}
