@extends('layouts.app')

@section('content')
<div class="dash-header p-4 p-lg-5 rounded-4 mb-4" style="background: white; border: 1px solid var(--border); box-shadow: var(--shadow-premium);">
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between w-100 gap-4">
        <div class="d-flex align-items-center gap-3 gap-md-4">
            <div class="welcome-icon-box d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(37, 99, 235, 0.2) 100%); border-radius: 16px; font-size: 28px; color: var(--primary);">
                <i class="bi bi-bandaid-fill"></i>
            </div>
            <div>
                <h1 class="mb-1 fw-800" style="font-size: clamp(20px, 4vw, 28px);">Add New Drug</h1>
                <p class="text-muted mb-0 fw-500" style="font-size: clamp(12px, 2vw, 14px);">
                    Register a new medicine into the pharmacy system
                </p>
            </div>
        </div>
        <div class="d-flex gap-3 w-100 w-md-auto">
            <a href="{{ route('drug.list') }}" class="btn btn-light border rounded-pill px-4 fw-600 d-flex align-items-center gap-2 transition-all hover-lift">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>
    </div>
</div>

<div class="data-card p-4">
    <div class="card-head mb-4">
        <h5>Drug Specifications</h5>
    </div>
    <form method="POST" action="{{ route('drug.store') }}">
        @csrf
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-600">Drug Name</label>
                <input type="text" name="name" class="form-control" required placeholder="Enter drug name">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-600">Drug Category</label>
                <select name="category_id" class="form-select" required>
                    <option value="" disabled selected>Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
 
            <div class="col-md-6">
                <label class="form-label fw-600">Price (UGX)</label>
                <input type="number" name="price" class="form-control" required placeholder="0.00">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-600">Initial Quantity</label>
                <input type="number" name="quantity" class="form-control" placeholder="0">
            </div>

            <div class="col-12">
                <label class="form-label fw-600">Description / Usage Instructions</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Provide drug description and usage guidelines"></textarea>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('drug.list') }}" class="btn btn-light rounded-pill px-4 border fw-600">
                Cancel
            </a>
            <button type="submit" class="btn btn-ent rounded-pill px-4 shadow-sm fw-600">
                Register New Drug
            </button>
        </div>
    </form>
</div>
@endsection