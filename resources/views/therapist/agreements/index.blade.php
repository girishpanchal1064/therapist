@extends('layouts/contentNavbarLayout')

@section('title', 'Agreements')

@section('page-style')
<style>
  .page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 1.5rem 2rem;
    margin-bottom: 1.5rem;
    color: white;
  }
  .page-header h4 {
    font-weight: 700;
    color: white;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }
  .table-modern {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
  }
  .table-modern thead th {
    background: linear-gradient(135deg, #f8f9fc 0%, #eef1f6 100%);
    color: #4a5568;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.05em;
    padding: 1rem 1.25rem;
    border: none;
  }
  .table-modern tbody td {
    padding: 1rem 1.25rem;
    vertical-align: middle;
    border-top: 1px solid #f1f5f9;
  }
  .table-modern tbody tr:hover {
    background: #f8f9fc;
    transform: scale(1.01);
    transition: all 0.2s ease;
  }
  .btn-action {
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.875rem;
    transition: all 0.3s ease;
    border: none;
  }
  .btn-view {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
  }
  .btn-edit {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
  }
  .btn-delete {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
  }
  .btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
  }
</style>
@endsection

@section('content')
<div class="page-header">
  <div class="d-flex justify-content-between align-items-center">
    <div>
      <h4>
        <i class="ri-file-paper-2-line"></i>
        Agreements
      </h4>
      <p class="mb-0">Manage your client agreements</p>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('therapist.agreements.index') }}" class="btn btn-light">
        <i class="ri-refresh-line me-1"></i>Refresh
      </a>
      <a href="{{ route('therapist.agreements.create') }}" class="btn btn-light" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none;">
        <i class="ri-add-line me-1"></i>Add Agreement
      </a>
    </div>
  </div>
</div>

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; border-left: 4px solid #059669;">
    <i class="ri-checkbox-circle-line me-2"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<!-- Search and Filters -->
<div class="card mb-4" style="border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
  <div class="card-body">
    <form method="GET" action="{{ route('therapist.agreements.index') }}" class="row g-3">
      <div class="col-md-4">
        <input type="text" name="search" class="form-control" placeholder="Search by title or content..." value="{{ $search }}" style="border-radius: 10px;">
      </div>
      <div class="col-md-3">
        <select name="type" class="form-select" style="border-radius: 10px;">
          <option value="">All Types</option>
          <option value="general" {{ $type == 'general' ? 'selected' : '' }}>General</option>
          <option value="client_specific" {{ $type == 'client_specific' ? 'selected' : '' }}>Client Specific</option>
        </select>
      </div>
      <div class="col-md-3">
        <select name="status" class="form-select" style="border-radius: 10px;">
          <option value="">All Status</option>
          <option value="draft" {{ $status == 'draft' ? 'selected' : '' }}>Draft</option>
          <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Active</option>
          <option value="signed" {{ $status == 'signed' ? 'selected' : '' }}>Signed</option>
          <option value="expired" {{ $status == 'expired' ? 'selected' : '' }}>Expired</option>
        </select>
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn w-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 10px;">
          <i class="ri-search-line me-1"></i>Search
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Agreements Table -->
<div class="table-modern">
  <table class="table table-hover mb-0">
    <thead>
      <tr>
        <th>Title</th>
        <th>Type</th>
        <th>Client</th>
        <th>Status</th>
        <th>Effective Date</th>
        <th>Expiry Date</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @forelse($agreements as $agreement)
        <tr>
          <td>
            <div class="fw-semibold">{{ Str::limit($agreement->title, 40) }}</div>
            <small class="text-muted">{{ Str::limit($agreement->content, 50) }}</small>
          </td>
          <td>
            <span class="badge {{ $agreement->type == 'general' ? 'bg-info' : 'bg-primary' }}">
              {{ ucfirst(str_replace('_', ' ', $agreement->type)) }}
            </span>
          </td>
          <td>
            @if($agreement->client)
              <div class="d-flex align-items-center">
                <div class="avatar avatar-sm me-2">
                  @if($agreement->client)
                    @if($agreement->client->profile && $agreement->client->profile->profile_image)
                      <img src="{{ asset('storage/' . $agreement->client->profile->profile_image) }}" alt="{{ $agreement->client->name }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                    @elseif($agreement->client->getRawOriginal('avatar'))
                      <img src="{{ asset('storage/' . $agreement->client->getRawOriginal('avatar')) }}" alt="{{ $agreement->client->name }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                    @else
                      <img src="https://ui-avatars.com/api/?name={{ urlencode($agreement->client->name) }}&background=3b82f6&color=fff&size=80&bold=true&format=svg" alt="{{ $agreement->client->name }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                    @endif
                  @else
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.75rem;">
                      G
                    </div>
                  @endif
                </div>
                <span>{{ $agreement->client->name }}</span>
              </div>
            @else
              <span class="text-muted">General</span>
            @endif
          </td>
          <td>
            @php
              $statusColors = [
                'draft' => 'bg-secondary',
                'active' => 'bg-success',
                'signed' => 'bg-primary',
                'expired' => 'bg-danger'
              ];
            @endphp
            <span class="badge {{ $statusColors[$agreement->status] ?? 'bg-secondary' }}">
              {{ ucfirst($agreement->status) }}
            </span>
          </td>
          <td>{{ $agreement->effective_date ? $agreement->effective_date->format('Y-m-d') : '-' }}</td>
          <td>{{ $agreement->expiry_date ? $agreement->expiry_date->format('Y-m-d') : '-' }}</td>
          <td>
            <div class="d-flex gap-1">
              <a href="{{ route('therapist.agreements.show', $agreement->id) }}" class="btn btn-action btn-view btn-sm">
                <i class="ri-eye-line"></i>
              </a>
              <a href="{{ route('therapist.agreements.edit', $agreement->id) }}" class="btn btn-action btn-edit btn-sm">
                <i class="ri-pencil-line"></i>
              </a>
              <form action="{{ route('therapist.agreements.destroy', $agreement->id) }}" method="POST" class="d-inline delete-form" data-title="Delete Agreement" data-text="Are you sure you want to delete this agreement? This action cannot be undone.">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-action btn-delete btn-sm">
                  <i class="ri-delete-bin-line"></i>
                </button>
              </form>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="7" class="text-center py-5">
            <i class="ri-file-paper-2-line" style="font-size: 3rem; color: #cbd5e0;"></i>
            <p class="mt-3 text-muted">No agreements found. <a href="{{ route('therapist.agreements.create') }}">Create your first agreement</a></p>
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

<!-- Pagination -->
@if($agreements->hasPages())
  <div class="d-flex justify-content-between align-items-center mt-4">
    <div class="text-muted">
      Showing {{ $agreements->firstItem() }} to {{ $agreements->lastItem() }} of {{ $agreements->total() }} entries
    </div>
    <div>
      {{ $agreements->links() }}
    </div>
  </div>
@endif
@endsection
