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

            <div class="mb-3 row">
              <label for="status" class="col-md-3 col-form-label text-white">Status</label>
              <div class="col-md-9">
                <select name="status" id="status" class="form-select">
                <optgroup label="Other">
                        <option value="OK" {{ old('status', $inventory->status_product ?? '') == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('status', $inventory->status_product ?? '') == 'NG' ? 'selected' : '' }}>NG</option>
                    </optgroup>
                    <optgroup label="Finished Good">
                        <option value="FG" {{ old('status', $inventory->status_product ?? '') == 'FG' ? 'selected' : '' }}>FG</option>
                        <option value="WIP" {{ old('status', $inventory->status_product ?? '') == 'WIP' ? 'selected' : '' }}>WIP</option>
                    </optgroup>
                    <optgroup label="Child Part">
                        <option value="GOOD" {{ old('status', $inventory->status_product ?? '') == 'GOOD' ? 'selected' : '' }}>GOOD</option>
                    </optgroup>
                    <optgroup label="Pakage">
                        <option value="GOOD" {{ old('status', $inventory->status_product ?? '') == 'GOOD' ? 'selected' : '' }}>GOOD</option>
                    </optgroup>
                    <optgroup label="Raw Material">
                        <option value="VIRGIN" {{ old('status', $inventory->status_product ?? '') == 'VIRGIN' ? 'selected' : '' }}>VIRGIN</option>
                        <option value="FUNGSAI" {{ old('status', $inventory->status_product ?? '') == 'FUNGSAI' ? 'selected' : '' }}>FUNGSAI</option>
                    </optgroup>
                </select>
              </div>
            </div>

            <!-- Qty Detail -->
            <div class="mb-3 p-3 border rounded">
              <h6 class="mb-3 text-center"><strong>QUANTITY INPUT</strong></h6>
              <div id="quantityInputs" class="row">
                <label for="qty_per_box" class="col-form-label text-white">WAJIB SINI</label>
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
                onclick="toggleOptionalQuantityInputs()">SHOW INCOMPLETE ITEM (ITEM RECEH)</button>

            </div>

            <div class="d-flex row">
              <!-- Issued Date -->
              <div class="mb-3 col-md-4">
                <label for="issued_date" class="col-form-label">Issued Date</label>
                <input required type="date" id="issued_date" name="issued_date" class="form-control"
                  value="{{ old('issued_date', date('Y-m-d')) }}" readonly>
              </div>

              <!-- Prepared By -->
              <div class="mb-3 col-md-4">
                <label for="prepared_by_name" class="col-form-label">Prepared By</label>
                <input hidden type="text" id="prepared_by" name="prepared_by" class="form-control"
                  value="{{ auth()->id() }}">
                <input readonly type="text" id="prepared_by_name" name="prepared_by_name" class="form-control"
                  placeholder="Enter name" value="{{ Auth::user()->username }}">
              </div>
              <div class="mb-3 col-md-4">
                <label for="detail_lokasi" class="col-form-label">Detail Lokasi</label>
                <select id="detail_lokasi" name="detail_lokasi" class="form-select">
                  <optgroup label="Childpart Area">
                    <option value="rak_a_a1_a25"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_a_a1_a25' ? 'selected' : '' }}>
                      Area Rak A (A1-A25)</option>
                    <option value="rak_a_a26_a52"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_a_a26_a52' ? 'selected' : '' }}>
                      Area Rak A (A26-A52)</option>
                    <option value="rak_b_b1_b25"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_b_b1_b25' ? 'selected' : '' }}>
                      Area Rak B (B1-B25)</option>
                    <option value="rak_b_b26_b54"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_b_b26_b54' ? 'selected' : '' }}>
                      Area Rak B (B26-B54)</option>
                    <option value="rak_c_c1_c25"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_c_c1_c25' ? 'selected' : '' }}>
                      Area Rak C (C1-C25)</option>
                    <option value="rak_c_c26_c50"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_c_c26_c50' ? 'selected' : '' }}>
                      Area Rak C (C26-C50)</option>
                    <option value="rak_d_d1_d25"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_d_d1_d25' ? 'selected' : '' }}>
                      Area Rak D (D1-D25)</option>
                    <option value="rak_d_d26_d50"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_d_d26_d50' ? 'selected' : '' }}>
                      Area Rak D (D26-D50)</option>
                    <option value="rak_e_e1_e25"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_e_e1_e25' ? 'selected' : '' }}>
                      Area Rak E (E1-E25)</option>
                    <option value="rak_e_e26_e50"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_e_e26_e50' ? 'selected' : '' }}>
                      Area Rak E (E26-E50)</option>
                    <option value="rak_f_f1_f25"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_f_f1_f25' ? 'selected' : '' }}>
                      Area Rak F (F1-F25)</option>
                    <option value="rak_f_f26_f50"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_f_f26_f50' ? 'selected' : '' }}>
                      Area Rak F (F26-F50)</option>
                  </optgroup>
                  <optgroup label="Pakaging Area">
                    <option value="rak_packing"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_packing' ? 'selected' : '' }}>Area
                      Packanging YPC</option>
                    <option value="rak_packing"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_packing' ? 'selected' : '' }}>Area
                      Packanging Carton Box WH(2)</option>
                    <option value="rak_packing"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_packing' ? 'selected' : '' }}>Area
                      Packanging Carton Box WH(3)</option>
                  </optgroup>
                  <optgroup label="Finished Good Area">
                    <option value="rak_finished_good_01"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_finished_good' ? 'selected' : '' }}>
                      Area Finished Good WH (11.1)</option>
                    <option value="rak_finished_good_02"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_finished_good' ? 'selected' : '' }}>
                      Area Finished Good WH (11.2)</option>
                    <option value="rak_finished_good_03"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_finished_good' ? 'selected' : '' }}>
                      Area Finished Good WH (11.3)</option>
                    <option value="rak_finished_good_04"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_finished_good' ? 'selected' : '' }}>
                      Area Shutter FG, Prep MMKI (12.1)</option>
                    <option value="rak_finished_good_05"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_finished_good' ? 'selected' : '' }}>
                      Area Shutter FG, Prep MMKI (12.2)</option>
                  </optgroup>
                  <optgroup label="Area Subcont">
                    <option value="rak_subcont_wip"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_subcont' ? 'selected' : '' }}>Area
                      Subcont FG</option>
                    <option value="rak_subcont_wip"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_subcont' ? 'selected' : '' }}>Area
                      Subcont WIP</option>
                  </optgroup>
                  <optgroup label="Area Delivery">
                    <option value="rak_delivery"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_delivery' ? 'selected' : '' }}>
                      Area Delivery</option>
                  </optgroup>
                  <optgroup label="Material Transit">
                    <option value="rak_material"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'Material' ? 'selected' : '' }}>Area
                      Material Transit</option>
                    <option value="rak_material"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'Material' ? 'selected' : '' }}>Area
                      Matrial WorkShop</option>
                  </optgroup>
                  <optgroup label="Shutter FG Fin">
                    <option value="rak_shutter_01"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_shutter_01' ? 'selected' : '' }}>
                      Area Shutter FG Fin Line 1-23 (16.1)</option>
                    <option value="rak_shutter_02"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_shutter_02' ? 'selected' : '' }}>
                      Area Shutter FG Fin Line 1-23 (16.2)</option>
                    <option value="rak_shutter_03"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_shutter_03' ? 'selected' : '' }}>
                      Area Shutter FG Fin Line 1-23 (16.3)</option>
                  </optgroup>
                  <optgroup label="QC Office Room">
                    <option value="rak_qc_wip"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_qc_wip' ? 'selected' : '' }}>Area
                      WIP QC Office</option>
                    <option value="rak_qc_fg"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_qc_fg' ? 'selected' : '' }}>Area
                      FG QC Office</option>
                  </optgroup>
                  <optgroup label="Manufacture Office">
                    <option value="rak_manufacture_FG"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_manufacture' ? 'selected' : '' }}>
                      Area Office FG</option>
                    <option value="rak_manufacture_WIP"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_manufacture' ? 'selected' : '' }}>
                      Area Office WIP</option>
                  </optgroup>
                  <optgroup label="WIP Lin Fin">
                    <option value="rak_wip_fin_01"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_wip_fin_01' ? 'selected' : '' }}>
                      Area Produksi (Finishing) WIP</option>
                  </optgroup>
                  <optgroup label="Childpart Fin">
                    <option value="rak_childpart_fin_01"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_childpart_fin_01' ? 'selected' : '' }}>
                      Area Childpart Fin Line (1-10)</option>
                    <option value="rak_childpart_fin_02"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_childpart_fin_02' ? 'selected' : '' }}>
                      Area Childpart Fin Line (11-20)</option>
                    <option value="rak_childpart_fin_01"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_childpart_fin_01' ? 'selected' : '' }}>
                      Area Childpart Fin Line (21-30)</option>
                  </optgroup>
                  <optgroup label="WIP Shutter Molding">
                    <option value="rak_wip_shutter_01"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_wip_shutter_01' ? 'selected' : '' }}>
                      Area WIP Shutter Molding 1-30 (21.1)</option>
                    <option value="rak_wip_shutter_02"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_wip_shutter_02' ? 'selected' : '' }}>
                      Area WIP Shutter Molding 1-30 (21.2)</option>
                    <option value="rak_wip_shutter_03"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_wip_shutter_03' ? 'selected' : '' }}>
                      Area WIP Shutter Molding 32-59 (21.3)</option>
                    <option value="rak_wip_shutter_04"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_wip_shutter_04' ? 'selected' : '' }}>
                      Area WIP Shutter Molding 32-59 (21.4)</option>
                  </optgroup>
                  <optgroup label="WIP Pianica">
                    <option value="rak_wip_pianica_01"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_wip_pianica_01' ? 'selected' : '' }}>
                      Area WIP Pianca (23.1)</option>
                    <option value="rak_wip_pianica_02"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_wip_pianica_02' ? 'selected' : '' }}>
                      Area WIP Pianca (23.2)</option>
                  </optgroup>
                  <optgroup label="WIP WH 2">
                    <option value="rak_wip_wh2_01"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_wip_wh2_01' ? 'selected' : '' }}>
                      Area WIP WH 2 (24.1)</option>
                    <option value="rak_wip_wh2_02"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_wip_wh2_02' ? 'selected' : '' }}>
                      Area WIP WH 2 (24.2)</option>
                  </optgroup>
                  <optgroup label="WIP Molding">
                    <option value="rak_wip_molding"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_wip_wh3_01' ? 'selected' : '' }}>
                      Area WIP Molding</option>
                  </optgroup>
                  <optgroup label="Material Molding ">
                    <option value="rak_material_molding_01"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_material_molding' ? 'selected' : '' }}>
                      Area Material Line Molding V</option>
                    <option value="rak_material_molding_02"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_material_molding' ? 'selected' : '' }}>
                      Area Material Line Molding F</option>
                    <option value="rak_material_molding_03"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_material_molding' ? 'selected' : '' }}>
                      Area Material Line Fungsai Mix</option>
                  </optgroup>
                  <optgroup label="WIP Rak Daisha">
                    <option value="rak_wip_daisha_01"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_wip_daisha' ? 'selected' : '' }}>
                      Area WIP Rak Daisha (27.1)</option>
                    <option value="rak_wip_daisha_02"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_wip_daisha' ? 'selected' : '' }}>
                      Area WIP Rak Daisha (27.2)</option>
                  </optgroup>
                  <optgroup label="Area Service Part">
                    <option value="rak_service_part"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_service_part' ? 'selected' : '' }}>
                      Area SPD</option>
                  </optgroup>
                  <optgroup label="Cut Off Delivery">
                    <option value="rak_Off_Deliver"
                      {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_subcont' ? 'selected' : '' }}>Area
                      Cut Off Delivery</option>
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
@endsection

<style>
  .toggle-btn {
    width: 100%;
    margin-bottom: 10px;
  }
</style>
