<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Dashboard - Admin</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/icon-kbi.png') }}" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

</head>

<body>

    <!-- Header -->
    @include('layouts.header')

    <!-- Sidebar -->
    @include('layouts.sidebar')

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <!-- Main content here -->
        <section class="section dashboard">
            <div class="row">
                <!-- Left side columns -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Input Date & Customer</h5>

                            <!-- Add your select elements here -->
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="dateInput">Select Date</label>
                                    <input type="date" id="dateInput" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label for="customerSelect">Select Customer</label>
                                    <select id="customerSelect" class="form-control">
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Line Chart -->
                            <div id="reportsChart"></div>
                        </div>
                    </div>

                    <!-- Inventory Report Card -->
                    <div class="card">
                        <div class="card-body pb-0">
                            <h5 class="card-title">Report Daily Stock FG</h5>
                            <div id="trafficChart" style="min-height: 400px;" class="echart"></div>
                        </div>
                    </div>
                    <!-- STO Report Card -->
                    <div class="card">
                        <div class="card-body pb-0">
                            <h5 class="card-title">STO Report</h5>
                            <div id="stoChart" style="min-height: 400px;" class="echart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const customerSelect = document.getElementById('customerSelect');

                // Initialize Select2 on the select elements
                $('#customerSelect').select2({
                    dropdownAutoWidth: true,
                    width: '100%',
                    theme: 'classic',
                });

                // Logout confirmation
                const logoutButton = document.getElementById('logoutButton');
                logoutButton.addEventListener('click', function(event) {
                    event.preventDefault(); // Prevent default action (navigation)

                    Swal.fire({
                        title: 'Are you sure you want to logout?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, logout!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Submit the logout form
                            document.getElementById('logoutForm').submit();
                        }
                    });
                });

                // Initialize trafficChart
                var trafficChart = echarts.init(document.querySelector("#trafficChart"));
                var trafficChartOptions = {
                    // Your chart options here
                };
                trafficChart.setOption(trafficChartOptions);

                // Initialize stoChart
                var stoChart = echarts.init(document.querySelector("#stoChart"));
                var stoChartOptions = {
                    title: {
                        text: 'STO Report'
                    },
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {
                            type: 'shadow'
                        }
                    },
                    legend: {
                        data: ['Part Name']
                    },
                    grid: {
                        left: '3%',
                        right: '4%',
                        bottom: '3%',
                        containLabel: true
                    },
                    xAxis: {
                        type: 'category',
                        data: {!! json_encode($partNames) !!} // Assuming you pass part names from the controller
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: [
                        {
                            name: 'Part Name',
                            type: 'bar',
                            data: {!! json_encode($partData) !!} // Assuming you pass part data from the controller
                        },
                        {
                            name: 'Minimum',
                            type: 'line',
                            data: {!! json_encode($minValues) !!}, // Assuming you pass minimum values from the controller
                            markLine: {
                                data: [
                                    { type: 'min', name: 'Min' }
                                ]
                            }
                        },
                        {
                            name: 'Maximum',
                            type: 'line',
                            data: {!! json_encode($maxValues) !!}, // Assuming you pass maximum values from the controller
                            markLine: {
                                data: [
                                    { type: 'max', name: 'Max' }
                                ]
                            }
                        }
                    ]
                };
                stoChart.setOption(stoChartOptions);
            });
        </script>
    </main><!-- End #main -->

    <!-- End Main Content -->

    <!-- ======= Footer ======= -->
    @include('layouts.footer')
    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
        });
    </script>
    @endif

</body>

</html>