<div>
  <h5 class="mb-4">Specializations</h5>

  <p class="text-muted mb-4">Select all specializations that match your practice. You can update these anytime.</p>

  <form action="{{ route('therapist.profile.specializations.update') }}" method="POST">
    @csrf

    <div class="row g-3">
      @forelse($specializations ?? [] as $specialization)
        <div class="col-md-6">
          <label class="d-flex align-items-start gap-2 border rounded-3 p-3 h-100 cursor-pointer">
            <input
              type="checkbox"
              class="form-check-input mt-1"
              name="specializations[]"
              value="{{ $specialization->id }}"
              {{ in_array($specialization->id, $selectedSpecializations ?? []) ? 'checked' : '' }}
            >
            <span>
              <strong class="d-block">
                @if($specialization->icon)
                  <i class="{{ $specialization->icon }} me-1"></i>
                @endif
                {{ $specialization->name }}
              </strong>
              <small class="text-muted">{{ $specialization->description ?: 'No description available.' }}</small>
            </span>
          </label>
        </div>
      @empty
        <div class="col-12 text-muted">No specializations available right now.</div>
      @endforelse
    </div>

    @error('specializations')
      <div class="text-danger small mt-2">{{ $message }}</div>
    @enderror

    <div class="mt-4">
      <button type="submit" class="btn btn-primary">
        <i class="ri-save-line me-1"></i> Save Specializations
      </button>
    </div>
  </form>
</div>
