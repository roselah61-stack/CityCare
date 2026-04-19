@extends('layouts.app')

@section('content')

<div class="dashboard-shell">

    <div class="page-header">
        <div>
            <h2 class="title">Edit Category</h2>
        </div>

        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
            ← Back
        </a>
    </div>

    <div class="panel">

        <form method="POST" action="{{ route('categories.update', $category->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" value="{{ $category->name }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control">{{ $category->description }}</textarea>
            </div>

            <button class="btn btn-success">
                Update Category
            </button>

        </form>

    </div>

</div>

@endsection