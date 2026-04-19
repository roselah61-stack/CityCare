@extends('layouts.app')

@section('content')

<div class="dashboard-shell">

    <div class="page-header">
        <div>
            <h2 class="title">Edit Treatment</h2>
        </div>

        <a href="{{ route('treatment.list') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <div class="panel">

        <form method="POST" action="{{ route('treatment.update', $treatment->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Patient</label>
                <select name="patient_id" class="form-control" required>
                    <option value="">Select Patient</option>

                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}"
                            {{ $treatment->patient_id == $patient->id ? 'selected' : '' }}>
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
                        <option value="{{ $drug->id }}"
                            {{ $treatment->drug_id == $drug->id ? 'selected' : '' }}>
                            {{ $drug->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Treatment Details</label>
                <textarea name="details" class="form-control" rows="4" required>{{ $treatment->details }}</textarea>
            </div>

            <div class="mb-3">
                <label>Treatment Date</label>
                <input type="date" name="treatment_date"
                       value="{{ $treatment->treatment_date }}"
                       class="form-control">
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-success">
                    Update Treatment
                </button>

                <a href="{{ route('treatment.list') }}" class="btn btn-light">
                    Cancel
                </a>
            </div>

        </form>

    </div>

</div>

@endsection