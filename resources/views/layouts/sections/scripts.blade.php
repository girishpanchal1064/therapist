
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

<!-- END: Theme JS-->
<!-- Pricing Modal JS-->
@stack('pricing-script')
<!-- END: Pricing Modal JS-->
<!-- BEGIN: Page JS-->
@yield('page-script')
<!-- END: Page JS-->

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- SweetAlert — Apni / Materio theme -->
<style>
.swal2-actions {
    gap: 12px !important;
    margin-top: 1.5rem !important;
}
.swal2-actions button {
    margin: 0 !important;
    min-width: 120px;
    border-radius: 10px !important;
    font-weight: 600;
    padding: 0.5rem 1.25rem;
}

.apni-swal-popup.swal2-popup {
    font-family: var(--apni-font-body, 'Plus Jakarta Sans', sans-serif);
    border-radius: 16px;
    padding: 2rem 1.75rem 1.5rem;
    box-shadow: var(--apni-shadow-gulf-10, 0 12px 32px rgb(4 28 84 / 0.1));
    border: none;
}

.apni-swal-title.swal2-title {
    font-family: var(--apni-font-display, 'Sora', sans-serif);
    font-weight: 700;
    font-size: 1.375rem;
    color: var(--apni-gulf-blue, #041c54);
    padding: 0.5rem 0 0;
}

.apni-swal-text.swal2-html-container,
.apni-swal-text.swal2-content {
    font-family: var(--apni-font-body, 'Plus Jakarta Sans', sans-serif);
    font-size: 0.9375rem;
    color: var(--apni-bermuda-gray, #7484a4);
    line-height: 1.5;
}

.swal2-icon.swal2-success {
    border-color: var(--apni-success, #10b981);
    color: var(--apni-success, #10b981);
}
.swal2-icon.swal2-success .swal2-success-ring {
    border-color: var(--apni-success-soft, #10b98115);
}
.swal2-icon.swal2-success [class^='swal2-success-line'] {
    background-color: var(--apni-success, #10b981);
}

.swal2-icon.swal2-error {
    border-color: var(--apni-danger, #ef4444);
    color: var(--apni-danger, #ef4444);
}
.swal2-icon.swal2-error [class^='swal2-x-mark-line'] {
    background-color: var(--apni-danger, #ef4444);
}

.swal2-icon.swal2-warning {
    border-color: var(--apni-warning, #f59e0b);
    color: var(--apni-warning, #f59e0b);
}

.swal2-icon.swal2-info {
    border-color: var(--apni-info, #3b82f6);
    color: var(--apni-info, #3b82f6);
}

.swal2-timer-progress-bar {
    background: var(--apni-gulf-blue, #041c54);
}

.swal2-container.swal2-backdrop-show {
    background: rgb(4 28 84 / 0.35);
}
</style>

<!-- Global SweetAlert Helper -->
<script>
window.ApniSwal = {
    base: {
        buttonsStyling: false,
        customClass: {
            popup: 'apni-swal-popup',
            title: 'apni-swal-title',
            htmlContainer: 'apni-swal-text',
            actions: 'swal2-actions',
        },
    },

    merge(options) {
        const customClass = {
            ...this.base.customClass,
            ...(options.customClass || {}),
        };
        return { ...this.base, ...options, customClass };
    },

    fire(options) {
        return Swal.fire(this.merge(options));
    },

    success(title, text, timer) {
        return this.fire({
            icon: 'success',
            title: title || 'Success!',
            text: text || 'Operation completed successfully.',
            confirmButtonText: 'OK',
            customClass: { confirmButton: 'btn btn-primary' },
            timer: timer ?? 3000,
            timerProgressBar: timer !== false,
        });
    },

    error(title, text) {
        return this.fire({
            icon: 'error',
            title: title || 'Error!',
            text: text || 'Something went wrong!',
            confirmButtonText: 'OK',
            customClass: { confirmButton: 'btn btn-danger' },
        });
    },

    warning(title, text) {
        return this.fire({
            icon: 'warning',
            title: title || 'Warning!',
            text: text || '',
            confirmButtonText: 'OK',
            customClass: { confirmButton: 'btn btn-warning' },
        });
    },

    info(title, text) {
        return this.fire({
            icon: 'info',
            title: title || 'Information',
            text: text || '',
            confirmButtonText: 'OK',
            customClass: { confirmButton: 'btn btn-primary' },
        });
    },

    confirm(options) {
        return this.fire({
            icon: 'warning',
            showCancelButton: true,
            reverseButtons: true,
            confirmButtonText: 'Confirm',
            cancelButtonText: 'Cancel',
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-secondary',
            },
            ...options,
        });
    },
};

function showSuccess(title, text, timer) {
    return ApniSwal.success(title, text, timer);
}

function showError(title, text) {
    return ApniSwal.error(title, text);
}

function confirmDelete(title, text, confirmText, cancelText) {
    return ApniSwal.confirm({
        title: title || 'Are you sure?',
        text: text || 'You won\'t be able to revert this!',
        confirmButtonText: confirmText || 'Yes, delete it!',
        cancelButtonText: cancelText || 'Cancel',
    });
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formElement = this;
            const button = formElement.querySelector('button[type="submit"]');
            const title = button?.dataset?.title || 'Are you sure?';
            const text = button?.dataset?.text || 'You won\'t be able to revert this!';
            const confirmText = button?.dataset?.confirmText || 'Yes, delete it!';
            const cancelText = button?.dataset?.cancelText || 'Cancel';

            confirmDelete(title, text, confirmText, cancelText).then((result) => {
                if (result.isConfirmed) {
                    formElement.submit();
                }
            });
        });
    });

    @if(session('success'))
        ApniSwal.success('Success!', @json(session('success')));
    @endif

    @if(session('error'))
        ApniSwal.error('Error!', @json(session('error')));
    @endif

    @if(session('warning'))
        ApniSwal.warning('Warning!', @json(session('warning')));
    @endif

    @if(session('info'))
        ApniSwal.info('Information', @json(session('info')));
    @endif
});
</script>

<!-- END: Theme JS-->
<!-- Pricing Modal JS-->
@stack('pricing-script')
<!-- END: Pricing Modal JS-->
<!-- BEGIN: Page JS-->
@yield('page-script')
<!-- END: Page JS-->
