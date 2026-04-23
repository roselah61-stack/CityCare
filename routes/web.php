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

    // Appointment Management
    Route::middleware('role:receptionist,doctor,patient,admin')->group(function () {
        Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
        Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
        Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
        Route::get('/appointments/{id}', [AppointmentController::class, 'show'])->name('appointments.show');
        Route::patch('/appointments/{id}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.updateStatus');
        Route::get('/appointments/check-availability', [AppointmentController::class, 'checkAvailability'])->name('appointments.checkAvailability');
    });

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
