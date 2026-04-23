@extends('layouts.app')

@section('content')
<div class="dash-header p-3 p-lg-4 rounded-4 mb-4 position-relative overflow-hidden" style="background-image: url('{{ asset('images/doc1.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed; border: 1px solid var(--border); box-shadow: var(--shadow-premium); min-height: 240px; margin-top: 80px;">
    <!-- Overlay for text readability -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(15, 23, 42, 0.85) 0%, rgba(30, 41, 59, 0.75) 50%, rgba(37, 99, 235, 0.65) 100%);"></div>
    
    <div class="position-relative z-1">
        <div class="d-flex flex-column flex-xl-row align-items-center justify-content-between w-100 gap-3">
            <div class="welcome-content flex-grow-1">
                <div class="d-flex flex-wrap align-items-center gap-3 gap-lg-4 mb-2">
                    <div class="welcome-badge-inline d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-info text-white" style="font-size: 11px; font-weight: 600; box-shadow: 0 4px 12px rgba(6, 182, 212, 0.3);">
                        <i class="bi bi-calendar-check-fill"></i> My Appointments
                    </div>
                    <h1 class="fw-900 mb-0" style="font-size: clamp(20px, 3vw, 32px); line-height: 1.2; text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3); color: white; white-space: nowrap;">
                        Your <span style="color: #fbbf24; text-shadow: 0 2px 8px rgba(251, 191, 36, 0.5);">Scheduled Visits</span>
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
                <a href="{{ route('patient.book.appointment') }}" class="btn rounded-pill px-3 py-2 d-flex align-items-center gap-2 flex-grow-1 flex-sm-grow-0 justify-content-center transition-all hover-lift" style="background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%); color: white; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4); border: none;">
                    <i class="bi bi-calendar-plus"></i> <span class="d-none d-sm-inline">Book New</span>
                    <span class="d-sm-none">Book</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Appointments List -->
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-0 p-3">
        <div class="section-header">
            <h5 class="section-title mb-0">
                <i class="bi bi-calendar-check text-primary"></i> All Appointments
            </h5>
            <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 py-1">
                <i class="bi bi-calendar3 me-1"></i> {{ $appointments->count() }} Total
            </span>
        </div>
    </div>
    <div class="card-body p-3">
        @if($appointments->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Doctor</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="date-badge bg-primary text-white rounded-2 p-2 text-center" style="min-width: 50px;">
                                        <div class="date-day fw-bold">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d') }}</div>
                                        <div class="date-month small">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M') }}</div>
                                    </div>
                                    <span>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</span>
                                </div>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-circle bg-secondary text-white" style="width: 32px; height: 32px; font-size: 0.8rem; line-height: 32px;">
                                        {{ strtoupper(substr($appointment->doctor->name, 0, 2)) }}
                                    </div>
                                    <span>Dr. {{ $appointment->doctor->name }}</span>
                                </div>
                            </td>
                            <td>{{ $appointment->reason }}</td>
                            <td>
                                <span class="badge status-badge status-{{ $appointment->status }} rounded-pill">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('patient.appointment.show', $appointment->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">View Details</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-calendar-x text-muted fs-1 mb-3"></i>
                <h6 class="text-muted mb-2">No appointments found</h6>
                <p class="text-muted small mb-3">You haven't scheduled any appointments yet.</p>
                <a href="{{ route('patient.book.appointment') }}" class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-calendar-plus me-2"></i>Book Your First Appointment
                </a>
            </div>
        @endif
    </div>
</div>

<style>
/* Professional Appointments Styles */

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

/* Status Badges */
.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
}

.status-pending { 
    background: rgba(250, 204, 21, 0.1); 
    color: #854d0e; 
    border: 1px solid rgba(250, 204, 21, 0.2);
}

.status-confirmed { 
    background: rgba(59, 130, 246, 0.1); 
    color: #1e40af; 
    border: 1px solid rgba(59, 130, 246, 0.2);
}

.status-completed { 
    background: rgba(34, 197, 94, 0.1); 
    color: #166534; 
    border: 1px solid rgba(34, 197, 94, 0.2);
}

.status-cancelled { 
    background: rgba(239, 68, 68, 0.1); 
    color: #991b1b; 
    border: 1px solid rgba(239, 68, 68, 0.2);
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
