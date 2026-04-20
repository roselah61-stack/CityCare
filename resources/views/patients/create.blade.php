@extends('layouts.app')

@section('content')

@canany(['isAdmin', 'isReceptionist'])
   

<div class="dashboard-shell">

    <div class="page-header">

        <div>
            <h2 class="title">Add New Patient</h2>
            <p class="subtitle">Register a new patient into the hospital system</p>
        </div>

        <a href="{{ route('patient.list') }}" class="btn btn-secondary">
            Back to Patients
        </a>

    </div>

    <div class="panel">

        <form method="POST" action="{{ route('patient.store') }}">

            @csrf

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-control" required>
                        <option value="">-- Select Gender --</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Patient Status</label>
                    <select name="status" class="form-control" required>
                        <option value="Active">Active</option>
                        <option value="Discharged">Discharged</option>
                        <option value="Deceased">Deceased</option>
                    </select>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control" rows="3"></textarea>
                </div>

            </div>

            <div class="d-flex justify-content-end gap-2">

                <a href="{{ route('patient.list') }}" class="btn btn-light">
                    Cancel
                </a>

                <button type="submit" class="btn btn-primary">
                    Save Patient
                </button>

            </div>

        </form>

    </div>

</div>
@else
   <div class="alert alert-danger">
       You are not allowed to add patients.
   </div>
@endelse

@endcanany


@endsection