@extends('layouts.app')

@section('content')

<div class="dashboard-shell">

    <div class="page-header">

        <div>
            <h2 class="title">Create Category</h2>
            <p class="subtitle">Add a new drug category to the system</p>
        </div>

        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Categories
        </a>

    </div>

    <div class="panel">

        <form method="POST" action="{{ route('categories.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Category Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4"></textarea>
            </div>

            <div class="d-flex justify-content-end gap-2">

                <a href="{{ route('categories.index') }}" class="btn btn-light">
                    Cancel
                </a>

                <button type="submit" class="btn btn-primary">
                    Save Category
                </button>

            </div>

        </form>

    </div>

</div>

@endsection