@extends('layouts.app')

@section('content')
<div class="dashboard-shell">
    <div class="text-center py-5">
        <div class="mb-4">
            <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
        </div>
        <h2 class="fw-bold text-dark mb-2">Payment Successful!</h2>
        <p class="text-muted mb-4 fs-5">Thank you for your payment. Your medical bill has been cleared successfully.</p>
        <div class="d-flex gap-3 justify-content-center">
            <a href="{{ route('billing.index') }}" class="btn btn-primary rounded-pill px-4 py-2">
                <i class="bi bi-receipt me-2"></i> View Billing
            </a>
            <a href="{{ route('dashboard') }}" class="btn btn-light border rounded-pill px-4 py-2">
                <i class="bi bi-house-door me-2"></i> Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
