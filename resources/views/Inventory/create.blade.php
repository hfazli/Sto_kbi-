@extends('layouts.app')

@section('title', 'Create Inventory')

@section('content')
  <div class="pagetitle">
    <h1>Create Inventory</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('inventory.index') }}">Inventory</a></li>
        <li class="breadcrumb-item active">Create Inventory</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Create Inventory</h5>

        <!-- Custom Styled Validation -->
        <form class="row g-3 needs-validation" novalidate enctype="multipart/form-data" method="POST"
          action="{{ route('inventory.store') }}">
          @csrf

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="inventory_id" class="form-label">ID Inventory</label>
              <input type="text" class="form-control" id="inventory_id" name="inventory_id"
                value="{{ old('inventory_id') }}" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="part_name" class="form-label">Part Name</label>
              <input type="text" class="form-control" id="part_name" name="part_name" value="{{ old('part_name') }}"
                required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="part_number" class="form-label">Part Number</label>
              <input type="text" class="form-control" id="part_number" name="part_number"
                value="{{ old('part_number') }}" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="type_package" class="form-label">Type Package</label>
              <input type="text" class="form-control" id="type_package" name="type_package"
                value="{{ old('type_package') }}" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="qty_package" class="form-label">Qty Package Pcs</label>
              <input type="number" class="form-control" id="qty_package" name="qty_package"
                value="{{ old('qty_package') }}" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="project" class="form-label">Project</label>
              <input type="text" class="form-control" id="project" name="project" value="{{ old('project') }}">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="customer" class="form-label">Customer</label>
              <select class="form-control" id="customer" name="customer" required>
                <option value="">Select Customer</option>
                @foreach ($customers as $customer)
                  <option value="{{ $customer->username }}"
                    {{ old('customer') == $customer->username ? 'selected' : '' }}>{{ $customer->username }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label for="status_product" class="form-label">Status Product</label>
              <select class="form-control" id="status_product" name="status_product" required>
                <option value="Finished Good" {{ request('status') == 'Finished Good' ? 'selected' : '' }}>Finished Good
                </option>
                <option value="Wip" {{ request('status') == 'Wip' ? 'selected' : '' }}>Wip</option>
                <option value="Packaging" {{ request('status') == 'Packaging' ? 'selected' : '' }}>Packaging</option>
                <option value="ChildPart" {{ request('status') == 'ChildPart' ? 'selected' : '' }}>ChildPart</option>
                <option value="Raw Material" {{ request('status') == 'Raw Material' ? 'selected' : '' }}>Raw Material
                </option>
              </select>
            </div>

          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="satuan" class="form-label">Unit</label>
              <select class="form-control" id="satuan" name="satuan" required>
                <option value="">Select Satuan</option>
                <option value="pcs" {{ old('satuan') == 'pcs' ? 'selected' : '' }}>Pcs</option>
                <option value="kg" {{ old('satuan') == 'kg' ? 'selected' : '' }}>Kg</option>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label for="stok_awal" class="form-label">Stok Plan</label>
              <input type="number" name="stok_awal" class="form-control" id="stok_awal"
                value="{{ old('stok_awal') }}" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="plant" class="form-label">Plan</label>
              <select class="form-control" id="plant" name="plant" required>
                <option value="">Select Plant</option>
                <option value="Plan 1" {{ old('plant') == 'Plant 1' ? 'selected' : '' }}>Plan 1</option>
                <option value="Plan 2" {{ old('plant') == 'Plant 2' ? 'selected' : '' }}>Plan 2</option>
              </select>
            </div>
            <div class="col-md-6 mb-3">
                @dd($detail_lokasi)
              <label for="detail_lokasi" class="form-label">Detail Lokasi</label>
              <select class="form-control" id="detail_lokasi" name="detail_lokasi" required>
                

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

          <div class="col-12">
            <button class="btn btn-primary" type="submit">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </section>
@endsection

@section('script')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#plant').change(function() {
        var selectedPlan = $(this).val();

        $('#detail_lokasi optgroup').each(function() {
          if ($(this).attr('data-plan') === selectedPlan) {
            $(this).show();
          } else {
            $(this).hide();
          }
        });

        // Reset the selected value if the selected option is hidden
        $('#detail_lokasi').val('');
      });

      // Trigger change event on page load if an option is pre-selected
      $('#plant').trigger('change');
    });
  </script>
@endsection
