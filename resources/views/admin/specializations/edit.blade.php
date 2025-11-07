@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Specialization')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Edit Specialization</h5>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.specializations.update', $specialization) }}" method="POST">
          @csrf
          @method('PUT')

          <div class="mb-3">
            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                   id="name" name="name" value="{{ old('name', $specialization->name) }}" required>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" 
                      id="description" name="description" rows="3">{{ old('description', $specialization->description) }}</textarea>
            @error('description')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="icon" class="form-label">Icon</label>
            <input type="text" class="form-control @error('icon') is-invalid @enderror" 
                   id="icon" name="icon" value="{{ old('icon', $specialization->icon) }}" 
                   placeholder="e.g., ri-heart-line">
            @error('icon')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Enter icon class name (e.g., RemixIcon class)</div>
          </div>

          <div class="mb-3">
            <label for="sort_order" class="form-label">Sort Order</label>
            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                   id="sort_order" name="sort_order" value="{{ old('sort_order', $specialization->sort_order) }}" min="0">
            @error('sort_order')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                     value="1" {{ old('is_active', $specialization->is_active) ? 'checked' : '' }}>
              <label class="form-check-label" for="is_active">
                Active
              </label>
            </div>
          </div>

          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.specializations.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Specialization</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
