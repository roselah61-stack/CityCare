@extends('layouts.app')

@section('content')
@include('includes.flash')
<!-- Breadcrumb Banner -->
<div class="breadcrumb-banner-modern mb-4" style="background-image: url('{{ asset('images/breadcrumb.jpg') }}');">
    <div class="breadcrumb-content-modern">
        <h2>Drug Categories</h2>
        <div class="breadcrumb-links">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span class="sep">/</span>
            <span>Drug Categories</span>
        </div>
    </div>
</div>

<div class="content-overlap px-4">
    <div class="dash-header p-4 rounded-4 mb-4" style="background: white; border: 1px solid var(--border); box-shadow: var(--shadow-premium);">
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between w-100 gap-4">
            <div class="d-flex align-items-center gap-3 gap-md-4">
                <div class="welcome-icon-box d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(37, 99, 235, 0.2) 100%); border-radius: 16px; font-size: 28px; color: var(--primary);">
                    <i class="bi bi-tags-fill"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-dark mb-0">Drug Categories</h4>
                    <p class="text-muted mb-0 fw-500">Manage hospital drug categories</p>
                </div>
            </div>
            <div class="d-flex gap-3 w-100 w-md-auto">
                @can('isPharmacist')
                <a href="{{ route('categories.create') }}" class="btn btn-ent rounded-pill px-4 d-flex align-items-center gap-2 transition-all hover-lift">
                    <i class="bi bi-plus-lg"></i> Add Category
            </a>
            @endcan
        </div>
    </div>
</div>

<div class="data-card p-0 overflow-hidden">
    <div class="card-head px-4 pt-4 pb-3">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <h5 class="mb-0">Category List</h5>
            <span class="badge bg-primary rounded-pill px-3 py-2">Total: {{ $categories->count() }}</span>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table-ent">
            <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Description</th>
                    <th>Created</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td>
                        <div class="patient-meta">
                            <div class="p-avatar" style="background: rgba(37, 99, 235, 0.1); color: var(--primary);">
                                <i class="bi bi-tag-fill"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark">{{ $category->name }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="text-muted">{{ Str::limit($category->description, 50) ?: 'No description' }}</span>
                    </td>
                    <td>
                        <span class="text-muted small">{{ $category->created_at->format('d M Y') }}</span>
                    </td>
                    <td class="text-end pe-4">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('categories.show', $category->id) }}" class="btn btn-light btn-sm border rounded-3 px-3 fw-600">
                                View
                            </a>
                            @can('isPharmacist')
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-light btn-sm border rounded-3 px-3 fw-600 text-info">
                                Edit
                            </a>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-light btn-sm border rounded-3 px-3 fw-600 text-danger" onclick="return confirm('Delete this category?')">
                                    Delete
                                </button>
                            </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-5">
                        <i class="bi bi-tags display-4 text-muted mb-3 d-block opacity-25"></i>
                        <p class="text-muted fw-600">No categories found.</p>
                        @can('isPharmacist')
                        <a href="{{ route('categories.create') }}" class="btn btn-ent rounded-pill px-4">
                            <i class="bi bi-plus-lg me-2"></i> Add First Category
                        </a>
                        @endcan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection