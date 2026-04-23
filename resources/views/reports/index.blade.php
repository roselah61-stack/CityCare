@extends('layouts.app')

@section('content')
@include('includes.flash')
<!-- Breadcrumb Banner -->
<div class="breadcrumb-banner-modern mb-4" style="background-image: url('{{ asset('images/breadcrumb.jpg') }}');">
    <div class="breadcrumb-content-modern">
        <h2>Reports & Analytics</h2>
        <div class="breadcrumb-links">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span class="sep">/</span>
            <span>Reports & Analytics</span>
        </div>
    </div>
</div>

<div class="content-overlap px-4">
    <div class="dash-header p-4 rounded-4 mb-4" style="background: white; border: 1px solid var(--border); box-shadow: var(--shadow-premium);">
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between w-100 gap-4">
            <div class="d-flex align-items-center gap-3 gap-md-4">
                <div class="welcome-icon-box d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(37, 99, 235, 0.2) 100%); border-radius: 16px; font-size: 28px; color: var(--primary);">
                    <i class="bi bi-bar-chart-line-fill"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-dark mb-0">Reports & Analytics</h4>
                    <p class="text-muted mb-0 fw-500">Comprehensive overview of hospital performance and clinical data</p>
                </div>
            </div>
            <div class="d-flex gap-3 w-100 w-md-auto">
                <div class="dropdown">
                    <button class="btn btn-light border rounded-pill px-4 fw-600 d-flex align-items-center gap-2 transition-all hover-lift dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-download"></i> Export Data
                </button>
                <ul class="dropdown-menu dropdown-menu-end rounded-3 shadow-sm border-0 mt-2">
                    <li><a class="dropdown-item py-2 px-3 fw-500" href="{{ route('reports.export', 'revenue') }}"><i class="bi bi-file-earmark-spreadsheet text-success me-2"></i> Revenue Report (CSV)</a></li>
                    <li><a class="dropdown-item py-2 px-3 fw-500" href="{{ route('reports.export', 'appointments') }}"><i class="bi bi-calendar-check text-primary me-2"></i> Appointments Report (CSV)</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item py-2 px-3 fw-500 opacity-50" href="#"><i class="bi bi-file-earmark-pdf text-danger me-2"></i> Clinical Trends (PDF - Soon)</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- KPI Row -->
<div class="kpi-row mb-4">
    <div class="kpi-card-gradient" style="background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);">
        <div class="kpi-head">
            <div class="kpi-icon-box">
                <i class="bi bi-people-fill"></i>
            </div>
            <div class="kpi-trend-white">Total</div>
        </div>
        <div class="kpi-info">
            <h3 style="color: white;">{{ number_format($stats['total_patients']) }}</h3>
            <span style="color: rgba(255,255,255,0.8);">Total Patients</span>
        </div>
    </div>
    <div class="kpi-card-gradient" style="background: linear-gradient(135deg, #16a34a 0%, #22c55e 100%);">
        <div class="kpi-head">
            <div class="kpi-icon-box">
                <i class="bi bi-currency-dollar"></i>
            </div>
            <div class="kpi-trend-white">Gross</div>
        </div>
        <div class="kpi-info">
            <h3 style="color: white;">UGX {{ number_format($stats['total_revenue'], 0) }}</h3>
            <span style="color: rgba(255,255,255,0.8);">Total Revenue</span>
        </div>
    </div>
    <div class="kpi-card-gradient" style="background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);">
        <div class="kpi-head">
            <div class="kpi-icon-box">
                <i class="bi bi-calendar-event"></i>
            </div>
            <div class="kpi-trend-white">Lifetime</div>
        </div>
        <div class="kpi-info">
            <h3 style="color: white;">{{ number_format($stats['total_appointments']) }}</h3>
            <span style="color: rgba(255,255,255,0.8);">Appointments</span>
        </div>
    </div>
    <div class="kpi-card-gradient" style="background: linear-gradient(135deg, #9333ea 0%, #a855f7 100%);">
        <div class="kpi-head">
            <div class="kpi-icon-box">
                <i class="bi bi-prescription2"></i>
            </div>
            <div class="kpi-trend-white">Urgent</div>
        </div>
        <div class="kpi-info">
            <h3 style="color: white;">{{ number_format($stats['pending_prescriptions']) }}</h3>
            <span style="color: rgba(255,255,255,0.8);">Pending Meds</span>
        </div>
    </div>
</div>

<!-- Charts & Reports Grid -->
<div class="analytics-grid" style="grid-template-columns: 2fr 1fr;">
    <!-- Revenue Trend Chart -->
    <div class="data-card">
        <div class="card-head">
            <h5>Revenue Trend (Last 7 Days)</h5>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-primary-subtle text-primary rounded-pill px-3">Live Data</span>
            </div>
        </div>
        <div style="height: 380px;">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <!-- Quick Reports Sidebar -->
    <div class="data-card">
        <div class="card-head">
            <h5>Download Center</h5>
        </div>
        <div class="d-flex flex-column gap-3">
            <a href="{{ route('reports.export', 'revenue') }}" class="p-3 rounded-4 bg-light border d-flex align-items-center gap-3 text-decoration-none transition-all hover-lift">
                <div class="p-3 rounded-3 bg-success-subtle text-success">
                    <i class="bi bi-file-earmark-spreadsheet fs-4"></i>
                </div>
                <div>
                    <div class="fw-bold text-dark small">Financial Statement</div>
                    <div class="text-muted" style="font-size: 11px;">Detailed CSV of all transactions</div>
                </div>
                <i class="bi bi-chevron-right ms-auto text-muted"></i>
            </a>

            <a href="{{ route('reports.export', 'appointments') }}" class="p-3 rounded-4 bg-light border d-flex align-items-center gap-3 text-decoration-none transition-all hover-lift">
                <div class="p-3 rounded-3 bg-primary-subtle text-primary">
                    <i class="bi bi-calendar-check fs-4"></i>
                </div>
                <div>
                    <div class="fw-bold text-dark small">Appointment Log</div>
                    <div class="text-muted" style="font-size: 11px;">Historical patient visit records</div>
                </div>
                <i class="bi bi-chevron-right ms-auto text-muted"></i>
            </a>

            <div class="p-3 rounded-4 bg-light border d-flex align-items-center gap-3 opacity-75">
                <div class="p-3 rounded-3 bg-danger-subtle text-danger">
                    <i class="bi bi-file-earmark-pdf fs-4"></i>
                </div>
                <div>
                    <div class="fw-bold text-dark small">Clinical Performance</div>
                    <div class="text-muted" style="font-size: 11px;">Detailed PDF analysis (Coming soon)</div>
                </div>
                <i class="bi bi-lock-fill ms-auto text-muted small"></i>
            </div>

            <div class="mt-auto p-4 rounded-4 bg-primary text-white position-relative overflow-hidden shadow-sm" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);">
                <div class="position-relative" style="z-index: 2;">
                    <h6 class="fw-bold mb-2">Need Custom Analysis?</h6>
                    <p class="small mb-3 opacity-75">Our data team can provide custom reports tailored to your department's specific needs.</p>
                    <a href="mailto:admin@citycare.com" class="btn btn-light btn-sm rounded-pill px-4 fw-bold">Request Support</a>
                </div>
                <i class="bi bi-graph-up-arrow position-absolute bottom-0 end-0 opacity-10 m-n3" style="font-size: 120px; transform: rotate(-15deg);"></i>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenueChart').getContext('2d');
    
    // Create gradient
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(37, 99, 235, 0.2)');
    gradient.addColorStop(1, 'rgba(37, 99, 235, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($recent_revenue->pluck('date')) !!},
            datasets: [{
                label: 'Daily Revenue (UGX)',
                data: {!! json_encode($recent_revenue->pluck('total')) !!},
                borderColor: '#2563eb',
                backgroundColor: gradient,
                borderWidth: 4,
                fill: true,
                tension: 0.4,
                pointRadius: 6,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#2563eb',
                pointBorderWidth: 3,
                pointHoverRadius: 8,
                pointHoverBackgroundColor: '#2563eb',
                pointHoverBorderColor: '#fff',
                pointHoverBorderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 12,
                    titleFont: { size: 13, weight: 'bold' },
                    bodyFont: { size: 13 },
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return 'Revenue: UGX ' + new Intl.NumberFormat().format(context.raw);
                        }
                    }
                }
            },
            scales: {
                y: { 
                    beginAtZero: true, 
                    grid: { color: '#f1f5f9', borderDash: [5, 5] },
                    ticks: {
                        font: { size: 11, weight: '600' },
                        color: '#64748b',
                        callback: function(value) {
                            return value >= 1000 ? (value / 1000) + 'k' : value;
                        }
                    }
                },
                x: { 
                    grid: { display: false },
                    ticks: {
                        font: { size: 11, weight: '600' },
                        color: '#64748b'
                    }
                }
            }
        }
    });
});
</script>
@endpush

</div>
@endsection
