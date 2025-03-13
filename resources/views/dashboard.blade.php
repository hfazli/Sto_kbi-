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
          <h5 class="card-title">Input Month & Customer</h5>
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
                <option value="all">All Customers</option>
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
          <div class="d-flex justify-content-between">
            <h5 class="card-title">STO Report</h5>
            <div class="dropdown">
              <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButtonSTO"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-three-dots"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButtonSTO">
                <li><a class="dropdown-item" href="#" id="downloadSTOChart">Download Chart</a></li>
              </ul>
            </div>
          </div>
          <canvas id="reportSTOChart" style="min-height: 400px;" class=""></canvas>
        </div>
      </div>

      <div class="row">
        <!-- Left side columns -->
        <div class="col-12">
          <h5 class="card-title">Input Date & Customer</h5>
          <!-- Add your select elements here -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="dateForecast">Select Date</label>
              {{-- <input type="date" id="dateInput" class="form-control"> --}}
              <select id="dateForecast" onchange="
              ()" class="form-control">
                @foreach ($dates as $date)
                  <option value="{{ $date }}">{{ $date->format('d M Y') }}
                  </option>
                @endforeach
                {{-- @for ($i = 0; $i < 12; $i++)
                  <option value="{{ now()->addMonths($i)->format('Y-m') }}">{{ now()->addMonths($i)->format('F Y') }}
                  </option>
                @endfor --}}
              </select>
            </div>
            <div class="col-md-6">
              <label for="custForecast">Select Customer</label>
              <select id="custForecast" class="form-control">
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

      <!-- Forecast Report Card -->
      <div class="card">
        <div class="card-body pb-0">
          <div class="d-flex justify-content-between">
            <h5 class="card-title">Daily Report</h5>
            <div class="dropdown">
              <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButtonForecast"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-three-dots"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButtonForecast">
                <li><a class="dropdown-item" href="#" id="downloadForecastChart">Download Chart</a></li>
              </ul>
            </div>
          </div>
          <canvas id="forecastChart" style="min-height: 300px;" class=""></canvas>
        </div>
      </div>

    </section>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
      let reportSTOChart;
      let forecastChart;

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

        // Initialize forecastChart
        let ctxForecast = document.getElementById("forecastChart").getContext("2d");
        const yAxisLabels = ['0', '0.5', '1', '1.5', '2', '2.5', '3', ">3"];

        forecastChart = new Chart(ctxForecast, {
          type: "bar",
          data: {
            labels: yAxisLabels, // Part names
            datasets: [{
              label: "Daily Report",
              backgroundColor: "rgba(75, 192, 192, 0.2)",
              borderColor: "rgba(75, 192, 192, 1)",
              borderWidth: 1,
              data: [] // Forecast quantities
            }]
          },
          options: {
            indexAxis: "y",
            scales: {
              x: {
                title: {
                  display: true,
                  text: "Stock Value" // X-axis label
                }
              },
              y: {
                title: {
                  display: true,
                  text: "Stock Day" // Y-axis label
                },
                ticks: {
                  callback: function(value) {
                    return value; // Ensure correct display of sorted labels
                  }
                }
              }
            }
          }
        });

        // Fetch data when the dropdown changes
        $("#monthSelect, #custSelect").on("change", function() {
          updateChart(reportSTOChart, "sto");
          // 
          // ();
        });

        $("#dateForecast, #custForecast").on("change", function() {
          updateForecastChart();
        });

        // Trigger Chart for the first time
        updateChart(reportSTOChart, "sto");
        updateForecastChart();

        function updateChart(chart, type) {
          let selectedMonth = $("#monthSelect").val();
          let selectedCustomer = $("#custSelect").val();

          fetchReportData(selectedMonth, selectedCustomer, type, chart);
        }

        function updateForecastChart() {
          let selectedDate = $("#dateForecast").val();
          let selectedCustomer = $("#custForecast").val();
          console.log("Update Forecast");
          fetchForecastData(selectedDate, selectedCustomer);
        }

        // Function to fetch data and update the charts
        function fetchReportData(month, cust, type, chart) {
          let url = "/fetch-report-sto";
          $.ajax({
            url: url,
            type: "GET",
            data: {
              month: month,
              customer: cust === "all" ? null : cust, // Handle "All Customers" case
            },
            success: function(response) {
              console.log(response);
              updateChartData(chart, response);
            },
            error: function() {
              alert("Failed to fetch data.");
            }
          });
        }

        // Function to fetch data and update the forecast chart
        function fetchForecastData(date, customer) {
          console.log("Fetch Forecast");

          $.ajax({
            url: "/fetch-forecast-summary",
            type: "GET",
            data: {
              date: date,
              customer: customer === "all" ? null : customer, // Handle "All Customers" case
            },
            success: function(response) {
              console.log(response);
              updateForecastChartData(forecastChart, response);
            },
            error: function() {
              alert("Failed to fetch forecast data.");
            }
          });
        }

        // Function to update the chart with new data
        function updateChartData(chart, data) {
          let labels = data.map(item => item.inventory?.part_name ?? item.customer);
          let values = data.map(item => item.total);

          chart.data.labels = labels;
          chart.data.datasets[0].data = values;
          chart.update();
        }

        // Function to update the forecast chart with new data
        function updateForecastChartData(chart, data) {
          // Define the correct Y-axis labels in the required order
          const yAxisLabels = ['3', '2,5', '2', '1,5', '1', '0,5', ">0"];

          // Initialize an array to store values in the correct order
          let orderedValues = new Array(yAxisLabels.length).fill(0); // Default to 0 or null
          let custName = '';
          let date = '';
          // Map data to correct Y-axis label positions
          data.forEach(item => {
            let index = yAxisLabels.indexOf(item.stock_day);
            custName = item.customer_name;
            date = new Date(item.date).toLocaleDateString("id-ID", {
              day: "numeric",
              month: "short",
              year: "numeric"
            });
            if (index !== -1) {
              orderedValues[index] = item.stock_value;
            }
          });


          // Keep the original Y-axis labels, only update the dataset
          chart.data.datasets[0].data = orderedValues;

          // Ensure the Y-axis uses the predefined labels
          chart.options.scales.y.ticks = {
            callback: function(value, index) {
              return yAxisLabels[index] ?? value; // Use predefined labels
            }
          };

          chart.options.plugins = {
            title: {
              display: true,
              text: `Daily Report${custName} - ${date}`, // Dynamic title
              font: {
                size: 16
              }
            }
          };

          chart.update(); // Only update once
        }




        // Download chart as image
        function downloadChart(chart, filename) {
          const link = document.createElement('a');
          link.href = chart.toBase64Image();
          link.download = filename;
          link.click();
        }

        // Event listeners for download buttons
        document.getElementById('downloadSTOChart').addEventListener('click', () => {
          downloadChart(reportSTOChart, 'sto_chart.png');
        });

        document.getElementById('downloadForecastChart').addEventListener('click', () => {
          downloadChart(forecastChart, 'forecast_chart.png');
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
