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
                        <i class="bi bi-calendar-plus-fill"></i> Book Appointment
                    </div>
                    <h1 class="fw-900 mb-0" style="font-size: clamp(20px, 3vw, 32px); line-height: 1.2; text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3); color: white; white-space: nowrap;">
                        Schedule Your <span style="color: #fbbf24; text-shadow: 0 2px 8px rgba(251, 191, 36, 0.5);">Medical Visit</span>
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
                <a href="{{ route('dashboard') }}" class="btn btn-light border rounded-pill px-3 py-2 fw-600 small d-flex align-items-center gap-2 flex-grow-1 flex-sm-grow-0 justify-content-center transition-all hover-lift" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3); color: #1e293b;">
                    <i class="bi bi-arrow-left"></i> <span class="d-none d-sm-inline">Back to Dashboard</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Appointment Booking Form -->
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 p-3">
                <div class="section-header">
                    <h5 class="section-title mb-0">
                        <i class="bi bi-calendar-plus text-primary"></i> Book New Appointment
                    </h5>
                </div>
            </div>
            <div class="card-body p-3">
                @if(session('success'))
                    <div class="alert alert-success border-0 bg-success bg-opacity-10 text-success mb-4">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger mb-4">
                        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('patient.appointment.store') }}">
                    @csrf
                    <div class="row g-3">
                        <!-- Doctor Selection -->
                        <div class="col-md-12">
                            <label for="doctor_id" class="form-label fw-600">
                                <i class="bi bi-person-badge text-primary me-2"></i>Select Doctor
                            </label>
                            <select name="doctor_id" id="doctor_id" class="form-select rounded-3 border-0 bg-light" required>
                                <option value="">Choose a doctor...</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                @endforeach
                            </select>
                            @error('doctor_id')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Appointment Date -->
                        <div class="col-md-6">
                            <label for="appointment_date" class="form-label fw-600">
                                <i class="bi bi-calendar-event text-primary me-2"></i>Appointment Date
                            </label>
                            <input type="date" name="appointment_date" id="appointment_date" 
                                   class="form-control rounded-3 border-0 bg-light" 
                                   min="{{ now()->format('Y-m-d') }}" required>
                            @error('appointment_date')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Appointment Time -->
                        <div class="col-md-6">
                            <label for="appointment_time" class="form-label fw-600">
                                <i class="bi bi-clock text-primary me-2"></i>Appointment Time
                            </label>
                            <select name="appointment_time" id="appointment_time" class="form-select rounded-3 border-0 bg-light" required>
                                <option value="">Select time...</option>
                                <option value="09:00">09:00 AM</option>
                                <option value="09:30">09:30 AM</option>
                                <option value="10:00">10:00 AM</option>
                                <option value="10:30">10:30 AM</option>
                                <option value="11:00">11:00 AM</option>
                                <option value="11:30">11:30 AM</option>
                                <option value="14:00">02:00 PM</option>
                                <option value="14:30">02:30 PM</option>
                                <option value="15:00">03:00 PM</option>
                                <option value="15:30">03:30 PM</option>
                                <option value="16:00">04:00 PM</option>
                                <option value="16:30">04:30 PM</option>
                            </select>
                            @error('appointment_time')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Reason for Visit -->
                        <div class="col-md-12">
                            <label for="reason" class="form-label fw-600">
                                <i class="bi bi-chat-text text-primary me-2"></i>Reason for Visit
                            </label>
                            <textarea name="reason" id="reason" rows="4" 
                                      class="form-control rounded-3 border-0 bg-light" 
                                      placeholder="Please describe the reason for your visit..." required></textarea>
                            @error('reason')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="col-md-12">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('dashboard') }}" class="btn btn-light border rounded-pill px-4 fw-600">
                                    <i class="bi bi-x-circle me-2"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary rounded-pill px-4 fw-600">
                                    <i class="bi bi-calendar-check me-2"></i>Book Appointment
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Information Card -->
        <div class="card border-0 shadow-sm rounded-4 mt-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-start gap-3">
                    <div class="info-icon bg-info bg-opacity-10 text-info rounded-circle p-2" style="width: 40px; height: 40px;">
                        <i class="bi bi-info-circle"></i>
                    </div>
                    <div class="info-content">
                        <h6 class="fw-600 mb-2">Appointment Guidelines</h6>
                        <ul class="small text-muted mb-0">
                            <li>Please arrive 15 minutes before your scheduled appointment time</li>
                            <li>Bring your ID card and any relevant medical documents</li>
                            <li>If you need to cancel, please do so at least 24 hours in advance</li>
                            <li>Emergency appointments are available - please call our reception</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Professional Book Appointment Styles */

/* Welcome Badge */
.welcome-badge-inline {
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
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

/* Form Styling */
.form-control, .form-select {
    border: 1px solid #e2e8f0;
    transition: all 0.2s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-label {
    color: #374151;
    margin-bottom: 0.5rem;
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
    .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
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
