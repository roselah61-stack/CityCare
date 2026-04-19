@extends('layouts.app')

@section('content')

<div class="dashboard-shell">

    <div class="page-header">
        <h2 class="title">Drug Details</h2>
    </div>

    <div class="panel">

        <h4>{{ $drug->name }}</h4>

        <p><strong>Category:</strong> {{ $drug->category->name ?? 'N/A' }}</p>

        <p><strong>Price:</strong> {{ number_format($drug->price) }} UGX</p>

        <p><strong>Quantity:</strong> {{ $drug->quantity }}</p>

        <p><strong>Description:</strong></p>
        <p>{{ $drug->description }}</p>

        <a href="{{ route('drug.list') }}" class="btn btn-secondary mt-3">
            Back
        </a>

    </div>

</div>

@endsection