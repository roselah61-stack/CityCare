@extends('layouts.app')

@section('content')

<div class="dashboard-shell">

    <div class="page-header">
        <div>
            <h2 class="title">Add Treatment</h2>
        </div>

        <a href="{{ route('treatment.list') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <div class="panel">

        <form method="POST" action="{{ route('treatment.store') }}">
            @csrf

            <div class="mb-3">
                <label>Patient</label>
                <select name="patient_id" class="form-control" required>
                    <option value="">Select Patient</option>

                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}">
                            {{ $patient->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Drug</label>
                <select name="drug_id" class="form-control" required>
                    <option value="">Select Drug</option>

                    @foreach($drugs as $drug)
                        <option value="{{ $drug->id }}">
                            {{ $drug->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Treatment Details</label>
                <textarea name="details" rows="4" class="form-control" required
                    placeholder="Describe diagnosis, dosage, instructions..."></textarea>
            </div>

            <div class="mb-3">
                <label>Date</label>
                <input type="date" name="treatment_date" class="form-control">
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-primary">
                    Save Treatment
                </button>

                <a href="{{ route('treatment.list') }}" class="btn btn-light">
                    Cancel
                </a>
            </div>

        </form>

    </div>

</div>

@endsection