<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Api\Controller;
use App\Models\QrCode; // Assuming a model for QR codes
use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    public function use(Request $request, $qrCodeId)
    {
        // Log the incoming request for QR code access
        \Log::info('QR Code Access Requested', ['qrCodeId' => $qrCodeId, 'user' => apiAuth()]);

        // Find the QR code
        $qrCode = QrCode::find($qrCodeId);

        if (!$qrCode) {
            return apiResponse2(1, 'qr_code_not_found', trans('api.qrcode.not_found'));
        }

        // Log the details of the QR code access attempt
        \Log::info('QR Code details', ['qrCode' => $qrCode->toArray()]);

        // You can add further checks for access if needed (e.g., user verification, status check)
        if ($qrCode->status !== 'active') {
            return apiResponse2(1, 'qr_code_not_active', trans('api.qrcode.not_active'));
        }

        // Log the success of the access attempt
        \Log::info('QR Code Access Successful', ['qrCode' => $qrCode->code]);

        // You can return a response here if needed, for example, a success message
        return apiResponse2(0, 'success', trans('api.qrcode.access_successful'));
    }
}
