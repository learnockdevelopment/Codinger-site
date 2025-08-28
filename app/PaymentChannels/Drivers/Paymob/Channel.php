<?php

namespace App\PaymentChannels\Drivers\Paymob;

use App\Models\Order;
use App\Models\PaymentChannel;
use App\PaymentChannels\BasePaymentChannel;
use App\PaymentChannels\IChannel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Channel extends BasePaymentChannel implements IChannel
{
    protected $currency;
    protected $api_key;
    protected $secret_key;
    protected $public_key;
    protected $integration_id;
    protected $order_session_key;

    protected array $credentialItems = [
        'api_key',
        'secret_key',
        'public_key',
        'integration_id',
    ];

    protected $currencyPrecision = [
        'EGP' => 100,
        'USD' => 100,
        'EUR' => 100,
        'JPY' => 1,
    ];

    public function __construct(PaymentChannel $paymentChannel)
    {
        $this->currency = currency();
        $this->setCredentialItems($paymentChannel);
        $this->order_session_key = 'paymob.payments.order_id';
    }

    private function handleConfigs()
    {
        // Any additional configurations
    }

    public function paymentRequest(Order $order)
    {
        $this->handleConfigs();

        try {
            $tokenResponse = $this->getToken();
            $token = $tokenResponse->token;
            $profile = $tokenResponse->profile;
            Log::debug('Retrieved Auth Token: ', ['token' => $token]);

            $intention = $this->createPaymobIntention($order, $token, $profile);
            Log::debug('Paymob Intention Response: ', ['intention' => $intention]);

            if (!$intention || !isset($intention->id)) {
                throw new \Exception('Paymob intention creation failed.');
            }

            $clientSecret = $intention->client_secret;
            $publicKey = $this->public_key;

            $checkoutUrl = "https://accept.paymob.com/unifiedcheckout/?publicKey={$publicKey}&clientSecret={$clientSecret}";
            Log::info('Redirecting to Paymob Unified Checkout: ', ['url' => $checkoutUrl]);

            return redirect()->to($checkoutUrl);
        } catch (\Exception $e) {
            Log::error('Error in Paymob payment process: ' . $e->getMessage());
            return response()->json(['status' => 'fail', 'message' => 'Payment process error: ' . $e->getMessage()], 500);
        }
    }

    public function getToken()
    {
        $response = Http::post('https://accept.paymobsolutions.com/api/auth/tokens', [
            'api_key' => $this->api_key
        ]);

        Log::debug('Token Response: ', ['response' => $response->json()]);

        if ($response->failed()) {
            Log::error('Failed to retrieve token: ', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            throw new \Exception('Failed to retrieve Paymob token.');
        }

        return $response->object();
    }

    private function createPaymobIntention(Order $order, $token, $profile)
    {
        $this->integration_id = explode(", ", $this->integration_id);
        $this->integration_id = array_map('intval', $this->integration_id);
        Log::debug('Integration id: ' . json_encode($this->integration_id));

        $user = $order->user;
        $fullNameParts = explode(' ', $user->full_name, 2);
        $firstName = $fullNameParts[0] ?? 'N/A';
        $lastName = $fullNameParts[1] ?? 'N/A';

        $precision = $this->currencyPrecision[$this->currency] ?? 100;

        $data = [
            'amount' => round(floatval($this->getPrice($order)) * $precision),
            'currency' => $this->currency,
            'payment_methods' => $this->integration_id,
            'billing_data' => [
                'apartment' => $user->apartment ?? 'N/A',
                'first_name' => $firstName,
                'last_name' => $lastName,
                'street' => $user->street ?? 'N/A',
                'building' => $user->building ?? 'N/A',
                'phone_number' => $user->mobile ?? 'N/A',
                'country' => $user->country_code ?? 'N/A',
                'email' => $user->email,
                'floor' => $user->floor ?? 'N/A',
                'state' => $user->state ?? 'N/A',
            ],
            'customer' => [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'extras' => [
                    're' => $user->referral_code ?? 'N/A',
                ],
            ],
            'extras' => [
                'ee' => 22,
                'merchant_order_id' => $order->id,
            ],
        ];

        Log::debug('Intention Creation Request: ', ['REQUEST' => $data]);
        $response = Http::withHeaders([
            'Authorization' => 'Token ' . $this->secret_key,
            'Content-Type' => 'application/json'
        ])->post('https://accept.paymob.com/v1/intention/', $data);

        Log::debug('Intention Creation Response: ', ['response' => $response->json()]);

        if ($response->failed()) {
            Log::error('Paymob intention creation failed: ', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            $errorDetails = $response->json();
            $errorMessage = isset($errorDetails['detail']) ? $errorDetails['detail'] : 'Unknown error occurred';

            throw new \Exception('Failed to create Paymob intention: ' . $errorMessage . ' Original data: ' . json_encode($data, JSON_PRETTY_PRINT));
        }

        return $response->object();
    }

    private function getPrice(Order $order): float
    {
        return $this->makeAmountByCurrency($order->total_amount, $this->currency);
    }

    public function verify(Request $request)
{
    $this->handleConfigs();

    $data = $request->all();
    Log::debug('Verification Data: ', ['data' => $data]);

    if (!isset($data['success']) || !$data['success']) {
        Log::warning('Payment verification failed: ', ['data' => $data]);

        // Return failure status with order data
        return response()->json([
            'status' => 'fail',
            'message' => 'Payment verification failed.',
            'order' => null, // No order available on failure
        ]);
    }

    $orderId = $data['merchant_order_id'] ?? $data['order'];
    Log::debug('Retrieved Order ID for Verification: ', ['order_id' => $orderId]);

    $order = Order::find(1238); // Find the order by the actual order ID

    if (!$order) {
        Log::error('Order not found for verification: ', ['order_id' => $orderId]);

        return response()->json([
            'status' => 'fail',
            'message' => 'Order not found.',
            'order' => null, // No order data if not found
        ]);
    }

    if (isset($data['success']) && $data['success']) {
        $order->update([
            'status' => Order::$paying,
        ]);
        Log::info('Payment verified successfully: ', ['order_id' => $orderId]);

        // Return success status with order data
        return [
            'status' => 'success',
            'message' => 'Payment verified successfully.',
            'order' => $order, // Include order details
        ];
    } else {
        $order->update([
            'status' => Order::$fail,
        ]);
        Log::info('Payment failed: ', ['order_id' => $orderId]);

        // Return failure status with order data
        return response()->json([
            'status' => 'fail',
            'message' => 'Payment failed.',
            'order' => $order, // Include order details
        ]);
    }
}

}
