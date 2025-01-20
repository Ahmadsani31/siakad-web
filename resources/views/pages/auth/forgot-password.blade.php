@extends('layouts.guest')

@section('title', 'Forget Password')

@section('content')
    <div class="row justify-content-center w-100">
        <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
                <div class="card-body">
                    <h2 class="text-center mb-3">Forget Password</h2>
                    <p class="text-center">Forgot your password? No problem. Just let us know your email
                        address and we will email you a password reset link that will
                        allow you to choose a new one.</p>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" aria-describedby="validationEmail">
                            @error('email')
                                <div id="validationEmail" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary w-100 fs-4 mb-4 rounded-2">Forget
                            Password</button>
                    </form>
                    <div class="d-flex align-items-center justify-content-center">
                        <p class="fs-4 mb-0 fw-bold">Already have an Account?</p>
                        <a class="text-primary fw-bold ms-2" href="{{ route('login') }}">Sign In</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@pushOnce('scripts')
@endPushOnce
