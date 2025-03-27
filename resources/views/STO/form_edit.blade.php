@extends('layouts.user')

@section('contents')
  <div class="container">
    <div class="card mt-4 shadow-lg">
      <div class="card-body p-4">
        <h5><strong>PT Kyoraku Blowmolding Indonesia</strong></h5>
        <p class="text-sm"><strong>PPIC Department / Warehouse Section<strong></p>
        <div class="text-center">
          <h5>Inventory Card</h5>
        </div>
        <hr>
        <div class="mt-4">
          <form class="w-100" method="POST" action="{{ route('sto.update', $report->id) }}">
            @csrf
            @method('PUT')
            <!-- Part Name -->
            <div class="mb-3 row">
              <label for="part-name" class="col-md-3 col-form-label">Part Name</label>
              <div class="col-md-9">
                <input type="text" id="part-name" name="part_name" class="form-control" placeholder="Enter part name"
                  value="{{ old('part_name', $report->part_name ?? '') }}" readonly>
              </div>
            </div>

            <!-- Part Number -->
            <div class="mb-3 row">
              <label for="part-number" class="col-md-3 col-form-label">Part Number</label>
              <div class="col-md-9">
                <input type="text" id="part-number" name="part_number" class="form-control"
                  placeholder="Enter part number" value="{{ old('part_number', $report->part_number ?? '') }}" readonly>
              </div>
            </div>

            <!-- Inventory Code -->
            <div class="mb-3 row">
              <label for="inventory-code" class="col-md-3 col-form-label">
                <strog>Inventory Code</strog>
              </label>
              <div class="col-md-9">
                <input type="text" id="inventory-code" name="inventory_id" class="form-control"
                  placeholder="Enter inventory code" value="{{ old('inventory_id', $report->inventory_id ?? '') }}"
                  readonly>
              </div>
            </div>
            <!-- Category -->
            <div class="mb-3 row">
              <label for="category" class="col-md-3 col-form-label">Category</label>
              <div class="col-md-9">
                <select id="category" name="category" class="form-select">
                  <option value="Finished Good"
                    {{ old('category', $report->category ?? '') == 'Finished Good' ? 'selected' : '' }}>Finished Good
                  </option>
                  <option value="Wip" {{ old('category', $report->category ?? '') == 'Wip' ? 'selected' : '' }}>Wip
                  </option>
                  <option value="ChildPart"
                    {{ old('category', $report->category ?? '') == 'ChildPart' ? 'selected' : '' }}>ChildPart</option>
                  <option value="Package" {{ old('category', $report->category ?? '') == 'Package' ? 'selected' : '' }}>
                    Package</option>
                  <option value="Raw Material"
                    {{ old('category', $report->category ?? '') == 'Raw Material' ? 'selected' : '' }}>Raw Material
                  </option>
                </select>
              </div>
            </div>

            <!-- Status -->
            <div class="mb-3 row">
              <label for="status" class="col-md-3 col-form-label">Status</label>
              <div class="col-md-9">
                <select name="status" id="status" class="form-select">
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
                    const selected = (status === "{{ old('status', $inventory->status_product ?? '') }}") ? 'selected' : '';
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
            <div class="mb-3 p-3 border rounded">
              <h6 class="mb-3 text-center"><strong>QUANTITY INPUT</strong></h6>
              <div id="quantityInputs" class="row">
                <label for="qty_per_box" class="col-form-label text-white">WAJIB SINI</label>
                <div class="mb-3 col-md-3">
                  <label for="qty_per_box" class="col-form-label">Qty/Box</label>
                  <input type="number" id="qty_per_box" name="qty_per_box" class="form-control"
                    placeholder="Enter quantity per box" required
                    value="{{ old('qty_per_box', $report->qty_per_box ?? '') }}">
                </div>
                <div class="mb-3 col-md-3">
                  <label for="qty_box" class="col-form-label">Qty Box</label>
                  <input type="number" id="qty_box" name="qty_box" class="form-control" required
                    placeholder="Enter box quantity" value="{{ old('qty_box', $report->qty_box ?? '') }}">
                </div>
                <div class="mb-3 col-md-3">
                  <label for="total" class="col-form-label">Total</label>
                  <input type="number" id="total" name="total" class="form-control" placeholder="Total" readonly>
                </div>
                <div class="mb-3 col-md-3">
                  <label for="grand_total" class="col-form-label">Grand Total</label>
                  <input required type="number" id="grand_total" name="grand_total" class="form-control"
                    placeholder="Total" readonly>
                </div>
              </div>

              <!-- Second Value -->
              <div id="optionalQuantityInputs" class="row" style="display: none;">
                <label for="qty_per_box" class="col-form-label text-white">ITEM RECEH</label>
                <div class="mb-3 col-md-3">
                  <label for="qty_per_box" class="col-form-label">Qty/Box</label>
                  <input type="number" id="qty_per_box_2" name="qty_per_box_2" class="form-control"
                    placeholder="Enter quantity per box"
                    value="{{ old('qty_per_box_2', $report->qty_per_box_2 ?? '') }}">
                </div>
                <div class="mb-3 col-md-3">
                  <label for="qty_box" class="col-form-label">Qty Box</label>
                  <input type="number" id="qty_box_2" name="qty_box_2" class="form-control"
                    placeholder="Enter box quantity" value="{{ old('qty_box_2', $report->qty_box_2 ?? '') }}">
                </div>
                <div class="mb-3 col-md-3">
                  <label for="total" class="col-form-label">Total</label>
                  <input type="number" id="total_2" name="total_2" class="form-control" placeholder="Total"
                    value="{{ old('qty_per_box_2') }}" readonly>
                </div>
              </div>
              <button type="button" class="btn btn-primary toggle-btn" id="optionalInputButton"
                onclick="toggleOptionalQuantityInputs()">SHOW INCOMPLETE ITEM (ITEM RECEH)</button>

            </div>

            <div class="d-flex row">
              <!-- Issued Date -->
              <div class="mb-3 col-md-3">
                <label for="issued_date" class="col-form-label">Issued Date</label>
                <input required type="date" id="issued_date" name="issued_date" class="form-control"
                  value="{{ old('issued_date', $report->issued_date->format('Y-m-d') ?? date('Y-m-d')) }}" readonly>
              </div>

              <!-- Prepared By -->
              <div class="mb-3 col-md-3">
                <label for="prepared_by_name" class="col-form-label">Prepared By</label>
                <input hidden type="text" id="prepared_by" name="prepared_by" class="form-control"
                  value="{{ $report->prepared_by }}">
                <input readonly type="text" id="prepared_by_name" name="prepared_by_name" class="form-control"
                  placeholder="Enter name" value="{{ $report->user->username }}">
              </div>

              <!-- Plant -->
              <div class="col-md-3 mb-3">
                <label for="plant" class="col-form-label">Plan</label>
                <select class="form-control" id="plant" name="plant" required>
                  <option value="Plan 1" {{ old('plant', $report->plant ?? '') == 'Plan 1' ? 'selected' : '' }}>Plan
                    1</option>
                  <option value="Plan 2" {{ old('plant', $report->plant ?? '') == 'Plan 2' ? 'selected' : '' }}>Plan
                    2</option>
                </select>
              </div>

              <div class="mb-3 col-md-3">
                <label for="detail_lokasi" class="col-form-label">Detail Lokasi</label>
                <select id="detail_lokasi" name="detail_lokasi" class="form-select">
                  @foreach ($detail_lokasi->groupBy('category') as $category => $locations)
                    <optgroup label="{{ $category }}" data-plan="{{ $locations->first()->plan }}">
                      @foreach ($locations as $lokasi)
                        <option value="{{ $lokasi->name }}"
                          {{ old('detail_lokasi', $report->detail_lokasi ?? '') == $lokasi->name ? 'selected' : '' }}>
                          {{ $lokasi->label }}
                        </option>
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
  </div>
@endsection

@section('script')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


  <script>
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

    // Filter detail lokasi
    $(document).ready(function() {
      $('#plant').change(function() {
        var selectedPlan = $(this).val();
        var category = $('#category').val();
        $('#detail_lokasi optgroup').each(function() {
          console.log(!categoryMapping[category].includes($(this).attr('label')));
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
      var selectedLokasi = $('#detail_lokasi').val();
      $('#plant').trigger('change');
      $('#detail_lokasi').val(selectedLokasi);
    });

    document.addEventListener("DOMContentLoaded", function() {
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

      calculateTotals();
    });

    function toggleQuantityInputs() {
      var quantityInputs = document.getElementById('quantityInputs');
      if (quantityInputs.style.display === 'none') {
        quantityInputs.style.display = 'block';
      } else {
        quantityInputs.style.display = 'none';
      }
    }

    function toggleOptionalQuantityInputs() {
      var optionalInputButton = document.getElementById('optionalInputButton')
      var optionalQuantityInputs = document.getElementById('optionalQuantityInputs');
      if (optionalQuantityInputs.style.display === 'none') {
        optionalQuantityInputs.style.display = 'flex';
        optionalInputButton.innerText = "HIDE INCOMPLETE ITEM (ITEM RECEH)";
      } else {
        optionalQuantityInputs.style.display = 'none';
        optionalInputButton.innerText = "SHOW INCOMPLETE ITEM (ITEM RECEH)";
      }
    }
  </script>
@endsection

<style>
  .toggle-btn {
    width: 100%;
    margin-bottom: 10px;
  }
</style>
