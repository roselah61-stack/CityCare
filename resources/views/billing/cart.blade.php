@extends('layouts.app')

@section('content')
@include('includes.flash')
<!-- Breadcrumb Banner -->
<div class="breadcrumb-banner-modern mb-4" style="background-image: url('{{ asset('images/breadcrumb.jpg') }}');">
    <div class="breadcrumb-content-modern">
        <h2>Shopping Cart</h2>
        <div class="breadcrumb-links">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span class="sep">/</span>
            <a href="{{ route('billing.index') }}">Billing</a>
            <span class="sep">/</span>
            <span>Cart</span>
        </div>
    </div>
</div>

<div class="content-overlap px-4">
    <div class="dash-header p-4 rounded-4 mb-4" style="background: white; border: 1px solid var(--border); box-shadow: var(--shadow-premium);">
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between w-100 gap-4">
            <div class="d-flex align-items-center gap-3 gap-md-4">
                <div class="welcome-icon-box d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(37, 99, 235, 0.2) 100%); border-radius: 16px; font-size: 28px; color: var(--primary);">
                    <i class="bi bi-cart3"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-dark mb-0">Shopping Cart</h4>
                    <p class="text-muted mb-0 fw-500">Review your selected items before checkout</p>
                </div>
            </div>
            <div class="d-flex gap-3 w-100 w-md-auto">
                <a href="{{ route('billing.products') }}" class="btn btn-light border rounded-pill px-4 d-flex align-items-center gap-2 transition-all hover-lift">
                    <i class="bi bi-arrow-left"></i> Continue Shopping
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="data-card p-0 overflow-hidden">
                <div class="table-responsive">
                    <table class="table-ent mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Product Details</th>
                                <th>Unit Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0 @endphp
                            @if(count($cart) > 0)
                                @foreach($cart as $id => $details)
                                    @php $total += $details['price'] * $details['quantity'] @endphp
                                    <tr data-id="{{ $id }}">
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center gap-3 py-2">
                                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <i class="bi bi-capsule"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark">{{ $details['name'] }}</div>
                                                    <div class="text-muted small text-truncate" style="max-width: 200px;">{{ $details['description'] }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-primary">UGX {{ number_format($details['price'], 0) }}</div>
                                        </td>
                                        <td>
                                            <input type="number" value="{{ $details['quantity'] }}" class="form-control form-control-sm rounded-3 update-cart text-center" style="width: 80px;" min="1" max="999">
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark">UGX {{ number_format($details['price'] * $details['quantity'], 0) }}</div>
                                        </td>
                                        <td class="text-end pe-4">
                                            <button class="btn btn-link text-danger remove-from-cart p-0 fw-600 text-decoration-none">
                                                <i class="bi bi-trash me-1"></i>Remove
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="py-4">
                                            <i class="bi bi-cart-x display-1 text-muted opacity-25 mb-3 d-block"></i>
                                            <h5 class="text-muted">Your cart is empty</h5>
                                            <p class="text-muted small">Add some products from the pharmacy to get started.</p>
                                            <a href="{{ route('billing.products') }}" class="btn btn-ent rounded-pill px-4">
                                                <i class="bi bi-cart-plus me-2"></i>Browse Products
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="data-card p-4">
                <h5 class="fw-bold text-dark mb-4">
                    <i class="bi bi-receipt me-2 text-primary"></i>Order Summary
                </h5>
                <div class="space-y-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-bold text-dark">UGX {{ number_format($total, 0) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Items Count</span>
                        <span class="fw-bold text-dark">{{ count($cart) }} items</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Tax (VAT 18%)</span>
                        <span class="fw-bold text-success">UGX {{ number_format($total * 0.18, 0) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <h6 class="fw-bold text-dark mb-0">Total Amount</h6>
                        <h6 class="fw-bold text-primary mb-0">UGX {{ number_format($total * 1.18, 0) }}</h6>
                    </div>
                </div>
                
                <form action="{{ route('billing.checkout') }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="btn btn-ent btn-lg w-100 rounded-pill shadow-sm {{ count($cart) == 0 ? 'disabled' : '' }}" {{ count($cart) == 0 ? 'disabled' : '' }}>
                        <i class="bi bi-credit-card me-2"></i>Proceed to Checkout
                    </button>
                </form>
                
                <div class="mt-3 text-center">
                    <small class="text-muted">
                        <i class="bi bi-shield-check me-1"></i>
                        Secure checkout powered by CityCare
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // Update cart quantity
        $(".update-cart").change(function (e) {
            e.preventDefault();
            var ele = $(this);
            var row = ele.parents("tr");
            
            $.ajax({
                url: '{{ route('billing.updateCart') }}',
                method: "PATCH",
                data: {
                    _token: '{{ csrf_token() }}', 
                    id: row.attr("data-id"), 
                    quantity: ele.val()
                },
                success: function (response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert('Error updating cart: ' + (response.error || 'Unknown error'));
                    }
                },
                error: function() {
                    alert('Error updating cart. Please try again.');
                }
            });
        });

        // Remove from cart
        $(".remove-from-cart").click(function (e) {
            e.preventDefault();
            var ele = $(this);
            var row = ele.parents("tr");
            
            if(confirm("Are you sure you want to remove this item?")) {
                $.ajax({
                    url: '{{ route('billing.removeFromCart') }}',
                    method: "DELETE",
                    data: {
                        _token: '{{ csrf_token() }}', 
                        id: row.attr("data-id")
                    },
                    success: function (response) {
                        if (response.success) {
                            row.fadeOut(300, function() {
                                $(this).remove();
                                location.reload();
                            });
                        } else {
                            alert('Error removing item');
                        }
                    },
                    error: function() {
                        alert('Error removing item. Please try again.');
                    }
                });
            }
        });
    });
</script>
@endpush
@endsection
