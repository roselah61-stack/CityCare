@extends('layouts.app')

@section('content')
<!-- Breadcrumb Banner -->
<div class="breadcrumb-banner-modern mb-4" style="background-image: url('{{ asset('images/breadcrumb.jpg') }}');">
    <div class="breadcrumb-content-modern">
        <h2>Appointment Details</h2>
        <div class="breadcrumb-links">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span class="sep">/</span>
            <a href="{{ route('appointments.index') }}">Appointments</a>
            <span class="sep">/</span>
            <span>Appointment #{{ $appointment->id }}</span>
        </div>
    </div>
</div>

<div class="content-overlap px-4">
    <div class="row g-4">
        <!-- Appointment Details Card -->
        <div class="col-lg-8">
            <div class="data-card p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="fw-bold text-dark mb-0">Appointment Information</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('appointments.index') }}" class="btn btn-light btn-sm border rounded-3 px-3 fw-600 transition-all hover-lift">
                            <i class="bi bi-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-600">Appointment ID</label>
                            <div class="fw-bold text-dark">#{{ $appointment->id }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small fw-600">Date</label>
                            <div class="fw-bold text-dark">{{ date('l, F d, Y', strtotime($appointment->appointment_date)) }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small fw-600">Time</label>
                            <div class="fw-bold text-dark">{{ date('h:i A', strtotime($appointment->appointment_time)) }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-600">Status</label>
                            @php
                                $statusColor = match($appointment->status) {
                                    'pending' => '#d97706',
                                    'confirmed' => '#16a34a',
                                    'completed' => '#2563eb',
                                    'cancelled' => '#ef4444',
                                    default => '#64748b'
                                };
                            @endphp
                            <span class="status-pill" style="background: {{ $statusColor }}15; color: {{ $statusColor }}; border: 1px solid {{ $statusColor }}30;">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small fw-600">Reason for Visit</label>
                            <div class="text-dark">{{ $appointment->reason ?? 'No reason provided' }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small fw-600">Created</label>
                            <div class="text-dark">{{ $appointment->created_at->format('M d, Y h:i A') }}</div>
                        </div>
                    </div>
                </div>

                @if($appointment->consultation)
                <div class="mt-4 pt-4 border-top">
                    <h6 class="fw-bold text-dark mb-3">Consultation Details</h6>
                    <div class="bg-light rounded-3 p-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small">Consultation ID</span>
                            <span class="fw-bold">#{{ $appointment->consultation->id }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small">Date</span>
                            <span class="fw-bold">{{ $appointment->consultation->created_at->format('M d, Y h:i A') }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">Status</span>
                            <span class="fw-bold text-success">{{ ucfirst($appointment->consultation->status) }}</span>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Patient & Doctor Information -->
        <div class="col-lg-4">
            <!-- Patient Card -->
            <div class="data-card p-4 mb-4">
                <h6 class="fw-bold text-dark mb-3">
                    <i class="bi bi-person-badge me-2 text-primary"></i>Patient Information
                </h6>
                <div class="text-center mb-3">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center fw-bold" style="width: 60px; height: 60px; font-size: 24px;">
                        {{ strtoupper(substr($appointment->patient->name, 0, 1)) }}
                    </div>
                </div>
                <div class="text-center">
                    <div class="fw-bold text-dark fs-6">{{ $appointment->patient->name }}</div>
                    <div class="text-muted small">{{ $appointment->patient->email }}</div>
                    <div class="text-muted small">{{ $appointment->patient->phone ?? 'No phone' }}</div>
                </div>
            </div>

            <!-- Doctor Card -->
            <div class="data-card p-4 mb-4">
                <h6 class="fw-bold text-dark mb-3">
                    <i class="bi bi-person-badge me-2 text-success"></i>Doctor Information
                </h6>
                <div class="text-center mb-3">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center fw-bold" style="width: 60px; height: 60px; font-size: 24px;">
                        {{ strtoupper(substr($appointment->doctor->name, 0, 1)) }}
                    </div>
                </div>
                <div class="text-center">
                    <div class="fw-bold text-dark fs-6">Dr. {{ $appointment->doctor->name }}</div>
                    <div class="text-muted small">{{ $appointment->doctor->email }}</div>
                    <div class="text-muted small">{{ $appointment->doctor->phone ?? 'No phone' }}</div>
                </div>
            </div>

            <!-- Actions -->
            <div class="data-card p-4">
                <h6 class="fw-bold text-dark mb-3">Actions</h6>
                <div class="d-grid gap-2">
                    @can('isDoctor')
                    @if($appointment->status === 'confirmed' && !$appointment->consultation)
                    <a href="{{ route('consultations.create', $appointment->id) }}" class="btn btn-success rounded-3 px-3 fw-600 transition-all hover-lift">
                        <i class="bi bi-play-circle me-2"></i>Start Consultation
                    </a>
                    @endif
                    @endcan

                    @if($appointment->status === 'pending' && (Gate::check('isReceptionist') || Gate::check('admin')))
                    <form action="{{ route('appointments.updateStatus', $appointment->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="confirmed">
                        <button type="submit" class="btn btn-success w-100 rounded-3 px-3 fw-600 transition-all hover-lift">
                            <i class="bi bi-check-circle me-2"></i>Confirm Appointment
                        </button>
                    </form>
                    @endif

                    @if($appointment->status !== 'cancelled' && $appointment->status !== 'completed')
                    <form action="{{ route('appointments.updateStatus', $appointment->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="cancelled">
                        <button type="submit" class="btn btn-danger w-100 rounded-3 px-3 fw-600 transition-all hover-lift">
                            <i class="bi bi-x-circle me-2"></i>Cancel Appointment
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
