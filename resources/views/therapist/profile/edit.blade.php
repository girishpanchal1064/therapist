@extends('layouts/contentNavbarLayout')

@section('title', 'Therapist Profile')

@section('content')
<div class="row">
  <div class="col-12">
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">My Profile</h5>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('therapist.profile.update') }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">First Name</label>
              <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $profile->first_name) }}">
              @error('first_name')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Last Name</label>
              <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $profile->last_name) }}">
              @error('last_name')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Date of Birth</label>
              <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth', $profile->date_of_birth) }}">
              @error('date_of_birth')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Profile Image</label>
              <input type="file" name="profile_image" class="form-control">
              @error('profile_image')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="col-12 mb-3">
              <label class="form-label">Bio</label>
              <textarea name="bio" class="form-control" rows="4">{{ old('bio', $profile->bio) }}</textarea>
              @error('bio')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
          </div>

          <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
