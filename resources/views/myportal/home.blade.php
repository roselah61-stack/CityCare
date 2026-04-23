@extends('layouts.app')

@section('page-title', 'Patient Dashboard')

@push('styles')
<style>
/* Additional patient dashboard styles */
.patient-welcome-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.appointment-item:hover {
    background: #e2e8f0 !important;
    transition: all 0.3s ease;
    cursor: pointer;
}
.visit-item:hover {
    background: #e2e8f0 !important;
    transition: all 0.3s ease;
}
</style>
@endpush

@section('content')
<!-- Patient Welcome Section -->
<div class="patient-welcome-section p-4 p-lg-5 rounded-4 mb-4 position-relative overflow-hidden" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 200px;">
    <div class="position-relative z-1">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="welcome-content">
                    <h1 class="text-white fw-bold mb-3" style="font-size: clamp(24px, 4vw, 36px);">
                        Welcome back, <span style="color: #fbbf24;">{{ auth()->user()->name }}</span>!
                    </h1>
                    <p class="text-white-50 mb-0" style="font-size: clamp(14px, 2vw, 16px);">
                        Your health journey continues. Here's your personalized medical dashboard.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 text-center text-lg-end">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill bg-white bg-opacity-20 backdrop-filter-blur-sm">
                    <i class="bi bi-calendar-check text-white"></i>
                    <span class="text-white small fw-500">{{ now()->format('l, F j, Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Summary Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-gradient-primary">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="icon-box bg-primary bg-opacity-10 rounded-3 p-3">
                        <i class="bi bi-calendar-event text-primary fs-4"></i>
                    </div>
                    <span class="badge bg-primary bg-opacity-20 text-primary rounded-pill px-3 py-1">
                        Active
                    </span>
                </div>
                <h3 class="fw-bold text-dark mb-1">{{ $upcomingAppointmentsCount }}</h3>
                <p class="text-muted mb-0">Upcoming Appointments</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-gradient-success">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="icon-box bg-success bg-opacity-10 rounded-3 p-3">
                        <i class="bi bi-clipboard-check text-success fs-4"></i>
                    </div>
                    <span class="badge bg-success bg-opacity-20 text-success rounded-pill px-3 py-1">
                        Complete
                    </span>
                </div>
                <h3 class="fw-bold text-dark mb-1">{{ $totalVisits }}</h3>
                <p class="text-muted mb-0">Total Visits</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-gradient-warning">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="icon-box bg-warning bg-opacity-10 rounded-3 p-3">
                        <i class="bi bi-credit-card text-warning fs-4"></i>
                    </div>
                    <span class="badge bg-warning bg-opacity-20 text-warning rounded-pill px-3 py-1">
                        Pending
                    </span>
                </div>
                <h3 class="fw-bold text-dark mb-1">{{ $pendingPaymentsCount }}</h3>
                <p class="text-muted mb-0">Pending Payments</p>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Upcoming Appointments -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-box bg-primary bg-opacity-10 rounded-3 p-2">
                            <i class="bi bi-calendar-week text-primary fs-5"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-0">Upcoming Appointments</h5>
                            <p class="text-muted small mb-0">Your scheduled medical visits</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-outline-secondary rounded-pill px-3" onclick="toggleAppointmentFilters()">
                            <i class="bi bi-funnel me-1"></i> Filter
                        </button>
                        <!-- Book Appointment button removed to avoid access issues -->
                    </div>
                </div>
                
                <!-- Appointment Filters -->
                <div id="appointmentFilters" class="mt-3" style="display: none;">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <select class="form-select form-select-sm" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="pending">Pending</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control form-control-sm" id="dateFromFilter" placeholder="From Date">
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control form-control-sm" id="dateToFilter" placeholder="To Date">
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-sm btn-primary rounded-pill w-100" onclick="loadAppointments()">
                                <i class="bi bi-search me-1"></i> Search
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div id="appointmentsContainer">
                    @if(isset($upcomingAppointments) && $upcomingAppointments->count() > 0)
                        <div class="appointments-list">
                            @foreach($upcomingAppointments as $appointment)
                                <div class="appointment-item d-flex align-items-center gap-4 p-3 rounded-3 mb-3" style="background: #f8fafc; border-left: 4px solid var(--primary);">
                                    <div class="appointment-date text-center">
                                        <div class="bg-primary text-white rounded-3 p-2">
                                            <div class="fw-bold">{{ \Carbon\Carbon::parse($appointment->appointment_date ?? $appointment->date)->format('M') }}</div>
                                            <div class="fs-4 fw-bold">{{ \Carbon\Carbon::parse($appointment->appointment_date ?? $appointment->date)->format('d') }}</div>
                                        </div>
                                    </div>
                                    <div class="appointment-details flex-grow-1">
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <h6 class="fw-bold text-dark mb-0">Dr. {{ $appointment->doctor->name ?? 'Not Assigned' }}</h6>
                                            <span class="badge bg-success bg-opacity-20 text-success rounded-pill px-2 py-1 small">
                                                {{ $appointment->status ?? 'Confirmed' }}
                                            </span>
                                        </div>
                                        <p class="text-muted small mb-1">
                                            <i class="bi bi-hospital me-1"></i> {{ $appointment->department ?? 'General Medicine' }}
                                        </p>
                                        <p class="text-muted small mb-0">
                                            <i class="bi bi-clock me-1"></i> {{ \Carbon\Carbon::parse($appointment->appointment_time ?? '00:00:00')->format('h:i A') }}
                                        </p>
                                    </div>
                                    <div class="appointment-actions">
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-outline-primary rounded-pill" onclick="viewAppointment({{ $appointment->id }})">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning rounded-pill" onclick="rescheduleAppointment({{ $appointment->id }})">
                                                <i class="bi bi-arrow-clockwise"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger rounded-pill" onclick="cancelAppointment({{ $appointment->id }})">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="icon-box bg-gray-100 rounded-3 p-3 d-inline-flex mb-3">
                                <i class="bi bi-calendar-x text-gray-400 fs-1"></i>
                            </div>
                            <h5 class="text-gray-600 mb-2">No Upcoming Appointments</h5>
                            <p class="text-muted small mb-4">You don't have any appointments scheduled</p>
                            <button class="btn btn-primary rounded-pill px-4">
                                <i class="bi bi-plus-lg me-2"></i> Book Appointment
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Visit History -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-box bg-success bg-opacity-10 rounded-3 p-2">
                            <i class="bi bi-clock-history text-success fs-5"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-0">Recent Visits</h5>
                            <p class="text-muted small mb-0">Your medical history</p>
                        </div>
                    </div>
                    <button class="btn btn-sm btn-outline-secondary rounded-pill px-3" onclick="toggleVisitFilters()">
                        <i class="bi bi-funnel me-1"></i> Filter
                    </button>
                </div>
                
                <!-- Visit Filters -->
                <div id="visitFilters" class="mt-3" style="display: none;">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <input type="date" class="form-control form-control-sm" id="visitDateFrom" placeholder="From Date">
                        </div>
                        <div class="col-md-6">
                            <input type="date" class="form-control form-control-sm" id="visitDateTo" placeholder="To Date">
                        </div>
                        <div class="col-12">
                            <button class="btn btn-sm btn-primary rounded-pill w-100" onclick="loadVisitHistory()">
                                <i class="bi bi-search me-1"></i> Search History
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div id="visitsContainer">
                    @if(isset($recentVisits) && $recentVisits->count() > 0)
                        <div class="visits-list">
                            @foreach($recentVisits as $visit)
                                <div class="visit-item p-3 rounded-3 mb-3" style="background: #f8fafc;">
                                    <div class="d-flex align-items-start justify-content-between mb-2">
                                        <div>
                                            <h6 class="fw-bold text-dark mb-1">Dr. {{ $visit->doctor->name ?? 'Unknown' }}</h6>
                                            <p class="text-muted small mb-0">
                                                <i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($visit->created_at)->format('M d, Y') }}
                                            </p>
                                        </div>
                                        <span class="badge bg-success bg-opacity-20 text-success rounded-pill px-2 py-1 small">
                                            Completed
                                        </span>
                                    </div>
                                    <p class="text-muted small mb-2">
                                        <strong>Diagnosis:</strong> {{ $visit->diagnosis ?? 'General checkup' }}
                                    </p>
                                    <p class="text-muted small mb-0">
                                        <strong>Treatment:</strong> {{ $visit->treatment ?? 'Medication prescribed' }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-center mt-3">
                            <button class="btn btn-outline-primary rounded-pill px-3" onclick="loadAllVisitHistory()">
                                View All History
                            </button>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div class="icon-box bg-gray-100 rounded-3 p-3 d-inline-flex mb-3">
                                <i class="bi bi-file-medical text-gray-400 fs-1"></i>
                            </div>
                            <h6 class="text-gray-600 mb-2">No Visit History</h6>
                            <p class="text-muted small mb-0">Your medical records will appear here</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Status -->
<div class="row g-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-box bg-warning bg-opacity-10 rounded-3 p-2">
                            <i class="bi bi-wallet2 text-warning fs-5"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-0">Payment Status</h5>
                            <p class="text-muted small mb-0">Your billing and payment history</p>
                        </div>
                    </div>
                    <button class="btn btn-sm btn-outline-primary rounded-pill px-3">
                        <i class="bi bi-download me-1"></i> Download Invoice
                    </button>
                </div>
            </div>
            <div class="card-body p-4">
                @if(isset($payments) && $payments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="bg-light text-muted small text-uppercase">
                                <tr>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Paid</th>
                                    <th>Balance</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payments as $payment)
                                    <tr>
                                        <td>
                                            <span class="small">{{ $payment->date->format('M d, Y') }}</span>
                                        </td>
                                        <td>
                                            <div>
                                                <div class="fw-bold small">{{ $payment->description ?? 'Consultation Fee' }}</div>
                                                <div class="text-muted small">Dr. {{ $payment->doctor->name ?? 'Unknown' }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-bold">${{ number_format($payment->amount, 2) }}</span>
                                        </td>
                                        <td>
                                            <span class="text-success fw-bold">${{ number_format($payment->paid_amount, 2) }}</span>
                                        </td>
                                        <td>
                                            <span class="text-warning fw-bold">${{ number_format($payment->balance, 2) }}</span>
                                        </td>
                                        <td>
                                            @if($payment->status == 'paid')
                                                <span class="badge bg-success bg-opacity-20 text-success rounded-pill px-2 py-1 small">
                                                    Paid
                                                </span>
                                            @else
                                                <span class="badge bg-warning bg-opacity-20 text-warning rounded-pill px-2 py-1 small">
                                                    Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-outline-primary rounded-pill">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                @if($payment->status != 'paid')
                                                    <button class="btn btn-sm btn-success rounded-pill">
                                                        <i class="bi bi-credit-card"></i> Pay
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="icon-box bg-gray-100 rounded-3 p-3 d-inline-flex mb-3">
                            <i class="bi bi-receipt text-gray-400 fs-1"></i>
                        </div>
                        <h5 class="text-gray-600 mb-2">No Payment Records</h5>
                        <p class="text-muted small mb-4">You don't have any billing records</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/patient-dashboard.js') }}"></script>
@endpush
