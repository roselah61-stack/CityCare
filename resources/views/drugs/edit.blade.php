@extends('layouts.app')

@section('content')

<div class="dashboard-shell">

    <div class="page-header">
        <div>
            <h2 class="title">Edit Drug</h2>
        </div>

        <a href="{{ route('drug.list') }}" class="btn btn-secondary">
            ← Back
        </a>
    </div>

    <div class="panel">

        <form method="POST" action="{{ route('drug.update', $drug->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Drug Name</label>
                <input type="text" name="name" value="{{ $drug->name }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Drug Category</label>

                <select name="category_id" class="form-control" required>
                    <option value="" disabled>Select Category</option>

                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ $drug->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Price (UGX)</label>
                <input type="number" name="price" value="{{ $drug->price }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Quantity</label>
                <input type="number" name="quantity" value="{{ $drug->quantity }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="4">{{ $drug->description }}</textarea>
            </div>

            <button class="btn btn-success">
                Update Drug
            </button>

        </form>

    </div>

</div>

@endsection