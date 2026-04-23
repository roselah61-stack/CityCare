@extends('layouts.app')

@section('content')
<div class="dash-header p-4 p-lg-5 rounded-4 mb-4" style="background: white; border: 1px solid var(--border); box-shadow: var(--shadow-premium);">
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between w-100 gap-4">
        <div class="d-flex align-items-center gap-3 gap-md-4">
            <div class="welcome-icon-box d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(37, 99, 235, 0.2) 100%); border-radius: 16px; font-size: 28px; color: var(--primary);">
                <i class="bi bi-bandaid-fill"></i>
            </div>
            <div>
                <h1 class="mb-1 fw-800" style="font-size: clamp(20px, 4vw, 28px);">{{ $drug->name }}</h1>
                <p class="text-muted mb-0 fw-500 d-flex align-items-center gap-2" style="font-size: clamp(12px, 2vw, 14px);">
                    <i class="bi bi-tag-fill text-primary"></i> {{ $drug->category->name ?? 'Uncategorized' }}
                </p>
            </div>
        </div>
        <div class="d-flex gap-3 w-100 w-md-auto">
            @can('isPharmacist')
            <a href="{{ route('drug.edit', $drug->id) }}" class="btn btn-ent rounded-pill px-4 d-flex align-items-center gap-2 transition-all hover-lift">
                <i class="bi bi-pencil"></i> Edit
            </a>
            @endcan
            <a href="{{ route('drug.list') }}" class="btn btn-light border rounded-pill px-4 fw-600 d-flex align-items-center gap-2 transition-all hover-lift">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="data-card mb-4">
            <div class="card-head">
                <h5>Drug Information</h5>
            </div>
            <div class="p-3 rounded-3 mb-4" style="background: #f8fafc;">
                <div class="d-flex align-items-start gap-3">
                    <div class="p-3 rounded-3" style="background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(37, 99, 235, 0.2) 100%);">
                        <i class="bi bi-bandaid-fill text-primary" style="font-size: 24px;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h4 class="fw-bold text-dark mb-2">{{ $drug->name }}</h4>
                        <p class="text-muted mb-0 lh-lg">{{ $drug->description ?: 'No description provided for this drug.' }}</p>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="p-3 rounded-3" style="background: #f8fafc;">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-tag-fill text-primary"></i>
                            <span class="fw-600 text-dark small text-uppercase">Category</span>
                        </div>
                        <span class="fw-bold text-dark fs-5">{{ $drug->category->name ?? 'Uncategorized' }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 rounded-3" style="background: #f8fafc;">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-currency-dollar text-primary"></i>
                            <span class="fw-600 text-dark small text-uppercase">Price per Unit</span>
                        </div>
                        <span class="fw-bold text-primary fs-5">UGX {{ number_format($drug->price, 0) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="data-card mb-4">
            <div class="card-head">
                <h5>Stock Information</h5>
            </div>
            <div class="d-flex flex-column gap-3">
                <div class="d-flex align-items-center justify-content-between p-3 rounded-3" style="background: #f8fafc;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 rounded-3" style="background: rgba(37, 99, 235, 0.1);">
                            <i class="bi bi-stack text-primary"></i>
                        </div>
                        <span class="fw-600 text-dark">Current Stock</span>
                    </div>
                    <span class="fw-bold {{ $drug->quantity <= $drug->low_stock_threshold ? 'text-danger' : 'text-success' }}">
                        {{ $drug->quantity }} units
                    </span>
                </div>
                <div class="d-flex align-items-center justify-content-between p-3 rounded-3" style="background: #f8fafc;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 rounded-3" style="background: rgba(37, 99, 235, 0.1);">
                            <i class="bi bi-exclamation-triangle text-warning"></i>
                        </div>
                        <span class="fw-600 text-dark">Low Stock Alert</span>
                    </div>
                    <span class="fw-bold text-dark">{{ $drug->low_stock_threshold }} units</span>
                </div>
                @if($drug->expiry_date)
                <div class="d-flex align-items-center justify-content-between p-3 rounded-3" style="background: #f8fafc;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 rounded-3" style="background: rgba(37, 99, 235, 0.1);">
                            <i class="bi bi-calendar-x text-danger"></i>
                        </div>
                        <span class="fw-600 text-dark">Expiry Date</span>
                    </div>
                    <span class="fw-bold {{ $drug->expiry_date < now() ? 'text-danger' : ($drug->expiry_date < now()->addMonths(3) ? 'text-warning' : 'text-dark') }}">
                        {{ date('d M Y', strtotime($drug->expiry_date)) }}
                    </span>
                </div>
                @endif
            </div>
        </div>
        <div class="data-card">
            <div class="card-head">
                <h5>Quick Details</h5>
            </div>
            <div class="d-flex flex-column gap-3">
                <div class="d-flex align-items-center justify-content-between p-3 rounded-3" style="background: #f8fafc;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 rounded-3" style="background: rgba(37, 99, 235, 0.1);">
                            <i class="bi bi-hash text-primary"></i>
                        </div>
                        <span class="fw-600 text-dark">Drug ID</span>
                    </div>
                    <span class="fw-bold text-primary">#{{ $drug->id }}</span>
                </div>
                <div class="d-flex align-items-center justify-content-between p-3 rounded-3" style="background: #f8fafc;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 rounded-3" style="background: rgba(37, 99, 235, 0.1);">
                            <i class="bi bi-calendar3 text-primary"></i>
                        </div>
                        <span class="fw-600 text-dark">Added</span>
                    </div>
                    <span class="fw-bold text-dark">{{ $drug->created_at->format('d M Y') }}</span>
                </div>
                <div class="d-flex align-items-center justify-content-between p-3 rounded-3" style="background: #f8fafc;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 rounded-3" style="background: rgba(37, 99, 235, 0.1);">
                            <i class="bi bi-arrow-clockwise text-primary"></i>
                        </div>
                        <span class="fw-600 text-dark">Last Updated</span>
                    </div>
                    <span class="fw-bold text-dark">{{ $drug->updated_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection