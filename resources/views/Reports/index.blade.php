@extends('layouts.app')

@section('title', 'Data Reports')

@section('content')
  <div class="pagetitle">
    <h1>FG Reports</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">FG Reports</li>
      </ol>
    </nav>
  </div>

  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <section class="section">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Reports List</h5>
        <div class="table-responsive">
          <a href="{{ route('reports.export') }}" class="btn btn-success mb-3">
            <i class="fas fa-file-excel"></i> Export Excel FG
          </a>
          <table class="table table-bordered text-center align-middle datatable">
            <thead class="thead-light">
              <tr>
                <th>No</th>
                <th>Part Name</th>
                <th>Part Number</th>
                <th>ID Inventory</th>
                <th>Status Product</th>
                <th>Qty Per Box</th>
                <th>Qty Box</th>
                <th>Total</th>
                <th>Grand Total</th>
                <th>STO Periode</th>
                <th>Detail Lokasi</th>
                <th>Customer</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($reports as $index => $report)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $report->inventory->part_name }}</td>
                  <td>{{ $report->inventory->part_number }}</td>
                  <td>{{ $report->inventory_id }}</td>
                  <td>{{ $report->status }}</td>
                  <td>{{ $report->qty_per_box }}</td>
                  <td>{{ $report->qty_box }}</td>
                  <td>{{ $report->total }}</td>
                  <td>{{ $report->grand_total }}</td>
                  <td>{{ $report->issued_date->format('F Y') }}</td>
                  <td>{{ $report->detail_lokasi }}</td>
                  <td>{{ $report->inventory->customer }}</td>
                  <td>
                    <div class="d-flex justify-content-center">
                      <a href="{{ route('reports.print', $report->id) }}" class="btn btn-warning me-2">
                        <i class="fas fa-print"></i> Print
                      </a>
                      <a href="{{ route('reports.edit', $report->id) }}" class="btn btn-primary me-2">
                        <i class="fas fa-edit"></i> Edit
                      </a>
                      <form action="{{ route('reports.destroy', $report->id) }}" method="POST"
                        id="delete-form-{{ $report->id }}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmDelete({{ $report->id }})" class="btn btn-danger">
                          <i class="bi bi-trash3"></i> Delete
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    function confirmDelete(id) {
      if (confirm('Are you sure you want to delete this item?')) {
        document.getElementById('delete-form-' + id).submit();
      }
    }

    function changeEntriesPerPage() {
      const entriesPerPage = document.getElementById('entriesPerPage').value;
      const url = new URL(window.location.href);
      if (entriesPerPage === 'all') {
        url.searchParams.delete('entries');
      } else {
        url.searchParams.set('entries', entriesPerPage);
      }
      window.location.href = url.toString();
    }
  </script>
@endsection