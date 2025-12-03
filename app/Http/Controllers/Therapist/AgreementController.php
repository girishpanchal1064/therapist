<?php

namespace App\Http\Controllers\Therapist;

use App\Http\Controllers\Controller;
use App\Models\Agreement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgreementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $therapistId = Auth::id();
        $search = $request->get('search');
        $type = $request->get('type');
        $status = $request->get('status');

        $query = Agreement::where('therapist_id', $therapistId)
            ->with('client');

        // Search functionality
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhereHas('client', function($clientQuery) use ($search) {
                      $clientQuery->where('name', 'like', "%{$search}%")
                                   ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by type
        if ($type) {
            $query->where('type', $type);
        }

        // Filter by status
        if ($status) {
            $query->where('status', $status);
        }

        $perPage = $request->get('per_page', 10);
        
        $agreements = $query->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->appends($request->query());

        return view('therapist.agreements.index', compact('agreements', 'search', 'type', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $therapistId = Auth::id();
        
        // Get clients for this therapist (from appointments)
        $clients = User::whereHas('appointmentsAsClient', function($query) use ($therapistId) {
            $query->where('therapist_id', $therapistId);
        })->distinct()->get();

        return view('therapist.agreements.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'nullable|exists:users,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:general,client_specific',
            'status' => 'required|in:draft,active,signed,expired',
            'effective_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|after:effective_date',
            'signed_date' => 'nullable|date',
            'signature_data' => 'nullable|string',
        ]);

        // If type is general, client_id should be null
        if ($validated['type'] === 'general') {
            $validated['client_id'] = null;
        }

        // If type is client_specific, client_id is required
        if ($validated['type'] === 'client_specific' && !$validated['client_id']) {
            return redirect()->back()
                ->withErrors(['client_id' => 'Client is required for client-specific agreements.'])
                ->withInput();
        }

        $validated['therapist_id'] = Auth::id();

        Agreement::create($validated);

        return redirect()->route('therapist.agreements.index')
            ->with('success', 'Agreement created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $agreement = Agreement::where('therapist_id', Auth::id())
            ->with('client')
            ->findOrFail($id);

        return view('therapist.agreements.show', compact('agreement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $agreement = Agreement::where('therapist_id', Auth::id())
            ->with('client')
            ->findOrFail($id);

        $therapistId = Auth::id();
        $clients = User::whereHas('appointmentsAsClient', function($query) use ($therapistId) {
            $query->where('therapist_id', $therapistId);
        })->distinct()->get();

        return view('therapist.agreements.edit', compact('agreement', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $agreement = Agreement::where('therapist_id', Auth::id())
            ->findOrFail($id);

        $validated = $request->validate([
            'client_id' => 'nullable|exists:users,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:general,client_specific',
            'status' => 'required|in:draft,active,signed,expired',
            'effective_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|after:effective_date',
            'signed_date' => 'nullable|date',
            'signature_data' => 'nullable|string',
        ]);

        // If type is general, client_id should be null
        if ($validated['type'] === 'general') {
            $validated['client_id'] = null;
        }

        // If type is client_specific, client_id is required
        if ($validated['type'] === 'client_specific' && !$validated['client_id']) {
            return redirect()->back()
                ->withErrors(['client_id' => 'Client is required for client-specific agreements.'])
                ->withInput();
        }

        $agreement->update($validated);

        return redirect()->route('therapist.agreements.index')
            ->with('success', 'Agreement updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $agreement = Agreement::where('therapist_id', Auth::id())
            ->findOrFail($id);

        $agreement->delete();

        return redirect()->route('therapist.agreements.index')
            ->with('success', 'Agreement deleted successfully.');
    }
}
