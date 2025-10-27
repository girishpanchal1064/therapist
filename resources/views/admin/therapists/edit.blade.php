@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Therapist')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Edit Therapist</h5>
      </div>
      <div class="card-body">
        @if($errors->any())
          <div class="alert alert-danger alert-dismissible" role="alert">
            <ul class="mb-0">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <form action="{{ route('admin.therapists.update', $therapist) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <!-- Basic Information -->
          <div class="card mb-4">
            <div class="card-header">
              <h6 class="mb-0">Basic Information</h6>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                           id="name" name="name" value="{{ old('name', $therapist->name) }}" required>
                    @error('name')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                           id="email" name="email" value="{{ old('email', $therapist->email) }}" required>
                    @error('email')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                           id="phone" name="phone" value="{{ old('phone', $therapist->phone) }}" required>
                    @error('phone')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                      <option value="">Select Status</option>
                      <option value="active" {{ old('status', $therapist->status) == 'active' ? 'selected' : '' }}>Active</option>
                      <option value="inactive" {{ old('status', $therapist->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                      <option value="suspended" {{ old('status', $therapist->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                    @error('status')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="avatar" class="form-label">Profile Picture</label>
                    <input type="file" class="form-control @error('avatar') is-invalid @enderror"
                           id="avatar" name="avatar" accept="image/*">
                    @error('avatar')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Upload a new profile picture (JPEG, PNG, JPG, GIF, SVG - Max 2MB)</div>
                  </div>
                </div>
                <div class="col-md-6">
                  @if($therapist->avatar)
                    <div class="mb-3">
                      <label class="form-label">Current Avatar</label>
                      <div>
                        <img src="{{ asset('storage/' . $therapist->avatar) }}" alt="Current Avatar" class="rounded" width="100" height="100">
                      </div>
                    </div>
                  @endif
                </div>
              </div>
            </div>
          </div>

          <!-- Therapist Profile Information -->
          <div class="card mb-4">
            <div class="card-header">
              <h6 class="mb-0">Therapist Profile</h6>
            </div>
            <div class="card-body">
              @if($therapist->therapistProfile)
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                      <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                             id="first_name" name="first_name" value="{{ old('first_name', $therapist->therapistProfile->first_name) }}" required>
                      @error('first_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                      <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                             id="last_name" name="last_name" value="{{ old('last_name', $therapist->therapistProfile->last_name) }}" required>
                      @error('last_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="experience_years" class="form-label">Experience (Years) <span class="text-danger">*</span></label>
                      <input type="number" class="form-control @error('experience_years') is-invalid @enderror"
                             id="experience_years" name="experience_years" value="{{ old('experience_years', $therapist->therapistProfile->experience_years) }}" min="0" required>
                      @error('experience_years')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="hourly_rate" class="form-label">Hourly Rate ($) <span class="text-danger">*</span></label>
                      <input type="number" class="form-control @error('hourly_rate') is-invalid @enderror"
                             id="hourly_rate" name="hourly_rate" value="{{ old('hourly_rate', $therapist->therapistProfile->hourly_rate) }}" min="0" step="0.01" required>
                      @error('hourly_rate')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>

                <div class="mb-3">
                  <label for="bio" class="form-label">Bio <span class="text-danger">*</span></label>
                  <textarea class="form-control @error('bio') is-invalid @enderror"
                            id="bio" name="bio" rows="4" required>{{ old('bio', $therapist->therapistProfile->bio) }}</textarea>
                  @error('bio')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="certifications" class="form-label">Certifications</label>
                      <textarea class="form-control @error('certifications') is-invalid @enderror"
                                id="certifications" name="certifications" rows="3">{{ old('certifications', $therapist->therapistProfile->certifications) }}</textarea>
                      @error('certifications')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="education" class="form-label">Education</label>
                      <textarea class="form-control @error('education') is-invalid @enderror"
                                id="education" name="education" rows="3">{{ old('education', $therapist->therapistProfile->education) }}</textarea>
                      @error('education')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>

                <div class="mb-3">
                  <label for="specializations" class="form-label">Specializations <span class="text-danger">*</span></label>
                  <select class="form-select @error('specializations') is-invalid @enderror"
                          id="specializations" name="specializations[]" multiple required>
                    @foreach($specializations as $specialization)
                      <option value="{{ $specialization->id }}"
                              {{ in_array($specialization->id, old('specializations', $therapist->therapistProfile->specializations->pluck('id')->toArray())) ? 'selected' : '' }}>
                        {{ $specialization->name }}
                      </option>
                    @endforeach
                  </select>
                  @error('specializations')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                  <div class="form-text">Hold Ctrl/Cmd to select multiple specializations</div>
                </div>
              @else
                <div class="alert alert-warning">
                  <i class="ri-alert-line me-2"></i>
                  No therapist profile found. Please create a therapist profile first.
                </div>
              @endif
            </div>
          </div>

          <div class="d-flex justify-content-end">
            <a href="{{ route('admin.therapists.index') }}" class="btn btn-secondary me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Therapist</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
