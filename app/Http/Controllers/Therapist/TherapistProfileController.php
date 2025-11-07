<?php

namespace App\Http\Controllers\Therapist;

use App\Http\Controllers\Controller;
use App\Models\TherapistProfile;
use App\Models\TherapistExperience;
use App\Models\TherapistQualification;
use App\Models\TherapistAward;
use App\Models\TherapistProfessionalBody;
use App\Models\TherapistBankDetail;
use App\Models\AreaOfExpertise;
use App\Models\TherapistSpecialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TherapistProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $profile = $user->therapistProfile;
        
        if (!$profile) {
            $profile = TherapistProfile::create([
                'user_id' => $user->id,
                'license_number' => 'TEMP-' . time(),
                'specialization' => '',
                'qualification' => '',
                'experience_years' => 0,
                'consultation_fee' => 0.00,
                'couple_consultation_fee' => 0.00,
                'bio' => '',
                'languages' => [],
            ]);
        }

        $tab = $request->get('tab', 'basic-info');
        
        $data = [
            'profile' => $profile,
            'user' => $user,
            'tab' => $tab,
        ];

        // Load related data based on tab
        switch ($tab) {
            case 'experience':
                $data['experiences'] = $profile->experiences()->orderBy('starting_date', 'desc')->get();
                break;
            case 'qualifications':
                $data['qualifications'] = $profile->qualifications()->orderBy('year_of_passing', 'desc')->get();
                break;
            case 'area-of-expertise':
                $data['areasOfExpertise'] = AreaOfExpertise::active()->ordered()->get();
                $data['selectedAreas'] = $profile->areas_of_expertise ?? [];
                break;
            case 'awards':
                $data['awards'] = $profile->awards()->orderBy('year', 'desc')->get();
                break;
            case 'professional-bodies':
                $data['professionalBodies'] = $profile->professionalBodies()->get();
                break;
            case 'bank-details':
                $data['bankDetails'] = $profile->bankDetails()->get();
                break;
            case 'specializations':
                $data['specializations'] = $profile->specializations()->get();
                break;
        }

        return view('therapist.profile.index', $data);
    }

    public function updateBasicInfo(Request $request)
    {
        $user = Auth::user();
        $profile = $user->therapistProfile;

        if (!$profile) {
            $profile = TherapistProfile::create([
                'user_id' => $user->id,
                'license_number' => 'TEMP-' . time(),
                'specialization' => '',
                'qualification' => '',
                'experience_years' => 0,
                'consultation_fee' => 0.00,
                'couple_consultation_fee' => 0.00,
                'bio' => '',
                'languages' => [],
            ]);
        }

        $request->validate([
            'prefix' => 'nullable|string|max:10',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'email' => 'required|email',
            'user_name' => 'nullable|string|max:255',
            'mobile' => 'nullable|string|max:20',
            'gender' => 'nullable|string|in:Male,Female,Other',
            'date_of_birth' => 'nullable|date',
            'languages' => 'nullable|array',
            'brief_description' => 'nullable|string',
            'present_address' => 'nullable|string',
            'present_country' => 'nullable|string',
            'present_state' => 'nullable|string',
            'present_city' => 'nullable|string',
            'present_district' => 'nullable|string',
            'present_zip' => 'nullable|string',
            'clinic_address' => 'nullable|string',
            'same_as_present_address' => 'nullable|boolean',
            'clinic_country' => 'nullable|string',
            'clinic_state' => 'nullable|string',
            'clinic_city' => 'nullable|string',
            'clinic_district' => 'nullable|string',
            'clinic_zip' => 'nullable|string',
            'timezone' => 'nullable|string',
            'experience_years' => 'nullable|string',
        ]);

        // Update user email if changed
        if ($request->email !== $user->email) {
            $user->email = $request->email;
            $user->save();
        }

        // Update user phone if changed
        if ($request->mobile && $request->mobile !== $user->phone) {
            $user->phone = $request->mobile;
            $user->save();
        }

        // Update user gender and date_of_birth
        if ($request->gender) {
            $user->gender = strtolower($request->gender);
            $user->save();
        }
        if ($request->date_of_birth) {
            $user->date_of_birth = $request->date_of_birth;
            $user->save();
        }

        // Update profile
        $profile->update($request->only([
            'prefix', 'first_name', 'middle_name', 'last_name', 'category',
            'user_name', 'brief_description', 'present_address',
            'present_country', 'present_state', 'present_city', 'present_district', 'present_zip',
            'clinic_address', 'same_as_present_address',
            'clinic_country', 'clinic_state', 'clinic_city', 'clinic_district', 'clinic_zip',
            'timezone', 'languages'
        ]));

        if ($request->experience_years) {
            $profile->experience_years = (int) str_replace([' years', ' year', 'yrs', 'yr'], '', $request->experience_years);
            $profile->save();
        }

        return redirect()->route('therapist.profile.index', ['tab' => 'basic-info'])
            ->with('success', 'Basic information updated successfully!');
    }

    public function storeExperience(Request $request)
    {
        $user = Auth::user();
        $profile = $user->therapistProfile;

        $request->validate([
            'designation' => 'required|string|max:255',
            'hospital_organisation' => 'required|string|max:255',
            'starting_date' => 'required|date',
            'last_date' => 'nullable|date',
            'document' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        $data = [
            'designation' => $request->designation,
            'hospital_organisation' => $request->hospital_organisation,
            'starting_date' => $request->starting_date,
            'last_date' => $request->last_date,
        ];

        if ($request->hasFile('document')) {
            $data['document'] = $request->file('document')->store('therapist-experiences', 'public');
        }

        $profile->experiences()->create($data);

        return redirect()->route('therapist.profile.index', ['tab' => 'experience'])
            ->with('success', 'Experience added successfully!');
    }

    public function updateExperience(Request $request, TherapistExperience $experience)
    {
        // Ensure the experience belongs to the authenticated therapist
        if ($experience->therapistProfile->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'designation' => 'required|string|max:255',
            'hospital_organisation' => 'required|string|max:255',
            'starting_date' => 'required|date',
            'last_date' => 'nullable|date',
            'document' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        $data = [
            'designation' => $request->designation,
            'hospital_organisation' => $request->hospital_organisation,
            'starting_date' => $request->starting_date,
            'last_date' => $request->last_date,
        ];

        if ($request->hasFile('document')) {
            if ($experience->document) {
                Storage::disk('public')->delete($experience->document);
            }
            $data['document'] = $request->file('document')->store('therapist-experiences', 'public');
        }

        $experience->update($data);

        return redirect()->route('therapist.profile.index', ['tab' => 'experience'])
            ->with('success', 'Experience updated successfully!');
    }

    public function deleteExperience(TherapistExperience $experience)
    {
        if ($experience->therapistProfile->user_id !== Auth::id()) {
            abort(403);
        }

        if ($experience->document) {
            Storage::disk('public')->delete($experience->document);
        }

        $experience->delete();

        return redirect()->route('therapist.profile.index', ['tab' => 'experience'])
            ->with('success', 'Experience deleted successfully!');
    }

    public function storeQualification(Request $request)
    {
        $user = Auth::user();
        $profile = $user->therapistProfile;

        $request->validate([
            'name_of_degree' => 'required|string|max:255',
            'degree_in' => 'required|string|max:255',
            'institute_university' => 'required|string|max:255',
            'year_of_passing' => 'required|string',
            'percentage_cgpa' => 'required|string',
            'certificate' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        $data = $request->only(['name_of_degree', 'degree_in', 'institute_university', 'year_of_passing', 'percentage_cgpa']);

        if ($request->hasFile('certificate')) {
            $data['certificate'] = $request->file('certificate')->store('therapist-qualifications', 'public');
        }

        $profile->qualifications()->create($data);

        return redirect()->route('therapist.profile.index', ['tab' => 'qualifications'])
            ->with('success', 'Qualification added successfully!');
    }

    public function updateQualification(Request $request, TherapistQualification $qualification)
    {
        if ($qualification->therapistProfile->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name_of_degree' => 'required|string|max:255',
            'degree_in' => 'required|string|max:255',
            'institute_university' => 'required|string|max:255',
            'year_of_passing' => 'required|string',
            'percentage_cgpa' => 'required|string',
            'certificate' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        $data = $request->only(['name_of_degree', 'degree_in', 'institute_university', 'year_of_passing', 'percentage_cgpa']);

        if ($request->hasFile('certificate')) {
            if ($qualification->certificate) {
                Storage::disk('public')->delete($qualification->certificate);
            }
            $data['certificate'] = $request->file('certificate')->store('therapist-qualifications', 'public');
        }

        $qualification->update($data);

        return redirect()->route('therapist.profile.index', ['tab' => 'qualifications'])
            ->with('success', 'Qualification updated successfully!');
    }

    public function deleteQualification(TherapistQualification $qualification)
    {
        if ($qualification->therapistProfile->user_id !== Auth::id()) {
            abort(403);
        }

        if ($qualification->certificate) {
            Storage::disk('public')->delete($qualification->certificate);
        }

        $qualification->delete();

        return redirect()->route('therapist.profile.index', ['tab' => 'qualifications'])
            ->with('success', 'Qualification deleted successfully!');
    }

    public function updateAreasOfExpertise(Request $request)
    {
        $user = Auth::user();
        $profile = $user->therapistProfile;

        $request->validate([
            'areas_of_expertise' => 'nullable|array',
        ]);

        $profile->areas_of_expertise = $request->areas_of_expertise ?? [];
        $profile->save();

        return redirect()->route('therapist.profile.index', ['tab' => 'area-of-expertise'])
            ->with('success', 'Areas of expertise updated successfully!');
    }

    public function storeAward(Request $request)
    {
        $user = Auth::user();
        $profile = $user->therapistProfile;

        $request->validate([
            'award_name' => 'required|string|max:255',
            'awarded_by' => 'required|string|max:255',
            'year' => 'required|string',
            'description' => 'nullable|string',
            'document' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        $data = $request->only(['award_name', 'awarded_by', 'year', 'description']);

        if ($request->hasFile('document')) {
            $data['document'] = $request->file('document')->store('therapist-awards', 'public');
        }

        $profile->awards()->create($data);

        return redirect()->route('therapist.profile.index', ['tab' => 'awards'])
            ->with('success', 'Award added successfully!');
    }

    public function updateAward(Request $request, TherapistAward $award)
    {
        if ($award->therapistProfile->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'award_name' => 'required|string|max:255',
            'awarded_by' => 'required|string|max:255',
            'year' => 'required|string',
            'description' => 'nullable|string',
            'document' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        $data = $request->only(['award_name', 'awarded_by', 'year', 'description']);

        if ($request->hasFile('document')) {
            if ($award->document) {
                Storage::disk('public')->delete($award->document);
            }
            $data['document'] = $request->file('document')->store('therapist-awards', 'public');
        }

        $award->update($data);

        return redirect()->route('therapist.profile.index', ['tab' => 'awards'])
            ->with('success', 'Award updated successfully!');
    }

    public function deleteAward(TherapistAward $award)
    {
        if ($award->therapistProfile->user_id !== Auth::id()) {
            abort(403);
        }

        if ($award->document) {
            Storage::disk('public')->delete($award->document);
        }

        $award->delete();

        return redirect()->route('therapist.profile.index', ['tab' => 'awards'])
            ->with('success', 'Award deleted successfully!');
    }

    public function storeProfessionalBody(Request $request)
    {
        $user = Auth::user();
        $profile = $user->therapistProfile;

        $request->validate([
            'body_name' => 'required|string|max:255',
            'membership_number' => 'nullable|string|max:255',
            'membership_type' => 'nullable|string|max:255',
            'year_joined' => 'nullable|string',
            'document' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        $data = $request->only(['body_name', 'membership_number', 'membership_type', 'year_joined']);

        if ($request->hasFile('document')) {
            $data['document'] = $request->file('document')->store('therapist-professional-bodies', 'public');
        }

        $profile->professionalBodies()->create($data);

        return redirect()->route('therapist.profile.index', ['tab' => 'professional-bodies'])
            ->with('success', 'Professional body added successfully!');
    }

    public function updateProfessionalBody(Request $request, TherapistProfessionalBody $professionalBody)
    {
        if ($professionalBody->therapistProfile->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'body_name' => 'required|string|max:255',
            'membership_number' => 'nullable|string|max:255',
            'membership_type' => 'nullable|string|max:255',
            'year_joined' => 'nullable|string',
            'document' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        $data = $request->only(['body_name', 'membership_number', 'membership_type', 'year_joined']);

        if ($request->hasFile('document')) {
            if ($professionalBody->document) {
                Storage::disk('public')->delete($professionalBody->document);
            }
            $data['document'] = $request->file('document')->store('therapist-professional-bodies', 'public');
        }

        $professionalBody->update($data);

        return redirect()->route('therapist.profile.index', ['tab' => 'professional-bodies'])
            ->with('success', 'Professional body updated successfully!');
    }

    public function deleteProfessionalBody(TherapistProfessionalBody $professionalBody)
    {
        if ($professionalBody->therapistProfile->user_id !== Auth::id()) {
            abort(403);
        }

        if ($professionalBody->document) {
            Storage::disk('public')->delete($professionalBody->document);
        }

        $professionalBody->delete();

        return redirect()->route('therapist.profile.index', ['tab' => 'professional-bodies'])
            ->with('success', 'Professional body deleted successfully!');
    }

    public function storeBankDetail(Request $request)
    {
        $user = Auth::user();
        $profile = $user->therapistProfile;

        $request->validate([
            'account_holder_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'ifsc_code' => 'required|string|max:20',
            'branch_name' => 'nullable|string|max:255',
            'account_type' => 'nullable|string|max:50',
        ]);

        $profile->bankDetails()->create($request->all());

        return redirect()->route('therapist.profile.index', ['tab' => 'bank-details'])
            ->with('success', 'Bank details added successfully!');
    }

    public function updateBankDetail(Request $request, TherapistBankDetail $bankDetail)
    {
        if ($bankDetail->therapistProfile->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'account_holder_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'ifsc_code' => 'required|string|max:20',
            'branch_name' => 'nullable|string|max:255',
            'account_type' => 'nullable|string|max:50',
        ]);

        $bankDetail->update($request->all());

        return redirect()->route('therapist.profile.index', ['tab' => 'bank-details'])
            ->with('success', 'Bank details updated successfully!');
    }

    public function deleteBankDetail(TherapistBankDetail $bankDetail)
    {
        if ($bankDetail->therapistProfile->user_id !== Auth::id()) {
            abort(403);
        }

        $bankDetail->delete();

        return redirect()->route('therapist.profile.index', ['tab' => 'bank-details'])
            ->with('success', 'Bank details deleted successfully!');
    }
}
