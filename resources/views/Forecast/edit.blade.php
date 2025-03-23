@extends('layouts.app')

@section('title', 'Update Forecast')

@section('content')
  <div class="pagetitle">
    <h1>Update Forecast</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('forecast.index') }}">Forecast</a></li>
        <li class="breadcrumb-item active">Update Forecast</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Update Forecast</h5>
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
          action="{{ route('forecast.update', $forecast->id) }}">
          @csrf
          @method('PUT')

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="inventory_id" class="form-label">ID Inventory</label>
              <select class="form-control" id="inventory_id" name="inventory_id" required>
                <option value="">Select Inventory ID</option>
                @foreach ($inventory as $item)
                  <option value="{{ $item->inventory_id }}"
                    {{ old('inventory_id', $forecast->inventory_id) == $item->inventory_id ? 'selected' : '' }}>
                    {{ $item->inventory_id }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label for="part_name" class="form-label">Part Name</label>
              <input type="text" class="form-control" id="part_name" name="part_name"
                value="{{ old('part_name', $forecast->part_name) }}" required readonly>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="part_number" class="form-label">Part Number</label>
              <input type="text" class="form-control" id="part_number" name="part_number"
                value="{{ old('part_number', $forecast->part_number) }}" required readonly>
            </div>
            <div class="col-md-6 mb-3">
              <label for="customer" class="form-label">Customer</label>
              <input type="text" class="form-control" id="customer" name="customer"
                value="{{ old('customer', $forecast->customer) }}" required readonly>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="forecast_qty" class="form-label">Forecast Quantity</label>
              <input type="number" name="forecast_qty" class="form-control" id="forecast_qty"
                value="{{ old('forecast_qty', $forecast->forecast_qty) }}" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="forecast_day" class="form-label">Forecast Day</label>
              <input type="number" name="forecast_day" class="form-control" id="forecast_day" step="0.5"
                value="{{ old('forecast_day', $forecast->forecast_day) }}" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="min_stok" class="form-label">Min Stok</label>
              <input type="number" name="min_stok" class="form-control" id="min_stok"
                value="{{ old('min_stok', $forecast->min_stok) }}" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="max_stok" class="form-label">Max Stok</label>
              <input type="number" name="max_stok" class="form-control" id="max_stok"
                value="{{ old('max_stok', $forecast->max_stok) }}" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="forecast_date" class="form-label">Forecast Date</label>
              <input type="date" name="forecast_date" class="form-control" id="forecast_date"
                value="{{ old('forecast_date', $forecast->forecast_date) }}" required>
            </div>
          </div>

          <div class="col-12">
            <button class="btn btn-primary w-100" type="submit">Update Forecast</button>
          </div>
        </form><!-- End Custom Styled Validation -->
      </div>
    </div>
  </section>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const inventoryData = @json($inventory);

      document.getElementById('inventory_id').addEventListener('change', function() {
        const selectedInventoryId = this.value;
        const selectedInventory = inventoryData.find(item => item.inventory_id === selectedInventoryId);

        if (selectedInventory) {
          document.getElementById('part_name').value = selectedInventory.part_name;
          document.getElementById('part_number').value = selectedInventory.part_number;
          document.getElementById('customer').value = selectedInventory
            .customer; // Assuming customer is part of inventory data
        } else {
          document.getElementById('part_name').value = '';
          document.getElementById('part_number').value = '';
          document.getElementById('customer').value = '';
        }
      });

      // Trigger change event to populate fields on page load
      document.getElementById('inventory_id').dispatchEvent(new Event('change'));
    });
  </script>
@endsection
