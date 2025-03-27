@extends('layouts.user')

@section('contents')
  @if (session('report'))
    <div class="container mt-3">
      <div id="downloadContainer" class="alert alert-success alert-dismissible fade show" role="alert">
        <a href="{{ route('reports.print', session('report')->id) }}" class="text-black text-decoration-underline">
          Print PDF
        </a>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    </div>
  @endif
  {{-- Main Content --}}

  <div class="container">
    <div class="card p-2 p-md-4 mt-4 shadow-lg">
      <!-- Form Packing -->
      <form action="{{ route('sto.scan') }}" method="POST" id="stoForm">
        @csrf
        <div class="mb-2">
          <label for="inventory_id" class="form-label" style="font-size: 1.1rem;">Inventory ID (Scan QR)</label>
          <div class="input-group my-2 my-md-3">
            <input type="text" name="inventory_id" class="form-control" id="inventory_id"
              placeholder="Masukkan ID Inventory" required autofocus>
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
      <div class="text-center">
        <button class="btn btn-link mt-2 text-white" type="button" id="showFormBtn">
          ID Inventory Kosong? Klik disini
        </button>
      </div>
    </div>

    <div id="stoFormCard" class="card mt-4 shadow-lg" style="display: none;">
      <div class="card-body p-4">
        <h5>PT Kyouraku Blowmoslding Indonesia</h5>
        <p class="text-sm">PPIC Department / Warehouse Section</p>
        <div class="text-center">
          <h3>Inventory Card </h3>
          <h5>JIKA TIDAK ADA ID INVENTORY INPUT SINI!!!</h5>
        </div>
        <hr>
        <div class="mt-4">
          <form class="w-100" method="POST" action="{{ route('sto.storeNew') }}">
            @csrf
            <!-- Part Name -->
            <div class="mb-3 row">
              <label for="part-name" class="col-md-3 col-form-label">Part Name</label>
              <div class="col-md-9">
                <input type="text" id="part-name" name="part_name" class="form-control" placeholder="Enter part name"
                  value="{{ old('part_name') }}">
              </div>
            </div>

            <!-- Part Number -->
            <div class="mb-3 row">
              <label for="part-number" class="col-md-3 col-form-label">Part Number</label>
              <div class="col-md-9">
                <input type="text" id="part-number" name="part_number" class="form-control"
                  placeholder="Enter part number" value="{{ old('part_number') }}">
              </div>
            </div>

            <!-- Inventory Code -->
            <div class="mb-3 row">
              <label for="inventory-code" class="col-md-3 col-form-label">Inventory Code</label>
              <div class="col-md-9">
                <input type="text" id="inventory-code" name="inventory_code" class="form-control"
                  placeholder="Enter inventory code" value="{{ old('inventory_code') }}">
              </div>
            </div>

            <!-- Category -->
            <div class="mb-3 row">
              <label for="category" class="col-md-3 col-form-label">Category</label>
              <div class="col-md-9">
                <select id="category" name="category" class="form-select">
                  <option value="Finished Good"
                    {{ old('category', $inventory->status_product ?? '') == 'Finished Good' ? 'selected' : '' }}>Finished
                    Good</option>
                  <option value="Wip"
                    {{ old('category', $inventory->status_product ?? '') == 'Wip' ? 'selected' : '' }}>Wip</option>
                  <option value="ChildPart"
                    {{ old('category', $inventory->status_product ?? '') == 'ChildPart' ? 'selected' : '' }}>ChildPart
                  </option>
                  <option value="Package"
                    {{ old('category', $inventory->status_product ?? '') == 'Package' ? 'selected' : '' }}>Package
                  </option>
                  <option value="Raw Material"
                    {{ old('category', $inventory->status_product ?? '') == 'Raw Material' ? 'selected' : '' }}>Raw
                    Material</option>
                </select>
              </div>
            </div>

            <!-- Status (Dropdown) -->
            <div class="mb-3 row">
              <label for="status" class="col-md-3 col-form-label text-white">Status</label>
              <div class="col-md-9">
                <select id="status" name="status" class="form-select status-container">
                  <!-- Status options will be dynamically inserted here -->
                </select>
              </div>
            </div>

            <script>
              document.addEventListener('DOMContentLoaded', function() {
                function updateStatusOptions() {
                  const category = document.getElementById('category').value;
                  const statusContainer = document.getElementById('status');
                  statusContainer.innerHTML = ''; // Clear previous options

                  let options = [];

                  if (category === 'Finished Good' || category === 'Wip' || category === 'ChildPart' || category ===
                    'Package') {
                    options = ['OK', 'NG'];
                  } else if (category === 'Raw Material') {
                    options = ['VIRGIN', 'FUNGSAI', 'NG'];
                  }

                  options.forEach(status => {
                    const selected = (status === "{{ old('status', $inventory->status_product ?? '') }}") ? 'selected' :
                      '';
                    const option = `<option value="${status}" ${selected}>${status}</option>`;
                    statusContainer.insertAdjacentHTML('beforeend', option);
                  });
                }

                document.getElementById('category').addEventListener('change', updateStatusOptions);

                // Trigger change event to load initial status when the page loads
                updateStatusOptions();
              });
            </script>

            <!-- Qty Detail -->
            <div cs="mb-3 p-3 border rounded">
              <h6 class="mb-3 text-center">QUANTITY INPUT</h6>
              <label for="qty_per_box" class="col-form-label text-white">ITEM COMPLETE</label>
              <div class="row">
                <label for="qty_per_box" class="col-form-label text-danger"></label>
                <label for="qty_per_box" class="col-form-label"></label>
                <div class="mb-3 col-md-3">
                  <label for="qty_per_box" class="col-form-label">Qty/Box</label>
                  <input type="number" id="qty_per_box" name="qty_per_box" class="form-control"
                    placeholder="Enter quantity per box"
                    value="{{ old('qty_per_box', $inventory->qty_package ?? '') }}">
                </div>
                <div class="mb-3 col-md-3">
                  <label for="qty_box" class="col-form-label">Qty Box</label>
                  <input type="number" id="qty_box" name="qty_box" class="form-control"
                    placeholder="Enter box quantity">
                </div>
                <div class="mb-3 col-md-3">
                  <label for="total" class="col-form-label">Total</label>
                  <input type="number" id="total" name="total" class="form-control" placeholder="Total"
                    readonly>
                </div>
                <div class="mb-3 col-md-3">
                  <label for="grand_total" class="col-form-label">Grand Total</label>
                  <input required type="number" id="grand_total" name="grand_total" class="form-control"
                    placeholder="Total" readonly>
                </div>
              </div>
              <!-- Second Value -->
              <div class="row">
                <div id="optionalQuantityInputs" class="row" style="display: none;">
                  <label for="qty_per_box" class="col-form-label text-white">ITEM UNCOMPLETE</label>
                  <div class="mb-3 col-md-3">
                    <label for="qty_per_box" class="col-form-label">Qty/Box</label>
                    <input type="number" id="qty_per_box_2" name="qty_per_box_2" class="form-control"
                      placeholder="Enter quantity per box" value="{{ old('qty_per_box_2') }}">
                  </div>
                  <div class="mb-3 col-md-3">
                    <label for="qty_box" class="col-form-label">Qty Box</label>
                    <input type="number" id="qty_box_2" name="qty_box_2" class="form-control"
                      placeholder="Enter box quantity" value="{{ old('qty_box_2') }}">
                  </div>
                  <div class="mb-3 col-md-3">
                    <label for="total" class="col-form-label">Total</label>
                    <input type="number" id="total_2" name="total_2" class="form-control" placeholder="Total"
                      value="{{ old('qty_per_box_2') }}" readonly>
                  </div>
                </div>
              </div>
              <button type="button" class="btn btn-primary toggle-btn w-100" id="optionalInputButton"
                onclick="toggleOptionalQuantityInputs()">SHOW UNCOMPLETE ITEM</button>

              <script>
                function toggleOptionalQuantityInputs() {
                  var optionalInputButton = document.getElementById('optionalInputButton');
                  var optionalQuantityInputs = document.getElementById('optionalQuantityInputs');
                  if (optionalQuantityInputs.style.display === 'none') {
                    optionalQuantityInputs.style.display = 'flex';
                    optionalInputButton.innerText = 'HIDE INCOMPLETE ITEM';
                  } else {
                    optionalQuantityInputs.style.display = 'none';
                    optionalInputButton.innerText = 'SHOW UNCOMPLETE ITEM';
                  }
                }
              </script>
            </div>

            <div class="d-flex row">
              <!-- Issued Date -->
              <div class="mb-3 col-md-3">
                <label for="issued_date" class="col-form-label">Issued Date</label>
                <input required type="date" id="issued_date" name="issued_date" class="form-control"
                  value="{{ old('issued_date', date('Y-m-d')) }}" readonly>
              </div>

              <!-- Prepared By -->
              <div class="mb-3 col-md-3">
                <label for="prepared_by_name" class="col-form-label">Prepared By</label>
                <input hidden type="text" id="prepared_by" name="prepared_by" class="form-control"
                  value="{{ auth()->id() }}">
                <input readonly type="text" id="prepared_by_name" name="prepared_by_name" class="form-control"
                  placeholder="Enter name" value="{{ Auth::user()->username }}">
              </div>

              <!-- Plant -->
              <div class="col-md-3 mb-3">
                <label for="plant" class="col-form-label">Plan</label>
                <select class="form-control" id="plant" name="plant" required>
                  <option value="Plan 1" {{ old('plant', $inventory->plant ?? '') == 'Plan 1' ? 'selected' : '' }}>Plan
                    1</option>
                  <option value="Plan 2" {{ old('plant', $inventory->plant ?? '') == 'Plan 2' ? 'selected' : '' }}>Plan
                    2</option>
                </select>
              </div>

              {{-- Detail Lokasi --}}
              <div class="mb-3 col-md-3">
                <label for="detail_lokasi" class="col-form-label">Detail Lokasi</label>
                <select id="detail_lokasi" name="detail_lokasi" class="form-select">
                  @foreach ($detail_lokasi->groupBy('category') as $category => $locations)
                    <optgroup label="{{ $category }}" data-plan="{{ $locations->first()->plan }}">
                      @foreach ($locations as $lokasi)
                        <option value="{{ $lokasi->name }}">{{ $lokasi->label }}</option>
                      @endforeach
                    </optgroup>
                  @endforeach
                </select>
              </div>
            </div>

            <!-- Submit Button -->
            <div class="text-center">
              <button type="submit" class="btn btn-success w-100 rounded">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="card p-2 p-md-4 mt-4 shadow-lg">
      <!-- Form Search -->
      <form action="{{ route('sto.search') }}" method="GET" id="searchForm">
        <div class="mb-2">
          <label for="search_query" class="form-label" style="font-size: 1.1rem;">Cari Part Name Atau Number</label>
          <div class="input-group my-2 my-md-3">
            <input type="text" name="query" class="form-control" id="search_query"
              placeholder="Masukkan Part Name atau Part Number" required>
          </div>
          <button class="btn btn-primary btn-lg w-100 mt-2" type="submit" id="btnSubmit">Search</Search></button>
        </div>
      </form>
    </div>

    {{-- Edit STO --}}
    <div class="card p-2 p-md-4 mt-4 shadow-lg">
      <!-- Form Search Report -->
      <form action="{{ route('sto.edit') }}" method="GET" id="editForm">
        <div class="mb-2">
          <label for="id_report" class="form-label" style="font-size: 1.1rem;">Edit Report STO (Berdasarkan
            Number)</label>
          <div class="input-group my-2 my-md-3">
            <input type="text" placeholder="Enter Report Number" name="id_report" class="form-control"
              id="id_report" required>
          </div>
          <button class="btn btn-primary btn-lg w-100 mt-2" type="submit" id="btnSubmitEdit">Edit</Search></button>
        </div>
      </form>
    </div>
  </div>

  </div>
  </div>
  </div>

  @if (session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      Swal.fire({
        toast: true,
        position: "top-end",
        icon: "success",
        title: "{{ session('success') }}",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
      });
    </script>
  @endif
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
      // Extract up to 6 digits
      let digits = decodedText.match(/\d{1,6}/);
      digits = digits ? digits[0] : '';

      // Extract up to 3 letters
      let letters = decodedText.match(/[a-zA-Z]{1,4}/);
      letters = letters ? letters[0] : '';

      // Combine the digits and letters
      let limitedText = digits + letters;

      console.log(`Code matched: ${limitedText}`);
      // Set the scanned text to the input field
      document.getElementById('inventory_id').value = limitedText;
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

    // Show the new inventory form when the button is clicked
    document.getElementById('showFormBtn').addEventListener('click', function() {
      const formCard = document.getElementById('stoFormCard');
      if (formCard.style.display === 'none') {
        formCard.style.display = 'block';
      } else {
        formCard.style.display = 'none';
      }
    });

    document.addEventListener('DOMContentLoaded', function() {
      function calculateTotals() {
        let QtyPerBox2 = parseFloat(document.getElementById("qty_per_box_2").value) || 0;
        let QtyBox2 = parseFloat(document.getElementById("qty_box_2").value) || 0;
        let qtyPerBox = parseFloat(document.getElementById("qty_per_box").value) || 0;
        let qtyBox = parseFloat(document.getElementById("qty_box").value) || 0;

        // Calculate totals
        let Total2 = QtyPerBox2 * QtyBox2;
        let total = qtyPerBox * qtyBox;
        let grandTotal = Total2 + total;

        // Update the input fields
        document.getElementById("total_2").value = Total2;
        document.getElementById("total").value = total;
        document.getElementById("grand_total").value = grandTotal;
      }

      // Attach event listeners to inputs
      let inputs = document.querySelectorAll("#qty_per_box_2, #qty_box_2, #qty_per_box, #qty_box");
      inputs.forEach(input => {
        input.addEventListener("input", calculateTotals);
      });
      document.getElementById('loader').style.display = 'none';
    });

    const categoryMapping = {
      "Finished Good": [
        "Shutter FG Fin",
        "Finished Good Area",
        "Area Service Part",
        "Area Delivery",
        "QC Office Room",
        "Manufacture Office",
        "Cut Off Delivery",
        "Area Subcont FG",
        "FG Area",
        "Delivery Area",
        'FG Area NG Spoiler',
        'FG Injection Area',
        'FG Shutter',
        "Finishing Line"
      ],
      "Raw Material": [
        "Material Transit",
        "Material Moulding",
        "Area Crusher & Material Injection",
        'Material Warehouse',
        "Material Line Blowmolding"
      ],
      "ChildPart": [
        "Childpart Area",
        "Childpart Fin",
        "Childpart Rack",
        "Receiving Cpart & Temporary Area"
      ],
      "Packaging": [
        "Packaging Area",
        "Lantai-2",
        'Packaging WH',
        "DOJO Area"
      ],
      "Wip": [
        "Area Subcont WIP",
        "WIP Rak Daisha",
        "Qc Office Room",
        "WIP WH 2",
        "WIP Molding",
        "WIP Shutter Molding",
        "WIP Pianica",
        "WIP Lin Fin",
        "WIP Line Blowmolding",
        "WIP Shutter Spoiler",
        "WIP Sanding Area",
        "WIP Shutter",
        'WIP Inoac',
        "WIP Ducting WH"
      ]
    };

    $(document).ready(function() {
      document.getElementById('loader').style.display = 'none';
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

      $('#plant').change(function() {
        var selectedPlan = $(this).val();

        $('#detail_lokasi optgroup').each(function() {
          if ($(this).attr('data-plan') === selectedPlan) {
            $(this).show();
          } else {
            $(this).hide();
          }
          if (!categoryMapping[category].includes($(this).attr('label'))) {
            $(this).hide();
          }
        });

        // Reset the selected value if the selected option is hidden
        $('#detail_lokasi').val('');
      });

      // Trigger change event on page load if an option is pre-selected
      $('#plant').trigger('change');

      //Trigger Auto Download
      let downloadContainer = document.getElementById("downloadContainer");

      if (downloadContainer) {
        let downloadLink = downloadContainer.querySelector("a");

        if (downloadLink) {
          // Simulate a click on the download link
          downloadLink.click();
        }
      }
    });
  </script>
@endsection
