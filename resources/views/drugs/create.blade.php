@extends('layouts.app')

@section('content')

<div class="dashboard-shell">

    <div class="page-header">

        <div>
            <h2 class="title">Add New Drug</h2>
            <p class="subtitle">Register a new medicine into the pharmacy system</p>
        </div>

        <a href="{{ route('drug.list') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>

    </div>

    <div class="panel">

        <form method="POST" action="{{ route('drug.store') }}">
            @csrf

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">Drug Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
    <label>Drug Category</label>

    <select name="category_id" class="form-control" required>
        <option value="" disabled selected>Select Category</option>

        @foreach($categories as $category)
            <option value="{{ $category->id }}">
                {{ $category->name }}
            </option>
        @endforeach
    </select>
</div>
 
                <div class="col-md-6 mb-3">
                    <label class="form-label">Price</label>
                    <input type="number" name="price" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Quantity</label>
                    <input type="number" name="quantity" class="form-control">
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>

            </div>

            <div class="d-flex justify-content-end gap-2">

                <a href="{{ route('drug.list') }}" class="btn btn-light">
                    Cancel
                </a>

                <button type="submit" class="btn btn-primary">
                    Save Drug
                </button>

            </div>

        </form>

    </div>

</div>

@endsection