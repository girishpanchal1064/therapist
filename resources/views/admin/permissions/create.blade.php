@extends('layouts/contentNavbarLayout')

@section('title', 'Create Permission')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Create New Permission</h5>
        <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline-secondary">
          <i class="ri-arrow-left-line me-2"></i>Back to Permissions
        </a>
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

        <form action="{{ route('admin.permissions.store') }}" method="POST">
          @csrf

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="name" class="form-label">Permission Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror"
                       id="name" name="name" value="{{ old('name') }}"
                       placeholder="e.g., manage blog posts" required>
                <div class="form-text">Use lowercase with underscores (e.g., manage_blog_posts)</div>
                @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-8">
              <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror"
                          id="description" name="description" rows="3"
                          placeholder="Describe what this permission allows users to do...">{{ old('description') }}</textarea>
                @error('description')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="alert alert-info">
            <h6 class="alert-heading">Permission Naming Convention</h6>
            <p class="mb-0">Use descriptive names that clearly indicate the action and resource:</p>
            <ul class="mb-0 mt-2">
              <li><code>view_users</code> - View user information</li>
              <li><code>create_users</code> - Create new users</li>
              <li><code>edit_users</code> - Edit existing users</li>
              <li><code>delete_users</code> - Delete users</li>
              <li><code>manage_settings</code> - Manage system settings</li>
            </ul>
          </div>

          <div class="d-flex justify-content-end">
            <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline-secondary me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">
              <i class="ri-save-line me-2"></i>Create Permission
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
