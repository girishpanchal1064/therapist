@extends('layouts/contentNavbarLayout')

@section('title', 'Create Role')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Create New Role</h5>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">
          <i class="ri-arrow-left-line me-2"></i>Back to Roles
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

        <form action="{{ route('admin.roles.store') }}" method="POST">
          @csrf

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="name" class="form-label">Role Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror"
                       id="name" name="name" value="{{ old('name') }}"
                       placeholder="e.g., content_manager" required>
                <div class="form-text">Use lowercase with underscores (e.g., content_manager)</div>
                @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label">Permissions</label>
            <div class="row">
              @foreach($permissions as $group => $groupPermissions)
                <div class="col-md-6 col-lg-4 mb-3">
                  <div class="card">
                    <div class="card-header">
                      <h6 class="card-title mb-0">{{ ucfirst($group) }}</h6>
                    </div>
                    <div class="card-body">
                      @foreach($groupPermissions as $permission)
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox"
                                 name="permissions[]" value="{{ $permission->name }}"
                                 id="permission_{{ $permission->id }}"
                                 {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}>
                          <label class="form-check-label" for="permission_{{ $permission->id }}">
                            {{ ucfirst(str_replace('_', ' ', $permission->name)) }}
                          </label>
                        </div>
                      @endforeach
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>

          <div class="d-flex justify-content-end">
            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">
              <i class="ri-save-line me-2"></i>Create Role
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
