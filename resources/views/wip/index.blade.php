@extends('layouts.app')

@section('title', 'Data WIP')

@section('content')
    <style>
        form label {
            font-size: 1.1rem;
            color: #495057;
        }

        form select {
            border: 2px solid #6c757d;
            font-size: 1rem;
            padding: 0.5rem;
            border-radius: 5px;
        }

        button i {
            margin-right: 5px;
        }
    </style>
    <div class="pagetitle">
        <h1>WORK IN PROCESS</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">WIP</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            {{ session('error') }}
        </div>
    @endif
    @if (session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            {{ session('info') }}
        </div>
    @endif

    <!-- Blade Template with Edit Modal -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data WIP</h5>
                        <a href="{{ route('wip.create') }}" class="btn btn-primary mb-3">
                            <i class="fas fa-plus"></i> Create New WIP
                        </a>
                        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#importModal">
                           <i class="fas fa-file-excel"></i> Import Excel WIP
                        </button>
                        <form action="{{ route('wip.index') }}" method="GET" class="mb-3 d-flex align-items-center">
                            <label for="status" class="me-2 fw-bold">
                                <i class="bi bi-filter"></i> Filter Status:
                            </label>
                            <select name="status" id="status" class="form-select w-auto" onchange="this.form.submit()">
                                <option value="">Semua Status</option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </form>
                        @if (Auth::check() && Auth::user()->role == 'viewer')
                            <form action="{{ route('wip.index.viewer') }}" method="GET" class="mb-3 d-flex align-items-center">
                                <label for="status" class="me-2 fw-bold">
                                    <i class="bi bi-filter"></i> Filter Status:
                                </label>
                                <select name="status" id="status" class="form-select w-auto" onchange="this.form.submit()">
                                    <option value="">Semua Status</option>
                                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                            </form>
                        @endif

                        <!-- Table with stripped rows -->
                        <div class="table-responsive">
                            <table class="table table-bordered text-center align-middle datatable">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">ID Inventory</th>
                                        <th scope="col" class="text-center">Part Name</th>
                                        <th scope="col" class="text-center">Part Number</th>
                                        <th scope="col" class="text-center">Type Package</th>
                                        <th scope="col" class="text-center">Qty Package</th>
                                        <th scope="col" class="text-center">Project</th>
                                        <th scope="col" class="text-center">Customer</th>
                                        <th scope="col" class="text-center">Area WIP</th>
                                        <th scope="col" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($wips as $wips)
                                        <tr>
                                            <td class="text-center">{{ $wipItem->no }}</td>
                                            <td class="text-center">{{ $wipItem->inventory_id }}</td>
                                            <td class="text-center">{{ $wipItem->part_name }}</td>
                                            <td class="text-center">{{ $wipItem->part_number }}</td>
                                            <td class="text-center">{{ $wipItem->type_package }}</td>
                                            <td class="text-center">{{ $wipItem->qty_package }}</td>
                                            <td class="text-center">{{ $wipItem->project }}</td>
                                            <td class="text-center">{{ $wipItem->customer }}</td>
                                            <td class="text-center">{{ $wipItem->area_wip }}</td>
                                            <td class="text-center">
                                                <!-- Edit Button (All Data) -->
                                                <a class="btn btn-primary btn-sm ms-1 mt-1 shadow-sm" href="{{ route('wip.edit', ['id' => $wipItem->id]) }}">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>

                                                @if ($wipItem->status)
                                                    <button class="btn btn-success btn-sm ms-1 mt-1 shadow-sm" onclick="changeStatus({{ $wipItem->id }}, 0)" data-bs-toggle="tooltip" data-bs-placement="top" title="Klik untuk Aktifkan">
                                                        <i class="bi bi-check-circle"></i> Aktif
                                                    </button>
                                                @else
                                                    <button class="btn btn-danger btn-sm ms-1 mt-1 shadow-sm" onclick="changeStatus({{ $wipItem->id }}, 1)" data-bs-toggle="tooltip" data-bs-placement="top" title="Klik untuk Nonaktifkan">
                                                        <i class="bi bi-x-circle"></i> Nonaktif
                                                    </button>
                                                @endif

                                                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                                <script>
                                                    function changeStatus(wipItemId, status) {
                                                        // Konfirmasi menggunakan SweetAlert2
                                                        Swal.fire({
                                                            title: 'Apakah Anda yakin?',
                                                            text: status === 0 ? "Status akan diubah menjadi Nonaktif!" : "Status akan diubah menjadi Aktif!",
                                                            icon: 'warning',
                                                            showCancelButton: true,
                                                            confirmButtonColor: status === 1 ? '#d33' : '#28a745',
                                                            cancelButtonColor: '#6c757d',
                                                            confirmButtonText: 'Ya, Ubah',
                                                            cancelButtonText: 'Batal'
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                // Lakukan permintaan AJAX
                                                                fetch(`/wip/${wipItemId}/change-status`, {
                                                                        method: 'POST',
                                                                        headers: {
                                                                            'Content-Type': 'application/json',
                                                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                                        },
                                                                        body: JSON.stringify({
                                                                            status
                                                                        })
                                                                    })
                                                                    .then(response => response.json())
                                                                    .then(data => {
                                                                        if (data.success) {
                                                                            // Alert berhasil
                                                                            Swal.fire({
                                                                                title: 'Berhasil!',
                                                                                text: data.message,
                                                                                icon: 'success',
                                                                                confirmButtonColor: '#28a745',
                                                                                confirmButtonText: 'OK'
                                                                            }).then(() => {
                                                                                location.reload();
                                                                            });
                                                                        } else {
                                                                            // Alert gagal
                                                                            Swal.fire({
                                                                                title: 'Gagal!',
                                                                                text: data.message,
                                                                                icon: 'error',
                                                                                confirmButtonColor: '#d33',
                                                                                confirmButtonText: 'OK'
                                                                            });
                                                                        }
                                                                    })
                                                                    .catch(error => {
                                                                        Swal.fire({
                                                                            title: 'Error!',
                                                                            text: 'Terjadi kesalahan saat memproses permintaan.',
                                                                            icon: 'error',
                                                                            confirmButtonColor: '#d33',
                                                                            confirmButtonText: 'OK'
                                                                        });
                                                                        console.error('Error:', error);
                                                                    });
                                                            }
                                                        });
                                                    }
                                                </script>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- modal import excel --}}
        <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Import WIP from Excel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('wip.import') }}" method="POST" enctype="multipart/form-data"></form>
                            @csrf
                            <div class="mb-3">
                                <label for="file" class="form-label">Upload Excel File</label>
                                <input type="file" name="file" class="form-control" id="file" required accept=".xls,.xlsx">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Import</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- end --}}
    </section>
@endsection