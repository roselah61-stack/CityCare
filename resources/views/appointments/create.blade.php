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
                        <div class="position-relative">
                            <input type="text" id="patientSearch" class="form-control @error('patient_id') is-invalid @enderror" 
                                   placeholder="Search patients..." autocomplete="off">
                            <input type="hidden" name="patient_id" id="patient_id" value="{{ old('patient_id') }}" required>
                            <div id="patientDropdown" class="position-absolute w-100 bg-white border rounded mt-1 shadow-sm" style="z-index: 1000; max-height: 200px; overflow-y: auto; display: none;"></div>
                        </div>
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
                                Dr. {{ $doctor->name }} {{ $doctor->specialization ? '(' . $doctor->specialization . ')' : '' }}
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
    const patientSearch = document.getElementById('patientSearch');
    const patientId = document.getElementById('patient_id');
    const patientDropdown = document.getElementById('patientDropdown');

    // Patient data from server
    const patients = @json($patients->map(function($patient) {
        return {
            id: $patient->id,
            name: $patient->name,
            email: $patient->email,
            phone: $patient->phone ?? ''
        };
    }));

    // Patient search functionality
    let selectedPatient = null;
    let searchTimeout;

    patientSearch.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();
        
        if (query.length < 2) {
            patientDropdown.style.display = 'none';
            return;
        }

        searchTimeout = setTimeout(() => {
            const filtered = patients.filter(p => 
                p.name.toLowerCase().includes(query.toLowerCase()) ||
                p.email.toLowerCase().includes(query.toLowerCase()) ||
                (p.phone && p.phone.includes(query))
            );

            patientDropdown.innerHTML = '';
            
            if (filtered.length === 0) {
                patientDropdown.innerHTML = '<div class="p-2 text-muted small">No patients found</div>';
            } else {
                filtered.forEach(patient => {
                    const item = document.createElement('div');
                    item.className = 'p-2 patient-option cursor-pointer hover-bg-light';
                    item.innerHTML = `
                        <div class="fw-bold">${patient.name}</div>
                        <div class="small text-muted">${patient.email}</div>
                        ${patient.phone ? `<div class="small text-muted">${patient.phone}</div>` : ''}
                    `;
                    item.onclick = () => selectPatient(patient);
                    patientDropdown.appendChild(item);
                });
            }
            
            patientDropdown.style.display = 'block';
        }, 300);
    });

    function selectPatient(patient) {
        selectedPatient = patient;
        patientSearch.value = patient.name;
        patientId.value = patient.id;
        patientDropdown.style.display = 'none';
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!patientSearch.contains(e.target) && !patientDropdown.contains(e.target)) {
            patientDropdown.style.display = 'none';
        }
    });

    // Enhanced availability check with caching and debouncing
    const availabilityCache = new Map();
    let availabilityTimeout;

    function fetchSlots() {
        const doctorId = doctorSelect.value;
        const date = dateInput.value;

        if (!doctorId || !date) {
            slotsContainer.innerHTML = '<p class="text-muted small mb-0">Please select a doctor and date to see available slots.</p>';
            submitBtn.disabled = true;
            return;
        }

        // Check cache first
        const cacheKey = `${doctorId}-${date}`;
        if (availabilityCache.has(cacheKey)) {
            renderSlots(availabilityCache.get(cacheKey));
            return;
        }

        slotsContainer.innerHTML = '<div class="spinner-border spinner-border-sm text-primary" role="status"></div> <span class="ms-2 small text-muted">Checking availability...</span>';

        // Debounce the API call
        clearTimeout(availabilityTimeout);
        availabilityTimeout = setTimeout(() => {
            fetch(`{{ route('appointments.checkAvailability') }}?doctor_id=${doctorId}&date=${date}`)
                .then(response => response.json())
                .then(slots => {
                    availabilityCache.set(cacheKey, slots);
                    renderSlots(slots);
                })
                .catch(error => {
                    console.error('Error checking availability:', error);
                    slotsContainer.innerHTML = '<p class="text-danger small mb-0"><i class="bi bi-exclamation-triangle me-1"></i> Error checking availability. Please try again.</p>';
                });
        }, 500);
    }

    function renderSlots(slots) {
        slotsContainer.innerHTML = '';
        
        if (slots.length === 0) {
            slotsContainer.innerHTML = '<p class="text-danger small mb-0"><i class="bi bi-exclamation-circle me-1"></i> No slots available for this day.</p>';
            submitBtn.disabled = true;
            return;
        }

        const availableSlots = slots.filter(slot => slot.available);
        
        if (availableSlots.length === 0) {
            slotsContainer.innerHTML = '<p class="text-warning small mb-0"><i class="bi bi-clock me-1"></i> All slots are booked for this day.</p>';
            submitBtn.disabled = true;
            return;
        }

        // Group slots by time periods
        const morningSlots = availableSlots.filter(s => {
            const hour = parseInt(s.time.split(':')[0]);
            return hour >= 9 && hour < 12;
        });
        
        const afternoonSlots = availableSlots.filter(s => {
            const hour = parseInt(s.time.split(':')[0]);
            return hour >= 12 && hour < 17;
        });

        if (morningSlots.length > 0) {
            const morningGroup = document.createElement('div');
            morningGroup.className = 'mb-3';
            morningGroup.innerHTML = '<div class="small text-muted mb-2">Morning</div>';
            morningSlots.forEach(slot => createSlotButton(slot, morningGroup));
            slotsContainer.appendChild(morningGroup);
        }

        if (afternoonSlots.length > 0) {
            const afternoonGroup = document.createElement('div');
            afternoonGroup.innerHTML = '<div class="small text-muted mb-2">Afternoon</div>';
            afternoonSlots.forEach(slot => createSlotButton(slot, afternoonGroup));
            slotsContainer.appendChild(afternoonGroup);
        }
    }

    function createSlotButton(slot, container) {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'btn btn-sm rounded-pill px-3 me-2 mb-2 btn-outline-primary';
        btn.innerText = formatTime(slot.time);
        
        btn.onclick = () => {
            // Remove previous selection
            document.querySelectorAll('#slots-container .btn').forEach(b => {
                b.classList.remove('btn-primary', 'text-white');
                b.classList.add('btn-outline-primary');
            });
            
            // Select current slot
            btn.classList.remove('btn-outline-primary');
            btn.classList.add('btn-primary', 'text-white');
            timeInput.value = slot.time;
            submitBtn.disabled = false;
            
            // Auto-focus on reason field
            document.querySelector('textarea[name="reason"]').focus();
        };
        
        container.appendChild(btn);
    }

    function formatTime(time) {
        const [hours, minutes] = time.split(':');
        const hour = parseInt(hours);
        const ampm = hour >= 12 ? 'PM' : 'AM';
        const displayHour = hour > 12 ? hour - 12 : hour;
        return `${displayHour}:${minutes} ${ampm}`;
    }

    // Auto-update functionality
    function setupAutoUpdate() {
        // Update availability every 30 seconds if doctor and date are selected
        setInterval(() => {
            if (doctorSelect.value && dateInput.value) {
                fetchSlots();
            }
        }, 30000);

        // Clear cache when date changes to tomorrow
        const today = new Date().toISOString().split('T')[0];
        if (dateInput.value < today) {
            availabilityCache.clear();
        }
    }

    // Event listeners
    doctorSelect.addEventListener('change', () => {
        timeInput.value = '';
        submitBtn.disabled = true;
        fetchSlots();
    });

    dateInput.addEventListener('change', () => {
        timeInput.value = '';
        submitBtn.disabled = true;
        fetchSlots();
    });

    // Initialize auto-update
    setupAutoUpdate();

    // Form validation
    document.getElementById('appointmentForm').addEventListener('submit', function(e) {
        if (!patientId.value) {
            e.preventDefault();
            alert('Please select a patient');
            patientSearch.focus();
            return false;
        }
    });
});
</script>
<style>
#slots-container .btn {
    min-width: 90px;
    font-weight: 600;
    transition: all 0.2s ease;
}
#slots-container .btn-primary {
    background-color: var(--primary) !important;
    border-color: var(--primary) !important;
}
#slots-container .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.patient-option {
    border-bottom: 1px solid var(--border);
    transition: background-color 0.2s ease;
}
.patient-option:hover {
    background-color: var(--bg-secondary);
}
.patient-option:last-child {
    border-bottom: none;
}

.cursor-pointer {
    cursor: pointer;
}

.hover-bg-light:hover {
    background-color: #f8f9fa;
}

#patientDropdown {
    border: 1px solid var(--border);
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.loading-spinner {
    display: inline-block;
    width: 16px;
    height: 16px;
    border: 2px solid #f3f3f3;
    border-top: 2px solid var(--primary);
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
@endpush
@endsection