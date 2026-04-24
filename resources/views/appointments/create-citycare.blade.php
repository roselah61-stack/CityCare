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
                        <i class="bi bi-calendar-plus"></i> Schedule Appointment
                    </div>
                    <h1 class="fw-900 mb-0" style="font-size: clamp(20px, 3vw, 32px); line-height: 1.2; text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3); color: white;">
                        New Medical Appointment
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
                <a href="{{ route('appointments.index') }}" class="btn btn-light border rounded-pill px-3 py-2 fw-600 small d-flex align-items-center gap-2 flex-grow-1 flex-sm-grow-0 justify-content-center transition-all hover-lift" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3); color: #1e293b;">
                    <i class="bi bi-arrow-left"></i> <span class="d-none d-sm-inline">Back to List</span>
                </a>
                <button class="btn rounded-pill px-3 py-2 d-flex align-items-center gap-2 flex-grow-1 flex-sm-grow-0 justify-content-center transition-all hover-lift" style="background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%); color: white; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4); border: none;" onclick="document.getElementById('appointmentForm').submit()">
                    <i class="bi bi-calendar-check"></i> <span class="d-none d-sm-inline">Schedule Now</span>
                    <span class="d-sm-none">Schedule</span>
                </button>
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
        <!-- Main Form Column -->
        <div class="col-lg-8">
            <div class="data-card">
                <div class="card-head">
                    <div class="section-title">
                        <i class="bi bi-calendar-plus text-primary"></i>
                        Appointment Details
                    </div>
                    <div class="d-flex gap-2">
                        <span class="badge bg-primary rounded-pill px-3">Step 1 of 3</span>
                    </div>
                </div>

                <form id="appointmentForm" method="POST" action="{{ route('appointments.store') }}">
                    @csrf
                    
                    <!-- Patient Information Section -->
                    <div class="mb-4 p-4 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; font-size: 14px;">
                                <i class="bi bi-person"></i>
                            </div>
                            <h5 class="mb-0 fw-bold">Patient Information</h5>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-600">Patient Name *</label>
                                <input type="text" name="patient_name" class="form-control form-control-lg" placeholder="Enter patient full name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">Email Address</label>
                                <input type="email" name="patient_email" class="form-control form-control-lg" placeholder="patient@email.com">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">Phone Number *</label>
                                <input type="tel" name="patient_phone" class="form-control form-control-lg" placeholder="0771234567" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">Date of Birth</label>
                                <input type="date" name="patient_dob" class="form-control form-control-lg">
                            </div>
                        </div>
                    </div>

                    <!-- Doctor Selection Section -->
                    <div class="mb-4 p-4 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; font-size: 14px;">
                                <i class="bi bi-person-badge"></i>
                            </div>
                            <h5 class="mb-0 fw-bold">Doctor Selection</h5>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-600">Select Doctor *</label>
                                <select name="doctor_name" class="form-select form-select-lg" required>
                                    <option value="">Choose a doctor</option>
                                    <option value="Dr. Sarah Nankya">Dr. Sarah Nankya - General Medicine</option>
                                    <option value="Dr. Michael Mwanga">Dr. Michael Mwanga - Cardiology</option>
                                    <option value="Dr. Rebecca Nakato">Dr. Rebecca Nakato - Pediatrics</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">Department</label>
                                <select name="department" class="form-select form-select-lg">
                                    <option value="">Select department</option>
                                    <option value="General Medicine">General Medicine</option>
                                    <option value="Cardiology">Cardiology</option>
                                    <option value="Pediatrics">Pediatrics</option>
                                    <option value="Orthopedics">Orthopedics</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Schedule Section -->
                    <div class="mb-4 p-4 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-warning text-white d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; font-size: 14px;">
                                <i class="bi bi-calendar"></i>
                            </div>
                            <h5 class="mb-0 fw-bold">Schedule Information</h5>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-600">Appointment Date *</label>
                                <input type="date" name="appointment_date" class="form-control form-control-lg" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">Appointment Time *</label>
                                <input type="time" name="appointment_time" class="form-control form-control-lg" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">Appointment Type</label>
                                <select name="appointment_type" class="form-select form-select-lg">
                                    <option value="Regular">Regular Check-up</option>
                                    <option value="Follow-up">Follow-up</option>
                                    <option value="Emergency">Emergency</option>
                                    <option value="Consultation">Consultation</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">Duration</label>
                                <select name="duration" class="form-select form-select-lg">
                                    <option value="30">30 minutes</option>
                                    <option value="45">45 minutes</option>
                                    <option value="60">1 hour</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Reason for Visit Section -->
                    <div class="mb-4 p-4 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; font-size: 14px;">
                                <i class="bi bi-clipboard-text"></i>
                            </div>
                            <h5 class="mb-0 fw-bold">Reason for Visit</h5>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-600">Chief Complaint *</label>
                            <input type="text" name="chief_complaint" class="form-control form-control-lg" placeholder="Brief description of the main issue" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-600">Detailed Description</label>
                            <textarea name="reason" class="form-control form-control-lg" rows="4" placeholder="Provide detailed information about the patient's condition, symptoms, or reason for visit..."></textarea>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('appointments.index') }}" class="btn btn-light btn-lg rounded-3 px-4">
                            <i class="bi bi-x-circle me-2"></i>Cancel
                        </a>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-primary btn-lg rounded-3 px-4">
                                <i class="bi bi-save me-2"></i>Save Draft
                            </button>
                            <button type="submit" class="btn btn-ent btn-lg rounded-3 px-4">
                                <i class="bi bi-calendar-check me-2"></i>Schedule Appointment
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar Column -->
        <div class="col-lg-4">
            <!-- Quick Tips Card -->
            <div class="data-card mb-4">
                <div class="card-head">
                    <div class="section-title">
                        <i class="bi bi-info-circle text-primary"></i>
                        Quick Tips
                    </div>
                </div>
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2" style="width: 32px; height: 32px; font-size: 14px;">
                            <i class="bi bi-1"></i>
                        </div>
                        <div>
                            <div class="fw-bold small">Fill Required Fields</div>
                            <div class="text-muted small">All fields marked with * are mandatory</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-circle bg-success bg-opacity-10 text-success p-2" style="width: 32px; height: 32px; font-size: 14px;">
                            <i class="bi bi-2"></i>
                        </div>
                        <div>
                            <div class="fw-bold small">Choose Right Doctor</div>
                            <div class="text-muted small">Select based on specialization</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-circle bg-warning bg-opacity-10 text-warning p-2" style="width: 32px; height: 32px; font-size: 14px;">
                            <i class="bi bi-3"></i>
                        </div>
                        <div>
                            <div class="fw-bold small">Schedule Smartly</div>
                            <div class="text-muted small">Pick convenient date and time</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-circle bg-info bg-opacity-10 text-info p-2" style="width: 32px; height: 32px; font-size: 14px;">
                            <i class="bi bi-4"></i>
                        </div>
                        <div>
                            <div class="fw-bold small">Provide Details</div>
                            <div class="text-muted small">Help doctors prepare better</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Available Time Slots -->
            <div class="data-card mb-4">
                <div class="card-head">
                    <div class="section-title">
                        <i class="bi bi-clock text-success"></i>
                        Available Time Slots
                    </div>
                    <span class="badge bg-success rounded-pill px-3">Today</span>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-outline-primary rounded-3 btn-sm">9:00 AM</button>
                    <button class="btn btn-outline-primary rounded-3 btn-sm">9:30 AM</button>
                    <button class="btn btn-outline-secondary rounded-3 btn-sm">10:00 AM</button>
                    <button class="btn btn-outline-primary rounded-3 btn-sm">10:30 AM</button>
                    <button class="btn btn-outline-primary rounded-3 btn-sm">11:00 AM</button>
                    <button class="btn btn-outline-secondary rounded-3 btn-sm">11:30 AM</button>
                    <button class="btn btn-outline-primary rounded-3 btn-sm">2:00 PM</button>
                    <button class="btn btn-outline-primary rounded-3 btn-sm">2:30 PM</button>
                    <button class="btn btn-outline-secondary rounded-3 btn-sm">3:00 PM</button>
                    <button class="btn btn-outline-primary rounded-3 btn-sm">3:30 PM</button>
                    <button class="btn btn-outline-primary rounded-3 btn-sm">4:00 PM</button>
                    <button class="btn btn-outline-secondary rounded-3 btn-sm">4:30 PM</button>
                </div>
                <div class="mt-3 p-3 rounded-3" style="background: #f8fafc;">
                    <div class="d-flex align-items-center gap-2 text-muted small">
                        <i class="bi bi-info-circle"></i>
                        <span>Gray slots are already booked</span>
                    </div>
                </div>
            </div>

            <!-- Doctor Availability -->
            <div class="data-card">
                <div class="card-head">
                    <div class="section-title">
                        <i class="bi bi-people text-warning"></i>
                        Doctor Availability
                    </div>
                </div>
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex align-items-center justify-content-between p-3 rounded-3 border">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-avatar" style="background: #dbeafe; color: #2563eb;">S</div>
                            <div>
                                <div class="fw-bold small">Dr. Sarah Nankya</div>
                                <div class="text-muted" style="font-size: 11px;">General Medicine</div>
                            </div>
                        </div>
                        <div class="text-success">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between p-3 rounded-3 border">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-avatar" style="background: #dcfce7; color: #16a34a;">M</div>
                            <div>
                                <div class="fw-bold small">Dr. Michael Mwanga</div>
                                <div class="text-muted" style="font-size: 11px;">Cardiology</div>
                            </div>
                        </div>
                        <div class="text-success">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between p-3 rounded-3 border">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-avatar" style="background: #fef3c7; color: #92400e;">R</div>
                            <div>
                                <div class="fw-bold small">Dr. Rebecca Nakato</div>
                                <div class="text-muted" style="font-size: 11px;">Pediatrics</div>
                            </div>
                        </div>
                        <div class="text-warning">
                            <i class="bi bi-clock-fill"></i>
                        </div>
                    </div>
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

/* Form Styles */
.form-control-lg {
    border-radius: 0.5rem;
    border: 1px solid #e2e8f0;
    padding: 0.75rem 1rem;
    font-weight: 500;
}

.form-control-lg:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
}

.form-select-lg {
    border-radius: 0.5rem;
    border: 1px solid #e2e8f0;
    padding: 0.75rem 1rem;
    font-weight: 500;
}

.form-select-lg:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
}

.form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

/* Avatar */
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
    
    .form-control-lg, .form-select-lg {
        padding: 0.625rem 0.75rem;
        font-size: 0.875rem;
    }
}
</style>
@endsection
