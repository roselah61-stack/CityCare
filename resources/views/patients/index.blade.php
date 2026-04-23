@extends('layouts.app')

@section('page-title', 'Patient Management')

@section('content')
@include('includes.flash')
<!-- Breadcrumb Banner -->
<div class="breadcrumb-banner-modern mb-4" style="background-image: url('{{ asset('images/breadcrumb.jpg') }}');">
    <div class="breadcrumb-content-modern">
        <h2>Patient Registry</h2>
        <div class="breadcrumb-links">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span class="sep">/</span>
            <span>Patient Management</span>
        </div>
    </div>
</div>

<div class="content-overlap px-4">
    <div class="dash-header p-4 rounded-4 mb-4" style="background: white; border: 1px solid var(--border); box-shadow: var(--shadow-premium);">
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between w-100 gap-4">
            <div class="d-flex align-items-center gap-3 gap-md-4">
                <div class="welcome-icon-box d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(37, 99, 235, 0.2) 100%); border-radius: 16px; font-size: 28px; color: var(--primary);">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-dark mb-0">Patient Registry</h4>
                    <p class="text-muted mb-0 fw-500">Manage and search hospital patient records</p>
                </div>
            </div>
            <div class="d-flex gap-3 w-100 w-md-auto">
                @if(Gate::check('isReceptionist') || Gate::check('admin'))
                <a href="{{ route('patient.create') }}" class="btn btn-ent rounded-pill px-4 d-flex align-items-center gap-2 transition-all hover-lift">
                    <i class="bi bi-person-plus-fill"></i> Register New Patient
                </a>
                @endif
            </div>
        </div>
    </div>

<div class="data-card mb-4 p-3">
    <div class="row align-items-center g-3">
        <div class="col-12 col-md-6">
            <div class="search-box w-100">
                <i class="bi bi-search text-muted"></i>
                <input type="text" id="patientSearch" placeholder="Search by name, phone or email...">
            </div>
        </div>
        <div class="col-12 col-md-6 text-md-end">
            <div class="text-muted small fw-600">Total Records: <span class="text-primary" id="totalCount">{{ $patients->count() }}</span></div>
        </div>
    </div>
</div>

<div class="data-card p-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table-ent mb-0">
            <thead>
                <tr>
                    <th class="ps-4">Patient Details</th>
                    <th>Contact Info</th>
                    <th>Status</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody id="patientsBody">
                @forelse($patients as $patient)
                <tr>
                    <td class="ps-4">
                        <div class="patient-meta">
                            <div class="p-avatar">{{ strtoupper(substr($patient->name, 0, 1)) }}</div>
                            <div>
                                <div class="fw-bold text-dark">{{ $patient->name }}</div>
                                <div class="text-muted small" style="font-size: 11px;">#PAT-{{ 1000 + $patient->id }} • {{ ucfirst($patient->gender) }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex flex-column gap-1">
                            <div class="small fw-600"><i class="bi bi-telephone text-primary me-2"></i>{{ $patient->phone }}</div>
                            <div class="small text-muted"><i class="bi bi-envelope me-2"></i>{{ $patient->email }}</div>
                        </div>
                    </td>
                    <td>
                        @php
                            $status = $patient->status ?? 'Active';
                            $pillClass = match($status) {
                                'Active' => 'pill-success',
                                'Discharged' => 'pill-warning',
                                'Critical' => 'pill-danger',
                                default => 'pill-warning'
                            };
                        @endphp
                        <span class="status-pill {{ $pillClass }}">{{ $status }}</span>
                    </td>
                    <td class="text-end pe-4">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('patient.show', $patient->id) }}" class="btn btn-light btn-sm border rounded-3 px-3 fw-600" title="View Details">
                                View
                            </a>
                            
                            @can('isDoctor')
                            <a href="{{ route('patient.edit', $patient->id) }}" class="btn btn-light btn-sm border rounded-3 px-3 fw-600 text-info" title="Edit Record">
                                Edit
                            </a>
                            @endcan

                            @can('isAdmin')
                            <form action="{{ route('patient.destroy', $patient->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-light btn-sm border rounded-3 px-3 fw-600 text-danger" onclick="return confirm('Permanently delete this patient record?')" title="Delete">
                                    Delete
                                </button>
                            </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-5">
                        <i class="bi bi-person-x display-4 text-muted mb-3 d-block opacity-25"></i>
                        <p class="text-muted fw-600">No patient records found.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('patientSearch').addEventListener('input', function(e) {
    const search = e.target.value;
    
    fetch(`{{ route('patient.list') }}?search=${search}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(patients => {
        const body = document.getElementById('patientsBody');
        const totalCount = document.getElementById('totalCount');
        body.innerHTML = '';
        totalCount.innerText = patients.length;

        if (patients.length === 0) {
            body.innerHTML = '<tr><td colspan="5" class="text-center py-5"><i class="bi bi-person-x display-4 text-muted mb-3 d-block"></i><p class="text-muted">No patients found.</p></td></tr>';
            return;
        }

        patients.forEach(patient => {
            let statusColor = 'secondary';
            if (patient.status === 'Active') statusColor = 'success';
            else if (patient.status === 'Discharged') statusColor = 'primary';
            else if (patient.status === 'Critical') statusColor = 'danger';
            else if (patient.status === 'Deceased') statusColor = 'dark';

            body.innerHTML += `
                <tr>
                    <td class="ps-4"><span class="text-muted small fw-bold">#${patient.id}</span></td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary-light text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; font-weight: 700; background-color: #eef2ff;">
                                ${patient.name.substring(0, 1).toUpperCase()}
                            </div>
                            <div>
                                <div class="fw-bold text-dark">${patient.name}</div>
                                <small class="text-muted text-capitalize">${patient.gender || ''}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex flex-column gap-1">
                            <div class="small"><i class="bi bi-telephone text-primary me-2"></i>${patient.phone}</div>
                            <div class="small text-muted"><i class="bi bi-envelope me-2"></i>${patient.email || ''}</div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-${statusColor}-light text-${statusColor} px-3" style="background-color: var(--bs-${statusColor}-bg-subtle);">
                            ${patient.status || 'Active'}
                        </span>
                    </td>
                    <td class="text-end pe-4">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="/patient/${patient.id}" class="btn btn-light btn-sm border rounded-3 px-3 fw-600">View</a>
                            ${@json(Gate::check('isDoctor')) ? `<a href="/patient/${patient.id}/edit" class="btn btn-light btn-sm border rounded-3 px-3 fw-600 text-info">Edit</a>` : ''}
                        </div>
                    </td>
                </tr>
            `;
        });
    });
});
</script>
@endpush

</div>
@endsection
