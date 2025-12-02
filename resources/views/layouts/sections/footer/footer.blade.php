@php
$containerFooter = !empty($containerNav) ? $containerNav : 'container-fluid';
@endphp

<!-- Footer -->
<footer class="content-footer footer bg-footer-theme">
  <div class="{{ $containerFooter }}">
    <div class="footer-container d-flex align-items-center justify-content-center py-4">
      <div class="text-body">
        © <script>document.write(new Date().getFullYear())</script> {{ config('variables.templateName', 'Therapist') }}. All rights reserved.
      </div>
    </div>
  </div>
</footer>
<!--/ Footer -->
