@extends('layouts.app')

@section('content')

<div class="dashboard-shell">

    <div class="page-header">
        <div>
            <h2 class="title">Patients Management</h2>
            <p class="subtitle">Manage hospital patient records</p>
        </div>

        <a href="{{ route('patient.create') }}" class="btn btn-primary">
            Add Patient
        </a>
    </div>

    <div class="panel">

        <div class="panel-header">
            <h5>Patient List</h5>
            <span>Total: {{ $patients->count() }}</span>
        </div>

        <div class="table-responsive">
        <table class="table table-hover align-middle">

            <thead class="table-light">
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($patients as $patient)

                <tr>
                    <td>{{ $patient->id }}</td>
                    <td>{{ $patient->name }}</td>
                    <td>{{ $patient->phone }}</td>
                    <td>{{ $patient->email }}</td>

                    <td>
                        @php
                            $status = $patient->status ?? 'Active';

                            if ($status == 'Active') {
                                $badge = 'bg-success';
                            } elseif ($status == 'Discharged') {
                                $badge = 'bg-primary';
                            } elseif ($status == 'Critical') {
                                $badge = 'bg-warning';
                            } elseif ($status == 'Deceased') {
                                $badge = 'bg-dark';
                            } else {
                                $badge = 'bg-secondary';
                            }
                        @endphp

                        <span class="badge {{ $badge }}">
                            {{ $status }}
                        </span>
                    </td>

                    <td>
                        <a href="{{ route('patient.show', $patient->id) }}" class="btn btn-info btn-sm">
                            View
                        </a>

                        <a href="{{ route('patient.edit', $patient->id) }}"
                           class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <form action="{{ route('patient.destroy', $patient->id) }}"
                              method="POST"
                              style="display:inline-block;">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this patient?')">
                                Delete
                            </button>

                        </form>

                    </td>
                </tr>

                @empty

                <tr>
                    <td colspan="6" class="text-center text-muted">
                        No patients found
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>
        </div>

    </div>

</div>

@endsection