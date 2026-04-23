@extends('layouts.app')

@section('content')
<div class="dash-header p-4 p-lg-5 rounded-4 mb-4" style="background: white; border: 1px solid var(--border); box-shadow: var(--shadow-premium);">
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between w-100 gap-4">
        <div class="d-flex align-items-center gap-3 gap-md-4">
            <div class="welcome-icon-box d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(37, 99, 235, 0.2) 100%); border-radius: 16px; font-size: 28px; color: var(--primary);">
                <i class="bi bi-pencil-square"></i>
            </div>
            <div>
                <h1 class="mb-1 fw-800" style="font-size: clamp(20px, 4vw, 28px);">Edit Patient: <span class="text-primary">{{ $patient->name }}</span></h1>
                <p class="text-muted mb-0 fw-500" style="font-size: clamp(12px, 2vw, 14px);">
                    Update patient demographic and contact information
                </p>
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
        <h5>Update Patient Information</h5>
    </div>
    <form method="POST" action="{{ route('patient.update', $patient->id) }}">
        @csrf
        @method('PUT')
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-600">Full Name</label>
                <input type="text" name="name" value="{{ $patient->name }}" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-600">Phone Number</label>
                <input type="text" name="phone" value="{{ $patient->phone }}" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-600">Email Address</label>
                <input type="email" name="email" value="{{ $patient->email }}" class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-600">Gender</label>
                <select name="gender" class="form-select">
                    <option value="Male" {{ $patient->gender == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ $patient->gender == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-600">Patient Status</label>
                <select name="status" class="form-select">
                    <option value="Active" {{ $patient->status == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Discharged" {{ $patient->status == 'Discharged' ? 'selected' : '' }}>Discharged</option>
                    <option value="Deceased" {{ $patient->status == 'Deceased' ? 'selected' : '' }}>Deceased</option>
                </select>
            </div>

            <div class="col-12">
                <label class="form-label fw-600">Address</label>
                <textarea name="address" class="form-control" rows="3">{{ $patient->address }}</textarea>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('patient.list') }}" class="btn btn-light rounded-pill px-4 border fw-600">
                Cancel
            </a>
            <button type="submit" class="btn btn-ent rounded-pill px-4 shadow-sm fw-600">
                Update Patient Record
            </button>
        </div>
    </form>
</div>
@endsection