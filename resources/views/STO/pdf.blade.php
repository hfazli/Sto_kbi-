<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventory PDF</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 15px;
      text-align: center;
      width: 400px;
      max-width: 400px;
      margin: 0, auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th,
    td {
      border: 1px solid black;
      padding: 10px;
      text-align: left;
    }

    .qr-code {
      margin: 20px 0;
    }

    .text-center {
      text-align: center;
    }
  </style>
</head>

<body>

  <h1>Inventory Details</h1>
  <p>Part Name: {{ $inventory->part_name }}</p>
  <p>Part Number: {{ $inventory->part_number }}</p>
  <p>Inventory Code: {{ $inventory->inventory_id }}</p>
  <p>Status: {{ $inventory->status_product }}</p>
  <p>Qty/Box: {{ $inventory->qty_package }}</p>
  <p>Qty Box: {{ $inventory->qty_box }}</p>
  <p>Total: {{ $inventory->total }}</p>
  <p>Grand Total: {{ $inventory->grand_total }}</p>

  <h2>STO PERIODE {{ strtoupper($report->issued_date->format('F Y')) }}</h2>

  <!-- QR Code -->
  <div class="qr-code">
    <img src="{{ $qrCodeBase64 }}" alt="QR Code">
    <p>{{ $report->inventory_id }}</p>
  </div>

  <!-- Table -->
  <table>
    <tbody>
      <tr>
        <td><b>DateTime</b></td>
        <td style="width: 0px">:</td>
        <td>{{ $report->created_at->format('d/m/Y H:i:s') }}</td>
      </tr>
      <tr>
        <td><b>INV ID</b></td>
        <td>:</td>
        <td>{{ $report->inventory_id }}</td>
      </tr>
      <tr>
        <td><b>PART NAME</b></td>
        <td>:</td>
        <td>{{ $report->inventory->part_name }}</td>
      </tr>
      <tr>
        <td><b>PART NO</b></td>
        <td>:</td>
        <td>{{ $report->inventory->part_number }}</td>
      </tr>
      <tr>
        <td><b>MASTER TYPE</b></td>
        <td>:</td>
        <td>{{ $report->inventory->status_product }}</td>
      </tr>
      <tr>
        <td><b>STO PERIODE</b></td>
        <td>:</td>
        <td>{{ $report->issued_date->format('F Y') }}</td>
      </tr>
      <tr>
        <td><b>PLANT</b></td>
        <td>:</td>
        <td>{{ $report->inventory->plant }}</td>
      </tr>
      <tr>
        <td><b>DETAIL LOKASI</b></td>
        <td>:</td>
        <td>{{ $report->detail_lokasi }}</td>
      </tr>
      <tr>
        <td><b>CUSTOMER</b></td>
        <td>:</td>
        <td>{{ $report->inventory->customer }}</td>
      </tr>
      <tr>
        <td><b>PIC</b></td>
        <td>:</td>
        <td>{{ $report->preparer->username }}</td>
      </tr>
      <tr>
        <td><b>ID Card</b></td>
        <td>:</td>
        <td>{{ $report->preparer->id_card_number }}</td> <!-- Updated to display ID card -->
      </tr>
      <tr>
        <td><b>TIPE</b></td>
        <td>:</td>
        <td>{{ $report->status }}</td>
      </tr>
      <tr>
        <td class="text-center"><b>STOCK AWAL</b></td>
        <td></td>
        <td class="text-center"><b>STO ACTUAL</b></td>
      </tr>
      <tr>
        <td>
          <h1 class="text-center">{{ $report->inventory->stok_awal }}</h1>
        </td>
        <td></td>
        <td class="text-center">
          <h1>{{ $report->grand_total }}</h1>
        </td>
      </tr>
    </tbody>
  </table>

</body>

</html>