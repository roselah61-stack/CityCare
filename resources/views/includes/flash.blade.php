@if(session()->has('success'))
<div class="alert alert-success alert-dismissible fade show position-fixed" role="alert" style="top: 100px; right: 20px; z-index: 9999; min-width: 300px; max-width: 400px; border-radius: 12px; border: none; box-shadow: 0 4px 20px rgba(34, 197, 94, 0.15); background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); color: #166534;">
    <div class="d-flex align-items-center gap-3">
        <div class="flex-shrink-0">
            <div class="rounded-circle bg-success bg-opacity-10 p-2">
                <i class="bi bi-check-circle-fill text-success fs-5"></i>
            </div>
        </div>
        <div class="flex-grow-1">
            <h6 class="mb-1 fw-bold">Success!</h6>
            <p class="mb-0 small">{{ session('success') }}</p>
        </div>
        <button type="button" class="btn-close flex-shrink-0" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@endif

@if(session()->has('error'))
<div class="alert alert-danger alert-dismissible fade show position-fixed" role="alert" style="top: 100px; right: 20px; z-index: 9999; min-width: 300px; max-width: 400px; border-radius: 12px; border: none; box-shadow: 0 4px 20px rgba(239, 68, 68, 0.15); background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); color: #dc2626;">
    <div class="d-flex align-items-center gap-3">
        <div class="flex-shrink-0">
            <div class="rounded-circle bg-danger bg-opacity-10 p-2">
                <i class="bi bi-x-circle-fill text-danger fs-5"></i>
            </div>
        </div>
        <div class="flex-grow-1">
            <h6 class="mb-1 fw-bold">Error!</h6>
            <p class="mb-0 small">{{ session('error') }}</p>
        </div>
        <button type="button" class="btn-close flex-shrink-0" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@endif

@if(session()->has('warning'))
<div class="alert alert-warning alert-dismissible fade show position-fixed" role="alert" style="top: 100px; right: 20px; z-index: 9999; min-width: 300px; max-width: 400px; border-radius: 12px; border: none; box-shadow: 0 4px 20px rgba(245, 158, 11, 0.15); background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); color: #92400e;">
    <div class="d-flex align-items-center gap-3">
        <div class="flex-shrink-0">
            <div class="rounded-circle bg-warning bg-opacity-10 p-2">
                <i class="bi bi-exclamation-triangle-fill text-warning fs-5"></i>
            </div>
        </div>
        <div class="flex-grow-1">
            <h6 class="mb-1 fw-bold">Warning!</h6>
            <p class="mb-0 small">{{ session('warning') }}</p>
        </div>
        <button type="button" class="btn-close flex-shrink-0" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@endif

@if(session()->has('info'))
<div class="alert alert-info alert-dismissible fade show position-fixed" role="alert" style="top: 100px; right: 20px; z-index: 9999; min-width: 300px; max-width: 400px; border-radius: 12px; border: none; box-shadow: 0 4px 20px rgba(59, 130, 246, 0.15); background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); color: #1e40af;">
    <div class="d-flex align-items-center gap-3">
        <div class="flex-shrink-0">
            <div class="rounded-circle bg-info bg-opacity-10 p-2">
                <i class="bi bi-info-circle-fill text-info fs-5"></i>
            </div>
        </div>
        <div class="flex-grow-1">
            <h6 class="mb-1 fw-bold">Information!</h6>
            <p class="mb-0 small">{{ session('info') }}</p>
        </div>
        <button type="button" class="btn-close flex-shrink-0" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show position-fixed" role="alert" style="top: 100px; right: 20px; z-index: 9999; min-width: 300px; max-width: 400px; border-radius: 12px; border: none; box-shadow: 0 4px 20px rgba(239, 68, 68, 0.15); background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); color: #dc2626;">
    <div class="d-flex align-items-center gap-3">
        <div class="flex-shrink-0">
            <div class="rounded-circle bg-danger bg-opacity-10 p-2">
                <i class="bi bi-x-circle-fill text-danger fs-5"></i>
            </div>
        </div>
        <div class="flex-grow-1">
            <h6 class="mb-1 fw-bold">Validation Error!</h6>
            <p class="mb-0 small">Please check the following errors:</p>
            <ul class="mb-0 small mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <button type="button" class="btn-close flex-shrink-0" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            if (alert.classList.contains('show')) {
                alert.classList.remove('show');
                alert.classList.add('fade');
                setTimeout(function() {
                    alert.remove();
                }, 150);
            }
        }, 5000);
    });
});
</script>
