@extends('layouts/contentNavbarLayout')

@section('title', 'User Role Management')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">User Role Management</h5>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
          <i class="ri-arrow-left-line me-2"></i>Back to Users
        </a>
      </div>
      <div class="card-body">
        @if(session('success'))
          <div class="alert alert-success alert-dismissible" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if(session('error'))
          <div class="alert alert-danger alert-dismissible" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>User</th>
                <th>Email</th>
                <th>Current Roles</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($users as $user)
                <tr>
                  <td>
                    <div class="d-flex align-items-center">
                      <div class="avatar avatar-sm me-2">
                        <img src="{{ $user->avatar }}" alt="Avatar" class="rounded-circle">
                      </div>
                      <div>
                        <h6 class="mb-0">{{ $user->name }}</h6>
                        <small class="text-muted">{{ ucfirst($user->status) }}</small>
                      </div>
                    </div>
                  </td>
                  <td>{{ $user->email }}</td>
                  <td>
                    @foreach($user->roles as $role)
                      <span class="badge bg-primary me-1">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</span>
                    @endforeach
                    @if($user->roles->count() == 0)
                      <span class="text-muted">No roles assigned</span>
                    @endif
                  </td>
                  <td>
                    <button type="button" class="btn btn-sm btn-outline-primary"
                            data-bs-toggle="modal" data-bs-target="#roleModal{{ $user->id }}">
                      <i class="ri-user-settings-line me-1"></i>Manage Roles
                    </button>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="text-center">No users found.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="d-flex justify-content-center">
          {{ $users->links() }}
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Role Management Modals -->
@foreach($users as $user)
<div class="modal fade" id="roleModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Manage Roles for {{ $user->name }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.user-roles.sync', $user) }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Select Roles</label>
            <div class="row">
              @foreach($roles as $role)
                <div class="col-md-6 mb-2">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox"
                           name="roles[]" value="{{ $role->name }}"
                           id="role_{{ $user->id }}_{{ $role->id }}"
                           {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                    <label class="form-check-label" for="role_{{ $user->id }}_{{ $role->id }}">
                      {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                      @if(in_array($role->name, ['super_admin', 'admin', 'therapist', 'client']))
                        <small class="text-muted">(Core Role)</small>
                      @endif
                    </label>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Update Roles</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach
@endsection
