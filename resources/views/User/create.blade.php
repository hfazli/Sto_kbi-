@extends('layouts.app')

@section('title', 'Create User')

@section('content')
    <div class="pagetitle">
        <h1>Create User</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Data User</a></li>
                <li class="breadcrumb-item active">Create User</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Create User</h5>

                <form class="row g-3 needs-validation" novalidate method="POST" action="{{ route('users.store') }}">
                    @csrf
                    <div class="col-md-12">
                        <label for="id_card_number" class="form-label">ID Card Number</label>
                        <div class="input-group">
                            <input type="text" name="id_card_number"
                                class="form-control @error('id_card_number') is-invalid @enderror"
                                value="{{ old('id_card_number') }}" id="id_card_number" placeholder="silahkan inputkan ID Card Number" required>
                            <button type="button" class="btn btn-outline-secondary" id="openScanner">
                                <i class="bi bi-camera"></i> Scan
                            </button>
                        </div>
                        @error('id_card_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" name="first_name"
                            class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}"
                            placeholder="silahkan inputkan first name" required>
                        @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                            value="{{ old('last_name') }}" placeholder="silahkan inputkan last name" required>
                        @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                            value="{{ old('username') }}" placeholder="silahkan inputkan username">
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" 
                                   class="form-control @error('password') is-invalid @enderror" placeholder="Minimum 8 characters">
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                <i class="bi bi-eye-slash" id="togglePasswordIcon"></i>
                            </button>
                        </div>
                        <small class="text-muted">Minimum 8 characters</small>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label for="department" class="form-label">Department</label>
                        <input type="text" name="department" class="form-control @error('department') is-invalid @enderror"
                            value="{{ old('department') }}" placeholder="silahkan inputkan department" required>
                        @error('department')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-12">
                        <label for="role" class="form-label">Role</label>
                        <select name="role" id="role" class="form-select  mb-3 @error('role') is-invalid @enderror" required>
                            <option value="" disabled selected>Pilih Role</option>
                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                            <option value="viewer" {{ old('role') == 'viewer' ? 'selected' : '' }}>Viewer</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-6">
                        <button class="btn btn-primary" type="submit">Create User</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <div id="scannerModal" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Scan Barcode</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="reader" style="width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

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

        let scannerActive = false;
        let html5QrCode;

        document.getElementById('openScanner').addEventListener('click', function() {
            const scannerModal = new bootstrap.Modal(document.getElementById('scannerModal'));

            if (scannerActive) {
                html5QrCode.stop().then(() => {
                    scannerModal.hide();
                    scannerActive = false;
                }).catch((err) => {
                    console.error(`Unable to stop scanning, error: ${err}`);
                });
            } else {
                scannerModal.show();
                html5QrCode = new Html5Qrcode("reader");
                html5QrCode.start(
                    { facingMode: "environment" },
                    {
                        fps: 10,
                        qrbox: { width: 250, height: 100 } // Adjusted for barcode scanning
                    },
                    (decodedText) => {
                        document.getElementById('id_card_number').value = decodedText;
                        scannerModal.hide();
                        html5QrCode.stop();
                        scannerActive = false;
                    },
                    (errorMessage) => {
                        console.warn(`Barcode scan error: ${errorMessage}`);
                    }
                ).then(() => {
                    scannerActive = true;
                }).catch((err) => {
                    console.error(`Unable to start scanning, error: ${err}`);
                });
            }
        });
    </script>
@endsection