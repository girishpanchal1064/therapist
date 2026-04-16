  .layout-page .content-wrapper {
    background: linear-gradient(to bottom, #fff, rgba(186, 194, 210, 0.05)) !important;
  }

  .page-header {
    background: linear-gradient(90deg, #041C54 0%, #2f4a76 55%, #647494 100%);
    border-radius: 24px;
    padding: 2rem;
    margin-top: 1.5rem;
    margin-bottom: 1.5rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 18px rgba(4, 28, 84, 0.28);
  }

  .page-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 400px;
    height: 400px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
  }

  .page-header h4 {
    color: white;
    font-weight: 700;
    margin-bottom: 0.5rem;
    position: relative;
    z-index: 1;
  }

  .page-header p {
    color: rgba(255, 255, 255, 0.85);
    margin-bottom: 0;
    position: relative;
    z-index: 1;
  }

  .header-icon {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    color: white;
    backdrop-filter: blur(10px);
  }

  .form-card {
    border: 1px solid rgba(186, 194, 210, 0.35);
    border-radius: 16px;
    box-shadow: 0 10px 15px rgba(4, 28, 84, 0.05), 0 4px 6px rgba(4, 28, 84, 0.05);
    overflow: hidden;
    margin-bottom: 1.5rem;
  }

  .form-card .card-header {
    background: linear-gradient(135deg, #f8fafc 0%, #eef2f7 100%);
    border-bottom: 1px solid rgba(186, 194, 210, 0.35);
    padding: 1.25rem 1.5rem;
  }

  .form-card .card-header h6 {
    font-weight: 700;
    color: #041C54;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1rem;
  }

  .form-card .card-header .header-icon-sm {
    width: 32px;
    height: 32px;
    background: linear-gradient(90deg, #041C54 0%, #647494 100%);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
  }

  .form-card .card-body {
    padding: 1.5rem;
  }

  .form-card .card-body > .row {
    margin-top: 20px;
  }

  .form-card .card-body > .row:first-child {
    margin-top: 0;
  }

  .form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
  }

  .form-control, .form-select {
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    padding: 0.625rem 1rem;
    transition: all 0.2s ease;
    font-size: 0.9375rem;
    background: #ffffff;
  }

  .form-control:focus, .form-select:focus {
    border-color: #647494;
    box-shadow: 0 0 0 3px rgba(100, 116, 148, 0.12);
    outline: none;
  }

  .form-control.is-invalid, .form-select.is-invalid {
    border-color: #ef4444;
    background: #fef2f2;
  }

  .form-text {
    color: #64748b;
    font-size: 0.8125rem;
    margin-top: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.375rem;
  }

  .invalid-feedback {
    display: block;
    color: #ef4444;
    font-size: 0.8125rem;
    margin-top: 0.375rem;
  }

  .action-buttons-wrapper {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    padding-top: 1.5rem;
    margin-top: 1.5rem;
    border-top: 2px solid #f0f2f5;
    flex-wrap: wrap;
  }

  .btn-cancel {
    background: white;
    border: 2px solid #e2e8f0;
    color: #64748b;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
  }

  .btn-cancel:hover {
    border-color: #cbd5e0;
    background: #f7fafc;
    color: #4a5568;
  }

  .btn-submit {
    background: linear-gradient(90deg, #041C54 0%, #647494 100%);
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 8px 14px rgba(4, 28, 84, 0.2);
  }

  .btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 18px rgba(4, 28, 84, 0.28);
    color: white;
  }

  .btn-submit:active {
    transform: translateY(0);
  }

  .alert-success {
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    border: 1px solid #86efac;
    color: #166534;
    border-radius: 12px;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
  }

  .alert-danger {
    background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
    border: 1px solid #fecaca;
    color: #991b1b;
    border-radius: 12px;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
  }

  .form-control[readonly] {
    background-color: #f8f9fa;
    cursor: not-allowed;
  }
