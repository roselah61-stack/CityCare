@extends('layouts.app')

@section('page-title', 'My Medical Profile')

@push('styles')
<style>
.patient-profile-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    padding: 2rem;
    margin-bottom: 2rem;
    color: white;
}
.profile-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 4px solid white;
    background: rgba(255, 255, 255, 0.1);
}
.info-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 12px;
    padding: 1.5rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- Profile Header -->
    <div class="patient-profile-section text-center mb-4">
        <div class="position-relative">
            <div class="profile-avatar mx-auto mb-3">
                <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=667eea&color=fff" 
                     alt="{{ auth()->user()->name }}" 
                     class="rounded-circle">
            </div>
            <h2 class="fw-bold mb-1">{{ auth()->user()->name }}</h2>
            <div class="d-flex justify-content-center gap-2">
                <span class="badge bg-success bg-opacity-25 text-success rounded-pill px-3 py-1">
                    <i class="bi bi-check-circle-fill me-1"></i> Active
                </span>
                <span class="badge bg-info bg-opacity-25 text-info rounded-pill px-3 py-1">
                    <i class="bi bi-calendar-check me-1"></i> Member Since {{ $patient->created_at ? $patient->created_at->format('Y') : 'N/A' }}
                </span>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Personal Information -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 p-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box bg-primary bg-opacity-10 rounded-3 p-2">
                        <i class="bi bi-person-circle text-primary fs-5"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Personal Information</h5>
                        <p class="text-muted small mb-0">Update your personal details</p>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <form id="profileForm">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">First Name</label>
                            <input type="text" class="form-control" name="first_name" value="{{ $patient->first_name ?? auth()->user()->name }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Last Name</label>
                            <input type="text" class="form-control" name="last_name" value="{{ $patient->last_name ?? '' }}" required>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control" name="email" value="{{ $patient->email ?? auth()->user()->email }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Phone</label>
                            <input type="tel" class="form-control" name="phone" value="{{ $patient->phone ?? '' }}">
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold">Address</label>
                            <input type="text" class="form-control" name="address" value="{{ $patient->address ?? '' }}">
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-check-lg me-2"></i> Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Medical Information -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 p-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box bg-success bg-opacity-10 rounded-3 p-2">
                        <i class="bi bi-heart-pulse text-success fs-5"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Medical Information</h5>
                        <p class="text-muted small mb-0">Update your medical details</p>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <form id="medicalForm">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Date of Birth</label>
                            <input type="date" class="form-control" name="date_of_birth" value="{{ $patient->date_of_birth ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Gender</label>
                            <select class="form-select" name="gender">
                                <option value="">Select Gender</option>
                                <option value="male" {{ $patient->gender === 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ $patient->gender === 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ $patient->gender === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Blood Type</label>
                            <select class="form-select" name="blood_type">
                                <option value="">Select Blood Type</option>
                                <option value="A+" {{ $patient->blood_type === 'A+' ? 'selected' : '' }}>A+</option>
                                <option value="A-" {{ $patient->blood_type === 'A-' ? 'selected' : '' }}>A-</option>
                                <option value="B+" {{ $patient->blood_type === 'B+' ? 'selected' : '' }}>B+</option>
                                <option value="B-" {{ $patient->blood_type === 'B-' ? 'selected' : '' }}>B-</option>
                                <option value="AB+" {{ $patient->blood_type === 'AB+' ? 'selected' : '' }}>AB+</option>
                                <option value="AB-" {{ $patient->blood_type === 'AB-' ? 'selected' : '' }}>AB-</option>
                                <option value="O+" {{ $patient->blood_type === 'O+' ? 'selected' : '' }}>O+</option>
                                <option value="O-" {{ $patient->blood_type === 'O-' ? 'selected' : '' }}>O-</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Allergies</label>
                            <textarea class="form-control" name="allergies" rows="3">{{ $patient->allergies ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Medications</label>
                            <textarea class="form-control" name="medications" rows="3">{{ $patient->medications ?? '' }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Medical Conditions</label>
                            <textarea class="form-control" name="medical_conditions" rows="3">{{ $patient->medical_conditions ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-success rounded-pill px-4">
                            <i class="bi bi-heart-pulse me-2"></i> Update Medical Info
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Insurance Information -->
<div class="row g-4 mt-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 p-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box bg-warning bg-opacity-10 rounded-3 p-2">
                        <i class="bi bi-shield-check text-warning fs-5"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Insurance Information</h5>
                        <p class="text-muted small mb-0">Manage your insurance details</p>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <form id="insuranceForm">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Insurance Provider</label>
                            <input type="text" class="form-control" name="insurance_provider" value="{{ $patient->insurance_provider ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Policy Number</label>
                            <input type="text" class="form-control" name="policy_number" value="{{ $patient->policy_number ?? '' }}">
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Group Number</label>
                            <input type="text" class="form-control" name="group_number" value="{{ $patient->group_number ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Emergency Contact</label>
                            <input type="text" class="form-control" name="emergency_contact" value="{{ $patient->emergency_contact ?? '' }}">
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-warning rounded-pill px-4">
                            <i class="bi bi-shield-check me-2"></i> Update Insurance Info
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Security Settings -->
<div class="row g-4 mt-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 p-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box bg-info bg-opacity-10 rounded-3 p-2">
                        <i class="bi bi-lock-fill text-info fs-5"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Security Settings</h5>
                        <p class="text-muted small mb-0">Manage your account security</p>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="info-card text-center">
                            <i class="bi bi-key-fill text-info fs-1 mb-2"></i>
                            <h6 class="fw-bold">Change Password</h6>
                            <p class="text-muted small mb-3">Last changed: 30 days ago</p>
                            <button class="btn btn-outline-info btn-sm rounded-pill">Update</button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-card text-center">
                            <i class="bi bi-shield-check text-success fs-1 mb-2"></i>
                            <h6 class="fw-bold">Two-Factor Auth</h6>
                            <p class="text-muted small mb-3">Status: <span class="badge bg-success bg-opacity-25 text-success rounded-pill px-2 py-1">Enabled</span></p>
                            <button class="btn btn-outline-success btn-sm rounded-pill">Configure</button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-card text-center">
                            <i class="bi bi-eye-slash text-warning fs-1 mb-2"></i>
                            <h6 class="fw-bold">Privacy Settings</h6>
                            <p class="text-muted small mb-3">Profile visibility: Public</p>
                            <button class="btn btn-outline-warning btn-sm rounded-pill">Manage</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/patient-dashboard.js') }}"></script>
@endpush

<div class="row g-4">
    <!-- Personal Information -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 p-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box bg-primary bg-opacity-10 rounded-3 p-2">
                        <i class="bi bi-person text-primary fs-5"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Personal Information</h5>
                        <p class="text-muted small mb-0">Your basic contact details</p>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <form id="profileForm">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-600 text-muted">First Name</label>
                            <input type="text" class="form-control" value="{{ $patient->first_name ?? auth()->user()->name }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-600 text-muted">Last Name</label>
                            <input type="text" class="form-control" value="{{ $patient->last_name ?? '' }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-600 text-muted">Email Address</label>
                            <input type="email" class="form-control" value="{{ auth()->user()->email }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-600 text-muted">Phone Number</label>
                            <input type="tel" class="form-control" value="{{ $patient->phone ?? '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-600 text-muted">Date of Birth</label>
                            <input type="date" class="form-control" value="{{ $patient->date_of_birth ?? '' }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-600 text-muted">Address</label>
                            <textarea class="form-control" rows="2">{{ $patient->address ?? '' }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-600 text-muted">Gender</label>
                            <select class="form-select">
                                <option value="male" {{ ($patient->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ ($patient->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ ($patient->gender ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-600 text-muted">Blood Type</label>
                            <select class="form-select">
                                <option value="">Select Blood Type</option>
                                <option value="A+" {{ ($patient->blood_type ?? '') == 'A+' ? 'selected' : '' }}>A+</option>
                                <option value="A-" {{ ($patient->blood_type ?? '') == 'A-' ? 'selected' : '' }}>A-</option>
                                <option value="B+" {{ ($patient->blood_type ?? '') == 'B+' ? 'selected' : '' }}>B+</option>
                                <option value="B-" {{ ($patient->blood_type ?? '') == 'B-' ? 'selected' : '' }}>B-</option>
                                <option value="O+" {{ ($patient->blood_type ?? '') == 'O+' ? 'selected' : '' }}>O+</option>
                                <option value="O-" {{ ($patient->blood_type ?? '') == 'O-' ? 'selected' : '' }}>O-</option>
                                <option value="AB+" {{ ($patient->blood_type ?? '') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                <option value="AB-" {{ ($patient->blood_type ?? '') == 'AB-' ? 'selected' : '' }}>AB-</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-check-lg me-2"></i> Save Changes
                        </button>
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="bi bi-x-lg me-2"></i> Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Medical Information -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 p-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box bg-success bg-opacity-10 rounded-3 p-2">
                        <i class="bi bi-heart-pulse text-success fs-5"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Medical Information</h5>
                        <p class="text-muted small mb-0">Your health-related details</p>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <form id="medicalForm">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-600 text-muted">Allergies</label>
                            <textarea class="form-control" rows="2" placeholder="List any known allergies...">{{ $patient->allergies ?? '' }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-600 text-muted">Current Medications</label>
                            <textarea class="form-control" rows="2" placeholder="List current medications...">{{ $patient->current_medications ?? '' }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-600 text-muted">Medical Conditions</label>
                            <textarea class="form-control" rows="2" placeholder="List any chronic conditions...">{{ $patient->medical_conditions ?? '' }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-600 text-muted">Emergency Contact</label>
                            <input type="text" class="form-control" value="{{ $patient->emergency_contact ?? '' }}" placeholder="Emergency contact name and phone">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-600 text-muted">Insurance Provider</label>
                            <input type="text" class="form-control" value="{{ $patient->insurance_provider ?? '' }}" placeholder="Insurance company name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-600 text-muted">Policy Number</label>
                            <input type="text" class="form-control" value="{{ $patient->policy_number ?? '' }}" placeholder="Insurance policy number">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-600 text-muted">Family Doctor</label>
                            <input type="text" class="form-control" value="{{ $patient->family_doctor ?? '' }}" placeholder="Primary care physician">
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-success rounded-pill px-4">
                            <i class="bi bi-check-lg me-2"></i> Save Medical Info
                        </button>
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="bi bi-x-lg me-2"></i> Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Security Settings -->
<div class="row g-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 p-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box bg-warning bg-opacity-10 rounded-3 p-2">
                        <i class="bi bi-shield-check text-warning fs-5"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Security Settings</h5>
                        <p class="text-muted small mb-0">Manage your account security</p>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="security-item p-4 rounded-3" style="background: #f8fafc;">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <h6 class="fw-bold text-dark mb-1">Change Password</h6>
                                    <p class="text-muted small mb-0">Update your account password</p>
                                </div>
                                <i class="bi bi-lock text-primary fs-4"></i>
                            </div>
                            <button class="btn btn-outline-primary rounded-pill px-3">
                                <i class="bi bi-key me-1"></i> Change Password
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="security-item p-4 rounded-3" style="background: #f8fafc;">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <h6 class="fw-bold text-dark mb-1">Two-Factor Authentication</h6>
                                    <p class="text-muted small mb-0">Add an extra layer of security</p>
                                </div>
                                <i class="bi bi-phone text-warning fs-4"></i>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="twoFactor">
                                <label class="form-check-label small" for="twoFactor">
                                    Enable 2FA
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="security-item p-4 rounded-3" style="background: #f8fafc;">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <h6 class="fw-bold text-dark mb-1">Email Notifications</h6>
                                    <p class="text-muted small mb-0">Receive appointment reminders</p>
                                </div>
                                <i class="bi bi-envelope text-info fs-4"></i>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                                <label class="form-check-label small" for="emailNotifications">
                                    Email Reminders
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="security-item p-4 rounded-3" style="background: #f8fafc;">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <h6 class="fw-bold text-dark mb-1">Privacy Settings</h6>
                                    <p class="text-muted small mb-0">Control data sharing preferences</p>
                                </div>
                                <i class="bi bi-eye-slash text-danger fs-4"></i>
                            </div>
                            <button class="btn btn-outline-secondary rounded-pill px-3">
                                <i class="bi bi-gear me-1"></i> Manage Privacy
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.security-item:hover {
    background: #e2e8f0 !important;
    transition: all 0.3s ease;
}
</style>

@endsection
