@extends('layouts.app')

@section('content')

<div class="dashboard-shell">

    <div class="page-header">
        <div>
            <h2 class="title">Edit Patient</h2>
        </div>

        <a href="{{ route('patient.list') }}" class="btn btn-secondary">
            ← Back
        </a>
    </div>

    <div class="panel">

        <form method="POST" action="{{ route('patient.update', $patient->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Full Name</label>
                <input type="text" name="name" value="{{ $patient->name }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Phone Number</label>
                <input type="text" name="phone" value="{{ $patient->phone }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" value="{{ $patient->email }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Gender</label>
                <select name="gender" class="form-control">
                    <option value="Male" {{ $patient->gender == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ $patient->gender == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Address</label>
                <textarea name="address" class="form-control" rows="3">{{ $patient->address }}</textarea>
            </div>

            <div class="mb-3">
                <label>Status</label>
            <select name="status" class="form-control">
    <option value="Active" {{ $patient->status == 'Active' ? 'selected' : '' }}>Active</option>
    <option value="Discharged" {{ $patient->status == 'Discharged' ? 'selected' : '' }}>Discharged</option>
    <option value="Deceased" {{ $patient->status == 'Deceased' ? 'selected' : '' }}>Deceased</option>
</select>
</div>

            <button class="btn btn-primary">
                Update Patient
            </button>

        </form>

    </div>

</div>

@endsection