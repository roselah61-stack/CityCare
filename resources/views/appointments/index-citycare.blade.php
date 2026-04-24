@extends('layouts.app')

@section('content')
<!-- Professional Header Section -->
<div class="dash-header p-3 p-lg-4 rounded-4 mb-4 position-relative overflow-hidden" style="background-image: url('{{ asset('images/doc1.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed; border: 1px solid var(--border); box-shadow: var(--shadow-premium); min-height: 200px; margin-top: 80px;">
    <!-- Overlay for text readability -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(15, 23, 42, 0.85) 0%, rgba(30, 41, 59, 0.75) 50%, rgba(37, 99, 235, 0.65) 100%);"></div>
    
    <div class="position-relative z-1">
        <div class="d-flex flex-column flex-xl-row align-items-center justify-content-between w-100 gap-3">
            <div class="welcome-content flex-grow-1">
                <div class="d-flex flex-wrap align-items-center gap-3 gap-lg-4 mb-2">
                    <div class="welcome-badge-inline d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-success text-white" style="font-size: 11px; font-weight: 600; box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);">
                        <i class="bi bi-calendar-check"></i> Appointment Management
                    </div>
                    <h1 class="fw-900 mb-0" style="font-size: clamp(20px, 3vw, 32px); line-height: 1.2; text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3); color: white;">
                        Medical Scheduling
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
                <a href="{{ route('appointments.create') }}" class="btn rounded-pill px-3 py-2 d-flex align-items-center gap-2 flex-grow-1 flex-sm-grow-0 justify-content-center transition-all hover-lift" style="background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%); color: white; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4); border: none;">
                    <i class="bi bi-plus-lg"></i> <span class="d-none d-sm-inline">Schedule Appointment</span>
                    <span class="d-sm-none">Schedule</span>
                </a>
            </div>
        </div>
    </div>
</div>

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

<!-- Main Content Area -->
<div class="dashboard-section main-content-section">
    <!-- KPI Cards Row -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="kpi-card-modern" style="background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="kpi-icon-modern">
                        <i class="bi bi-calendar-heart"></i>
                    </div>
                    <div class="kpi-trend-modern">Today</div>
                </div>
                <div class="kpi-content">
                    <h3 class="kpi-value">12</h3>
                    <span class="kpi-label">Total Appointments</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="kpi-card-modern" style="background: linear-gradient(135deg, #16a34a 0%, #22c55e 100%);">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="kpi-icon-modern">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="kpi-trend-modern">+15%</div>
                </div>
                <div class="kpi-content">
                    <h3 class="kpi-value">8</h3>
                    <span class="kpi-label">Completed</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="kpi-card-modern" style="background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="kpi-icon-modern">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div class="kpi-trend-modern">4 Pending</div>
                </div>
                <div class="kpi-content">
                    <h3 class="kpi-value">4</h3>
                    <span class="kpi-label">Upcoming</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="kpi-card-modern" style="background: linear-gradient(135deg, #9333ea 0%, #a855f7 100%);">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="kpi-icon-modern">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="kpi-trend-modern">Active</div>
                </div>
                <div class="kpi-content">
                    <h3 class="kpi-value">6</h3>
                    <span class="kpi-label">Doctors Available</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Appointments Table -->
    <div class="data-card">
        <div class="card-head">
            <div class="section-title">
                <i class="bi bi-calendar-week text-primary"></i>
                All Appointments
            </div>
            <div class="d-flex flex-wrap gap-2">
                <span class="status-pill pill-success">8 Completed</span>
                <span class="status-pill pill-warning">4 Pending</span>
                <span class="status-pill pill-danger">0 Cancelled</span>
            </div>
        </div>

        <!-- Search and Filter Bar -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="search-box">
                    <i class="bi bi-search text-muted"></i>
                    <input type="text" class="form-control" placeholder="Search appointments..." style="padding-left: 2.5rem;">
                </div>
            </div>
            <div class="col-md-2">
                <select class="form-select">
                    <option>All Status</option>
                    <option>Pending</option>
                    <option>Confirmed</option>
                    <option>Completed</option>
                    <option>Cancelled</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select">
                    <option>All Doctors</option>
                    <option>Dr. Sarah Nankya</option>
                    <option>Dr. Michael Mwanga</option>
                    <option>Dr. Rebecca Nakato</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" class="form-control">
            </div>
            <div class="col-md-2">
                <button class="btn btn-ent w-100">
                    <i class="bi bi-funnel me-2"></i>Filter
                </button>
            </div>
        </div>

        <!-- Appointments Table -->
        <div class="table-responsive">
            <table class="table-ent">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="patient-meta">
                                <div class="p-avatar">J</div>
                                <div>
                                    <div class="fw-bold">John Mugisha</div>
                                    <div class="text-muted small">john.mugisha@gmail.com</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="patient-meta">
                                <div class="p-avatar" style="background: #dbeafe; color: #2563eb;">S</div>
                                <div>
                                    <div class="fw-bold">Dr. Sarah Nankya</div>
                                    <div class="text-muted small">General Medicine</div>
                                </div>
                            </div>
                        </td>
                        <td class="fw-bold">Apr 25, 2026</td>
                        <td class="fw-bold">10:30 AM</td>
                        <td>
                            <span class="badge bg-light text-dark rounded-pill px-3">Regular</span>
                        </td>
                        <td>
                            <span class="status-pill pill-success">Confirmed</span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-outline-primary rounded-3" title="View Details">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-warning rounded-3" title="Reschedule">
                                    <i class="bi bi-calendar2"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger rounded-3" title="Cancel">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="patient-meta">
                                <div class="p-avatar">E</div>
                                <div>
                                    <div class="fw-bold">Esther Nalwoga</div>
                                    <div class="text-muted small">esther.nalwoga@gmail.com</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="patient-meta">
                                <div class="p-avatar" style="background: #dcfce7; color: #16a34a;">M</div>
                                <div>
                                    <div class="fw-bold">Dr. Michael Mwanga</div>
                                    <div class="text-muted small">Cardiology</div>
                                </div>
                            </div>
                        </td>
                        <td class="fw-bold">Apr 24, 2026</td>
                        <td class="fw-bold">2:00 PM</td>
                        <td>
                            <span class="badge bg-warning text-dark rounded-pill px-3">Follow-up</span>
                        </td>
                        <td>
                            <span class="status-pill pill-warning">Pending</span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-outline-primary rounded-3" title="View Details">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-warning rounded-3" title="Reschedule">
                                    <i class="bi bi-calendar2"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger rounded-3" title="Cancel">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="patient-meta">
                                <div class="p-avatar">D</div>
                                <div>
                                    <div class="fw-bold">David Ssenyonjo</div>
                                    <div class="text-muted small">david.ssenyonjo@yahoo.com</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="patient-meta">
                                <div class="p-avatar" style="background: #fef3c7; color: #92400e;">R</div>
                                <div>
                                    <div class="fw-bold">Dr. Rebecca Nakato</div>
                                    <div class="text-muted small">Pediatrics</div>
                                </div>
                            </div>
                        </td>
                        <td class="fw-bold">Apr 23, 2026</td>
                        <td class="fw-bold">11:15 AM</td>
                        <td>
                            <span class="badge bg-info text-white rounded-pill px-3">Emergency</span>
                        </td>
                        <td>
                            <span class="status-pill pill-success">Completed</span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-outline-primary rounded-3" title="View Details">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-secondary rounded-3" title="View Report">
                                    <i class="bi bi-file-medical"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="patient-meta">
                                <div class="p-avatar">G</div>
                                <div>
                                    <div class="fw-bold">Grace Babirye</div>
                                    <div class="text-muted small">grace.babirye@hotmail.com</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="patient-meta">
                                <div class="p-avatar" style="background: #dbeafe; color: #2563eb;">S</div>
                                <div>
                                    <div class="fw-bold">Dr. Sarah Nankya</div>
                                    <div class="text-muted small">General Medicine</div>
                                </div>
                            </div>
                        </td>
                        <td class="fw-bold">Apr 22, 2026</td>
                        <td class="fw-bold">3:45 PM</td>
                        <td>
                            <span class="badge bg-light text-dark rounded-pill px-3">Consultation</span>
                        </td>
                        <td>
                            <span class="status-pill pill-success">Completed</span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-outline-primary rounded-3" title="View Details">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-secondary rounded-3" title="View Report">
                                    <i class="bi bi-file-medical"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted small">
                Showing <strong>1-4</strong> of <strong>12</strong> appointments
            </div>
            <nav>
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item disabled">
                        <a class="page-link rounded-3" href="#" tabindex="-1">Previous</a>
                    </li>
                    <li class="page-item active">
                        <a class="page-link rounded-3" href="#">1</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link rounded-3" href="#">2</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link rounded-3" href="#">3</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link rounded-3" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<style>
/* KPI Cards */
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

/* Data Cards */
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

/* Section Headers */
.section-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Status Pills */
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

/* Patient Meta */
.patient-meta {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.p-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--primary);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 14px;
}

/* Search Box */
.search-box {
    position: relative;
}

.search-box i {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    z-index: 1;
}

.search-box input {
    padding-left: 2.5rem !important;
}

/* Table Styles */
.table-ent {
    width: 100%;
    border-collapse: collapse;
}

.table-ent th {
    background: #f8fafc;
    border: none;
    padding: 1rem;
    font-weight: 600;
    color: #475569;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.025em;
}

.table-ent td {
    padding: 1rem;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}

.table-ent tbody tr:hover {
    background: #f8fafc;
}

/* Responsive */
@media (max-width: 768px) {
    .kpi-value {
        font-size: 1.5rem;
    }
    
    .kpi-card-modern {
        padding: 1rem;
        margin-bottom: 1rem;
    }
    
    .data-card {
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .card-head {
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
}
</style>
@endsection
