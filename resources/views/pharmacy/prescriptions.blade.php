@extends('layouts.app')

@section('page-title', 'Pharmacy Dispensing')

@section('content')
<!-- Breadcrumb Banner -->
<div class="breadcrumb-banner-modern mb-4" style="background-image: url('{{ asset('images/breadcrumb.jpg') }}');">
    <div class="breadcrumb-content-modern">
        <h2>Prescription Queue</h2>
        <div class="breadcrumb-links">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span class="sep">/</span>
            <span>Pharmacy Dispensing</span>
        </div>
    </div>
</div>

<div class="content-overlap px-4">
    <div class="dash-header p-4 rounded-4 mb-4" style="background: white; border: 1px solid var(--border); box-shadow: var(--shadow-premium);">
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between w-100 gap-4">
            <div class="d-flex align-items-center gap-3 gap-md-4">
                <div class="welcome-icon-box d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(37, 99, 235, 0.2) 100%); border-radius: 16px; font-size: 28px; color: var(--primary);">
                    <i class="bi bi-capsule"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-dark mb-0">Prescription Queue</h4>
                    <p class="text-muted mb-0 fw-500">Review and dispense medications to patients</p>
                </div>
            </div>
            <div class="d-flex gap-3 w-100 w-md-auto">
                <a href="{{ route('drug.list') }}" class="btn btn-light border shadow-sm rounded-pill px-4 d-flex align-items-center gap-2 transition-all hover-lift">
                    <i class="bi bi-capsule text-primary"></i> View Inventory
                </a>
            </div>
        </div>
    </div>

<div class="card border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Patient Details</th>
                        <th>Prescribing Doctor</th>
                        <th>Date Issued</th>
                        <th>Prescription</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prescriptions as $prescription)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-info-light text-info rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; font-weight: 700; background-color: #f0f9ff;">
                                    {{ strtoupper(substr($prescription->patient->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $prescription->patient->name }}</div>
                                    <small class="text-muted">{{ $prescription->patient->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="text-dark fw-medium">Dr. {{ $prescription->doctor->name }}</div>
                            <small class="text-muted">Physician</small>
                        </td>
                        <td>
                            <div class="text-dark fw-bold small">{{ $prescription->created_at->format('d M Y') }}</div>
                            <small class="text-muted">{{ $prescription->created_at->format('h:i A') }}</small>
                        </td>
                        <td>
                            <span class="badge bg-primary-light text-primary border border-primary px-3" style="background-color: #eef2ff;">
                                {{ $prescription->items->count() }} Medication(s)
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <button type="button" class="btn btn-primary btn-sm px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#dispenseModal{{ $prescription->id }}">
                                <i class="bi bi-capsule-pill me-1"></i> Dispense
                            </button>

                            <!-- Dispense Modal -->
                            <div class="modal fade" id="dispenseModal{{ $prescription->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg rounded-4">
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="modal-title fw-bold text-dark">Dispense Medication</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-start">
                                            <div class="bg-light p-3 rounded-3 mb-4 d-flex align-items-center">
                                                <div class="bg-white rounded-circle p-2 me-3 shadow-sm">
                                                    <i class="bi bi-person-vcard text-primary fs-4"></i>
                                                </div>
                                                <div>
                                                    <small class="text-muted text-uppercase fw-bold" style="font-size: 10px;">Patient</small>
                                                    <div class="fw-bold text-dark">{{ $prescription->patient->name }}</div>
                                                </div>
                                            </div>

                                            <h6 class="fw-bold text-dark mb-3 px-1">Prescription Details</h6>
                                            <div class="list-group list-group-flush border rounded-3 overflow-hidden">
                                                @foreach($prescription->items as $item)
                                                <div class="list-group-item d-flex justify-content-between align-items-start py-3 bg-white">
                                                    <div class="flex-grow-1">
                                                        <div class="fw-bold text-dark">{{ $item->drug->name }}</div>
                                                        <div class="text-muted small">
                                                            <span class="me-2"><i class="bi bi-clock-history me-1"></i>{{ $item->dosage }}</span>
                                                            <span><i class="bi bi-calendar3 me-1"></i>{{ $item->duration }}</span>
                                                        </div>
                                                        @if($item->instructions)
                                                        <div class="text-info small mt-1"><i class="bi bi-info-circle me-1"></i>{{ $item->instructions }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="text-end ms-3">
                                                        <div class="badge bg-dark rounded-pill mb-1">Qty: {{ $item->quantity }}</div>
                                                        <div>
                                                            @if($item->drug->quantity >= $item->quantity)
                                                            <small class="text-success fw-bold"><i class="bi bi-check2-circle me-1"></i>In Stock</small>
                                                            @else
                                                            <small class="text-danger fw-bold"><i class="bi bi-exclamation-circle me-1"></i>Insufficient</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 pt-0 pb-4 justify-content-center">
                                            <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                                            <form action="{{ route('pharmacy.dispense', $prescription->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary px-5 shadow" {{ $prescription->items->contains(fn($item) => $item->drug->quantity < $item->quantity) ? 'disabled' : '' }}>
                                                    Confirm & Dispense
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="py-4">
                                <i class="bi bi-prescription2 display-1 text-muted opacity-25 mb-3 d-block"></i>
                                <h5 class="text-muted">No pending prescriptions</h5>
                                <p class="text-muted small">All prescriptions have been successfully dispensed.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
@endsection
