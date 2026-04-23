@extends('layouts.app')

@section('content')
<div class="dash-header p-4 p-lg-5 rounded-4 mb-4" style="background: white; border: 1px solid var(--border); box-shadow: var(--shadow-premium);">
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between w-100 gap-4">
        <div class="d-flex align-items-center gap-3 gap-md-4">
            <div class="welcome-icon-box d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(37, 99, 235, 0.2) 100%); border-radius: 16px; font-size: 28px; color: var(--primary);">
                <i class="bi bi-calendar-plus-fill"></i>
            </div>
            <div>
                <h1 class="mb-1 fw-800" style="font-size: clamp(20px, 4vw, 28px);">Schedule Appointment</h1>
                <p class="text-muted mb-0 fw-500" style="font-size: clamp(12px, 2vw, 14px);">
                    Book a new consultation with a healthcare professional
                </p>
            </div>
        </div>
        <div class="d-flex gap-3 w-100 w-md-auto">
            <a href="{{ route('appointments.index') }}" class="btn btn-light border rounded-pill px-4 fw-600 d-flex align-items-center gap-2 transition-all hover-lift">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="data-card p-4">
            <div class="card-head mb-4">
                <h5>Appointment Booking Details</h5>
            </div>
            <form action="{{ route('appointments.store') }}" method="POST" id="appointmentForm">
                @csrf
                
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-600">Select Patient</label>
                        <select name="patient_id" class="form-select @error('patient_id') is-invalid @enderror" required>
                            <option value="">-- Choose Patient --</option>
                            @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ (old('patient_id') == $patient->id || (Auth::user()->role->name == 'patient' && Auth::id() == $patient->id)) ? 'selected' : '' }}>
                                {{ $patient->name }} ({{ $patient->email }})
                            </option>
                            @endforeach
                        </select>
                        @error('patient_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-600">Select Doctor</label>
                        <select name="doctor_id" id="doctor_id" class="form-select @error('doctor_id') is-invalid @enderror" required>
                            <option value="">-- Choose Doctor --</option>
                            @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                Dr. {{ $doctor->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('doctor_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-600">Appointment Date</label>
                        <input type="date" name="appointment_date" id="appointment_date" class="form-control @error('appointment_date') is-invalid @enderror" 
                               min="{{ date('Y-m-d') }}" value="{{ old('appointment_date') }}" required>
                        @error('appointment_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-600">Available Time Slots</label>
                        <div id="slots-container" class="d-flex flex-wrap gap-2 pt-1">
                            <p class="text-muted small mb-0">Please select a doctor and date to see available slots.</p>
                        </div>
                        <input type="hidden" name="appointment_time" id="appointment_time" required>
                        @error('appointment_time')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-600">Reason for Visit</label>
                        <textarea name="reason" class="form-control" rows="3" placeholder="Briefly describe the reason for appointment">{{ old('reason') }}</textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('appointments.index') }}" class="btn btn-light rounded-pill px-4 border fw-600">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-ent rounded-pill px-4 shadow-sm fw-600" id="submitBtn" disabled>
                        Confirm Appointment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const doctorSelect = document.getElementById('doctor_id');
    const dateInput = document.getElementById('appointment_date');
    const slotsContainer = document.getElementById('slots-container');
    const timeInput = document.getElementById('appointment_time');
    const submitBtn = document.getElementById('submitBtn');

    function fetchSlots() {
        const doctorId = doctorSelect.value;
        const date = dateInput.value;

        if (!doctorId || !date) return;

        slotsContainer.innerHTML = '<div class="spinner-border spinner-border-sm text-primary" role="status"></div> <span class="ms-2 small text-muted">Checking availability...</span>';

        fetch(`{{ route('appointments.checkAvailability') }}?doctor_id=${doctorId}&date=${date}`)
            .then(response => response.json())
            .then(slots => {
                slotsContainer.innerHTML = '';
                if (slots.length === 0) {
                    slotsContainer.innerHTML = '<p class="text-danger small mb-0"><i class="bi bi-exclamation-circle me-1"></i> No slots available for this day.</p>';
                    return;
                }

                slots.forEach(slot => {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = `btn btn-sm rounded-pill px-3 ${slot.available ? 'btn-outline-primary' : 'btn-light disabled'}`;
                    btn.innerText = slot.time;
                    btn.disabled = !slot.available;
                    
                    if (slot.available) {
                        btn.onclick = () => {
                            document.querySelectorAll('#slots-container .btn').forEach(b => {
                                b.classList.remove('btn-primary', 'text-white');
                                b.classList.add('btn-outline-primary');
                            });
                            btn.classList.remove('btn-outline-primary');
                            btn.classList.add('btn-primary', 'text-white');
                            timeInput.value = slot.time;
                            submitBtn.disabled = false;
                        };
                    }
                    
                    slotsContainer.appendChild(btn);
                });
            });
    }

    doctorSelect.onchange = fetchSlots;
    dateInput.onchange = fetchSlots;
});
</script>
<style>
#slots-container .btn {
    min-width: 90px;
    font-weight: 600;
}
#slots-container .btn-primary {
    background-color: var(--primary) !important;
    border-color: var(--primary) !important;
}
</style>
@endpush
@endsection