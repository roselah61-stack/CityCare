@extends('layouts.app')

@section('content')
<div class="dash-header p-4 p-lg-5 rounded-4 mb-4" style="background: white; border: 1px solid var(--border); box-shadow: var(--shadow-premium);">
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between w-100 gap-4">
        <div class="d-flex align-items-center gap-3 gap-md-4">
            <div class="welcome-icon-box d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(37, 99, 235, 0.2) 100%); border-radius: 16px; font-size: 28px; color: var(--primary);">
                <i class="bi bi-tag-fill"></i>
            </div>
            <div>
                <h1 class="mb-1 fw-800" style="font-size: clamp(20px, 4vw, 28px);">{{ $category->name }}</h1>
                <p class="text-muted mb-0 fw-500 d-flex align-items-center gap-2" style="font-size: clamp(12px, 2vw, 14px);">
                    <i class="bi bi-calendar3 text-primary"></i> Created on {{ $category->created_at->format('d M Y') }}
                </p>
            </div>
        </div>
        <div class="d-flex gap-3 w-100 w-md-auto">
            @can('isPharmacist')
            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-ent rounded-pill px-4 d-flex align-items-center gap-2 transition-all hover-lift">
                <i class="bi bi-pencil"></i> Edit
            </a>
            @endcan
            <a href="{{ route('categories.index') }}" class="btn btn-light border rounded-pill px-4 fw-600 d-flex align-items-center gap-2 transition-all hover-lift">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="data-card">
            <div class="card-head">
                <h5>Category Information</h5>
            </div>
            <div class="p-3 rounded-3" style="background: #f8fafc;">
                <div class="d-flex align-items-start gap-3">
                    <div class="p-3 rounded-3" style="background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(37, 99, 235, 0.2) 100%);">
                        <i class="bi bi-tag-fill text-primary" style="font-size: 24px;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h4 class="fw-bold text-dark mb-2">{{ $category->name }}</h4>
                        <p class="text-muted mb-0 lh-lg">{{ $category->description ?: 'No description provided for this category.' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="data-card">
            <div class="card-head">
                <h5>Quick Stats</h5>
            </div>
            <div class="d-flex flex-column gap-3">
                <div class="d-flex align-items-center justify-content-between p-3 rounded-3" style="background: #f8fafc;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 rounded-3" style="background: rgba(37, 99, 235, 0.1);">
                            <i class="bi bi-hash text-primary"></i>
                        </div>
                        <span class="fw-600 text-dark">Category ID</span>
                    </div>
                    <span class="fw-bold text-primary">#{{ $category->id }}</span>
                </div>
                <div class="d-flex align-items-center justify-content-between p-3 rounded-3" style="background: #f8fafc;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 rounded-3" style="background: rgba(37, 99, 235, 0.1);">
                            <i class="bi bi-calendar3 text-primary"></i>
                        </div>
                        <span class="fw-600 text-dark">Created</span>
                    </div>
                    <span class="fw-bold text-dark">{{ $category->created_at->format('d M Y') }}</span>
                </div>
                <div class="d-flex align-items-center justify-content-between p-3 rounded-3" style="background: #f8fafc;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 rounded-3" style="background: rgba(37, 99, 235, 0.1);">
                            <i class="bi bi-arrow-clockwise text-primary"></i>
                        </div>
                        <span class="fw-600 text-dark">Last Updated</span>
                    </div>
                    <span class="fw-bold text-dark">{{ $category->updated_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection