<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Api\Controller;
use App\Models\QrCode; // Assuming a model for QR codes
use Illuminate\Http\Request;
use App\Models\Webinar;
use App\Models\Bundle;
use App\Models\Accounting;
use App\Models\Sale;
use App\User;

class QrCodeController extends Controller
{
  public function show(Request $request)
{
    $code = $request->input('code');
    // Log the start of the fetch process
    \Log::info('Fetching QR Code details', ['code' => $code]);

    // Find the QR code by its code
    $qrCode = QrCode::where('code', $code)->first();

    // Check if the QR code exists
    if (!$qrCode) {
        \Log::warning('QR Code not found', ['code' => $code]);
        return apiResponse2(1, 'qr_code_not_found', trans('api.qrcode.not_found'));
    }

    // Log the successful retrieval of the QR code
    \Log::info('QR Code found', ['qrCode' => $qrCode->toArray()]);

    // Return the QR code details in the response
    return apiResponse2(1, 'success', trans('api.qrcode.details_successful'), $qrCode);
}

   public function use(Request $request)
{
    // Log the beginning of the method
    \Log::info('QR Code Access - Start', ['request' => $request->all()]);

    $user_id = $request->input('user_id');
    $qrCodeCode = $request->input('code');
    $course_id = $request->input('course_id');
    $bundle_id = $request->input('bundle_id');
    \Log::info('Inputs extracted', [
        'user_id' => $user_id,
        'code' => $qrCodeCode,
        'course_id' => $course_id,
        'bundle_id' => $bundle_id,
    ]);

    // Retrieve the user
    $user = User::find($user_id);
    if (!$user) {
        \Log::warning('User not found', ['user_id' => $user_id]);
        return apiResponse2(1, 'user_not_found', trans('api.user.not_found'));
    }

    // Find the QR code
    $qrCode = QrCode::where('code', $qrCodeCode)->first();
    if (!$qrCode) {
        \Log::warning('QR Code not found', ['code' => $qrCodeCode]);
        return apiResponse2(1, 'qr_code_not_found', trans('api.qrcode.not_found'));
    }

    \Log::info('QR Code found', ['qrCode' => $qrCode->toArray()]);

    // Check if the QR code is already used
    if ($qrCode->is_used) {
        \Log::warning('QR Code already used', ['qrCode' => $qrCode->code]);
        return apiResponse2(1, 'qr_code_not_active', trans('api.qrcode.not_active'));
    }

    if ($course_id) {
        // Handle course purchase
        $course = Webinar::find($course_id);
        if (!$course) {
            \Log::warning('Course not found', ['course_id' => $course_id]);
            return apiResponse2(1, 'course_not_found', trans('api.course.not_found'));
        }

        \Log::info('Course found', ['course' => $course->toArray()]);

        // Create a sale for the course
        Sale::create([
            'buyer_id' => $user->id,
            'seller_id' => $course->creator_id,
            'webinar_id' => $course->id,
            'type' => Sale::$webinar,
            'payment_method' => Sale::$credit,
            'amount' => $course->price,
            'total_amount' => $course->price,
            'created_at' => time(),
        ]);

        \Log::info('Sale created for course', ['course_id' => $course_id]);
    } elseif ($bundle_id) {
        // Handle bundle purchase
        $bundle = Bundle::find($bundle_id);
        if (!$bundle) {
            \Log::warning('Bundle not found', ['bundle_id' => $bundle_id]);
            return apiResponse2(1, 'bundle_not_found', trans('api.bundle.not_found'));
        }

        \Log::info('Bundle found', ['bundle' => $bundle->toArray()]);

        // Create a sale for the bundle
        Sale::create([
            'buyer_id' => $user->id,
            'seller_id' => $bundle->creator_id,
            'bundle_id' => $bundle->id,
            'type' => Sale::$bundle,
            'payment_method' => Sale::$credit,
            'amount' => $bundle->price,
            'total_amount' => $bundle->price,
            'created_at' => time(),
        ]);

        \Log::info('Sale created for bundle', ['bundle_id' => $bundle_id]);
    } else {
        \Log::warning('Neither course_id nor bundle_id provided', ['request' => $request->all()]);
        return apiResponse2(1, 'invalid_request', trans('api.invalid_request'));
    }

    $usedIn = null;

// Check if it's a course or bundle and set used_in accordingly
if ($course_id) {
    $usedIn = $course_id;  // Set to course_id if it's a course
} elseif ($bundle_id) {
    $usedIn = $bundle_id;  // Set to bundle_id if it's a bundle
}

$qrCode->update([
    'is_used' => 1,
    'user_id' => $user->id,
    'used_at' => now(),  // current timestamp
    'used_in' => $usedIn,  // Set used_in dynamically based on course_id or bundle_id
]);
    \Log::info('QR Code marked as used', ['qrCode' => $qrCode->code]);

    \Log::info('QR Code Access - End', ['qrCode' => $qrCode->code]);

    return apiResponse2(1, 'success', trans('api.qrcode.access_successful'));
}

}
    
