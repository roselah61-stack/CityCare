<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserManagementController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| These routes are stateless and used for Postman / mobile apps
|
*/

// Public API routes
Route::post('/login', [AuthController::class, 'apiLogin']);
Route::post('/register', [AuthController::class, 'apiRegister']);

// Protected routes (requires authentication later)
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'apiLogout']);

    // Admin role management
    Route::post('/assign-role/{id}', [UserManagementController::class, 'assignRole']);

    Route::get('/users', [UserManagementController::class, 'index']);
});