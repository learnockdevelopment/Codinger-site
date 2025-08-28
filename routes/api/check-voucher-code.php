<?php
use App\Models\Voucher;
use Illuminate\Http\Request;

Route::post('/admin/financial/vouchers/check-code', function (Request $request) {
    $code = $request->input('code');
    $exists = Voucher::where('code', $code)->exists();

    return response()->json(['exists' => $exists]);
});
