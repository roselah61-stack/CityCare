@extends('layouts.app')

@section('content')
@include('includes.flash')
<!-- Breadcrumb Banner -->
<div class="breadcrumb-banner-modern mb-4" style="background-image: url('{{ asset('images/breadcrumb.jpg') }}');">
    <div class="breadcrumb-content-modern">
        <h2>Pharmacy Products</h2>
        <div class="breadcrumb-links">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span class="sep">/</span>
            <a href="{{ route('billing.index') }}">Billing</a>
            <span class="sep">/</span>
            <span>Select Products</span>
        </div>
    </div>
</div>

<div class="content-overlap px-4">
    <div class="dash-header p-4 rounded-4 mb-4" style="background: white; border: 1px solid var(--border); box-shadow: var(--shadow-premium);">
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between w-100 gap-4">
            <div class="d-flex align-items-center gap-3 gap-md-4">
                <div class="welcome-icon-box d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(37, 99, 235, 0.2) 100%); border-radius: 16px; font-size: 28px; color: var(--primary);">
                    <i class="bi bi-capsule"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-dark mb-0">Pharmacy Products</h4>
                    <p class="text-muted mb-0 fw-500">Select medications and products for billing</p>
                </div>
            </div>
            <div class="d-flex gap-3 w-100 w-md-auto">
                <a href="{{ route('billing.cart') }}" class="btn btn-ent rounded-pill px-4 d-flex align-items-center gap-2 transition-all hover-lift position-relative">
                    <i class="bi bi-cart3"></i> 
                    View Cart
                    @if(count($cart) > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">
                        {{ array_sum(array_column($cart, 'quantity')) }}
                    </span>
                    @endif
                </a>
            </div>
        </div>
    </div>

    <!-- Search and Filter Bar -->
    <div class="data-card p-4 mb-4">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="search-box">
                    <i class="bi bi-search text-muted"></i>
                    <input type="text" id="productSearch" class="form-control border-0 shadow-none" placeholder="Search products by name or category...">
                </div>
            </div>
            <div class="col-md-3">
                <select id="categoryFilter" class="form-select border-0 shadow-sm">
                    <option value="">All Categories</option>
                    @foreach($drugs->pluck('category')->unique()->filter() as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select id="sortBy" class="form-select border-0 shadow-sm">
                    <option value="name">Sort by Name</option>
                    <option value="price-low">Price: Low to High</option>
                    <option value="price-high">Price: High to Low</option>
                    <option value="stock">Stock Level</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="row g-4" id="productsContainer">
        @forelse($drugs as $drug)
        <div class="col-lg-4 col-md-6 product-item" data-name="{{ strtolower($drug->name) }}" data-category="{{ $drug->category->id ?? '' }}" data-price="{{ $drug->price }}" data-stock="{{ $drug->quantity }}">
            <div class="data-card h-100 d-flex flex-column">
                <div class="p-4 flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-capsule fs-4"></i>
                        </div>
                        @php
                            $stockStatus = $drug->quantity <= $drug->low_stock_threshold ? 'low' : 'available';
                            $stockColor = $stockStatus === 'low' ? '#ef4444' : '#16a34a';
                        @endphp
                        <span class="status-pill" style="background: {{ $stockColor }}15; color: {{ $stockColor }}; border: 1px solid {{ $stockColor }}30; font-size: 11px;">
                            {{ $drug->quantity }} in stock
                        </span>
                    </div>
                    
                    <h6 class="fw-bold text-dark mb-2">{{ $drug->name }}</h6>
                    <div class="text-muted small mb-3">{{ $drug->category->name ?? 'Uncategorized' }}</div>
                    
                    <p class="text-muted small mb-3" style="min-height: 40px;">
                        {{ Str::limit($drug->description ?? 'No description available', 80) }}
                    </p>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <div class="text-muted small">Unit Price</div>
                            <div class="fw-bold text-primary fs-5">UGX {{ number_format($drug->price, 0) }}</div>
                        </div>
                        <div class="text-end">
                            <div class="text-muted small">Expiry</div>
                            <div class="small fw-bold {{ \Carbon\Carbon::parse($drug->expiry_date)->isPast() ? 'text-danger' : 'text-dark' }}">
                                {{ \Carbon\Carbon::parse($drug->expiry_date)->format('M Y') }}
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="p-3 border-top bg-light">
                    <form action="{{ route('billing.addToCart') }}" method="POST" class="d-flex gap-2">
                        @csrf
                        <input type="hidden" name="drug_id" value="{{ $drug->id }}">
                        <input type="number" name="quantity" value="1" min="1" max="{{ $drug->quantity }}" 
                               class="form-control form-control-sm rounded-3" style="width: 80px;" 
                               {{ $drug->quantity <= 0 ? 'disabled' : '' }}>
                        <button type="submit" class="btn btn-ent btn-sm rounded-3 flex-grow-1 {{ $drug->quantity <= 0 ? 'disabled' : '' }}"
                                {{ $drug->quantity <= 0 ? 'disabled' : '' }}>
                            <i class="bi bi-cart-plus me-1"></i> Add
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="bi bi-capsule display-1 text-muted opacity-25 mb-3 d-block"></i>
                <h5 class="text-muted">No products available</h5>
                <p class="text-muted small">Pharmacy inventory is currently empty or all products are out of stock.</p>
            </div>
        </div>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Search functionality
    $('#productSearch').on('input', function() {
        const searchTerm = $(this).val().toLowerCase();
        $('.product-item').each(function() {
            const productName = $(this).data('name').toLowerCase();
            const isVisible = productName.includes(searchTerm);
            $(this).toggle(isVisible);
        });
    });

    // Category filter
    $('#categoryFilter').on('change', function() {
        const selectedCategory = $(this).val();
        $('.product-item').each(function() {
            const productCategory = $(this).data('category').toString();
            const isVisible = !selectedCategory || productCategory === selectedCategory;
            $(this).toggle(isVisible);
        });
    });

    // Sort functionality
    $('#sortBy').on('change', function() {
        const sortBy = $(this).val();
        const container = $('#productsContainer');
        const items = container.find('.product-item').toArray();

        items.sort(function(a, b) {
            switch(sortBy) {
                case 'name':
                    return $(a).data('name').localeCompare($(b).data('name'));
                case 'price-low':
                    return $(a).data('price') - $(b).data('price');
                case 'price-high':
                    return $(b).data('price') - $(a).data('price');
                case 'stock':
                    return $(b).data('stock') - $(a).data('stock');
                default:
                    return 0;
            }
        });

        container.empty().append(items);
    });
});
</script>
@endpush
@endsection
