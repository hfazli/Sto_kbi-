@extends('layouts.app')

@section('title', 'Edit Price')

@section('content')
    <div class="pagetitle">
        <h1>Edit Price</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('price.index') }}">Price</a></li>
                <li class="breadcrumb-item active">Edit Price</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Edit Price Details</h5>

                <form action="{{ route('price.update', $price->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="inventory_id" class="form-label">ID Inventory</label>
                        <input type="text" name="inventory_id" id="inventory_id" class="form-control" value="{{ $price->inventory_id }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="part_name" class="form-label">Part Name</label>
                        <input type="text" name="part_name" id="part_name" class="form-control" value="{{ $price->part_name }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="part_number" class="form-label">Part No</label>
                        <input type="text" name="part_number" id="part_number" class="form-control" value="{{ $price->part_number }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="unit_price" class="form-label">Unit Price</label>
                        <input type="number" name="unit_price" id="unit_price" class="form-control" value="{{ $price->unit_price }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Price</button>
                    <a href="{{ route('price.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </section>
@endsection