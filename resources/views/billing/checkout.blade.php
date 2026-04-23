@extends('layouts.app')

@section('content')
<!-- Breadcrumb Banner -->
<div class="breadcrumb-banner-modern mb-4" style="background-image: url('{{ asset('images/breadcrumb.jpg') }}');">
    <div class="breadcrumb-content-modern">
        <h2>Checkout</h2>
        <div class="breadcrumb-links">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span class="sep">/</span>
            <a href="{{ route('billing.index') }}">Billing</a>
            <span class="sep">/</span>
            <a href="{{ route('billing.cart') }}">Cart</a>
            <span class="sep">/</span>
            <span>Checkout</span>
        </div>
    </div>
</div>

<div class="content-overlap px-4">
    <div class="dash-header p-4 rounded-4 mb-4" style="background: white; border: 1px solid var(--border); box-shadow: var(--shadow-premium);">
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between w-100 gap-4">
            <div class="d-flex align-items-center gap-3 gap-md-4">
                <div class="welcome-icon-box d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(37, 99, 235, 0.2) 100%); border-radius: 16px; font-size: 28px; color: var(--primary);">
                    <i class="bi bi-credit-card"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-dark mb-0">Checkout</h4>
                    <p class="text-muted mb-0 fw-500">Complete your pharmacy purchase</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <form action="{{ route('billing.processCheckout') }}" method="POST" id="checkoutForm">
            @csrf
            <!-- Customer Information -->
            <div class="col-lg-8">
                <div class="data-card p-4 mb-4">
                    <h5 class="fw-bold text-dark mb-4">
                        <i class="bi bi-person-badge me-2 text-primary"></i>Customer Information
                    </h5>
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="bg-light p-3 rounded-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 48px; height: 48px; font-size: 16px;">
                                        {{ strtoupper(substr($currentUser->name, 0, 2)) }}
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-bold text-dark">{{ $currentUser->name }}</div>
                                        <div class="text-muted small">{{ $currentUser->email ?? 'No email' }}</div>
                                        <div class="badge bg-primary mt-1">{{ ucfirst($currentUser->role->name ?? 'User') }}</div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="user_id" value="{{ $currentUser->id }}">
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="data-card p-4">
                    <h5 class="fw-bold text-dark mb-4">
                        <i class="bi bi-receipt me-2 text-primary"></i>Order Details
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Price</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $subtotal = 0 @endphp
                                @foreach($cart as $id => $details)
                                    @php $subtotal += $details['price'] * $details['quantity'] @endphp
                                    <tr>
                                        <td>
                                            <div class="fw-bold">{{ $details['name'] }}</div>
                                            <div class="text-muted small">{{ Str::limit($details['description'], 50) }}</div>
                                        </td>
                                        <td class="text-center">{{ $details['quantity'] }}</td>
                                        <td class="text-end">UGX {{ number_format($details['price'], 0) }}</td>
                                        <td class="text-end fw-bold">UGX {{ number_format($details['price'] * $details['quantity'], 0) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="border-top pt-3 mt-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-bold">UGX {{ number_format($subtotal, 0) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">VAT (18%)</span>
                            <span class="fw-bold text-success">UGX {{ number_format($subtotal * 0.18, 0) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold text-dark mb-0">Total Amount</h6>
                            <h6 class="fw-bold text-primary mb-0">UGX {{ number_format($subtotal * 1.18, 0) }}</h6>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment & Actions -->
            <div class="col-lg-4">
                <div class="data-card p-4">
                    <h5 class="fw-bold text-dark mb-4">
                        <i class="bi bi-shield-check me-2 text-success"></i>Secure Checkout
                    </h5>
                    
                    <div class="alert alert-info border-0 rounded-3 mb-4" style="background: #eef2ff;">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-info-circle text-primary"></i>
                            <strong>Payment Processing</strong>
                        </div>
                        <p class="small mb-0">After confirming the order, you'll be able to collect payment from the customer using your preferred method.</p>
                    </div>

                    <div class="space-y-3 mb-4">
                        <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3">
                            <div class="bg-success text-white rounded-circle p-2" style="width: 32px; height: 32px;">
                                <i class="bi bi-check-lg"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold text-dark small">Stock Verified</div>
                                <div class="text-muted small">All items are available</div>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3">
                            <div class="bg-primary text-white rounded-circle p-2" style="width: 32px; height: 32px;">
                                <i class="bi bi-lock"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold text-dark small">Secure Transaction</div>
                                <div class="text-muted small">Encrypted and protected</div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-ent btn-lg w-100 rounded-pill shadow-sm mb-3">
                        <i class="bi bi-check-circle me-2"></i>Confirm Order
                    </button>

                    <div class="text-center">
                        <a href="{{ route('billing.cart') }}" class="btn btn-light border rounded-pill px-4">
                            <i class="bi bi-arrow-left me-2"></i>Back to Cart
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
.space-y-3 > * + * {
    margin-top: 0.75rem;
}
</style>
@endsection
