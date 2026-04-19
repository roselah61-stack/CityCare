@extends('layouts.app')

@section('content')

<div class="container py-4 dashboard-shell">

    <div class="row align-items-center mb-4">

        <div class="col-12 col-md-8">
            <h2 class="fw-bold mb-1">Drugs Management</h2>
            <p class="text-muted mb-0">Manage hospital pharmacy drugs</p>
        </div>

        <div class="col-12 col-md-4 text-md-end mt-3 mt-md-0">
            <a href="{{ route('drug.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Drug
            </a>
        </div>

    </div>

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Drug List</h5>
            <span class="text-muted">Total: {{ $drugs->count() }}</span>
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover mb-0 align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Description</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($drugs as $drug)

                            <tr>
                                <td>{{ $drug->id }}</td>

                                <td class="fw-semibold">{{ $drug->name }}</td>

                                <td>
                                    {{ $drug->category->name ?? 'Unassigned' }}
                                </td>

                                <td>{{ number_format($drug->price) }}</td>

                                <td>{{ $drug->quantity }}</td>

                                <td>
                                    {{ \Illuminate\Support\Str::limit($drug->description, 50) }}
                                </td>

                                <td class="text-end">

                                    <a href="{{ route('drug.show', $drug->id) }}"
                                       class="btn btn-sm btn-info">
                                        View
                                    </a>

                                    <a href="{{ route('drug.edit', $drug->id) }}"
                                       class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <form action="{{ route('drug.destroy', $drug->id) }}"
                                          method="POST"
                                          class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Delete drug?')">
                                            Delete
                                        </button>

                                    </form>

                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    No drugs found
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