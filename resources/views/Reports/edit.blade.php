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

          <!-- Inventory Code -->
          <div class="col-md-6">
            <label for="inventory-code" class="form-label">Inventory Code</label>
            <input required type="text" id="inventory-code" name="inventory_id"
              class="form-control @error('inventory_id') is-invalid @enderror" placeholder="Enter inventory code"
              value="{{ old('inventory_id', $report->inventory->inventory_id ?? '') }}">
            @error('inventory_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Status (Radio Buttons) -->
          <div class="col-md-6">
            <label class="form-label">Status</label>
            <div class="d-flex">
              @php
                $status = old('status', $report->inventory->status_product ?? '');
              @endphp
              <div class="form-check me-3">
                <input class="form-check-input" type="radio" name="status" id="ng" value="NG"
                  {{ $status == 'NG' ? 'checked' : '' }}>
                <label class="form-check-label" for="ng">NG</label>
              </div>
              <div class="form-check me-3">
                <input class="form-check-input" type="radio" name="status" id="wip" value="WIP"
                  {{ $status == 'WIP' ? 'checked' : '' }}>
                <label class="form-check-label" for="wip">WIP</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="fg" value="FG"
                  {{ $status == 'FG' ? 'checked' : '' }}>
                <label class="form-check-label" for="fg">FG</label>
              </div>
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
                <input type="number" id="qty_per_box_2" name="qty_per_box_2" class="form-control" required
                  placeholder="Enter quantity per box"
                  value="{{ old('qty_per_box_2', $report->qty_per_box_2 ?? '') }}">
              </div>
              <div class="col-md-3">
                <input type="number" id="qty_box_2" name="qty_box_2" class="form-control" required
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
              value="{{ $report->preparer->username }}">
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

    document.getElementById('checked_by_checkbox').addEventListener('change', function() {
      let input = document.getElementById('checker');
      let inputId = document.getElementById('checked_by');
      if (this.checked) {
        // Masih error, mengambil data admin yang login saat ini
        // console.log("{{ Auth::user() }}")
        // inputId.value = "{{ Auth::user()->id }}";
        // input.value = "{{ Auth::user()->username }}"; // Set the current user's username
      } else {
        input.value = ""; // Clear the field when unchecked
      }
    });
  </script>
@endsection