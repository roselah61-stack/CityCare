@extends('layouts.app')

@section('content')
<div class="dash-header p-4 p-lg-5 rounded-4 mb-4" style="background: white; border: 1px solid var(--border); box-shadow: var(--shadow-premium);">
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between w-100 gap-4">
        <div class="d-flex align-items-center gap-3 gap-md-4">
            <div class="welcome-icon-box d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(37, 99, 235, 0.2) 100%); border-radius: 16px; font-size: 28px; color: var(--primary);">
                <i class="bi bi-clipboard2-pulse-fill"></i>
            </div>
            <div>
                <h1 class="mb-1 fw-800" style="font-size: clamp(20px, 4vw, 28px);">New Consultation</h1>
                <p class="text-muted mb-0 fw-500" style="font-size: clamp(12px, 2vw, 14px);">
                    Recording session for <strong>{{ $appointment->patient->name }}</strong>
                </p>
            </div>
        </div>
        <div class="d-flex gap-3 w-100 w-md-auto">
            <a href="{{ route('appointments.index') }}" class="btn btn-light border rounded-pill px-4 fw-600 d-flex align-items-center gap-2 transition-all hover-lift">
                <i class="bi bi-x-lg"></i> Cancel
            </a>
        </div>
    </div>
</div>

<form action="{{ route('consultations.store') }}" method="POST">
    @csrf
    <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="data-card h-100">
                <div class="card-head mb-4">
                    <h5>Clinical Details & Observations</h5>
                </div>
                
                <div class="p-3 rounded-3 mb-4" style="background: #f8fafc; border: 1px solid var(--border);">
                    <div class="row g-3">
                        <div class="col-6 col-md-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">BP (mmHg)</label>
                            <input type="text" name="blood_pressure" class="form-control" placeholder="120/80">
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Temp (°C)</label>
                            <input type="text" name="temperature" class="form-control" placeholder="36.5">
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Weight (kg)</label>
                            <input type="text" name="weight" class="form-control" placeholder="70">
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">HR (bpm)</label>
                            <input type="text" name="heart_rate" class="form-control" placeholder="72">
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-600">Diagnosis</label>
                    <textarea name="diagnosis" class="form-control @error('diagnosis') is-invalid @enderror" rows="4" placeholder="Enter patient diagnosis..." required>{{ old('diagnosis') }}</textarea>
                    @error('diagnosis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-0">
                    <label class="form-label fw-600">Doctor's Notes</label>
                    <textarea name="notes" class="form-control" rows="4" placeholder="Additional observations, history, etc.">{{ old('notes') }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="data-card h-100 d-flex flex-column">
                <div class="card-head mb-4 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Prescription</h5>
                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-600" onclick="addDrugRow()">
                        <i class="bi bi-plus"></i> Add Drug
                    </button>
                </div>
                
                <div class="flex-grow-1">
                    <div id="drugs-container">
                        <!-- Drug rows will be added here -->
                    </div>
                    
                    <div id="no-drugs-msg" class="text-center py-5">
                        <div class="p-4 rounded-4 bg-light border border-dashed mb-3">
                            <i class="bi bi-capsule text-muted display-4 d-block mb-3 opacity-25"></i>
                            <p class="text-muted fw-600 mb-0">No drugs prescribed yet.</p>
                            <button type="button" class="btn btn-sm btn-link text-primary mt-2 text-decoration-none" onclick="addDrugRow()">+ Click here to add medication</button>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-ent w-100 py-3 rounded-pill shadow-sm fw-600">
                        Complete Consultation & Issue Prescription
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<template id="drug-row-template">
    <div class="drug-row border rounded-4 p-3 mb-3 bg-light position-relative transition-all shadow-sm">
        <button type="button" class="btn-close position-absolute top-0 end-0 m-3" onclick="this.parentElement.remove(); checkEmpty();"></button>
        
        <div class="mb-3">
            <label class="form-label small fw-bold text-muted text-uppercase">Drug Name</label>
            <select name="drugs[INDEX][id]" class="form-select form-select-sm" required>
                <option value="">-- Select Drug --</option>
                @foreach($drugs as $drug)
                <option value="{{ $drug->id }}">{{ $drug->name }} (Stock: {{ $drug->quantity }})</option>
                @endforeach
            </select>
        </div>

        <div class="row g-2 mb-3">
            <div class="col-6">
                <label class="form-label small fw-bold text-muted text-uppercase">Dosage</label>
                <input type="text" name="drugs[INDEX][dosage]" class="form-control form-control-sm" placeholder="e.g. 1x3" required>
            </div>
            <div class="col-6">
                <label class="form-label small fw-bold text-muted text-uppercase">Duration</label>
                <input type="text" name="drugs[INDEX][duration]" class="form-control form-control-sm" placeholder="e.g. 5 days" required>
            </div>
        </div>

        <div class="row g-2">
            <div class="col-6">
                <label class="form-label small fw-bold text-muted text-uppercase">Total Qty</label>
                <input type="number" name="drugs[INDEX][quantity]" class="form-control form-control-sm" min="1" required>
            </div>
            <div class="col-6">
                <label class="form-label small fw-bold text-muted text-uppercase">Instructions</label>
                <input type="text" name="drugs[INDEX][instructions]" class="form-control form-control-sm" placeholder="e.g. After meal">
            </div>
        </div>
    </div>
</template>

@push('scripts')
<script>
let drugIndex = 0;

function addDrugRow() {
    const container = document.getElementById('drugs-container');
    const template = document.getElementById('drug-row-template').innerHTML;
    const newRow = template.replace(/INDEX/g, drugIndex++);
    
    const div = document.createElement('div');
    div.innerHTML = newRow;
    container.appendChild(div.firstElementChild);
    
    checkEmpty();
}

function checkEmpty() {
    const container = document.getElementById('drugs-container');
    const msg = document.getElementById('no-drugs-msg');
    msg.style.display = container.children.length === 0 ? 'block' : 'none';
}
</script>
<style>
.drug-row:hover {
    background: #fff !important;
    border-color: var(--primary) !important;
}
</style>
@endpush
@endsection