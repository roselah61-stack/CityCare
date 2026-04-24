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
                        <i class="bi bi-check-circle"></i> Appointment Confirmed
                    </div>
                    <h1 class="fw-900 mb-0" style="font-size: clamp(20px, 3vw, 32px); line-height: 1.2; text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3); color: white;">
                        Successfully Scheduled
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
                <button class="btn btn-light border rounded-pill px-3 py-2 fw-600 small d-flex align-items-center gap-2 flex-grow-1 flex-sm-grow-0 justify-content-center transition-all hover-lift" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3); color: #1e293b;" onclick="window.print()">
                    <i class="bi bi-printer"></i> <span class="d-none d-sm-inline">Print</span>
                </button>
                <a href="{{ route('appointments.create') }}" class="btn rounded-pill px-3 py-2 d-flex align-items-center gap-2 flex-grow-1 flex-sm-grow-0 justify-content-center transition-all hover-lift" style="background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%); color: white; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4); border: none;">
                    <i class="bi bi-plus-lg"></i> <span class="d-none d-sm-inline">Schedule Another</span>
                    <span class="d-sm-none">New</span>
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
    <div class="row g-4">
        <!-- Success Message Column -->
        <div class="col-lg-8">
            <!-- Success Card -->
            <div class="data-card">
                <div class="card-head">
                    <div class="section-title">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        Appointment Confirmation
                    </div>
                    <div class="d-flex gap-2">
                        <span class="status-pill pill-success">Confirmed</span>
                        <span class="badge bg-primary rounded-pill px-3">ID: #APT-2026-0424</span>
                    </div>
                </div>

                <!-- Success Animation -->
                <div class="text-center mb-4">
                    <div class="success-animation">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <h2 class="fw-bold text-success mb-2">Appointment Scheduled Successfully!</h2>
                    <p class="text-muted">Your appointment has been confirmed and added to our system. A confirmation email has been sent to your registered email address.</p>
                </div>

                <!-- Appointment Details -->
                <div class="appointment-details p-4 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                    <h5 class="mb-3 fw-bold">
                        <i class="bi bi-calendar-check text-primary me-2"></i>Appointment Details
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-size: 16px;">
                                    <i class="bi bi-person"></i>
                                </div>
                                <div>
                                    <div class="fw-bold">Patient Name</div>
                                    <div class="text-muted">John Mugisha</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-size: 16px;">
                                    <i class="bi bi-person-badge"></i>
                                </div>
                                <div>
                                    <div class="fw-bold">Doctor</div>
                                    <div class="text-muted">Dr. Sarah Nankya</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-warning text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-size: 16px;">
                                    <i class="bi bi-calendar"></i>
                                </div>
                                <div>
                                    <div class="fw-bold">Date & Time</div>
                                    <div class="text-muted">April 25, 2026 at 10:30 AM</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-size: 16px;">
                                    <i class="bi bi-hospital"></i>
                                </div>
                                <div>
                                    <div class="fw-bold">Department</div>
                                    <div class="text-muted">General Medicine</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top">
                        <div class="fw-bold mb-2">Reason for Visit</div>
                        <div class="text-muted">Routine checkup and health assessment</div>
                    </div>
                </div>

                <!-- Important Information -->
                <div class="alert alert-info mt-4" role="alert">
                    <h6 class="alert-heading fw-bold">
                        <i class="bi bi-info-circle me-2"></i>Important Information
                    </h6>
                    <ul class="mb-0">
                        <li>Please arrive <strong>15 minutes</strong> before your scheduled appointment time</li>
                        <li>Bring your <strong>ID card</strong> and any relevant medical documents</li>
                        <li>If you need to reschedule, please call us at least <strong>24 hours</strong> in advance</li>
                        <li>You will receive a <strong>confirmation email</strong> with appointment details shortly</li>
                        <li>For emergencies, please call our emergency hotline: <strong>0771234567</strong></li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="{{ route('appointments.index') }}" class="btn btn-light btn-lg rounded-3 px-4">
                        <i class="bi bi-list me-2"></i>View All Appointments
                    </a>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-primary btn-lg rounded-3 px-4" onclick="window.print()">
                            <i class="bi bi-printer me-2"></i>Print Details
                        </button>
                        <a href="{{ route('appointments.create') }}" class="btn btn-ent btn-lg rounded-3 px-4">
                            <i class="bi bi-plus-circle me-2"></i>Schedule Another
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Column -->
        <div class="col-lg-4">
            <!-- Next Steps Card -->
            <div class="data-card mb-4">
                <div class="card-head">
                    <div class="section-title">
                        <i class="bi bi-arrow-right-circle text-primary"></i>
                        Next Steps
                    </div>
                </div>
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2" style="width: 32px; height: 32px; font-size: 14px;">
                            <i class="bi bi-1"></i>
                        </div>
                        <div>
                            <div class="fw-bold small">Check Email</div>
                            <div class="text-muted small">Look for confirmation email</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-circle bg-success bg-opacity-10 text-success p-2" style="width: 32px; height: 32px; font-size: 14px;">
                            <i class="bi bi-2"></i>
                        </div>
                        <div>
                            <div class="fw-bold small">Prepare Documents</div>
                            <div class="text-muted small">Gather medical records</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-circle bg-warning bg-opacity-10 text-warning p-2" style="width: 32px; height: 32px; font-size: 14px;">
                            <i class="bi bi-3"></i>
                        </div>
                        <div>
                            <div class="fw-bold small">Arrive Early</div>
                            <div class="text-muted small">15 minutes before appointment</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="data-card mb-4">
                <div class="card-head">
                    <div class="section-title">
                        <i class="bi bi-telephone text-success"></i>
                        Contact Information
                    </div>
                </div>
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2" style="width: 32px; height: 32px; font-size: 14px;">
                            <i class="bi bi-telephone"></i>
                        </div>
                        <div>
                            <div class="fw-bold small">Main Office</div>
                            <div class="text-muted small">+256 777 123456</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-danger bg-opacity-10 text-danger p-2" style="width: 32px; height: 32px; font-size: 14px;">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>
                        <div>
                            <div class="fw-bold small">Emergency</div>
                            <div class="text-muted small">+256 777 987654</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-success bg-opacity-10 text-success p-2" style="width: 32px; height: 32px; font-size: 14px;">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div>
                            <div class="fw-bold small">Email</div>
                            <div class="text-muted small">info@citycare.ug</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="data-card">
                <div class="card-head">
                    <div class="section-title">
                        <i class="bi bi-lightning-charge text-warning"></i>
                        Quick Actions
                    </div>
                </div>
                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('appointments.index') }}" class="btn btn-outline-primary btn-sm rounded-3 px-3 text-start">
                        <i class="bi bi-list me-2"></i>View My Appointments
                    </a>
                    <a href="#" class="btn btn-outline-success btn-sm rounded-3 px-3 text-start">
                        <i class="bi bi-calendar-plus me-2"></i>Reschedule Appointment
                    </a>
                    <a href="#" class="btn btn-outline-danger btn-sm rounded-3 px-3 text-start">
                        <i class="bi bi-x-circle me-2"></i>Cancel Appointment
                    </a>
                    <a href="#" class="btn btn-outline-info btn-sm rounded-3 px-3 text-start">
                        <i class="bi bi-question-circle me-2"></i>Help & Support
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
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

/* Success Animation */
.success-animation {
    margin-bottom: 2rem;
}

.success-animation i {
    font-size: 4rem;
    color: #28a745;
    animation: scaleIn 0.5s ease-in-out;
}

@keyframes scaleIn {
    from { transform: scale(0); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
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

/* Appointment Details */
.appointment-details {
    background: #f8fafc;
    border-radius: 0.5rem;
    padding: 1.5rem;
}

/* Button Styles */
.btn-ent {
    background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #0891b2 100%);
    color: white;
    border: none;
    font-weight: 600;
}

.btn-ent:hover {
    background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 50%, #0891b2 100%);
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(30, 58, 138, 0.4);
}

/* Responsive */
@media (max-width: 768px) {
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
    
    .success-animation i {
        font-size: 3rem;
    }
}
</style>
@endsection
