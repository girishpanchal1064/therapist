@extends('layouts/contentNavbarLayout')

@section('title', 'Permission Details')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Permission Details: {{ ucfirst(str_replace('_', ' ', $permission->name)) }}</h5>
        <div>
          <a href="{{ route('admin.permissions.edit', $permission) }}" class="btn btn-primary me-2">
            <i class="ri-pencil-line me-2"></i>Edit Permission
          </a>
          <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline-secondary">
            <i class="ri-arrow-left-line me-2"></i>Back to Permissions
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <div class="mb-4">
              <h6 class="text-muted mb-2">Permission Information</h6>
              <table class="table table-borderless">
                <tr>
                  <td><strong>ID:</strong></td>
                  <td>{{ $permission->id }}</td>
                </tr>
                <tr>
                  <td><strong>Name:</strong></td>
                  <td>{{ ucfirst(str_replace('_', ' ', $permission->name)) }}</td>
                </tr>
                <tr>
                  <td><strong>Raw Name:</strong></td>
                  <td><code>{{ $permission->name }}</code></td>
                </tr>
                <tr>
                  <td><strong>Created:</strong></td>
                  <td>{{ $permission->created_at->format('M d, Y H:i') }}</td>
                </tr>
                <tr>
                  <td><strong>Updated:</strong></td>
                  <td>{{ $permission->updated_at->format('M d, Y H:i') }}</td>
                </tr>
                <tr>
                  <td><strong>Roles Count:</strong></td>
                  <td><span class="badge bg-primary">{{ $permission->roles->count() }}</span></td>
                </tr>
              </table>
            </div>
          </div>

          <div class="col-md-6">
            <div class="mb-4">
              <h6 class="text-muted mb-2">Description</h6>
              @if($permission->description)
                <p>{{ $permission->description }}</p>
              @else
                <p class="text-muted">No description provided.</p>
              @endif
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <h6 class="text-muted mb-3">Roles with this Permission ({{ $permission->roles->count() }})</h6>
            @if($permission->roles->count() > 0)
              <div class="row">
                @foreach($permission->roles as $role)
                  <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex align-items-center">
                          <div class="avatar avatar-sm me-2">
                            <span class="avatar-initial rounded bg-primary">{{ strtoupper(substr($role->name, 0, 2)) }}</span>
                          </div>
                          <div>
                            <h6 class="mb-0">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</h6>
                            <small class="text-muted">{{ $role->users->count() }} users</small>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            @else
              <div class="alert alert-info">
                <i class="ri-information-line me-2"></i>
                This permission is not assigned to any roles.
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
