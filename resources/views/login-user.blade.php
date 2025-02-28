<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>User Log</title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('../assets/img/icon-kbi.png') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <style>
    .page-wrapper {
      background-color: #f8f9fa;
    }

    .card {
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-body {
      padding: 2rem;
    }

    .form-label {
      font-weight: bold;
    }

    .form-control {
      border-width: 2px;
      /* Increase border thickness */
    }

    .btn-primary {
      background-color: #007bff;
      border-color: #007bff;
    }

    .btn-primary:hover {
      background-color: #0056b3;
      border-color: #004085;
    }

    .btn-success {
      background-color: #28a745;
      border-color: #28a745;
    }

    .btn-success:hover {
      background-color: #218838;
      border-color: #1e7e34;
    }

    .credits {
      text-align: center;
      margin-top: 1rem;
    }

    .credits a {
      color: #007bff;
      text-decoration: none;
    }

    .credits a:hover {
      text-decoration: underline;
    }

    .alert {
      margin-top: 1rem;
    }

    .alert-dismissible .btn-close {
      position: absolute;
      top: 0.75rem;
      right: 1rem;
    }

    /* Tambahan untuk spacing tombol */
    .btn-container {
      display: flex;
      flex-direction: column;
      gap: 1rem;
      margin-top: 1rem;
    }

    /* Pusatkan QR Scanner */
    .camera-wrapper {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      margin-top: 1.5rem;
    }

    #reader {
      width: 100%;
      max-width: 350px;
      height: auto;
      margin-top: 1rem;
    }

    .input-group-text {
      cursor: pointer;
    }
  </style>
</head>

<body>
  <div class="page-wrapper d-flex align-items-center justify-content-center min-vh-100">
    <div class="row justify-content-center w-100">
      <div class="col-md-12 col-lg-6 col-xxl-4">
        <div class="card">
          <div class="card-body text-center">
            <img src="{{ asset('../assets/img/kyoraku-baru.png') }}" width="180" alt="Logo">
            <p class="mt-2">PT.Kyoraku Blowmolding Indonesia</p>

            <!-- Notifikasi -->
            @if (session('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
              </div>
            @endif
            @if (session('error'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
              </div>
            @endif
            @if (session('auth_error'))
              <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session('auth_error') }}
              </div>
            @endif

            <!-- Form Login -->
            <form action="{{ route('loginUser') }}" method="POST" id="idCardLoginForm">
              @csrf
              <div class="mb-4">
                <label for="userId" class="form-label">ID Card Number</label>
                <div class="input-group">
                  <input type="text" name="id_card_number" class="form-control" id="userId"
                    placeholder="Silahkan scan barcode" required autofocus>
                  <span class="input-group-text" id="cameraIcon" onclick="toggleScanner()">
                    <i class="bi bi-camera"></i>
                  </span>
                </div>
              </div>

              <div class="btn-container">
                <button type="submit" id="btnSubmit" class="btn btn-primary w-100 py-2 fs-5">Sign In</button>
                <a href="{{ route('login-admin') }}" class="btn btn-outline-secondary w-100 py-2 fs-5">
                  <i class="bi bi-box-arrow-in-right"></i> Login Admin
                </a>
              </div>
            </form>

            <!-- Barcode Scanner -->
            <input type="hidden" id="barcode" name="result">
            <div class="camera-wrapper">
              <div id="reader" style="display: none;"></div>
            </div>

            <div class="copyright mt-3">
              &copy; STO MANAGEMENT SYSTEM<strong><span> 2025</span></strong>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
  <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

  <script>
    function onScanSuccess(decodedText) {
      console.log(`Code matched: ${decodedText}`);
      // Set the scanned text to the input field
      document.getElementById('userId').value = decodedText;
      // Send the scanned ID card number to the server for validation
      document.getElementById('idCardLoginForm').submit();
      showLoading();
    }

    function showLoading() {
      let submitButton = document.querySelector('#btnSubmit');
      submitButton.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Logging in...`;
      submitButton.disabled = true;
    }

    function onScanFailure(error) {
      // console.warn(`Code scan error: ${error}`);
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
      "reader", {
        fps: 24,
        qrbox: {
          width: 250,
          height: 100
        }
      }, // Adjusted for barcode scanning
      false
    );

    function toggleScanner() {
      const reader = document.getElementById('reader');
      if (reader.style.display === 'none') {
        reader.style.display = 'block';
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
      } else {
        reader.style.display = 'none';
        html5QrcodeScanner.clear();
      }
    }

    // Auto-close alert
    setTimeout(() => {
      let alertElement = document.querySelector('.alert');
      if (alertElement) {
        alertElement.classList.add('fade');
        setTimeout(() => {
          alertElement.remove();
        }, 500);
      }
    }, 2000);

    // Keep session alive
    setInterval(() => {
      fetch('/keep-session-alive').then(response => {
        if (response.ok) console.log('Session refreshed');
      });
    }, 600000);
  </script>

</body>

</html>
