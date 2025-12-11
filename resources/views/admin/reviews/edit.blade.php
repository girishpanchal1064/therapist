@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Review')

@section('vendor-style')
<style>
  .page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 24px 28px;
    margin-bottom: 24px;
    box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
  }
  .page-header h4 { margin: 0; font-weight: 700; color: white; font-size: 1.5rem; }
  .page-header p { color: rgba(255, 255, 255, 0.85); margin: 4px 0 0 0; }
  .page-header .btn-header {
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 10px 20px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
  }
  .page-header .btn-header:hover { background: rgba(255, 255, 255, 0.3); color: white; }

  .form-card {
    border-radius: 16px;
    border: none;
    box-shadow: 0 2px 16px rgba(0, 0, 0, 0.06);
    overflow: hidden;
  }
  .form-card .card-header {
    background: linear-gradient(135deg, #f8f9fc 0%, #eef1f6 100%);
    border-bottom: 1px solid #e9ecef;
    padding: 20px 24px;
  }
  .form-card .card-body { padding: 24px; }

  .section-title {
    display: flex;
    align-items: center;
    gap: 14px;
  }
  .section-title .icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
  }
  .section-title h5 { margin: 0; font-weight: 700; color: #2d3748; }
  .section-title small { color: #718096; font-size: 0.85rem; }

  .form-label-styled { font-weight: 600; color: #4a5568; margin-bottom: 8px; font-size: 0.9rem; display: block; }
  .form-control, .form-select {
    border: 2px solid #e4e6eb;
    border-radius: 10px;
    padding: 12px 16px;
    transition: all 0.3s ease;
  }
  .form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
  }

  /* Star Rating */
  .rating-container {
    background: linear-gradient(135deg, rgba(255, 193, 7, 0.1) 0%, rgba(255, 152, 0, 0.1) 100%);
    border-radius: 16px;
    padding: 24px;
    text-align: center;
  }
  .rating-stars {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-bottom: 12px;
  }
  .rating-star {
    font-size: 3rem;
    color: #e4e6eb;
    cursor: pointer;
    transition: all 0.2s ease;
  }
  .rating-star:hover,
  .rating-star.active {
    color: #ffc107;
    transform: scale(1.15);
  }
  .rating-star.active {
    filter: drop-shadow(0 2px 4px rgba(255, 193, 7, 0.5));
  }
  .rating-text {
    font-size: 1.5rem;
    font-weight: 700;
    color: #ffc107;
  }

  .form-check-input:checked { background-color: #667eea; border-color: #667eea; }

  .toggle-card {
    background: #f8f9fc;
    border-radius: 12px;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 12px;
    border: 2px solid transparent;
    transition: all 0.3s ease;
  }
  .toggle-card:hover { border-color: rgba(102, 126, 234, 0.2); }
  .toggle-card .toggle-info h6 { margin: 0 0 2px; font-weight: 600; color: #2d3748; }
  .toggle-card .toggle-info small { color: #718096; }

  .btn-cancel {
    background: white;
    border: 2px solid #e4e6eb;
    color: #566a7f;
    padding: 12px 24px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
  }
  .btn-cancel:hover { border-color: #ea5455; color: #ea5455; }
  .btn-submit {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    padding: 12px 28px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
  }
  .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4); color: white; }
</style>
@endsection

@section('content')
<div class="page-header">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
      <h4><i class="ri-star-smile-line me-2"></i>Edit Review</h4>
      <p>Update review details</p>
    </div>
    <a href="{{ route('admin.reviews.index') }}" class="btn btn-header">
      <i class="ri-arrow-left-line me-1"></i> Back to Reviews
    </a>
  </div>
</div>

@if(session('error'))
  <div class="alert alert-danger alert-dismissible mb-4"><i class="ri-error-warning-line me-2"></i>{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif
@if($errors->any())
  <div class="alert alert-danger alert-dismissible mb-4"><i class="ri-error-warning-line me-2"></i><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

<form action="{{ route('admin.reviews.update', $review) }}" method="POST">
  @csrf
  @method('PUT')
  <div class="row g-4">
    <div class="col-lg-8">
      <div class="card form-card mb-4">
        <div class="card-header">
          <div class="section-title">
            <div class="icon"><i class="ri-user-heart-line"></i></div>
            <div>
              <h5>Review Information</h5>
              <small>Review details</small>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label-styled">Client</label>
              <input type="text" class="form-control" value="{{ $review->client->name }} ({{ $review->client->email }})" readonly>
            </div>
            <div class="col-md-6">
              <label class="form-label-styled">Therapist</label>
              <input type="text" class="form-control" value="{{ $review->therapist->name }}" readonly>
            </div>
            @if($review->appointment)
            <div class="col-12">
              <label class="form-label-styled">Appointment</label>
              <input type="text" class="form-control" value="{{ $review->appointment->appointment_date->format('M d, Y') }}" readonly>
            </div>
            @endif
          </div>
        </div>
      </div>

      <div class="card form-card">
        <div class="card-header">
          <div class="section-title">
            <div class="icon"><i class="ri-message-3-line"></i></div>
            <div>
              <h5>Review Content</h5>
              <small>Rating and comment</small>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="rating-container mb-4">
            <input type="hidden" id="rating" name="rating" value="{{ old('rating', $review->rating) }}" required>
            <div class="rating-stars">
              @for($i = 1; $i <= 5; $i++)
                <i class="ri-star-fill rating-star {{ $i <= old('rating', $review->rating) ? 'active' : '' }}" data-rating="{{ $i }}"></i>
              @endfor
            </div>
            <div class="rating-text"><span id="rating-display">{{ old('rating', $review->rating) }}</span>/5 Stars</div>
          </div>

          <label class="form-label-styled">Comment</label>
          <textarea class="form-control" name="comment" rows="5" placeholder="Write the review comment here...">{{ old('comment', $review->comment) }}</textarea>
          <div class="text-muted small mt-2">Maximum 1000 characters</div>

          <div class="d-flex justify-content-between align-items-center pt-4 mt-4 border-top">
            <a href="{{ route('admin.reviews.index') }}" class="btn btn-cancel"><i class="ri-close-line me-1"></i> Cancel</a>
            <button type="submit" class="btn btn-submit"><i class="ri-save-line me-1"></i> Update Review</button>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card form-card">
        <div class="card-header">
          <div class="section-title">
            <div class="icon"><i class="ri-settings-4-line"></i></div>
            <div>
              <h5>Settings</h5>
              <small>Visibility options</small>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="toggle-card">
            <div class="toggle-info">
              <h6><i class="ri-verified-badge-line me-2 text-success"></i>Verified</h6>
              <small>Mark as verified review</small>
            </div>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="is_verified" name="is_verified" value="1" {{ old('is_verified', $review->is_verified) ? 'checked' : '' }}>
            </div>
          </div>
          <div class="toggle-card">
            <div class="toggle-info">
              <h6><i class="ri-eye-line me-2 text-primary"></i>Public</h6>
              <small>Visible to everyone</small>
            </div>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="is_public" name="is_public" value="1" {{ old('is_public', $review->is_public) ? 'checked' : '' }}>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const ratingInput = document.getElementById('rating');
  const ratingDisplay = document.getElementById('rating-display');
  const stars = document.querySelectorAll('.rating-star');

  stars.forEach(star => {
    star.addEventListener('click', function() {
      const rating = parseInt(this.dataset.rating);
      ratingInput.value = rating;
      ratingDisplay.textContent = rating;
      stars.forEach((s, i) => s.classList.toggle('active', i < rating));
    });
    star.addEventListener('mouseenter', function() {
      const rating = parseInt(this.dataset.rating);
      stars.forEach((s, i) => s.classList.toggle('active', i < rating));
    });
  });
  document.querySelector('.rating-container').addEventListener('mouseleave', function() {
    const rating = parseInt(ratingInput.value);
    stars.forEach((s, i) => s.classList.toggle('active', i < rating));
  });
});
</script>
@endsection
