<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'Default Title')</title>
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
  <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <!-- Select2 CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

  <!-- Template Main CSS File -->
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>

</head>
<style>
  /* Custom untuk layar besar */
  @media (min-width: 1920px) {
    .swal2-popup {
      font-size: 1.5rem !important;
      /* Perbesar font untuk layar besar */
    }

    .swal2-title {
      font-size: 2rem !important;
      /* Perbesar judul */
    }

    .swal2-content {
      font-size: 1.5rem !important;
      /* Perbesar konten */
    }

    .swal2-confirm {
      font-size: 1.25rem !important;
      /* Perbesar tombol */
    }
  }

  /* Responsif untuk layar kecil */
  @media (max-width: 768px) {
    .swal2-popup {
      font-size: 0.875rem !important;
    }
  }

  .table-responsive {
    overflow-x: auto;
    margin-top: 20px;
    /* Menambahkan margin atas untuk estetika */
  }

  .table {
    border-collapse: collapse;
    width: 100%;
    /* Memastikan tabel mengisi ruang */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    /* Menambahkan bayangan pada tabel */
  }

  .table th,
  .table td {
    vertical-align: middle;
    padding: 15px;
    /* Menambahkan padding untuk ruang di dalam sel */
    text-align: center;
    /* Memastikan teks rata tengah */
    transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;
    /* Efek transisi yang lebih halus */
  }

  .table tr {
    transition: background-color 0.3s;
    /* Menambahkan transisi untuk baris */
  }

  .table tr:hover {
    background-color: #007bff;
    /* Warna latar belakang saat hover */
    color: white;
    /* Mengubah warna teks menjadi putih saat hover */
    transform: scale(1.02);
    /* Memberikan efek zoom sedikit saat hover */
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    /* Menambahkan bayangan saat hover */
  }

  .table th {
    background-color: rgb(55, 41, 251);
    /* Warna gelap untuk header */
    color: white;
    /* Warna teks header */
    font-weight: bold;
    text-transform: uppercase;
    /* Mengubah teks header menjadi huruf kapital */
  }

  /* Gaya untuk tabel striping */
  .table-striped tbody tr:nth-of-type(odd) {
    background-color: #f2f2f2;
    /* Warna striping */
  }

  .loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: transparent;
    /* Transparent background */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
  }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  // Hide loader after page load
  $(window).on('load', function() {
    $('.loader').addClass('hidden'); // Add hidden class to fade out
    setTimeout(() => {
      $('.loader').remove(); // Remove loader from DOM after fade out
    }, 500); // Match this time with the CSS transition duration
  });
</script>

<body>
  <!-- Loader -->
  <div class="loader" id="loader">
    <div class="spinner-border text-primary" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>
  @include('layouts.header')

  @include('layouts.sidebar')
  <main id="main" class="main">
    @yield('content')
  </main><!-- End #main -->

  @include('layouts.footer')

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>


  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
  <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
  <!-- Template Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>
  <!-- CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

  <!-- JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


  <script>
    function confirmDelete(partId) {
      Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data ini akan dihapus secara permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
        width: '50%', // Atur lebar
        showClass: {
          popup: 'animate__animated animate__fadeInDown' // Animasi saat muncul
        },
        hideClass: {
          popup: 'animate__animated animate__fadeOutUp' // Animasi saat menghilang
        }
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('delete-form-' + partId).submit();
        }
      });
    }
  </script>
  <script>
    function confirmDelete(userId) {
      Swal.fire({
        title: 'Apakah kamu yakin?',
        text: "Data ini akan dihapus secara permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
        width: '50%', // Atur lebar
        showClass: {
          popup: 'animate__animated animate__jackInTheBox', // Animasi saat popup muncul
          icon: 'animate__animated animate__shakeY' // Animasi pada ikon peringatan
        },
        hideClass: {
          popup: 'animate__animated animate__fadeOutUp' // Animasi saat popup menghilang
        }
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('delete-form-' + userId).submit();
        }
      });
    }
  </script>

  <script>
    setInterval(function() {
      fetch('/keep-session-alive').then(response => {
        if (response.ok) {
          console.log('Session refreshed');
        }
      });
    }, 600000); // Refresh setiap 10 menit (600000 ms)
  </script>

  @yield('script')



</body>

</html>
