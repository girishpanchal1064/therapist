<div>
  <h5 class="mb-4">Area of Expertise</h5>
  
  <form action="{{ route('therapist.profile.areas-of-expertise.update') }}" method="POST">
    @csrf
    
    <div class="mb-4">
      <p class="text-muted">Select your areas of expertise. Selected areas will be highlighted.</p>
      <div class="d-flex flex-wrap gap-2" id="areas-container">
        @foreach($areasOfExpertise ?? [] as $area)
          <button type="button" 
                  class="btn area-tag-btn {{ in_array($area->id, $selectedAreas ?? []) ? 'btn-primary' : 'btn-outline-primary' }}"
                  data-area-id="{{ $area->id }}">
            @if($area->icon)
              <i class="{{ $area->icon }} me-1"></i>
            @endif
            {{ $area->name }}
          </button>
        @endforeach
      </div>
    </div>
    
    <input type="hidden" name="areas_of_expertise" id="selected-areas-input" value="{{ json_encode($selectedAreas ?? []) }}">
    
    <div class="mt-4">
      <button type="submit" class="btn btn-primary">
        <i class="ri-save-line me-1"></i> Save Changes
      </button>
    </div>
  </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const buttons = document.querySelectorAll('.area-tag-btn');
  const input = document.getElementById('selected-areas-input');
  let selectedAreas = JSON.parse(input.value || '[]');
  
  buttons.forEach(button => {
    button.addEventListener('click', function() {
      const areaId = parseInt(this.getAttribute('data-area-id'));
      const index = selectedAreas.indexOf(areaId);
      
      if (index > -1) {
        // Deselect
        selectedAreas.splice(index, 1);
        this.classList.remove('btn-primary');
        this.classList.add('btn-outline-primary');
      } else {
        // Select
        selectedAreas.push(areaId);
        this.classList.remove('btn-outline-primary');
        this.classList.add('btn-primary');
      }
      
      input.value = JSON.stringify(selectedAreas);
    });
  });
});
</script>

<style>
.area-tag-btn {
  transition: all 0.3s ease;
}
.area-tag-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
</style>
