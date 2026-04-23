<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CityCare Medical Centre</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    
    <link rel="stylesheet" href="{{ asset('style.css') }}?v={{ time() }}">
    
    @stack('styles')
</head>
<body>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div id="wrapper">
        <div id="sidebar-overlay" class="d-lg-none"></div>
        <!-- Enterprise Blue Gradient Sidebar -->
        <aside class="sidebar" id="sidebar">
            <a href="{{ route('dashboard') }}" class="sidebar-logo">
                <img src="{{ asset('images/logo.png') }}" alt="CityCare Logo">
                <span>CityCare</span>
            </a>

            <nav class="nav-menu">
                <div class="nav-label">Main Console</div>
                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2"></i>
                    <span>Dashboard</span>
                </a>

                @if(Gate::check('isReceptionist') || Gate::check('isAdmin'))
                <a href="{{ route('patient.list') }}" class="nav-item {{ request()->is('patient*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span>Patient Registry</span>
                </a>
                @endif

                <a href="{{ route('appointments.index') }}" class="nav-item {{ request()->is('appointments*') ? 'active' : '' }}">
                    <i class="bi bi-calendar3"></i>
                    <span>Schedules</span>
                </a>

                <!-- Patient Only Navigation -->
                @if(auth()->user()->role && auth()->user()->role->name === 'patient')
                <div class="nav-label">My Patient Area</div>
                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house-heart-fill"></i>
                    <span>Patient Dashboard</span>
                </a>
                <a href="{{ route('patient.profile') }}" class="nav-item {{ request()->is('patient/profile*') ? 'active' : '' }}">
                    <i class="bi bi-person-badge-fill"></i>
                    <span>My Medical Profile</span>
                </a>
                @else
                <!-- Non-Patient Navigation -->
                <div class="nav-label">Medical Core</div>
                
                @can('isDoctor')
                <a href="{{ route('consultations.index') }}" class="nav-item {{ request()->is('consultations*') ? 'active' : '' }}">
                    <i class="bi bi-clipboard2-pulse"></i>
                    <span>Consultations</span>
                </a>
                @endcan

                @if(Gate::check('isPharmacist') || Gate::check('isAdmin'))
                <a href="{{ route('drug.list') }}" class="nav-item {{ request()->is('drug*') ? 'active' : '' }}">
                    <i class="bi bi-bandaid"></i>
                    <span>Pharmacy Hub</span>
                </a>
                <a href="{{ route('categories.index') }}" class="nav-item {{ request()->is('categories*') ? 'active' : '' }}">
                    <i class="bi bi-tags"></i>
                    <span>Drug Categories</span>
                </a>
                @endif

                @if(Gate::check('isCashier') || Gate::check('isAdmin'))
                <a href="{{ route('billing.index') }}" class="nav-item {{ request()->is('billing*') ? 'active' : '' }}">
                    <i class="bi bi-wallet2"></i>
                    <span>Billing & Finance</span>
                </a>
                @endif

                @can('isAdmin')
                <div class="nav-label">Administration</div>
                <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->is('admin/users*') ? 'active' : '' }}">
                    <i class="bi bi-shield-lock"></i>
                    <span>Staff Access</span>
                </a>
                <a href="{{ route('reports.index') }}" class="nav-item {{ request()->is('reports*') ? 'active' : '' }}">
                    <i class="bi bi-graph-up"></i>
                    <span>Reports & Analytics</span>
                </a>
                @endcan
                @endif
            </nav>

            <div class="mt-auto pt-4 border-top border-white border-opacity-10">
                <a href="{{ route('logout') }}" class="nav-item">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Sign Out</span>
                </a>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main id="main-content">
            <!-- Professional Top Navigation -->
            <header class="top-nav">
                <div class="d-flex align-items-center gap-3">
                    <button id="sidebar-toggle" class="btn btn-light d-lg-none border-0 p-2">
                        <i class="bi bi-list fs-4"></i>
                    </button>
                    <div class="search-box d-none d-md-flex">
                        <i class="bi bi-search text-muted"></i>
                        <input type="text" placeholder="Global search for patients, records or drugs...">
                    </div>
                </div>

                <div class="d-flex align-items-center gap-4">
                    <div class="dropdown">
                        <button class="btn btn-light rounded-circle p-2 position-relative border shadow-none" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-bell-fill text-muted"></i>
                            @if(auth()->user()->unreadNotifications()->count() > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem; min-width: 18px; height: 18px;">
                                    {{ auth()->user()->unreadNotifications()->count() > 99 ? '99+' : auth()->user()->unreadNotifications()->count() }}
                                </span>
                            @endif
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 mt-3" style="width: 350px; max-height: 400px; overflow-y: auto;">
                            <li class="dropdown-header d-flex justify-content-between align-items-center py-2 px-3 border-bottom">
                                <span class="fw-600">Notifications</span>
                                @if(auth()->user()->unreadNotifications()->count() > 0)
                                    <a href="#" class="text-primary small text-decoration-none" onclick="markAllAsRead(event)">
                                        <i class="bi bi-check-all me-1"></i>Mark all read
                                    </a>
                                @endif
                            </li>
                            
                            @php
                                $notifications = auth()->user()->notifications()->latest()->limit(10)->get();
                            @endphp
                            
                            @if($notifications->count() > 0)
                                @foreach($notifications as $notification)
                                    <li class="dropdown-item py-2 px-3 {{ $notification->read_at ? '' : 'bg-light bg-opacity-50' }}" style="cursor: pointer; border-left: 3px solid {{ $notification->read_at ? 'transparent' : '#3b82f6' }};">
                                        <div class="d-flex align-items-start gap-2">
                                            <div class="notification-icon flex-shrink-0">
                                                @switch($notification->type)
                                                    @case('appointment')
                                                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2" style="width: 32px; height: 32px;">
                                                            <i class="bi bi-calendar-check fs-6"></i>
                                                        </div>
                                                        @break
                                                    @case('payment')
                                                        <div class="rounded-circle bg-warning bg-opacity-10 text-warning p-2" style="width: 32px; height: 32px;">
                                                            <i class="bi bi-receipt fs-6"></i>
                                                        </div>
                                                        @break
                                                    @case('message')
                                                        <div class="rounded-circle bg-info bg-opacity-10 text-info p-2" style="width: 32px; height: 32px;">
                                                            <i class="bi bi-envelope fs-6"></i>
                                                        </div>
                                                        @break
                                                    @default
                                                        <div class="rounded-circle bg-secondary bg-opacity-10 text-secondary p-2" style="width: 32px; height: 32px;">
                                                            <i class="bi bi-bell fs-6"></i>
                                                        </div>
                                                        @break
                                                @endswitch
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-start mb-1">
                                                    <div class="fw-600 small">{{ $notification->data['title'] ?? 'Notification' }}</div>
                                                    @if(!$notification->read_at)
                                                        <span class="badge bg-primary rounded-pill" style="font-size: 0.6rem;">New</span>
                                                    @endif
                                                </div>
                                                <div class="text-muted small mb-1">{{ $notification->data['message'] ?? $notification->data['body'] ?? 'No message' }}</div>
                                                <div class="text-muted" style="font-size: 0.7rem;">
                                                    <i class="bi bi-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                            @if(!$notification->read_at)
                                                <button class="btn btn-sm text-muted" onclick="markAsRead(event, {{ $notification->id }})" title="Mark as read">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                                
                                <li class="dropdown-divider opacity-10"></li>
                                <li>
                                    <a href="{{ route('notifications.index') }}" class="dropdown-item text-center py-2 px-3 text-primary">
                                        <i class="bi bi-list-ul me-2"></i>View All Notifications
                                    </a>
                                </li>
                            @else
                                <li class="dropdown-item py-4 px-3 text-center text-muted">
                                    <i class="bi bi-bell-slash fs-1 mb-2 d-block"></i>
                                    <div class="small">No notifications yet</div>
                                </li>
                            @endif
                        </ul>
                    </div>

                    <div class="vr text-muted opacity-25"></div>

                    <div class="dropdown">
                        <div class="d-flex align-items-center gap-3 cursor-pointer" data-bs-toggle="dropdown" style="cursor: pointer;">
                            <div class="text-end d-none d-sm-block">
                                <div class="fw-bold small lh-1">{{ auth()->user()->name }}</div>
                                <div class="text-muted" style="font-size: 10px; text-transform: uppercase;">{{ auth()->user()->role->name }}</div>
                            </div>
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 42px; height: 42px; font-size: 14px;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 mt-3">
                            <li><a class="dropdown-item py-2 px-3" href="{{ auth()->user()->role->name === 'patient' ? route('patient.profile') : route('profile') }}"><i class="bi bi-person-circle me-2"></i> My Account</a></li>
                            <li><hr class="dropdown-divider opacity-10"></li>
                            <li><a class="dropdown-item py-2 px-3 text-danger" href="{{ route('logout') }}"><i class="bi bi-box-arrow-left me-2"></i> Logout</a></li>
                        </ul>
                    </div>
                </div>
            </header>

            @yield('content')

            <!-- Student Footer -->
            <footer class="mt-5 py-4 border-top">
                <div class="container-fluid">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-12 text-center">
                            <div class="text-muted small">
                                NABUKEERA ROSEMARY KEEYA | VU-BCS-2307-0996-DAY | {{ date('Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const wrapper = document.getElementById('wrapper');

            if (toggle) {
                toggle.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                    overlay.classList.toggle('active');
                });
            }

            if (overlay) {
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                });
            }

            // Auto-refresh notifications every 30 seconds
            setInterval(function() {
                fetchNotifications();
            }, 30000);
        });

        // Notification functions
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
                    // Remove the notification from the dropdown
                    const notificationElement = event.target.closest('li');
                    notificationElement.style.opacity = '0.5';
                    notificationElement.style.borderLeftColor = 'transparent';
                    
                    // Remove the "New" badge
                    const newBadge = notificationElement.querySelector('.badge');
                    if (newBadge) {
                        newBadge.remove();
                    }
                    
                    // Update the notification count
                    updateNotificationCount(data.unreadCount);
                    
                    // Remove the mark as read button
                    event.target.remove();
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
                    // Reload the page to refresh notifications
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error marking all notifications as read:', error);
            });
        }

        function fetchNotifications() {
            fetch('/notifications/fetch', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                updateNotificationCount(data.unreadCount);
            })
            .catch(error => {
                console.error('Error fetching notifications:', error);
            });
        }

        function updateNotificationCount(count) {
            const notificationBadge = document.querySelector('.bi-bell-fill').nextElementSibling;
            if (count > 0) {
                if (notificationBadge) {
                    notificationBadge.textContent = count > 99 ? '99+' : count;
                } else {
                    // Create badge if it doesn't exist
                    const badge = document.createElement('span');
                    badge.className = 'position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger';
                    badge.style.fontSize = '0.6rem';
                    badge.style.minWidth = '18px';
                    badge.style.height = '18px';
                    badge.textContent = count > 99 ? '99+' : count;
                    document.querySelector('.bi-bell-fill').parentElement.appendChild(badge);
                }
            } else {
                if (notificationBadge) {
                    notificationBadge.remove();
                }
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
