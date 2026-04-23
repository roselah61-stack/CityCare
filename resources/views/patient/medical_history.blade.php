@extends('layouts.app')

@section('content')
<div class="dash-header p-3 p-lg-4 rounded-4 mb-4 position-relative overflow-hidden" style="background-image: url('{{ asset('images/doc1.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed; border: 1px solid var(--border); box-shadow: var(--shadow-premium); min-height: 240px; margin-top: 80px;">
    <!-- Overlay for text readability -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(15, 23, 42, 0.85) 0%, rgba(30, 41, 59, 0.75) 50%, rgba(37, 99, 235, 0.65) 100%);"></div>
    
    <div class="position-relative z-1">
        <div class="d-flex flex-column flex-xl-row align-items-center justify-content-between w-100 gap-3">
            <div class="welcome-content flex-grow-1">
                <div class="d-flex flex-wrap align-items-center gap-3 gap-lg-4 mb-2">
                    <div class="welcome-badge-inline d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-success text-white" style="font-size: 11px; font-weight: 600; box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);">
                        <i class="bi bi-clipboard-pulse-fill"></i> Medical History
                    </div>
                    <h1 class="fw-900 mb-0" style="font-size: clamp(20px, 3vw, 32px); line-height: 1.2; text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3); color: white; white-space: nowrap;">
                        Your <span style="color: #fbbf24; text-shadow: 0 2px 8px rgba(251, 191, 36, 0.5);">Health Records</span>
                    </h1>
                </div>
                <div class="d-flex flex-wrap align-items-center gap-2 gap-lg-3 small fw-500" style="font-size: clamp(11px, 1.3vw, 13px); color: rgba(255, 255, 255, 0.9);">
                    <span class="d-flex align-items-center gap-1 px-2 py-1 rounded-pill" style="background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2);">
                        <i class="bi bi-calendar3"></i> {{ now()->format('l, d F Y') }}
                    </span>
                    <span class="d-flex align-items-center gap-1 px-2 py-1 rounded-pill" style="background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2);">
                        <i class="bi bi-clock"></i> <span id="live-clock">{{ now()->format('H:i') }}</span>
                    </span>
                    <span style="color: rgba(255, 255, 255, 0.7);">CityCare Medical Centre</span>
                </div>
            </div>
            <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-xl-auto">
                <a href="{{ route('dashboard') }}" class="btn btn-light border rounded-pill px-3 py-2 fw-600 small d-flex align-items-center gap-2 flex-grow-1 flex-sm-grow-0 justify-content-center transition-all hover-lift" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3); color: #1e293b;">
                    <i class="bi bi-arrow-left"></i> <span class="d-none d-sm-inline">Back to Dashboard</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Medical History Stats -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-3 text-center">
                <div class="medical-icon bg-primary bg-opacity-10 text-primary rounded-circle p-3 mx-auto mb-3" style="width: 60px; height: 60px;">
                    <i class="bi bi-clipboard-pulse fs-4"></i>
                </div>
                <h5 class="text-primary fw-bold">{{ $consultations->count() }}</h5>
                <p class="text-muted small mb-0">Total Consultations</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-3 text-center">
                <div class="medical-icon bg-info bg-opacity-10 text-info rounded-circle p-3 mx-auto mb-3" style="width: 60px; height: 60px;">
                    <i class="bi bi-prescription fs-4"></i>
                </div>
                <h5 class="text-info fw-bold">{{ $consultations->whereNotNull('prescription')->count() }}</h5>
                <p class="text-muted small mb-0">Prescriptions</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-3 text-center">
                <div class="medical-icon bg-success bg-opacity-10 text-success rounded-circle p-3 mx-auto mb-3" style="width: 60px; height: 60px;">
                    <i class="bi bi-calendar-check fs-4"></i>
                </div>
                <h5 class="text-success fw-bold">{{ $consultations->where('created_at', '>=', now()->subMonths(6))->count() }}</h5>
                <p class="text-muted small mb-0">Last 6 Months</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-3 text-center">
                <div class="medical-icon bg-warning bg-opacity-10 text-warning rounded-circle p-3 mx-auto mb-3" style="width: 60px; height: 60px;">
                    <i class="bi bi-people fs-4"></i>
                </div>
                <h5 class="text-warning fw-bold">{{ $consultations->pluck('doctor_id')->unique()->count() }}</h5>
                <p class="text-muted small mb-0">Different Doctors</p>
            </div>
        </div>
    </div>
</div>

<!-- Consultations List -->
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-0 p-3">
        <div class="section-header">
            <h5 class="section-title mb-0">
                <i class="bi bi-clipboard-pulse text-primary"></i> Consultation History
            </h5>
            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">
                <i class="bi bi-clock-history me-1"></i> {{ $consultations->count() }} Records
            </span>
        </div>
    </div>
    <div class="card-body p-3">
        @if($consultations->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Doctor</th>
                            <th>Chief Complaint</th>
                            <th>Diagnosis</th>
                            <th>Prescription</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($consultations as $consultation)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="date-badge bg-primary text-white rounded-2 p-2 text-center" style="min-width: 50px;">
                                        <div class="date-day fw-bold">{{ \Carbon\Carbon::parse($consultation->created_at)->format('d') }}</div>
                                        <div class="date-month small">{{ \Carbon\Carbon::parse($consultation->created_at)->format('M') }}</div>
                                    </div>
                                    <span>{{ \Carbon\Carbon::parse($consultation->created_at)->format('M d, Y') }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-circle bg-secondary text-white" style="width: 32px; height: 32px; font-size: 0.8rem; line-height: 32px;">
                                        {{ strtoupper(substr($consultation->doctor->name, 0, 2)) }}
                                    </div>
                                    <span>Dr. {{ $consultation->doctor->name }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="text-truncate d-block" style="max-width: 200px;" title="{{ $consultation->chief_complaint }}">
                                    {{ \Illuminate\Support\Str::limit($consultation->chief_complaint, 30) }}
                                </span>
                            </td>
                            <td>
                                <span class="text-truncate d-block" style="max-width: 200px;" title="{{ $consultation->diagnosis }}">
                                    {{ \Illuminate\Support\Str::limit($consultation->diagnosis, 30) }}
                                </span>
                            </td>
                            <td>
                                @if($consultation->prescription)
                                    <span class="badge bg-info bg-opacity-10 text-info rounded-pill">
                                        <i class="bi bi-prescription2 me-1"></i>Yes
                                    </span>
                                @else
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill">
                                        <i class="bi bi-x-circle me-1"></i>No
                                    </span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('patient.consultation.show', $consultation->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">View Details</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-clipboard-x text-muted fs-1 mb-3"></i>
                <h6 class="text-muted mb-2">No medical history found</h6>
                <p class="text-muted small mb-3">You haven't had any consultations yet.</p>
                <a href="{{ route('patient.book.appointment') }}" class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-calendar-plus me-2"></i>Book Your First Consultation
                </a>
            </div>
        @endif
    </div>
</div>

<style>
/* Professional Medical History Styles */

/* Welcome Badge */
.welcome-badge-inline {
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

/* Professional Section Headers */
.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #f1f5f9;
}

.section-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Enhanced Cards */
.card {
    border: 1px solid rgba(226, 232, 240, 0.8);
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
}

.card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transform: translateY(-1px);
}

/* Date Badge */
.date-badge {
    font-size: 0.8rem;
}

.date-day {
    font-size: 0.9rem;
}

.date-month {
    font-size: 0.6rem;
    text-transform: uppercase;
}

/* Avatar Circle */
.avatar-circle {
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

/* Medical Icons */
.medical-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

/* Hover Effects */
.hover-lift {
    transition: all 0.2s ease;
}

.hover-lift:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}
</style>

<script>
// Live Clock functionality
document.addEventListener('DOMContentLoaded', function() {
    function updateClock() {
        const clockElement = document.getElementById('live-clock');
        if (clockElement) {
            const now = new Date();
            clockElement.textContent = now.toLocaleTimeString('en-US', { 
                hour: '2-digit', 
                minute: '2-digit',
                hour12: false 
            });
        }
    }
    
    updateClock();
    setInterval(updateClock, 1000);
});
</script>
@endsection
