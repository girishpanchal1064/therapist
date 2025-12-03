@extends('layouts/contentNavbarLayout')

@section('title', 'Create Agreement')

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
  }
  .form-card {
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    border: none;
  }
  .form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
  }
  .form-control, .form-select {
    border-radius: 10px;
    border: 1px solid #e4e6eb;
    padding: 0.75rem 1rem;
  }
  .form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
  }
  .btn-submit {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    padding: 0.75rem 2rem;
    border-radius: 10px;
    font-weight: 600;
  }
  .btn-cancel {
    background: #f3f4f6;
    border: none;
    color: #6b7280;
    padding: 0.75rem 2rem;
    border-radius: 10px;
    font-weight: 600;
  }
</style>
@endsection

@section('content')
<div class="page-header">
  <div class="d-flex justify-content-between align-items-center">
    <div>
      <h4>
        <i class="ri-file-add-line"></i>
        Create Agreement
      </h4>
      <p class="mb-0">Create a new agreement for your client</p>
    </div>
    <a href="{{ route('therapist.agreements.index') }}" class="btn btn-light">
      <i class="ri-arrow-left-line me-1"></i>Back
    </a>
  </div>
</div>

<div class="card form-card">
  <div class="card-body p-4">
    <form action="{{ route('therapist.agreements.store') }}" method="POST">
      @csrf

      <div class="mb-4">
        <label for="type" class="form-label">Agreement Type <span class="text-danger">*</span></label>
        <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
          <option value="">Select Type</option>
          <option value="general" {{ old('type') == 'general' ? 'selected' : '' }}>General</option>
          <option value="client_specific" {{ old('type') == 'client_specific' ? 'selected' : '' }}>Client Specific</option>
        </select>
        @error('type')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-4" id="client_select_wrapper" style="display: none;">
        <label for="client_id" class="form-label">Client <span class="text-danger">*</span></label>
        <select name="client_id" id="client_id" class="form-select @error('client_id') is-invalid @enderror">
          <option value="">Select Client</option>
          @foreach($clients as $client)
            <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
              {{ $client->name }} ({{ $client->email }})
            </option>
          @endforeach
        </select>
        @error('client_id')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-4">
        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
        @error('title')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-4">
        <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
        <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" rows="10" required>{{ old('content') }}</textarea>
        @error('content')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-4">
        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
          <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
          <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
          <option value="signed" {{ old('status') == 'signed' ? 'selected' : '' }}>Signed</option>
          <option value="expired" {{ old('status') == 'expired' ? 'selected' : '' }}>Expired</option>
        </select>
        @error('status')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="row mb-4">
        <div class="col-md-6">
          <label for="effective_date" class="form-label">Effective Date</label>
          <input type="date" name="effective_date" id="effective_date" class="form-control @error('effective_date') is-invalid @enderror" value="{{ old('effective_date') }}">
          @error('effective_date')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="col-md-6">
          <label for="expiry_date" class="form-label">Expiry Date</label>
          <input type="date" name="expiry_date" id="expiry_date" class="form-control @error('expiry_date') is-invalid @enderror" value="{{ old('expiry_date') }}">
          @error('expiry_date')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('therapist.agreements.index') }}" class="btn btn-cancel">
          <i class="ri-close-line me-1"></i>Cancel
        </a>
        <button type="submit" class="btn btn-submit">
          <i class="ri-save-line me-1"></i>Create Agreement
        </button>
      </div>
    </form>
  </div>
</div>
@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const typeSelect = document.getElementById('type');
  const clientSelectWrapper = document.getElementById('client_select_wrapper');
  const clientSelect = document.getElementById('client_id');

  typeSelect.addEventListener('change', function() {
    if (this.value === 'client_specific') {
      clientSelectWrapper.style.display = 'block';
      clientSelect.setAttribute('required', 'required');
    } else {
      clientSelectWrapper.style.display = 'none';
      clientSelect.removeAttribute('required');
      clientSelect.value = '';
    }
  });

  // Initialize on page load
  if (typeSelect.value === 'client_specific') {
    clientSelectWrapper.style.display = 'block';
    clientSelect.setAttribute('required', 'required');
  }
});
</script>
@endsection
