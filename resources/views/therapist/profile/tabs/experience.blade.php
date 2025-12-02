<div>
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">Experience</h5>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#experienceModal">
      <i class="ri-add-line me-1"></i> Add Experience
    </button>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered">
      <thead class="table-light">
        <tr>
          <th>Sr. No.</th>
          <th>Designation</th>
          <th>Hospital/Organisation</th>
          <th>Starting Date</th>
          <th>Last Date</th>
          <th>Document</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($experiences ?? [] as $index => $experience)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $experience->designation }}</td>
            <td>{{ $experience->hospital_organisation }}</td>
            <td>{{ $experience->starting_date->format('d-m-Y') }}</td>
            <td>{{ $experience->last_date ? $experience->last_date->format('d-m-Y') : 'Present' }}</td>
            <td>
              @if($experience->document)
                <a href="{{ asset('storage/' . $experience->document) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                  <i class="ri-file-line me-1"></i> View
                </a>
              @else
                <span class="text-muted">No document</span>
              @endif
            </td>
            <td>
              <button type="button" class="btn btn-sm btn-primary" 
                      data-bs-toggle="modal" 
                      data-bs-target="#experienceModal"
                      data-experience-id="{{ $experience->id }}"
                      data-designation="{{ $experience->designation }}"
                      data-hospital="{{ $experience->hospital_organisation }}"
                      data-starting-date="{{ $experience->starting_date->format('Y-m-d') }}"
                      data-last-date="{{ $experience->last_date ? $experience->last_date->format('Y-m-d') : '' }}">
                <i class="ri-edit-line"></i>
              </button>
              <form method="POST" action="{{ route('therapist.profile.experience.delete', $experience) }}" class="d-inline delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" data-title="Delete Experience" data-text="Are you sure you want to delete this experience? This action cannot be undone." data-confirm-text="Yes, delete it!" data-cancel-text="Cancel">
                  <i class="ri-delete-bin-line"></i>
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="text-center text-muted">No experience records found. Click "Add Experience" to add one.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Experience Modal -->
<div class="modal fade" id="experienceModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="experienceModalTitle">Add Experience</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="experienceForm" method="POST" enctype="multipart/form-data">
        @csrf
        <div id="experienceMethod"></div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Designation <span class="text-danger">*</span></label>
            <input type="text" name="designation" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Hospital/Organisation <span class="text-danger">*</span></label>
            <input type="text" name="hospital_organisation" class="form-control" required>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Starting Date <span class="text-danger">*</span></label>
              <input type="date" name="starting_date" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Last Date</label>
              <input type="date" name="last_date" class="form-control">
              <small class="text-muted">Leave empty if currently working</small>
            </div>
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
  const modal = document.getElementById('experienceModal');
  const form = document.getElementById('experienceForm');
  const title = document.getElementById('experienceModalTitle');
  const methodDiv = document.getElementById('experienceMethod');
  
  modal.addEventListener('show.bs.modal', function(event) {
    const button = event.relatedTarget;
    const experienceId = button?.getAttribute('data-experience-id');
    
    if (experienceId) {
      // Edit mode
      title.textContent = 'Edit Experience';
      form.action = '{{ route("therapist.profile.experience.update", ":id") }}'.replace(':id', experienceId);
      methodDiv.innerHTML = '@method("PUT")';
      
      // Populate form
      form.querySelector('[name="designation"]').value = button.getAttribute('data-designation') || '';
      form.querySelector('[name="hospital_organisation"]').value = button.getAttribute('data-hospital') || '';
      form.querySelector('[name="starting_date"]').value = button.getAttribute('data-starting-date') || '';
      form.querySelector('[name="last_date"]').value = button.getAttribute('data-last-date') || '';
    } else {
      // Add mode
      title.textContent = 'Add Experience';
      form.action = '{{ route("therapist.profile.experience.store") }}';
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
