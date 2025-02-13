<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Scan STO</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <!-- Favicons -->
    <link href="{{ asset('assets/img/icon-kbi.png') }}" rel="icon">
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/form.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/loader.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        .loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #282828; /* Solid background color */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
    </style>
</head>

<body>
    {{-- loader --}}
    <div class="loader" id="loader">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    {{-- loader --}}
    <section class="section">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <!-- Penanda Login -->
                <div class="navbar-form d-flex justify-content-between align-items-center mb-1 p-1  rounded">
                    <h5 class="card-title mb-0" style="font-size: 1.5rem; font-weight: bold; color: #ffff;">
                        <i class="fas fa-warehouse me-2"></i> Scan STO
                    </h5>
                    @if (session('success'))
                        <div id="alertSuccess" class="alert alert-success alert-dismissible fade show mt-1 p-1"
                            role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('notfound'))
                        <div id="alertNotFound" class="alert alert-danger alert-dismissible fade show mt-1 p-1"
                            role="alert">
                            {{ session('notfound') }}
                        </div>
                    @endif
                    <div class="text-end">
                        {{-- name --}}
                        <small class="text-muted d-block">
                            <i class="fas fa-user me-1" style="color:#1abc9c;"></i>
                            {{ $user->name ?? 'Guest' }}
                        </small>
                        <small class="text-muted d-block">
                            <strong style="color: #bdc3c7">
                                @if (!empty($user->last_login) && $user->last_login instanceof \Carbon\Carbon)
                                    {{ $user->last_login->format('d M Y, H:i:s') }}
                                @else
                                    {{ $user->last_login ?? 'Belum login' }}
                                @endif
                            </strong>
                        </small>
                        
                    </div>
                </div>
                <div class="card p-4 shadow-lg" style="margin-bottom: -10px">
                    <!-- Form Packing -->
                    <form>
                        @csrf
                        <div class="col-12 mb-2">
                            <label for="partNumberInput" class="form-label" style="font-size: 1.1rem;">Inventory ID
                                (Scan QR)</label>
                            <div class="input-group">
                                <input type="text" name="part_number" class="form-control" id="partNumberInput"
                                    required autofocus>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary btn-lg w-100" type="submit" id="">Show</button>
                        </div>
                        <input type="hidden" name="action" value="show" id="actionField">
                    </form>
                </div>
            </div>
            <div class="text-center">
                <img id="noDataImage" src="{{ asset('assets/img/Scan-Barcode.png') }}"
                    class="animated-image img-fluid py-3" loading="lazy"
                    style="max-width: 28%; height: auto; object-fit: fill; cursor: pointer;" alt="Page Not Found">
            </div>
        </div>
    </section>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    {{-- jsload --}}
    <script>
        window.addEventListener('load', function() {
            // Sembunyikan loader setelah halaman selesai dimuat
            document.getElementById('loader').style.display = 'none';
        });
    </script>
    {{-- reload with ajax  --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-focus pada input ketika halaman dimuat
            const partNumberInput = document.getElementById('partNumberInput');
            const form = document.getElementById('autoSubmitForm');

            if (partNumberInput) {
                partNumberInput.focus(); // Fokus pada input saat halaman dimuat

                document.addEventListener('click', function(event) {
                    if (event.target !== partNumberInput) {
                        partNumberInput.focus();
                    }
                });
            }
            // Fungsi untuk menampilkan alert dengan waktu otomatis hilang
            function showAlert(alertId) {
                const alertBox = document.getElementById(alertId);
                if (alertBox) {
                    alertBox.style.display = 'block';
                    alertBox.classList.add('show'); // Tambahkan animasi

                    // Hilangkan alert setelah 5 detik
                    setTimeout(() => {
                        alertBox.classList.remove('show');
                        alertBox.classList.add('fade');
                        setTimeout(() => alertBox.remove(), 500); // Hapus setelah fade-out selesai
                    }, 5000);
                }
            }
            // Panggil alert sesuai session
            @if (session('success'))
                showAlert('alertSuccess');
            @elseif (session('notfound'))
                showAlert('alertNotFound');
            @endif
        });
        // Keep session alive setiap 10 menit
        let sessionAlive = true; // Kendalikan secara global
        setInterval(() => {
            if (!sessionAlive) return;
            fetch('/keep-session-alive').catch(() => sessionAlive = false);
        }, 10 * 60 * 1000);

        function debounce(func, delay) {
            let timer;
            return function(...args) {
                clearTimeout(timer);
                timer = setTimeout(() => func.apply(this, args), delay);
            };
        }
        document.getElementById('partNumberInput').addEventListener('input', debounce(resetTimer, 500));
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Panggil fungsi sesuai session
            @if (session('notfound'))
                showAlert('alertNotFound');
            @endif
        });
        // {{-- time alert --}}
        @if (session('success') || session('notfound') || session('gagal'))
            // Waktu delay 5 detik (5000 milidetik)
            setTimeout(function() {
                // Mencari elemen alert yang ada dan menyembunyikannya
                var alertElement = document.querySelector('.alert');
                if (alertElement) {
                    alertElement.classList.remove('show');
                    alertElement.classList.add('fade');
                    setTimeout(function() {
                        alertElement.remove();
                    }, 50); // Menunggu animasi fade-out
                }
            }, 2000);
        @endif
    </script>
</body>

</html>