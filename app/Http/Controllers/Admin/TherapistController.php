<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TherapistProfile;
use App\Models\TherapistSpecialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class TherapistController extends Controller
{
    public function index(Request $request)
    {
        $query = User::whereHas('roles', function($q) {
            $q->where('name', 'Therapist');
        })->with(['therapistProfile.specializations']);

        // Search by name
        if ($request->filled('search_name')) {
            $searchName = $request->search_name;
            $query->where(function($q) use ($searchName) {
                $q->where('name', 'like', '%' . $searchName . '%')
                  ->orWhere('email', 'like', '%' . $searchName . '%');
            });
        }

        // Filter by status
        if ($request->filled('search_status')) {
            $query->where('status', $request->search_status);
        }

        // Filter by specialization
        if ($request->filled('search_specialization')) {
            $query->whereHas('therapistProfile.specializations', function($q) use ($request) {
                $q->where('therapist_specializations.id', $request->search_specialization);
            });
        }

        $therapists = $query->paginate(15)->withQueryString();
        $specializations = TherapistSpecialization::all();

        return view('admin.therapists.index', compact('therapists', 'specializations'));
    }

    public function create()
    {
        $specializations = TherapistSpecialization::all();
        return view('admin.therapists.create', compact('specializations'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'bio' => 'required|string',
            'experience_years' => 'required|integer|min:0',
            'consultation_fee' => 'required|numeric|min:0',
            'specializations' => 'required|array',
            'specializations.*' => 'exists:therapist_specializations,id',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'certifications' => 'nullable|string',
            'education' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'status' => 'active',
        ]);

        $user->assignRole('Therapist');

        // Handle profile image upload
        $profileImagePath = null;
        if ($request->hasFile('profile_image')) {
            $profileImagePath = $request->file('profile_image')->store('therapist-profiles', 'public');
        }

        $therapistProfile = TherapistProfile::create([
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'bio' => $request->bio,
            'experience_years' => $request->experience_years,
            'consultation_fee' => $request->consultation_fee,
            'profile_image' => $profileImagePath,
            'certifications' => $request->certifications,
            'education' => $request->education,
            'is_verified' => true,
            'is_approved' => true,
        ]);

        // Attach specializations to therapist profile
        if ($user->therapistProfile) {
            $user->therapistProfile->specializations()->attach($request->specializations);
        }

        return redirect()->route('admin.therapists.index')
            ->with('success', 'Therapist created successfully.');
    }

    public function show(User $therapist)
    {
        $therapist->load(['therapistProfile.specializations', 'appointmentsAsTherapist.client']);
        return view('admin.therapists.show', compact('therapist'));
    }

    public function edit(User $therapist)
    {
        $specializations = TherapistSpecialization::all();
        $therapist->load(['therapistProfile.specializations']);
        return view('admin.therapists.edit', compact('therapist', 'specializations'));
    }

    public function update(Request $request, User $therapist)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $therapist->id,
            'phone' => 'required|string|max:20',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'bio' => 'required|string',
            'experience_years' => 'required|integer|min:0',
            'consultation_fee' => 'required|numeric|min:0',
            'specializations' => 'required|array',
            'specializations.*' => 'exists:therapist_specializations,id',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'certifications' => 'nullable|string',
            'education' => 'nullable|string',
            'status' => 'required|in:active,inactive,suspended',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $therapist->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $request->status,
        ]);

        // Handle profile image upload
        $profileImagePath = $therapist->therapistProfile->profile_image;
        if ($request->hasFile('profile_image')) {
            // Delete old image
            if ($profileImagePath) {
                Storage::disk('public')->delete($profileImagePath);
            }
            $profileImagePath = $request->file('profile_image')->store('therapist-profiles', 'public');
        }

        $therapist->therapistProfile->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'bio' => $request->bio,
            'experience_years' => $request->experience_years,
            'consultation_fee' => $request->consultation_fee,
            'profile_image' => $profileImagePath,
            'certifications' => $request->certifications,
            'education' => $request->education,
        ]);

        // Sync specializations with therapist profile
        if ($therapist->therapistProfile) {
            $therapist->therapistProfile->specializations()->sync($request->specializations);
        }

        return redirect()->route('admin.therapists.index')
            ->with('success', 'Therapist updated successfully.');
    }

    public function destroy(User $therapist)
    {
        // Delete profile image
        if ($therapist->therapistProfile && $therapist->therapistProfile->profile_image) {
            Storage::disk('public')->delete($therapist->therapistProfile->profile_image);
        }

        $therapist->delete();
        return redirect()->route('admin.therapists.index')
            ->with('success', 'Therapist deleted successfully.');
    }

    public function pending()
    {
        $therapists = User::whereHas('roles', function($query) {
            $query->where('name', 'Therapist');
        })->whereHas('therapistProfile', function($query) {
            $query->where('is_approved', false);
        })->with(['therapistProfile.specializations'])->paginate(15);

        return view('admin.therapists.pending', compact('therapists'));
    }

    public function approve(User $therapist)
    {
        if ($therapist->therapistProfile) {
            $therapist->therapistProfile->update([
                'is_approved' => true,
                'is_verified' => true,
            ]);
        }

        return redirect()->back()
            ->with('success', 'Therapist approved successfully.');
    }

    public function reject(User $therapist)
    {
        if ($therapist->therapistProfile) {
            $therapist->therapistProfile->update([
                'is_approved' => false,
                'is_verified' => false,
            ]);
        }

        return redirect()->back()
            ->with('success', 'Therapist rejected successfully.');
    }
}
