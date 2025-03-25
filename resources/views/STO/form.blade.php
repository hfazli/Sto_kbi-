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
          <form class="w-100" method="POST" action="{{ route('sto.store', $inventory->inventory_id) }}">
            @csrf
            <!-- Part Name -->
            <div class="mb-3 row">
              <label for="part-name" class="col-md-3 col-form-label">Part Name</label>
              <div class="col-md-9">
                <input type="text" id="part-name" name="part_name" class="form-control" placeholder="Enter part name"
                  value="{{ old('part_name', $inventory->part_name ?? '') }}" readonly>
              </div>
            </div>

            <!-- Part Number -->
            <div class="mb-3 row">
              <label for="part-number" class="col-md-3 col-form-label">Part Number</label>
              <div class="col-md-9">
                <input type="text" id="part-number" name="part_number" class="form-control"
                  placeholder="Enter part number" value="{{ old('part_number', $inventory->part_number ?? '') }}"
                  readonly>
              </div>
            </div>

            <!-- Inventory Code -->
            <div class="mb-3 row">
              <label for="inventory-code" class="col-md-3 col-form-label">
                <strog>Inventory Code</strog>
              </label>
              <div class="col-md-9">
                <input required hidden type="text" id="inventory-code" name="id_inventory" class="form-control"
                  value="{{ old('id', $inventory->id ?? '') }}">
                <input required type="text" id="inventory-code" name="inventory_id" class="form-control"
                  placeholder="Enter inventory code" value="{{ old('inventory_id', $inventory->inventory_id ?? '') }}"
                  readonly>
              </div>
            </div>

            <!-- Category -->
            <div class="mb-3 row">
              <label for="category" class="col-md-3 col-form-label">Category</label>
              <div class="col-md-9">
                <input type="text" id="category" name="category" class="form-control" placeholder="Enter category"
                  value="{{ old('category', $inventory->status_product ?? '') }}"readonly>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="status" class="col-md-3 col-form-label text-white">Status</label>
              <div class="col-md-9">
                <select name="status" id="status" class="form-select">
                  <optgroup label="Status">
                    <option value="OK"
                      {{ old('status', $inventory->status_product ?? '') == 'OK' ? 'selected' : '' }}>OK</option>
                    <option value="NG"
                      {{ old('status', $inventory->status_product ?? '') == 'NG' ? 'selected' : '' }}>NG</option>
                    <option value="Virgin"
                      {{ old('status', $inventory->status_product ?? '') == 'Virgin' ? 'selected' : '' }}>Virgin</option>
                    <option value="Funsai"
                      {{ old('status', $inventory->status_product ?? '') == 'Funsai' ? 'selected' : '' }}>Funsai</option>
                  </optgroup>
                </select>
              </div>
            </div>

            <!-- Qty Detail -->
            <div class="mb-3 p-3 border rounded">
              <h6 class="mb-3 text-center"><strong>QUANTITY INPUT</strong></h6>
              <div id="quantityInputs" class="row">
                <label for="qty_per_box" class="col-form-label text-white">ITEMCOMPLETE</label>
                <div class="mb-3 col-md-3">
                  <label for="qty_per_box" class="col-form-label">Qty/Box</label>
                  <input type="number" id="qty_per_box" name="qty_per_box" class="form-control"
                    placeholder="Enter quantity per box" required
                    value="{{ old('qty_per_box', $inventory->qty_package ?? '') }}" readonly>
                </div>
                <div class="mb-3 col-md-3">
                  <label for="qty_box" class="col-form-label">Qty Box</label>
                  <input type="number" id="qty_box" name="qty_box" class="form-control" required
                    placeholder="Enter box quantity">
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
              <div class="row">
                <div id="optionalQuantityInputs" class="row" style="display: none;">
                  <label for="qty_per_box" class="col-form-label text-white">ITEM RECEH</label>
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
              <button type="button" class="btn btn-primary toggle-btn" id="optionalInputButton"
                onclick="toggleOptionalQuantityInputs()">SHOW UNCOMPLETE ITEM</button>
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
                        <option value="{{ $lokasi->name }}"
                          {{ old('detail_lokasi', $inventory->detail_lokasi) == $lokasi->name ? 'selected' : '' }}>
                          {{ $lokasi->label }}</option>
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
        "Area Warehouse",
        "Area Delivery",
        "QC Office Room",
        "Manufacture Office",
        "Cut Off Delivery",
        "Area Subcont"
      ],
      "Raw Material": [
        "Material Transit",
        "Material Moulding"
      ],
      "ChildPart": [
        "Childpart Area",
        "Childpart Fin",
        "Area ChildPartTrolly",
        "Area ChildPart Fin Line",
        "Area ChildPart Temporary"
      ],
      "Packaging": [
        "Packaging Area"
      ],
      "Wip": [
        "Area Subcont Wip",
        "WIP Rak Daisha",
        "Qc Office Room Wip",
        "WIP WH 2",
        "WIP Molding",
        "WIP Shutter Molding",
        "WIP Pianica"
      ]
    };

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
    });

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

    function toggleQuantityInputs() {
      var quantityInputs = document.getElementById('quantityInputs');
      if (quantityInputs.style.display === 'none') {
        quantityInputs.style.display = 'flex';
      } else {
        quantityInputs.style.display = 'none';
      }
    }

    function toggleOptionalQuantityInputs() {
      var optionalInputButton = document.getElementById('optionalInputButton');
      var optionalQuantityInputs = document.getElementById('optionalQuantityInputs');
      if (optionalQuantityInputs.style.display === 'none') {
        optionalQuantityInputs.style.display = 'flex';
        optionalInputButton.innerText = 'HIDE INCOMPLETE ITEM (ITEM RECEH)';
      } else {
        optionalQuantityInputs.style.display = 'none';
        optionalInputButton.innerText = 'SHOW INCOMPLETE ITEM (ITEM RECEH)';
      }
    }
  </script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      function updateStatusOptions() {
        const category = document.getElementById('category').value;
        const statusSelect = document.getElementById('status');
        const statusOptions = statusSelect.querySelectorAll('option');

        statusOptions.forEach(option => {
          option.style.display = 'block';
        });

        if (category === 'Finished Good' || category === 'Wip' || category === 'ChildPart' || category ===
          'Packaging') {
          statusOptions.forEach(option => {
            if (option.value !== 'OK' && option.value !== 'NG') {
              option.style.display = 'none';
            }
          });
        } else if (category === 'Raw Material') {
          statusOptions.forEach(option => {
            if (option.value !== 'Virgin' && option.value !== 'Funsai' && option.value !== 'NG') {
              option.style.display = 'none';
            }
          });
        }
      }

      // function updateDetailLokasiOptions() {
      //   const category = document.getElementById('category').value;
      //   const detailLokasiSelect = document.getElementById('detail_lokasi');
      //   const detailLokasiOptions = detailLokasiSelect.querySelectorAll('optgroup');

      //   detailLokasiOptions.forEach(optgroup => {
      //     optgroup.style.display = 'block';
      //   });

      //   if (category === 'Finished Good') {
      //     detailLokasiOptions.forEach(optgroup => {
      //       if (optgroup.label !== 'Shutter FG Fin' && optgroup.label !== 'Finished Good Area' && optgroup
      //         .label !== 'Area Service Part' && optgroup.label !== 'Area Warehouse' && optgroup.label !==
      //         'Area Delivery' && optgroup.label !== 'QC Office Room' && optgroup.label !== 'Manufacture Office' &&
      //         optgroup.label !== 'Cut Off Delivery' && optgroup.label !== 'Area Subcont') {
      //         optgroup.style.display = 'none';
      //       }
      //     });
      //   } else if (category === 'Raw Material') {
      //     detailLokasiOptions.forEach(optgroup => {
      //       if (optgroup.label !== 'Material Transit' && optgroup.label !== 'Material Moulding') {
      //         optgroup.style.display = 'none';
      //       }
      //     });
      //   } else if (category === 'ChildPart') {
      //     detailLokasiOptions.forEach(optgroup => {
      //       if (optgroup.label !== 'Childpart Area' && optgroup.label !== 'Childpart Fin' && optgroup.label !==
      //         'Area ChildPartTrolly' && optgroup.label !== 'Area ChildPart Fin Line' && optgroup.label !==
      //         'Area ChildPart Temporary') {
      //         optgroup.style.display = 'none';
      //       }
      //     });
      //   } else if (category === 'Packaging') {
      //     detailLokasiOptions.forEach(optgroup => {
      //       if (optgroup.label !== 'Packaging Area') {
      //         optgroup.style.display = 'none';
      //       }
      //     });
      //   } else if (category === 'Wip') {
      //     detailLokasiOptions.forEach(optgroup => {
      //       if (optgroup.label !== 'Area Subcont Wip' && optgroup.label !== 'WIP Rak Daisha' && optgroup.label !==
      //         'Qc Office Room Wip' && optgroup.label !== 'WIP WH 2' && optgroup.label !== 'WIP Molding' &&
      //         optgroup.label !== 'WIP Shutter Molding' && optgroup.label !== 'WIP Pianica') {
      //         optgroup.style.display = 'none';
      //       }
      //     });
      //   }
      // }

      // Trigger change event to load initial status and detail lokasi when the page loads
      updateStatusOptions();
      // updateDetailLokasiOptions();

      document.getElementById('category').addEventListener('input', function() {
        updateStatusOptions();
        // updateDetailLokasiOptions();
      });
    });
  </script>
@endsection

<style>
  .toggle-btn {
    width: 100%;
    margin-bottom: 10px;
  }
</style>
