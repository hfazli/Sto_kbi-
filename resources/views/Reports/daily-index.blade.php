@extends('layouts.app')

@section('title', 'Data Reports')

@section('content')
    <div class="pagetitle">
        <h1>Daily Reports</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Daily Reports</li>
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
                <div class="d-flex justify-content-between mb-3">
                    <a href="{{ route('reports.export') }}" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> Export Excel FG
                    </a>
                </div>
                <form action="{{ route('reports.index') }}" method="GET" class="mb-3 d-flex align-items-center">
                    <label for="statusFilter" class="me-2 fw-bold">
                        <i class="bi bi-filter"></i> Filter Category:
                    </label>
                    <select name="status" id="statusFilter" class="form-select w-auto" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="OK" {{ request('status') == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ request('status') == 'NG' ? 'selected' : '' }}>NG</option>
                        <option value="VIRGIN" {{ request('status') == 'NG' ? 'selected' : '' }}>VIRGIN</option>
                        <option value="FUNSAI" {{ request('status') == 'FUNSAI' ? 'selected' : '' }}>FUNSAI</option>
                    </select>
                </form>
                <div class="table-responsive">
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
                                <th>Prepared By</th>
                                <th>Date</th>
                                <th>Plant</th> <!-- Added Plant column -->
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reports as $index => $report)
                                @if (request('status') == '' || request('status') == $report->status)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $report->part_name ?? '' }}</td>
                                        <td>{{ $report->part_number ?? '' }}</td>
                                        <td>{{ $report->inventory_id }}</td>
                                        <td>{{ $report->status }}</td>
                                        <td>{{ $report->qty_per_box }}</td>
                                        <td>{{ $report->qty_box }}</td>
                                        <td>{{ $report->total }}</td>
                                        <td>{{ $report->grand_total }}</td>
                                        <td>{{ $report->issued_date->format('F Y') }}</td>
                                        <td>{{ $report->detail_lokasi }}</td>
                                        <td>{{ $report->inventory ? $report->inventory->customer : '' }}</td>
                                        <td>{{ $report->user ? $report->user->username : '' }}</td>
                                        <td>{{ $report->issued_date ? $report->issued_date->format('d-m-Y') : 'N/A' }}</td>
                                        <td>{{ $report->inventory ? $report->inventory->plant : 'N/A' }}</td>
                                        <!-- Displaying Plant from inventory -->
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('reports.print', $report->id) }}"
                                                    class="btn btn-warning me-2">
                                                    <i class="fas fa-print"></i> Print
                                                </a>
                                                <a href="{{ route('reports.edit', $report->id) }}"
                                                    class="btn btn-primary me-2">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('reports.destroy', $report->id) }}" method="POST"
                                                    id="delete-form-{{ $report->id }}" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="confirmDelete({{ $report->id }})"
                                                        class="btn btn-danger">
                                                        <i class="bi bi-trash3"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
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
