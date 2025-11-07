@extends('layouts/contentNavbarLayout')

@section('title', 'Account Summary')

@section('content')
<div class="row">
  <div class="col-12 mb-4">
    @if(session('success'))
      <div class="alert alert-success alert-dismissible" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <div class="card">
      <div class="card-body">
        <!-- Page Title -->
        <h4 class="mb-4 fw-bold">Account Summary</h4>

        <!-- Filters and Search -->
        <div class="d-flex flex-wrap gap-2 mb-4 align-items-end">
          <div>
            <label class="form-label small">Therapist</label>
            <form method="GET" action="{{ route('admin.account-summary.index') }}" class="d-flex gap-2" id="therapistForm">
              <select name="therapist_id" class="form-select" style="width: 200px;" onchange="this.form.submit()">
                <option value="">All Therapists</option>
                @foreach($therapists as $therapist)
                  <option value="{{ $therapist->id }}" {{ $therapistId == $therapist->id ? 'selected' : '' }}>
                    {{ $therapist->name }}
                  </option>
                @endforeach
              </select>
              <input type="hidden" name="start_date" value="{{ $startDate }}">
              <input type="hidden" name="end_date" value="{{ $endDate }}">
              <input type="hidden" name="search" value="{{ $search }}">
              <input type="hidden" name="per_page" value="{{ $perPage }}">
            </form>
          </div>

          <div>
            <label class="form-label small">Date Range</label>
            <form method="GET" action="{{ route('admin.account-summary.index') }}" class="d-flex gap-2" id="dateRangeForm">
              <input type="date" name="start_date" class="form-control" value="{{ $startDate }}" style="width: 150px;">
              <input type="date" name="end_date" class="form-control" value="{{ $endDate }}" style="width: 150px;">
              <input type="hidden" name="therapist_id" value="{{ $therapistId }}">
              <input type="hidden" name="search" value="{{ $search }}">
              <input type="hidden" name="per_page" value="{{ $perPage }}">
              <button type="submit" class="btn btn-outline-primary">
                <i class="ri-calendar-line me-1"></i> SELECT DATE RANGE
              </button>
            </form>
          </div>
          
          <div class="flex-grow-1">
            <form method="GET" action="{{ route('admin.account-summary.index') }}" class="d-flex gap-2">
              <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ $search }}">
              @if($therapistId)
                <input type="hidden" name="therapist_id" value="{{ $therapistId }}">
              @endif
              @if($startDate)
                <input type="hidden" name="start_date" value="{{ $startDate }}">
              @endif
              @if($endDate)
                <input type="hidden" name="end_date" value="{{ $endDate }}">
              @endif
              <input type="hidden" name="per_page" value="{{ $perPage }}">
              <button type="submit" class="btn btn-outline-primary">
                <i class="ri-search-line"></i>
              </button>
              @if($search)
                <a href="{{ route('admin.account-summary.index', ['therapist_id' => $therapistId, 'start_date' => $startDate, 'end_date' => $endDate, 'per_page' => $perPage]) }}" class="btn btn-outline-secondary">
                  <i class="ri-close-line"></i>
                </a>
              @endif
            </form>
          </div>

          <div>
            <button type="button" class="btn btn-outline-success" onclick="location.reload()">
              <i class="ri-refresh-line me-1"></i> REFRESH
            </button>
          </div>
        </div>

        <!-- Account Summary Table -->
        <div class="table-responsive">
          <table class="table table-bordered account-summary-table">
            <thead class="table-primary">
              <tr>
                <th>Sr. No.</th>
                <th>Session ID</th>
                <th>Therapist</th>
                <th>User</th>
                <th>Session Date</th>
                <th>Session Time</th>
                <th>Mode</th>
                <th>Description</th>
                <th>Transaction Date</th>
                <th>Due Amount</th>
                <th>Available Amount</th>
                <th>Disbursed Amount</th>
              </tr>
            </thead>
            <tbody>
              @forelse($summaries as $index => $summary)
                <tr>
                  <td>{{ $summaries->firstItem() + $index }}</td>
                  <td>#{{ str_pad($summary->id, 6, '0', STR_PAD_LEFT) }}</td>
                  <td>
                    <div class="d-flex align-items-center">
                      @if($summary->therapist->avatar)
                        <img src="{{ asset('storage/' . $summary->therapist->avatar) }}" 
                             alt="{{ $summary->therapist->name }}" 
                             class="rounded-circle me-2" 
                             width="32" 
                             height="32">
                      @else
                        <div class="avatar-initial rounded-circle bg-label-primary me-2 d-flex align-items-center justify-content-center" 
                             style="width: 32px; height: 32px;">
                          {{ strtoupper(substr($summary->therapist->name, 0, 2)) }}
                        </div>
                      @endif
                      <div>
                        <div class="fw-bold">{{ $summary->therapist->name }}</div>
                        <small class="text-muted">{{ $summary->therapist->email }}</small>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      @if($summary->client->avatar)
                        <img src="{{ asset('storage/' . $summary->client->avatar) }}" 
                             alt="{{ $summary->client->name }}" 
                             class="rounded-circle me-2" 
                             width="32" 
                             height="32">
                      @else
                        <div class="avatar-initial rounded-circle bg-label-success me-2 d-flex align-items-center justify-content-center" 
                             style="width: 32px; height: 32px;">
                          {{ strtoupper(substr($summary->client->name, 0, 2)) }}
                        </div>
                      @endif
                      <div>
                        <div class="fw-bold">{{ $summary->client->name }}</div>
                        <small class="text-muted">{{ $summary->client->email }}</small>
                      </div>
                    </div>
                  </td>
                  <td>{{ $summary->appointment_date->format('d-m-Y') }}</td>
                  <td>{{ date('h:i A', strtotime($summary->appointment_time)) }}</td>
                  <td class="text-capitalize">{{ $summary->session_mode }}</td>
                  <td>
                    @if($summary->session_notes)
                      <div class="text-truncate" style="max-width: 200px;" title="{{ $summary->session_notes }}">
                        {{ Str::limit($summary->session_notes, 50) }}
                      </div>
                    @else
                      <span class="text-muted">-</span>
                    @endif
                  </td>
                  <td>
                    @if($summary->payment && $summary->payment->paid_at)
                      {{ $summary->payment->paid_at->format('d-m-Y') }}
                    @else
                      <span class="text-muted">-</span>
                    @endif
                  </td>
                  <td>₹{{ number_format($summary->payment ? $summary->payment->amount : 0, 2) }}</td>
                  <td>₹{{ number_format($summary->payment ? $summary->payment->amount : 0, 2) }}</td>
                  <td>₹0.00</td>
                </tr>
              @empty
                <tr>
                  <td colspan="12" class="text-center text-muted py-4">
                    No matching data found.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        @if($summaries->hasPages())
          <div class="d-flex justify-content-between align-items-center mt-4">
            <div>
              <span class="text-muted">Showing {{ $summaries->firstItem() }} to {{ $summaries->lastItem() }} of {{ $summaries->total() }} entries</span>
            </div>
            <div class="d-flex align-items-center gap-2">
              <div class="d-flex gap-1">
                <a href="{{ $summaries->url(1) }}" class="btn btn-sm btn-outline-secondary {{ $summaries->onFirstPage() ? 'disabled' : '' }}">
                  <i class="ri-arrow-left-double-line"></i>
                </a>
                <a href="{{ $summaries->previousPageUrl() }}" class="btn btn-sm btn-outline-secondary {{ $summaries->onFirstPage() ? 'disabled' : '' }}">
                  <i class="ri-arrow-left-line"></i>
                </a>
                <a href="{{ $summaries->nextPageUrl() }}" class="btn btn-sm btn-outline-secondary {{ $summaries->hasMorePages() ? '' : 'disabled' }}">
                  <i class="ri-arrow-right-line"></i>
                </a>
                <a href="{{ $summaries->url($summaries->lastPage()) }}" class="btn btn-sm btn-outline-secondary {{ $summaries->hasMorePages() ? '' : 'disabled' }}">
                  <i class="ri-arrow-right-double-line"></i>
                </a>
              </div>
              <span class="text-muted ms-2">Page {{ $summaries->currentPage() }} of {{ $summaries->lastPage() }}</span>
              <select class="form-select form-select-sm" style="width: auto;" onchange="updatePerPage(this.value)">
                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 rows</option>
                <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25 rows</option>
                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50 rows</option>
                <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100 rows</option>
              </select>
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

@section('page-script')
<script>
  function updatePerPage(value) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', value);
    window.location.href = url.toString();
  }
</script>
@endsection

@section('page-style')
<style>
  .account-summary-table {
    margin-top: 1rem;
  }

  .account-summary-table thead th {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
    color: white;
    font-weight: 600;
    padding: 1rem;
    border: none;
    text-align: center;
  }

  .account-summary-table tbody td {
    padding: 1rem;
    text-align: center;
    vertical-align: middle;
  }

  .account-summary-table tbody tr:hover {
    background-color: #f8f9fa;
  }
</style>
@endsection
