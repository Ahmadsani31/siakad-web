@extends('layouts.guest')
@section('content')
    <div class="row justify-content-center w-100">
        <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
                <div class="card-body">
                    <h2 class="text-center mb-3">Update Your Password</h2>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" value="{{ $request->email ?? old('email') }}"
                                aria-describedby="validationEmail" readonly>
                            @error('email')
                                <div id="validationEmail" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
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
                        <div class="mb-3">
                            <label for="password-conf" class="form-label">Comfirm Password</label>
                            <div class="input-group mb-3">
                                <input type="password" name="password_confirmation" class="form-control" id="password-conf"
                                    aria-describedby="validationPassword">
                                <span class="input-group-text" id="togglePasswordConf">
                                    <i class="fa-solid fa-eye-slash" id="toggleIconConf"></i>
                                </span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary w-100 fs-4 mb-4 rounded-2">Update</button>
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

        document.getElementById('togglePasswordConf').addEventListener('click', function() {
            const passwordFieldConf = document.getElementById('password-conf');

            if (passwordFieldConf.type === 'password') {
                passwordFieldConf.type = 'text';
                $('#toggleIconConf').removeClass('fa-solid fa-eye-slash');
                $('#toggleIconConf').addClass('fa-solid fa-eye');
            } else {
                passwordFieldConf.type = 'password';
                $('#toggleIconConf').removeClass('fa-solid fa-eye');
                $('#toggleIconConf').addClass('fa-solid fa-eye-slash');
            }
        });
    </script>
@endPushOnce
