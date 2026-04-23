@extends('layouts.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 70vh;">
    <div class="text-center p-5 shadow-sm rounded-4 bg-white border-0">
        <div class="mb-4">
            <i class="bi bi-shield-lock text-danger" style="font-size: 5rem;"></i>
        </div>
        <h1 class="fw-bold text-dark mb-2">Access Denied</h1>
        <p class="text-muted mb-4 fs-5">Sorry, you don't have the required permissions to access this page.</p>
        <div class="d-flex gap-3 justify-content-center">
            <a href="{{ url()->previous() }}" class="btn btn-primary rounded-pill px-4 py-2">
                <i class="bi bi-arrow-left me-2"></i> Go Back
            </a>
            <a href="{{ route('dashboard') }}" class="btn btn-light border rounded-pill px-4 py-2">
                <i class="bi bi-house-door me-2"></i> Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
