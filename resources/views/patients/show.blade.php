@extends('layouts.app')

@section('page-title', 'Patient Medical History')

@section('content')
<!-- Breadcrumb Banner -->
<div class="breadcrumb-banner-modern mb-4" style="background-image: url('{{ asset('images/breadcrumb.jpg') }}');">
    <div class="breadcrumb-content-modern">
        <h2>Patient Profile</h2>
        <div class="breadcrumb-links">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span class="sep">/</span>
            <a href="{{ route('patient.list') }}">Patient Management</a>
            <span class="sep">/</span>
            <span>{{ $patient->name }}</span>
        </div>
    </div>
</div>

<div class="content-overlap px-4">
<div class="row g-4">
    <!-- Patient Profile Summary -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center p-4">
                <div class="bg-primary-light text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; font-size: 32px; font-weight: 800; background-color: #eef2ff;">
                    {{ strtoupper(substr($patient->name, 0, 1)) }}
                </div>
                <h4 class="fw-bold mb-1">{{ $patient->name }}</h4>
                <p class="text-muted small mb-4">Patient ID: #{{ $patient->id }}</p>
                
                <div class="row g-2 text-start">
                    <div class="col-6">
                        <small class="text-muted d-block">Gender</small>
                        <span class="fw-bold small text-capitalize">{{ $patient->gender }}</span>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Phone</small>
                        <span class="fw-bold small">{{ $patient->phone }}</span>
                    </div>
                    <div class="col-12 mt-3">
                        <small class="text-muted d-block">Email</small>
                        <span class="fw-bold small">{{ $patient->email }}</span>
                    </div>
                    <div class="col-12 mt-3">
                        <small class="text-muted d-block">Address</small>
                        <span class="fw-bold small">{{ $patient->address }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mt-4">
            <div class="card-title px-4 pt-4 mb-0">Quick Stats</div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span class="small text-muted">Total Visits</span>
                    <span class="fw-bold small">{{ $consultations->count() }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="small text-muted">Last Visit</span>
                    <span class="fw-bold small text-primary">{{ $consultations->first() ? $consultations->first()->created_at->format('d M Y') : 'N/A' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- EHR Timeline -->
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-title px-4 pt-4 d-flex justify-content-between align-items-center">
                <span>Electronic Health Record (EHR) Timeline</span>
                <button class="btn btn-primary btn-sm rounded-pill px-3" style="font-size: 11px;">
                    <i class="bi bi-printer me-1"></i> Print History
                </button>
            </div>
            <div class="card-body p-4">
                @forelse($consultations as $consultation)
                <div class="timeline-item mb-5 position-relative" style="border-left: 2px solid #e2e8f0; padding-left: 30px; margin-left: 10px;">
                    <div class="position-absolute" style="left: -9px; top: 0; width: 16px; height: 16px; border-radius: 50%; background: var(--sidebar-bg); border: 3px solid #fff;"></div>
                    
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <span class="badge bg-light text-dark border mb-2" style="font-size: 10px;">{{ $consultation->created_at->format('D, d M Y - h:i A') }}</span>
                            <h6 class="fw-bold mb-0">Consultation with Dr. {{ $consultation->doctor->name }}</h6>
                        </div>
                    </div>

                    <div class="bg-light rounded-4 p-3 mt-3">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <small class="text-muted text-uppercase fw-bold" style="font-size: 10px;">Diagnosis</small>
                                <p class="mb-0 small fw-medium">{{ $consultation->diagnosis }}</p>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted text-uppercase fw-bold" style="font-size: 10px;">Vitals</small>
                                <div class="d-flex flex-wrap gap-2 mt-1">
                                    <span class="badge bg-white text-dark border" style="font-size: 9px;">BP: {{ $consultation->blood_pressure ?? 'N/A' }}</span>
                                    <span class="badge bg-white text-dark border" style="font-size: 9px;">Temp: {{ $consultation->temperature ?? 'N/A' }}°C</span>
                                    <span class="badge bg-white text-dark border" style="font-size: 9px;">HR: {{ $consultation->heart_rate ?? 'N/A' }} bpm</span>
                                </div>
                            </div>
                            @if($consultation->prescription)
                            <div class="col-12 border-top pt-2">
                                <small class="text-muted text-uppercase fw-bold d-block mb-2" style="font-size: 10px;">Prescription Issued</small>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($consultation->prescription->items as $item)
                                    <span class="badge bg-info-light text-primary border" style="background-color: #f0f9ff; font-size: 9px;">
                                        <i class="bi bi-capsule me-1"></i> {{ $item->drug->name }} ({{ $item->dosage }})
                                    </span>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-5">
                    <i class="bi bi-journal-medical display-1 text-muted opacity-25 mb-3"></i>
                    <p class="text-muted">No medical history found for this patient.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
</div>
@endsection
