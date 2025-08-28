<?php

namespace App\Http\Controllers\Web;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Accounting;

class VoucherController extends Controller
{
    public function validateVoucher(Request $request)
    {
        Log::info('Starting voucher validation');

        $voucherCode = $request->input('code');
        if (!$voucherCode) {
            Log::error('Voucher code not provided in request');
            return response()->json([
                'valid' => false,
                'message' => 'Voucher code is required.'
            ], 400);
        }

        Log::info('Voucher code received', ['code' => $voucherCode]);
        $voucher = Voucher::where('code', $voucherCode)->first();

        if ($voucher) {
            Log::info('Voucher found', ['voucher_id' => $voucher->id, 'is_used' => $voucher->is_used]);
            if (!$voucher->is_used) {
                return response()->json([
                    'valid' => true,
                    'message' => 'Voucher is valid.',
                    'amount' => $voucher->amount
                ]);
            } else {
                return response()->json([
                    'valid' => false,
                    'message' => 'Voucher has already been used.'
                ], 400);
            }
        } else {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid voucher code.'
            ], 400);
        }
    }

    public function useVoucher(Request $request)
    {
        $voucherCode = $request->input('code');
        Log::info('Attempting to use voucher', ['code' => $voucherCode]);

        $voucher = Voucher::where('code', $voucherCode)->first();

        if (!$voucher) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid voucher code.'
            ], 400);
        }

        if ($voucher->is_used) {
            return response()->json([
                'success' => false,
                'message' => 'Voucher has already been used.'
            ], 400);
        }

        $userId = $request->user()->id;
		$voucher->used_at = Carbon::now('Africa/Cairo');
        $voucher->user_id = $userId;
        $voucher->is_used = true;
        $voucher->save();

        // Charge the user’s account with the discount amount
        Accounting::create([
            'creator_id' => auth()->user()->id,
            'amount' => $voucher->amount,  // Apply discount as a negative charge
            'user_id' => $userId,
            'type' => 'addiction',
            'description' => 'Voucher Applied: ' . $voucher->code,  // Added voucher code to the description
            'type_account' => Accounting::$asset,
            'store_type' => 'Voucher',
            'created_at' => time(),
        ]);


        return response()->json([
            'success' => true,
            'amount' => $voucher->amount,
            'message' => 'Voucher applied successfully.'
        ]);
    }
}
