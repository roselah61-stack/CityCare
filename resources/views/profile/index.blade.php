@extends('layouts.app')

@section('content')

<div class="panel">


    <div class="breadcrumb-banner">

    <div class="breadcrumb-content">
        <a href="{{ url('/dashboard') }}">Dashboard</a>
        <span>/</span>
        <span class="active">Profile</span>
    </div>

</div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @php
        $user = session('user');
    @endphp

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3 text-center">

            <img src="{{ $user['image'] ?? asset('images/user.png') }}"
                 style="width:100px;height:100px;border-radius:50%;object-fit:cover;">

        </div>

        <div class="mb-3">
            <label>Name</label>
            <input type="text"
                   name="name"
                   value="{{ $user['name'] ?? '' }}"
                   class="form-control"
                   required>
        </div>
        
        <div class="mb-3">
            <label>Profile Image</label>
            <input type="file" name="profile_image" class="form-control">
        </div>

        <button class="btn btn-primary">Update Profile</button>

    </form>

</div>

@endsection