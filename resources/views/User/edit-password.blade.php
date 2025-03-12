@extends('layouts.app')

@section('title', 'Edit Password')

@section('content')
    <div class="pagetitle">
        <h1>Edit Password</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Data User</a></li>
                <li class="breadcrumb-item active">Edit Password</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Edit Password</h5>

                <form method="POST" action="{{ route('users.updatePassword', $user) }}">
                    @csrf
                    <div class="col-md-12">
                        <label for="password" class="form-label">New Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                <i class="bi bi-eye-slash" id="togglePasswordIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                            <button type="button" class="btn btn-outline-secondary" id="togglePasswordConfirmation">
                                <i class="bi bi-eye-slash" id="togglePasswordConfirmationIcon"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-6 mt-3">
                        <button class="btn btn-primary" type="submit">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const togglePasswordIcon = document.getElementById('togglePasswordIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                togglePasswordIcon.classList.remove('bi-eye-slash');
                togglePasswordIcon.classList.add('bi-eye');
            } else {
                passwordInput.type = 'password';
                togglePasswordIcon.classList.remove('bi-eye');
                togglePasswordIcon.classList.add('bi-eye-slash');
            }
        });

        document.getElementById('togglePasswordConfirmation').addEventListener('click', function() {
            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const togglePasswordConfirmationIcon = document.getElementById('togglePasswordConfirmationIcon');

            if (passwordConfirmationInput.type === 'password') {
                passwordConfirmationInput.type = 'text';
                togglePasswordConfirmationIcon.classList.remove('bi-eye-slash');
                togglePasswordConfirmationIcon.classList.add('bi-eye');
            } else {
                passwordConfirmationInput.type = 'password';
                togglePasswordConfirmationIcon.classList.remove('bi-eye');
                togglePasswordConfirmationIcon.classList.add('bi-eye-slash');
            }
        });
    </script>
@endsection