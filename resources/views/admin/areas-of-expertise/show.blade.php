@extends('layouts/contentNavbarLayout')

@section('title', 'View Area of Expertise')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Area of Expertise Details</h5>
        <div>
          <a href="{{ route('admin.areas-of-expertise.edit', $areasOfExpertise) }}" class="btn btn-primary btn-sm">
            <i class="ri-pencil-line me-1"></i> Edit
          </a>
          <a href="{{ route('admin.areas-of-expertise.index') }}" class="btn btn-secondary btn-sm">
            <i class="ri-arrow-left-line me-1"></i> Back
          </a>
        </div>
      </div>
      <div class="card-body">
        <dl class="row">
          <dt class="col-sm-3">Name:</dt>
          <dd class="col-sm-9">{{ $areasOfExpertise->name }}</dd>

          <dt class="col-sm-3">Slug:</dt>
          <dd class="col-sm-9"><code>{{ $areasOfExpertise->slug }}</code></dd>

          <dt class="col-sm-3">Description:</dt>
          <dd class="col-sm-9">{{ $areasOfExpertise->description ?: 'N/A' }}</dd>

          <dt class="col-sm-3">Icon:</dt>
          <dd class="col-sm-9">{{ $areasOfExpertise->icon ?: 'N/A' }}</dd>

          <dt class="col-sm-3">Sort Order:</dt>
          <dd class="col-sm-9">{{ $areasOfExpertise->sort_order }}</dd>

          <dt class="col-sm-3">Status:</dt>
          <dd class="col-sm-9">
            <span class="badge bg-{{ $areasOfExpertise->is_active ? 'success' : 'secondary' }}">
              {{ $areasOfExpertise->is_active ? 'Active' : 'Inactive' }}
            </span>
          </dd>

          <dt class="col-sm-3">Created At:</dt>
          <dd class="col-sm-9">{{ $areasOfExpertise->created_at->format('M d, Y h:i A') }}</dd>

          <dt class="col-sm-3">Updated At:</dt>
          <dd class="col-sm-9">{{ $areasOfExpertise->updated_at->format('M d, Y h:i A') }}</dd>
        </dl>
      </div>
    </div>
  </div>
</div>
@endsection
