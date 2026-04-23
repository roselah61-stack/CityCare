@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h4 class="mb-0">Verify Your Email Address</h4>
                </div>
                <div class="card-body p-4">
                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <p class="text-muted">
                        Before proceeding, please check your email for a verification link. 
                        If you did not receive the email, click the button below to request another.
                    </p>

                    <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                Resend Verification Email
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <a href="{{ route('logout') }}" class="text-danger small text-decoration-none">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
