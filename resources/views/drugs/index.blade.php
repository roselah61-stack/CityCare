@extends('layouts.app')

@section('content')
<div class="dash-header p-4 p-lg-5 rounded-4 mb-4" style="background: white; border: 1px solid var(--border); box-shadow: var(--shadow-premium);">
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between w-100 gap-4">
        <div class="d-flex align-items-center gap-3 gap-md-4">
            <div class="welcome-icon-box d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(37, 99, 235, 0.2) 100%); border-radius: 16px; font-size: 28px; color: var(--primary);">
                <i class="bi bi-bandaid-fill"></i>
            </div>
            <div>
                <h1 class="mb-1 fw-800" style="font-size: clamp(20px, 4vw, 28px);">Pharmacy Hub</h1>
                <p class="text-muted mb-0 fw-500" style="font-size: clamp(12px, 2vw, 14px);">
                    Manage hospital pharmacy drugs
                </p>
            </div>
        </div>
        <div class="d-flex gap-3 w-100 w-md-auto">
            @can('isPharmacist')
            <a href="{{ route('drug.create') }}" class="btn btn-ent rounded-pill px-4 d-flex align-items-center gap-2 transition-all hover-lift">
                <i class="bi bi-plus-lg"></i> Add Drug
            </a>
            @endcan
        </div>
    </div>
</div>

<div class="data-card p-0 overflow-hidden">
    <div class="card-head px-4 pt-4 pb-3">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <h5 class="mb-0">Drug List</h5>
            <span class="badge bg-primary rounded-pill px-3 py-2">Total: {{ $drugs->count() }}</span>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table-ent">
            <thead>
                <tr>
                    <th>Drug Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Expiry</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($drugs as $drug)
                <tr>
                    <td>
                        <div class="patient-meta">
                            <div class="p-avatar" style="background: rgba(37, 99, 235, 0.1); color: var(--primary);">
                                <i class="bi bi-bandaid"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark">{{ $drug->name }}</div>
                                <div class="text-muted" style="font-size: 11px;">{{ Str::limit($drug->description, 40) }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="status-pill" style="background: rgba(37, 99, 235, 0.1); color: var(--primary);">{{ $drug->category->name ?? 'Unassigned' }}</span>
                    </td>
                    <td>
                        <span class="fw-bold text-primary">UGX {{ number_format($drug->price, 0) }}</span>
                    </td>
                    <td>
                        @php
                            $stockClass = $drug->quantity <= $drug->low_stock_threshold ? 'pill-danger' : 'pill-success';
                            $stockText = $drug->quantity <= $drug->low_stock_threshold ? 'Low' : 'Good';
                        @endphp
                        <div class="d-flex align-items-center gap-2">
                            <span class="status-pill {{ $stockClass }}">{{ $stockText }}</span>
                            <span class="text-muted small">{{ $drug->quantity }} units</span>
                        </div>
                    </td>
                    <td>
                        @if($drug->expiry_date)
                            @php
                                $isExpired = $drug->expiry_date < now();
                                $expiryClass = $isExpired ? 'text-danger' : ($drug->expiry_date < now()->addMonths(3) ? 'text-warning' : 'text-muted');
                            @endphp
                            <span class="{{ $expiryClass }} small fw-600">
                                @if($isExpired)
                                    <i class="bi bi-exclamation-circle text-danger me-1"></i>
                                @endif
                                {{ date('d M Y', strtotime($drug->expiry_date)) }}
                            </span>
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </td>
                    <td class="text-end pe-4">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('drug.show', $drug->id) }}" class="btn btn-light btn-sm border rounded-3 px-3 fw-600">
                                View
                            </a>
                            @can('isPharmacist')
                            <a href="{{ route('drug.edit', $drug->id) }}" class="btn btn-light btn-sm border rounded-3 px-3 fw-600 text-info">
                                Edit
                            </a>
                            <form action="{{ route('drug.destroy', $drug->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-light btn-sm border rounded-3 px-3 fw-600 text-danger" onclick="return confirm('Delete drug?')">
                                    Delete
                                </button>
                            </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <i class="bi bi-bandaid display-4 text-muted mb-3 d-block opacity-25"></i>
                        <p class="text-muted fw-600">No drugs found in the pharmacy.</p>
                        @can('isPharmacist')
                        <a href="{{ route('drug.create') }}" class="btn btn-ent rounded-pill px-4">
                            <i class="bi bi-plus-lg me-2"></i> Add First Drug
                        </a>
                        @endcan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection