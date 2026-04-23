@extends('layouts.app')

@section('content')
<div class="dash-header">
    <div>
        <h1>Consultations</h1>
        <p>Overview of all patient consultations.</p>
    </div>
</div>

<div class="data-card p-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table-ent mb-0">
            <thead>
                <tr>
                    <th class="ps-4">Patient</th>
                    <th>Doctor</th>
                    <th>Date</th>
                    <th>Diagnosis</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($consultations as $consultation)
                <tr>
                    <td class="ps-4">
                        <div class="patient-meta">
                            <div class="p-avatar">{{ strtoupper(substr($consultation->patient->name, 0, 1)) }}</div>
                            <div>
                                <div class="fw-bold text-dark">{{ $consultation->patient->name }}</div>
                                <div class="text-muted small" style="font-size: 11px;">#PAT-{{ 1000 + $consultation->patient->id }}</div>
                            </div>
                        </div>
                    </td>
                    <td>Dr. {{ $consultation->doctor->name }}</td>
                    <td>{{ $consultation->created_at->format('d M Y') }}</td>
                    <td>{{ Str::limit($consultation->diagnosis, 50) }}</td>
                    <td class="text-end pe-4">
                        <a href="{{ route('consultations.show', $consultation->id) }}" class="btn btn-light btn-sm border rounded-3 px-3 fw-600" title="View Details">
                            View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <i class="bi bi-journal-medical display-4 text-muted mb-3 d-block opacity-25"></i>
                        <p class="text-muted fw-600">No consultations found.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
