@extends('layouts.app')

@section('content')

<!-- Breadcrumb Banner -->
<div class="breadcrumb-banner-modern mb-4" style="background-image: url('{{ asset('images/breadcrumb.jpg') }}');">
    <div class="breadcrumb-content-modern">
        <h2>Add New Patient</h2>
        <div class="breadcrumb-links">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span class="sep">/</span>
            <a href="{{ route('patient.list') }}">Patient Management</a>
            <span class="sep">/</span>
            <span>Add New Patient</span>
        </div>
    </div>
</div>

<div class="content-overlap px-4">
@canany(['isAdmin', 'isReceptionist'])
    <div class="dash-header p-4 rounded-4 mb-4" style="background: white; border: 1px solid var(--border); box-shadow: var(--shadow-premium);">
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between w-100 gap-4">
            <div class="d-flex align-items-center gap-3 gap-md-4">
                <div class="welcome-icon-box d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(37, 99, 235, 0.2) 100%); border-radius: 16px; font-size: 28px; color: var(--primary);">
                    <i class="bi bi-person-plus-fill"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-dark mb-0">Add New Patient</h4>
                    <p class="text-muted mb-0 fw-500">Register a new patient into the hospital system</p>
                </div>
            </div>
            <div class="d-flex gap-3 w-100 w-md-auto">
                <a href="{{ route('patient.list') }}" class="btn btn-light border rounded-pill px-4 fw-600 d-flex align-items-center gap-2 transition-all hover-lift">
                <i class="bi bi-arrow-left"></i> Back to Patients
            </a>
        </div>
    </div>
</div>

<div class="data-card p-4">
    <div class="card-head mb-4">
        <h5>Patient Registration Details</h5>
    </div>
    <form method="POST" action="{{ route('patient.store') }}">
        @csrf
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-600">Full Name</label>
                <input type="text" name="name" class="form-control" required placeholder="Enter patient's full name">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-600">Phone Number</label>
                <input type="text" name="phone" class="form-control" required placeholder="e.g. +256...">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-600">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="Optional email address">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-600">Gender</label>
                <select name="gender" class="form-select" required>
                    <option value="">-- Select Gender --</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-600">Patient Status</label>
                <select name="status" class="form-select" required>
                    <option value="Active">Active</option>
                    <option value="Discharged">Discharged</option>
                    <option value="Deceased">Deceased</option>
                </select>
            </div>

            <div class="col-12">
                <label class="form-label fw-600">Address</label>
                <textarea name="address" class="form-control" rows="3" placeholder="Enter physical address"></textarea>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('patient.list') }}" class="btn btn-light rounded-pill px-4 border fw-600">
                Cancel
            </a>
            <button type="submit" class="btn btn-ent rounded-pill px-4 shadow-sm fw-600">
                Save Patient Record
            </button>
        </div>
    </form>
</div>
@else
<div class="alert alert-danger rounded-4 border-0 shadow-sm p-4">
    <div class="d-flex align-items-center gap-3">
        <i class="bi bi-exclamation-triangle-fill fs-3"></i>
        <div>
            <h5 class="mb-1 fw-bold">Access Denied</h5>
            <p class="mb-0">You do not have the necessary permissions to register new patients.</p>
        </div>
    </div>
</div>
@endcanany

</div>
@endsection