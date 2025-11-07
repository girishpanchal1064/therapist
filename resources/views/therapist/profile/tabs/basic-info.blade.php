<div>
  <h5 class="mb-4">Basic Information</h5>
  
  <form action="{{ route('therapist.profile.basic-info.update') }}" method="POST">
    @csrf
    
    <div class="row mb-3">
      <div class="col-md-3">
        <label class="form-label">Prefix</label>
        <select name="prefix" class="form-select">
          <option value="">Select</option>
          <option value="Mr." {{ $profile->prefix === 'Mr.' ? 'selected' : '' }}>Mr.</option>
          <option value="Mrs." {{ $profile->prefix === 'Mrs.' ? 'selected' : '' }}>Mrs.</option>
          <option value="Ms." {{ $profile->prefix === 'Ms.' ? 'selected' : '' }}>Ms.</option>
          <option value="Dr." {{ $profile->prefix === 'Dr.' ? 'selected' : '' }}>Dr.</option>
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label">First Name <span class="text-danger">*</span></label>
        <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $profile->first_name) }}" required>
      </div>
      <div class="col-md-3">
        <label class="form-label">Middle Name</label>
        <input type="text" name="middle_name" class="form-control" value="{{ old('middle_name', $profile->middle_name) }}">
      </div>
      <div class="col-md-3">
        <label class="form-label">Last Name <span class="text-danger">*</span></label>
        <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $profile->last_name) }}" required>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-4">
        <label class="form-label">Category</label>
        <input type="text" name="category" class="form-control" value="{{ old('category', $profile->category) }}">
      </div>
      <div class="col-md-4">
        <label class="form-label">User Name</label>
        <input type="text" name="user_name" class="form-control" value="{{ old('user_name', $profile->user_name) }}">
      </div>
      <div class="col-md-4">
        <label class="form-label">Email <span class="text-danger">*</span></label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-4">
        <label class="form-label">Mobile</label>
        <input type="text" name="mobile" class="form-control" value="{{ old('mobile', $user->phone) }}">
      </div>
      <div class="col-md-4">
        <label class="form-label">Gender</label>
        <select name="gender" class="form-select">
          <option value="">Select</option>
          <option value="Male" {{ strtolower($user->gender ?? '') === 'male' ? 'selected' : '' }}>Male</option>
          <option value="Female" {{ strtolower($user->gender ?? '') === 'female' ? 'selected' : '' }}>Female</option>
          <option value="Other" {{ strtolower($user->gender ?? '') === 'other' ? 'selected' : '' }}>Other</option>
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Date of Birth</label>
        <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d')) }}">
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-12">
        <label class="form-label">Languages</label>
        <select name="languages[]" class="form-select" multiple>
          <option value="English" {{ in_array('English', $profile->languages ?? []) ? 'selected' : '' }}>English</option>
          <option value="Hindi" {{ in_array('Hindi', $profile->languages ?? []) ? 'selected' : '' }}>Hindi</option>
          <option value="Spanish" {{ in_array('Spanish', $profile->languages ?? []) ? 'selected' : '' }}>Spanish</option>
          <option value="French" {{ in_array('French', $profile->languages ?? []) ? 'selected' : '' }}>French</option>
          <option value="German" {{ in_array('German', $profile->languages ?? []) ? 'selected' : '' }}>German</option>
        </select>
        <small class="text-muted">Hold Ctrl/Cmd to select multiple</small>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-12">
        <label class="form-label">Brief Description</label>
        <textarea name="brief_description" class="form-control" rows="3">{{ old('brief_description', $profile->brief_description) }}</textarea>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-4">
        <label class="form-label">Experience (Years)</label>
        <input type="text" name="experience_years" class="form-control" value="{{ old('experience_years', $profile->experience_years) }}" placeholder="e.g., 5 years">
      </div>
      <div class="col-md-4">
        <label class="form-label">Timezone</label>
        <select name="timezone" class="form-select">
          <option value="">Select Timezone</option>
          <option value="Asia/Kolkata" {{ $profile->timezone === 'Asia/Kolkata' ? 'selected' : '' }}>Asia/Kolkata (IST)</option>
          <option value="UTC" {{ $profile->timezone === 'UTC' ? 'selected' : '' }}>UTC</option>
          <option value="America/New_York" {{ $profile->timezone === 'America/New_York' ? 'selected' : '' }}>America/New_York (EST)</option>
          <option value="Europe/London" {{ $profile->timezone === 'Europe/London' ? 'selected' : '' }}>Europe/London (GMT)</option>
        </select>
      </div>
    </div>

    <hr class="my-4">

    <h6 class="mb-3">Present Address</h6>
    <div class="row mb-3">
      <div class="col-md-12">
        <label class="form-label">Address</label>
        <textarea name="present_address" class="form-control" rows="2">{{ old('present_address', $profile->present_address) }}</textarea>
      </div>
    </div>
    <div class="row mb-3">
      <div class="col-md-3">
        <label class="form-label">Country</label>
        <input type="text" name="present_country" class="form-control" value="{{ old('present_country', $profile->present_country) }}">
      </div>
      <div class="col-md-3">
        <label class="form-label">State</label>
        <input type="text" name="present_state" class="form-control" value="{{ old('present_state', $profile->present_state) }}">
      </div>
      <div class="col-md-3">
        <label class="form-label">City</label>
        <input type="text" name="present_city" class="form-control" value="{{ old('present_city', $profile->present_city) }}">
      </div>
      <div class="col-md-3">
        <label class="form-label">District</label>
        <input type="text" name="present_district" class="form-control" value="{{ old('present_district', $profile->present_district) }}">
      </div>
    </div>
    <div class="row mb-3">
      <div class="col-md-3">
        <label class="form-label">ZIP Code</label>
        <input type="text" name="present_zip" class="form-control" value="{{ old('present_zip', $profile->present_zip) }}">
      </div>
    </div>

    <hr class="my-4">

    <h6 class="mb-3">Clinic Address</h6>
    <div class="row mb-3">
      <div class="col-md-12">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="same_as_present_address" id="same_as_present" value="1" {{ $profile->same_as_present_address ? 'checked' : '' }}>
          <label class="form-check-label" for="same_as_present">
            Same as Present Address
          </label>
        </div>
      </div>
    </div>
    <div class="row mb-3" id="clinic-address-fields">
      <div class="col-md-12">
        <label class="form-label">Address</label>
        <textarea name="clinic_address" class="form-control" rows="2">{{ old('clinic_address', $profile->clinic_address) }}</textarea>
      </div>
    </div>
    <div class="row mb-3" id="clinic-address-details">
      <div class="col-md-3">
        <label class="form-label">Country</label>
        <input type="text" name="clinic_country" class="form-control" value="{{ old('clinic_country', $profile->clinic_country) }}">
      </div>
      <div class="col-md-3">
        <label class="form-label">State</label>
        <input type="text" name="clinic_state" class="form-control" value="{{ old('clinic_state', $profile->clinic_state) }}">
      </div>
      <div class="col-md-3">
        <label class="form-label">City</label>
        <input type="text" name="clinic_city" class="form-control" value="{{ old('clinic_city', $profile->clinic_city) }}">
      </div>
      <div class="col-md-3">
        <label class="form-label">District</label>
        <input type="text" name="clinic_district" class="form-control" value="{{ old('clinic_district', $profile->clinic_district) }}">
      </div>
    </div>
    <div class="row mb-3" id="clinic-zip-field">
      <div class="col-md-3">
        <label class="form-label">ZIP Code</label>
        <input type="text" name="clinic_zip" class="form-control" value="{{ old('clinic_zip', $profile->clinic_zip) }}">
      </div>
    </div>

    <div class="mt-4">
      <button type="submit" class="btn btn-primary">
        <i class="ri-save-line me-1"></i> Save Changes
      </button>
    </div>
  </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const checkbox = document.getElementById('same_as_present');
  const clinicFields = document.getElementById('clinic-address-fields');
  const clinicDetails = document.getElementById('clinic-address-details');
  const clinicZip = document.getElementById('clinic-zip-field');
  
  function toggleClinicFields() {
    if (checkbox.checked) {
      clinicFields.style.display = 'none';
      clinicDetails.style.display = 'none';
      clinicZip.style.display = 'none';
    } else {
      clinicFields.style.display = 'block';
      clinicDetails.style.display = 'flex';
      clinicZip.style.display = 'block';
    }
  }
  
  checkbox.addEventListener('change', toggleClinicFields);
  toggleClinicFields();
});
</script>
