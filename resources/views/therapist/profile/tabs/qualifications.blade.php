<div>
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">Qualifications</h5>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#qualificationModal">
      <i class="ri-add-line me-1"></i> Add Qualification
    </button>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered">
      <thead class="table-light">
        <tr>
          <th>Sr. No.</th>
          <th>Name of Degree</th>
          <th>Degree In</th>
          <th>Institute/University</th>
          <th>Year of Passing</th>
          <th>Percentage/CGPA</th>
          <th>Certificate</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($qualifications ?? [] as $index => $qualification)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $qualification->name_of_degree }}</td>
            <td>{{ $qualification->degree_in }}</td>
            <td>{{ $qualification->institute_university }}</td>
            <td>{{ $qualification->year_of_passing }}</td>
            <td>{{ $qualification->percentage_cgpa }}</td>
            <td>
              @if($qualification->certificate)
                <a href="{{ asset('storage/' . $qualification->certificate) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                  <i class="ri-file-line me-1"></i> View
                </a>
              @else
                <span class="text-muted">No certificate</span>
              @endif
            </td>
            <td>
              <button type="button" class="btn btn-sm btn-primary" 
                      data-bs-toggle="modal" 
                      data-bs-target="#qualificationModal"
                      data-qualification-id="{{ $qualification->id }}"
                      data-name-of-degree="{{ $qualification->name_of_degree }}"
                      data-degree-in="{{ $qualification->degree_in }}"
                      data-institute="{{ $qualification->institute_university }}"
                      data-year="{{ $qualification->year_of_passing }}"
                      data-percentage="{{ $qualification->percentage_cgpa }}">
                <i class="ri-edit-line"></i>
              </button>
              <form method="POST" action="{{ route('therapist.profile.qualification.delete', $qualification) }}" class="d-inline delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" data-title="Delete Qualification" data-text="Are you sure you want to delete this qualification? This action cannot be undone." data-confirm-text="Yes, delete it!" data-cancel-text="Cancel">
                  <i class="ri-delete-bin-line"></i>
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="8" class="text-center text-muted">No qualifications found. Click "Add Qualification" to add one.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Qualification Modal -->
<div class="modal fade" id="qualificationModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="qualificationModalTitle">Add Qualification</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="qualificationForm" method="POST" enctype="multipart/form-data">
        @csrf
        <div id="qualificationMethod"></div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Name of Degree <span class="text-danger">*</span></label>
            <input type="text" name="name_of_degree" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Degree In <span class="text-danger">*</span></label>
            <input type="text" name="degree_in" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Institute/University <span class="text-danger">*</span></label>
            <input type="text" name="institute_university" class="form-control" required>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Year of Passing <span class="text-danger">*</span></label>
              <input type="text" name="year_of_passing" class="form-control" required placeholder="e.g., 2020">
            </div>
            <div class="col-md-6">
              <label class="form-label">Percentage/CGPA <span class="text-danger">*</span></label>
              <input type="text" name="percentage_cgpa" class="form-control" required placeholder="e.g., 85% or 8.5">
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Certificate</label>
            <input type="file" name="certificate" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
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
  const modal = document.getElementById('qualificationModal');
  const form = document.getElementById('qualificationForm');
  const title = document.getElementById('qualificationModalTitle');
  const methodDiv = document.getElementById('qualificationMethod');
  
  modal.addEventListener('show.bs.modal', function(event) {
    const button = event.relatedTarget;
    const qualificationId = button?.getAttribute('data-qualification-id');
    
    if (qualificationId) {
      title.textContent = 'Edit Qualification';
      form.action = '{{ route("therapist.profile.qualification.update", ":id") }}'.replace(':id', qualificationId);
      methodDiv.innerHTML = '@method("PUT")';
      
      form.querySelector('[name="name_of_degree"]').value = button.getAttribute('data-name-of-degree') || '';
      form.querySelector('[name="degree_in"]').value = button.getAttribute('data-degree-in') || '';
      form.querySelector('[name="institute_university"]').value = button.getAttribute('data-institute') || '';
      form.querySelector('[name="year_of_passing"]').value = button.getAttribute('data-year') || '';
      form.querySelector('[name="percentage_cgpa"]').value = button.getAttribute('data-percentage') || '';
    } else {
      title.textContent = 'Add Qualification';
      form.action = '{{ route("therapist.profile.qualification.store") }}';
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
