@extends('layouts/contentNavbarLayout')

@section('title', 'Assessment Results')

@section('page-style')
<style>
  .layout-page .content-wrapper {
    background: linear-gradient(to bottom, #fff, rgba(186, 194, 210, 0.05)) !important;
  }

  .page-header {
    background: linear-gradient(90deg, #041C54 0%, #2f4a76 55%, #647494 100%);
    border-radius: 24px;
    padding: 24px 28px;
    margin-bottom: 24px;
    box-shadow: 0 10px 18px rgba(4, 28, 84, 0.28);
  }
  .page-header h4 {
    margin: 0;
    font-weight: 700;
    color: #fff;
    font-size: 1.5rem;
  }
  .page-header p {
    margin: 4px 0 0;
    color: rgba(255, 255, 255, 0.85);
  }
  .page-header .btn-back-results {
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.35);
    color: #fff;
    font-weight: 600;
    border-radius: 10px;
    padding: 10px 18px;
  }
  .page-header .btn-back-results:hover {
    background: rgba(255, 255, 255, 0.3);
    color: #fff;
  }

  .results-stats-card {
    border-radius: 16px;
    border: 1px solid rgba(186, 194, 210, 0.35);
    box-shadow: 0 10px 15px rgba(4, 28, 84, 0.05), 0 4px 6px rgba(4, 28, 84, 0.05);
    overflow: hidden;
    position: relative;
    background: #fff;
  }
  .results-stats-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #041C54 0%, #647494 100%);
  }
  .results-stats-card .stats-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
  }
  .results-stats-card .stats-icon.total {
    background: rgba(4, 28, 84, 0.08);
    color: #041C54;
  }
  .results-stats-card .stats-icon.completed {
    background: rgba(40, 199, 111, 0.12);
    color: #28c76f;
  }
  .results-stats-card .stats-icon.progress {
    background: rgba(100, 116, 148, 0.14);
    color: #647494;
  }
  .results-stats-card .stats-icon.avg {
    background: rgba(255, 159, 67, 0.14);
    color: #ff9f43;
  }
  .results-stats-card .stats-label {
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    color: #7484a4;
    margin-bottom: 4px;
  }
  .results-stats-card .stats-value {
    font-size: 1.75rem;
    font-weight: 800;
    margin: 0;
    background: linear-gradient(90deg, #041C54 0%, #647494 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }
  .results-stats-card .stats-sub {
    font-size: 0.85rem;
    color: #7484a4;
    margin-top: 2px;
  }

  .results-main-card {
    border-radius: 16px;
    border: 1px solid rgba(186, 194, 210, 0.35);
    box-shadow: 0 10px 15px rgba(4, 28, 84, 0.05), 0 4px 6px rgba(4, 28, 84, 0.05);
    overflow: hidden;
  }
  .results-main-card > .card-header {
    background: linear-gradient(135deg, #f8fafc 0%, #eef2f7 100%);
    border-bottom: 1px solid rgba(186, 194, 210, 0.35);
    padding: 20px 24px;
  }
  .results-main-card .card-title {
    font-weight: 700;
    color: #041C54;
  }

  .results-filters .form-control:focus,
  .results-filters .form-select:focus {
    border-color: #647494;
    box-shadow: 0 0 0 4px rgba(100, 116, 148, 0.12);
  }

  .btn-results-search {
    background: linear-gradient(90deg, #041C54 0%, #647494 100%);
    border: none;
    color: #fff;
    border-radius: 10px;
    padding: 0.5rem 0.85rem;
    box-shadow: 0 4px 12px rgba(4, 28, 84, 0.2);
  }
  .btn-results-search:hover {
    color: #fff;
    box-shadow: 0 6px 16px rgba(4, 28, 84, 0.26);
  }

  .btn-results-refresh {
    border-color: #647494;
    color: #647494;
    font-weight: 600;
    border-radius: 10px;
  }
  .btn-results-refresh:hover {
    background: rgba(100, 116, 148, 0.1);
    border-color: #647494;
    color: #041C54;
  }

  .avatar-results-initials {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: 700;
    color: #fff;
    background: linear-gradient(90deg, #041C54 0%, #647494 100%);
  }

  .results-pagination .btn-outline-secondary:hover:not(.disabled) {
    background: linear-gradient(90deg, #041C54 0%, #647494 100%);
    border-color: transparent;
    color: #fff;
  }

  .results-empty-icon {
    width: 72px;
    height: 72px;
    margin: 0 auto;
    border-radius: 50%;
    background: linear-gradient(90deg, #041C54 0%, #647494 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 2rem;
  }
</style>
@endsection

@section('content')
<div class="page-header">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
      <h4><i class="ri-bar-chart-line me-2"></i>Assessment Results</h4>
      <p>Track completions, scores, and participant activity</p>
    </div>
    <a href="{{ route('admin.assessments.index') }}" class="btn btn-sm btn-back-results">
      <i class="ri-arrow-left-line me-1"></i> Back to Assessments
    </a>
  </div>
</div>
<div class="row">
  <div class="col-12">
    <!-- Statistics Cards -->
    <div class="row mb-4 g-3">
      <div class="col-md-3">
        <div class="card results-stats-card h-100">
          <div class="card-body">
            <div class="d-flex align-items-center gap-3">
              <div class="stats-icon total"><i class="ri-file-list-3-line"></i></div>
              <div>
                <div class="stats-label">Total assessments</div>
                <h3 class="stats-value">{{ number_format($totalAssessments) }}</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card results-stats-card h-100">
          <div class="card-body">
            <div class="d-flex align-items-center gap-3">
              <div class="stats-icon completed"><i class="ri-checkbox-circle-line"></i></div>
              <div>
                <div class="stats-label">Completed</div>
                <h3 class="stats-value">{{ number_format($completedAssessments) }}</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card results-stats-card h-100">
          <div class="card-body">
            <div class="d-flex align-items-center gap-3">
              <div class="stats-icon progress"><i class="ri-time-line"></i></div>
              <div>
                <div class="stats-label">In progress</div>
                <h3 class="stats-value">{{ number_format($inProgressAssessments) }}</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card results-stats-card h-100">
          <div class="card-body">
            <div class="d-flex align-items-center gap-3">
              <div class="stats-icon avg"><i class="ri-bar-chart-line"></i></div>
              <div>
                <div class="stats-label">Average score</div>
                <h3 class="stats-value">{{ $averageScore ? number_format($averageScore, 1) : 'N/A' }}</h3>
                @if($averagePercentage)
                  <div class="stats-sub">{{ number_format($averagePercentage, 1) }}% avg. percentage</div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card results-main-card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">All results</h5>
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
        <div class="d-flex flex-wrap gap-2 mb-4 align-items-end results-filters">
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
              <button type="submit" class="btn btn-results-search">
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
            <button type="button" class="btn btn-results-refresh" onclick="location.reload()">
              <i class="ri-refresh-line me-1"></i> Refresh
            </button>
          </div>
        </div>

        <!-- Results Table -->
        <div class="table-responsive admin-table-scroll">
          <table class="table table-hover table-results-admin align-middle">
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
                        <div class="avatar-results-initials me-2">
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
                        <i class="{{ $result->assessment->icon }} me-2" style="color: {{ $result->assessment->color ?? '#647494' }};"></i>
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
                  <td colspan="10" class="text-center py-5">
                    <div class="results-empty-icon mb-3">
                      <i class="ri-inbox-line"></i>
                    </div>
                    <p class="text-muted mb-0">No assessment results found.</p>
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
            <div class="d-flex align-items-center gap-2 results-pagination">
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
