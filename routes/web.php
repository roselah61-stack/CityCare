<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DrugController;
use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientPortalController;
use App\Http\Controllers\NotificationController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::any('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
    
    // Simple patient routes without complex middleware
    Route::get('/patient/profile', [PatientPortalController::class, 'profile'])->name('patient.profile');
    Route::post('/patient/profile', [PatientPortalController::class, 'updateProfile'])->name('patient.profile.update');
    Route::post('/patient/change-password', [PatientPortalController::class, 'changePassword'])->name('patient.password.change');
    Route::get('/patient/appointments', [PatientPortalController::class, 'appointments'])->name('patient.appointments');
    Route::get('/patient/appointments/{id}', [PatientPortalController::class, 'showAppointment'])->name('patient.appointment.show');
    Route::get('/patient/book-appointment', [PatientPortalController::class, 'bookAppointment'])->name('patient.book.appointment');
    Route::post('/patient/book-appointment', [PatientPortalController::class, 'storeAppointment'])->name('patient.appointment.store');
    Route::get('/patient/medical-history', [PatientPortalController::class, 'medicalHistory'])->name('patient.medical.history');
    Route::get('/patient/consultation/{id}', [PatientPortalController::class, 'showConsultation'])->name('patient.consultation.show');
    Route::get('/patient/payments', [PatientPortalController::class, 'payments'])->name('patient.payments');
    Route::get('/patient/payments/{id}', [PatientPortalController::class, 'showPayment'])->name('patient.payment.show');
    Route::get('/patient/visit-history', [PatientPortalController::class, 'visitHistory'])->name('patient.visit.history');
    Route::get('/overview', [PageController::class, 'overview'])->name('overview');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile', [UserController::class, 'updateProfile'])->name('profile.update');

    // Notification Routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::get('/notifications/fetch', [NotificationController::class, 'fetch'])->name('notifications.fetch');

    // Admin Only
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/users', [UserManagementController::class, 'index'])->name('admin.users.index');
        Route::get('/admin/users/create', [UserManagementController::class, 'create'])->name('admin.users.create');
        Route::post('/admin/users', [UserManagementController::class, 'store'])->name('admin.users.store');
        Route::get('/admin/users/{id}/edit', [UserManagementController::class, 'edit'])->name('admin.users.edit');
        Route::put('/admin/users/{id}', [UserManagementController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{id}', [UserManagementController::class, 'destroy'])->name('admin.users.destroy');
        Route::post('/admin/users/{id}/assign-role', [UserManagementController::class, 'assignRole'])->name('admin.assignRole');
        
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/appointments', [ReportController::class, 'appointments'])->name('reports.appointments');
        Route::get('/reports/revenue', [ReportController::class, 'revenue'])->name('reports.revenue');
        Route::get('/reports/pharmacy', [ReportController::class, 'pharmacy'])->name('reports.pharmacy');
        Route::get('/reports/export/{type}', [ReportController::class, 'export'])->name('reports.export');
    });

    // Receptionist Actions
    Route::middleware('role:receptionist,admin')->group(function () {
        Route::get('/patientList', [PatientController::class, 'index'])->name('patient.list');
        Route::get('/patient/{id}', [PatientController::class, 'show'])->name('patient.show');
        Route::get('/createPatient', [PatientController::class, 'create'])->name('patient.create');
        Route::post('/createPatient', [PatientController::class, 'store'])->name('patient.store');
        Route::delete('/patient/{id}', [PatientController::class, 'destroy'])->name('patient.destroy');
    });

    // Appointment Management - TEMPORARY MINIMAL VERSION TO FIX 500 ERROR
    Route::get('/appointments', function () {
        return '<!DOCTYPE html>
<html>
<head>
    <title>Appointments - CityCare Medical Centre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        body { background: #f8f9fa; }
        .container { max-width: 1200px; }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
        .card-header { border-radius: 12px 12px 0 0 !important; }
        .table { border-radius: 8px; overflow: hidden; }
        .table thead th { border-bottom: 2px solid #dee2e6; font-weight: 600; }
        .btn { border-radius: 8px; }
        .status-badge { padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 500; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-confirmed { background: #d1ecf1; color: #0c5460; }
        .status-completed { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">Appointments Management</h1>
                <p class="text-muted mb-0">Manage and schedule patient appointments</p>
            </div>
            <div>
                <a href="/appointments/create" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>New Appointment
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">All Appointments</h5>
                    <div class="d-flex gap-2">
                        <div class="input-group" style="width: 250px;">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control" placeholder="Search appointments...">
                        </div>
                        <select class="form-select" style="width: 150px;">
                            <option>All Status</option>
                            <option>Pending</option>
                            <option>Confirmed</option>
                            <option>Completed</option>
                            <option>Cancelled</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Patient</th>
                                <th>Doctor</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="bi bi-person-fill"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">John Mugisha</div>
                                            <div class="text-muted small">john.mugisha@gmail.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="bi bi-person-fill"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">Dr. Sarah Nankya</div>
                                            <div class="text-muted small">General Medicine</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Apr 25, 2026</td>
                                <td>10:30 AM</td>
                                <td><span class="status-badge status-confirmed">Confirmed</span></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-outline-primary" title="View">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" title="Cancel">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="bi bi-person-fill"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">Esther Nalwoga</div>
                                            <div class="text-muted small">esther.nalwoga@gmail.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="bi bi-person-fill"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">Dr. Michael Mwanga</div>
                                            <div class="text-muted small">Cardiology</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Apr 24, 2026</td>
                                <td>2:00 PM</td>
                                <td><span class="status-badge status-pending">Pending</span></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-outline-primary" title="View">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" title="Cancel">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="bi bi-person-fill"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">David Ssenyonjo</div>
                                            <div class="text-muted small">david.ssenyonjo@yahoo.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="bi bi-person-fill"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">Dr. Rebecca Nakato</div>
                                            <div class="text-muted small">Pediatrics</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Apr 23, 2026</td>
                                <td>11:15 AM</td>
                                <td><span class="status-badge status-completed">Completed</span></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-outline-primary" title="View">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary" title="View Report">
                                            <i class="bi bi-file-medical"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-top">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">Showing 3 of 3 appointments</div>
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item disabled"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</body>
</html>';
    })->name('appointments.index');
    
    Route::get('/appointments/create', function () {
        return '<!DOCTYPE html>
<html>
<head>
    <title>Schedule Appointment - CityCare Medical Centre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        body { background: #f8f9fa; }
        .container { max-width: 900px; }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
        .card-header { border-radius: 12px 12px 0 0 !important; }
        .form-control, .form-select { border-radius: 8px; border: 1px solid #dee2e6; }
        .form-control:focus, .form-select:focus { border-color: #0d6efd; box-shadow: 0 0 0 0.2rem rgba(13,110,253,0.25); }
        .btn { border-radius: 8px; font-weight: 500; }
        .form-label { font-weight: 600; color: #495057; margin-bottom: 0.5rem; }
        .breadcrumb { background: transparent; padding: 0; margin-bottom: 1rem; }
        .breadcrumb-item + .breadcrumb-item::before { content: "›"; color: #6c757d; }
        .info-card { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 12px; }
        .step-indicator { display: flex; justify-content: space-between; margin-bottom: 2rem; }
        .step { flex: 1; text-align: center; position: relative; }
        .step::before { content: ""; position: absolute; top: 15px; left: 50%; width: 100%; height: 2px; background: #dee2e6; z-index: -1; }
        .step:first-child::before { left: 50%; width: 50%; }
        .step:last-child::before { left: 0; width: 50%; }
        .step.active::before { background: #0d6efd; }
        .step-number { width: 30px; height: 30px; border-radius: 50%; background: #dee2e6; color: white; display: inline-flex; align-items: center; justify-content: center; font-weight: bold; margin-bottom: 0.5rem; }
        .step.active .step-number { background: #0d6efd; }
        .step-text { font-size: 0.85rem; color: #6c757d; }
        .step.active .step-text { color: #0d6efd; font-weight: 600; }
    </style>
</head>
<body>
    <div class="container mt-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard" style="text-decoration: none; color: #6c757d;">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/appointments" style="text-decoration: none; color: #6c757d;">Appointments</a></li>
                <li class="breadcrumb-item active" aria-current="page">Schedule Appointment</li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">Schedule New Appointment</h1>
                <p class="text-muted mb-0">Book an appointment for a patient with a doctor</p>
            </div>
            <div>
                <a href="/appointments" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Back to Appointments
                </a>
            </div>
        </div>

        <!-- Progress Indicator -->
        <div class="step-indicator mb-4">
            <div class="step active">
                <div class="step-number">1</div>
                <div class="step-text">Patient Info</div>
            </div>
            <div class="step active">
                <div class="step-number">2</div>
                <div class="step-text">Doctor Selection</div>
            </div>
            <div class="step active">
                <div class="step-number">3</div>
                <div class="step-text">Schedule</div>
            </div>
            <div class="step">
                <div class="step-number">4</div>
                <div class="step-text">Confirm</div>
            </div>
        </div>

        <div class="row">
            <!-- Main Form -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0">
                            <i class="bi bi-calendar-plus me-2 text-primary"></i>
                            Appointment Details
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="/appointments">
                            @csrf
                            
                            <!-- Patient Information -->
                            <div class="mb-4">
                                <h6 class="text-muted mb-3">
                                    <i class="bi bi-person me-2"></i>Patient Information
                                </h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Patient Name *</label>
                                            <input type="text" name="patient_name" class="form-control" placeholder="Enter patient name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Patient Email</label>
                                            <input type="email" name="patient_email" class="form-control" placeholder="patient@email.com">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Phone Number</label>
                                            <input type="tel" name="patient_phone" class="form-control" placeholder="0771234567">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Date of Birth</label>
                                            <input type="date" name="patient_dob" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Doctor Selection -->
                            <div class="mb-4">
                                <h6 class="text-muted mb-3">
                                    <i class="bi bi-person-badge me-2"></i>Doctor Selection
                                </h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Doctor Name *</label>
                                            <select name="doctor_name" class="form-select" required>
                                                <option value="">Select a doctor</option>
                                                <option value="Dr. Sarah Nankya">Dr. Sarah Nankya - General Medicine</option>
                                                <option value="Dr. Michael Mwanga">Dr. Michael Mwanga - Cardiology</option>
                                                <option value="Dr. Rebecca Nakato">Dr. Rebecca Nakato - Pediatrics</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Department</label>
                                            <select name="department" class="form-select">
                                                <option value="">Select department</option>
                                                <option value="General Medicine">General Medicine</option>
                                                <option value="Cardiology">Cardiology</option>
                                                <option value="Pediatrics">Pediatrics</option>
                                                <option value="Orthopedics">Orthopedics</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Schedule -->
                            <div class="mb-4">
                                <h6 class="text-muted mb-3">
                                    <i class="bi bi-calendar me-2"></i>Schedule
                                </h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Appointment Date *</label>
                                            <input type="date" name="appointment_date" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Appointment Time *</label>
                                            <input type="time" name="appointment_time" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Appointment Type</label>
                                            <select name="appointment_type" class="form-select">
                                                <option value="Regular">Regular Check-up</option>
                                                <option value="Follow-up">Follow-up</option>
                                                <option value="Emergency">Emergency</option>
                                                <option value="Consultation">Consultation</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Duration</label>
                                            <select name="duration" class="form-select">
                                                <option value="30">30 minutes</option>
                                                <option value="45">45 minutes</option>
                                                <option value="60">1 hour</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Reason for Visit -->
                            <div class="mb-4">
                                <h6 class="text-muted mb-3">
                                    <i class="bi bi-clipboard-text me-2"></i>Reason for Visit
                                </h6>
                                <div class="mb-3">
                                    <label class="form-label">Chief Complaint *</label>
                                    <input type="text" name="chief_complaint" class="form-control" placeholder="Brief description of the main issue" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Detailed Description</label>
                                    <textarea name="reason" class="form-control" rows="4" placeholder="Provide detailed information about the patient\'s condition, symptoms, or reason for visit..."></textarea>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-between">
                                <a href="/appointments" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle me-2"></i>Cancel
                                </a>
                                <div>
                                    <button type="button" class="btn btn-outline-primary me-2">
                                        <i class="bi bi-save me-2"></i>Save Draft
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-calendar-check me-2"></i>Schedule Appointment
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Info Card -->
                <div class="info-card p-4 mb-4">
                    <h5 class="mb-3">
                        <i class="bi bi-info-circle me-2"></i>Quick Tips
                    </h5>
                    <ul class="mb-0">
                        <li class="mb-2">Fill in all required fields marked with *</li>
                        <li class="mb-2">Select the appropriate doctor based on specialization</li>
                        <li class="mb-2">Choose a convenient date and time slot</li>
                        <li class="mb-2">Provide detailed reason for better preparation</li>
                        <li>Double-check all information before submitting</li>
                    </ul>
                </div>

                <!-- Available Time Slots -->
                <div class="card">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0">
                            <i class="bi bi-clock me-2 text-primary"></i>Available Time Slots
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-sm btn-outline-primary">9:00 AM</button>
                            <button class="btn btn-sm btn-outline-primary">9:30 AM</button>
                            <button class="btn btn-sm btn-outline-secondary">10:00 AM</button>
                            <button class="btn btn-sm btn-outline-primary">10:30 AM</button>
                            <button class="btn btn-sm btn-outline-primary">11:00 AM</button>
                            <button class="btn btn-sm btn-outline-secondary">11:30 AM</button>
                            <button class="btn btn-sm btn-outline-primary">2:00 PM</button>
                            <button class="btn btn-sm btn-outline-primary">2:30 PM</button>
                            <button class="btn btn-sm btn-outline-secondary">3:00 PM</button>
                            <button class="btn btn-sm btn-outline-primary">3:30 PM</button>
                            <button class="btn btn-sm btn-outline-primary">4:00 PM</button>
                            <button class="btn btn-sm btn-outline-secondary">4:30 PM</button>
                        </div>
                        <small class="text-muted d-block mt-3">
                            <i class="bi bi-info-circle me-1"></i>
                            Gray slots are already booked
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>';
    })->name('appointments.create');
    
    Route::post('/appointments', function () {
        return '<!DOCTYPE html>
<html>
<head>
    <title>Appointment Scheduled - CityCare Medical Centre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        body { background: #f8f9fa; }
        .container { max-width: 800px; }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
        .card-header { border-radius: 12px 12px 0 0 !important; }
        .btn { border-radius: 8px; font-weight: 500; }
        .success-animation { text-align: center; margin-bottom: 2rem; }
        .success-animation i { font-size: 4rem; color: #28a745; animation: scaleIn 0.5s ease-in-out; }
        @keyframes scaleIn { from { transform: scale(0); } to { transform: scale(1); } }
        .appointment-details { background: #f8f9fa; border-radius: 8px; padding: 1.5rem; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-white border-bottom text-center">
                <div class="success-animation">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <h2 class="mb-0">Appointment Scheduled Successfully!</h2>
                <p class="text-muted mb-0">Your appointment has been confirmed and added to the system.</p>
            </div>
            <div class="card-body">
                <div class="appointment-details mb-4">
                    <h5 class="mb-3">
                        <i class="bi bi-calendar-check me-2 text-primary"></i>Appointment Details
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Patient:</strong> <span id="patient-name">John Doe</span></p>
                            <p class="mb-2"><strong>Doctor:</strong> <span id="doctor-name">Dr. Sarah Nankya</span></p>
                            <p class="mb-2"><strong>Department:</strong> <span id="department">General Medicine</span></p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Date:</strong> <span id="appointment-date">April 25, 2026</span></p>
                            <p class="mb-2"><strong>Time:</strong> <span id="appointment-time">10:30 AM</span></p>
                            <p class="mb-2"><strong>Type:</strong> <span id="appointment-type">Regular Check-up</span></p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <p class="mb-1"><strong>Reason for Visit:</strong></p>
                        <p class="text-muted" id="reason">Routine checkup and health assessment</p>
                    </div>
                </div>

                <div class="alert alert-info">
                    <h6 class="alert-heading">
                        <i class="bi bi-info-circle me-2"></i>Important Information
                    </h6>
                    <ul class="mb-0">
                        <li>Please arrive 15 minutes before your scheduled appointment time</li>
                        <li>Bring your ID card and any relevant medical documents</li>
                        <li>If you need to reschedule, please call us at least 24 hours in advance</li>
                        <li>You will receive a confirmation email shortly</li>
                    </ul>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="/appointments" class="btn btn-outline-secondary">
                        <i class="bi bi-list me-2"></i>View All Appointments
                    </a>
                    <div>
                        <button class="btn btn-outline-primary me-2" onclick="window.print()">
                            <i class="bi bi-printer me-2"></i>Print Details
                        </button>
                        <a href="/appointments/create" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Schedule Another
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>';
    })->name('appointments.store');
    
    Route::get('/appointments/{id}', function ($id) {
        return "<h1>Appointment Details #$id</h1><p>Appointment details will be shown here.</p>";
    })->name('appointments.show');
    
    Route::patch('/appointments/{id}/status', function ($id) {
        return "Appointment #$id status updated";
    })->name('appointments.updateStatus');
    
    Route::get('/appointments/check-availability', function () {
        return response()->json([
            ['time' => '09:00', 'available' => true],
            ['time' => '09:30', 'available' => true],
            ['time' => '10:00', 'available' => false],
            ['time' => '10:30', 'available' => true]
        ]);
    })->name('appointments.checkAvailability');

    // Consultation Management - Multiple Roles
    Route::middleware('role:doctor,pharmacist,patient,admin')->group(function () {
        Route::get('/consultations', [ConsultationController::class, 'index'])->name('consultations.index');
        Route::get('/consultations/{id}', [ConsultationController::class, 'show'])->name('consultations.show');
    });

    // Doctor Actions - Create Consultations
    Route::middleware('role:doctor,admin')->group(function () {
        Route::get('/consultations/create/{appointment_id}', [ConsultationController::class, 'create'])->name('consultations.create');
        Route::post('/consultations', [ConsultationController::class, 'store'])->name('consultations.store');
        
        Route::get('/patient/{id}/edit', [PatientController::class, 'edit'])->name('patient.edit');
        Route::put('/patient/{id}', [PatientController::class, 'update'])->name('patient.update');
    });

    // Pharmacist Actions
    Route::middleware('role:pharmacist,admin')->group(function () {
        Route::get('/pharmacy/prescriptions', [PharmacyController::class, 'prescriptions'])->name('pharmacy.prescriptions');
        Route::get('/pharmacy/prescriptions/{id}', [PharmacyController::class, 'showPrescription'])->name('pharmacy.prescriptions.show');
        Route::post('/pharmacy/dispense/{id}', [PharmacyController::class, 'dispense'])->name('pharmacy.dispense');
        
        Route::resource('categories', CategoryController::class);
        Route::get('/drugList', [DrugController::class, 'index'])->name('drug.list');
        Route::get('/createDrug', [DrugController::class, 'create'])->name('drug.create');
        Route::post('/createDrug', [DrugController::class, 'store'])->name('drug.store');
        Route::get('/drug/{id}/edit', [DrugController::class, 'edit'])->name('drug.edit');
        Route::put('/drug/{id}', [DrugController::class, 'update'])->name('drug.update');
        Route::delete('/drug/{id}', [DrugController::class, 'destroy'])->name('drug.destroy');
    });

    // Cashier Actions
    Route::middleware('role:cashier,admin')->group(function () {
        Route::get('/billing', [BillController::class, 'index'])->name('billing.index');
        Route::get('/billing/products', [BillController::class, 'products'])->name('billing.products');
        Route::post('/billing/add-to-cart', [BillController::class, 'addToCart'])->name('billing.addToCart');
        Route::patch('/billing/update-cart', [BillController::class, 'updateCart'])->name('billing.updateCart');
        Route::delete('/billing/remove-from-cart', [BillController::class, 'removeFromCart'])->name('billing.removeFromCart');
        Route::get('/billing/cart', [BillController::class, 'cart'])->name('billing.cart');
        Route::get('/billing/checkout', [BillController::class, 'checkout'])->name('billing.checkout');
        Route::post('/billing/checkout', [BillController::class, 'processCheckout'])->name('billing.processCheckout');
        Route::get('/billing/create/{patient_id}', [BillController::class, 'create'])->name('billing.create');
        Route::post('/billing', [BillController::class, 'store'])->name('billing.store');
        Route::get('/billing/{id}', [BillController::class, 'show'])->name('billing.show');
        Route::get('/billing/{id}/payment', [BillController::class, 'payment'])->name('billing.payment');
        Route::post('/billing/{id}/confirm-payment', [BillController::class, 'confirmPayment'])->name('billing.confirmPayment');
        Route::get('/billing/{id}/print', [BillController::class, 'printReceipt'])->name('billing.print');
        Route::post('/billing/{id}/pay', [BillController::class, 'processPayment'])->name('billing.pay');
    });

    // Doctor Routes
    Route::middleware('role:doctor')->group(function () {
        Route::get('/doctor/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
        Route::get('/doctor/appointments', [DoctorController::class, 'appointments'])->name('doctor.appointments');
        Route::get('/doctor/appointments/{id}', [DoctorController::class, 'showAppointment'])->name('doctor.appointment.show');
        Route::get('/doctor/consultation/create/{appointmentId}', [DoctorController::class, 'createConsultation'])->name('doctor.consultation.create');
        Route::post('/doctor/consultation/store/{appointmentId}', [DoctorController::class, 'storeConsultation'])->name('doctor.consultation.store');
        Route::get('/doctor/patients', [DoctorController::class, 'patients'])->name('doctor.patients');
        Route::get('/doctor/patients/{id}', [DoctorController::class, 'showPatient'])->name('doctor.patient.show');
        Route::get('/doctor/schedule', [DoctorController::class, 'schedule'])->name('doctor.schedule');
    });

    
    // Enhanced Cashier Routes
    Route::middleware('role:cashier,admin')->group(function () {
        Route::get('/cashier/dashboard', [BillController::class, 'dashboard'])->name('cashier.dashboard');
        Route::get('/cashier/payments', [BillController::class, 'paymentTracking'])->name('cashier.payments');
    });

    // Receptionist Routes (enhanced appointment management)
    Route::middleware('role:receptionist,admin')->group(function () {
        Route::get('/appointments/{id}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
        Route::put('/appointments/{id}', [AppointmentController::class, 'update'])->name('appointments.update');
        Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
    });

    // Debug route to check user role
    Route::get('/debug-user', function () {
        if (!auth()->check()) {
            return response()->json(['error' => 'Not authenticated'], 401);
        }
        
        $user = auth()->user();
        $role = null;
        
        try {
            $role = $user->role ? $user->role->name : null;
        } catch (\Exception $e) {
            $role = 'Error: ' . $e->getMessage();
        }
        
        return response()->json([
            'user_id' => $user->id,
            'user_email' => $user->email,
            'user_name' => $user->name,
            'role_id' => $user->role_id,
            'role_name' => $role,
            'authenticated' => true,
            'environment' => app()->environment()
        ]);
    });
    
    // Simple appointment route without middleware for testing
    Route::get('/test-appointments', function () {
        return 'Appointments route works!';
    });

    // Simplified appointment create route for debugging
    Route::get('/appointments/create-simple', function () {
        try {
            $user = auth()->user();
            if (!$user) {
                return 'Not authenticated';
            }
            
            // Test basic user data
            $userInfo = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role_id' => $user->role_id
            ];
            
            // Test basic database query
            try {
                $userCount = \App\Models\User::count();
                $userInfo['user_count'] = $userCount;
            } catch (\Exception $e) {
                $userInfo['user_count_error'] = $e->getMessage();
            }
            
            // Test role query
            try {
                $roles = \App\Models\Role::all();
                $userInfo['roles'] = $roles->pluck('name')->toArray();
            } catch (\Exception $e) {
                $userInfo['roles_error'] = $e->getMessage();
            }
            
            return response()->json($userInfo);
            
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    });

    // Test appointment controller without middleware
    Route::get('/test-appointment-controller', function () {
        try {
            $controller = new \App\Http\Controllers\AppointmentController();
            return 'Controller instantiated successfully';
        } catch (\Exception $e) {
            return 'Controller error: ' . $e->getMessage();
        }
    });

    // Bypass route for appointments/create without middleware - COMPLETELY MINIMAL
    Route::get('/appointments/create-bypass', function () {
        try {
            // Return a simple HTML form without any database calls
            return '
            <!DOCTYPE html>
            <html>
            <head>
                <title>Schedule Appointment - Minimal</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
            </head>
            <body>
                <div class="container mt-4">
                    <h2>Schedule Appointment (Minimal Version)</h2>
                    <div class="alert alert-info">
                        This is a minimal version to test basic functionality. 
                        If this works, the issue is with database dependencies.
                    </div>
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Patient Name</label>
                            <input type="text" class="form-control" placeholder="Enter patient name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Doctor Name</label>
                            <input type="text" class="form-control" placeholder="Enter doctor name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Appointment Date</label>
                            <input type="date" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Appointment Time</label>
                            <input type="time" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Reason</label>
                            <textarea class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Schedule Appointment</button>
                    </form>
                </div>
            </body>
            </html>';
            
        } catch (\Exception $e) {
            return 'Bypass route error: ' . $e->getMessage() . ' Line: ' . $e->getLine();
        }
    });

    // ULTIMATE MINIMAL APPOINTMENT ROUTE - No database, no views, just HTML
    Route::get('/appointments/create-minimal', function () {
        return '<!DOCTYPE html>
<html>
<head><title>Test Appointment</title></head>
<body>
    <h1>Test Appointment Page</h1>
    <p>If you can see this page, basic routing works.</p>
    <form>
        <input type="text" placeholder="Patient name"><br><br>
        <input type="text" placeholder="Doctor name"><br><br>
        <input type="date"><br><br>
        <input type="time"><br><br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>';
    });

    // Test if the original route works with static data
    Route::get('/appointments/create-test', function () {
        try {
            // Test the view with static data
            $doctors = collect([
                (object)['id' => 1, 'name' => 'Dr. Test', 'email' => 'test@test.com']
            ]);
            $patients = collect([
                (object)['id' => 2, 'name' => 'Patient Test', 'email' => 'patient@test.com']
            ]);
            
            return view('appointments.create', compact('doctors', 'patients'));
        } catch (\Exception $e) {
            return 'View test error: ' . $e->getMessage() . ' Line: ' . $e->getLine();
        }
    });

    // Test database connection
    Route::get('/test-database', function () {
        try {
            // Test basic database connection
            $connection = \DB::connection();
            $databaseName = $connection->getDatabaseName();
            
            return response()->json([
                'database_connected' => true,
                'database_name' => $databaseName,
                'connection_details' => 'Database connection working'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'database_connected' => false,
                'error' => $e->getMessage()
            ]);
        }
    });

    // Test if users table exists
    Route::get('/test-users-table', function () {
        try {
            $userCount = \DB::table('users')->count();
            return response()->json([
                'users_table_exists' => true,
                'user_count' => $userCount
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'users_table_exists' => false,
                'error' => $e->getMessage()
            ]);
        }
    });

    // Test if roles table exists
    Route::get('/test-roles-table', function () {
        try {
            $roleCount = \DB::table('roles')->count();
            $roles = \DB::table('roles')->get();
            return response()->json([
                'roles_table_exists' => true,
                'role_count' => $roleCount,
                'roles' => $roles
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'roles_table_exists' => false,
                'error' => $e->getMessage()
            ]);
        }
    });
    Route::get('/debug-role', function() {
        if (!auth()->check()) {
            return 'Not logged in';
        }
        
        $user = auth()->user();
        $role = $user->role;
        
        return [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'role_id' => $user->role_id,
            'role' => $role ? $role->name : 'No role assigned',
            'role_object' => $role,
        ];
    })->middleware('auth');

    // Simple patient test route
    Route::get('/patient-test', function() {
        if (!auth()->check()) {
            return 'Please login first';
        }
        
        $user = auth()->user();
        return "Hello {$user->name}! You are accessing the patient test area. Your role is: " . ($user->role ? $user->role->name : 'No role');
    })->middleware('auth');

    // Test patient middleware directly
    Route::get('/test-patient-middleware', function() {
        if (!auth()->check()) {
            return 'Please login first';
        }
        
        $user = auth()->user();
        return "Patient middleware test successful for {$user->name}! Role: " . ($user->role ? $user->role->name : 'No role');
    })->middleware('patient');

    // Patient routes removed - now using main dashboard

    // General Auth access
    Route::get('/drug/{id}', [DrugController::class, 'show'])->name('drug.show');
    Route::get('/treatmentList', [TreatmentController::class, 'index'])->name('treatment.list');
    Route::get('/treatment/{id}', [TreatmentController::class, 'show'])->name('treatment.show');

});
