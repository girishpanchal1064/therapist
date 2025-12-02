<div>
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">Awards & Recognition</h5>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#awardModal">
      <i class="ri-add-line me-1"></i> Add Award
    </button>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered">
      <thead class="table-light">
        <tr>
          <th>Sr. No.</th>
          <th>Award Name</th>
          <th>Awarded By</th>
          <th>Year</th>
          <th>Description</th>
          <th>Document</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($awards ?? [] as $index => $award)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $award->award_name }}</td>
            <td>{{ $award->awarded_by }}</td>
            <td>{{ $award->year }}</td>
            <td>{{ Str::limit($award->description, 50) }}</td>
            <td>
              @if($award->document)
                <a href="{{ asset('storage/' . $award->document) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                  <i class="ri-file-line me-1"></i> View
                </a>
              @else
                <span class="text-muted">No document</span>
              @endif
            </td>
            <td>
              <button type="button" class="btn btn-sm btn-primary" 
                      data-bs-toggle="modal" 
                      data-bs-target="#awardModal"
                      data-award-id="{{ $award->id }}"
                      data-award-name="{{ $award->award_name }}"
                      data-awarded-by="{{ $award->awarded_by }}"
                      data-year="{{ $award->year }}"
                      data-description="{{ $award->description }}">
                <i class="ri-edit-line"></i>
              </button>
              <form method="POST" action="{{ route('therapist.profile.award.delete', $award) }}" class="d-inline delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" data-title="Delete Award" data-text="Are you sure you want to delete this award? This action cannot be undone." data-confirm-text="Yes, delete it!" data-cancel-text="Cancel">
                  <i class="ri-delete-bin-line"></i>
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="text-center text-muted">No awards found. Click "Add Award" to add one.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Award Modal -->
<div class="modal fade" id="awardModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="awardModalTitle">Add Award</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="awardForm" method="POST" enctype="multipart/form-data">
        @csrf
        <div id="awardMethod"></div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Award Name <span class="text-danger">*</span></label>
            <input type="text" name="award_name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Awarded By <span class="text-danger">*</span></label>
            <input type="text" name="awarded_by" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Year <span class="text-danger">*</span></label>
            <input type="text" name="year" class="form-control" required placeholder="e.g., 2020">
          </div>
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Document</label>
            <input type="file" name="document" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
            <small class="text-muted">Max size: 5MB</small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const modal = document.getElementById('awardModal');
  const form = document.getElementById('awardForm');
  const title = document.getElementById('awardModalTitle');
  const methodDiv = document.getElementById('awardMethod');
  
  modal.addEventListener('show.bs.modal', function(event) {
    const button = event.relatedTarget;
    const awardId = button?.getAttribute('data-award-id');
    
    if (awardId) {
      title.textContent = 'Edit Award';
      form.action = '{{ route("therapist.profile.award.update", ":id") }}'.replace(':id', awardId);
      methodDiv.innerHTML = '@method("PUT")';
      
      form.querySelector('[name="award_name"]').value = button.getAttribute('data-award-name') || '';
      form.querySelector('[name="awarded_by"]').value = button.getAttribute('data-awarded-by') || '';
      form.querySelector('[name="year"]').value = button.getAttribute('data-year') || '';
      form.querySelector('[name="description"]').value = button.getAttribute('data-description') || '';
    } else {
      title.textContent = 'Add Award';
      form.action = '{{ route("therapist.profile.award.store") }}';
      methodDiv.innerHTML = '';
      form.reset();
    }
  });
  
  modal.addEventListener('hidden.bs.modal', function() {
    form.reset();
    methodDiv.innerHTML = '';
  });
});
</script>
