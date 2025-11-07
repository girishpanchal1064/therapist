<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AreaOfExpertise;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AreaOfExpertiseController extends Controller
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
        $areas = AreaOfExpertise::ordered()->paginate(15);
        return view('admin.areas-of-expertise.index', compact('areas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->checkSuperAdmin();
        return view('admin.areas-of-expertise.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->checkSuperAdmin();
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:areas_of_expertise,name',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active') ? true : false;
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        AreaOfExpertise::create($validated);

        return redirect()->route('admin.areas-of-expertise.index')
            ->with('success', 'Area of Expertise created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $this->checkSuperAdmin();
        $areasOfExpertise = AreaOfExpertise::findOrFail($id);
        return view('admin.areas-of-expertise.show', compact('areasOfExpertise'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $this->checkSuperAdmin();
        $areasOfExpertise = AreaOfExpertise::findOrFail($id);
        return view('admin.areas-of-expertise.edit', compact('areasOfExpertise'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->checkSuperAdmin();
        $areasOfExpertise = AreaOfExpertise::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:areas_of_expertise,name,' . $areasOfExpertise->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active') ? true : false;
        $validated['sort_order'] = $validated['sort_order'] ?? $areasOfExpertise->sort_order;

        $areasOfExpertise->update($validated);

        return redirect()->route('admin.areas-of-expertise.index')
            ->with('success', 'Area of Expertise updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->checkSuperAdmin();
        $areasOfExpertise = AreaOfExpertise::findOrFail($id);
        $areasOfExpertise->delete();

        return redirect()->route('admin.areas-of-expertise.index')
            ->with('success', 'Area of Expertise deleted successfully.');
    }
}
