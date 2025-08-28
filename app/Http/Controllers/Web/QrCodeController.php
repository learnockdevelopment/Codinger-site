<?php

namespace App\Http\Controllers\Web;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\QrCode;
use App\Models\Accounting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QrCodeController extends Controller
{
    public function validateQrCode(Request $request)
    {
        Log::info('Starting QR code validation');

        $qrCode = $request->input('code');
        if (!$qrCode) {
            Log::error('QR code not provided in request');
            return response()->json([
                'valid' => false,
                'message' => 'QR code is required.'
            ], 400);
        }

        Log::info('QR code received', ['code' => $qrCode]);
        $qrCode = QrCode::where('code', $qrCode)->first();

        if ($qrCode) {
            Log::info('QR code found', ['qr_code_id' => $qrCode->id, 'is_used' => $qrCode->is_used]);
            if (!$qrCode->is_used) {
                return response()->json([
                    'valid' => true,
                    'message' => 'QR code is valid.',
                    'amount' => $qrCode->amount
                ]);
            } else {
                return response()->json([
                    'valid' => false,
                    'message' => 'QR code has already been used.'
                ], 400);
            }
        } else {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid QR code.'
            ], 400);
        }
    }

    public function useQrCode(Request $request)
    {
        $qrCodeValue = $request->input('code');
        Log::info('Attempting to use QR code', ['code' => $qrCodeValue]);

        $qrCode = QrCode::where('code', $qrCodeValue)->first();

        if (!$qrCode) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid QR code.'
            ], 400);
        }

        if ($qrCode->is_used) {
            return response()->json([
                'success' => false,
                'message' => 'QR code has already been used.'
            ], 400);
        }

        $userId = $request->user()->id;
        $qrCode->used_at = Carbon::now('Africa/Cairo');
        $qrCode->user_id = $userId;
        $qrCode->is_used = true;
        $qrCode->save();

        // Charge the user’s account with the amount specified in the QR code
        Accounting::create([
            'creator_id' => auth()->user()->id,
            'amount' => $qrCode->amount,  // Apply discount or benefit as a negative charge
            'user_id' => $userId,
            'type' => 'addiction',
            'description' => 'QR Code Applied: ' . $qrCode->code,  // Added QR code to the description
            'type_account' => Accounting::$asset,
            'store_type' => 'QRCode',
            'created_at' => time(),
        ]);

        return response()->json([
            'success' => true,
            'amount' => $qrCode->amount,
            'message' => 'QR code applied successfully.'
        ]);
    }
}
