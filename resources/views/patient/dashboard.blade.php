@extends('layouts.app')

@section('content')
<div class="dash-header p-3 p-lg-4 rounded-4 mb-4 position-relative overflow-hidden" style="background-image: url('{{ asset('images/doc1.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed; border: 1px solid var(--border); box-shadow: var(--shadow-premium); min-height: 240px; margin-top: 80px;">
    <!-- Overlay for text readability -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(15, 23, 42, 0.85) 0%, rgba(30, 41, 59, 0.75) 50%, rgba(37, 99, 235, 0.65) 100%);"></div>
    
    <div class="position-relative z-1">
        <div class="d-flex flex-column flex-xl-row align-items-center justify-content-between w-100 gap-3">
            <div class="welcome-content flex-grow-1">
                <div class="d-flex flex-wrap align-items-center gap-3 gap-lg-4 mb-2">
                    <div class="welcome-badge-inline d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-success text-white" style="font-size: 11px; font-weight: 600; box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);">
                        <i class="bi bi-heart-pulse-fill"></i> Patient Portal
                    </div>
                    <h1 class="fw-900 mb-0" style="font-size: clamp(20px, 3vw, 32px); line-height: 1.2; text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3); color: white; white-space: nowrap;">
                        Welcome back, <span style="color: #fbbf24; text-shadow: 0 2px 8px rgba(251, 191, 36, 0.5);">{{ auth()->user()->name }}</span> !
                    </h1>
                </div>
                <div class="d-flex flex-wrap align-items-center gap-2 gap-lg-3 small fw-500" style="font-size: clamp(11px, 1.3vw, 13px); color: rgba(255, 255, 255, 0.9);">
                    <span class="d-flex align-items-center gap-1 px-2 py-1 rounded-pill" style="background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2);">
                        <i class="bi bi-calendar3"></i> {{ now()->format('l, d F Y') }}
                    </span>
                    <span class="d-flex align-items-center gap-1 px-2 py-1 rounded-pill" style="background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2);">
                        <i class="bi bi-clock"></i> <span id="live-clock">{{ now()->format('H:i') }}</span>
                    </span>
                    <span style="color: rgba(255, 255, 255, 0.7);">CityCare Medical Centre</span>
                </div>
            </div>
            <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-xl-auto">
                <a href="{{ route('patient.profile') }}" class="btn btn-light border rounded-pill px-3 py-2 fw-600 small d-flex align-items-center gap-2 flex-grow-1 flex-sm-grow-0 justify-content-center transition-all hover-lift" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3); color: #1e293b;">
                    <i class="bi bi-person-gear"></i> <span class="d-none d-sm-inline">Edit Profile</span>
                </a>
                <a href="{{ route('patient.book.appointment') }}" class="btn rounded-pill px-3 py-2 d-flex align-items-center gap-2 flex-grow-1 flex-sm-grow-0 justify-content-center transition-all hover-lift" style="background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%); color: white; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4); border: none;">
                    <i class="bi bi-calendar-plus"></i> <span class="d-none d-sm-inline">Book Appointment</span>
                    <span class="d-sm-none">Book</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Professional KPI Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="kpi-card-modern bg-gradient-primary">
            <div class="kpi-content">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="kpi-icon-modern">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <div class="kpi-trend-modern">
                        <i class="bi bi-arrow-up"></i> {{ $upcomingAppointments->count() > 0 ? 'Active' : 'None' }}
                    </div>
                </div>
                <h3 class="kpi-value">{{ $upcomingAppointments->count() }}</h3>
                <p class="kpi-label">Upcoming Appointments</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="kpi-card-modern bg-gradient-success">
            <div class="kpi-content">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="kpi-icon-modern">
                        <i class="bi bi-clipboard-pulse"></i>
                    </div>
                    <div class="kpi-trend-modern">
                        <i class="bi bi-check-circle"></i> Complete
                    </div>
                </div>
                <h3 class="kpi-value">{{ $stats['completed_consultations'] }}</h3>
                <p class="kpi-label">Completed Visits</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="kpi-card-modern bg-gradient-warning">
            <div class="kpi-content">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="kpi-icon-modern">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <div class="kpi-trend-modern">
                        <i class="bi bi-exclamation-triangle"></i> {{ $stats['pending_payments'] > 0 ? 'Action' : 'Clear' }}
                    </div>
                </div>
                <h3 class="kpi-value">{{ $stats['pending_payments'] }}</h3>
                <p class="kpi-label">Pending Payments</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="kpi-card-modern bg-gradient-info">
            <div class="kpi-content">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="kpi-icon-modern">
                        <i class="bi bi-calendar3"></i>
                    </div>
                    <div class="kpi-trend-modern">
                        <i class="bi bi-graph-up"></i> Total
                    </div>
                </div>
                <h3 class="kpi-value">{{ $stats['total_appointments'] }}</h3>
                <p class="kpi-label">Total Appointments</p>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="row g-4">
    <!-- Personal Profile Section -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 p-3">
                <div class="section-header">
                    <h5 class="section-title mb-0">
                        <i class="bi bi-person-circle text-primary"></i> Personal Profile
                    </h5>
                    <a href="{{ route('patient.profile') }}" class="btn btn-sm btn-outline-primary rounded-pill">Edit</a>
                </div>
            </div>
            <div class="card-body p-3">
                <div class="profile-summary">
                    <div class="profile-avatar text-center mb-3">
                        <div class="avatar-circle bg-primary text-white mx-auto" style="width: 80px; height: 80px; font-size: 2rem; line-height: 80px;">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                    </div>
                    <div class="profile-info text-center">
                        <h6 class="mb-2 fw-600">{{ auth()->user()->name }}</h6>
                        <p class="text-muted small mb-3">{{ auth()->user()->email }}</p>
                        <div class="profile-details">
                            @if(auth()->user()->phone)
                            <div class="detail-item mb-2">
                                <i class="bi bi-telephone text-primary me-2"></i>
                                <span class="small">{{ auth()->user()->phone }}</span>
                            </div>
                            @endif
                            @if(auth()->user()->address)
                            <div class="detail-item mb-2">
                                <i class="bi bi-geo-alt text-primary me-2"></i>
                                <span class="small">{{ auth()->user()->address }}</span>
                            </div>
                            @endif
                            @if(auth()->user()->date_of_birth)
                            <div class="detail-item mb-2">
                                <i class="bi bi-calendar-event text-primary me-2"></i>
                                <span class="small">{{ \Carbon\Carbon::parse(auth()->user()->date_of_birth)->format('M d, Y') }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @if(auth()->user()->medical_history || auth()->user()->allergies)
                <div class="medical-info mt-3 p-2 bg-light rounded-3">
                    <h6 class="text-muted small mb-2 fw-600">Medical Information</h6>
                    @if(auth()->user()->allergies)
                    <div class="alert alert-warning alert-sm border-0 bg-warning bg-opacity-10 text-warning mb-2">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        <strong class="small">Allergies:</strong> <span class="small">{{ auth()->user()->allergies }}</span>
                    </div>
                    @endif
                    @if(auth()->user()->medical_history)
                    <div class="medical-history">
                        <small class="text-muted">{{ Str::limit(auth()->user()->medical_history, 100) }}</small>
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Upcoming Appointments -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 p-3">
                <div class="section-header">
                    <h5 class="section-title mb-0">
                        <i class="bi bi-calendar-check text-primary"></i> Upcoming Appointments
                    </h5>
                    <a href="{{ route('patient.appointments') }}" class="btn btn-sm btn-outline-primary rounded-pill">View All</a>
                </div>
            </div>
            <div class="card-body p-3">
                @if($upcomingAppointments->count() > 0)
                    <div class="appointments-list">
                        @foreach($upcomingAppointments as $appointment)
                        <div class="appointment-item border rounded-3 p-3 mb-3 bg-light">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="appointment-date text-center">
                                        <div class="date-badge bg-primary text-white rounded-3 p-2" style="min-width: 60px;">
                                            <div class="date-day fw-bold">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d') }}</div>
                                            <div class="date-month small">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M') }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="appointment-details">
                                        <div class="appointment-header d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="mb-1 fw-600">Dr. {{ $appointment->doctor->name }}</h6>
                                                <span class="appointment-time text-muted small">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</span>
                                            </div>
                                            <div class="appointment-status">
                                                <span class="badge status-badge status-{{ $appointment->status }} rounded-pill">
                                                    {{ ucfirst($appointment->status) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="appointment-info">
                                            <p class="mb-2 small"><strong>Reason:</strong> {{ $appointment->reason }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="appointment-actions">
                                        <a href="{{ route('patient.appointment.show', $appointment->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">View Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state text-center py-5">
                        <i class="bi bi-calendar-x text-muted fs-1 mb-3"></i>
                        <h6 class="text-muted mb-2">No upcoming appointments</h6>
                        <p class="text-muted small mb-3">You don't have any scheduled appointments.</p>
                        <a href="{{ route('patient.book.appointment') }}" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-calendar-plus me-2"></i>Book Appointment
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity Section -->
<div class="row g-4 mt-2">
    <!-- Recent Consultations -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 p-3">
                <div class="section-header">
                    <h5 class="section-title mb-0">
                        <i class="bi bi-clock-history text-primary"></i> Recent Visits
                    </h5>
                    <a href="{{ route('patient.visit.history') }}" class="btn btn-sm btn-outline-primary rounded-pill">View All</a>
                </div>
            </div>
            <div class="card-body p-3">
                @if($recentConsultations->count() > 0)
                    <div class="consultations-list">
                        @foreach($recentConsultations as $consultation)
                        <div class="consultation-item border rounded-3 p-3 mb-3 bg-light">
                            <div class="consultation-header d-flex justify-content-between align-items-start mb-2">
                                <div class="doctor-info">
                                    <h6 class="mb-1 fw-600">Dr. {{ $consultation->doctor->name }}</h6>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($consultation->created_at)->format('M d, Y') }}</small>
                                </div>
                                <div class="consultation-date">
                                    <span class="badge bg-secondary rounded-pill">{{ \Carbon\Carbon::parse($consultation->created_at)->format('M j') }}</span>
                                </div>
                            </div>
                            <div class="consultation-details">
                                <p class="mb-1 small"><strong>Chief Complaint:</strong> {{ $consultation->chief_complaint }}</p>
                                <p class="mb-1 small"><strong>Diagnosis:</strong> {{ $consultation->diagnosis }}</p>
                                @if($consultation->prescription)
                                <div class="prescription-info mt-2">
                                    <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-2 py-1">
                                        <i class="bi bi-prescription2 me-1"></i> Prescription issued
                                    </span>
                                </div>
                                @endif
                            </div>
                            <div class="consultation-actions mt-2">
                                <a href="{{ route('patient.consultation.show', $consultation->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">View Details</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state text-center py-5">
                        <i class="bi bi-clipboard-x text-muted fs-1 mb-3"></i>
                        <h6 class="text-muted mb-2">No visit history</h6>
                        <p class="text-muted small">You haven't had any consultations yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Payment Status -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 p-3">
                <div class="section-header">
                    <h5 class="section-title mb-0">
                        <i class="bi bi-receipt-cutoff text-primary"></i> Payment Status
                    </h5>
                    <a href="{{ route('patient.payments') }}" class="btn btn-sm btn-outline-primary rounded-pill">View All</a>
                </div>
            </div>
            <div class="card-body p-3">
                @if($recentBills->count() > 0)
                    <div class="payments-summary mb-3 p-3 bg-light rounded-3">
                        <div class="payment-stats">
                            <div class="payment-stat d-flex justify-content-between align-items-center mb-2">
                                <span class="stat-label small fw-600">Total Amount:</span>
                                <span class="stat-value fw-bold">UGX {{ number_format($recentBills->sum('total_amount'), 0) }}</span>
                            </div>
                            <div class="payment-stat d-flex justify-content-between align-items-center mb-2">
                                <span class="stat-label small fw-600">Paid:</span>
                                <span class="stat-value fw-bold text-success">UGX {{ number_format($recentBills->where('payment_status', 'completed')->sum('total_amount'), 0) }}</span>
                            </div>
                            <div class="payment-stat d-flex justify-content-between align-items-center">
                                <span class="stat-label small fw-600">Pending:</span>
                                <span class="stat-value fw-bold text-warning">UGX {{ number_format($recentBills->where('payment_status', 'pending')->sum('total_amount'), 0) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="payments-list">
                        @foreach($recentBills as $bill)
                        <div class="payment-item border rounded-3 p-3 mb-3 bg-light">
                            <div class="payment-header d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="mb-1 fw-600">Bill #{{ $bill->id }}</h6>
                                    <span class="badge status-badge status-{{ $bill->payment_status }} rounded-pill">
                                        {{ ucfirst($bill->payment_status) }}
                                    </span>
                                </div>
                            </div>
                            <div class="payment-details">
                                <p class="mb-1 small"><strong>Amount:</strong> UGX {{ number_format($bill->total_amount, 0) }}</p>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($bill->created_at)->format('M d, Y - g:i A') }}</small>
                            </div>
                            <div class="payment-actions mt-2">
                                @if($bill->payment_status === 'pending')
                                <a href="{{ route('patient.payment.show', $bill->id) }}" class="btn btn-sm btn-success rounded-pill">Pay Now</a>
                                @else
                                <a href="{{ route('patient.payment.show', $bill->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">View Receipt</a>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state text-center py-5">
                        <i class="bi bi-receipt text-muted fs-1 mb-3"></i>
                        <h6 class="text-muted mb-2">No payment records</h6>
                        <p class="text-muted small">You don't have any billing records yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions Section -->
<div class="row g-4 mt-2">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 p-3">
                <div class="section-header">
                    <h5 class="section-title mb-0">
                        <i class="bi bi-lightning-charge text-primary"></i> Quick Actions
                    </h5>
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1">
                        <i class="bi bi-star-fill me-1"></i> Frequently Used
                    </span>
                </div>
            </div>
            <div class="card-body p-3">
                <div class="row g-3">
                    <!-- Book Appointment -->
                    <div class="col-md-3 col-sm-6">
                        <div class="quick-action-card text-center p-4 rounded-3 border bg-light hover-lift transition-all">
                            <div class="action-icon bg-primary bg-opacity-10 text-primary rounded-circle p-3 mx-auto mb-3" style="width: 80px; height: 80px;">
                                <i class="bi bi-calendar-plus fs-3"></i>
                            </div>
                            <h6 class="fw-600 mb-2">Book Appointment</h6>
                            <p class="text-muted small mb-3">Schedule a new medical visit</p>
                            <a href="{{ route('patient.book.appointment') }}" class="btn btn-primary rounded-pill px-4 fw-600">
                                <i class="bi bi-plus-circle me-2"></i>Book Now
                            </a>
                        </div>
                    </div>

                    <!-- View Appointments -->
                    <div class="col-md-3 col-sm-6">
                        <div class="quick-action-card text-center p-4 rounded-3 border bg-light hover-lift transition-all">
                            <div class="action-icon bg-info bg-opacity-10 text-info rounded-circle p-3 mx-auto mb-3" style="width: 80px; height: 80px;">
                                <i class="bi bi-calendar-check fs-3"></i>
                            </div>
                            <h6 class="fw-600 mb-2">My Appointments</h6>
                            <p class="text-muted small mb-3">View scheduled visits</p>
                            <a href="{{ route('patient.appointments') }}" class="btn btn-info rounded-pill px-4 fw-600">
                                <i class="bi bi-list-check me-2"></i>View All
                            </a>
                        </div>
                    </div>

                    <!-- Medical History -->
                    <div class="col-md-3 col-sm-6">
                        <div class="quick-action-card text-center p-4 rounded-3 border bg-light hover-lift transition-all">
                            <div class="action-icon bg-success bg-opacity-10 text-success rounded-circle p-3 mx-auto mb-3" style="width: 80px; height: 80px;">
                                <i class="bi bi-clipboard-pulse fs-3"></i>
                            </div>
                            <h6 class="fw-600 mb-2">Medical History</h6>
                            <p class="text-muted small mb-3">Past consultations</p>
                            <a href="{{ route('patient.medical.history') }}" class="btn btn-success rounded-pill px-4 fw-600">
                                <i class="bi bi-file-medical me-2"></i>View Records
                            </a>
                        </div>
                    </div>

                    <!-- Payment Status -->
                    <div class="col-md-3 col-sm-6">
                        <div class="quick-action-card text-center p-4 rounded-3 border bg-light hover-lift transition-all">
                            <div class="action-icon bg-warning bg-opacity-10 text-warning rounded-circle p-3 mx-auto mb-3" style="width: 80px; height: 80px;">
                                <i class="bi bi-receipt-cutoff fs-3"></i>
                            </div>
                            <h6 class="fw-600 mb-2">Payment Status</h6>
                            <p class="text-muted small mb-3">Bills and payments</p>
                            <a href="{{ route('patient.payments') }}" class="btn btn-warning rounded-pill px-4 fw-600">
                                <i class="bi bi-credit-card me-2"></i>View Bills
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Secondary Actions -->
                <div class="row g-3 mt-3">
                    <div class="col-md-4 col-sm-6">
                        <div class="quick-action-card-secondary d-flex align-items-center p-3 rounded-3 border bg-light hover-lift transition-all">
                            <div class="action-icon-sm bg-secondary bg-opacity-10 text-secondary rounded-circle p-2 me-3" style="width: 50px; height: 50px;">
                                <i class="bi bi-person-gear fs-5"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-600 mb-1">Edit Profile</h6>
                                <p class="text-muted small mb-0">Update personal info</p>
                            </div>
                            <a href="{{ route('patient.profile') }}" class="btn btn-outline-secondary rounded-pill px-3 fw-600">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="quick-action-card-secondary d-flex align-items-center p-3 rounded-3 border bg-light hover-lift transition-all">
                            <div class="action-icon-sm bg-danger bg-opacity-10 text-danger rounded-circle p-2 me-3" style="width: 50px; height: 50px;">
                                <i class="bi bi-clock-history fs-5"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-600 mb-1">Visit History</h6>
                                <p class="text-muted small mb-0">Past appointments</p>
                            </div>
                            <a href="{{ route('patient.visit.history') }}" class="btn btn-outline-danger rounded-pill px-3 fw-600">
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="quick-action-card-secondary d-flex align-items-center p-3 rounded-3 border bg-light hover-lift transition-all">
                            <div class="action-icon-sm bg-info bg-opacity-10 text-info rounded-circle p-2 me-3" style="width: 50px; height: 50px;">
                                <i class="bi bi-question-circle fs-5"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-600 mb-1">Help & Support</h6>
                                <p class="text-muted small mb-0">Get assistance</p>
                            </div>
                            <a href="#" class="btn btn-outline-info rounded-pill px-3 fw-600">
                                <i class="bi bi-headset"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Professional Patient Dashboard Styles - Based on Admin Dashboard */

/* Modern KPI Cards */
.kpi-card-modern {
    padding: 1.5rem;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.kpi-card-modern::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 100px;
    height: 100px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    transform: translate(30px, -30px);
}

.kpi-card-modern:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.kpi-icon-modern {
    width: 48px;
    height: 48px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: white;
    backdrop-filter: blur(10px);
}

.kpi-trend-modern {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    backdrop-filter: blur(10px);
}

.kpi-content {
    position: relative;
    z-index: 1;
}

.kpi-value {
    color: white;
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
    line-height: 1.2;
}

.kpi-label {
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.875rem;
    font-weight: 500;
}

/* Professional Section Headers */
.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #f1f5f9;
}

.section-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.section-title .badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.75rem;
}

/* Status Badges */
.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
}

.status-pending { 
    background: rgba(250, 204, 21, 0.1); 
    color: #854d0e; 
    border: 1px solid rgba(250, 204, 21, 0.2);
}

.status-confirmed { 
    background: rgba(59, 130, 246, 0.1); 
    color: #1e40af; 
    border: 1px solid rgba(59, 130, 246, 0.2);
}

.status-completed { 
    background: rgba(34, 197, 94, 0.1); 
    color: #166534; 
    border: 1px solid rgba(34, 197, 94, 0.2);
}

.status-cancelled { 
    background: rgba(239, 68, 68, 0.1); 
    color: #991b1b; 
    border: 1px solid rgba(239, 68, 68, 0.2);
}

/* Enhanced Cards */
.card {
    border: 1px solid rgba(226, 232, 240, 0.8);
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
}

.card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transform: translateY(-1px);
}

/* Welcome Badge */
.welcome-badge-inline {
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

/* Hover Effects */
.hover-lift {
    transition: all 0.2s ease;
}

.hover-lift:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Responsive Design */
@media (max-width: 768px) {
    .kpi-value {
        font-size: 1.5rem;
    }
    
    .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .kpi-card-modern {
        padding: 1rem;
    }
    
    .kpi-icon-modern {
        width: 40px;
        height: 40px;
        font-size: 18px;
    }
}

/* Quick Actions Cards */
.quick-action-card {
    border: 1px solid rgba(226, 232, 240, 0.8) !important;
    background: white !important;
    transition: all 0.3s ease;
    cursor: pointer;
}

.quick-action-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    border-color: rgba(59, 130, 246, 0.3) !important;
}

.quick-action-card .action-icon {
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.quick-action-card:hover .action-icon {
    transform: scale(1.1);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.quick-action-card-secondary {
    border: 1px solid rgba(226, 232, 240, 0.8) !important;
    background: white !important;
    transition: all 0.3s ease;
    cursor: pointer;
}

.quick-action-card-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    border-color: rgba(59, 130, 246, 0.2) !important;
}

.quick-action-card-secondary .action-icon-sm {
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.quick-action-card-secondary:hover .action-icon-sm {
    transform: scale(1.05);
}

/* Enhanced Button Styles */
.quick-action-card .btn {
    transition: all 0.3s ease;
    border: none;
    font-weight: 600;
    text-transform: none;
    letter-spacing: 0.5px;
}

.quick-action-card .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.quick-action-card-secondary .btn {
    transition: all 0.3s ease;
    font-weight: 600;
}

.quick-action-card-secondary .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

/* Gradient Backgrounds */
.bg-gradient-primary {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
}

/* Responsive Quick Actions */
@media (max-width: 768px) {
    .quick-action-card {
        margin-bottom: 1rem;
    }
    
    .quick-action-card .action-icon {
        width: 60px !important;
        height: 60px !important;
    }
    
    .quick-action-card h6 {
        font-size: 0.9rem;
    }
    
    .quick-action-card p {
        font-size: 0.8rem;
    }
    
    .quick-action-card .btn {
        font-size: 0.8rem;
        padding: 0.5rem 1rem;
    }
    
    .quick-action-card-secondary {
        margin-bottom: 1rem;
    }
    
    .quick-action-card-secondary .action-icon-sm {
        width: 40px !important;
        height: 40px !important;
    }
    
    .quick-action-card-secondary h6 {
        font-size: 0.85rem;
    }
    
    .quick-action-card-secondary p {
        font-size: 0.75rem;
    }
}
</style>

<script>
// Live Clock functionality
document.addEventListener('DOMContentLoaded', function() {
    function updateClock() {
        const clockElement = document.getElementById('live-clock');
        if (clockElement) {
            const now = new Date();
            clockElement.textContent = now.toLocaleTimeString('en-US', { 
                hour: '2-digit', 
                minute: '2-digit',
                hour12: false 
            });
        }
    }
    
    updateClock();
    setInterval(updateClock, 1000);
});
</script>
@endsection
