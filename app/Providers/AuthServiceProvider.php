<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::define('isAdmin', function ($user) {
            return optional($user->role)->name === 'admin';
        });

        Gate::define('isDoctor', function ($user) {
            return optional($user->role)->name === 'doctor';
        });

        Gate::define('isPharmacist', function ($user) {
            return optional($user->role)->name === 'pharmacist';
        });

        Gate::define('isReceptionist', function ($user) {
            return optional($user->role)->name === 'receptionist';
        });

        Gate::define('isPatient', function ($user) {
            return optional($user->role)->name === 'patient';
        });
    }
}