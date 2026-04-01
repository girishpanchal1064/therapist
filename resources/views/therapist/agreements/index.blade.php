@extends('layouts/contentNavbarLayout')

@section('title', 'Agreements')

@section('page-style')
<style>
  .layout-page .content-wrapper { background: linear-gradient(to bottom, #fff, rgba(186, 194, 210, 0.05)) !important; }

  .therapist-agreements-apni .agr-filters .agr-filter-input,
  .therapist-agreements-apni .agr-filters .agr-filter-select {
    padding: 0.75rem 1rem;
    border: 2px solid rgba(186, 194, 210, 0.85);
    border-radius: 10px;
    font-size: 0.9375rem;
    background: #f8fafc;
    transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
  }
  .therapist-agreements-apni .agr-filters .agr-filter-input:focus,
  .therapist-agreements-apni .agr-filters .agr-filter-select:focus {
    outline: none;
    border-color: #041c54;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(4, 28, 84, 0.12);
  }
  .therapist-agreements-apni .btn-agr-search {
    padding: 0.75rem 1.15rem;
    background: #041c54;
    color: #fff !important;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(4, 28, 84, 0.2);
  }
  .therapist-agreements-apni .btn-agr-search:hover {
    background: #052a66;
    color: #fff !important;
  }

  .therapist-agreements-apni .agr-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid rgba(186, 194, 210, 0.45);
  }
  .therapist-agreements-apni .agr-table thead th {
    background: rgba(186, 194, 210, 0.2);
    color: #4d5d78;
    font-weight: 700;
    font-size: 0.72rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    padding: 12px 10px;
    border: none;
    white-space: nowrap;
  }
  .therapist-agreements-apni .agr-table tbody td {
    padding: 12px 10px;
    border-bottom: 1px solid rgba(186, 194, 210, 0.35);
    vertical-align: middle;
    color: #334155;
    font-size: 0.85rem;
  }
  .therapist-agreements-apni .agr-table tbody tr:hover {
    background: rgba(4, 28, 84, 0.03);
  }
  .therapist-agreements-apni .agr-table tbody tr:last-child td {
    border-bottom: none;
  }

  .therapist-agreements-apni .client-cell {
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }
  .therapist-agreements-apni .client-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid rgba(186, 194, 210, 0.7);
  }
  .therapist-agreements-apni .client-name {
    font-weight: 600;
    color: #041c54;
    font-size: 0.875rem;
    font-family: var(--apni-font-display, 'Sora', system-ui, sans-serif);
  }

  .therapist-agreements-apni .agr-btn-view,
  .therapist-agreements-apni .agr-btn-edit,
  .therapist-agreements-apni .agr-btn-delete {
    border: none;
    padding: 0.45rem 0.65rem;
    border-radius: 8px;
    font-size: 0.85rem;
    color: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: opacity 0.2s ease, transform 0.2s ease;
  }
  .therapist-agreements-apni .agr-btn-view {
    background: #041c54;
  }
  .therapist-agreements-apni .agr-btn-view:hover {
    background: #052a66;
    color: #fff;
  }
  .therapist-agreements-apni .agr-btn-edit {
    background: #d97706;
  }
  .therapist-agreements-apni .agr-btn-edit:hover {
    background: #b45309;
    color: #fff;
  }
  .therapist-agreements-apni .agr-btn-delete {
    background: #dc2626;
  }
  .therapist-agreements-apni .agr-btn-delete:hover {
    background: #b91c1c;
    color: #fff;
  }

  .therapist-agreements-apni .pagination-wrap {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
    margin-top: 1.25rem;
    padding-top: 1.25rem;
    border-top: 1px solid rgba(186, 194, 210, 0.45);
  }
  .therapist-agreements-apni .pagination-wrap .pagination {
    margin-bottom: 0;
  }
  .therapist-agreements-apni .page-link {
    color: #041c54;
    border-color: rgba(186, 194, 210, 0.85);
    border-radius: 8px !important;
    margin: 0 2px;
  }
  .therapist-agreements-apni .page-item.active .page-link {
    background: #041c54;
    border-color: #041c54;
    color: #fff;
  }

  .therapist-agreements-apni .empty-state {
    text-align: center;
    padding: 2.5rem 1rem;
  }
  .therapist-agreements-apni .empty-state i {
    font-size: 3rem;
    color: #647494;
    margin-bottom: 0.75rem;
    display: block;
  }
  .therapist-agreements-apni .empty-state p {
    color: #7484a4;
    font-size: 0.9375rem;
    margin: 0;
  }
  .therapist-agreements-apni .empty-state a {
    color: #041c54;
    font-weight: 600;
    text-decoration: none;
  }
  .therapist-agreements-apni .empty-state a:hover {
    text-decoration: underline;
  }

  @media (max-width: 768px) {
    .therapist-agreements-apni .agr-table {
      display: block;
      overflow-x: auto;
    }
  }
</style>
@endsection

@section('content')
@php
  $agrTypeClass = function ($t) {
    return $t === 'general'
      ? 'inline-block rounded-full border border-sky-200/90 bg-sky-50 px-2.5 py-0.5 text-xs font-semibold text-sky-900'
      : 'inline-block rounded-full border border-[#041C54]/25 bg-[#041C54]/10 px-2.5 py-0.5 text-xs font-semibold text-[#041C54]';
  };
  $agrStatusClass = function ($s) {
    return match ($s) {
      'draft' => 'inline-block rounded-full border border-slate-200 bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-700',
      'active' => 'inline-block rounded-full border border-emerald-200/90 bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-900',
      'signed' => 'inline-block rounded-full border border-[#041C54]/30 bg-[#041C54]/12 px-2.5 py-0.5 text-xs font-semibold text-[#041C54]',
      'expired' => 'inline-block rounded-full border border-red-200/90 bg-red-50 px-2.5 py-0.5 text-xs font-semibold text-red-900',
      default => 'inline-block rounded-full border border-slate-200 bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-600',
    };
  };
@endphp

<div class="therapist-agreements-apni pb-2">
  <div class="relative mb-8 overflow-hidden rounded-3xl shadow-[0_20px_25px_-5px_rgba(100,116,148,0.2),0_8px_10px_-6px_rgba(100,116,148,0.2)]"
       style="background: linear-gradient(171deg, #647494 0%, #6d7f9d 25%, #7484A4 50%, #6d7f9d 75%, #647494 100%);">
    <div class="pointer-events-none absolute -right-20 top-0 h-64 w-64 rounded-full bg-white/10 blur-[64px]" aria-hidden="true"></div>
    <div class="relative z-10 flex flex-col gap-6 p-6 lg:flex-row lg:items-center lg:justify-between lg:p-8">
      <div class="min-w-0">
        <h1 class="font-display flex items-center gap-3 text-2xl font-medium leading-snug text-white md:text-3xl">
          <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-[14px] bg-white/15 text-[1.5rem] backdrop-blur-sm">
            <i class="ri-file-paper-2-line"></i>
          </span>
          Agreements
        </h1>
        <p class="mt-2 max-w-xl text-base text-white/90">
          Manage your client agreements and templates.
        </p>
      </div>
      <div class="flex shrink-0 flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center">
        <button type="button" class="order-2 inline-flex items-center justify-center gap-2 rounded-[14px] border-2 border-white px-5 py-2.5 text-sm font-medium text-white transition hover:bg-white/10 sm:order-1" onclick="location.reload()">
          <i class="ri-refresh-line text-lg"></i>
          Refresh
        </button>
        <a href="{{ route('therapist.dashboard') }}"
           class="order-3 inline-flex items-center justify-center gap-2 rounded-[14px] bg-white px-5 py-2.5 text-sm font-medium text-[#041C54] shadow-md transition hover:bg-[#BAC2D2]/30 sm:order-2">
          <i class="ri-dashboard-line text-lg"></i>
          Dashboard
        </a>
        <a href="{{ route('therapist.agreements.create') }}"
           class="order-1 inline-flex items-center justify-center gap-2 rounded-[14px] border-2 border-white px-5 py-2.5 text-sm font-medium text-white transition hover:bg-white/10 sm:order-3">
          <i class="ri-add-line text-lg"></i>
          Add agreement
        </a>
      </div>
    </div>
  </div>

  @if(session('success'))
    <div class="mb-6 flex items-start gap-3 rounded-2xl border border-[#10B981]/30 bg-[#ecfdf5] px-4 py-3 text-sm text-[#065f46] md:px-5" role="status">
      <i class="ri-checkbox-circle-fill mt-0.5 text-lg text-[#059669]"></i>
      <div class="min-w-0 flex-1">{{ session('success') }}</div>
    </div>
  @endif

  <div class="rounded-2xl border border-[#BAC2D2]/30 bg-white p-4 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)] sm:p-6">
    <form method="GET" action="{{ route('therapist.agreements.index') }}" class="agr-filters row g-3 align-items-end">
      <div class="col-md-4">
        <label class="form-label mb-1 d-block text-uppercase small fw-semibold text-[#7484A4]" style="letter-spacing: 0.03em; font-size: 0.72rem;">Search</label>
        <input type="text" name="search" class="form-control agr-filter-input w-100" placeholder="Title or content…" value="{{ $search }}">
      </div>
      <div class="col-md-3">
        <label class="form-label mb-1 d-block text-uppercase small fw-semibold text-[#7484A4]" style="letter-spacing: 0.03em; font-size: 0.72rem;">Type</label>
        <select name="type" class="form-select agr-filter-select w-100">
          <option value="">All types</option>
          <option value="general" {{ $type == 'general' ? 'selected' : '' }}>General</option>
          <option value="client_specific" {{ $type == 'client_specific' ? 'selected' : '' }}>Client specific</option>
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label mb-1 d-block text-uppercase small fw-semibold text-[#7484A4]" style="letter-spacing: 0.03em; font-size: 0.72rem;">Status</label>
        <select name="status" class="form-select agr-filter-select w-100">
          <option value="">All statuses</option>
          <option value="draft" {{ $status == 'draft' ? 'selected' : '' }}>Draft</option>
          <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Active</option>
          <option value="signed" {{ $status == 'signed' ? 'selected' : '' }}>Signed</option>
          <option value="expired" {{ $status == 'expired' ? 'selected' : '' }}>Expired</option>
        </select>
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn btn-agr-search w-100">
          <i class="ri-search-line me-1"></i>Search
        </button>
      </div>
    </form>

    <div class="mt-6 border-t border-[#BAC2D2]/30 pt-6">
      <h2 class="font-display mb-4 text-lg font-medium text-[#041C54]">All agreements</h2>
      <div class="table-responsive">
        <table class="agr-table">
          <thead>
            <tr>
              <th>Title</th>
              <th>Type</th>
              <th>Client</th>
              <th>Status</th>
              <th>Effective</th>
              <th>Expiry</th>
              <th style="width: 130px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($agreements as $agreement)
              <tr>
                <td>
                  <div class="fw-semibold text-[#041C54]">{{ Str::limit($agreement->title, 40) }}</div>
                  <small class="text-[#7484A4]">{{ Str::limit($agreement->content, 50) }}</small>
                </td>
                <td>
                  <span class="{{ $agrTypeClass($agreement->type) }}">
                    {{ ucfirst(str_replace('_', ' ', $agreement->type)) }}
                  </span>
                </td>
                <td>
                  @if($agreement->client)
                    <div class="client-cell">
                      @if($agreement->client->profile && $agreement->client->profile->profile_image)
                        <img src="{{ asset('storage/' . $agreement->client->profile->profile_image) }}" alt="{{ $agreement->client->name }}" class="client-avatar">
                      @elseif($agreement->client->getRawOriginal('avatar'))
                        <img src="{{ asset('storage/' . $agreement->client->getRawOriginal('avatar')) }}" alt="{{ $agreement->client->name }}" class="client-avatar">
                      @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($agreement->client->name) }}&background=647494&color=fff&size=80&bold=true&format=svg" alt="{{ $agreement->client->name }}" class="client-avatar">
                      @endif
                      <span class="client-name">{{ $agreement->client->name }}</span>
                    </div>
                  @else
                    <span class="text-[#7484A4]">General</span>
                  @endif
                </td>
                <td>
                  <span class="{{ $agrStatusClass($agreement->status) }}">
                    {{ ucfirst($agreement->status) }}
                  </span>
                </td>
                <td class="text-[#647494]">{{ $agreement->effective_date ? $agreement->effective_date->format('Y-m-d') : '—' }}</td>
                <td class="text-[#647494]">{{ $agreement->expiry_date ? $agreement->expiry_date->format('Y-m-d') : '—' }}</td>
                <td>
                  <div class="d-flex flex-wrap gap-1">
                    <a href="{{ route('therapist.agreements.show', $agreement->id) }}" class="agr-btn-view" title="View"><i class="ri-eye-line"></i></a>
                    <a href="{{ route('therapist.agreements.edit', $agreement->id) }}" class="agr-btn-edit" title="Edit"><i class="ri-pencil-line"></i></a>
                    <form action="{{ route('therapist.agreements.destroy', $agreement->id) }}" method="POST" class="d-inline delete-form" data-title="Delete Agreement" data-text="Are you sure you want to delete this agreement? This action cannot be undone.">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="agr-btn-delete" title="Delete"><i class="ri-delete-bin-line"></i></button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7">
                  <div class="empty-state">
                    <i class="ri-file-paper-2-line"></i>
                    <p>No agreements found. <a href="{{ route('therapist.agreements.create') }}">Create your first agreement</a></p>
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    @if($agreements->hasPages() || $agreements->total() > 0)
      <div class="pagination-wrap">
        <div class="text-sm text-[#7484A4]">
          @if($agreements->total() > 0)
            Showing {{ $agreements->firstItem() }}–{{ $agreements->lastItem() }} of {{ $agreements->total() }}
          @endif
        </div>
        <div>{{ $agreements->links() }}</div>
      </div>
    @endif
  </div>
</div>
@endsection
