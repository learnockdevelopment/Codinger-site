@push('styles_top')
    <style>
        .qrcode-details th,
        .qrcode-details td {
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
            font-size: 1rem;
            text-align: left;
        }

        .qrcode-details th {
            background-color: #f8f9fa;
            color: #495057;
            font-weight: 600;
        }

        .qrcode-details td {
            background-color: #ffffff;
        }

        .qrcode-image {
            text-align: center;
          position: relative;
        }

        .qrcode-image img {
            width: 50px;
            height: 50px;
            border: 2px solid #dee2e6;
            border-radius: 10px;
        }

    </style>
@endpush

<div>
    <table class="qrcode-details">
        <tr>
            <!-- QR Code Image -->
            <td rowspan="2" class="qrcode-image">
                <img src="data:image/png;base64,{{ $qrCodeBase64 ?? $qrCode->base64Image }}" alt="QR Code">
            </td>

            <td>{{ $qrCode->code }}</td>
        </tr>
      
        <tr>
            <td>Till {{ \Carbon\Carbon::parse($qrCode->expiration_date)->format('Y-m-d') }}</td>
        </tr>
    </table>
</div>
