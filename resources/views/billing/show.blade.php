@extends('layouts.app')

@section('content')
@include('includes.flash')

<!-- Breadcrumb Banner -->
<div class="breadcrumb-banner-modern mb-4" style="background-image: url('{{ asset('images/breadcrumb.jpg') }}');">
    <div class="breadcrumb-content-modern">
        <h2>Bill Details</h2>
        <div class="breadcrumb-links">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span class="sep">/</span>
            <a href="{{ route('billing.index') }}">Billing</a>
            <span class="sep">/</span>
            <span>Bill #{{ $bill->id }}</span>
        </div>
    </div>
</div>

<div class="content-overlap px-4">
    <div class="dash-header p-4 rounded-4 mb-4" style="background: white; border: 1px solid var(--border); box-shadow: var(--shadow-premium);">
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between w-100 gap-4">
            <div class="d-flex align-items-center gap-3 gap-md-4">
                <div class="welcome-icon-box d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(37, 99, 235, 0.2) 100%); border-radius: 16px; font-size: 28px; color: var(--primary);">
                    <i class="bi bi-receipt"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-dark mb-0">Bill #{{ $bill->id }}</h4>
                    <p class="text-muted mb-0 fw-500">Patient: {{ $bill->user->name }}</p>
                </div>
            </div>
            <div class="d-flex gap-2">
                <span class="badge {{ $bill->payment_status === 'completed' ? 'bg-success' : 'bg-warning' }} fs-6">
                    {{ ucfirst($bill->payment_status) }}
                </span>
                <span class="badge bg-primary fs-6">UGX {{ number_format($bill->total_amount, 0) }}</span>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Bill Details -->
        <div class="col-lg-8">
            <div class="data-card p-4 mb-4">
                <h5 class="fw-bold text-dark mb-4">
                    <i class="bi bi-receipt-cutoff me-2 text-primary"></i>Bill Information
                </h5>
                
                <div class="row g-3 mb-4">
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
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded-3">
                            <div class="small text-muted mb-1">Cashier</div>
                            <div class="fw-bold">{{ $bill->cashier->name ?? 'System' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded-3">
                            <div class="small text-muted mb-1">Payment Method</div>
                            <div class="fw-bold">{{ ucfirst($bill->payment_method ?? 'Pending') }}</div>
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
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
                            @else
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No items found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Payment Summary & Actions -->
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

            <div class="data-card p-4">
                <h5 class="fw-bold text-dark mb-4">
                    <i class="bi bi-gear me-2 text-secondary"></i>Actions
                </h5>
                
                <div class="d-grid gap-2">
                    @if($bill->payment_status === 'pending')
                        <a href="{{ route('billing.payment', $bill->id) }}" class="btn btn-success rounded-pill">
                            <i class="bi bi-credit-card me-2"></i>Process Payment
                        </a>
                    @endif
                    
                    <a href="{{ route('billing.print', $bill->id) }}" class="btn btn-outline-primary rounded-pill">
                        <i class="bi bi-printer me-2"></i>Print Receipt
                    </a>
                    
                    <a href="{{ route('billing.index') }}" class="btn btn-light rounded-pill">
                        <i class="bi bi-arrow-left me-2"></i>Back to Billing
                    </a>
                </div>
                
                @if($bill->payment_status === 'completed')
                    <div class="alert alert-success border-0 rounded-3 mt-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-check-circle-fill"></i>
                            <div>
                                <strong>Payment Completed</strong>
                                <div class="small">This bill has been fully paid.</div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.space-y-3 > * + * {
    margin-top: 1rem;
}
</style>
@endsection
