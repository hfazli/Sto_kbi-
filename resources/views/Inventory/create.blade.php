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
                            <input type="text" class="form-control" id="inventory_id" name="inventory_id" value="{{ old('inventory_id') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="part_name" class="form-label">Part Name</label>
                            <input type="text" class="form-control" id="part_name" name="part_name" value="{{ old('part_name') }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="part_number" class="form-label">Part Number</label>
                            <input type="text" class="form-control" id="part_number" name="part_number" value="{{ old('part_number') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="type_package" class="form-label">Type Package</label>
                            <input type="text" class="form-control" id="type_package" name="type_package" value="{{ old('type_package') }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="qty_package" class="form-label">Qty Package Pcs</label>
                            <input type="number" class="form-control" id="qty_package" name="qty_package" value="{{ old('qty_package') }}" required>
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
                                <option value="ADM-KAP" {{ old('customer') == 'ADM-KAP' ? 'selected' : '' }}>ADM-KAP</option>
                                <option value="ADM-KEP" {{ old('customer') == 'ADM-KEP' ? 'selected' : '' }}>ADM-KEP</option>
                                <option value="ADM-SAP" {{ old('customer') == 'ADM-SAP' ? 'selected' : '' }}>ADM-SAP</option>
                                <option value="ADM-SEP" {{ old('customer') == 'ADM-SEP' ? 'selected' : '' }}>ADM-SEP</option>
                                <option value="ADM-SPD" {{ old('customer') == 'ADM-SPD' ? 'selected' : '' }}>ADM-SPD</option>
                                <option value="ASMO-DMIA" {{ old('customer') == 'ASMO-DMIA' ? 'selected' : '' }}>ASMO-DMIA</option>
                                <option value="DENSO" {{ old('customer') == 'DENSO' ? 'selected' : '' }}>DENSO</option>
                                <option value="GMK" {{ old('customer') == 'GMK' ? 'selected' : '' }}>GMK</option>
                                <option value="HAC" {{ old('customer') == 'HAC' ? 'selected' : '' }}>HAC</option>
                                <option value="HINO" {{ old('customer') == 'HINO' ? 'selected' : '' }}>HINO</option>
                                <option value="HINO-SPD" {{ old('customer') == 'HINO-SPD' ? 'selected' : '' }}>HINO-SPD</option>
                                <option value="HMMI" {{ old('customer') == 'HMMI' ? 'selected' : '' }}>HMMI</option>
                                <option value="HPM" {{ old('customer') == 'HPM' ? 'selected' : '' }}>HPM</option>
                                <option value="HPM-SPD LOKAL" {{ old('customer') == 'HPM-SPD LOKAL' ? 'selected' : '' }}>HPM-SPD LOKAL</option>
                                <option value="IAMI" {{ old('customer') == 'IAMI' ? 'selected' : '' }}>IAMI</option>
                                <option value="IPI" {{ old('customer') == 'IPI' ? 'selected' : '' }}>IPI</option>
                                <option value="IRC" {{ old('customer') == 'IRC' ? 'selected' : '' }}>IRC</option>
                                <option value="KTB" {{ old('customer') == 'KTB' ? 'selected' : '' }}>KTB</option>
                                <option value="KTB-SPD" {{ old('customer') == 'KTB-SPD' ? 'selected' : '' }}>KTB-SPD</option>
                                <option value="MAH SING" {{ old('customer') == 'MAH SING' ? 'selected' : '' }}>MAH SING</option>
                                <option value="MMKI" {{ old('customer') == 'MMKI' ? 'selected' : '' }}>MMKI</option>
                                <option value="MMKI-SPD" {{ old('customer') == 'MMKI-SPD' ? 'selected' : '' }}>MMKI-SPD</option>
                                <option value="NAFUCO" {{ old('customer') == 'NAFUCO' ? 'selected' : '' }}>NAFUCO</option>
                                <option value="NAGASSE" {{ old('customer') == 'NAGASSE' ? 'selected' : '' }}>NAGASSE</option>
                                <option value="NISSEN" {{ old('customer') == 'NISSEN' ? 'selected' : '' }}>NISSEN</option>
                                <option value="PBI" {{ old('customer') == 'PBI' ? 'selected' : '' }}>PBI</option>
                                <option value="SIM" {{ old('customer') == 'SIM' ? 'selected' : '' }}>SIM</option>
                                <option value="SIM-SPD" {{ old('customer') == 'SIM-SPD' ? 'selected' : '' }}>SIM-SPD</option>
                                <option value="SMI" {{ old('customer') == 'SMI' ? 'selected' : '' }}>SMI</option>
                                <option value="TMMIN" {{ old('customer') == 'TMMIN' ? 'selected' : '' }}>TMMIN</option>
                                <option value="TMMIN-POQ" {{ old('customer') == 'TMMIN-POQ' ? 'selected' : '' }}>TMMIN-POQ</option>
                                <option value="TRID" {{ old('customer') == 'TRID' ? 'selected' : '' }}>TRID</option>
                                <option value="VALEO" {{ old('customer') == 'VALEO' ? 'selected' : '' }}>VALEO</option>
                                <option value="YMPI" {{ old('customer') == 'YMPI' ? 'selected' : '' }}>YMPI</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="detail_lokasi" class="form-label">Detail Lokasi</label>
                            <input type="text" class="form-control" id="detail_lokasi" name="detail_lokasi" value="{{ old('detail_lokasi') }}">
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
                            <label for="stok_awal" class="form-label">Stok Awal</label>
                            <input type="number" name="stok_awal" class="form-control" id="stok_awal" value="{{ old('stok_awal') }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="plant" class="form-label">Plant</label>
                            <input type="text" class="form-control" id="plant" name="plant" value="{{ old('plant') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status_product" class="form-label">Status Product</label>
                            <select class="form-control" id="status_product" name="status_product" required>
                                <option value="">Select Status Product</option>
                                <option value="FG" {{ old('status_product') == 'FG' ? 'selected' : '' }}>FG</option>
                                <option value="WIP" {{ old('status_product') == 'WIP' ? 'selected' : '' }}>WIP</option>
                                <option value="CHILPART" {{ old('status_product') == 'CHILPART' ? 'selected' : '' }}>CHILPART</option>
                                <option value="RAW MATERIAL" {{ old('status_product') == 'RAW MATERIAL' ? 'selected' : '' }}>RAW MATERIAL</option>
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