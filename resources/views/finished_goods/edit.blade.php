@extends('layouts.app')

@section('title', 'Update Finished Good')

@section('content')
    <div class="pagetitle">
        <h1>Update Finished Good</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('finished_goods.index') }}">Finished Goods</a></li>
                <li class="breadcrumb-item active">Update Finished Good</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Update Finished Good</h5>
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
                    action="{{ route('finished_goods.update', $finishedGood->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="col-md-6">
                        <label for="inventory_id" class="form-label">ID Inventory</label>
                        <input type="text" name="inventory_id" class="form-control @error('inventory_id') is-invalid @enderror"
                            id="inventory_id" value="{{ old('inventory_id', $finishedGood->inventory_id) }}">
                        @error('inventory_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="part_name" class="form-label">Part Name</label>
                        <input type="text" name="part_name" class="form-control @error('part_name') is-invalid @enderror"
                            id="part_name" value="{{ old('part_name', $finishedGood->part_name) }}">
                        @error('part_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="part_number" class="form-label">Part Number</label>
                        <input type="text" name="part_number" class="form-control @error('part_number') is-invalid @enderror"
                            id="part_number" value="{{ old('part_number', $finishedGood->part_number) }}">
                        @error('part_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="type_package" class="form-label">Type Package</label>
                        <input type="text" name="type_package" class="form-control @error('type_package') is-invalid @enderror"
                            id="type_package" value="{{ old('type_package', $finishedGood->type_package) }}">
                        @error('type_package')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="qty_package" class="form-label">Qty Package Pcs</label>
                        <input type="number" name="qty_package" class="form-control @error('qty_package') is-invalid @enderror"
                            id="qty_package" value="{{ old('qty_package', $finishedGood->qty_package) }}">
                        @error('qty_package')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="project" class="form-label">Project</label>
                        <input type="text" name="project" class="form-control @error('project') is-invalid @enderror"
                            id="project" value="{{ old('project', $finishedGood->project) }}">
                        @error('project')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="customer" class="form-label">Customer</label>
                        <select name="customer" class="form-control @error('customer') is-invalid @enderror" id="customer" required>
                            <option value="">Select Customer</option>
                            <option value="ADM-KAP" {{ old('customer', $finishedGood->customer) == 'ADM-KAP' ? 'selected' : '' }}>ADM-KAP</option>
                            <option value="ADM-KEP" {{ old('customer', $finishedGood->customer) == 'ADM-KEP' ? 'selected' : '' }}>ADM-KEP</option>
                            <option value="ADM-SAP" {{ old('customer', $finishedGood->customer) == 'ADM-SAP' ? 'selected' : '' }}>ADM-SAP</option>
                            <option value="ADM-SEP" {{ old('customer', $finishedGood->customer) == 'ADM-SEP' ? 'selected' : '' }}>ADM-SEP</option>
                            <option value="ADM-SPD" {{ old('customer', $finishedGood->customer) == 'ADM-SPD' ? 'selected' : '' }}>ADM-SPD</option>
                            <option value="ASMO-DMIA" {{ old('customer', $finishedGood->customer) == 'ASMO-DMIA' ? 'selected' : '' }}>ASMO-DMIA</option>
                            <option value="DENSO" {{ old('customer', $finishedGood->customer) == 'DENSO' ? 'selected' : '' }}>DENSO</option>
                            <option value="GMK" {{ old('customer', $finishedGood->customer) == 'GMK' ? 'selected' : '' }}>GMK</option>
                            <option value="HAC" {{ old('customer', $finishedGood->customer) == 'HAC' ? 'selected' : '' }}>HAC</option>
                            <option value="HINO" {{ old('customer', $finishedGood->customer) == 'HINO' ? 'selected' : '' }}>HINO</option>
                            <option value="HINO-SPD" {{ old('customer', $finishedGood->customer) == 'HINO-SPD' ? 'selected' : '' }}>HINO-SPD</option>
                            <option value="HMMI" {{ old('customer', $finishedGood->customer) == 'HMMI' ? 'selected' : '' }}>HMMI</option>
                            <option value="HPM" {{ old('customer', $finishedGood->customer) == 'HPM' ? 'selected' : '' }}>HPM</option>
                            <option value="HPM-SPD LOKAL" {{ old('customer', $finishedGood->customer) == 'HPM-SPD LOKAL' ? 'selected' : '' }}>HPM-SPD LOKAL</option>
                            <option value="IAMI" {{ old('customer', $finishedGood->customer) == 'IAMI' ? 'selected' : '' }}>IAMI</option>
                            <option value="IPI" {{ old('customer', $finishedGood->customer) == 'IPI' ? 'selected' : '' }}>IPI</option>
                            <option value="IRC" {{ old('customer', $finishedGood->customer) == 'IRC' ? 'selected' : '' }}>IRC</option>
                            <option value="KTB" {{ old('customer', $finishedGood->customer) == 'KTB' ? 'selected' : '' }}>KTB</option>
                            <option value="KTB-SPD" {{ old('customer', $finishedGood->customer) == 'KTB-SPD' ? 'selected' : '' }}>KTB-SPD</option>
                            <option value="MAH SING" {{ old('customer', $finishedGood->customer) == 'MAH SING' ? 'selected' : '' }}>MAH SING</option>
                            <option value="MMKI" {{ old('customer', $finishedGood->customer) == 'MMKI' ? 'selected' : '' }}>MMKI</option>
                            <option value="MMKI-SPD" {{ old('customer', $finishedGood->customer) == 'MMKI-SPD' ? 'selected' : '' }}>MMKI-SPD</option>
                            <option value="NAFUCO" {{ old('customer', $finishedGood->customer) == 'NAFUCO' ? 'selected' : '' }}>NAFUCO</option>
                            <option value="NAGASSE" {{ old('customer', $finishedGood->customer) == 'NAGASSE' ? 'selected' : '' }}>NAGASSE</option>
                            <option value="NISSEN" {{ old('customer', $finishedGood->customer) == 'NISSEN' ? 'selected' : '' }}>NISSEN</option>
                            <option value="PBI" {{ old('customer', $finishedGood->customer) == 'PBI' ? 'selected' : '' }}>PBI</option>
                            <option value="SIM" {{ old('customer', $finishedGood->customer) == 'SIM' ? 'selected' : '' }}>SIM</option>
                            <option value="SIM-SPD" {{ old('customer', $finishedGood->customer) == 'SIM-SPD' ? 'selected' : '' }}>SIM-SPD</option>
                            <option value="SMI" {{ old('customer', $finishedGood->customer) == 'SMI' ? 'selected' : '' }}>SMI</option>
                            <option value="TMMIN" {{ old('customer', $finishedGood->customer) == 'TMMIN' ? 'selected' : '' }}>TMMIN</option>
                            <option value="TMMIN-POQ" {{ old('customer', $finishedGood->customer) == 'TMMIN-POQ' ? 'selected' : '' }}>TMMIN-POQ</option>
                            <option value="TRID" {{ old('customer', $finishedGood->customer) == 'TRID' ? 'selected' : '' }}>TRID</option>
                            <option value="VALEO" {{ old('customer', $finishedGood->customer) == 'VALEO' ? 'selected' : '' }}>VALEO</option>
                            <option value="YMPI" {{ old('customer', $finishedGood->customer) == 'YMPI' ? 'selected' : '' }}>YMPI</option>
                        </select>
                        @error('customer')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="area_fg" class="form-label">Area FG</label>
                        <input type="text" name="area_fg" class="form-control @error('area_fg') is-invalid @enderror"
                            id="area_fg" value="{{ old('area_fg', $finishedGood->area_fg) }}">
                        @error('area_fg')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="satuan" class="form-label">Satuan</label>
                        <select name="satuan" class="form-control @error('satuan') is-invalid @enderror" id="satuan" required>
                            <option value="">Select Satuan</option>
                            <option value="pcs" {{ old('satuan', $finishedGood->satuan) == 'pcs' ? 'selected' : '' }}>Pcs</option>
                            <option value="kg" {{ old('satuan', $finishedGood->satuan) == 'kg' ? 'selected' : '' }}>Kg</option>
                            <option value="liter" {{ old('satuan', $finishedGood->satuan) == 'liter' ? 'selected' : '' }}>Liter</option>
                        </select>
                        @error('satuan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="stok_awal" class="form-label">Stok Awal</label>
                        <input type="number" name="stok_awal" class="form-control @error('stok_awal') is-invalid @enderror"
                            id="stok_awal" value="{{ old('stok_awal', $finishedGood->stok_awal) }}">
                        @error('stok_awal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">Update Finished Good</button>
                    </div>
                </form><!-- End Custom Styled Validation -->
            </div>
        </div>
    </section>
@endsection