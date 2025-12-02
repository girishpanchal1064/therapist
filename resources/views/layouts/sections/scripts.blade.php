
@vite([
  'resources/assets/vendor/libs/jquery/jquery.js',
  'resources/assets/vendor/libs/popper/popper.js',
  'resources/assets/vendor/js/bootstrap.js',
  'resources/assets/vendor/libs/node-waves/node-waves.js',
  'resources/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js',
  'resources/assets/vendor/js/menu.js'
])

@yield('vendor-script')
<!-- END: Page Vendor JS-->
<!-- BEGIN: Theme JS-->
@vite(['resources/assets/js/main.js'])

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- SweetAlert Custom Styles -->
<style>
.swal2-actions {
    gap: 12px !important;
    margin-top: 1.5rem !important;
}
.swal2-actions button {
    margin: 0 !important;
    min-width: 120px;
}
</style>

<!-- Global SweetAlert Helper -->
<script>
// Global SweetAlert delete confirmation
document.addEventListener('DOMContentLoaded', function() {
    // Handle delete forms
    document.querySelectorAll('.delete-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formElement = this;
            const button = formElement.querySelector('button[type="submit"]');
            const title = button?.dataset?.title || 'Are you sure?';
            const text = button?.dataset?.text || 'You won\'t be able to revert this!';
            const confirmText = button?.dataset?.confirmText || 'Yes, delete it!';
            const cancelText = button?.dataset?.cancelText || 'Cancel';

            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: confirmText,
                cancelButtonText: cancelText,
                reverseButtons: true,
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary',
                    actions: 'swal2-actions'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    formElement.submit();
                }
            });
        });
    });

    // Show success/error messages from session
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#28a745',
            confirmButtonText: 'OK',
            timer: 3000,
            timerProgressBar: true
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'OK'
        });
    @endif

    @if(session('warning'))
        Swal.fire({
            icon: 'warning',
            title: 'Warning!',
            text: '{{ session('warning') }}',
            confirmButtonColor: '#ffc107',
            confirmButtonText: 'OK'
        });
    @endif

    @if(session('info'))
        Swal.fire({
            icon: 'info',
            title: 'Information',
            text: '{{ session('info') }}',
            confirmButtonColor: '#17a2b8',
            confirmButtonText: 'OK'
        });
    @endif
});

// Helper function for delete confirmation
function confirmDelete(title, text, confirmText, cancelText) {
    return Swal.fire({
        title: title || 'Are you sure?',
        text: text || 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: confirmText || 'Yes, delete it!',
        cancelButtonText: cancelText || 'Cancel',
        reverseButtons: true,
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-secondary',
            actions: 'swal2-actions'
        },
        buttonsStyling: false
    });
}

// Helper function for success message
function showSuccess(title, text, timer) {
    Swal.fire({
        icon: 'success',
        title: title || 'Success!',
        text: text || 'Operation completed successfully.',
        confirmButtonColor: '#28a745',
        confirmButtonText: 'OK',
        timer: timer || 3000,
        timerProgressBar: true
    });
}

// Helper function for error message
function showError(title, text) {
    Swal.fire({
        icon: 'error',
        title: title || 'Error!',
        text: text || 'Something went wrong!',
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'OK'
    });
}
</script>

<!-- END: Theme JS-->
<!-- Pricing Modal JS-->
@stack('pricing-script')
<!-- END: Pricing Modal JS-->
<!-- BEGIN: Page JS-->
@yield('page-script')
<!-- END: Page JS-->
