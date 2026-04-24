<!DOCTYPE html>
<html>
<head>
    <title>Schedule Appointment - Emergency Fallback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="alert alert-warning">
            <h4>Emergency Fallback Mode</h4>
            <p>The system is running in minimal mode due to database issues. This form allows basic appointment scheduling.</p>
        </div>
        
        <h2>Schedule Appointment</h2>
        <form method="POST" action="/appointments">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Patient Name</label>
                        <input type="text" name="patient_name" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Doctor Name</label>
                        <input type="text" name="doctor_name" class="form-control" required>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Appointment Date</label>
                        <input type="date" name="appointment_date" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Appointment Time</label>
                        <input type="time" name="appointment_time" class="form-control" required>
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Reason for Visit</label>
                <textarea name="reason" class="form-control" rows="3"></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Schedule Appointment</button>
            <a href="/dashboard" class="btn btn-secondary">Back to Dashboard</a>
        </form>
    </div>
</body>
</html>
