@extends('layouts.app')

@section('content')
@include('includes.flash')
<!-- Breadcrumb Banner -->
<div class="breadcrumb-banner-modern mb-4" style="background-image: url('{{ asset('images/breadcrumb.jpg') }}');">
    <div class="breadcrumb-content-modern">
        <h2>Treatment Records</h2>
        <div class="breadcrumb-links">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span class="sep">/</span>
            <span>Treatment Records</span>
        </div>
    </div>
</div>

<div class="content-overlap px-4">
    <div class="dash-header p-4 rounded-4 mb-4" style="background: white; border: 1px solid var(--border); box-shadow: var(--shadow-premium);">
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between w-100 gap-4">
            <div class="d-flex align-items-center gap-3 gap-md-4">
                <div class="welcome-icon-box d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(37, 99, 235, 0.2) 100%); border-radius: 16px; font-size: 28px; color: var(--primary);">
                    <i class="bi bi-heart-pulse-fill"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-dark mb-0">Treatment Records</h4>
                    <p class="text-muted mb-0 fw-500">Manage patient treatments and medications</p>
                </div>
            </div>
            <div class="d-flex gap-3 w-100 w-md-auto">
                @can('isDoctor')
                <a href="{{ route('treatment.create') }}" class="btn btn-ent rounded-pill px-4 d-flex align-items-center gap-2 transition-all hover-lift">
                    <i class="bi bi-heart-pulse"></i> Add Treatment
                </a>
                @endcan
            </div>
        </div>
    </div>

    </div>

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Treatment List</h5>
            <span class="text-muted">Total: {{ $treatments->count() }}</span>
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover mb-0 align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>Id</th>
                            <th>Patient</th>
                            <th>Drug</th>
                            <th>Details</th>
                            <th>Date</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($treatments as $treatment)

                            <tr>
                                <td>{{ $treatment->id }}</td>

                                <td class="fw-semibold">
                                    {{ $treatment->patient->name ?? 'Unknown' }}
                                </td>

                                <td>
                                    {{ $treatment->drug->name ?? 'N/A' }}
                                </td>

                                <td>
                                    {{ $treatment->details ?? 'N/A' }}
                                </td>

                                <td>
                                    {{ $treatment->treatment_date
                                        ? \Carbon\Carbon::parse($treatment->treatment_date)->format('d M Y')
                                        : 'N/A' }}
                                </td>

                                <td class="text-end">
    <div class="d-flex justify-content-end gap-1 flex-nowrap">

        <a href="{{ route('treatment.show', $treatment->id) }}"
           class="btn btn-sm btn-info">
            View
        </a>

        @can('isDoctor')
        <a href="{{ route('treatment.edit', $treatment->id) }}"
           class="btn btn-sm btn-warning">
            Edit
        </a>

        <form action="{{ route('treatment.destroy', $treatment->id) }}"
              method="POST"
              class="d-inline">

            @csrf
            @method('DELETE')

            <button class="btn btn-sm btn-danger"
                    onclick="return confirm('Delete this record?')">
                Delete
            </button>

        </form>
        @endcan

    </div>
</td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    No treatments found
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>
</div>
@endsection