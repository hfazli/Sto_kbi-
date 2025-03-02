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
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

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
    <!-- Main content here -->
    <section class="section dashboard">
      <div class="row">
        <!-- Left side columns -->
        <div class="col-12">
          <h5 class="card-title">Input Date & Customer</h5>
          <!-- Add your select elements here -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="dateInput">Select Month</label>
              {{-- <input type="date" id="dateInput" class="form-control"> --}}
              <select id="monthSelect" class="form-control">
                @for ($i = 0; $i < 12; $i++)
                  <option value="{{ now()->addMonths($i)->format('Y-m') }}">{{ now()->addMonths($i)->format('F Y') }}
                  </option>
                @endfor
              </select>
            </div>
            <div class="col-md-6">
              <label for="custSelect">Select Customer</label>
              <select id="custSelect" class="form-control">
                @foreach ($customers as $customer)
                  <option value="{{ $customer->username }}">{{ $customer->username }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <!-- Line Chart -->
          <div id="reportsChart"></div>
        </div>
      </div>

      <!-- STO Report Card -->
      <div class="card">
        <div class="card-body pb-0">
          <h5 class="card-title">STO Report</h5>
          <canvas id="reportSTOChart" style="min-height: 400px;" class=""></canvas>
        </div>
      </div>

      <!-- Inventory Report Card -->
      <div class="card">
        <div class="card-body pb-0">
          <h5 class="card-title">Report FG</h5>

          <!-- Form untuk Forecast -->
          <form id="forecastForm">
            <div class="row mb-3">
              <div class="col-md-4">
                <canvas id="trafficChart" style="min-height: 400px;" class="echart"></canvas>
              </div>
            </div>
        </div>

      </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
      let reportSTOChart;
      let reportFGChart;

      document.addEventListener("DOMContentLoaded", () => {
        // Initialize stoChart
        let ctxSTO = document.getElementById("reportSTOChart").getContext("2d");
        reportSTOChart = new Chart(ctxSTO, {
          type: "bar",
          data: {
            labels: [],
            datasets: [{
              label: "Total Inventory",
              backgroundColor: "rgba(75, 192, 192, 0.2)",
              borderColor: "rgb(0, 132, 255)",
              borderWidth: 1,
              data: []
            }]
          }
        });

        // Initialize fgChart
        let ctxFG = document.getElementById("trafficChart").getContext("2d");
        reportFGChart = new Chart(ctxFG, {
          type: "line",
          data: {
            labels: [],
            datasets: [{
              label: "Daily Stock FG",
              backgroundColor: "rgba(153, 102, 255, 0.2)",
              borderColor: "rgba(153, 102, 255, 1)",
              borderWidth: 1,
              data: []
            }]
          }
        });

        // Fetch data when the dropdown changes
        $("#monthSelect, #custSelect").on("change", function() {
          updateChart(reportSTOChart, "sto");
        });

        $("#fgMonthSelect, #fgCustSelect").on("change", function() {
          updateChart(reportFGChart, "fg");
        });

        // Trigger Chart for the first time
        updateChart(reportSTOChart, "sto");
        // updateChart(reportFGChart, "fg");

        function updateChart(chart, type) {
          let selectedMonth = type === "sto" ? $("#monthSelect").val() : $("#fgMonthSelect").val();
          let selectedCustomer = type === "sto" ? $("#custSelect").val() : $("#fgCustSelect").val();

          fetchReportData(selectedMonth, selectedCustomer, type, chart);
        }

        // Function to fetch data and update the charts
        function fetchReportData(month, cust, type, chart) {
          let url = type === "sto" ? "/fetch-report-sto" : "/fetch-report-fg";
          $.ajax({
            url: url,
            type: "GET",
            data: {
              month: month,
              customer: cust,
            },
            success: function(response) {
              updateChartData(chart, response);
            },
            error: function() {
              alert("Failed to fetch data.");
            }
          });
        }

        // Function to update the chart with new data
        function updateChartData(chart, data) {
          let labels = data.map(item => item.inventory.part_name);
          let values = data.map(item => item.total);
          // let labels = data.map(item => item.part_name);
          // let values = data.map(item => item.total);

          chart.data.labels = labels;
          chart.data.datasets[0].data = values;
          chart.update();
        }
      });

      $(document).ready(function() {
        $("#forecastForm").submit(function(event) {
          event.preventDefault();

          let selectedMonth = $("#fgMonthSelect").val();
          let selectedCustomer = $("#fgCustSelect").val();
          let forecastValue = $("#forecastInput").val();

          if (!forecastValue || forecastValue <= 0) {
            Swal.fire({
              icon: 'error',
              title: 'Invalid Input',
              text: 'Forecast must be a positive number!',
            });
            return;
          }

          $.ajax({
            url: "/save-forecast",
            type: "POST",
            data: {
              month: selectedMonth,
              customer: selectedCustomer,
              forecast: forecastValue,
              _token: "{{ csrf_token() }}"
            },
            success: function(response) {
              Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Forecast data has been saved!',
              });
              $("#forecastInput").val("");
            },
            error: function() {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to save forecast data.',
              });
            }
          });
        });
      });
    </script>
    <!-- Add Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" crossorigin="anonymous"></script>
  </main><!-- End #main -->

  <!-- End Main Content -->

  <!-- ======= Footer ======= -->
  @include('layouts.footer')
  <!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

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
