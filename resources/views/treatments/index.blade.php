@extends('layouts.app')

@section('content')

<div class="container py-4 dashboard-shell">

    <div class="row align-items-center mb-4">

        <div class="col-12 col-md-8">
            <h2 class="fw-bold mb-1">Treatment Records</h2>
            <p class="text-muted mb-0">Manage patient treatments and medications</p>
        </div>

        <div class="col-12 col-md-4 text-md-end mt-3 mt-md-0">
            <a href="{{ route('treatment.create') }}" class="btn btn-primary">
                <i class="bi bi-heart-pulse"></i> Add Treatment
            </a>
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

@endsection