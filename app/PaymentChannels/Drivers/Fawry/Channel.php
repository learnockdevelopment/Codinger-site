<?php

namespace App\PaymentChannels\Drivers\Fawry;

use App\Models\Order;
use App\Models\PaymentChannel;
use App\PaymentChannels\BasePaymentChannel;
use App\PaymentChannels\IChannel;
use Illuminate\Http\Request;

class Channel extends BasePaymentChannel implements IChannel
{
    protected $currency;
    protected $order_session_key;
    protected $test_mode;
    protected $merchant_code;
    protected $secret_key;

    protected array $credentialItems = [
        'merchant_code',
        'secret_key',
    ];

    public function __construct(PaymentChannel $paymentChannel)
    {
        $this->currency = currency();
        $this->order_session_key = 'fawry.payments.order_id';
        $this->setCredentialItems($paymentChannel);
        
        // Log initialization
        \Log::info('Fawry Payment Channel initialized', [
            'currency' => $this->currency,
            'order_session_key' => $this->order_session_key,
            'merchant_code' => $this->merchant_code,
        ]);
    }

    public function paymentRequest(Order $order)
    {
        $user = $order->user;

        // Log order and user details
        \Log::info('Fawry Payment Request', [
            'order_id' => $order->id,
            'user_id' => $user->id,
            'amount' => $order->total_amount,
            'currency' => $this->currency,
        ]);

        // Prepare charge request data
        $chargeRequest = json_encode($this->buildChargeRequest($order, $user));

        return view('web.default.cart.channels.fawry_checkout_form', [
            'chargeRequest' => $chargeRequest,
            'action_url' => $this->action_url(),
        ]);
    }

    private function action_url()
    {
        return $this->test_mode ? 'https://atfawry.fawrystaging.com/ECommercePlugin/FawryPay.jsp' : 'https://www.atfawry.com/ECommercePlugin/FawryPay.jsp';
    }

    private function buildChargeRequest(Order $order, $user)
    {
        return [
            'merchantCode' => $this->merchant_code,
            'merchantRefNum' => $order->id,
            'customerMobile' => $user->mobile,
            'customerEmail' => $user->email,
            'customerName' => $user->full_name,
            'customerProfileId' => $user->id,
            'paymentExpiry' => now()->addMinutes(30)->timestamp * 1000, // Example: set expiration time to 30 minutes
            'chargeItems' => [
                [
                    'itemId' => 'unique-item-id-1', // Replace with actual item ID
                    'description' => 'Product Description 1',
                    'price' => $order->total_amount, // Total amount, or adjust based on your items
                    'quantity' => 1, // Set quantity appropriately
                    'imageUrl' => 'https://example.com/image1.jpg', // Replace with actual image URL
                ],
            ],
            'returnUrl' => $this->makeCallbackUrl('return'),
            'authCaptureModePayment' => false,
            'signature' => $this->generateSignature($order),
        ];
    }

    private function generateSignature(Order $order)
    {
        return hash('sha256', $this->merchant_code . $order->id . $order->total_amount . $this->secret_key);
    }

    private function makeCallbackUrl($status)
    {
        return url("/payments/verify/Fawry?status=$status");
    }

    public function verify(Request $request)
    {
        $data = $request->all();

        // Log incoming request data
        \Log::info('Fawry Payment Verification Request', [
            'request_data' => $data,
        ]);

        try {
            $order_id = session()->get($this->order_session_key, null);
            session()->forget($this->order_session_key);

            $user = auth()->user();

            // Log order fetching
            \Log::info('Fetching Order for Verification', [
                'order_id' => $order_id,
                'user_id' => $user->id,
            ]);

            $order = Order::where('id', $order_id)
                ->where('user_id', $user->id)
                ->first();

            if (!empty($order)) {
                $orderStatus = Order::$fail;

                // Log order status initialization
                \Log::info('Initial Order Status', [
                    'order_id' => $order->id,
                    'status' => $orderStatus,
                ]);

                if (!empty($data['status']) && $data['status'] == 'notify') {
                    $merchant_code = $this->merchant_code;
                    $merchant_ref_num = $data['merchant_ref_num'];
                    $fawry_amount = $data['fawry_amount'];
                    $fawry_currency = $data['fawry_currency'];
                    $payment_status = $data['payment_status'];
                    $signature = $data['signature'];

                    // Log payment status and signature details
                    \Log::info('Fawry Payment Status Details', [
                        'merchant_code' => $merchant_code,
                        'merchant_ref_num' => $merchant_ref_num,
                        'fawry_amount' => $fawry_amount,
                        'fawry_currency' => $fawry_currency,
                        'payment_status' => $payment_status,
                        'signature' => $signature,
                    ]);

                    $local_signature = hash('sha256', $merchant_code . $merchant_ref_num . $fawry_amount . $fawry_currency . $payment_status . $this->secret_key);

                    // Log local signature for debugging
                    \Log::info('Generated Local Signature', [
                        'local_signature' => $local_signature,
                    ]);

                    if (($local_signature === $signature) && ($payment_status == 'PAID')) {
                        $orderStatus = Order::$paying;
                    }

                    // Log order status after verification
                    \Log::info('Final Order Status after Verification', [
                        'order_id' => $order->id,
                        'final_status' => $orderStatus,
                    ]);
                }

                $order->update([
                    'status' => $orderStatus,
                ]);
            }

            return $order;
        } catch (\Exception $e) {
            \Log::error('Fawry Payment Verification Error: ' . $e->getMessage(), [
                'request_data' => $data,
            ]);
            return response()->json(['error' => 'Payment verification failed'], 500);
        }
    }
}
