<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public function index()
    {
        $assessments = Assessment::paginate(15);
        return view('admin.assessments.index', compact('assessments'));
    }

    public function create()
    {
        return view('admin.assessments.create');
    }

    public function store(Request $request)
    {
        // Implementation for storing assessments
    }

    public function show(Assessment $assessment)
    {
        return view('admin.assessments.show', compact('assessment'));
    }

    public function edit(Assessment $assessment)
    {
        return view('admin.assessments.edit', compact('assessment'));
    }

    public function update(Request $request, Assessment $assessment)
    {
        // Implementation for updating assessments
    }

    public function destroy(Assessment $assessment)
    {
        $assessment->delete();
        return redirect()->route('admin.assessments.index');
    }

    public function results()
    {
        return view('admin.assessments.results');
    }
}
