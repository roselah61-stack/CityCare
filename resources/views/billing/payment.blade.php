@extends('layouts.app')

@section('content')
@include('includes.flash')

<!-- Breadcrumb Banner -->
<div class="breadcrumb-banner-modern mb-4" style="background-image: url('{{ asset('images/breadcrumb.jpg') }}');">
    <div class="breadcrumb-content-modern">
        <h2>Payment Processing</h2>
        <div class="breadcrumb-links">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span class="sep">/</span>
            <a href="{{ route('billing.index') }}">Billing</a>
            <span class="sep">/</span>
            <span>Payment</span>
        </div>
    </div>
</div>

<div class="content-overlap px-4">
    <div class="dash-header p-4 rounded-4 mb-4" style="background: white; border: 1px solid var(--border); box-shadow: var(--shadow-premium);">
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between w-100 gap-4">
            <div class="d-flex align-items-center gap-3 gap-md-4">
                <div class="welcome-icon-box d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.2) 100%); border-radius: 16px; font-size: 28px; color: #10b981;">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-dark mb-0">Process Payment</h4>
                    <p class="text-muted mb-0 fw-500">Complete payment for Bill #{{ $bill->id }}</p>
                </div>
            </div>
            <div class="d-flex gap-2">
                <span class="badge bg-light text-dark fs-6">Patient: {{ $bill->user->name }}</span>
                <span class="badge bg-primary fs-6">Amount: UGX {{ number_format($bill->total_amount, 0) }}</span>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Bill Details -->
        <div class="col-lg-8">
            <div class="data-card p-4 mb-4">
                <h5 class="fw-bold text-dark mb-4">
                    <i class="bi bi-receipt-cutoff me-2 text-primary"></i>Bill Details
                </h5>
                
                <div class="table-responsive mb-4">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Unit Price</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($bill->items && is_array($bill->items))
                                @foreach($bill->items as $item)
                                    <tr>
                                        <td>
                                            <div class="fw-bold">{{ $item['name'] ?? 'Unknown Item' }}</div>
                                            <div class="text-muted small">{{ $item['description'] ?? 'Pharmacy Product' }}</div>
                                        </td>
                                        <td class="text-center">{{ $item['quantity'] ?? 1 }}</td>
                                        <td class="text-end">UGX {{ number_format($item['price'] ?? 0, 0) }}</td>
                                        <td class="text-end fw-bold">UGX {{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 0) }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                
                <div class="border-top pt-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="bg-light p-3 rounded-3">
                                <div class="small text-muted mb-1">Bill Type</div>
                                <div class="fw-bold text-uppercase">{{ $bill->bill_type ?? 'Pharmacy' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-light p-3 rounded-3">
                                <div class="small text-muted mb-1">Date Issued</div>
                                <div class="fw-bold">{{ $bill->created_at->format('M d, Y H:i') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Form -->
            <div class="data-card p-4">
                <h5 class="fw-bold text-dark mb-4">
                    <i class="bi bi-credit-card me-2 text-success"></i>Payment Information
                </h5>
                
                <form action="{{ route('billing.confirmPayment', $bill->id) }}" method="POST" id="paymentForm">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark">Payment Method *</label>
                            <div class="payment-methods">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="payment-method-card">
                                            <input type="radio" name="payment_method" value="cash" required class="d-none">
                                            <div class="card border-2 shadow-sm h-100">
                                                <div class="card-body text-center p-3">
                                                    <div class="text-success mb-2" style="font-size: 24px;">
                                                        <i class="bi bi-cash"></i>
                                                    </div>
                                                    <div class="fw-bold">Cash</div>
                                                    <div class="text-muted small">Pay with cash</div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="payment-method-card">
                                            <input type="radio" name="payment_method" value="mobile_money" required class="d-none">
                                            <div class="card border-2 shadow-sm h-100">
                                                <div class="card-body text-center p-3">
                                                    <div class="text-primary mb-2" style="font-size: 24px;">
                                                        <i class="bi bi-phone"></i>
                                                    </div>
                                                    <div class="fw-bold">Mobile Money</div>
                                                    <div class="text-muted small">Airtel/MTN Money</div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="payment-method-card">
                                            <input type="radio" name="payment_method" value="card" required class="d-none">
                                            <div class="card border-2 shadow-sm h-100">
                                                <div class="card-body text-center p-3">
                                                    <div class="text-warning mb-2" style="font-size: 24px;">
                                                        <i class="bi bi-credit-card"></i>
                                                    </div>
                                                    <div class="fw-bold">Card</div>
                                                    <div class="text-muted small">Credit/Debit Card</div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12" id="mobileMoneyFields" style="display: none;">
                            <label class="form-label fw-bold text-dark">Mobile Money Details</label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="tel" name="phone_number" class="form-control border-0 shadow-sm rounded-3" placeholder="Phone Number (e.g., 0752123456)">
                                </div>
                                <div class="col-md-6">
                                    <select name="mobile_provider" class="form-select border-0 shadow-sm rounded-3">
                                        <option value="">Select Provider</option>
                                        <option value="airtel">Airtel Money</option>
                                        <option value="mtn">MTN Mobile Money</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-12" id="cardFields" style="display: none;">
                            <label class="form-label fw-bold text-dark">Card Details</label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="text" name="card_last4" class="form-control border-0 shadow-sm rounded-3" placeholder="Last 4 digits">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="card_holder" class="form-control border-0 shadow-sm rounded-3" placeholder="Cardholder Name">
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold text-dark">Payment Notes (Optional)</label>
                            <textarea name="payment_notes" class="form-control border-0 shadow-sm rounded-3" rows="3" placeholder="Add any notes about this payment..."></textarea>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Payment Summary -->
        <div class="col-lg-4">
            <div class="data-card p-4 mb-4">
                <h5 class="fw-bold text-dark mb-4">
                    <i class="bi bi-calculator me-2 text-primary"></i>Payment Summary
                </h5>
                
                <div class="space-y-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-bold">UGX {{ number_format($bill->total_amount, 0) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">VAT (18%)</span>
                        <span class="fw-bold text-success">UGX {{ number_format($bill->total_amount * 0.18, 0) }}</span>
                    </div>
                    <div class="border-top pt-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold text-dark mb-0">Total Amount</h6>
                            <h6 class="fw-bold text-primary mb-0">UGX {{ number_format($bill->total_amount * 1.18, 0) }}</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="data-card p-4 mb-4">
                <h5 class="fw-bold text-dark mb-4">
                    <i class="bi bi-shield-check me-2 text-success"></i>Payment Security
                </h5>
                
                <div class="space-y-3">
                    <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3">
                        <div class="bg-success text-white rounded-circle p-2" style="width: 32px; height: 32px;">
                            <i class="bi bi-check-lg"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold text-dark small">Secure Processing</div>
                            <div class="text-muted small">All payments are encrypted</div>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3">
                        <div class="bg-primary text-white rounded-circle p-2" style="width: 32px; height: 32px;">
                            <i class="bi bi-receipt"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold text-dark small">Instant Receipt</div>
                            <div class="text-muted small">Receipt generated immediately</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3">
                        <div class="bg-info text-white rounded-circle p-2" style="width: 32px; height: 32px;">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold text-dark small">Payment History</div>
                            <div class="text-muted small">Complete audit trail</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="data-card p-4">
                <button type="submit" form="paymentForm" class="btn btn-success btn-lg w-100 rounded-pill shadow-sm mb-3">
                    <i class="bi bi-check-circle me-2"></i>Process Payment
                </button>
                
                <div class="d-flex gap-2">
                    <a href="{{ route('billing.show', $bill->id) }}" class="btn btn-light flex-fill rounded-pill">
                        <i class="bi bi-arrow-left me-1"></i> Back
                    </a>
                    <a href="{{ route('billing.print', $bill->id) }}" class="btn btn-outline-primary flex-fill rounded-pill">
                        <i class="bi bi-printer me-1"></i> Print
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.payment-method-card {
    cursor: pointer;
    display: block;
}

.payment-method-card input:checked + .card {
    border-color: var(--primary) !important;
    background: linear-gradient(135deg, rgba(37, 99, 235, 0.05) 0%, rgba(37, 99, 235, 0.1) 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
}

.payment-method-card .card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.space-y-3 > * + * {
    margin-top: 1rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const mobileMoneyFields = document.getElementById('mobileMoneyFields');
    const cardFields = document.getElementById('cardFields');

    paymentMethods.forEach(method => {
        method.addEventListener('change', function() {
            mobileMoneyFields.style.display = 'none';
            cardFields.style.display = 'none';
            
            if (this.value === 'mobile_money') {
                mobileMoneyFields.style.display = 'block';
            } else if (this.value === 'card') {
                cardFields.style.display = 'block';
            }
        });
    });
});
</script>
@endsection
