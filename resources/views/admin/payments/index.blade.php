@extends('layouts/contentNavbarLayout')

@section('title', 'Payments Management')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Payments Management</h5>
        <div class="d-flex gap-2">
          <a href="{{ route('admin.payments.pending') }}" class="btn btn-outline-warning">
            <i class="ri-time-line me-1"></i> Pending Payments
          </a>
          <a href="{{ route('admin.payments.reports') }}" class="btn btn-outline-info">
            <i class="ri-bar-chart-line me-1"></i> Reports
          </a>
          <a href="{{ route('admin.payments.create') }}" class="btn btn-primary">
            <i class="ri-add-line me-1"></i> Add Payment
          </a>
        </div>
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

        <!-- Filters -->
        <div class="d-flex flex-wrap gap-2 mb-4 align-items-end">
          <div>
            <label class="form-label small">Status</label>
            <form method="GET" action="{{ route('admin.payments.index') }}" class="d-flex gap-2">
              <select name="status" class="form-select" style="width: 150px;" onchange="this.form.submit()">
                <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All Status</option>
                <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ $status === 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="failed" {{ $status === 'failed' ? 'selected' : '' }}>Failed</option>
                <option value="refunded" {{ $status === 'refunded' ? 'selected' : '' }}>Refunded</option>
              </select>
              <input type="hidden" name="search" value="{{ $search }}">
              <input type="hidden" name="per_page" value="{{ $perPage }}">
            </form>
          </div>
          
          <div class="flex-grow-1">
            <form method="GET" action="{{ route('admin.payments.index') }}" class="d-flex gap-2">
              <input type="text" name="search" class="form-control" placeholder="Search by transaction ID, amount, user name or email..." value="{{ $search }}">
              <input type="hidden" name="status" value="{{ $status }}">
              <input type="hidden" name="per_page" value="{{ $perPage }}">
              <button type="submit" class="btn btn-outline-primary">
                <i class="ri-search-line"></i>
              </button>
              @if($search)
                <a href="{{ route('admin.payments.index', ['status' => $status, 'per_page' => $perPage]) }}" class="btn btn-outline-secondary">
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

        <!-- Payments Table -->
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Transaction ID</th>
                <th>User</th>
                <th>Amount</th>
                <th>Tax</th>
                <th>Total</th>
                <th>Payment Method</th>
                <th>Status</th>
                <th>Paid At</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($payments as $payment)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>
                    @if($payment->transaction_id)
                      <code>{{ $payment->transaction_id }}</code>
                    @else
                      <span class="text-muted">-</span>
                    @endif
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      @if($payment->user->avatar)
                        <img src="{{ asset('storage/' . $payment->user->avatar) }}" 
                             alt="{{ $payment->user->name }}" 
                             class="rounded-circle me-2" 
                             width="32" 
                             height="32">
                      @else
                        <div class="avatar-initial rounded-circle bg-label-primary me-2 d-flex align-items-center justify-content-center" 
                             style="width: 32px; height: 32px;">
                          {{ strtoupper(substr($payment->user->name, 0, 2)) }}
                        </div>
                      @endif
                      <div>
                        <div class="fw-bold">{{ $payment->user->name }}</div>
                        <small class="text-muted">{{ $payment->user->email }}</small>
                      </div>
                    </div>
                  </td>
                  <td>₹{{ number_format($payment->amount, 2) }}</td>
                  <td>₹{{ number_format($payment->tax_amount, 2) }}</td>
                  <td><strong>₹{{ number_format($payment->total_amount, 2) }}</strong></td>
                  <td class="text-capitalize">{{ $payment->payment_method }}</td>
                  <td>
                    @php
                      $statusColors = [
                        'pending' => 'warning',
                        'processing' => 'info',
                        'completed' => 'success',
                        'failed' => 'danger',
                        'refunded' => 'secondary'
                      ];
                      $color = $statusColors[$payment->status] ?? 'secondary';
                    @endphp
                    <span class="badge bg-{{ $color }}">
                      {{ ucfirst($payment->status) }}
                    </span>
                  </td>
                  <td>
                    @if($payment->paid_at)
                      {{ $payment->paid_at->format('d-m-Y h:i A') }}
                    @else
                      <span class="text-muted">-</span>
                    @endif
                  </td>
                  <td>
                    <div class="dropdown">
                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="ri-more-2-line"></i>
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('admin.payments.show', $payment) }}">
                          <i class="ri-eye-line me-1"></i> View
                        </a>
                        @if($payment->status === 'completed' && $payment->status !== 'refunded')
                          <form action="{{ route('admin.payments.refund', $payment) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="dropdown-item text-warning" onclick="return confirm('Are you sure you want to refund this payment?')">
                              <i class="ri-refund-line me-1"></i> Refund
                            </button>
                          </form>
                        @endif
                        <a class="dropdown-item" href="{{ route('admin.payments.edit', $payment) }}">
                          <i class="ri-pencil-line me-1"></i> Edit
                        </a>
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure?')">
                            <i class="ri-delete-bin-line me-1"></i> Delete
                          </button>
                        </form>
                      </div>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="10" class="text-center py-4">
                    <div class="text-muted">
                      <i class="ri-inbox-line" style="font-size: 3rem;"></i>
                      <p class="mt-2">No payments found.</p>
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        @if($payments->hasPages())
          <div class="d-flex justify-content-between align-items-center mt-4">
            <div>
              <span class="text-muted">Showing {{ $payments->firstItem() }} to {{ $payments->lastItem() }} of {{ $payments->total() }} entries</span>
            </div>
            <div class="d-flex align-items-center gap-2">
              <div class="d-flex gap-1">
                <a href="{{ $payments->url(1) }}" class="btn btn-sm btn-outline-secondary {{ $payments->onFirstPage() ? 'disabled' : '' }}">
                  <i class="ri-arrow-left-double-line"></i>
                </a>
                <a href="{{ $payments->previousPageUrl() }}" class="btn btn-sm btn-outline-secondary {{ $payments->onFirstPage() ? 'disabled' : '' }}">
                  <i class="ri-arrow-left-line"></i>
                </a>
                <a href="{{ $payments->nextPageUrl() }}" class="btn btn-sm btn-outline-secondary {{ $payments->hasMorePages() ? '' : 'disabled' }}">
                  <i class="ri-arrow-right-line"></i>
                </a>
                <a href="{{ $payments->url($payments->lastPage()) }}" class="btn btn-sm btn-outline-secondary {{ $payments->hasMorePages() ? '' : 'disabled' }}">
                  <i class="ri-arrow-right-double-line"></i>
                </a>
              </div>
              <span class="text-muted ms-2">Page {{ $payments->currentPage() }} of {{ $payments->lastPage() }}</span>
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
