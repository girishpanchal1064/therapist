<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public function index()
    {
        $assessments = Assessment::active()
            ->ordered()
            ->withCount(['questions', 'userAssessments as completion_count' => function($query) {
                $query->where('status', 'completed');
            }])
            ->get();

        return view('web.assessments.index', compact('assessments'));
    }

    public function show($slug)
    {
        $assessment = Assessment::where('slug', $slug)
            ->where('is_active', true)
            ->with(['questions' => function($query) {
                $query->ordered();
            }])
            ->firstOrFail();

        return view('web.assessments.show', compact('assessment'));
    }

    public function start($slug)
    {
        $assessment = Assessment::where('slug', $slug)
            ->where('is_active', true)
            ->with(['questions' => function($query) {
                $query->ordered();
            }])
            ->firstOrFail();

        return view('web.assessments.take', compact('assessment'));
    }
}
