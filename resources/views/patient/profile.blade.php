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
                        <i class="bi bi-person-badge-fill"></i> Medical Profile
                    </div>
                    <h1 class="fw-900 mb-0" style="font-size: clamp(20px, 3vw, 32px); line-height: 1.2; text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3); color: white; white-space: nowrap;">
                        Manage Your <span style="color: #fbbf24; text-shadow: 0 2px 8px rgba(251, 191, 36, 0.5);">Health Information</span>
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

<div class="row g-4">
    <!-- Profile Form -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 p-3">
                <div class="section-header">
                    <h5 class="section-title mb-0">
                        <i class="bi bi-person-gear text-primary"></i> Personal Information
                    </h5>
                </div>
            </div>
            <div class="card-body p-3">
                @if(session('success'))
                    <div class="alert alert-success border-0 bg-success bg-opacity-10 text-success mb-4">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif
                
                <form method="POST" action="{{ route('patient.profile.update') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-600">
                                <i class="bi bi-person text-primary me-2"></i>Full Name
                            </label>
                            <input type="text" class="form-control rounded-3 border-0 bg-light" id="name" name="name" value="{{ $patient->name }}" required>
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-600">
                                <i class="bi bi-envelope text-primary me-2"></i>Email Address
                            </label>
                            <input type="email" class="form-control rounded-3 border-0 bg-light" id="email" name="email" value="{{ $patient->email }}" required>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-600">
                                <i class="bi bi-telephone text-primary me-2"></i>Phone Number
                            </label>
                            <input type="tel" class="form-control rounded-3 border-0 bg-light" id="phone" name="phone" value="{{ $patient->phone }}">
                            @error('phone')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="date_of_birth" class="form-label fw-600">
                                <i class="bi bi-calendar-event text-primary me-2"></i>Date of Birth
                            </label>
                            <input type="date" class="form-control rounded-3 border-0 bg-light" id="date_of_birth" name="date_of_birth" value="{{ $patient->date_of_birth ?? '' }}">
                            @error('date_of_birth')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="address" class="form-label fw-600">
                                <i class="bi bi-geo-alt text-primary me-2"></i>Address
                            </label>
                            <textarea class="form-control rounded-3 border-0 bg-light" id="address" name="address" rows="2">{{ $patient->address ?? '' }}</textarea>
                            @error('address')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="emergency_contact" class="form-label fw-600">
                                <i class="bi bi-telephone-plus text-primary me-2"></i>Emergency Contact
                            </label>
                            <input type="text" class="form-control rounded-3 border-0 bg-light" id="emergency_contact" name="emergency_contact" value="{{ $patient->emergency_contact ?? '' }}" placeholder="Name and phone number">
                            @error('emergency_contact')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-600">
                            <i class="bi bi-check-circle me-2"></i>Update Profile
                        </button>
                        <a href="{{ route('dashboard') }}" class="btn btn-light border rounded-pill px-4 fw-600 ms-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Medical Information -->
        <div class="card border-0 shadow-sm rounded-4 mt-4">
            <div class="card-header bg-white border-0 p-3">
                <div class="section-header">
                    <h5 class="section-title mb-0">
                        <i class="bi bi-heart-pulse text-primary"></i> Medical Information
                    </h5>
                </div>
            </div>
            <div class="card-body p-3">
                <form method="POST" action="{{ route('patient.profile.update') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="medical_history" class="form-label fw-600">
                                <i class="bi bi-clipboard-pulse text-primary me-2"></i>Medical History
                            </label>
                            <textarea class="form-control rounded-3 border-0 bg-light" id="medical_history" name="medical_history" rows="4" placeholder="Please describe any past medical conditions, surgeries, or chronic illnesses...">{{ $patient->medical_history ?? '' }}</textarea>
                            @error('medical_history')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Include any chronic conditions, past surgeries, or ongoing treatments</small>
                        </div>
                        <div class="col-12">
                            <label for="allergies" class="form-label fw-600">
                                <i class="bi bi-exclamation-triangle text-primary me-2"></i>Allergies
                            </label>
                            <textarea class="form-control rounded-3 border-0 bg-light" id="allergies" name="allergies" rows="3" placeholder="List any known allergies (medications, food, environmental)...">{{ $patient->allergies ?? '' }}</textarea>
                            @error('allergies')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Important for your safety during treatments and medication prescriptions</small>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-600">
                            <i class="bi bi-check-circle me-2"></i>Update Medical Information
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Profile Summary -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 p-3">
                <div class="section-header">
                    <h5 class="section-title mb-0">
                        <i class="bi bi-person-circle text-primary"></i> Profile Summary
                    </h5>
                </div>
            </div>
            <div class="card-body p-3 text-center">
                <div class="profile-avatar-large mb-3">
                    <div class="avatar-circle-large bg-primary text-white mx-auto" style="width: 100px; height: 100px; font-size: 2.5rem; line-height: 100px;">
                        {{ strtoupper(substr($patient->name, 0, 2)) }}
                    </div>
                </div>
                <h5 class="mb-1 fw-600">{{ $patient->name }}</h5>
                <p class="text-muted mb-3">{{ $patient->email }}</p>
                <div class="profile-stats d-flex justify-content-around mb-3">
                    <div class="stat-item text-center">
                        <div class="stat-value fw-bold text-primary">{{ \App\Models\Appointment::where('patient_id', $patient->id)->count() }}</div>
                        <div class="stat-label small text-muted">Total Visits</div>
                    </div>
                    <div class="stat-item text-center">
                        <div class="stat-value fw-bold text-success">{{ \App\Models\Consultation::where('patient_id', $patient->id)->count() }}</div>
                        <div class="stat-label small text-muted">Consultations</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Change Password -->
        <div class="card border-0 shadow-sm rounded-4 mt-4">
            <div class="card-header bg-white border-0 p-3">
                <div class="section-header">
                    <h5 class="section-title mb-0">
                        <i class="bi bi-shield-lock text-primary"></i> Security
                    </h5>
                </div>
            </div>
            <div class="card-body p-3">
                <form method="POST" action="{{ route('patient.password.change') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="current_password" class="form-label fw-600">
                            <i class="bi bi-key text-primary me-2"></i>Current Password
                        </label>
                        <input type="password" class="form-control rounded-3 border-0 bg-light" id="current_password" name="current_password" required>
                        @error('current_password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label fw-600">
                            <i class="bi bi-lock text-primary me-2"></i>New Password
                        </label>
                        <input type="password" class="form-control rounded-3 border-0 bg-light" id="password" name="password" required>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Minimum 8 characters</small>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label fw-600">
                            <i class="bi bi-lock-fill text-primary me-2"></i>Confirm New Password
                        </label>
                        <input type="password" class="form-control rounded-3 border-0 bg-light" id="password_confirmation" name="password_confirmation" required>
                        @error('password_confirmation')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-outline-primary rounded-pill w-100 fw-600">
                        <i class="bi bi-key me-2"></i>Change Password
                    </button>
                </form>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card border-0 shadow-sm rounded-4 mt-4">
            <div class="card-header bg-white border-0 p-3">
                <div class="section-header">
                    <h5 class="section-title mb-0">
                        <i class="bi bi-lightning text-primary"></i> Quick Actions
                    </h5>
                </div>
            </div>
            <div class="card-body p-3">
                <div class="d-grid gap-2">
                    <a href="{{ route('patient.book.appointment') }}" class="btn btn-primary rounded-pill fw-600">
                        <i class="bi bi-calendar-plus me-2"></i>Book Appointment
                    </a>
                    <a href="{{ route('patient.appointments') }}" class="btn btn-outline-primary rounded-pill fw-600">
                        <i class="bi bi-calendar-check me-2"></i>View Appointments
                    </a>
                    <a href="{{ route('patient.payments') }}" class="btn btn-outline-primary rounded-pill fw-600">
                        <i class="bi bi-receipt me-2"></i>Payment History
                    </a>
                    <a href="{{ route('patient.medical.history') }}" class="btn btn-outline-primary rounded-pill fw-600">
                        <i class="bi bi-clipboard-pulse me-2"></i>Medical History
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Professional Patient Profile Styles - Based on Admin Dashboard */

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

.section-title .badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.75rem;
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

/* Profile Avatar */
.avatar-circle-large {
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Profile Stats */
.profile-stats .stat-value {
    font-size: 1.5rem;
    line-height: 1.2;
}

.profile-stats .stat-label {
    font-size: 0.75rem;
    line-height: 1.4;
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
    
    .profile-stats {
        flex-direction: column;
        gap: 1rem;
    }
    
    .profile-stats .stat-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .profile-stats .stat-item:last-child {
        border-bottom: none;
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
