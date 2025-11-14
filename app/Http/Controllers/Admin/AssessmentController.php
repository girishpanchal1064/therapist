<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status', 'all');
        $category = $request->get('category');
        $perPage = $request->get('per_page', 15);

        $query = Assessment::withCount(['questions', 'userAssessments']);

        // Apply search
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Apply status filter
        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        // Apply category filter
        if ($category) {
            $query->where('category', $category);
        }

        $assessments = $query->orderBy('sort_order')->orderBy('title')->paginate($perPage);

        // Get unique categories for filter
        $categories = Assessment::distinct()->pluck('category')->filter()->sort()->values();

        return view('admin.assessments.index', compact('assessments', 'search', 'status', 'category', 'perPage', 'categories'));
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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:assessments,slug,' . $assessment->id,
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'duration_minutes' => 'required|integer|min:1|max:300',
            'question_count' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $assessment->update([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'icon' => $validated['icon'] ?? null,
            'color' => $validated['color'] ?? '#3B82F6',
            'duration_minutes' => $validated['duration_minutes'],
            'question_count' => $validated['question_count'] ?? $assessment->questions()->count(),
            'is_active' => $request->has('is_active'),
            'sort_order' => $validated['sort_order'] ?? 0,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
        ]);

        return redirect()->route('admin.assessments.index')
            ->with('success', 'Assessment updated successfully.');
    }

    public function destroy(Assessment $assessment)
    {
        $assessment->delete();
        return redirect()->route('admin.assessments.index');
    }

    public function results(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status', 'all');
        $assessmentId = $request->get('assessment_id');
        $perPage = $request->get('per_page', 15);

        $query = \App\Models\UserAssessment::with(['user', 'assessment']);

        // Apply search
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                              ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('assessment', function($assessmentQuery) use ($search) {
                    $assessmentQuery->where('title', 'like', "%{$search}%");
                });
            });
        }

        // Apply status filter
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        // Apply assessment filter
        if ($assessmentId) {
            $query->where('assessment_id', $assessmentId);
        }

        $results = $query->orderBy('created_at', 'desc')->paginate($perPage);

        // Statistics
        $totalAssessments = \App\Models\UserAssessment::count();
        $completedAssessments = \App\Models\UserAssessment::where('status', 'completed')->count();
        $inProgressAssessments = \App\Models\UserAssessment::where('status', 'in_progress')->count();
        $abandonedAssessments = \App\Models\UserAssessment::where('status', 'abandoned')->count();
        $averageScore = \App\Models\UserAssessment::where('status', 'completed')
            ->whereNotNull('total_score')
            ->avg('total_score');
        $averagePercentage = \App\Models\UserAssessment::where('status', 'completed')
            ->whereNotNull('percentage')
            ->avg('percentage');

        // Get all assessments for filter
        $assessments = Assessment::orderBy('title')->get();

        return view('admin.assessments.results', compact(
            'results', 
            'search', 
            'status', 
            'assessmentId', 
            'perPage',
            'assessments',
            'totalAssessments',
            'completedAssessments',
            'inProgressAssessments',
            'abandonedAssessments',
            'averageScore',
            'averagePercentage'
        ));
    }

    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate',
            'ids' => 'required|string',
        ]);

        $action = $request->input('action');
        $idsJson = $request->input('ids');
        $ids = json_decode($idsJson, true);

        if (!is_array($ids) || empty($ids)) {
            return redirect()->route('admin.assessments.index')
                ->with('error', 'Invalid selection. Please select at least one assessment.');
        }

        // Validate that all IDs exist
        $validIds = Assessment::whereIn('id', $ids)->pluck('id')->toArray();
        
        if (empty($validIds)) {
            return redirect()->route('admin.assessments.index')
                ->with('error', 'No valid assessments found.');
        }

        $isActive = $action === 'activate';
        Assessment::whereIn('id', $validIds)->update(['is_active' => $isActive]);

        $count = count($validIds);
        $message = $isActive 
            ? "{$count} assessment(s) activated successfully." 
            : "{$count} assessment(s) deactivated successfully.";

        return redirect()->route('admin.assessments.index')
            ->with('success', $message);
    }
}
