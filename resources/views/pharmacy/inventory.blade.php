@extends('layouts.app')

@section('page-title', 'Pharmacy Inventory & Analytics')

@section('content')
<!-- Inventory Stats -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="stat-card-v2">
                <div class="stat-icon-box text-primary" style="background: #eef2ff;">
                    <i class="bi bi-capsule"></i>
                </div>
                <div>
                    <div class="label">Total Stock Value</div>
                    <div class="value" style="font-size: 16px;">UGX {{ number_format($totalStockValue, 0) }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="stat-card-v2">
                <div class="stat-icon-box text-warning" style="background: #fffbeb;">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div>
                    <div class="label">Low Stock Items</div>
                    <div class="value">{{ $lowStockCount }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="stat-card-v2">
                <div class="stat-icon-box text-danger" style="background: #fef2f2;">
                    <i class="bi bi-calendar-x"></i>
                </div>
                <div>
                    <div class="label">Expired Drugs</div>
                    <div class="value">{{ $expiredCount }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="stat-card-v2">
                <div class="stat-icon-box text-success" style="background: #ecfdf5;">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div>
                    <div class="label">Unique Drugs</div>
                    <div class="value">{{ $drugs->count() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-title px-4 pt-4 d-flex justify-content-between align-items-center">
        <span>Drug Inventory Management</span>
        <a href="{{ route('drug.create') }}" class="btn btn-primary btn-sm rounded-pill px-3" style="font-size: 11px;">
            <i class="bi bi-plus-lg me-1"></i> Add New Drug
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Drug Name</th>
                        <th>Category</th>
                        <th>Stock Level</th>
                        <th>Expiry Date</th>
                        <th>Price (Unit)</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($drugs as $drug)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-dark">{{ $drug->name }}</div>
                            <small class="text-muted">{{ $drug->description }}</small>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $drug->category->name }}</span>
                        </td>
                        <td>
                            @php
                                $stockColor = $drug->quantity <= $drug->low_stock_threshold ? 'danger' : 'success';
                            @endphp
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress flex-grow-1" style="height: 6px; width: 60px;">
                                    <div class="progress-bar bg-{{ $stockColor }}" style="width: {{ min(($drug->quantity / 100) * 100, 100) }}%"></div>
                                </div>
                                <span class="fw-bold text-{{ $stockColor }} small">{{ $drug->quantity }}</span>
                            </div>
                        </td>
                        <td>
                            @php
                                $isExpired = $drug->expiry_date && $drug->expiry_date < now();
                                $expiryColor = $isExpired ? 'danger' : ($drug->expiry_date && $drug->expiry_date < now()->addMonths(3) ? 'warning' : 'muted');
                            @endphp
                            <span class="text-{{ $expiryColor }} small fw-bold">
                                {{ $drug->expiry_date ? date('d M Y', strtotime($drug->expiry_date)) : 'N/A' }}
                                @if($isExpired) <i class="bi bi-x-circle-fill ms-1"></i> @endif
                            </span>
                        </td>
                        <td>
                            <span class="small fw-bold">UGX {{ number_format($drug->price, 0) }}</span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('drug.edit', $drug->id) }}" class="btn btn-light btn-sm border rounded-3 px-3 fw-600 text-info">Edit</a>
                                <form action="{{ route('drug.destroy', $drug->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-light btn-sm border rounded-3 px-3 fw-600 text-danger" onclick="return confirm('Delete drug?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
