@extends('layouts/contentNavbarLayout')

@section('title', 'Role Details')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Role Details: {{ ucfirst(str_replace('_', ' ', $role->name)) }}</h5>
        <div>
          <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-primary me-2">
            <i class="ri-pencil-line me-2"></i>Edit Role
          </a>
          <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">
            <i class="ri-arrow-left-line me-2"></i>Back to Roles
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <div class="mb-4">
              <h6 class="text-muted mb-2">Role Information</h6>
              <table class="table table-borderless">
                <tr>
                  <td><strong>ID:</strong></td>
                  <td>{{ $role->id }}</td>
                </tr>
                <tr>
                  <td><strong>Name:</strong></td>
                  <td>{{ ucfirst(str_replace('_', ' ', $role->name)) }}</td>
                </tr>
                <tr>
                  <td><strong>Created:</strong></td>
                  <td>{{ $role->created_at->format('M d, Y H:i') }}</td>
                </tr>
                <tr>
                  <td><strong>Updated:</strong></td>
                  <td>{{ $role->updated_at->format('M d, Y H:i') }}</td>
                </tr>
                <tr>
                  <td><strong>Users Count:</strong></td>
                  <td><span class="badge bg-primary">{{ $role->users->count() }}</span></td>
                </tr>
              </table>
            </div>
          </div>

          <div class="col-md-6">
            <div class="mb-4">
              <h6 class="text-muted mb-2">Role Type</h6>
              @if(in_array($role->name, ['super_admin', 'admin', 'therapist', 'client']))
                <span class="badge bg-warning">Core System Role</span>
                <p class="text-muted mt-2">This is a core system role that cannot be deleted.</p>
              @else
                <span class="badge bg-info">Custom Role</span>
                <p class="text-muted mt-2">This is a custom role that can be modified or deleted.</p>
              @endif
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <h6 class="text-muted mb-3">Assigned Permissions ({{ $role->permissions->count() }})</h6>
            @if($role->permissions->count() > 0)
              <div class="row">
                @foreach($role->permissions->groupBy(function($permission) {
                    return explode(' ', $permission->name)[0];
                }) as $group => $permissions)
                  <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card">
                      <div class="card-header">
                        <h6 class="card-title mb-0">{{ ucfirst($group) }}</h6>
                      </div>
                      <div class="card-body">
                        @foreach($permissions as $permission)
                          <div class="d-flex align-items-center mb-2">
                            <i class="ri-check-line text-success me-2"></i>
                            <span>{{ ucfirst(str_replace('_', ' ', $permission->name)) }}</span>
                          </div>
                        @endforeach
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            @else
              <div class="alert alert-info">
                <i class="ri-information-line me-2"></i>
                This role has no permissions assigned.
              </div>
            @endif
          </div>
        </div>

        @if($role->users->count() > 0)
          <div class="row mt-4">
            <div class="col-12">
              <h6 class="text-muted mb-3">Users with this Role ({{ $role->users->count() }})</h6>
              <div class="table-responsive">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Status</th>
                      <th>Joined</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($role->users->take(10) as $user)
                      <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                          <span class="badge bg-{{ $user->status === 'active' ? 'success' : ($user->status === 'suspended' ? 'danger' : 'secondary') }}">
                            {{ ucfirst($user->status) }}
                          </span>
                        </td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
                @if($role->users->count() > 10)
                  <p class="text-muted text-center">And {{ $role->users->count() - 10 }} more users...</p>
                @endif
              </div>
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
