@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Agreement')

@section('page-style')
<style>
  .layout-page .content-wrapper { background: linear-gradient(to bottom, #fff, rgba(186, 194, 210, 0.05)) !important; }

  .therapist-agreements-apni .agr-form-label {
    font-weight: 600;
    font-size: 0.8125rem;
    color: #647494;
    margin-bottom: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 0.03em;
  }
  .therapist-agreements-apni .form-control,
  .therapist-agreements-apni .form-select {
    border-radius: 10px;
    border: 2px solid rgba(186, 194, 210, 0.85);
    padding: 0.75rem 1rem;
    background: #f8fafc;
    font-size: 0.9375rem;
    transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
  }
  .therapist-agreements-apni .form-control:focus,
  .therapist-agreements-apni .form-select:focus {
    border-color: #041c54;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(4, 28, 84, 0.12);
    outline: none;
  }
  .therapist-agreements-apni .form-check-input:focus {
    box-shadow: 0 0 0 3px rgba(4, 28, 84, 0.15);
    border-color: #041c54;
  }
  .therapist-agreements-apni .form-check-input:checked {
    background-color: #041c54;
    border-color: #041c54;
  }
  .therapist-agreements-apni .btn-agr-submit {
    background: #041c54;
    border: none;
    color: #fff !important;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(4, 28, 84, 0.2);
    transition: transform 0.15s ease, box-shadow 0.15s ease;
  }
  .therapist-agreements-apni .btn-agr-submit:hover {
    background: #052a6b;
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(4, 28, 84, 0.25);
  }
  .therapist-agreements-apni .btn-agr-cancel {
    background: #f8fafc;
    border: 2px solid rgba(186, 194, 210, 0.85);
    color: #7484a4 !important;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
  }
  .therapist-agreements-apni .btn-agr-cancel:hover {
    background: #eef2f6;
    color: #041c54 !important;
    border-color: rgba(4, 28, 84, 0.25);
  }
</style>
@endsection

@section('content')
<div class="therapist-agreements-apni pb-2">
  <div class="relative mb-8 overflow-hidden rounded-3xl shadow-[0_20px_25px_-5px_rgba(100,116,148,0.2),0_8px_10px_-6px_rgba(100,116,148,0.2)]"
       style="background: linear-gradient(171deg, #647494 0%, #6d7f9d 25%, #7484A4 50%, #6d7f9d 75%, #647494 100%);">
    <div class="pointer-events-none absolute -right-20 top-0 h-64 w-64 rounded-full bg-white/10 blur-[64px]" aria-hidden="true"></div>
    <div class="relative z-10 flex flex-col gap-6 p-6 lg:flex-row lg:items-center lg:justify-between lg:p-8">
      <div class="min-w-0">
        <h1 class="font-display flex items-center gap-3 text-2xl font-medium leading-snug text-white md:text-3xl">
          <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-[14px] bg-white/15 text-[1.5rem] backdrop-blur-sm">
            <i class="ri-file-edit-line"></i>
          </span>
          Edit Agreement
        </h1>
        <p class="mt-2 max-w-xl text-base text-white/90">
          Update agreement details and status.
        </p>
      </div>
      <div class="flex shrink-0 flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center">
        <a href="{{ route('therapist.agreements.show', $agreement->id) }}"
           class="inline-flex items-center justify-center gap-2 rounded-[14px] border-2 border-white px-5 py-2.5 text-sm font-medium text-white transition hover:bg-white/10">
          <i class="ri-eye-line text-lg"></i>
          View
        </a>
        <a href="{{ route('therapist.agreements.index') }}"
           class="inline-flex items-center justify-center gap-2 rounded-[14px] bg-white px-5 py-2.5 text-sm font-medium text-[#041C54] shadow-md transition hover:bg-[#BAC2D2]/30">
          <i class="ri-arrow-left-line text-lg"></i>
          Back to agreements
        </a>
      </div>
    </div>
  </div>

  <div class="rounded-2xl border border-[#BAC2D2]/30 bg-white p-4 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)] sm:p-6">
    <form action="{{ route('therapist.agreements.update', $agreement->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="mb-4">
        <label for="type" class="form-label agr-form-label">Agreement type <span class="text-danger">*</span></label>
        <select name="type" id="type" class="form-select" required>
          <option value="general" {{ $agreement->type == 'general' ? 'selected' : '' }}>General</option>
          <option value="client_specific" {{ $agreement->type == 'client_specific' ? 'selected' : '' }}>Client specific</option>
        </select>
      </div>

      <div class="mb-4" id="client_select_wrapper" style="display: {{ $agreement->type == 'client_specific' ? 'block' : 'none' }};">
        <label for="client_id" class="form-label agr-form-label">Client <span class="text-danger">*</span></label>
        <select name="client_id" id="client_id" class="form-select" {{ $agreement->type == 'client_specific' ? 'required' : '' }}>
          <option value="">Select client</option>
          @foreach($clients as $client)
            <option value="{{ $client->id }}" {{ $agreement->client_id == $client->id ? 'selected' : '' }}>
              {{ $client->name }} ({{ $client->email }})
            </option>
          @endforeach
        </select>
      </div>

      <div class="mb-4">
        <label for="title" class="form-label agr-form-label">Title <span class="text-danger">*</span></label>
        <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $agreement->title) }}" required>
      </div>

      <div class="mb-4">
        <label for="content" class="form-label agr-form-label">Content <span class="text-danger">*</span></label>
        <textarea name="content" id="content" class="form-control" rows="10" required>{{ old('content', $agreement->content) }}</textarea>
      </div>

      <div class="mb-4">
        <label for="status" class="form-label agr-form-label">Status <span class="text-danger">*</span></label>
        <select name="status" id="status" class="form-select" required>
          <option value="draft" {{ $agreement->status == 'draft' ? 'selected' : '' }}>Draft</option>
          <option value="active" {{ $agreement->status == 'active' ? 'selected' : '' }}>Active</option>
          <option value="signed" {{ $agreement->status == 'signed' ? 'selected' : '' }}>Signed</option>
          <option value="expired" {{ $agreement->status == 'expired' ? 'selected' : '' }}>Expired</option>
        </select>
      </div>

      <div class="row mb-4">
        <div class="col-md-6 mb-3 mb-md-0">
          <label for="effective_date" class="form-label agr-form-label">Effective date</label>
          <input type="date" name="effective_date" id="effective_date" class="form-control" value="{{ old('effective_date', $agreement->effective_date ? $agreement->effective_date->format('Y-m-d') : '') }}">
        </div>
        <div class="col-md-6">
          <label for="expiry_date" class="form-label agr-form-label">Expiry date</label>
          <input type="date" name="expiry_date" id="expiry_date" class="form-control" value="{{ old('expiry_date', $agreement->expiry_date ? $agreement->expiry_date->format('Y-m-d') : '') }}">
        </div>
      </div>

      <div class="d-flex justify-content-end flex-wrap gap-2 mt-4 pt-2 border-top border-[#BAC2D2]/30">
        <a href="{{ route('therapist.agreements.index') }}" class="btn btn-agr-cancel">
          <i class="ri-close-line me-1"></i>Cancel
        </a>
        <button type="submit" class="btn btn-agr-submit">
          <i class="ri-save-line me-1"></i>Update agreement
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
});
</script>
@endsection
