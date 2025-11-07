<div>
  <h5 class="mb-4">Specializations</h5>
  
  <p class="text-muted mb-4">Your specializations are managed by the administrator. Contact support if you need to update your specializations.</p>
  
  <div class="table-responsive">
    <table class="table table-bordered">
      <thead class="table-light">
        <tr>
          <th>Sr. No.</th>
          <th>Name</th>
          <th>Description</th>
          <th>Icon</th>
        </tr>
      </thead>
      <tbody>
        @forelse($specializations ?? [] as $index => $specialization)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>
              <div class="d-flex align-items-center">
                @if($specialization->icon)
                  <i class="{{ $specialization->icon }} me-2"></i>
                @endif
                <strong>{{ $specialization->name }}</strong>
              </div>
            </td>
            <td>{{ $specialization->description ?? '-' }}</td>
            <td>
              @if($specialization->icon)
                <i class="{{ $specialization->icon }}" style="font-size: 1.5rem;"></i>
              @else
                <span class="text-muted">No icon</span>
              @endif
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="text-center text-muted">No specializations assigned yet.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
