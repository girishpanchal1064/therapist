@extends('layouts/contentNavbarLayout')

@section('title', 'Client Dashboard')

@section('content')
<div class="row">
  <!-- Statistics Cards -->
  <div class="col-lg-3 col-md-6 col-12 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
          <div class="avatar flex-shrink-0">
            <i class="ri-calendar-check-line text-primary" style="font-size: 2rem;"></i>
          </div>
        </div>
        <span class="fw-semibold d-block mb-1">Total Appointments</span>
        <h3 class="card-title mb-2">{{ $stats['total_appointments'] }}</h3>
        <small class="text-success fw-semibold">
          <i class="ri-arrow-up-line"></i> {{ $stats['upcoming_appointments'] }} upcoming
        </small>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-12 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
          <div class="avatar flex-shrink-0">
            <i class="ri-wallet-3-line text-success" style="font-size: 2rem;"></i>
          </div>
        </div>
        <span class="fw-semibold d-block mb-1">Wallet Balance</span>
        <h3 class="card-title mb-2">₹{{ number_format($stats['wallet_balance'], 2) }}</h3>
        <button type="button" class="btn btn-sm btn-outline-primary mt-2" data-bs-toggle="modal" data-bs-target="#rechargeWalletModal">
          <i class="ri-add-circle-line me-1"></i>Recharge
        </button>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-12 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
          <div class="avatar flex-shrink-0">
            <i class="ri-file-list-3-line text-info" style="font-size: 2rem;"></i>
          </div>
        </div>
        <span class="fw-semibold d-block mb-1">Assessments</span>
        <h3 class="card-title mb-2">{{ $stats['assessments_completed'] }}</h3>
        <small class="text-muted">Completed</small>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-12 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
          <div class="avatar flex-shrink-0">
            <i class="ri-star-line text-warning" style="font-size: 2rem;"></i>
          </div>
        </div>
        <span class="fw-semibold d-block mb-1">Reviews Given</span>
        <h3 class="card-title mb-2">{{ $stats['reviews_given'] }}</h3>
        <small class="text-muted">Total reviews</small>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <!-- Today's Appointments -->
  @if($todayAppointments->count() > 0)
  <div class="col-12 mb-4">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
          <i class="ri-calendar-todo-line me-2"></i>Today's Sessions
        </h5>
        <span class="badge bg-primary">{{ $todayAppointments->count() }} session(s)</span>
      </div>
      <div class="card-body">
        <div class="row">
          @foreach($todayAppointments as $appointment)
          <div class="col-md-6 mb-3">
            <div class="card border-primary">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                  <div class="d-flex align-items-center">
                    <div class="avatar avatar-md me-3">
                      <img src="{{ $appointment->therapist->avatar }}" alt="{{ $appointment->therapist->name }}" class="rounded-circle">
                    </div>
                    <div>
                      <h6 class="mb-1">{{ $appointment->therapist->name }}</h6>
                      <p class="text-muted mb-1">
                        <i class="ri-time-line me-1"></i>
                        {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                      </p>
                      <span class="badge bg-{{ $appointment->status === 'confirmed' ? 'success' : 'warning' }}">
                        {{ ucfirst($appointment->status) }}
                      </span>
                    </div>
                  </div>
                  <div>
                    @if($appointment->status === 'confirmed' || $appointment->status === 'in_progress')
                    <a href="{{ route('client.sessions.join', $appointment->id) }}" class="btn btn-sm btn-primary">
                      <i class="ri-video-line me-1"></i>Join Session
                    </a>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
  @endif

  <!-- Upcoming Appointments -->
  <div class="col-md-6 col-lg-6 mb-4">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Upcoming Sessions</h5>
        <a href="{{ route('therapists.index') }}" class="btn btn-sm btn-outline-primary">
          <i class="ri-add-circle-line me-1"></i>Book Session
        </a>
      </div>
      <div class="card-body">
        @if($upcomingAppointments->count() > 0)
          <div class="table-responsive">
            <table class="table table-borderless">
              <thead>
                <tr>
                  <th>Therapist</th>
                  <th>Date & Time</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($upcomingAppointments->take(5) as $appointment)
                <tr>
                  <td>
                    <div class="d-flex align-items-center">
                      <div class="avatar avatar-sm me-2">
                        <img src="{{ $appointment->therapist->avatar }}" alt="Avatar" class="rounded-circle">
                      </div>
                      <div>
                        <h6 class="mb-0">{{ $appointment->therapist->name }}</h6>
                        <small class="text-muted">{{ $appointment->session_mode }}</small>
                      </div>
                    </div>
                  </td>
                  <td>
                    <small class="d-block">{{ $appointment->appointment_date->format('M d, Y') }}</small>
                    <small class="text-muted">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</small>
                  </td>
                  <td>
                    <span class="badge bg-{{ $appointment->status === 'confirmed' ? 'success' : 'warning' }}">
                      {{ ucfirst($appointment->status) }}
                    </span>
                  </td>
                  <td>
                    <div class="dropdown">
                      <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Actions
                      </button>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('client.appointments.show', $appointment->id) }}"><i class="ri-eye-line me-2"></i>View</a></li>
                        @if($appointment->status === 'confirmed')
                        <li><a class="dropdown-item" href="{{ route('client.sessions.join', $appointment->id) }}"><i class="ri-video-line me-2"></i>Join Session</a></li>
                        @endif
                        <li><a class="dropdown-item" href="{{ route('client.reviews.create', $appointment->id) }}"><i class="ri-star-line me-2"></i>Review</a></li>
                      </ul>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          @if($upcomingAppointments->count() > 5)
          <div class="text-center mt-3">
            <a href="{{ route('client.appointments.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
          </div>
          @endif
        @else
          <div class="text-center py-4">
            <i class="ri-calendar-line" style="font-size: 3rem; color: #ccc;"></i>
            <p class="text-muted mt-3">No upcoming sessions</p>
            <a href="{{ route('therapists.index') }}" class="btn btn-primary">
              <i class="ri-add-circle-line me-1"></i>Book a Session
            </a>
          </div>
        @endif
      </div>
    </div>
  </div>

  <!-- Recent Completed Sessions -->
  <div class="col-md-6 col-lg-6 mb-4">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Recent Sessions</h5>
      </div>
      <div class="card-body">
        @if($recentAppointments->count() > 0)
          <div class="table-responsive">
            <table class="table table-borderless">
              <thead>
                <tr>
                  <th>Therapist</th>
                  <th>Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($recentAppointments->take(5) as $appointment)
                <tr>
                  <td>
                    <div class="d-flex align-items-center">
                      <div class="avatar avatar-sm me-2">
                        <img src="{{ $appointment->therapist->avatar }}" alt="Avatar" class="rounded-circle">
                      </div>
                      <div>
                        <h6 class="mb-0">{{ $appointment->therapist->name }}</h6>
                      </div>
                    </div>
                  </td>
                  <td>{{ $appointment->appointment_date->format('M d, Y') }}</td>
                  <td>
                    <div class="dropdown">
                      <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Actions
                      </button>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('client.appointments.show', $appointment->id) }}"><i class="ri-eye-line me-2"></i>View</a></li>
                        <li><a class="dropdown-item" href="{{ route('client.reviews.create', $appointment->id) }}"><i class="ri-star-line me-2"></i>Review</a></li>
                      </ul>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <div class="text-center py-4">
            <i class="ri-file-list-3-line" style="font-size: 3rem; color: #ccc;"></i>
            <p class="text-muted mt-3">No recent sessions</p>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

<div class="row">
  <!-- Assessments -->
  <div class="col-md-6 col-lg-6 mb-4">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Assessments</h5>
        <a href="{{ route('assessments.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
      </div>
      <div class="card-body">
        @if($availableAssessments->count() > 0)
          <div class="list-group list-group-flush">
            @foreach($availableAssessments->take(5) as $assessment)
            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
              <div class="d-flex align-items-center">
                <div class="avatar avatar-sm me-3" style="background-color: {{ $assessment->color ?? '#6366f1' }}20;">
                  <i class="{{ $assessment->icon ?? 'ri-file-list-3-line' }}" style="color: {{ $assessment->color ?? '#6366f1' }}; font-size: 1.5rem;"></i>
                </div>
                <div>
                  <h6 class="mb-0">{{ $assessment->title }}</h6>
                  <small class="text-muted">{{ $assessment->duration_minutes }} min • {{ $assessment->question_count }} questions</small>
                </div>
              </div>
              <div>
                @if($assessment->user_completed > 0)
                <span class="badge bg-success me-2">Completed</span>
                @endif
                <a href="{{ route('assessments.start', $assessment->slug) }}" class="btn btn-sm btn-primary">
                  {{ $assessment->user_completed > 0 ? 'Retake' : 'Start' }}
                </a>
              </div>
            </div>
            @endforeach
          </div>
        @else
          <p class="text-muted text-center py-4">No assessments available</p>
        @endif
      </div>
    </div>
  </div>

  <!-- Wallet Transactions -->
  <div class="col-md-6 col-lg-6 mb-4">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Recent Transactions</h5>
        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#rechargeWalletModal">
          <i class="ri-add-circle-line me-1"></i>Recharge
        </button>
      </div>
      <div class="card-body">
        @if($walletTransactions->count() > 0)
          <div class="table-responsive">
            <table class="table table-borderless">
              <thead>
                <tr>
                  <th>Type</th>
                  <th>Amount</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
                @foreach($walletTransactions->take(5) as $transaction)
                <tr>
                  <td>
                    <span class="badge bg-{{ $transaction->type === 'credit' ? 'success' : 'danger' }}">
                      {{ ucfirst($transaction->type) }}
                    </span>
                    <small class="d-block text-muted">{{ $transaction->description }}</small>
                  </td>
                  <td class="fw-semibold text-{{ $transaction->type === 'credit' ? 'success' : 'danger' }}">
                    {{ $transaction->formatted_amount }}
                  </td>
                  <td>{{ $transaction->created_at->format('M d, Y') }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <div class="text-center py-4">
            <i class="ri-wallet-3-line" style="font-size: 3rem; color: #ccc;"></i>
            <p class="text-muted mt-3">No transactions yet</p>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#rechargeWalletModal">
              <i class="ri-add-circle-line me-1"></i>Add Money to Wallet
            </button>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

<!-- Recharge Wallet Modal -->
@include('client.wallet.partials.recharge-modal', ['wallet' => (object)['balance' => $stats['wallet_balance']]])

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Payment method selection with enhanced UI
  document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
    radio.addEventListener('change', function() {
      document.querySelectorAll('.payment-method-card').forEach(card => {
        card.classList.remove('border-primary', 'shadow-sm');
        card.classList.add('border');
        card.style.transform = 'scale(1)';
      });
      if (this.checked) {
        const card = this.closest('label').querySelector('.payment-method-card');
        card.classList.remove('border');
        card.classList.add('border-primary', 'shadow-sm');
        card.style.transform = 'scale(1.02)';
      }
    });
  });

  // Initialize first payment method
  const firstRadio = document.querySelector('input[name="payment_method"]:checked');
  if (firstRadio) {
    firstRadio.dispatchEvent(new Event('change'));
  }

  // Quick amount buttons
  document.querySelectorAll('.quick-amount-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const amount = this.dataset.amount;
      document.getElementById('rechargeAmount').value = amount;
      document.querySelectorAll('.quick-amount-btn').forEach(b => {
        b.classList.remove('btn-primary');
        b.classList.add('btn-outline-primary');
      });
      this.classList.remove('btn-outline-primary');
      this.classList.add('btn-primary');
    });
  });

  // Custom amount input
  const amountInput = document.getElementById('rechargeAmount');
  if (amountInput) {
    amountInput.addEventListener('input', function() {
      const value = parseFloat(this.value);
      document.querySelectorAll('.quick-amount-btn').forEach(b => {
        if (parseFloat(b.dataset.amount) === value) {
          b.classList.remove('btn-outline-primary');
          b.classList.add('btn-primary');
        } else {
          b.classList.remove('btn-primary');
          b.classList.add('btn-outline-primary');
        }
      });
    });
  }
});
</script>
@endsection
@endsection
