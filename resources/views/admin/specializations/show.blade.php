@extends('layouts/contentNavbarLayout')

@section('title', 'View Specialization')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Specialization Details</h5>
        <div>
          <a href="{{ route('admin.specializations.edit', $specialization) }}" class="btn btn-primary btn-sm">
            <i class="ri-pencil-line me-1"></i> Edit
          </a>
          <a href="{{ route('admin.specializations.index') }}" class="btn btn-secondary btn-sm">
            <i class="ri-arrow-left-line me-1"></i> Back
          </a>
        </div>
      </div>
      <div class="card-body">
        <dl class="row">
          <dt class="col-sm-3">Name:</dt>
          <dd class="col-sm-9">{{ $specialization->name }}</dd>

          <dt class="col-sm-3">Slug:</dt>
          <dd class="col-sm-9"><code>{{ $specialization->slug }}</code></dd>

          <dt class="col-sm-3">Description:</dt>
          <dd class="col-sm-9">{{ $specialization->description ?: 'N/A' }}</dd>

          <dt class="col-sm-3">Icon:</dt>
          <dd class="col-sm-9">{{ $specialization->icon ?: 'N/A' }}</dd>

          <dt class="col-sm-3">Sort Order:</dt>
          <dd class="col-sm-9">{{ $specialization->sort_order }}</dd>

          <dt class="col-sm-3">Status:</dt>
          <dd class="col-sm-9">
            <span class="badge bg-{{ $specialization->is_active ? 'success' : 'secondary' }}">
              {{ $specialization->is_active ? 'Active' : 'Inactive' }}
            </span>
          </dd>

          <dt class="col-sm-3">Created At:</dt>
          <dd class="col-sm-9">{{ $specialization->created_at->format('M d, Y h:i A') }}</dd>

          <dt class="col-sm-3">Updated At:</dt>
          <dd class="col-sm-9">{{ $specialization->updated_at->format('M d, Y h:i A') }}</dd>
        </dl>
      </div>
    </div>
  </div>
</div>
@endsection
