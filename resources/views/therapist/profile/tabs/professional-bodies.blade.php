<div>
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">Member Of Professional Bodies</h5>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#professionalBodyModal">
      <i class="ri-add-line me-1"></i> Add Professional Body
    </button>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered">
      <thead class="table-light">
        <tr>
          <th>Sr. No.</th>
          <th>Body Name</th>
          <th>Membership Number</th>
          <th>Membership Type</th>
          <th>Year Joined</th>
          <th>Document</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($professionalBodies ?? [] as $index => $body)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $body->body_name }}</td>
            <td>{{ $body->membership_number ?? '-' }}</td>
            <td>{{ $body->membership_type ?? '-' }}</td>
            <td>{{ $body->year_joined ?? '-' }}</td>
            <td>
              @if($body->document)
                <a href="{{ asset('storage/' . $body->document) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                  <i class="ri-file-line me-1"></i> View
                </a>
              @else
                <span class="text-muted">No document</span>
              @endif
            </td>
            <td>
              <button type="button" class="btn btn-sm btn-primary" 
                      data-bs-toggle="modal" 
                      data-bs-target="#professionalBodyModal"
                      data-body-id="{{ $body->id }}"
                      data-body-name="{{ $body->body_name }}"
                      data-membership-number="{{ $body->membership_number }}"
                      data-membership-type="{{ $body->membership_type }}"
                      data-year-joined="{{ $body->year_joined }}">
                <i class="ri-edit-line"></i>
              </button>
              <form method="POST" action="{{ route('therapist.profile.professional-body.delete', $body) }}" class="d-inline delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" data-title="Delete Professional Body" data-text="Are you sure you want to delete this professional body? This action cannot be undone." data-confirm-text="Yes, delete it!" data-cancel-text="Cancel">
                  <i class="ri-delete-bin-line"></i>
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="text-center text-muted">No professional bodies found. Click "Add Professional Body" to add one.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Professional Body Modal -->
<div class="modal fade" id="professionalBodyModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="professionalBodyModalTitle">Add Professional Body</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="professionalBodyForm" method="POST" enctype="multipart/form-data">
        @csrf
        <div id="professionalBodyMethod"></div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Body Name <span class="text-danger">*</span></label>
            <input type="text" name="body_name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Membership Number</label>
            <input type="text" name="membership_number" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">Membership Type</label>
            <input type="text" name="membership_type" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">Year Joined</label>
            <input type="text" name="year_joined" class="form-control" placeholder="e.g., 2020">
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
  const modal = document.getElementById('professionalBodyModal');
  const form = document.getElementById('professionalBodyForm');
  const title = document.getElementById('professionalBodyModalTitle');
  const methodDiv = document.getElementById('professionalBodyMethod');
  
  modal.addEventListener('show.bs.modal', function(event) {
    const button = event.relatedTarget;
    const bodyId = button?.getAttribute('data-body-id');
    
    if (bodyId) {
      title.textContent = 'Edit Professional Body';
      form.action = '{{ route("therapist.profile.professional-body.update", ":id") }}'.replace(':id', bodyId);
      methodDiv.innerHTML = '@method("PUT")';
      
      form.querySelector('[name="body_name"]').value = button.getAttribute('data-body-name') || '';
      form.querySelector('[name="membership_number"]').value = button.getAttribute('data-membership-number') || '';
      form.querySelector('[name="membership_type"]').value = button.getAttribute('data-membership-type') || '';
      form.querySelector('[name="year_joined"]').value = button.getAttribute('data-year-joined') || '';
    } else {
      title.textContent = 'Add Professional Body';
      form.action = '{{ route("therapist.profile.professional-body.store") }}';
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
