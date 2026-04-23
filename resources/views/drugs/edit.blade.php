@extends('layouts.app')

@section('content')
<div class="dash-header p-4 p-lg-5 rounded-4 mb-4" style="background: white; border: 1px solid var(--border); box-shadow: var(--shadow-premium);">
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between w-100 gap-4">
        <div class="d-flex align-items-center gap-3 gap-md-4">
            <div class="welcome-icon-box d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(37, 99, 235, 0.2) 100%); border-radius: 16px; font-size: 28px; color: var(--primary);">
                <i class="bi bi-bandaid-fill"></i>
            </div>
            <div>
                <h1 class="mb-1 fw-800" style="font-size: clamp(20px, 4vw, 28px);">Edit Drug: <span class="text-primary">{{ $drug->name }}</span></h1>
                <p class="text-muted mb-0 fw-500" style="font-size: clamp(12px, 2vw, 14px);">
                    Update drug details and stock information
                </p>
            </div>
        </div>
        <div class="d-flex gap-3 w-100 w-md-auto">
            <a href="{{ route('drug.list') }}" class="btn btn-light border rounded-pill px-4 fw-600 d-flex align-items-center gap-2 transition-all hover-lift">
                <i class="bi bi-arrow-left"></i> Back to Drugs
            </a>
        </div>
    </div>
</div>

<div class="data-card p-4">
    <div class="card-head mb-4">
        <h5>Drug Details</h5>
    </div>
    <form action="{{ route('drug.update', $drug->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label for="name" class="form-label fw-600">Drug Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $drug->name) }}" required>
                @error('name')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="category_id" class="form-label fw-600">Category</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $drug->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-12">
                <label for="description" class="form-label fw-600">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $drug->description) }}</textarea>
                @error('description')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="price" class="form-label fw-600">Price (UGX)</label>
                <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $drug->price) }}" step="0.01" required>
                @error('price')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="quantity" class="form-label fw-600">Quantity in Stock</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', $drug->quantity) }}" required>
                @error('quantity')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="low_stock_threshold" class="form-label fw-600">Low Stock Threshold</label>
                <input type="number" class="form-control" id="low_stock_threshold" name="low_stock_threshold" value="{{ old('low_stock_threshold', $drug->low_stock_threshold) }}" required>
                @error('low_stock_threshold')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="expiry_date" class="form-label fw-600">Expiry Date</label>
                <input type="date" class="form-control" id="expiry_date" name="expiry_date" value="{{ old('expiry_date', $drug->expiry_date ? \Carbon\Carbon::parse($drug->expiry_date)->format('Y-m-d') : '') }}">
                @error('expiry_date')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-ent rounded-pill px-4 shadow-sm fw-600">
                Update Drug
            </button>
            <a href="{{ route('drug.list') }}" class="btn btn-light rounded-pill px-4 border fw-600">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection