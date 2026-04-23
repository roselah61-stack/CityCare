@extends('layouts.app')

@section('content')
<!-- Breadcrumb Banner -->
<div class="breadcrumb-banner-modern mb-4" style="background-image: url('{{ asset('images/breadcrumb.jpg') }}');">
    <div class="breadcrumb-content-modern">
        <h2>Clinic Appointments</h2>
        <div class="breadcrumb-links">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span class="sep">/</span>
            <span>Appointment Schedules</span>
        </div>
    </div>
</div>

<div class="content-overlap px-4">
    <div class="dash-header p-4 rounded-4 mb-4" style="background: white; border: 1px solid var(--border); box-shadow: var(--shadow-premium);">
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between w-100 gap-4">
            <div class="d-flex align-items-center gap-3 gap-md-4">
                <div class="welcome-icon-box d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(37, 99, 235, 0.2) 100%); border-radius: 16px; font-size: 28px; color: var(--primary);">
                    <i class="bi bi-calendar-check-fill"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-dark mb-0">Clinic Appointments</h4>
                    <p class="text-muted mb-0 fw-500">Schedule and monitor patient visits</p>
                </div>
            </div>
            <div class="d-flex gap-3 w-100 w-md-auto">
                @if(Gate::check('isReceptionist') || Gate::check('isPatient') || Gate::check('admin'))
                <a href="{{ route('appointments.create') }}" class="btn btn-ent rounded-pill px-4 d-flex align-items-center gap-2 transition-all hover-lift">
                    <i class="bi bi-calendar-plus-fill"></i> Schedule Appointment
                </a>
                @endif
            </div>
        </div>
    </div>

    <div class="data-card p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table-ent mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Patient</th>
                        <th>Doctor</th>
                        <th>Date & Time</th>
                        <th>Status</th>
                        <th>Reason</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appointment)
                    <tr>
                        <td class="ps-4">
                            <div class="patient-meta py-2">
                                <div class="p-avatar" style="background: rgba(37, 99, 235, 0.1); color: var(--primary); font-weight: 700;">
                                    {{ strtoupper(substr($appointment->patient->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $appointment->patient->name }}</div>
                                    <div class="text-muted small">{{ $appointment->patient->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-light rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="bi bi-person-badge text-primary"></i>
                                </div>
                                <div class="fw-bold text-dark">Dr. {{ $appointment->doctor->name }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="text-dark fw-bold small">{{ date('D, d M Y', strtotime($appointment->appointment_date)) }}</div>
                            <div class="text-muted small"><i class="bi bi-clock me-1"></i>{{ date('h:i A', strtotime($appointment->appointment_time)) }}</div>
                        </td>
                        <td>
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
                        </td>
                        <td>
                            <div class="text-truncate text-muted small" style="max-width: 150px;" title="{{ $appointment->reason }}">
                                {{ $appointment->reason ?? 'No reason provided' }}
                            </div>
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('appointments.show', $appointment->id) }}" class="btn btn-light btn-sm border rounded-3 px-3 fw-600 transition-all hover-lift">
                                    View
                                </a>
                                
                                @can('isDoctor')
                                @if($appointment->status === 'confirmed')
                                <a href="{{ route('consultations.create', $appointment->id) }}" class="btn btn-light btn-sm border rounded-3 px-3 fw-600 text-success transition-all hover-lift">
                                    Start
                                </a>
                                @endif
                                @endcan

                                @if($appointment->status === 'pending' && (Gate::check('isReceptionist') || Gate::check('admin')))
                                <form action="{{ route('appointments.updateStatus', $appointment->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="confirmed">
                                    <button type="submit" class="btn btn-light btn-sm border rounded-3 px-3 fw-600 text-success transition-all hover-lift">Confirm</button>
                                </form>
                                @endif

                                @if($appointment->status !== 'cancelled' && $appointment->status !== 'completed')
                                <form action="{{ route('appointments.updateStatus', $appointment->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit" class="btn btn-light btn-sm border rounded-3 px-3 fw-600 text-danger transition-all hover-lift">Cancel</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="bi bi-calendar-x display-4 text-muted mb-3 d-block opacity-25"></i>
                            <p class="text-muted fw-600">No appointments found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection