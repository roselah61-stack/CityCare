@extends('layouts.app')

@section('page-title', 'Billing & Payments')

@section('content')
@include('includes.flash')
<!-- Breadcrumb Banner -->
<div class="breadcrumb-banner-modern mb-4" style="background-image: url('{{ asset('images/breadcrumb.jpg') }}');">
    <div class="breadcrumb-content-modern">
        <h2>Revenue & Billing</h2>
        <div class="breadcrumb-links">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span class="sep">/</span>
            <span>Billing & Payments</span>
        </div>
    </div>
</div>

<div class="content-overlap px-4">
    <div class="dash-header p-4 rounded-4 mb-4" style="background: white; border: 1px solid var(--border); box-shadow: var(--shadow-premium);">
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between w-100 gap-4">
            <div class="d-flex align-items-center gap-3 gap-md-4">
                <div class="welcome-icon-box d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(37, 99, 235, 0.2) 100%); border-radius: 16px; font-size: 28px; color: var(--primary);">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-dark mb-0">Revenue & Billing</h4>
                    <p class="text-muted mb-0 fw-500">Manage invoices and process patient payments</p>
                </div>
            </div>
            <div class="d-flex gap-3 w-100 w-md-auto">
                <a href="{{ route('billing.products') }}" class="btn btn-ent rounded-pill px-4 d-flex align-items-center gap-2 transition-all hover-lift">
                    <i class="bi bi-capsule"></i> Pharmacy Shop
                </a>
            </div>
        </div>
    </div>

<div class="data-card p-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table-ent mb-0">
            <thead>
                <tr>
                    <th class="ps-4">Patient Details</th>
                    <th>Amount Due</th>
                    <th>Status</th>
                    <th>Method</th>
                    <th>Date</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bills as $bill)
                <tr>
                    <td class="ps-4">
                        <div class="patient-meta">
                            <div class="p-avatar" style="background: #ecfdf5; color: #059669;">
                                {{ strtoupper(substr($bill->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-bold text-dark">{{ $bill->user->name }}</div>
                                <div class="text-muted small" style="font-size: 11px;">#INV-{{ 5000 + $bill->id }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="fw-bold text-primary">UGX {{ number_format($bill->total_amount, 0) }}</div>
                    </td>
                    <td>
                        @php
                            $pillClass = $bill->payment_status === 'completed' ? 'pill-success' : 'pill-warning';
                        @endphp
                        <span class="status-pill {{ $pillClass }}">{{ ucfirst($bill->payment_status) }}</span>
                    </td>
                    <td>
                        @if($bill->payment_method)
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-{{ $bill->payment_method === 'cash' ? 'cash-stack text-success' : ($bill->payment_method === 'card' ? 'credit-card text-info' : 'phone text-primary') }}"></i>
                                <span class="small fw-600 text-muted">{{ ucfirst(str_replace('_', ' ', $bill->payment_method)) }}</span>
                            </div>
                        @else
                            <span class="text-muted small fw-600">Pending</span>
                        @endif
                    </td>
                    <td>
                        <div class="text-dark small fw-bold">{{ $bill->created_at->format('d M Y') }}</div>
                    </td>
                    <td class="text-end pe-4">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('billing.show', $bill->id) }}" class="btn btn-light btn-sm border rounded-3 px-3 fw-600" title="View Invoice">
                                View
                            </a>
                            @if($bill->payment_status === 'pending')
                            <button type="button" class="btn btn-ent btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#payModal{{ $bill->id }}">
                                Pay
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>

                    <!-- Payment Modal -->
                    <div class="modal fade" id="payModal{{ $bill->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow-lg rounded-4">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fw-bold text-dark">Process Payment</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('billing.pay', $bill->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-body text-start">
                                        <div class="bg-primary text-white p-4 rounded-4 mb-4 text-center shadow">
                                            <div class="small opacity-75 mb-1 text-uppercase letter-spacing-1 fw-bold">Amount Due</div>
                                            <h2 class="mb-0 fw-bold">UGX {{ number_format($bill->total_amount, 0) }}</h2>
                                        </div>

                                        <label class="form-label fw-bold mb-3 text-dark">Select Payment Method</label>
                                        <div class="d-flex flex-column gap-3">
                                            <div class="payment-option">
                                                <input type="radio" class="btn-check" name="payment_method" value="cash" id="cash{{ $bill->id }}" required>
                                                <label class="btn btn-outline-light text-dark border p-3 w-100 d-flex align-items-center justify-content-between rounded-3" for="cash{{ $bill->id }}">
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-success-light text-success rounded-circle p-2 me-3" style="background-color: #ecfdf5;">
                                                            <i class="bi bi-cash-stack fs-4"></i>
                                                        </div>
                                                        <span class="fw-bold">Cash Payment</span>
                                                    </div>
                                                    <i class="bi bi-check-circle-fill check-icon text-primary"></i>
                                                </label>
                                            </div>

                                            <div class="payment-option">
                                                <input type="radio" class="btn-check" name="payment_method" value="mobile_money" id="mm{{ $bill->id }}">
                                                <label class="btn btn-outline-light text-dark border p-3 w-100 d-flex align-items-center justify-content-between rounded-3" for="mm{{ $bill->id }}">
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-primary-light text-primary rounded-circle p-2 me-3" style="background-color: #eef2ff;">
                                                            <i class="bi bi-phone fs-4"></i>
                                                        </div>
                                                        <span class="fw-bold">Mobile Money</span>
                                                    </div>
                                                    <i class="bi bi-check-circle-fill check-icon text-primary"></i>
                                                </label>
                                            </div>

                                            <div class="payment-option">
                                                <input type="radio" class="btn-check" name="payment_method" value="card" id="card{{ $bill->id }}">
                                                <label class="btn btn-outline-light text-dark border p-3 w-100 d-flex align-items-center justify-content-between rounded-3" for="card{{ $bill->id }}">
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-info-light text-info rounded-circle p-2 me-3" style="background-color: #f0f9ff;">
                                                            <i class="bi bi-credit-card fs-4"></i>
                                                        </div>
                                                        <span class="fw-bold">Credit/Debit Card</span>
                                                    </div>
                                                    <i class="bi bi-check-circle-fill check-icon text-primary"></i>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0 pt-0 pb-4 justify-content-center">
                                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary px-5 shadow">Complete Payment</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="py-4">
                                <i class="bi bi-receipt-cutoff display-1 text-muted opacity-25 mb-3 d-block"></i>
                                <h5 class="text-muted">No transactions found</h5>
                                <p class="text-muted small">Financial records will appear here once billing is generated.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.payment-option .btn-check:checked + label {
    background-color: #f8fafc !important;
    border-color: var(--primary) !important;
    box-shadow: 0 0 0 1px var(--primary);
}
.payment-option .check-icon {
    display: none;
}
.payment-option .btn-check:checked + label .check-icon {
    display: block;
}
</style>
</div>
</div>
@endsection
