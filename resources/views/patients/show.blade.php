@extends('layouts.app')

@section('content')

<div class="dashboard-shell">

    <div class="page-header d-flex justify-content-between align-items-center">

        <div>
            <h2 class="title">
                <i class="bi bi-person-vcard"></i> Patient Details
            </h2>
            <p class="subtitle">Complete patient information record</p>
        </div>

        <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>

    </div>

    <div class="panel">

        <div class="row">

            <div class="col-md-6">

                <h5 class="mb-3">
                    <i class="bi bi-info-circle"></i> Basic Information
                </h5>

                <p><i class="bi bi-person-vcard"></i> <strong>ID:</strong> {{ $patient->id }}</p>
                <p><i class="bi bi-person"></i> <strong>Name:</strong> {{ $patient->name }}</p>
                <p><i class="bi bi-telephone"></i> <strong>Phone:</strong> {{ $patient->phone }}</p>
                <p><i class="bi bi-envelope"></i> <strong>Email:</strong> {{ $patient->email ?? 'N/A' }}</p>
                <p><i class="bi bi-geo-alt"></i> <strong>Address:</strong> {{ $patient->address ?? 'N/A' }}</p>

            </div>

            <div class="col-md-6">

                <h5 class="mb-3">
                    <i class="bi bi-heart-pulse"></i> Medical Status
                </h5>

                @php
                    $status = $patient->status ?? 'Active';

                    $badge = match($status) {
                        'Active' => 'bg-success',
                        'Discharged' => 'bg-primary',
                        'Critical' => 'bg-warning',
                        'Deceased' => 'bg-dark',
                        default => 'bg-secondary'
                    };
                @endphp

                <p>
                    <i class="bi bi-activity"></i>
                    <strong>Status:</strong>
                    <span class="badge {{ $badge }}">
                        {{ $status }}
                    </span>
                </p>

                <p>
                    <i class="bi bi-calendar-plus"></i>
                    <strong>Created:</strong> {{ $patient->created_at->format('d M Y') }}
                </p>

                <p>
                    <i class="bi bi-calendar-check"></i>
                    <strong>Updated:</strong> {{ $patient->updated_at->format('d M Y') }}
                </p>

            </div>

        </div>

    </div>

</div>

@endsection