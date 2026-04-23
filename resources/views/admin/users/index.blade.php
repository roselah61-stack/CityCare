@extends('layouts.app')

@section('content')
<!-- Breadcrumb Banner -->
<div class="breadcrumb-banner-modern mb-4" style="background-image: url('{{ asset('images/breadcrumb.jpg') }}');">
    <div class="breadcrumb-content-modern">
        <h2>Staff Access Control</h2>
        <div class="breadcrumb-links">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span class="sep">/</span>
            <span>System Personnel</span>
        </div>
    </div>
</div>

<div class="content-overlap px-4">
    <div class="dash-header p-4 rounded-4 mb-4" style="background: white; border: 1px solid var(--border); box-shadow: var(--shadow-premium);">
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between w-100 gap-4">
            <div class="d-flex align-items-center gap-3 gap-md-4">
                <div class="welcome-icon-box d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(37, 99, 235, 0.2) 100%); border-radius: 16px; font-size: 28px; color: var(--primary);">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-dark mb-0">System Personnel</h4>
                    <p class="text-muted mb-0 fw-500">Manage staff access and assign system roles</p>
                </div>
            </div>
            <div class="d-flex gap-3 w-100 w-md-auto">
                <a href="{{ route('admin.users.create') }}" class="btn btn-ent rounded-pill px-4 d-flex align-items-center gap-2 transition-all hover-lift">
                    <i class="bi bi-person-plus-fill"></i> Add New User
                </a>
            </div>
        </div>
    </div>

    <div class="data-card p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table-ent mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">User Identity</th>
                        <th>Assigned Role</th>
                        <th>Quick Role Update</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="ps-4">
                            <div class="patient-meta py-2">
                                <div class="p-avatar" style="background: rgba(37, 99, 235, 0.1); color: var(--primary); font-weight: 700;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $user->name }}</div>
                                    <div class="text-muted small"><i class="bi bi-envelope-at me-1"></i>{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @php
                                $roleColor = match($user->role->name ?? '') {
                                    'admin' => '#ef4444',
                                    'doctor' => '#2563eb',
                                    'pharmacist' => '#0891b2',
                                    'receptionist' => '#d97706',
                                    'patient' => '#16a34a',
                                    default => '#64748b'
                                };
                            @endphp
                            <span class="status-pill" style="background: {{ $roleColor }}15; color: {{ $roleColor }}; border: 1px solid {{ $roleColor }}30;">
                                <i class="bi bi-shield-lock me-1"></i> {{ ucfirst($user->role->name ?? 'No Role') }}
                            </span>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.assignRole', $user->id) }}" class="d-flex align-items-center gap-2">
                                @csrf
                                <select name="role_id" class="form-select form-select-sm bg-light border-0 rounded-pill px-3 shadow-none fw-600" style="width: 150px; height: 38px;">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ ($user->role_id == $role->id) ? 'selected' : '' }}>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-light btn-sm rounded-pill border px-3 fw-600 shadow-sm transition-all hover-lift" style="height: 38px;">
                                    Update
                                </button>
                            </form>
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-light btn-sm border rounded-3 px-3 fw-600 transition-all hover-lift">
                                    Edit
                                </a>
                                @if(auth()->id() !== $user->id)
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-light btn-sm border rounded-3 px-3 fw-600 text-danger transition-all hover-lift" onclick="return confirm('Revoke all access for this user?')">
                                        Delete
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection