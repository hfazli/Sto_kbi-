@extends('layouts.user')

@section('contents')
  <div class="container">
    <div class="card mt-4 shadow-lg">
      <div class="card-body p-4">
        <h5>PT Kyoraku Blowmolding Indonesia</h5>
        <p class="text-sm">PPIC Department / Warehouse Section</p>
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
                  placeholder="Enter part number" value="{{ old('part_number', $inventory->part_number ?? '') }}" readonly>
              </div>
            </div>

            <!-- Inventory Code -->
            <div class="mb-3 row">
              <label for="inventory-code" class="col-md-3 col-form-label">Inventory Code</label>
              <div class="col-md-9">
                <input required hidden type="text" id="inventory-code" name="id_inventory" class="form-control"
                  value="{{ old('id', $inventory->id ?? '') }}">
                <input required type="text" id="inventory-code" name="inventory_id" class="form-control"
                  placeholder="Enter inventory code" value="{{ old('inventory_id', $inventory->inventory_id ?? '') }}" readonly>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="status" class="col-md-3 col-form-label">Status</label>
              <div class="col-md-9">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="status" id="status_ng" value="NG" {{ old('status', $inventory->status_product ?? '') == 'NG' ? 'checked' : '' }} >
                  <label class="form-check-label" for="status_ng">NG</label>
                </div>
                <label class="col-form-label mt-2">Finished Good</label>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="status" id="status_wip" value="WIP" {{ old('status', $inventory->status_product ?? '') == 'WIP' ? 'checked' : '' }} >
                  <label class="form-check-label" for="status_wip">WIP</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="status" id="status_fg" value="FG" {{ old('status', $inventory->status_product ?? '') == 'FG' ? 'checked' : '' }} >
                  <label class="form-check-label" for="status_fg">FG</label>
                </div>
                <label class="col-form-label mt-2">Childpart</label>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="status" id="status_good" value="GOOD" {{ old('status', $inventory->status_product ?? '') == 'GOOD' ? 'checked' : '' }} >
                  <label class="form-check-label" for="status_good">GOOD</label>
                </div>
                <label class="col-form-label mt-2">Raw Material</label>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="status" id="status_virgin" value="VIRGIN" {{ old('status', $inventory->status_product ?? '') == 'VIRGIN' ? 'checked' : '' }} >
                  <label class="form-check-label" for="status_virgin">VIRGIN</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="status" id="status_fungsai" value="FUNGSAI" {{ old('status', $inventory->status_product ?? '') == 'FUNGSAI' ? 'checked' : '' }} >
                  <label class="form-check-label" for="status_fungsai">FUNGSAI</label>
                </div>
              </div>

            <!-- Qty Detail -->
            <div class="mb-3 p-3 border rounded">
              <h6 class="mb-3 text-center">DETAIL QUANTITY</h6>
              <div class="row">
                <label for="qty_per_box" class="col-form-label text-danger"></label>
                <label for="qty_per_box" class="col-form-label"></label>
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
                <label for="qty_per_box" class="col-form-label text-danger">ITEM RECEH JIKA ADA (OPTIONAL)</label>
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

            <div class="d-flex row">
              <!-- Issued Date -->
              <div class="mb-3 col-md-4">
                <label for="issued_date" class="col-form-label">Issued Date</label>
                <input required type="date" id="issued_date" name="issued_date" class="form-control"
                  value="{{ old('issued_date', date('Y-m-d')) }}"readonly>
              </div>

              <!-- Prepared By -->
              <div class="mb-3 col-md-4">
                <label for="prepared_by_name" class="col-form-label">Prepared By</label>
                <input hidden type="text" id="prepared_by" name="prepared_by" class="form-control"
                  value="{{ auth()->id() }}">
                <input readonly type="text" id="prepared_by_name" name="prepared_by_name" class="form-control"
                  placeholder="Enter name" value="{{ Auth::user()->username }}">
              </div>

              <!-- Detail Lokasi -->
              <div class="mb-3 col-md-4">
                <label for="detail_lokasi" class="col-form-label">Detail Lokasi</label>
                <input type="text" id="detail_lokasi" name="detail_lokasi" class="form-control"
                  placeholder="Enter detail location" value="{{ old('detail_lokasi') }}">
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
  </script>
@endsection