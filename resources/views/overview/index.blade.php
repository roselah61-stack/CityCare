@extends('layouts.app')

@section('content')
@include('includes.flash')

<div class="dashboard-shell">
    <div class="breadcrumb-banner">

    <div class="breadcrumb-content">
        <a href="{{ url('/dashboard') }}">Dashboard</a>
        <span>/</span>
        <span class="active">Overview</span>
    </div>
</div>

    <div class="page-header">

        <div>
            
            <p class="subtitle">
             {{ now()->format('l, d F Y') }}
            </p>
        </div>

    </div>

    <div class="panel" style="margin-bottom:20px;">

        <h4>System Overview</h4>

        <p style="color:#6b7280;">
            This overview shows real-time hospital statistics including patients, drugs, treatments, and categories.
        </p>

    </div>
    <div class="kpi-grid">

        <div class="kpi-card blue">
            <div>
                <h6>Patients</h6>
                <h2>{{ $patients }}</h2>
            </div>
            <div class="kpi-icon blue">
                <i class="bi bi-person"></i>
            </div>
        </div>

        <div class="kpi-card green">
            <div>
                <h6>Drugs</h6>
                <h2>{{ $drugs }}</h2>
            </div>
            <div class="kpi-icon green">
                <i class="bi bi-capsule"></i>
            </div>
        </div>

        <div class="kpi-card orange">
            <div>
                <h6>Treatments</h6>
                <h2>{{ $treatments }}</h2>
            </div>
            <div class="kpi-icon orange">
                <i class="bi bi-heart-pulse"></i>
            </div>
        </div>

        <div class="kpi-card red">
            <div>
                <h6>Categories</h6>
                <h2>{{ $categories }}</h2>
            </div>
            <div class="kpi-icon red">
                <i class="bi bi-tags"></i>
            </div>
        </div>

    </div>

    <div class="panel" style="margin-top:25px;">

        <div class="panel-header">
            <h5>Hospital Data Overview</h5>
            <span>Live Statistics</span>
        </div>

        <canvas id="hospitalChart" height="120"></canvas>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('hospitalChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Patients', 'Drugs', 'Treatments', 'Categories'],
        datasets: [{
            label: 'Overview',
            data: [
                {{ $patients }},
                {{ $drugs }},
                {{ $treatments }},
                {{ $categories }}
            ],
            backgroundColor: [
                '#4f46e5',
                '#22c55e',
                '#f97316',
                '#ef4444'
            ],
            borderRadius: 8
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        }
    }
});
</script>

@endsection