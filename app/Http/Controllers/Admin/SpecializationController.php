<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TherapistSpecialization;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class SpecializationController extends Controller
{
    /**
     * Check if user is SuperAdmin
     */
    private function checkSuperAdmin()
    {
        if (!Auth::user() || !Auth::user()->hasRole('SuperAdmin')) {
            abort(403, 'Unauthorized access. Only SuperAdmin can access this page.');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->checkSuperAdmin();
        $specializations = TherapistSpecialization::ordered()->paginate(15);
        return view('admin.specializations.index', compact('specializations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->checkSuperAdmin();
        return view('admin.specializations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->checkSuperAdmin();
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:therapist_specializations,name',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active') ? true : false;
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        TherapistSpecialization::create($validated);

        return redirect()->route('admin.specializations.index')
            ->with('success', 'Specialization created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TherapistSpecialization $specialization)
    {
        $this->checkSuperAdmin();
        return view('admin.specializations.show', compact('specialization'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TherapistSpecialization $specialization)
    {
        $this->checkSuperAdmin();
        return view('admin.specializations.edit', compact('specialization'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TherapistSpecialization $specialization)
    {
        $this->checkSuperAdmin();
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:therapist_specializations,name,' . $specialization->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active') ? true : false;
        $validated['sort_order'] = $validated['sort_order'] ?? $specialization->sort_order;

        $specialization->update($validated);

        return redirect()->route('admin.specializations.index')
            ->with('success', 'Specialization updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TherapistSpecialization $specialization)
    {
        $this->checkSuperAdmin();
        $specialization->delete();

        return redirect()->route('admin.specializations.index')
            ->with('success', 'Specialization deleted successfully.');
    }
}
