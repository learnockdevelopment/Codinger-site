<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group QR Codes</title>
    <style>
        @page {
            size: A4;
        }

        body {
            font-family: 'Poppins', Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #212529;
        }

        h1 {
            text-align: center;
            font-size: 2.5rem;
            color: #007bff;
            margin: 20px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        td {
            width: 48%; /* Each QR code will take up 48% of the row width */
            text-align: center;
            padding: 5px;
            vertical-align: top;
        }
table{
    border: 1px solid #dee2e6;
}
        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>

    @php
        $qrCodesPerRow = 2; // Number of QR codes per row
        $qrCodesPerPage = 10; // Number of QR codes per page (5 rows * 2 codes per row)
        $totalQrCodes = count($qrCodes);
        $pages = ceil($totalQrCodes / $qrCodesPerPage); // Calculate the total number of pages
    @endphp

    @for ($page = 0; $page < $pages; $page++)
        <div class="page-container">
            <table>
                @foreach ($qrCodes->slice($page * $qrCodesPerPage, $qrCodesPerPage) as $index => $qrCode)
                    @if ($index % $qrCodesPerRow == 0) 
                        <tr>
                    @endif
                    <td>
                        @include('admin.financial.qrcodes.pdf', ['qrCode' => $qrCode])
                    </td>
                    @if (($index + 1) % $qrCodesPerRow == 0 || $index == $qrCodesPerPage - 1) 
                        </tr>
                    @endif
                @endforeach
            </table>

            <!-- Page Break after each page -->
            @if ($page < $pages - 1)
                <div class="page-break"></div>
            @endif
        </div>
    @endfor

</body>

</html>
