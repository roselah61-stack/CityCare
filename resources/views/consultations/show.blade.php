@extends('layouts.app')

@section('content')
<!-- Breadcrumb Banner -->
<div class="breadcrumb-banner-modern mb-4" style="background-image: url('{{ asset('images/breadcrumb.jpg') }}');">
    <div class="breadcrumb-content-modern">
        <h2><i class="bi bi-clipboard2-pulse me-2" style="color: white;"></i>Consultation Details</h2>
        <div class="breadcrumb-links">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span class="sep">/</span>
            <a href="{{ route('consultations.index') }}">Consultations</a>
            <span class="sep">/</span>
            <span>Consultation #{{ $consultation->id }}</span>
        </div>
    </div>
</div>

<div class="content-overlap px-4">
    <!-- Patient & Doctor Info -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="data-card p-4">
                <h6 class="text-primary mb-3 fw-600">
                    <i class="bi bi-person-fill me-2"></i>Patient Information
                </h6>
                <div class="patient-info">
                    <div class="d-flex align-items-center mb-3">
                        <div class="p-avatar me-3">{{ strtoupper(substr($consultation->patient->name, 0, 1)) }}</div>
                        <div>
                            <div class="fw-bold text-dark fs-5">{{ $consultation->patient->name }}</div>
                            <div class="text-muted">ID: #PAT-{{ 1000 + $consultation->patient->id }}</div>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="small text-muted">Email</label>
                            <div class="fw-600">{{ $consultation->patient->email }}</div>
                        </div>
                        <div class="col-6">
                            <label class="small text-muted">Phone</label>
                            <div class="fw-600">{{ $consultation->patient->phone ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="data-card p-4">
                <h6 class="text-primary mb-3 fw-600">
                    <i class="bi bi-person-badge-fill me-2"></i>Doctor Information
                </h6>
                <div class="doctor-info">
                    <div class="d-flex align-items-center mb-3">
                        <div class="p-avatar me-3 bg-primary text-white">D</div>
                        <div>
                            <div class="fw-bold text-dark fs-5">Dr. {{ $consultation->doctor->name }}</div>
                            <div class="text-muted">{{ $consultation->doctor->role->name ?? 'Doctor' }}</div>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="small text-muted">Email</label>
                            <div class="fw-600">{{ $consultation->doctor->email }}</div>
                        </div>
                        <div class="col-6">
                            <label class="small text-muted">Specialization</label>
                            <div class="fw-600">{{ $consultation->doctor->specialization ?? 'General Practice' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Consultation Details -->
    <div class="row g-4">
        <div class="col-lg-8">
            <!-- Patient History -->
            <div class="data-card p-4 mb-4">
                <h6 class="text-primary mb-4 fw-600">
                    <i class="bi bi-clipboard2-pulse me-2"></i>Patient History
                </h6>
                
                <div class="row g-4 mb-4">
                    <div class="col-12">
                        <label class="form-label fw-600 text-primary">Chief Complaint</label>
                        <div class="p-3 bg-light rounded-3">{{ $consultation->chief_complaint ?? 'Not recorded' }}</div>
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label fw-600">History of Present Illness</label>
                        <div class="p-3 bg-light rounded-3">{{ $consultation->history_of_present_illness ?? 'Not recorded' }}</div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label fw-600">Past Medical History</label>
                        <div class="p-3 bg-light rounded-3">{{ $consultation->past_medical_history ?? 'Not recorded' }}</div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label fw-600">Family History</label>
                        <div class="p-3 bg-light rounded-3">{{ $consultation->family_history ?? 'Not recorded' }}</div>
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label fw-600">Social History</label>
                        <div class="p-3 bg-light rounded-3">{{ $consultation->social_history ?? 'Not recorded' }}</div>
                    </div>
                </div>
            </div>

            <!-- Physical Examination -->
            <div class="data-card p-4 mb-4">
                <h6 class="text-primary mb-4 fw-600">
                    <i class="bi bi-activity me-2"></i>Physical Examination
                </h6>
                
                <div class="row g-4 mb-4">
                    <div class="col-12">
                        <label class="form-label fw-600">Physical Examination Findings</label>
                        <div class="p-3 bg-light rounded-3">{{ $consultation->physical_examination ?? 'Not recorded' }}</div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label fw-600">Allergies</label>
                        <div class="p-3 bg-light rounded-3">{{ $consultation->allergies ?? 'No known allergies' }}</div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label fw-600">Current Medications</label>
                        <div class="p-3 bg-light rounded-3">{{ $consultation->medications ?? 'None recorded' }}</div>
                    </div>
                </div>
            </div>

            <!-- Assessment & Diagnosis -->
            <div class="data-card p-4 mb-4">
                <h6 class="text-primary mb-4 fw-600">
                    <i class="bi bi-clipboard-check me-2"></i>Assessment & Diagnosis
                </h6>
                
                <div class="row g-4 mb-4">
                    <div class="col-12">
                        <label class="form-label fw-600">Differential Diagnosis</label>
                        <div class="p-3 bg-light rounded-3">{{ $consultation->differential_diagnosis ?? 'Not recorded' }}</div>
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label fw-600 text-primary">Final Diagnosis</label>
                        <div class="p-3 bg-primary bg-opacity-10 rounded-3 border border-primary">{{ $consultation->diagnosis ?? 'Not recorded' }}</div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label fw-600">Investigations Ordered</label>
                        <div class="p-3 bg-light rounded-3">{{ $consultation->investigations_ordered ?? 'None' }}</div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label fw-600">Investigation Results</label>
                        <div class="p-3 bg-light rounded-3">{{ $consultation->investigation_results ?? 'Pending' }}</div>
                    </div>
                </div>
            </div>

            <!-- Treatment Plan -->
            <div class="data-card p-4">
                <h6 class="text-primary mb-4 fw-600">
                    <i class="bi bi-heart-pulse me-2"></i>Treatment Plan
                </h6>
                
                <div class="row g-4">
                    <div class="col-12">
                        <label class="form-label fw-600 text-primary">Treatment Plan</label>
                        <div class="p-3 bg-success bg-opacity-10 rounded-3 border border-success">{{ $consultation->treatment_plan ?? 'Not recorded' }}</div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label fw-600">Medications Prescribed</label>
                        <div class="p-3 bg-light rounded-3">{{ $consultation->medications_prescribed ?? 'None' }}</div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label fw-600">Follow-up Plan</label>
                        <div class="p-3 bg-light rounded-3">{{ $consultation->follow_up_plan ?? 'Not specified' }}</div>
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label fw-600">Doctor's Notes</label>
                        <div class="p-3 bg-light rounded-3">{{ $consultation->notes ?? 'No additional notes' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vital Signs & Prescription -->
        <div class="col-lg-4">
            <!-- Vital Signs -->
            <div class="data-card p-4 mb-4">
                <h6 class="text-primary mb-4 fw-600">
                    <i class="bi bi-activity me-2"></i>Vital Signs
                </h6>
                
                <div class="vital-signs">
                    <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-light rounded-3">
                        <span class="small text-muted">Blood Pressure</span>
                        <span class="fw-bold text-danger">{{ $consultation->blood_pressure ?? 'N/A' }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-light rounded-3">
                        <span class="small text-muted">Temperature</span>
                        <span class="fw-bold text-info">{{ $consultation->temperature ? $consultation->temperature . '°C' : 'N/A' }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-light rounded-3">
                        <span class="small text-muted">Heart Rate</span>
                        <span class="fw-bold text-danger">{{ $consultation->heart_rate ? $consultation->heart_rate . ' bpm' : 'N/A' }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-light rounded-3">
                        <span class="small text-muted">Weight</span>
                        <span class="fw-bold">{{ $consultation->weight ? $consultation->weight . ' kg' : 'N/A' }}</span>
                    </div>
                    
                    @if($consultation->height)
                    <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-light rounded-3">
                        <span class="small text-muted">Height</span>
                        <span class="fw-bold">{{ $consultation->height . ' cm' }}</span>
                    </div>
                    @endif
                    
                    @if($consultation->bmi)
                    <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-warning bg-opacity-10 rounded-3 border border-warning">
                        <span class="small text-muted">BMI</span>
                        <span class="fw-bold text-warning">{{ $consultation->bmi }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Prescription -->
            @if($consultation->prescription)
            <div class="data-card p-4">
                <h6 class="text-primary mb-4 fw-600">
                    <i class="bi bi-capsule me-2"></i>Prescription
                </h6>
                
                <div class="prescription-items">
                    @foreach($consultation->prescription->items as $item)
                    <div class="border rounded-3 p-3 mb-3 bg-light">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="fw-bold text-primary">{{ $item->drug->name }}</div>
                            <span class="badge bg-success text-white">{{ $item->quantity }} units</span>
                        </div>
                        <div class="row g-2">
                            <div class="col-6">
                                <span class="small text-muted">Dosage:</span>
                                <div class="fw-600">{{ $item->dosage }}</div>
                            </div>
                            <div class="col-6">
                                <span class="small text-muted">Duration:</span>
                                <div class="fw-600">{{ $item->duration }}</div>
                            </div>
                        </div>
                        @if($item->instructions)
                        <div class="mt-2 p-2 bg-white rounded-2">
                            <span class="small text-muted">Instructions:</span>
                            <div class="fw-600">{{ $item->instructions }}</div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
                
                <div class="mt-3 p-3 bg-info bg-opacity-10 rounded-3 border border-info">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-600">Prescription Status:</span>
                        <span class="badge bg-{{ $consultation->prescription->status == 'dispensed' ? 'success' : 'warning' }} text-white">
                            {{ ucfirst($consultation->prescription->status) }}
                        </span>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row g-4 mt-4">
        <div class="col-12">
            <div class="d-flex gap-3 justify-content-center">
                <a href="{{ route('consultations.index') }}" class="btn btn-light border rounded-pill px-4 fw-600">
                    <i class="bi bi-arrow-left me-2"></i>Back to Consultations
                </a>
                
                @if($consultation->appointment_id)
                <a href="{{ route('appointments.show', $consultation->appointment_id) }}" class="btn btn-primary rounded-pill px-4 fw-600">
                    <i class="bi bi-calendar-check me-2"></i>View Appointment
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
