// Patient Dashboard JavaScript
document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Live clock update
    function updateClock() {
        const now = new Date();
        const clockElement = document.getElementById('live-clock');
        if (clockElement) {
            clockElement.textContent = now.toLocaleTimeString('en-US', { 
                hour: '2-digit', 
                minute: '2-digit',
                hour12: true 
            });
        }
    }
    
    // Update clock every second
    updateClock();
    setInterval(updateClock, 1000);

    // Toggle appointment filters
    window.toggleAppointmentFilters = function() {
        const filters = document.getElementById('appointmentFilters');
        if (filters) {
            filters.style.display = filters.style.display === 'none' ? 'block' : 'none';
        }
    };

    // Toggle visit filters
    window.toggleVisitFilters = function() {
        const filters = document.getElementById('visitFilters');
        if (filters) {
            filters.style.display = filters.style.display === 'none' ? 'block' : 'none';
        }
    };

    // Profile form submission
    const profileForm = document.getElementById('profileForm');
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Saving...';
            submitBtn.disabled = true;
            
            fetch('/patient/profile', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Profile updated successfully!', 'success');
                } else {
                    showNotification(data.message || 'Error updating profile', 'error');
                }
            })
            .catch(error => {
                showNotification('Network error. Please try again.', 'error');
            })
            .finally(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });
    }

    // Medical form submission
    const medicalForm = document.getElementById('medicalForm');
    if (medicalForm) {
        medicalForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Saving...';
            submitBtn.disabled = true;
            
            fetch('/patient/profile', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Medical information updated successfully!', 'success');
                } else {
                    showNotification(data.message || 'Error updating medical information', 'error');
                }
            })
            .catch(error => {
                showNotification('Network error. Please try again.', 'error');
            })
            .finally(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });
    }

    // Appointment filtering
    const appointmentFilters = document.getElementById('appointmentFilters');
    if (appointmentFilters) {
        appointmentFilters.addEventListener('change', function() {
            loadAppointments();
        });
    }

    // Visit history filtering
    const visitFilters = document.getElementById('visitFilters');
    if (visitFilters) {
        visitFilters.addEventListener('change', function() {
            loadVisitHistory();
        });
    }

    // Load appointments via AJAX
    function loadAppointments() {
        const status = document.getElementById('statusFilter')?.value || '';
        const dateFrom = document.getElementById('dateFromFilter')?.value || '';
        const dateTo = document.getElementById('dateToFilter')?.value || '';
        
        const params = new URLSearchParams();
        if (status) params.append('status', status);
        if (dateFrom) params.append('date_from', dateFrom);
        if (dateTo) params.append('date_to', dateTo);
        
        fetch(`/patient/appointments?${params}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    showNotification(data.error, 'error');
                    return;
                }
                renderAppointments(data);
            })
            .catch(error => {
                showNotification('Error loading appointments', 'error');
            });
    }

    // Load visit history via AJAX
    function loadVisitHistory() {
        const dateFrom = document.getElementById('visitDateFrom')?.value || '';
        const dateTo = document.getElementById('visitDateTo')?.value || '';
        const doctorId = document.getElementById('doctorFilter')?.value || '';
        
        const params = new URLSearchParams();
        if (dateFrom) params.append('date_from', dateFrom);
        if (dateTo) params.append('date_to', dateTo);
        if (doctorId) params.append('doctor_id', doctorId);
        
        fetch(`/patient/visits?${params}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    showNotification(data.error, 'error');
                    return;
                }
                renderVisitHistory(data);
            })
            .catch(error => {
                showNotification('Error loading visit history', 'error');
            });
    }

    // Render appointments
    function renderAppointments(appointments) {
        const container = document.getElementById('appointmentsContainer');
        if (!container) return;
        
        if (appointments.length === 0) {
            container.innerHTML = `
                <div class="text-center py-5">
                    <div class="icon-box bg-gray-100 rounded-3 p-3 d-inline-flex mb-3">
                        <i class="bi bi-calendar-x text-gray-400 fs-1"></i>
                    </div>
                    <h5 class="text-gray-600 mb-2">No Appointments Found</h5>
                    <p class="text-muted small mb-4">No appointments match your criteria</p>
                </div>
            `;
            return;
        }
        
        const html = appointments.map(appointment => `
            <div class="appointment-item d-flex align-items-center gap-4 p-3 rounded-3 mb-3" style="background: #f8fafc; border-left: 4px solid var(--primary);">
                <div class="appointment-date text-center">
                    <div class="bg-primary text-white rounded-3 p-2">
                        <div class="fw-bold">${new Date(appointment.date).toLocaleDateString('en-US', { month: 'short' })}</div>
                        <div class="fs-4 fw-bold">${new Date(appointment.date).getDate()}</div>
                    </div>
                </div>
                <div class="appointment-details flex-grow-1">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <h6 class="fw-bold text-dark mb-0">Dr. ${appointment.doctor?.name || 'Not Assigned'}</h6>
                        <span class="badge bg-success bg-opacity-20 text-success rounded-pill px-2 py-1 small">
                            ${appointment.status || 'Confirmed'}
                        </span>
                    </div>
                    <p class="text-muted small mb-1">
                        <i class="bi bi-hospital me-1"></i> ${appointment.department || 'General Medicine'}
                    </p>
                    <p class="text-muted small mb-0">
                        <i class="bi bi-clock me-1"></i> ${new Date(appointment.date).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' })}
                    </p>
                </div>
                <div class="appointment-actions">
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-outline-primary rounded-pill" onclick="viewAppointment(${appointment.id})">
                            <i class="bi bi-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-warning rounded-pill" onclick="rescheduleAppointment(${appointment.id})">
                            <i class="bi bi-arrow-clockwise"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger rounded-pill" onclick="cancelAppointment(${appointment.id})">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
        
        container.innerHTML = html;
    }

    // Render visit history
    function renderVisitHistory(visits) {
        const container = document.getElementById('visitsContainer');
        if (!container) return;
        
        if (visits.data && visits.data.length === 0) {
            container.innerHTML = `
                <div class="text-center py-4">
                    <div class="icon-box bg-gray-100 rounded-3 p-3 d-inline-flex mb-3">
                        <i class="bi bi-file-medical text-gray-400 fs-1"></i>
                    </div>
                    <h6 class="text-gray-600 mb-2">No Visit History</h6>
                    <p class="text-muted small mb-0">Your medical records will appear here</p>
                </div>
            `;
            return;
        }
        
        const visitData = visits.data || visits;
        const html = visitData.map(visit => `
            <div class="visit-item p-3 rounded-3 mb-3" style="background: #f8fafc;">
                <div class="d-flex align-items-start justify-content-between mb-2">
                    <div>
                        <h6 class="fw-bold text-dark mb-1">Dr. ${visit.doctor?.name || 'Unknown'}</h6>
                        <p class="text-muted small mb-0">
                            <i class="bi bi-calendar3 me-1"></i> ${new Date(visit.date).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' })}
                        </p>
                    </div>
                    <span class="badge bg-success bg-opacity-20 text-success rounded-pill px-2 py-1 small">
                        Completed
                    </span>
                </div>
                <p class="text-muted small mb-2">
                    <strong>Diagnosis:</strong> ${visit.diagnosis || 'General checkup'}
                </p>
                <p class="text-muted small mb-0">
                    <strong>Treatment:</strong> ${visit.treatment || 'Medication prescribed'}
                </p>
            </div>
        `).join('');
        
        container.innerHTML = html;
    }

    // Notification system
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
        notification.style.zIndex = '9999';
        notification.style.minWidth = '300px';
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(notification);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 5000);
    }

    // Appointment action functions
    window.viewAppointment = function(id) {
        // Implement view appointment modal or redirect
        console.log('View appointment:', id);
        showNotification('Opening appointment details...', 'info');
    };

    window.rescheduleAppointment = function(id) {
        // Implement reschedule functionality
        console.log('Reschedule appointment:', id);
        showNotification('Opening reschedule form...', 'info');
    };

    window.cancelAppointment = function(id) {
        if (confirm('Are you sure you want to cancel this appointment?')) {
            // Implement cancel functionality
            console.log('Cancel appointment:', id);
            showNotification('Cancelling appointment...', 'warning');
        }
    };

    // Check for upcoming appointment reminders
    function checkAppointmentReminders() {
        fetch('/patient/appointments?status=confirmed')
            .then(response => response.json())
            .then(appointments => {
                appointments.forEach(appointment => {
                    const appointmentDate = new Date(appointment.date);
                    const now = new Date();
                    const hoursUntilAppointment = (appointmentDate - now) / (1000 * 60 * 60);
                    
                    // Show reminder if appointment is within 24 hours
                    if (hoursUntilAppointment > 0 && hoursUntilAppointment <= 24) {
                        const reminderKey = `reminder_${appointment.id}`;
                        if (!localStorage.getItem(reminderKey)) {
                            showNotification(
                                `You have an appointment tomorrow at ${appointmentDate.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' })} with Dr. ${appointment.doctor?.name || 'Unknown'}`,
                                'info'
                            );
                            localStorage.setItem(reminderKey, 'true');
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Error checking appointments:', error);
            });
    }

    // Check reminders on page load
    checkAppointmentReminders();
    
    // Check reminders every 30 minutes
    setInterval(checkAppointmentReminders, 30 * 60 * 1000);

    // Initialize page
    console.log('Patient Dashboard initialized');
});
