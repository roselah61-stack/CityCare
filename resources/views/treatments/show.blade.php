@extends('layouts.app')

@section('content')

<div class="dashboard-shell">

    <div class="page-header">
        <h2 class="title">Treatment Details</h2>
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

        <a href="{{ route('treatment.list') }}" class="btn btn-secondary">
            Back
        </a>

    </div>

</div>

@endsection