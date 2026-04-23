@extends('layouts.app')

@section('content')
<div class="dash-header p-4 p-lg-5 rounded-4 mb-4" style="background: white; border: 1px solid var(--border); box-shadow: var(--shadow-premium);">
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between w-100 gap-4">
        <div class="d-flex align-items-center gap-3 gap-md-4">
            <div class="welcome-icon-box d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(37, 99, 235, 0.2) 100%); border-radius: 16px; font-size: 28px; color: var(--primary);">
                <i class="bi bi-tag-fill"></i>
            </div>
            <div>
                <h1 class="mb-1 fw-800" style="font-size: clamp(20px, 4vw, 28px);">Create New Category</h1>
                <p class="text-muted mb-0 fw-500" style="font-size: clamp(12px, 2vw, 14px);">
                    Add a new drug category to organize your pharmacy inventory
                </p>
            </div>
        </div>
        <div class="d-flex gap-3 w-100 w-md-auto">
            <a href="{{ route('categories.index') }}" class="btn btn-light border rounded-pill px-4 fw-600 d-flex align-items-center gap-2 transition-all hover-lift">
                <i class="bi bi-arrow-left"></i> Back to Categories
            </a>
        </div>
    </div>
</div>

<div class="data-card p-4">
    <div class="card-head mb-4">
        <h5>Category Information</h5>
    </div>
    <form method="POST" action="{{ route('categories.store') }}">
        @csrf
        <div class="row g-4 mb-4">
            <div class="col-md-12">
                <label class="form-label fw-600">Category Name</label>
                <input type="text" name="name" class="form-control" required placeholder="e.g. Antibiotics, Painkillers, etc.">
            </div>

            <div class="col-md-12">
                <label class="form-label fw-600">Description</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Briefly describe the purpose of this category"></textarea>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('categories.index') }}" class="btn btn-light rounded-pill px-4 border fw-600">
                Cancel
            </a>
            <button type="submit" class="btn btn-ent rounded-pill px-4 shadow-sm fw-600">
                Create Category
            </button>
        </div>
    </form>
</div>
@endsection