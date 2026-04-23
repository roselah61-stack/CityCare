@extends('layouts.app')

@section('content')

<div class="dashboard-shell">

    <div class="page-header d-flex justify-content-between align-items-center">
        <h2 class="title">Treatment Details</h2>
        <div class="d-flex gap-2">
            @can('isDoctor')
            <a href="{{ route('treatment.edit', $treatment->id) }}" class="btn btn-warning btn-sm px-3 fw-600">
                Edit
            </a>
            @endcan
            <a href="{{ route('treatment.list') }}" class="btn btn-secondary btn-sm px-3 fw-600">
                Back
            </a>
        </div>
    </div>

    <div class="panel">

        <div class="mb-3">
            <strong>Patient:</strong>
            <p>{{ $treatment->patient->name ?? 'N/A' }}</p>
        </div>

        <div class="mb-3">
            <strong>Drug:</strong>
            <p>{{ $treatment->drug->name ?? 'N/A' }}</p>
        </div>

        <div class="mb-3">
            <strong>Treatment Details:</strong>
            <p>{{ $treatment->details }}</p>
        </div>

        <div class="mb-3">
            <strong>Date:</strong>
            <p>
                {{ $treatment->treatment_date 
                    ? \Carbon\Carbon::parse($treatment->treatment_date)->format('d M Y') 
                    : 'N/A' }}
            </p>
        </div>

    </div>

</div>

@endsection