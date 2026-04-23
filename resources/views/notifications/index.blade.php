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
                        <i class="bi bi-bell-fill"></i> Notifications
                    </div>
                    <h1 class="fw-900 mb-0" style="font-size: clamp(20px, 3vw, 32px); line-height: 1.2; text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3); color: white; white-space: nowrap;">
                        Your <span style="color: #fbbf24; text-shadow: 0 2px 8px rgba(251, 191, 36, 0.5);">Notifications</span>
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
                @if(auth()->user()->unreadNotifications()->count() > 0)
                    <button onclick="markAllAsRead(event)" class="btn btn-light border rounded-pill px-3 py-2 fw-600 small d-flex align-items-center gap-2 flex-grow-1 flex-sm-grow-0 justify-content-center transition-all hover-lift" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3); color: #1e293b;">
                        <i class="bi bi-check-all"></i> <span class="d-none d-sm-inline">Mark All Read</span>
                    </button>
                @endif
                <a href="{{ route('dashboard') }}" class="btn btn-light border rounded-pill px-3 py-2 fw-600 small d-flex align-items-center gap-2 flex-grow-1 flex-sm-grow-0 justify-content-center transition-all hover-lift" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3); color: #1e293b;">
                    <i class="bi bi-arrow-left"></i> <span class="d-none d-sm-inline">Back to Dashboard</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Notifications Stats -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-3 text-center">
                <div class="notification-icon bg-primary bg-opacity-10 text-primary rounded-circle p-3 mx-auto mb-3" style="width: 60px; height: 60px;">
                    <i class="bi bi-bell fs-4"></i>
                </div>
                <h5 class="text-primary fw-bold">{{ auth()->user()->notifications()->count() }}</h5>
                <p class="text-muted small mb-0">Total Notifications</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-3 text-center">
                <div class="notification-icon bg-warning bg-opacity-10 text-warning rounded-circle p-3 mx-auto mb-3" style="width: 60px; height: 60px;">
                    <i class="bi bi-exclamation-triangle fs-4"></i>
                </div>
                <h5 class="text-warning fw-bold">{{ auth()->user()->unreadNotifications()->count() }}</h5>
                <p class="text-muted small mb-0">Unread</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-3 text-center">
                <div class="notification-icon bg-success bg-opacity-10 text-success rounded-circle p-3 mx-auto mb-3" style="width: 60px; height: 60px;">
                    <i class="bi bi-check-circle fs-4"></i>
                </div>
                <h5 class="text-success fw-bold">{{ auth()->user()->readNotifications()->count() }}</h5>
                <p class="text-muted small mb-0">Read</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-3 text-center">
                <div class="notification-icon bg-info bg-opacity-10 text-info rounded-circle p-3 mx-auto mb-3" style="width: 60px; height: 60px;">
                    <i class="bi bi-calendar3 fs-4"></i>
                </div>
                <h5 class="text-info fw-bold">{{ auth()->user()->notifications()->where('created_at', '>=', now()->subDays(7))->count() }}</h5>
                <p class="text-muted small mb-0">This Week</p>
            </div>
        </div>
    </div>
</div>

<!-- Notifications List -->
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-0 p-3">
        <div class="section-header">
            <h5 class="section-title mb-0">
                <i class="bi bi-list-ul text-primary"></i> All Notifications
            </h5>
            <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 py-1">
                <i class="bi bi-clock-history me-1"></i> {{ $notifications->count() }} Total
            </span>
        </div>
    </div>
    <div class="card-body p-3">
        @if($notifications->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Title</th>
                            <th>Message</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notifications as $notification)
                        <tr class="{{ $notification->read_at ? '' : 'table-warning' }}">
                            <td>
                                <div class="notification-icon-small">
                                    @switch($notification->type)
                                        @case('appointment')
                                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 d-inline-block" style="width: 32px; height: 32px;">
                                                <i class="bi bi-calendar-check fs-6"></i>
                                            </div>
                                            @break
                                        @case('payment')
                                            <div class="rounded-circle bg-warning bg-opacity-10 text-warning p-2 d-inline-block" style="width: 32px; height: 32px;">
                                                <i class="bi bi-receipt fs-6"></i>
                                            </div>
                                            @break
                                        @case('message')
                                            <div class="rounded-circle bg-info bg-opacity-10 text-info p-2 d-inline-block" style="width: 32px; height: 32px;">
                                                <i class="bi bi-envelope fs-6"></i>
                                            </div>
                                            @break
                                        @default
                                            <div class="rounded-circle bg-secondary bg-opacity-10 text-secondary p-2 d-inline-block" style="width: 32px; height: 32px;">
                                                <i class="bi bi-bell fs-6"></i>
                                            </div>
                                            @break
                                    @endswitch
                                </div>
                            </td>
                            <td>
                                <div class="fw-600">{{ $notification->data['title'] ?? 'Notification' }}</div>
                            </td>
                            <td>
                                <div class="text-truncate" style="max-width: 300px;" title="{{ $notification->data['message'] ?? $notification->data['body'] ?? 'No message' }}">
                                    {{ \Illuminate\Support\Str::limit($notification->data['message'] ?? $notification->data['body'] ?? 'No message', 50) }}
                                </div>
                            </td>
                            <td>
                                <div class="small">
                                    <div>{{ $notification->created_at->format('M d, Y') }}</div>
                                    <div class="text-muted">{{ $notification->created_at->format('g:i A') }}</div>
                                </div>
                            </td>
                            <td>
                                @if($notification->read_at)
                                    <span class="badge bg-success rounded-pill">Read</span>
                                @else
                                    <span class="badge bg-warning rounded-pill">Unread</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    @if(!$notification->read_at)
                                        <button onclick="markAsRead(event, {{ $notification->id }})" class="btn btn-sm btn-outline-primary rounded-pill" title="Mark as read">
                                            <i class="bi bi-check"></i>
                                        </button>
                                    @endif
                                    <button onclick="deleteNotification(event, {{ $notification->id }})" class="btn btn-sm btn-outline-danger rounded-pill" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $notifications->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-bell-slash text-muted fs-1 mb-3"></i>
                <h6 class="text-muted mb-2">No notifications found</h6>
                <p class="text-muted small">You don't have any notifications yet.</p>
            </div>
        @endif
    </div>
</div>

<style>
/* Professional Notifications Styles */

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

/* Notification Icons */
.notification-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.notification-icon-small {
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Hover Effects */
.hover-lift {
    transition: all 0.2s ease;
}

.hover-lift:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Table styling for unread notifications */
.table-warning {
    background-color: rgba(250, 204, 21, 0.1) !important;
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

// Notification functions (same as in layout)
function markAsRead(event, notificationId) {
    event.preventDefault();
    event.stopPropagation();
    
    fetch(`/notifications/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error marking notification as read:', error);
    });
}

function markAllAsRead(event) {
    event.preventDefault();
    
    fetch('/notifications/read-all', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error marking all notifications as read:', error);
    });
}

function deleteNotification(event, notificationId) {
    event.preventDefault();
    
    if (confirm('Are you sure you want to delete this notification?')) {
        fetch(`/notifications/${notificationId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error deleting notification:', error);
        });
    }
}
</script>
@endsection
