@extends('layouts.user')

@section('contents')
<div class="container">
    <div class="card p-2 p-md-4 mt-4 shadow-lg">
        <!-- Form Packing -->
        <form action="{{ route('sto.scan') }}" method="POST" id="stoForm">
            @csrf
            <div class="mb-2">
                <label for="inventory_id" class="form-label" style="font-size: 1.1rem;">Inventory ID (Scan QR)</label>
                <div class="input-group my-2 my-md-3">
                    <input type="text" name="inventory_id" class="form-control" id="inventory_id" required autofocus>
                    <button class="btn btn-secondary" type="button" id="scanPart" onclick="toggleScanner()">
                        <i class="bi bi-camera"></i>
                    </button>
                </div>
                <button class="btn btn-primary btn-lg w-100 mt-2" type="submit" id="btnSubmit">Show</button>
            </div>
            <input type="hidden" name="action" value="show" id="actionField">
            <div class="camera-wrapper mt-3 d-flex flex-col justify-content-center">
                <div id="reader" style="display: none; max-width: 600px;"></div>
            </div>
        </form>
    </div>

    <div class="card p-2 p-md-4 mt-4 shadow-lg">
        <!-- Form Search -->
        <form action="{{ route('sto.search') }}" method="GET" id="searchForm">
            <div class="mb-2">
                <label for="search_query" class="form-label" style="font-size: 1.1rem;">Search Part Name or Number</label>
                <div class="input-group my-2 my-md-3">
                    <input type="text" name="search_query" class="form-control" id="search_query" required>
                    <button class="btn btn-primary" type="submit" id="searchButton">
                        <i class="bi bi-search"></i> Search
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script>
    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", {
            fps: 24,
            qrbox: {
                width: 250,
                height: 250
            }
        },
        false
    );

    function toggleScanner() {
        const reader = document.getElementById('reader');
        if (reader.style.display === 'none') {
            reader.style.display = 'block';
            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        } else {
            reader.style.display = 'none';
            html5QrcodeScanner.clear();
        }
    }

    function showLoading() {
        let submitButton = document.querySelector('#btnSubmit');
        submitButton.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Checking Inventory...`;
        submitButton.disabled = true;
    }

    function onScanFailure(error) {
        // console.log(`Code scan error: ${error}`);
    }

    function onScanSuccess(decodedText) {
        decodedText = decodedText.slice(0, 6);
        console.log(`Code matched: ${decodedText}`);
        // Set the scanned text to the input field
        document.getElementById('inventory_id').value = decodedText;
        // Send the scanned ID card number to the server for validation
        document.getElementById('stoForm').submit();
        showLoading();
    }

    // Keep session alive setiap 10 menit
    let sessionAlive = true; // Kendalikan secara global
    setInterval(() => {
        if (!sessionAlive) return;
        fetch('/keep-session-alive').catch(() => sessionAlive = false);
    }, 10 * 60 * 1000);
</script>
@endsection