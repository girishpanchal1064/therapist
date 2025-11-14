@extends('layouts/contentNavbarLayout')

@section('title', 'Assessment Results')

@section('content')
<div class="row">
  <div class="col-12">
    <!-- Statistics Cards -->
    <div class="row mb-4">
      <div class="col-md-3">
        <div class="card bg-primary text-white">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h6 class="card-title text-white-50 mb-1">Total Assessments</h6>
                <h3 class="mb-0">{{ number_format($totalAssessments) }}</h3>
              </div>
              <i class="ri-file-list-3-line" style="font-size: 3rem; opacity: 0.3;"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card bg-success text-white">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h6 class="card-title text-white-50 mb-1">Completed</h6>
                <h3 class="mb-0">{{ number_format($completedAssessments) }}</h3>
              </div>
              <i class="ri-checkbox-circle-line" style="font-size: 3rem; opacity: 0.3;"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card bg-info text-white">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h6 class="card-title text-white-50 mb-1">In Progress</h6>
                <h3 class="mb-0">{{ number_format($inProgressAssessments) }}</h3>
              </div>
              <i class="ri-time-line" style="font-size: 3rem; opacity: 0.3;"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card bg-warning text-white">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h6 class="card-title text-white-50 mb-1">Average Score</h6>
                <h3 class="mb-0">{{ $averageScore ? number_format($averageScore, 1) : 'N/A' }}</h3>
                @if($averagePercentage)
                  <small class="text-white-50">{{ number_format($averagePercentage, 1) }}%</small>
                @endif
              </div>
              <i class="ri-bar-chart-line" style="font-size: 3rem; opacity: 0.3;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Assessment Results</h5>
        <div class="d-flex gap-2">
          <a href="{{ route('admin.assessments.index') }}" class="btn btn-outline-secondary">
            <i class="ri-arrow-left-line me-1"></i> Back to Assessments
          </a>
        </div>
      </div>
      <div class="card-body">
        @if(session('success'))
          <div class="alert alert-success alert-dismissible" role="alert">
            <i class="ri-checkbox-circle-line me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if(session('error'))
          <div class="alert alert-danger alert-dismissible" role="alert">
            <i class="ri-error-warning-line me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <!-- Filters -->
        <div class="d-flex flex-wrap gap-2 mb-4 align-items-end">
          <div>
            <label class="form-label small">Status</label>
            <form method="GET" action="{{ route('admin.assessments.results') }}" class="d-flex gap-2">
              <select name="status" class="form-select" style="width: 150px;" onchange="this.form.submit()">
                <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All Status</option>
                <option value="started" {{ $status === 'started' ? 'selected' : '' }}>Started</option>
                <option value="in_progress" {{ $status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="abandoned" {{ $status === 'abandoned' ? 'selected' : '' }}>Abandoned</option>
              </select>
              <input type="hidden" name="search" value="{{ $search }}">
              <input type="hidden" name="assessment_id" value="{{ $assessmentId }}">
              <input type="hidden" name="per_page" value="{{ $perPage }}">
            </form>
          </div>

          @if($assessments->count() > 0)
            <div>
              <label class="form-label small">Assessment</label>
              <form method="GET" action="{{ route('admin.assessments.results') }}" class="d-flex gap-2">
                <select name="assessment_id" class="form-select" style="width: 200px;" onchange="this.form.submit()">
                  <option value="">All Assessments</option>
                  @foreach($assessments as $assessment)
                    <option value="{{ $assessment->id }}" {{ $assessmentId == $assessment->id ? 'selected' : '' }}>
                      {{ $assessment->title }}
                    </option>
                  @endforeach
                </select>
                <input type="hidden" name="search" value="{{ $search }}">
                <input type="hidden" name="status" value="{{ $status }}">
                <input type="hidden" name="per_page" value="{{ $perPage }}">
              </form>
            </div>
          @endif
          
          <div class="flex-grow-1">
            <form method="GET" action="{{ route('admin.assessments.results') }}" class="d-flex gap-2">
              <input type="text" name="search" class="form-control" placeholder="Search by user name, email, or assessment title..." value="{{ $search }}">
              <input type="hidden" name="status" value="{{ $status }}">
              <input type="hidden" name="assessment_id" value="{{ $assessmentId }}">
              <input type="hidden" name="per_page" value="{{ $perPage }}">
              <button type="submit" class="btn btn-outline-primary">
                <i class="ri-search-line"></i>
              </button>
              @if($search)
                <a href="{{ route('admin.assessments.results', ['status' => $status, 'assessment_id' => $assessmentId, 'per_page' => $perPage]) }}" class="btn btn-outline-secondary">
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

        <!-- Results Table -->
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>User</th>
                <th>Assessment</th>
                <th>Status</th>
                <th>Score</th>
                <th>Percentage</th>
                <th>Started At</th>
                <th>Completed At</th>
                <th>Duration</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($results as $result)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>
                    <div class="d-flex align-items-center">
                      @if($result->user->avatar)
                        <img src="{{ asset('storage/' . $result->user->avatar) }}" 
                             alt="{{ $result->user->name }}" 
                             class="rounded-circle me-2" 
                             width="32" 
                             height="32">
                      @else
                        <div class="avatar-initial rounded-circle bg-label-primary me-2 d-flex align-items-center justify-content-center" 
                             style="width: 32px; height: 32px;">
                          {{ strtoupper(substr($result->user->name, 0, 2)) }}
                        </div>
                      @endif
                      <div>
                        <div class="fw-bold">{{ $result->user->name }}</div>
                        <small class="text-muted">{{ $result->user->email }}</small>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      @if($result->assessment->icon)
                        <i class="{{ $result->assessment->icon }} me-2" style="color: {{ $result->assessment->color ?? '#3B82F6' }};"></i>
                      @endif
                      <div>
                        <div class="fw-bold">{{ $result->assessment->title }}</div>
                        <small class="text-muted">{{ $result->assessment->category }}</small>
                      </div>
                    </div>
                  </td>
                  <td>
                    @php
                      $statusColors = [
                        'started' => 'secondary',
                        'in_progress' => 'info',
                        'completed' => 'success',
                        'abandoned' => 'danger'
                      ];
                      $color = $statusColors[$result->status] ?? 'secondary';
                    @endphp
                    <span class="badge bg-{{ $color }}">
                      {{ ucfirst(str_replace('_', ' ', $result->status)) }}
                    </span>
                  </td>
                  <td>
                    @if($result->total_score !== null && $result->max_score !== null)
                      <strong>{{ $result->total_score }}</strong> / {{ $result->max_score }}
                    @else
                      <span class="text-muted">-</span>
                    @endif
                  </td>
                  <td>
                    @if($result->percentage !== null)
                      <div class="d-flex align-items-center">
                        <div class="progress me-2" style="width: 60px; height: 8px;">
                          <div class="progress-bar bg-{{ $result->percentage >= 70 ? 'success' : ($result->percentage >= 50 ? 'warning' : 'danger') }}" 
                               role="progressbar" 
                               style="width: {{ $result->percentage }}%"></div>
                        </div>
                        <span class="fw-bold">{{ number_format($result->percentage, 1) }}%</span>
                      </div>
                    @else
                      <span class="text-muted">-</span>
                    @endif
                  </td>
                  <td>
                    @if($result->started_at)
                      {{ $result->started_at->format('d-m-Y h:i A') }}
                    @else
                      <span class="text-muted">-</span>
                    @endif
                  </td>
                  <td>
                    @if($result->completed_at)
                      {{ $result->completed_at->format('d-m-Y h:i A') }}
                    @else
                      <span class="text-muted">-</span>
                    @endif
                  </td>
                  <td>
                    @if($result->started_at && $result->completed_at)
                      {{ $result->completed_at->diffInMinutes($result->started_at) }} min
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
                        <a class="dropdown-item" href="#" onclick="viewResultDetails({{ $result->id }}); return false;">
                          <i class="ri-eye-line me-1"></i> View Details
                        </a>
                        @if($result->status === 'completed' && $result->recommendations)
                          <a class="dropdown-item" href="#" onclick="viewRecommendations({{ $result->id }}); return false;">
                            <i class="ri-lightbulb-line me-1"></i> View Recommendations
                          </a>
                        @endif
                      </div>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="10" class="text-center py-4">
                    <div class="text-muted">
                      <i class="ri-inbox-line" style="font-size: 3rem;"></i>
                      <p class="mt-2">No assessment results found.</p>
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        @if($results->hasPages())
          <div class="d-flex justify-content-between align-items-center mt-4">
            <div>
              <span class="text-muted">Showing {{ $results->firstItem() }} to {{ $results->lastItem() }} of {{ $results->total() }} entries</span>
            </div>
            <div class="d-flex align-items-center gap-2">
              <div class="d-flex gap-1">
                <a href="{{ $results->url(1) }}" class="btn btn-sm btn-outline-secondary {{ $results->onFirstPage() ? 'disabled' : '' }}">
                  <i class="ri-arrow-left-double-line"></i>
                </a>
                <a href="{{ $results->previousPageUrl() }}" class="btn btn-sm btn-outline-secondary {{ $results->onFirstPage() ? 'disabled' : '' }}">
                  <i class="ri-arrow-left-line"></i>
                </a>
                <a href="{{ $results->nextPageUrl() }}" class="btn btn-sm btn-outline-secondary {{ $results->hasMorePages() ? '' : 'disabled' }}">
                  <i class="ri-arrow-right-line"></i>
                </a>
                <a href="{{ $results->url($results->lastPage()) }}" class="btn btn-sm btn-outline-secondary {{ $results->hasMorePages() ? '' : 'disabled' }}">
                  <i class="ri-arrow-right-double-line"></i>
                </a>
              </div>
              <span class="text-muted ms-2">Page {{ $results->currentPage() }} of {{ $results->lastPage() }}</span>
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

  function viewResultDetails(resultId) {
    // TODO: Implement modal or redirect to detailed view
    alert('View details for result ID: ' + resultId);
  }

  function viewRecommendations(resultId) {
    // TODO: Implement modal to show recommendations
    alert('View recommendations for result ID: ' + resultId);
  }
</script>
@endsection
