@extends('layouts.app')

@section('content')

<div class="dashboard-shell">

    <div class="page-header">
        <h2 class="title">Category Details</h2>
    </div>

    <div class="panel">

        <h4>{{ $category->name }}</h4>

        <p><strong>Description:</strong> {{ $category->description }}</p>

        <p><strong>Created:</strong> {{ $category->created_at->format('d M Y') }}</p>

        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
            Back
        </a>

    </div>

</div>

@endsection