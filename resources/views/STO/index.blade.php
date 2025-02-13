<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Scan STO</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <!-- Favicons -->
    <link href="{{ asset('assets/img/icon-kbi.png') }}" rel="icon">
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/form.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/loader.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Card</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff700;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 90%;
            max-width: 800px;
            background: yellow;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
            border: 2px solid black;
            text-align: center;
            box-sizing: border-box;
        }

        .header-section,
        .footer-container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            font-weight: bold;
        }

        .header-section p,
        .footer-container p {
            margin: 5px;
        }

        .horizontal-line {
            width: 100%;
            border-top: 2px solid black;
            margin: 10px 0;
        }

        .form-group {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            text-align: left;
            margin-bottom: 10px;
        }

        .form-group label {
            font-weight: bold;
            margin-right: 10px;
            flex: 1;
        }

        .form-group input {
            padding: 5px;
            width: 100%;
            box-sizing: border-box;
            flex: 2;
            font-weight: bold;
            border: 2px solid black;
        }

        .status-product-container {
            display: flex;
            flex-direction: row;
            align-items: center;
            text-align: left;
            margin-bottom: 10px;
        }

        .status-product-container label {
            font-weight: bold;
            margin-right: 10px;
            flex: 1;
        }

        .status-product {
            display: flex;
            flex: 2;
            justify-content: space-between;
        }

        .status-product label {
            font-weight: bold;
        }

        .status-product strong {
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 2px solid black;
            padding: 8px;
            text-align: center;
            font-weight: bold;
        }

        th {
            background-color: #d3d3d3;
        }

        .footer-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-top: 20px;
        }

        .footer-container p {
            flex: 1;
            display: flex;
            align-items: center;
            border: 2px solid black;
            padding: 5px;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .footer-container input {
            margin-left: 10px;
            flex: 1;
            padding: 5px;
            box-sizing: border-box;
            width: 100%;
            font-weight: bold;
            border: 2px solid black;
        }

        input[name="qty_box"],
        input[name="qty_box_total"],
        input[name="total"],
        input[name="qty_box_2"],
        input[name="qty_box_total_2"],
        input[name="total_2"] {
            border: 2px solid black;
        }

        input[name="grand_total_combined"] {
            width: 100%;
            font-size: 1.8em;
            padding: 15px;
            text-align: center;
            background-color: #fff;
            border: 3px solid black;
            font-weight: bold;
            box-sizing: border-box;
        }

        @media (max-width: 600px) {
            .header-section,
            .footer-container {
                flex-direction: column;
                align-items: center;
            }

            .footer-container p {
                width: 100%;
                text-align: left;
            }
        }
    </style>
    <script>
        function calculateTotal() {
            var qtyBox1 = document.getElementsByName('qty_box')[0].value;
            var qtyBoxTotal1 = document.getElementsByName('qty_box_total')[0].value;
            var total1 = qtyBox1 * qtyBoxTotal1 || 0;
            document.getElementsByName('total')[0].value = total1;

            var qtyBox2 = document.getElementsByName('qty_box_2')[0].value;
            var qtyBoxTotal2 = document.getElementsByName('qty_box_total_2')[0].value;
            var total2 = qtyBox2 * qtyBoxTotal2 || 0;
            document.getElementsByName('total_2')[0].value = total2;

            document.getElementsByName('grand_total_combined')[0].value = total1 + total2;
        }

        document.addEventListener('input', calculateTotal);
    </script>
</head>

<body>
    <div class="container">
        <form>
            <div class="header-section">
                <div class="left">
                    <p>PT. KYORAKU BLOWMOLDING INDONESIA</p>
                    <p>PPIC DEPARTMENT / WAREHOUSE SECTION</p>
                </div>
                <div class="separator"></div>
                <div class="right">
                    <p>Card No: PR24-</p>
                </div>
            </div>
            <div class="horizontal-line"></div>
            <h2>INVENTORY CARD</h2>
            <div class="horizontal-line"></div>
            <div class="form-group">
                <label>PART NAME:</label>
                <input type="text" name="part_name">
            </div>
            <div class="form-group">
                <label>PART NUMBER:</label>
                <input type="text" name="part_number">
            </div>
            <div class="form-group">
                <label>INVENTORY CODE:</label>
                <input type="text" name="inventory_code">
            </div>
            <div class="status-product-container">
                <label><strong>STATUS PRODUCT:</strong></label>
                <div class="status-product">
                    <label><input type="radio" name="status_product" value="NG"> <strong>NG</strong></label>
                    <label><input type="radio" name="status_product" value="WIP"> <strong>WIP</strong></label>
                    <label><input type="radio" name="status_product" value="FINISH GOOD"> <strong>FG</strong></label>
                </div>
            </div>
            <table>
                <tr>
                    <th>QTY/BOX</th>
                    <th>QTY BOX</th>
                    <th>TOTAL</th>
                    <th>GRAND TOTAL</th>
                </tr>
                <tr>
                    <td><input type="text" name="qty_box"></td>
                    <td><input type="text" name="qty_box_total"></td>
                    <td><input type="text" name="total" readonly></td>
                    <td rowspan="2"><input type="text" name="grand_total_combined" readonly></td>
                </tr>
                <tr>
                    <td><input type="text" name="qty_box_2"></td>
                    <td><input type="text" name="qty_box_total_2"></td>
                    <td><input type="text" name="total_2" readonly></td>
                </tr>
            </table>
            <div class="footer-container">
                <p>Issued Date: <input type="date" name="issued_date"></p>
                <p>Prepared by: <input type="text" name="prepared_by"></p>
                <p>Checked by: <input type="text" name="checked_by"></p>
            </div>
        </form>
    </div>
</body>

</html>