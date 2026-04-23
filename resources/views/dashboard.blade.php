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
                        <i class="bi bi-check-lg"></i> Medical Professional
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
                <button class="btn btn-light border rounded-pill px-3 py-2 fw-600 small d-flex align-items-center gap-2 flex-grow-1 flex-sm-grow-0 justify-content-center transition-all hover-lift" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3); color: #1e293b;">
                    <i class="bi bi-download"></i> <span class="d-none d-sm-inline">Export</span>
                </button>
                <a href="{{ route('appointments.index') }}" class="btn rounded-pill px-3 py-2 d-flex align-items-center gap-2 flex-grow-1 flex-sm-grow-0 justify-content-center transition-all hover-lift" style="background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%); color: white; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4); border: none;">
                    <i class="bi bi-plus-lg"></i> <span class="d-none d-sm-inline">New Appointment</span>
                    <span class="d-sm-none">New</span>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
@media (min-width: 768px) {
    .dash-header {
        min-height: 220px !important;
    }
}
@media (min-width: 1200px) {
    .dash-header {
        min-height: 240px !important;
    }
}

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
    justify-content: between;
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

/* Enhanced Data Cards */
.data-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    border: 1px solid #f1f5f9;
    transition: all 0.3s ease;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.data-card:hover {
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
    transform: translateY(-2px);
}

.card-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #f1f5f9;
}

.card-head h5 {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1e293b;
    margin: 0;
}

/* Professional Status Pills */
.status-pill {
    padding: 0.375rem 0.875rem;
    border-radius: 2rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.025em;
}

.pill-success {
    background: #dcfce7;
    color: #166534;
}

.pill-warning {
    background: #fef3c7;
    color: #92400e;
}

.pill-danger {
    background: #fee2e2;
    color: #dc2626;
}

/* Section Spacing */
.dashboard-section {
    margin-bottom: 2.5rem;
}

.kpi-section {
    margin-bottom: 2rem;
}

.main-content-section {
    margin-bottom: 2rem;
}

.charts-section {
    margin-bottom: 2rem;
}

.bottom-section {
    margin-bottom: 1rem;
}

/* Responsive Improvements */
@media (max-width: 768px) {
    .kpi-value {
        font-size: 1.5rem;
    }
    
    .kpi-card-modern {
        padding: 1rem;
        margin-bottom: 1rem;
    }
    
    .kpi-icon-modern {
        width: 40px;
        height: 40px;
        font-size: 18px;
    }
    
    .data-card {
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .card-head {
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
    }
    
    .dashboard-section {
        margin-bottom: 2rem;
    }
}

@media (max-width: 576px) {
    .data-card {
        padding: 1rem;
        margin-bottom: 1.25rem;
    }
    
    .dashboard-section {
        margin-bottom: 1.5rem;
    }
}
</style>

<script>
    function updateClock() {
        const now = new Date();
        const clock = document.getElementById('live-clock');
        if (clock) {
            clock.textContent = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        }
    }
    setInterval(updateClock, 1000);
</script>

<!-- Patient-Specific Modules -->
@if(auth()->user()->role && auth()->user()->role->name === 'patient')
<!-- Patient Dashboard Summary -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-gradient-primary">
            <div class="card-body p-4 text-center">
                <i class="bi bi-calendar-heart text-white fs-1 mb-2"></i>
                <h4 class="text-white mb-1">My Appointments</h4>
                <p class="text-white-50 mb-0">Your scheduled medical visits</p>
                <a href="{{ route('patient.dashboard') }}" class="btn btn-light rounded-pill px-3 mt-3">
                    <i class="bi bi-arrow-right"></i> View Dashboard
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-gradient-success">
            <div class="card-body p-4 text-center">
                <i class="bi bi-clock-history text-white fs-1 mb-2"></i>
                <h4 class="text-white mb-1">Visit History</h4>
                <p class="text-white-50 mb-0">Your medical consultation records</p>
                <a href="{{ route('patient.dashboard') }}" class="btn btn-light rounded-pill px-3 mt-3">
                    <i class="bi bi-arrow-right"></i> View History
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-gradient-warning">
            <div class="card-body p-4 text-center">
                <i class="bi bi-credit-card text-white fs-1 mb-2"></i>
                <h4 class="text-white mb-1">Payment Status</h4>
                <p class="text-white-50 mb-0">Your billing and payment information</p>
                <a href="{{ route('patient.dashboard') }}" class="btn btn-light rounded-pill px-3 mt-3">
                    <i class="bi bi-arrow-right"></i> View Payments
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-gradient-info">
            <div class="card-body p-4 text-center">
                <i class="bi bi-person-badge text-white fs-1 mb-2"></i>
                <h4 class="text-white mb-1">My Profile</h4>
                <p class="text-white-50 mb-0">Manage your personal and medical information</p>
                <a href="/patient/profile" class="btn btn-light rounded-pill px-3 mt-3">
                    <i class="bi bi-arrow-right"></i> Manage Profile
                </a>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Admin/Staff Dashboard -->
@if(!auth()->user()->role || auth()->user()->role->name !== 'patient')
<!-- Executive Summary - Key Performance Indicators -->
<div class="dashboard-section kpi-section">
<div class="row g-3">
    <div class="col-6 col-lg-3">
        <div class="kpi-card-modern" style="background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="kpi-icon-modern">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="kpi-trend-modern">+{{ rand(5,15) }}%</div>
            </div>
            <div class="kpi-content">
                <h3 class="kpi-value">{{ number_format($totalPatients) }}</h3>
                <span class="kpi-label">Total Patients</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="kpi-card-modern" style="background: linear-gradient(135deg, #16a34a 0%, #22c55e 100%);">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="kpi-icon-modern">
                    <i class="bi bi-person-badge-fill"></i>
                </div>
                <div class="kpi-trend-modern">Active</div>
            </div>
            <div class="kpi-content">
                <h3 class="kpi-value">{{ number_format($totalDoctors) }}</h3>
                <span class="kpi-label">Medical Staff</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="kpi-card-modern" style="background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="kpi-icon-modern">
                    <i class="bi bi-calendar-check-fill"></i>
                </div>
                <div class="kpi-trend-modern">{{ $todayStats['pending'] }} Pending</div>
            </div>
            <div class="kpi-content">
                <h3 class="kpi-value">{{ $todayStats['total'] }}</h3>
                <span class="kpi-label">Today's Schedule</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="kpi-card-modern" style="background: linear-gradient(135deg, #9333ea 0%, #a855f7 100%);">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="kpi-icon-modern">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="kpi-trend-modern">+{{ rand(8,20) }}%</div>
            </div>
            <div class="kpi-content">
                <h3 class="kpi-value">UGX {{ number_format($totalRevenue, 0) }}</h3>
                <span class="kpi-label">Revenue</span>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Main Grid - Responsive Layout -->
<div class="dashboard-section main-content-section">
<div class="row g-4">
    <!-- Left Column - Activities & Workload -->
    <div class="col-lg-7">
        <!-- Today's Schedule & Status -->
        <div class="data-card mb-4">
            <div class="card-head">
                <div class="section-title">
                    <i class="bi bi-calendar-week text-primary"></i>
                    Today's Activities
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <span class="status-pill pill-success">{{ $todayStats['completed'] }} Completed</span>
                    <span class="status-pill pill-warning">{{ $todayStats['pending'] }} Pending</span>
                    <span class="status-pill pill-danger">{{ $todayStats['cancelled'] }} Cancelled</span>
                </div>
            </div>
            <div class="table-responsive" style="max-height: 300px;">
                <table class="table-ent">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Patient</th>
                            <th class="d-none d-md-table-cell">Doctor</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($todayAppointments as $appt)
                        <tr>
                            <td class="fw-bold">{{ date('H:i', strtotime($appt->appointment_time)) }}</td>
                            <td>
                                <div class="patient-meta">
                                    <div class="p-avatar">{{ strtoupper(substr($appt->patient->name, 0, 1)) }}</div>
                                    <span class="fw-bold">{{ $appt->patient->name }}</span>
                                </div>
                            </td>
                            <td class="text-muted d-none d-md-table-cell">Dr. {{ $appt->doctor->name }}</td>
                            <td>
                                @php
                                    $pillClass = match($appt->status) {
                                        'completed' => 'pill-success',
                                        'pending' => 'pill-warning',
                                        'cancelled' => 'pill-danger',
                                        default => 'pill-warning'
                                    };
                                @endphp
                                <span class="status-pill {{ $pillClass }}">{{ ucfirst($appt->status) }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">No appointments scheduled for today</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Doctor Workload Summary -->
        <div class="data-card">
            <div class="card-head">
                <div class="section-title">
                    <i class="bi bi-people text-success"></i>
                    Doctor Workload Summary
                </div>
                <span class="badge bg-light text-dark">{{ $doctorsOnDuty }} Doctors on Duty</span>
            </div>
            <div class="row g-3">
                @forelse($doctorWorkload as $doctor)
                <div class="col-12 col-md-6">
                    <div class="d-flex align-items-center justify-content-between p-3 rounded-3 border">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-avatar" style="background: #dbeafe; color: #2563eb;">
                                {{ strtoupper(substr($doctor->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-bold small">Dr. {{ $doctor->name }}</div>
                                <div class="text-muted" style="font-size: 11px;">{{ $doctor->completed_appointments_count + $doctor->scheduled_appointments_count }} total</div>
                            </div>
                        </div>
                        <div class="d-flex gap-3">
                            <div class="text-center">
                                <div class="fw-bold text-success">{{ $doctor->completed_appointments_count }}</div>
                                <div class="text-muted" style="font-size: 10px;">Done</div>
                            </div>
                            <div class="text-center">
                                <div class="fw-bold text-warning">{{ $doctor->scheduled_appointments_count }}</div>
                                <div class="text-muted" style="font-size: 10px;">Scheduled</div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-muted text-center py-3">No doctors registered</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Right Column - Financial & Pharmacy -->
    <div class="col-lg-5">
        <!-- Financial Overview -->
        <div class="data-card mb-4">
            <div class="card-head">
                <div class="section-title">
                    <i class="bi bi-graph-up-arrow text-warning"></i>
                    Financial Overview
                </div>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-4">
                    <div class="text-center p-3 rounded-3 bg-primary bg-opacity-10">
                        <div class="fw-bold text-primary">UGX {{ number_format($totalRevenue, 0) }}</div>
                        <div class="text-muted small">Today</div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="text-center p-3 rounded-3 bg-success bg-opacity-10">
                        <div class="fw-bold text-success">UGX {{ number_format($weeklyRevenue, 0) }}</div>
                        <div class="text-muted small">This Week</div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="text-center p-3 rounded-3 bg-warning bg-opacity-10">
                        <div class="fw-bold text-warning">UGX {{ number_format($monthlyRevenue, 0) }}</div>
                        <div class="text-muted small">This Month</div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="card-head mb-3">
                <span class="fw-bold text-dark small">Payment Breakdown</span>
            </div>
            <div class="d-flex flex-column gap-3">
                <div class="d-flex justify-content-between align-items-center p-2 rounded-2 bg-light">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-clipboard2-pulse text-primary"></i>
                        <span class="small fw-600">Consultations</span>
                    </div>
                    <span class="fw-bold">UGX {{ number_format($consultationFees, 0) }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center p-2 rounded-2 bg-light">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-bandaid text-success"></i>
                        <span class="small fw-600">Pharmacy Sales</span>
                    </div>
                    <span class="fw-bold">UGX {{ number_format($pharmacySales, 0) }}</span>
                </div>
            </div>
        </div>

        <!-- Pharmacy Insights -->
        <div class="data-card" style="margin-bottom: 2.5rem;">
            <div class="card-head">
                <div class="section-title">
                    <i class="bi bi-capsule text-info"></i>
                    Pharmacy Insights
                </div>
                <a href="{{ route('drug.list') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">View All</a>
            </div>
            @forelse($lowStockAlerts as $drug)
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                <div>
                    <div class="fw-bold small">{{ $drug->name }}</div>
                    <div class="text-danger" style="font-size: 11px;">Only {{ $drug->quantity }} left</div>
                </div>
                <i class="bi bi-exclamation-triangle-fill text-danger"></i>
            </div>
            @empty
            <p class="text-muted small text-center py-3">All stock levels normal</p>
            @endforelse
            <div class="mt-3 p-3 rounded-3" style="background: #f8fafc;">
                <div class="d-flex justify-content-between">
                    <span class="text-muted small fw-600">Total Pharmacy Sales</span>
                    <span class="fw-bold text-success">UGX {{ number_format($pharmacySales, 0) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Charts Row - Responsive -->
<div class="dashboard-section charts-section">
<div class="row g-4">
    <div class="col-lg-8">
        <div class="data-card">
            <div class="card-head">
                <div class="section-title">
                    <i class="bi bi-graph-up text-primary"></i>
                    Revenue Trends (Last 7 Days)
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-light btn-sm border rounded-pill px-3 d-flex align-items-center gap-2">
                        <i class="bi bi-calendar3"></i> Weekly
                    </button>
                    <button class="btn btn-ent btn-sm rounded-pill px-3 d-flex align-items-center gap-2">
                        <i class="bi bi-calendar-month"></i> Monthly
                    </button>
                </div>
            </div>
            <div style="height: 280px;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="data-card">
            <div class="card-head">
                <div class="section-title">
                    <i class="bi bi-people text-info"></i>
                    Patient Demographics
                </div>
            </div>
            <div style="height: 200px;">
                <canvas id="demoChart"></canvas>
            </div>
            <div class="mt-3 d-flex justify-content-around">
                <div class="text-center">
                    <div class="fw-extrabold text-primary" style="font-size: 24px;">{{ $demographics['data'][0] }}</div>
                    <div class="text-muted small">Male Patients</div>
                </div>
                <div class="text-center">
                    <div class="fw-extrabold" style="color: #94a3b8; font-size: 24px;">{{ $demographics['data'][1] }}</div>
                    <div class="text-muted small">Female Patients</div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Bottom Row: Recent Patients & Quick Actions -->
<div class="dashboard-section bottom-section">
<div class="row g-4">
    <!-- Recent Patients Table -->
    <div class="col-lg-8">
        <div class="data-card">
            <div class="card-head">
                <div class="section-title">
                    <i class="bi bi-person-plus text-success"></i>
                    Recent Registered Patients
                </div>
                <a href="{{ route('patient.list') }}" class="btn btn-sm btn-outline-success rounded-pill px-3">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table-ent">
                    <thead>
                        <tr>
                            <th>Patient Name</th>
                            <th class="d-none d-md-table-cell">Gender</th>
                            <th class="d-none d-lg-table-cell">Phone</th>
                            <th>Joined Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPatients as $patient)
                        <tr>
                            <td>
                                <div class="patient-meta">
                                    <div class="p-avatar" style="background: #f1f5f9; color: var(--primary);">
                                        {{ strtoupper(substr($patient->name, 0, 1)) }}
                                    </div>
                                    <span class="fw-bold">{{ $patient->name }}</span>
                                </div>
                            </td>
                            <td class="text-muted d-none d-md-table-cell">{{ ucfirst($patient->gender) }}</td>
                            <td class="text-muted d-none d-lg-table-cell">{{ $patient->phone }}</td>
                            <td class="text-muted small">{{ $patient->created_at->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">No recent patients found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Report Links -->
    <div class="col-lg-4">
        <div class="data-card">
            <div class="card-head">
                <div class="section-title">
                    <i class="bi bi-lightning-charge text-warning"></i>
                    Quick Actions & Reports
                </div>
            </div>
            <div class="d-flex flex-column gap-3">
                <div class="row g-3">
                    <div class="col-6">
                        <a href="{{ route('patient.create') }}" class="quick-action-card p-3">
                            <div class="qa-icon" style="background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%); width: 40px; height: 40px; font-size: 18px;">
                                <i class="bi bi-person-plus-fill" style="color: white;"></i>
                            </div>
                            <div class="fw-bold" style="font-size: 11px; margin-top: 8px; text-align: center;">Add Patient</div>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('admin.users.create') }}" class="quick-action-card p-3">
                            <div class="qa-icon" style="background: linear-gradient(135deg, #16a34a 0%, #22c55e 100%); width: 40px; height: 40px; font-size: 18px;">
                                <i class="bi bi-person-badge-fill" style="color: white;"></i>
                            </div>
                            <div class="fw-bold" style="font-size: 11px; margin-top: 8px; text-align: center;">Add Doctor</div>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('appointments.create') }}" class="quick-action-card p-3">
                            <div class="qa-icon" style="background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%); width: 40px; height: 40px; font-size: 18px;">
                                <i class="bi bi-calendar-plus-fill" style="color: white;"></i>
                            </div>
                            <div class="fw-bold" style="font-size: 11px; margin-top: 8px; text-align: center;">Book Appt</div>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('reports.index') }}" class="quick-action-card p-3">
                            <div class="qa-icon" style="background: linear-gradient(135deg, #9333ea 0%, #a855f7 100%); width: 40px; height: 40px; font-size: 18px;">
                                <i class="bi bi-graph-up-arrow" style="color: white;"></i>
                            </div>
                            <div class="fw-bold" style="font-size: 11px; margin-top: 8px; text-align: center;">Reports</div>
                        </a>
                    </div>
                </div>
                <hr class="my-2 opacity-10">
                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('reports.export', 'revenue') }}" class="btn btn-light btn-sm border text-start d-flex align-items-center gap-2 px-3 py-2 rounded-3">
                        <i class="bi bi-file-earmark-pdf text-danger"></i>
                        <span class="small fw-600">Download Revenue Report</span>
                    </a>
                    <a href="{{ route('reports.export', 'pharmacy') }}" class="btn btn-light btn-sm border text-start d-flex align-items-center gap-2 px-3 py-2 rounded-3">
                        <i class="bi bi-file-earmark-pdf text-danger"></i>
                        <span class="small fw-600">Download Pharmacy Report</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<style>
.quick-action-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
    border-radius: 16px;
    border: 1px solid var(--border);
    background: #fafafa;
    text-decoration: none !important;
    color: var(--text-main);
    transition: all 0.2s;
}

.quick-action-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    border-color: var(--primary);
    background: white;
}

.qa-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
}
</style>

@push('scripts')
<script>
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($revenueLabels ?: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']) !!},
        datasets: [{
            data: {!! json_encode($revenueData ?: [0, 0, 0, 0, 0, 0, 0]) !!},
            borderColor: '#2563eb',
            backgroundColor: 'rgba(37, 99, 235, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointRadius: 5,
            pointBackgroundColor: '#fff',
            pointBorderColor: '#2563eb'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { display: false },
            x: { grid: { display: false }, ticks: { font: { size: 11 } } }
        }
    }
});

const demoCtx = document.getElementById('demoChart').getContext('2d');
new Chart(demoCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($demographics['labels']) !!},
        datasets: [{
            data: {!! json_encode($demographics['data']) !!},
            backgroundColor: ['#2563eb', '#94a3b8'],
            borderWidth: 0,
            cutout: '70%'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } }
    }
});
</script>
@endif
@endpush
@endsection
