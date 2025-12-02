<div>
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">Bank Details</h5>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bankDetailModal">
      <i class="ri-add-line me-1"></i> Add Bank Detail
    </button>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered">
      <thead class="table-light">
        <tr>
          <th>Sr. No.</th>
          <th>Account Holder Name</th>
          <th>Account Number</th>
          <th>Bank Name</th>
          <th>IFSC Code</th>
          <th>Branch Name</th>
          <th>Account Type</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($bankDetails ?? [] as $index => $bankDetail)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $bankDetail->account_holder_name }}</td>
            <td>{{ $bankDetail->account_number }}</td>
            <td>{{ $bankDetail->bank_name }}</td>
            <td>{{ $bankDetail->ifsc_code }}</td>
            <td>{{ $bankDetail->branch_name ?? '-' }}</td>
            <td class="text-capitalize">{{ $bankDetail->account_type ?? '-' }}</td>
            <td>
              <button type="button" class="btn btn-sm btn-primary" 
                      data-bs-toggle="modal" 
                      data-bs-target="#bankDetailModal"
                      data-bank-detail-id="{{ $bankDetail->id }}"
                      data-account-holder="{{ $bankDetail->account_holder_name }}"
                      data-account-number="{{ $bankDetail->account_number }}"
                      data-bank-name="{{ $bankDetail->bank_name }}"
                      data-ifsc="{{ $bankDetail->ifsc_code }}"
                      data-branch="{{ $bankDetail->branch_name }}"
                      data-account-type="{{ $bankDetail->account_type }}">
                <i class="ri-edit-line"></i>
              </button>
              <form method="POST" action="{{ route('therapist.profile.bank-detail.delete', $bankDetail) }}" class="d-inline delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" data-title="Delete Bank Detail" data-text="Are you sure you want to delete this bank detail? This action cannot be undone." data-confirm-text="Yes, delete it!" data-cancel-text="Cancel">
                  <i class="ri-delete-bin-line"></i>
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="8" class="text-center text-muted">No bank details found. Click "Add Bank Detail" to add one.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Bank Detail Modal -->
<div class="modal fade" id="bankDetailModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="bankDetailModalTitle">Add Bank Detail</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="bankDetailForm" method="POST">
        @csrf
        <div id="bankDetailMethod"></div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Account Holder Name <span class="text-danger">*</span></label>
            <input type="text" name="account_holder_name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Account Number <span class="text-danger">*</span></label>
            <input type="text" name="account_number" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Bank Name <span class="text-danger">*</span></label>
            <input type="text" name="bank_name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">IFSC Code <span class="text-danger">*</span></label>
            <input type="text" name="ifsc_code" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Branch Name</label>
            <input type="text" name="branch_name" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">Account Type</label>
            <select name="account_type" class="form-select">
              <option value="savings">Savings</option>
              <option value="current">Current</option>
            </select>
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
  const modal = document.getElementById('bankDetailModal');
  const form = document.getElementById('bankDetailForm');
  const title = document.getElementById('bankDetailModalTitle');
  const methodDiv = document.getElementById('bankDetailMethod');
  
  modal.addEventListener('show.bs.modal', function(event) {
    const button = event.relatedTarget;
    const bankDetailId = button?.getAttribute('data-bank-detail-id');
    
    if (bankDetailId) {
      title.textContent = 'Edit Bank Detail';
      form.action = '{{ route("therapist.profile.bank-detail.update", ":id") }}'.replace(':id', bankDetailId);
      methodDiv.innerHTML = '@method("PUT")';
      
      form.querySelector('[name="account_holder_name"]').value = button.getAttribute('data-account-holder') || '';
      form.querySelector('[name="account_number"]').value = button.getAttribute('data-account-number') || '';
      form.querySelector('[name="bank_name"]').value = button.getAttribute('data-bank-name') || '';
      form.querySelector('[name="ifsc_code"]').value = button.getAttribute('data-ifsc') || '';
      form.querySelector('[name="branch_name"]').value = button.getAttribute('data-branch') || '';
      form.querySelector('[name="account_type"]').value = button.getAttribute('data-account-type') || 'savings';
    } else {
      title.textContent = 'Add Bank Detail';
      form.action = '{{ route("therapist.profile.bank-detail.store") }}';
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
