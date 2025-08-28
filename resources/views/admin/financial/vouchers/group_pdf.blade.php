<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voucher Details</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 20mm;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }

        h1 {
            text-align: center;
        }

        .voucher-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 30px;
        }

        .voucher-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .voucher-header h2 {
            font-size: 24px;
            color: #343a40;
            font-weight: bold;
        }

        .voucher-details {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .voucher-details th,
        .voucher-details td {
            padding: 12px;
            border: 1px solid #ddd;
            font-size: 16px;
            text-align: left;
        }

        .voucher-details th {
            background-color: #f0f0f0;
            color: #495057;
            width: 35%;
        }

        .voucher-details td {
            background-color: #ffffff;
        }

        .voucher-footer {
            margin-top: 40px;
            text-align: center;
            font-size: 18px;
            color: #6c757d;
        }

        .highlight {
            color: #007bff;
            font-weight: bold;
        }

        .instructions {
            margin-top: 40px;
            font-size: 16px;
            color: #495057;
            padding: 20px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .instructions h3 {
            font-size: 20px;
            color: #343a40;
        }

        .instructions p {
            margin-bottom: 10px;
        }

        /* Page Break */
        .page-break {
            page-break-before: always;
        }

    </style>
</head>

<body>
    @foreach ($vouchers as $voucher)
        <div class="voucher-container">
            <div class="voucher-header">
                <h2>Voucher {{ $voucher->code }}</h2>
                <p>Here are the details of the voucher:</p>
            </div>

            <table class="voucher-details">
                <tr>
                    <th>{{ trans('admin/main.code') }}</th>
                    <td>{{ $voucher->code }}</td>
                </tr>
                <tr>
                    <th>{{ trans('admin/main.amount') }}</th>
                    <td>{{ handlePrice($voucher->amount) }}</td>
                </tr>
            </table>
        </div>

        <!-- Instructions Section -->
        <div class="instructions">
            <h3>Instructions for Using the Voucher:</h3>
            <p>1. Visit our website and log in to your account.</p>
            <p>2. Go to the checkout page and enter the voucher code during the payment process.</p>
            <p>3. The voucher will automatically apply its amount to your total Balance.</p>
            <p>4. If the voucher is valid, you will see the amount reflected on your Balance.</p>
        </div>

        <div class="voucher-footer">
            <p>Thank you for using our service. If you have any questions, feel free to contact us.</p>
        </div>

        <!-- Page break after each voucher -->
        @if (!$loop->last) 
            <div class="page-break"></div>
        @endif
    @endforeach
</body>

</html>
