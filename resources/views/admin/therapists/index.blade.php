@extends('layouts/contentNavbarLayout')

@section('title', 'Therapists Management')

@section('vendor-style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
@endsection

@section('vendor-script')
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
@endsection

@section('page-style')
<style>
  /* Page Header */
  .page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 14px;
    padding: 1.5rem 1.75rem;
    padding-top: 1.75rem;
    margin-top: 0;
    margin-bottom: 1.25rem;
    position: relative;
    overflow: hidden;
  }

  .page-header h4 {
    padding-top: 0;
    margin-top: 0;
  }

  .page-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 300px;
    height: 300px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
  }

  .page-header::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -10%;
    width: 150px;
    height: 150px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 50%;
  }

  .header-icon {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    backdrop-filter: blur(10px);
  }

  .page-header h4 {
    color: white;
    font-weight: 700;
    margin-bottom: 0.25rem;
    margin-top: 0;
    padding-top: 0;
    position: relative;
    z-index: 1;
    font-size: 1.35rem;
  }

  .page-header p {
    color: rgba(255, 255, 255, 0.85);
    margin-bottom: 0;
    position: relative;
    z-index: 1;
    font-size: 0.875rem;
  }

  .btn-add-new {
    background: rgba(255, 255, 255, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 0.6rem 1.25rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
  }

  .btn-add-new:hover {
    background: white;
    color: #667eea;
    border-color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 255, 255, 0.3);
  }

  /* Main Card */
  .main-card {
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    background: white;
  }

  .main-card .card-header {
    background: linear-gradient(135deg, #f8f9fc 0%, #eef1f6 100%);
    border-bottom: 2px solid #e2e8f0;
    padding: 1rem 1.25rem;
  }

  .main-card .card-header h5 {
    padding-top: 0;
    margin-top: 0;
  }

  .main-card .card-body {
    padding: 1.25rem;
  }

  /* Add Button */
  .btn-add {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    padding: 0.6rem 1.25rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.25);
  }

  .btn-add:active {
    box-shadow: 0 1px 4px rgba(102, 126, 234, 0.2);
  }

  /* Alert Styling */
  .alert-success {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    border: none;
    border-left: 5px solid #10b981;
    color: #065f46;
    border-radius: 14px;
    padding: 1rem 1.25rem;
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.1);
  }

  .alert-danger {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    border: none;
    border-left: 5px solid #ef4444;
    color: #991b1b;
    border-radius: 14px;
    padding: 1rem 1.25rem;
    box-shadow: 0 2px 8px rgba(239, 68, 68, 0.1);
  }

  /* Therapist Card - One Line Layout */
  .therapist-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
    overflow: hidden;
    position: relative;
    margin-top: 20px;
    margin-bottom: 0.5rem;
    border-left: 4px solid transparent;
  }

  .therapist-card:nth-child(even) {
    background: #fafbfc;
    border-left-color: #667eea;
  }

  .therapist-card:nth-child(odd) {
    border-left-color: #764ba2;
  }

  .therapist-card .card-body {
    padding: 0.75rem 1rem;
  }

  .therapist-card .row {
    margin: 0;
  }

  .therapist-card .col-lg-1,
  .therapist-card .col-lg-2,
  .therapist-card .col-md-1,
  .therapist-card .col-md-2,
  .therapist-card .col-md-3,
  .therapist-card .col-sm-1,
  .therapist-card .col-sm-2,
  .therapist-card .col-sm-3,
  .therapist-card .col-sm-4 {
    padding-left: 0.5rem;
    padding-right: 0.5rem;
    display: flex;
    align-items: center;
    overflow: hidden;
  }

  .therapist-card .row {
    flex-wrap: nowrap;
  }

  @media (max-width: 991px) {
    .therapist-card .row {
      flex-wrap: wrap;
    }
  }

  /* Therapist Avatar */
  .therapist-avatar {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    object-fit: cover;
    border: 2px solid #f0f2ff;
    box-shadow: 0 1px 3px rgba(102, 126, 234, 0.15);
    flex-shrink: 0;
  }

  .therapist-avatar-default {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    object-fit: cover;
    border: 2px solid #f0f2ff;
    box-shadow: 0 1px 3px rgba(102, 126, 234, 0.15);
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
    flex-shrink: 0;
  }

  .therapist-info {
    min-width: 0;
    flex: 1;
  }

  .therapist-info h6 {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0;
    font-size: 0.8rem;
    line-height: 1.2;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .therapist-info small {
    color: #6b7280;
    display: flex;
    align-items: center;
    gap: 0.2rem;
    font-size: 0.65rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .therapist-avatar-initials {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
  }

  /* Specialization Badge */
  .spec-badge {
    background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
    color: #0369a1;
    padding: 0.3rem 0.65rem;
    border-radius: 6px;
    font-size: 0.7rem;
    font-weight: 600;
    margin-right: 0.25rem;
    margin-bottom: 0.25rem;
    display: inline-block;
    border: 1px solid rgba(3, 105, 161, 0.1);
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .spec-badge:hover {
    background: linear-gradient(135deg, #bae6fd 0%, #7dd3fc 100%);
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(3, 105, 161, 0.2);
  }

  .spec-badge-wrapper {
    position: relative;
  }

  /* Experience Badge */
  .exp-badge {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    color: #1e40af;
    padding: 0.35rem 0.65rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    border: 1px solid rgba(30, 64, 175, 0.15);
    box-shadow: 0 1px 3px rgba(30, 64, 175, 0.1);
  }

  .exp-badge i {
    font-size: 0.9rem;
    color: #3b82f6;
  }

  /* Fee Badge */
  .fee-badge {
    background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
    color: #166534;
    padding: 0.35rem 0.65rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    border: 1px solid rgba(22, 101, 52, 0.15);
    box-shadow: 0 1px 3px rgba(22, 101, 52, 0.1);
  }

  .fee-badge i {
    font-size: 0.9rem;
    color: #22c55e;
  }

  /* Not Set Badge */
  .not-set-badge {
    background: #f3f4f6;
    color: #6b7280;
    padding: 0.4rem 0.75rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 500;
    font-style: italic;
  }

  /* Status Badge */
  .status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.35rem 0.75rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    box-shadow: 0 1px 2px rgba(0,0,0,0.08);
  }

  .status-badge.active {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
  }

  .status-badge.suspended {
    background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
    color: #991b1b;
  }

  .status-badge.inactive {
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
    color: #4b5563;
  }

  /* Modern Action Buttons */
  .action-btns {
    display: flex;
    gap: 0.5rem;
    align-items: center;
  }

  .action-btn {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 0.85rem;
    box-shadow: 0 1px 2px rgba(0,0,0,0.08);
    text-decoration: none;
  }

  .action-btn.view {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    color: #1d4ed8;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.15);
  }

  .action-btn.view:active {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.25);
  }

  .action-btn.edit {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #b45309;
    box-shadow: 0 2px 8px rgba(245, 158, 11, 0.15);
  }

  .action-btn.edit:active {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
    box-shadow: 0 2px 8px rgba(245, 158, 11, 0.25);
  }

  .action-btn.delete {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #dc2626;
    box-shadow: 0 2px 8px rgba(239, 68, 68, 0.15);
  }

  .action-btn.delete:active {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    box-shadow: 0 2px 8px rgba(239, 68, 68, 0.25);
  }

  .btn-action {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 0.85rem;
    box-shadow: 0 1px 2px rgba(0,0,0,0.08);
    text-decoration: none;
  }

  .btn-action:active {
    transform: translateY(0);
  }

  .btn-action.view {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    color: #1d4ed8;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.15);
  }

  .btn-action.view:active {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.25);
  }

  .btn-action.edit {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #b45309;
    box-shadow: 0 2px 8px rgba(245, 158, 11, 0.15);
  }

  .btn-action.edit:active {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
    box-shadow: 0 2px 8px rgba(245, 158, 11, 0.25);
  }

  .btn-action.delete {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #dc2626;
    box-shadow: 0 2px 8px rgba(239, 68, 68, 0.15);
  }

  .btn-action.delete:active {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    box-shadow: 0 2px 8px rgba(239, 68, 68, 0.25);
  }

  /* Action Dropdown - Fallback */
  .action-dropdown .dropdown-toggle {
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
    border: none;
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
  }

  .action-dropdown .dropdown-toggle:active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
  }

  .action-dropdown .dropdown-menu {
    border: none;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    border-radius: 12px;
    padding: 0.5rem;
    min-width: 180px;
  }

  .action-dropdown .dropdown-item {
    border-radius: 8px;
    padding: 0.625rem 1rem;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s ease;
  }

  .action-dropdown .dropdown-item:active {
    background: #f1f5f9;
  }

  .action-dropdown .dropdown-item.text-danger:active {
    background: #fef2f2;
  }

  /* Filter Card */
  .filter-card {
    border-radius: 16px;
    border: 1px solid #e9ecef;
    background: white;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
    margin-bottom: 1.5rem;
    display: block !important;
    visibility: visible !important;
  }

  .filter-card .card-body {
    padding: 24px;
  }

  .filter-card .filter-title {
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    cursor: pointer;
    padding-bottom: 16px;
    border-bottom: 1px solid #e9ecef;
    margin-bottom: 20px;
  }

  .filter-icon-wrapper {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    font-size: 1rem;
  }

  .btn-filter-toggle {
    background: transparent;
    border: 2px solid #e4e6eb;
    border-radius: 8px;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #667eea;
    transition: all 0.3s ease;
    cursor: pointer;
  }

  .btn-filter-toggle:hover {
    background: rgba(102, 126, 234, 0.1);
    border-color: #667eea;
  }

  .btn-filter-toggle i {
    font-size: 1.2rem;
    transition: transform 0.3s ease;
  }

  .btn-filter-toggle.active i {
    transform: rotate(180deg);
  }

  .filter-content {
    overflow: hidden;
    transition: all 0.3s ease;
  }

  .filter-content.collapsed {
    max-height: 0;
    margin-top: 0;
    opacity: 0;
    padding-top: 0;
    overflow: hidden;
  }

  .filter-content:not(.collapsed) {
    max-height: 1000px;
    opacity: 1;
    overflow: visible;
  }

  .filter-content {
    max-height: 1000px;
    opacity: 1;
  }

  .filter-card .form-label {
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
    color: #8e9baa;
    margin-bottom: 6px;
  }

  .filter-card .form-control,
  .filter-card .form-select {
    border-radius: 10px;
    border: 1px solid #e4e6eb;
    padding: 10px 14px;
    transition: all 0.2s ease;
  }

  .filter-card .form-control:focus,
  .filter-card .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
  }

  .filter-card .input-group-merge .input-group-text {
    background: #f8f9fc;
    border: 1px solid #e4e6eb;
    border-right: none;
    border-radius: 10px 0 0 10px;
    color: #667eea;
  }

  .filter-card .input-group-merge .form-control {
    border-left: none;
    border-radius: 0 10px 10px 0;
  }

  .filter-card .input-group-merge .form-control:focus {
    border-left: 1px solid #667eea;
  }

  .btn-apply-filter {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    padding: 10px 24px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
  }

  .btn-apply-filter:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    color: white;
  }

  .btn-clear-filter {
    background: #f1f5f9;
    border: 2px solid #e4e6eb;
    color: #475569;
    padding: 8px 16px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.875rem;
    transition: all 0.2s ease;
  }

  .btn-clear-filter:hover {
    background: #e2e8f0;
    border-color: #cbd5e1;
    color: #334155;
  }

  /* Detail Item */
  .detail-item {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    margin: 0;
    background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
    border-radius: 6px;
    border: 1px solid rgba(102, 126, 234, 0.1);
    font-size: 0.75rem;
    font-weight: 600;
    color: #1f2937;
    white-space: nowrap;
    width: 100%;
    min-width: 0;
  }

  .detail-icon {
    width: 20px;
    height: 20px;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    font-size: 0.65rem;
    flex-shrink: 0;
    box-shadow: 0 1px 2px rgba(102, 126, 234, 0.2);
  }

  .detail-text {
    font-weight: 600;
    color: #1f2937;
    font-size: 0.75rem;
    line-height: 1.2;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    flex: 1;
    min-width: 0;
  }

  /* Pagination */
  .pagination {
    gap: 0.25rem;
  }

  .page-link {
    border: none;
    border-radius: 8px !important;
    padding: 0.5rem 0.875rem;
    color: #4a5568;
    transition: all 0.2s ease;
  }

  .page-link:active {
    background: #f1f5f9;
    color: #667eea;
  }

  .page-item.active .page-link {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
  }

  /* Modal Styling */
  .modal-specializations .modal-content {
    border-radius: 14px;
    border: none;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
  }

  .modal-specializations .modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 14px 14px 0 0;
    border-bottom: none;
    padding: 1.25rem 1.5rem;
  }

  .modal-specializations .modal-body {
    padding: 1.5rem;
  }

  .spec-list-item {
    padding: 0.75rem 1rem;
    background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
    border-radius: 8px;
    margin-bottom: 0.5rem;
    color: #0369a1;
    font-weight: 600;
    font-size: 0.875rem;
    border: 1px solid rgba(3, 105, 161, 0.1);
  }

  /* Responsive */
  @media (max-width: 768px) {
    .page-header {
      padding: 1.5rem;
    }

    .main-card .card-header {
      flex-direction: column;
      gap: 1rem;
    }
  }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 position-relative" style="z-index: 1;">
    <div class="d-flex align-items-center gap-3">
      <div class="header-icon">
        <i class="ri-user-heart-line"></i>
      </div>
      <div style="padding-top: 0;">
        <h4 class="mb-1" style="padding-top: 0; margin-top: 0;">Therapists Management</h4>
        <p class="mb-0">Manage therapist profiles, specializations and availability</p>
      </div>
    </div>
    <a href="{{ route('admin.therapists.create') }}" class="btn btn-add-new">
      <i class="ri-add-circle-line me-2"></i>Add New Therapist
    </a>
  </div>
</div>

<!-- Summary Card -->
@if($therapists->count() > 0)
  @php
    $totalTherapists = $therapists->total();
    $activeCount = $therapists->where('status', 'active')->count();
    $verifiedCount = $therapists->filter(function($t) { return $t->therapistProfile && $t->therapistProfile->is_verified; })->count();
  @endphp
  <div class="card mb-3" style="background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%); border: 1px solid rgba(102, 126, 234, 0.2); border-radius: 14px; box-shadow: 0 2px 8px rgba(102, 126, 234, 0.1);">
    <div class="card-body" style="padding: 1rem 1.25rem;">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div class="d-flex align-items-center" style="gap: 1rem;">
          <div style="width: 48px; height: 48px; background: rgba(102, 126, 234, 0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
            <i class="ri-user-heart-line text-primary" style="font-size: 1.25rem;"></i>
          </div>
          <div>
            <div class="text-muted" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Total Therapists</div>
            <div class="text-dark fw-bold" style="font-size: 1.5rem; line-height: 1;">{{ $totalTherapists }}</div>
          </div>
        </div>
        <div class="d-flex align-items-center" style="gap: 0.75rem;">
          <span class="badge bg-success" style="font-size: 0.75rem; padding: 0.5rem 0.875rem; border-radius: 10px; font-weight: 600; box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);">
            <i class="ri-checkbox-circle-line me-1"></i>{{ $activeCount }} Active
          </span>
          <span class="badge bg-primary" style="font-size: 0.75rem; padding: 0.5rem 0.875rem; border-radius: 10px; font-weight: 600; box-shadow: 0 2px 4px rgba(102, 126, 234, 0.2);">
            <i class="ri-verified-badge-line me-1"></i>{{ $verifiedCount }} Verified
          </span>
        </div>
      </div>
    </div>
  </div>
@endif

<!-- Filters Card -->
<div class="card filter-card mb-4">
  <div class="card-body">
    <div class="filter-title mb-3">
      <div class="d-flex align-items-center gap-2">
        <div class="filter-icon-wrapper">
          <i class="ri-filter-3-line"></i>
        </div>
        <span>Filter & Search</span>
      </div>
      <button type="button" class="btn-filter-toggle" onclick="toggleFilterSection()">
        <i class="ri-arrow-down-s-line" id="filterToggleIcon"></i>
      </button>
    </div>
    <div class="filter-content" id="filterContent">
      <form method="GET" action="{{ route('admin.therapists.index') }}" id="filterForm">
        <div class="row g-3 align-items-end">
          <!-- Search -->
          <div class="col-md-4">
            <label for="search_name" class="form-label">Search</label>
            <div class="input-group input-group-merge">
              <span class="input-group-text"><i class="ri-search-line"></i></span>
              <input type="text" class="form-control" id="search_name" name="search_name" 
                     value="{{ request('search_name') }}" placeholder="Name or email...">
            </div>
          </div>

          <!-- Specialization Filter -->
          <div class="col-md-3">
            <label for="search_specialization" class="form-label">Specialization</label>
            <select class="form-select" id="search_specialization" name="search_specialization">
              <option value="">All Specializations</option>
              @foreach($specializations ?? [] as $spec)
                <option value="{{ $spec->id }}" {{ request('search_specialization') == $spec->id ? 'selected' : '' }}>
                  {{ $spec->name }}
                </option>
              @endforeach
            </select>
          </div>

          <!-- Status Filter -->
          <div class="col-md-3">
            <label for="search_status" class="form-label">Status</label>
            <select class="form-select" id="search_status" name="search_status">
              <option value="">All Status</option>
              <option value="active" {{ request('search_status') == 'active' ? 'selected' : '' }}>Active</option>
              <option value="inactive" {{ request('search_status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
              <option value="suspended" {{ request('search_status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
            </select>
          </div>

          <!-- Action Buttons -->
          <div class="col-md-2">
            <button type="submit" class="btn btn-apply-filter w-100">
              <i class="ri-search-line me-1"></i>Apply
            </button>
          </div>
        </div>

        @if(request()->hasAny(['search_name', 'search_specialization', 'search_status']))
          <div class="mt-3 pt-3 border-top">
            <a href="{{ route('admin.therapists.index') }}" class="btn btn-clear-filter">
              <i class="ri-close-line me-1"></i>Clear Filters
            </a>
          </div>
        @endif
      </form>
    </div>
  </div>
</div>

<!-- Main Card -->
<div class="card main-card">
  <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div style="padding-top: 0;">
      <h5 class="mb-1" style="padding-top: 0; margin-top: 0;"><i class="ri-list-check me-2"></i>All Therapists</h5>
      <p class="text-muted mb-0 small">{{ $therapists->total() }} total therapists found</p>
    </div>
  </div>
  <div class="card-body">
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="ri-checkbox-circle-line me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="ri-error-warning-line me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <!-- Therapists List -->
    @if($therapists->count() > 0)
      @foreach($therapists as $therapist)
        <div class="card therapist-card">
          <div class="card-body">
            <div class="row align-items-center g-2" style="margin: 0;">
              <!-- Avatar & Name -->
              <div class="col-lg-2 col-md-3 col-sm-4 mb-0">
                <div class="d-flex align-items-center" style="gap: 0.6rem;">
                  @if($therapist->therapistProfile && $therapist->therapistProfile->profile_image)
                    <img src="{{ asset('storage/' . $therapist->therapistProfile->profile_image) }}" alt="Avatar" class="therapist-avatar">
                  @elseif($therapist->avatar)
                    <img src="{{ asset('storage/' . $therapist->avatar) }}" alt="Avatar" class="therapist-avatar">
                  @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($therapist->name) }}&background=667eea&color=fff&size=80&bold=true&format=svg" alt="Avatar" class="therapist-avatar-default">
                  @endif
                  <div class="therapist-info" style="min-width: 0; flex: 1;">
                    <h6 style="margin: 0; font-size: 0.85rem; font-weight: 600; color: #1f2937; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $therapist->name }}</h6>
                    <small style="font-size: 0.7rem; color: #6b7280; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block;"><i class="ri-mail-line"></i>{{ Str::limit($therapist->email, 22) }}</small>
                  </div>
                </div>
              </div>

              <!-- Contact Info -->
              <div class="col-lg-2 col-md-2 col-sm-3 mb-0" style="min-width: 120px;">
                <div class="detail-item" style="padding: 0.3rem 0.5rem; margin: 0; width: 100%;">
                  <div class="detail-icon" style="width: 18px; height: 18px; font-size: 0.6rem; flex-shrink: 0;"><i class="ri-phone-line"></i></div>
                  <span class="detail-text" style="font-size: 0.7rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block;">{{ $therapist->phone ?: '-' }}</span>
                </div>
              </div>

              <!-- Specializations -->
              <div class="col-lg-2 col-md-2 col-sm-3 mb-0" style="min-width: 150px;">
                @if($therapist->therapistProfile && $therapist->therapistProfile->specializations->count() > 0)
                  <div class="spec-badge-wrapper" style="display: flex; flex-wrap: wrap; gap: 0.25rem; width: 100%;">
                    @foreach($therapist->therapistProfile->specializations->take(1) as $specialization)
                      <span class="spec-badge" data-bs-toggle="modal" data-bs-target="#specializationsModal{{ $therapist->id }}" style="font-size: 0.65rem; padding: 0.25rem 0.5rem; cursor: pointer; white-space: nowrap; max-width: 100%; overflow: hidden; text-overflow: ellipsis;">
                        {{ Str::limit($specialization->name, 18) }}
                      </span>
                    @endforeach
                    @if($therapist->therapistProfile->specializations->count() > 1)
                      <span class="spec-badge" data-bs-toggle="modal" data-bs-target="#specializationsModal{{ $therapist->id }}" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-size: 0.65rem; padding: 0.25rem 0.5rem; cursor: pointer; white-space: nowrap; flex-shrink: 0;">
                        +{{ $therapist->therapistProfile->specializations->count() - 1 }}
                      </span>
                    @endif
                  </div>
                @else
                  <span class="text-muted" style="font-size: 0.7rem;">-</span>
                @endif
              </div>

              <!-- Experience -->
              <div class="col-lg-1 col-md-1 col-sm-2 mb-0">
                @if($therapist->therapistProfile && $therapist->therapistProfile->experience_years)
                  <span class="exp-badge" style="font-size: 0.7rem; padding: 0.3rem 0.5rem; white-space: nowrap;">
                    <i class="ri-award-line" style="font-size: 0.7rem;"></i>{{ $therapist->therapistProfile->experience_years }}Y
                  </span>
                @else
                  <span class="text-muted" style="font-size: 0.7rem;">-</span>
                @endif
              </div>

              <!-- Fee -->
              <div class="col-lg-1 col-md-1 col-sm-2 mb-0">
                @if($therapist->therapistProfile && $therapist->therapistProfile->consultation_fee)
                  <span class="fee-badge" style="font-size: 0.7rem; padding: 0.3rem 0.5rem; white-space: nowrap;">
                    <i class="ri-money-rupee-circle-line" style="font-size: 0.7rem;"></i>₹{{ number_format($therapist->therapistProfile->consultation_fee, 0) }}
                  </span>
                @else
                  <span class="text-muted" style="font-size: 0.7rem;">-</span>
                @endif
              </div>

              <!-- Status -->
              <div class="col-lg-1 col-md-1 col-sm-2 mb-0">
                <span class="status-badge {{ $therapist->status ?? 'inactive' }}" style="font-size: 0.7rem; padding: 0.3rem 0.6rem; white-space: nowrap;">
                  {{ ucfirst($therapist->status ?: 'inactive') }}
                </span>
              </div>

              <!-- Created Date -->
              <div class="col-lg-1 col-md-1 col-sm-2 mb-0">
                <small class="text-muted" style="font-size: 0.7rem; white-space: nowrap;">
                  {{ $therapist->created_at->format('M d, Y') }}
                </small>
              </div>

              <!-- Actions -->
              <div class="col-lg-2 col-md-1 col-sm-2 mb-0">
                <div class="d-flex align-items-center justify-content-lg-end justify-content-start" style="gap: 0.35rem;">
                  <a href="{{ route('admin.therapists.show', $therapist) }}" class="action-btn view" title="View Profile" style="width: 30px; height: 30px; font-size: 0.85rem;">
                    <i class="ri-eye-line"></i>
                  </a>
                  <a href="{{ route('admin.therapists.edit', $therapist) }}" class="action-btn edit" title="Edit" style="width: 30px; height: 30px; font-size: 0.85rem;">
                    <i class="ri-pencil-line"></i>
                  </a>
                  <form action="{{ route('admin.therapists.destroy', $therapist) }}" method="POST" class="d-inline delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="action-btn delete" title="Delete" style="width: 30px; height: 30px; font-size: 0.85rem;" data-title="Delete Therapist" data-text="Are you sure you want to delete this therapist? This action cannot be undone." data-confirm-text="Yes, delete it!" data-cancel-text="Cancel">
                      <i class="ri-delete-bin-line"></i>
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Specializations Modal -->
        <div class="modal fade modal-specializations" id="specializationsModal{{ $therapist->id }}" tabindex="-1" aria-labelledby="specializationsModalLabel{{ $therapist->id }}" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="specializationsModalLabel{{ $therapist->id }}">
                  <i class="ri-user-heart-line me-2"></i>{{ $therapist->name }}'s Specializations
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                @if($therapist->therapistProfile && $therapist->therapistProfile->specializations->count() > 0)
                  @foreach($therapist->therapistProfile->specializations as $specialization)
                    <div class="spec-list-item">
                      <i class="ri-checkbox-circle-line me-2"></i>{{ $specialization->name }}
                    </div>
                  @endforeach
                @else
                  <p class="text-muted mb-0">No specializations assigned.</p>
                @endif
              </div>
            </div>
          </div>
        </div>
      @endforeach
    @else
      <div class="text-center py-5">
        <i class="ri-user-search-line" style="font-size: 3rem; color: #cbd5e1;"></i>
        <p class="text-muted mt-3 mb-0">No therapists found matching your criteria.</p>
      </div>
    @endif

    <!-- Pagination -->
    @if($therapists->hasPages())
      <div class="d-flex justify-content-center mt-4 mb-2">
        {{ $therapists->links() }}
      </div>
    @endif
  </div>
</div>
@endsection

@section('page-script')
<script>
function toggleFilterSection() {
    const content = document.getElementById('filterContent');
    const toggle = document.querySelector('.btn-filter-toggle');
    const icon = document.getElementById('filterToggleIcon');
    
    if (content) {
        content.classList.toggle('collapsed');
    }
    if (toggle) {
        toggle.classList.toggle('active');
    }
}

$(document).ready(function() {
    // Auto-submit form on filter change (optional - can be removed if you want manual apply)
    // $('#search_specialization, #search_status').on('change', function() {
    //     $(this).closest('form').submit();
    // });

    // Delete confirmation
    $('.delete-form').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const button = form.find('button[type="submit"]');
        const title = button.data('title') || 'Confirm Delete';
        const text = button.data('text') || 'Are you sure?';
        const confirmText = button.data('confirm-text') || 'Yes, delete it!';
        const cancelText = button.data('cancel-text') || 'Cancel';

        if (confirm(text)) {
            form.off('submit').submit();
        }
    });
});
</script>
@endsection
