@extends('layouts.app')

@section('content')
@include('includes.flash')

<!-- Breadcrumb Banner -->
<div class="breadcrumb-banner-modern mb-4" style="background-image: url('{{ asset('images/breadcrumb.jpg') }}');">
    <div class="breadcrumb-content-modern">
        <h2>My Profile</h2>
        <div class="breadcrumb-links">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span class="sep">/</span>
            <span>Edit Profile</span>
        </div>
    </div>
</div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3 text-center">

            <img src="{{ $user->profile_image ? asset($user->profile_image) . '?v=' . $user->updated_at->timestamp : asset('images/user.png') }}"
                 style="width:100px;height:100px;border-radius:50%;object-fit:cover;">

        </div>

        <div class="mb-3">
            <label>Name</label>
            <input type="text"
                   name="name"
                   value="{{ $user->name ?? '' }}"
                   class="form-control"
                   required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email"
                   name="email"
                   value="{{ $user->email ?? '' }}"
                   class="form-control"
                   required>
        </div>

        <div class="mb-3">
            <label>New Password (leave blank to keep current)</label>
            <input type="password"
                   name="password"
                   class="form-control"
                   placeholder="Enter new password">
        </div>

        <div class="mb-3">
            <label>Confirm New Password</label>
            <input type="password"
                   name="password_confirmation"
                   class="form-control"
                   placeholder="Confirm new password">
        </div>
        
        <div class="mb-3">
            <label>Profile Image</label>
            <input type="file" name="profile_image" class="form-control">
        </div>

        <button class="btn btn-primary">Update Profile</button>

    </form>

@endsection