@extends('layouts.app')

@section('content')

<div class="dashboard-shell">

    <div class="page-header">
        <div>
            <h2 class="title">
                Welcome to Medicure Hospital System
            </h2><br>

            <p class="subtitle date-box">
    <i class="bi bi-calendar3"></i>
    {{ now()->format('l, d F Y') }}
</p>
        </div>

        <div>
            <form method="GET" action="{{ url()->current() }}" class="search-box-wrapper">

                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       class="search-box form-control"
                       placeholder="Search patients">

                <button type="submit" class="search-icon-btn">
                    <i class="bi bi-search"></i>
                </button>

            </form>
        </div>
    </div>

    <div class="kpi-grid">

        <div class="kpi-card blue">
            <div>
                <h6>Total Patients</h6>
                <h2>{{ $totalPatients }}</h2>
                <small>Registered patients</small>
            </div>
            <div class="kpi-icon blue">
                <i class="bi bi-people"></i>
            </div>
        </div>

        <div class="kpi-card green">
            <div>
                <h6>Total Drugs</h6>
                <h2>{{ $totalDrugs }}</h2>
                <small>Pharmacy inventory</small>
            </div>
            <div class="kpi-icon green">
                <i class="bi bi-capsule"></i>
            </div>
        </div>

        <div class="kpi-card orange">
            <div>
                <h6>Drug Categories</h6>
                <h2>{{ $totalCategories }}</h2>
                <small>Drug groups</small>
            </div>
            <div class="kpi-icon orange">
                <i class="bi bi-folder"></i>
            </div>
        </div>

        <div class="kpi-card red">
            <div>
                <h6>Active Treatments</h6>
                <h2>{{ $totalTreatments }}</h2>
                <small>Active records</small>
            </div>
            <div class="kpi-icon red">
                <i class="bi bi-heart-pulse"></i>
            </div>
        </div>

    </div>

    <div class="analytics-grid">

        <div class="panel chart-panel">
            <div class="panel-header">
                <h5>Patient Admission Trend</h5>
                <span>Monthly registrations</span>
            </div>

            <canvas id="patientsChart"></canvas>
        </div>

        <div class="panel chart-panel">
            <div class="panel-header">
                <h5>Drug Category Distribution</h5>
                <span>Inventory breakdown</span>
            </div>

            <canvas id="drugChart"></canvas>
        </div>

    </div>

<div class="panel">

    <div class="panel-header d-flex justify-content-between align-items-center">

        <div>
            <h5 class="mb-0">Recent Patients</h5>
            <small class="text-muted">Latest hospital records</small>
        </div>

        <div class="d-flex gap-2 align-items-center">

            @if(request('search'))
                <span class="badge bg-info text-dark">
                    Search: {{ request('search') }}
                </span>

                <a href="{{ route('dashboard') }}" class="btn btn-sm btn-secondary">
                    Back
                </a>
            @endif

        </div>

    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle">

            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Patient Name</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($patients as $p)

                    <tr>
                        <td>{{ $p->id }}</td>

                        <td class="fw-semibold">
                            {{ $p->name }}
                        </td>

                        <td>{{ $p->phone }}</td>

                        <td>
                           @php
$class = match($p->status) {
    'Active' => 'bg-success',
    'Discharged' => 'bg-primary',
    'Deceased' => 'bg-dark',
    default => 'bg-warning'
};
@endphp

<span class="badge {{ $class }}">
    {{ $p->status }}
</span>
                        </td>

                        <td class="text-end">

                            <a href="{{ route('patient.show', $p->id) }}"
                               class="btn btn-sm btn-outline-primary">
                                View
                            </a>

                            <a href="{{ route('patient.edit', $p->id) }}"
                               class="btn btn-sm btn-warning">
                                Edit
                            </a>

                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">

                            @if(request('search'))
                                No patients found for "{{ request('search') }}"
                            @else
                                No patients available yet
                            @endif

                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>
    </div>

</div>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {

    new Chart(document.getElementById('patientsChart'), {
        type: 'line',
        data: {
            labels: @json($months),
            datasets: [{
                label: 'Patients Registered',
                data: @json($patientCounts),
                borderColor: '#4f46e5',
                backgroundColor: 'rgba(79,70,229,0.12)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#4f46e5'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            }
        }
    });

    new Chart(document.getElementById('drugChart'), {
        type: 'doughnut',
        data: {
            labels: @json($drugCategories),
            datasets: [{
                data: @json($drugCounts),
                backgroundColor: [
                    '#4f46e5',
                    '#22c55e',
                    '#f97316',
                    '#bf00ff',
                    '#10b981',
                    '#f63b3b',
                    '#fff700',
                    '#05fefa'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

});
</script>
@endpush