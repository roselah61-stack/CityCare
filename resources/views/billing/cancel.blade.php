@extends('layouts.app')

@section('content')
<div class="dashboard-shell">
    <div class="text-center py-5">
        <div class="mb-4">
            <i class="bi bi-x-circle-fill text-danger" style="font-size: 5rem;"></i>
        </div>
        <h2 class="fw-bold text-dark mb-2">Payment Cancelled</h2>
        <p class="text-muted mb-4 fs-5">The payment process was cancelled. No charges have been made.</p>
        <div class="d-flex gap-3 justify-content-center">
            <a href="{{ route('billing.cart') }}" class="btn btn-primary rounded-pill px-4 py-2">
                <i class="bi bi-cart me-2"></i> Return to Cart
            </a>
            <a href="{{ route('billing.index') }}" class="btn btn-light border rounded-pill px-4 py-2">
                <i class="bi bi-receipt me-2"></i> View Billing
            </a>
        </div>
    </div>
</div>
@endsection
