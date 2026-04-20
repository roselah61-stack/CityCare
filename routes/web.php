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

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/verify-otp', [AuthController::class, 'showOtp'])->name('2fa.form');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('2fa.verify');

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
    Route::get('/overview', [PageController::class, 'overview'])->name('overview');

    Route::middleware('can:isAdmin')->group(function () {

        Route::get('/admin/users', [UserManagementController::class, 'index'])->name('admin.users');
        Route::post('/admin/users/{id}/assign-role', [UserManagementController::class, 'assignRole'])->name('admin.assignRole');

        Route::get('/createPatient', [PatientController::class, 'create'])->name('patient.create');
        Route::post('/createPatient', [PatientController::class, 'store'])->name('patient.store');
        Route::get('/patientList', [PatientController::class, 'index'])->name('patient.list');
        Route::get('/patient/{id}', [PatientController::class, 'show'])->name('patient.show');
        Route::get('/patient/{id}/edit', [PatientController::class, 'edit'])->name('patient.edit');
        Route::put('/patient/{id}', [PatientController::class, 'update'])->name('patient.update');
        Route::delete('/patient/{id}', [PatientController::class, 'destroy'])->name('patient.destroy');

        Route::get('/createCategory', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/createCategory', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categoryList', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/category/{id}', [CategoryController::class, 'show'])->name('categories.show');
        Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/category/{id}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    });

    Route::middleware('can:isPharmacist')->group(function () {

        Route::get('/createDrug', [DrugController::class, 'create'])->name('drug.create');
        Route::post('/createDrug', [DrugController::class, 'store'])->name('drug.store');
        Route::get('/drugList', [DrugController::class, 'index'])->name('drug.list');
        Route::get('/drug/{id}', [DrugController::class, 'show'])->name('drug.show');
        Route::get('/drug/{id}/edit', [DrugController::class, 'edit'])->name('drug.edit');
        Route::put('/drug/{id}', [DrugController::class, 'update'])->name('drug.update');
        Route::delete('/drug/{id}', [DrugController::class, 'destroy'])->name('drug.destroy');
    });

    Route::middleware('can:isDoctor')->group(function () {

        Route::get('/createTreatment', [TreatmentController::class, 'create'])->name('treatment.create');
        Route::post('/createTreatment', [TreatmentController::class, 'store'])->name('treatment.store');
        Route::get('/treatmentList', [TreatmentController::class, 'index'])->name('treatment.list');
        Route::get('/treatment/{id}', [TreatmentController::class, 'show'])->name('treatment.show');
        Route::get('/treatment/{id}/edit', [TreatmentController::class, 'edit'])->name('treatment.edit');
        Route::put('/treatment/{id}', [TreatmentController::class, 'update'])->name('treatment.update');
        Route::delete('/treatment/{id}', [TreatmentController::class, 'destroy'])->name('treatment.destroy');
    });

    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [UserController::class, 'update'])->name('profile.update');
});