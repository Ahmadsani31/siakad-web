@extends('layouts.guest')
@section('content')
    <div class="row justify-content-center w-100">
        <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
                <div class="card-body">
                    <h2 class="text-center mb-3">Sign-In</h2>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" aria-describedby="validationEmail">
                            @error('email')
                                <div id="validationEmail" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group mb-3">
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" id="password"
                                    aria-describedby="validationPassword">
                                <span class="input-group-text" id="togglePassword">
                                    <i class="fa-solid fa-eye-slash" id="toggleIcon"></i>
                                </span>
                            </div>
                            @error('password')
                                <div id="validationPassword" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="form-check">
                                <input class="form-check-input primary" type="checkbox" value=""
                                    id="flexCheckChecked">
                                <label class="form-check-label text-dark" for="flexCheckChecked">
                                    Remeber this Device
                                </label>
                            </div>
                            <a class="text-primary fw-bold" href="{{ route('password.request') }}">Forgot Password ?</a>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Sign In</button>
                        <div class="d-flex align-items-center justify-content-center">
                            <a class="text-primary fw-bold ms-2" href="{{ route('register') }}">Create an account</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@pushOnce('scripts')
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordField = document.getElementById('password');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                $('#toggleIcon').removeClass('fa-solid fa-eye-slash');
                $('#toggleIcon').addClass('fa-solid fa-eye');
            } else {
                passwordField.type = 'password';
                $('#toggleIcon').removeClass('fa-solid fa-eye');
                $('#toggleIcon').addClass('fa-solid fa-eye-slash');
            }

        });
    </script>
@endPushOnce
