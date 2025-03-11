@extends('layouts.app')

@section('title', 'Update Inventory')

@section('content')
  <div class="pagetitle">
    <h1>Update Report</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Report STO</a></li>
        <li class="breadcrumb-item active">Update</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Update Report</h5>
        @if (session('success'))
          <div class="alert alert-success">
            {{ session('success') }}
          </div>
        @endif
        @if (session('error'))
          <div class="alert alert-danger">
            {{ session('error') }}
          </div>
        @endif
        <!-- Custom Styled Validation -->
        <form class="row g-3 needs-validation" novalidate enctype="multipart/form-data" method="POST"
          action="{{ route('reports.edit', $report->id) }}">
          @csrf
          @method('PUT')

          <!-- Part Name -->
          <div class="col-md-6">
            <label for="part-name" class="form-label">Part Name</label>
            <input type="text" id="part-name" name="part_name"
              class="form-control @error('part_name') is-invalid @enderror" placeholder="Enter part name"
              value="{{ old('part_name', $report->inventory->part_name ?? '') }}">
            @error('part_name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Part Number -->
          <div class="col-md-6">
            <label for="part-number" class="form-label">Part Number</label>
            <input type="text" id="part-number" name="part_number"
              class="form-control @error('part_number') is-invalid @enderror" placeholder="Enter part number"
              value="{{ old('part_number', $report->inventory->part_number ?? '') }}">
            @error('part_number')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Inventory Code and Status -->
          <div class="row">
            <div class="col-md-6">
              <label for="inventory-code" class="form-label">Inventory Code</label>
              <input required type="text" id="inventory-code" name="inventory_id"
                class="form-control @error('inventory_id') is-invalid @enderror" placeholder="Enter inventory code"
                value="{{ old('inventory_id', $report->inventory->inventory_id ?? '') }}">
              @error('inventory_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label for="status" class="form-label">Status</label>
              <select name="status" id="status" class="form-select">
                <option value="NG" {{ old('status', $inventory->status_product ?? '') == 'NG' ? 'selected' : '' }}>NG</option>
                <option value="OK" {{ old('status', $inventory->status_product ?? '') == 'OK' ? 'selected' : '' }}>OK</option>
                <option value="FG" {{ old('status', $inventory->status_product ?? '') == 'FG' ? 'selected' : '' }}>FG</option>
                <option value="WIP" {{ old('status', $inventory->status_product ?? '') == 'WIP' ? 'selected' : '' }}>WIP</option>
                <option value="GOOD" {{ old('status', $inventory->status_product ?? '') == 'GOOD' ? 'selected' : '' }}>GOOD</option>
                <option value="VIRGIN" {{ old('status', $inventory->status_product ?? '') == 'VIRGIN' ? 'selected' : '' }}>VIRGIN</option>
                <option value="FUNGSAI" {{ old('status', $inventory->status_product ?? '') == 'FUNGSAI' ? 'selected' : '' }}>FUNGSAI</option>
              </select>
            </div>
          </div>

          <!-- Quantity Details -->
          <div class="col-12 border rounded p-3">
            <h6 class="text-center">Quantity Details</h6>
            <div class="row">
              <div class="col-md-3">
                <label for="qty_per_box" class="form-label">Qty/Box</label>
                <input type="number" id="qty_per_box" name="qty_per_box" class="form-control" required
                  placeholder="Enter quantity per box" value="{{ old('qty_per_box', $report->qty_per_box ?? '') }}">
              </div>
              <div class="col-md-3">
                <label for="qty_box" class="form-label">Qty Box</label>
                <input type="number" id="qty_box" name="qty_box" class="form-control" required
                  value="{{ old('qty_box', $report->qty_box ?? '') }}">
              </div>
              <div class="col-md-3">
                <label for="total" class="form-label">Total</label>
                <input type="number" id="total" name="total" class="form-control"
                  value="{{ old('total', $report->total ?? '') }}" readonly>
              </div>
              <div class="col-md-3">
                <label for="grand_total" class="form-label">Grand Total</label>
                <input type="number" id="grand_total" name="grand_total" class="form-control" required
                  value="{{ old('grand_total', $report->grand_total ?? '') }}" readonly>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-3">
                <input type="number" id="qty_per_box_2" name="qty_per_box_2" class="form-control" 
                  placeholder="Enter quantity per box"
                  value="{{ old('qty_per_box_2', $report->qty_per_box_2 ?? '') }}">
              </div>
              <div class="col-md-3">
                <input type="number" id="qty_box_2" name="qty_box_2" class="form-control" 
                  value="{{ old('qty_box_2', $report->qty_box_2 ?? '') }}">
              </div>
              <div class="col-md-3">
                <input type="number" id="total_2" name="total_2" class="form-control"
                  value="{{ old('total_2', $report->total_2 ?? '') }}" readonly>
              </div>
            </div>
          </div>

          <!-- Issued Date -->
          <div class="col-md-4">
            <label for="issued_date" class="form-label">Issued Date</label>
            <input type="date" id="issued_date" name="issued_date" class="form-control" required
              value="{{ old('issued_date', $report->issued_date->format('Y-m-d')) }}">
          </div>

          <!-- Prepared By -->
          <div class="col-md-4">
            <label for="prepared_by_name" class="form-label">Prepared By</label>
            <input hidden type="text" id="prepared_by" name="prepared_by" class="form-control"
              value="{{ $report->prepared_by }}">
            <input readonly type="text" id="prepared_by_name" name="prepared_by_name" class="form-control"
              value="{{ $report->user->username ?? '' }}">
          </div>
          
          <!-- Detail Lokasi -->
          <div class="mb-3 col-md-4">
            <label for="detail_lokasi" class="col-form-label">Detail Lokasi</label>
            <select id="detail_lokasi" name="detail_lokasi" class="form-select">
              <optgroup label="Childpart Area">
                <option value="rak_a_a1_a25" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_a_a1_a25' ? 'selected' : '' }}>Area Rak A (A1-A25)</option>
                <option value="rak_a_a26_a52" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_a_a26_a52' ? 'selected' : '' }}>Area Rak A (A26-A52)</option>
                <option value="rak_b_b1_b25" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_b_b1_b25' ? 'selected' : '' }}>Area Rak B (B1-B25)</option>
                <option value="rak_b_b26_b54" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_b_b26_b54' ? 'selected' : '' }}>Area Rak B (B26-B54)</option>
                <option value="rak_c_c1_c25" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_c_c1_c25' ? 'selected' : '' }}>Area Rak C (C1-C25)</option>
                <option value="rak_c_c26_c50" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_c_c26_c50' ? 'selected' : '' }}>Area Rak C (C26-C50)</option>
                <option value="rak_d_d1_d25" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_d_d1_d25' ? 'selected' : '' }}>Area Rak D (D1-D25)</option>
                <option value="rak_d_d26_d50" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_d_d26_d50' ? 'selected' : '' }}>Area Rak D (D26-D50)</option>
                <option value="rak_e_e1_e25" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_e_e1_e25' ? 'selected' : '' }}>Area Rak E (E1-E25)</option>
                <option value="rak_e_e26_e50" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_e_e26_e50' ? 'selected' : '' }}>Area Rak E (E26-E50)</option>
                <option value="rak_f_f1_f25" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_f_f1_f25' ? 'selected' : '' }}>Area Rak F (F1-F25)</option>
                <option value="rak_f_f26_f50" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_f_f26_f50' ? 'selected' : '' }}>Area Rak F (F26-F50)</option>
              </optgroup>
              <optgroup label="Packaging Area">
                <option value="rak_packing" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_packing' ? 'selected' : '' }}>Area Packaging YPC</option>
                <option value="rak_packing" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_packing' ? 'selected' : '' }}>Area Packaging Carton Box WH(2)</option>
                <option value="rak_packing" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_packing' ? 'selected' : '' }}>Area Packaging Carton Box WH(3)</option>
              </optgroup>
              <optgroup label="Finished Good Area">
                <option value="rak_finished_good_01" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_finished_good' ? 'selected' : '' }}>Area Finished Good WH (11.1)</option>
                <option value="rak_finished_good_02" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_finished_good' ? 'selected' : '' }}>Area Finished Good WH (11.2)</option>
                <option value="rak_finished_good_03" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_finished_good' ? 'selected' : '' }}>Area Finished Good WH (11.3)</option>
                <option value="rak_finished_good_04" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_finished_good' ? 'selected' : '' }}>Area Shutter FG, Prep MMKI (12.1)</option>
                <option value="rak_finished_good_05" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_finished_good' ? 'selected' : '' }}>Area Shutter FG, Prep MMKI (12.2)</option>
              </optgroup>
              <optgroup label="Area Subcont">
                <option value="rak_subcont_wip" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_subcont' ? 'selected' : '' }}>Area Subcont FG</option>
                <option value="rak_subcont_wip" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_subcont' ? 'selected' : '' }}>Area Subcont WIP</option>
              </optgroup>
              <optgroup label="Area Delivery">
                <option value="rak_delivery" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_delivery' ? 'selected' : '' }}>Area Delivery</option>
              </optgroup>
              <optgroup label="Material Transit">
                <option value="rak_material" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'Material' ? 'selected' : '' }}>Area Material Transit</option>
                <option value="rak_material" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'Material' ? 'selected' : '' }}>Area Material Workshop</option>
              </optgroup>
              <optgroup label="Shutter FG Fin">
                <option value="rak_shutter_01" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_shutter_01' ? 'selected' : '' }}>Area Shutter FG Fin Line 1-23 (16.1)</option>
                <option value="rak_shutter_02" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_shutter_02' ? 'selected' : '' }}>Area Shutter FG Fin Line 1-23 (16.2)</option>
                <option value="rak_shutter_03" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_shutter_03' ? 'selected' : '' }}>Area Shutter FG Fin Line 1-23 (16.3)</option>
              </optgroup>
              <optgroup label="QC Office Room">
                <option value="rak_qc_wip" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_qc_wip' ? 'selected' : '' }}>Area WIP QC Office</option>
                <option value="rak_qc_fg" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_qc_fg' ? 'selected' : '' }}>Area FG QC Office</option>
              </optgroup>
              <optgroup label="Manufacture Office">
                <option value="rak_manufacture_FG" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_manufacture' ? 'selected' : '' }}>Area Office FG</option>
                <option value="rak_manufacture_WIP" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_manufacture' ? 'selected' : '' }}>Area Office WIP</option>
              </optgroup>
              <optgroup label="WIP Lin Fin">
                <option value="rak_wip_fin_01" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_wip_fin_01' ? 'selected' : '' }}>Area Produksi (Finishing) WIP</option>
              </optgroup>
              <optgroup label="Childpart Fin">
                <option value="rak_childpart_fin_01" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_childpart_fin_01' ? 'selected' : '' }}>Area Childpart Fin Line (1-10)</option>
                <option value="rak_childpart_fin_02" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_childpart_fin_02' ? 'selected' : '' }}>Area Childpart Fin Line (11-20)</option>
                <option value="rak_childpart_fin_01" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_childpart_fin_01' ? 'selected' : '' }}>Area Childpart Fin Line (21-30)</option>
              </optgroup>
              <optgroup label="WIP Shutter Molding">
                <option value="rak_wip_shutter_01" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_wip_shutter_01' ? 'selected' : '' }}>Area WIP Shutter Molding 1-30 (21.1)</option>
                <option value="rak_wip_shutter_02" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_wip_shutter_02' ? 'selected' : '' }}>Area WIP Shutter Molding 1-30 (21.2)</option>
                <option value="rak_wip_shutter_03" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_wip_shutter_03' ? 'selected' : '' }}>Area WIP Shutter Molding 32-59 (21.3)</option>
                <option value="rak_wip_shutter_04" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_wip_shutter_04' ? 'selected' : '' }}>Area WIP Shutter Molding 32-59 (21.4)</option>
              </optgroup>
              <optgroup label="WIP Pianica">
                <option value="rak_wip_pianica_01" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_wip_pianica_01' ? 'selected' : '' }}>Area WIP Pianica (23.1)</option>
                <option value="rak_wip_pianica_02" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_wip_pianica_02' ? 'selected' : '' }}>Area WIP Pianica (23.2)</option>
              </optgroup>
              <optgroup label="WIP WH 2">
                <option value="rak_wip_wh2_01" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_wip_wh2_01' ? 'selected' : '' }}>Area WIP WH 2 (24.1)</option>
                <option value="rak_wip_wh2_02" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_wip_wh2_02' ? 'selected' : '' }}>Area WIP WH 2 (24.2)</option>
              </optgroup>
              <optgroup label="WIP Molding">
                <option value="rak_wip_molding" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_wip_wh3_01' ? 'selected' : '' }}>Area WIP Molding</option>
              </optgroup>
              <optgroup label="Material Molding">
                <option value="rak_material_molding_01" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_material_molding' ? 'selected' : '' }}>Area Material Line Molding V</option>
                <option value="rak_material_molding_02" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_material_molding' ? 'selected' : '' }}>Area Material Line Molding F</option>
                <option value="rak_material_molding_03" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_material_molding' ? 'selected' : '' }}>Area Material Line Fungsai Mix</option>
              </optgroup>
              <optgroup label="WIP Rak Daisha">
                <option value="rak_wip_daisha_01" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_wip_daisha' ? 'selected' : '' }}>Area WIP Rak Daisha (27.1)</option>
                <option value="rak_wip_daisha_02" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_wip_daisha' ? 'selected' : '' }}>Area WIP Rak Daisha (27.2)</option>
              </optgroup>
              <optgroup label="Area Service Part">
                <option value="rak_service_part" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_service_part' ? 'selected' : '' }}>Area SPD</option>
              </optgroup>
              <optgroup label="Cut Off Delivery">
                <option value="rak_Off_Deliver" {{ old('detail_lokasi', $inventory->detail_lokasi ?? '') == 'rak_subcont' ? 'selected' : '' }}>Area Cut Off Delivery</option>
              </optgroup>
            </select>
          </div>
          
          <!-- Submit Button -->
          <div class="col-12">
            <button class="btn btn-primary w-100" type="submit">Submit</button>
          </div>
        </form>

      </div>
    </div>
  </section>
@endsection

@section('script')
  <script>
    function calculateTotals() {
      let qtyPerBox = parseFloat(document.getElementById("qty_per_box").value) || 0;
      let qtyBox = parseFloat(document.getElementById("qty_box").value) || 0;
      let qtyPerBox2 = parseFloat(document.getElementById("qty_per_box_2").value) || 0;
      let qtyBox2 = parseFloat(document.getElementById("qty_box_2").value) || 0;

      // Calculate totals
      let oldTotal = qtyPerBox2 * qtyBox2;
      let total = qtyPerBox * qtyBox;
      let grandTotal = oldTotal + total;

      // Update the input fields
      document.getElementById("total_2").value = oldTotal;
      document.getElementById("total").value = total;
      document.getElementById("grand_total").value = grandTotal;
    }

    // Attach event listeners to inputs
    let inputs = document.querySelectorAll("#qty_per_box_2, #qty_box_2, #qty_per_box, #qty_box");
    inputs.forEach(input => {
      input.addEventListener("input", calculateTotals);
    });
  </script>
@endsection