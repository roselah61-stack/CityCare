@extends('layouts.app')

@section('content')

<div class="container py-4 dashboard-shell">

    <div class="row align-items-center mb-4">

        <div class="col-12 col-md-8">
            <h2 class="fw-bold mb-1">Categories</h2>
            <p class="text-muted mb-0">Manage hospital drug categories</p>
        </div>

        <div class="col-12 col-md-4 text-md-end mt-3 mt-md-0">
            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Category
            </a>
        </div>

    </div>

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Category List</h5>
            <span class="text-muted">Total: {{ $categories->count() }}</span>
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover mb-0 align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($categories as $category)

                            <tr>
                                <td>{{ $category->id }}</td>
                                <td class="fw-semibold">{{ $category->name }}</td>
                                <td>{{ $category->description }}</td>

                                <td class="text-end">

                                    <a href="{{ route('categories.show', $category->id) }}"
                                       class="btn btn-sm btn-info">
                                        View
                                    </a>

                                    <a href="{{ route('categories.edit', $category->id) }}"
                                       class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <form action="{{ route('categories.destroy', $category->id) }}"
                                          method="POST"
                                          class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Delete this category?')">
                                            Delete
                                        </button>

                                    </form>

                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    No categories found
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection