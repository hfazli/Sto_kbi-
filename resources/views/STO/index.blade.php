@extends('layouts.user')

@section('contents')
  <div class="container">
    <div class="card p-2 p-md-4 mt-4 shadow-lg">
      <!-- Form Packing -->
      <form action="{{ route('sto.scan') }}" method="POST" id="stoForm">
        @csrf
        <div class="mb-2">
          <label for="inventory_id" class="form-label" style="font-size: 1.1rem;">Inventory ID (Scan QR)</label>
          <div class="input-group my-2 my-md-3">
            <input type="text" name="inventory_id" class="form-control" id="inventory_id" required autofocus>
            <button class="btn btn-secondary" type="button" id="scanPart" onclick="toggleScanner()">
              <i class="bi bi-camera"></i>
            </button>
          </div>
          <button class="btn btn-primary btn-lg w-100 mt-2" type="submit" id="btnSubmit">Show</button>
        </div>
        <input type="hidden" name="action" value="show" id="actionField">
        <div class="camera-wrapper mt-3 d-flex flex-col justify-content-center">
          <div id="reader" style="display: none; max-width: 600px;"></div>
        </div>
      </form>
    </div>

    <div class="card p-2 p-md-4 mt-4 shadow-lg">
      <!-- Form Search -->
      <form action="{{ route('sto.search') }}" method="GET">
        <div class="mb-2">
          <label for="part_name_number" class="form-label" style="font-size: 1.1rem;">Part Name/Part Number</label>
          <input type="text" name="part_name_number" class="form-control" id="part_name_number" placeholder="Enter Part Name or Part Number">
        </div>
        <button class="btn btn-primary btn-lg w-100 mt-2" type="submit" id="btnSubmit">Search</button>
        <input type="hidden" name="action" value="search" id="actionField">
      </form>
    </div>
  </div>
@endsection

@section('script')
  <script>
    let html5QrcodeScanner = new Html5QrcodeScanner(
      "reader", {
        fps: 24,
        qrbox: {
          width: 250,
          height: 250
        }
      },
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

    function showLoading() {
      let submitButton = document.querySelector('#btnSubmit');
      submitButton.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Checking Inventory...`;
      submitButton.disabled = true;
    }

    function onScanFailure(error) {
      // console.log(`Code scan error: ${error}`);
    }

    function onScanSuccess(decodedText) {
      let match = decodedText.match(/^(\d+)[A-Za-z]/);
      let extractedNumber = match ? match[1] : decodedText;
      // Set the scanned text to the input field
      document.getElementById('inventory_id').value = extractedNumber;
      // Send the scanned ID card number to the server for validation
      document.getElementById('stoForm').submit();
      showLoading();
    }

    // Keep session alive setiap 10 menit
    let sessionAlive = true; // Kendalikan secara global
    setInterval(() => {
      if (!sessionAlive) return;
      fetch('/keep-session-alive').catch(() => sessionAlive = false);
    }, 10 * 60 * 1000);

    $(document).ready(function() {
      $('#category').on('change', function() {
        var category = $(this).val();
        var initialStatus = "{{ isset($report) ? $report->status : old('status ') }}";
        $.ajax({
          url: "{{ url('/get-status') }}/" + encodeURIComponent(category),
          type: 'GET',
          success: function(response) {
            var statusContainer = $('.status-container');
            statusContainer.empty(); // Clear previous options

            if (response.length > 0) {
              response.forEach(function(status) {
                var checked = (status === initialStatus) ? 'checked' : '';
                var radioInput = `
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="radio" name="status" id="${status}" value="${status}" ${checked}>
                                    <label class="form-check-label" for="${status}">${status}</label>
                                </div>
                            `;
                statusContainer.append(radioInput);
              });
            } else {
              statusContainer.append('<p>No status options available</p>');
            }
          }
        });
      });

      // Trigger change event to load initial status when the page loads
      $('#category').trigger('change');
    });
  </script>
@endsection