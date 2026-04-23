@extends('layouts.app')

@section('content')
<div class="dash-header p-4 p-lg-5 rounded-4 mb-4" style="background: white; border: 1px solid var(--border); box-shadow: var(--shadow-premium);">
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between w-100 gap-4">
        <div class="d-flex align-items-center gap-3 gap-md-4">
            <div class="welcome-icon-box d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(37, 99, 235, 0.2) 100%); border-radius: 16px; font-size: 28px; color: var(--primary);">
                <i class="bi bi-heart-pulse-fill"></i>
            </div>
            <div>
                <h1 class="mb-1 fw-800" style="font-size: clamp(20px, 4vw, 28px);">Add New Treatment</h1>
                <p class="text-muted mb-0 fw-500" style="font-size: clamp(12px, 2vw, 14px);">
                    Record a new treatment, diagnosis or prescription for a patient
                </p>
            </div>
        </div>
        <div class="d-flex gap-3 w-100 w-md-auto">
            <a href="{{ route('treatment.list') }}" class="btn btn-light border rounded-pill px-4 fw-600 d-flex align-items-center gap-2 transition-all hover-lift">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>
    </div>
</div>

<div class="data-card p-4">
    <div class="card-head mb-4">
        <h5>Treatment Details</h5>
    </div>
    <form method="POST" action="{{ route('treatment.store') }}">
        @csrf
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-600">Select Patient</label>
                <select name="patient_id" class="form-select" required>
                    <option value="">Select Patient</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}">
                            {{ $patient->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-600">Select Prescribed Drug</label>
                <select name="drug_id" class="form-select" required>
                    <option value="">Select Drug</option>
                    @foreach($drugs as $drug)
                        <option value="{{ $drug->id }}">
                            {{ $drug->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-12">
                <label class="form-label fw-600">Treatment Details & Notes</label>
                <textarea name="details" rows="4" class="form-control" required
                    placeholder="Describe diagnosis, dosage, and patient instructions..."></textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-600">Treatment Date</label>
                <input type="date" name="treatment_date" class="form-control" value="{{ date('Y-m-d') }}">
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('treatment.list') }}" class="btn btn-light rounded-pill px-4 border fw-600">
                Cancel
            </a>
            <button type="submit" class="btn btn-ent rounded-pill px-4 shadow-sm fw-600">
                Save Treatment Record
            </button>
        </div>
    </form>
</div>
@endsection