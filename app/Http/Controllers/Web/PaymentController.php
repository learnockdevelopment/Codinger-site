<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mixins\Cashback\CashbackAccounting;
use App\Models\Accounting;
use App\Models\BecomeInstructor;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentChannel;
use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\ReserveMeeting;
use App\Models\Reward;
use App\Models\RewardAccounting;
use App\Models\Sale;
use App\Models\TicketUser;
use App\PaymentChannels\ChannelManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $order_session_key = 'payment.order_id';

    public function paymentRequest(Request $request)
    {
        $this->validate($request, [
            'gateway' => 'required'
        ]);

        $user = auth()->user();
        $gateway = $request->input('gateway');
        $orderId = $request->input('order_id');

        $order = Order::where('id', $orderId)
            ->where('user_id', $user->id)
            ->first();

        if ($order->type === Order::$meeting) {
            $orderItem = OrderItem::where('order_id', $order->id)->first();
            $reserveMeeting = ReserveMeeting::where('id', $orderItem->reserve_meeting_id)->first();
            $reserveMeeting->update(['locked_at' => time()]);
        }

        if ($gateway === 'credit') {

            if ($user->getAccountingCharge() < $order->total_amount) {
                $order->update(['status' => Order::$fail]);

                session()->put($this->order_session_key, $order->id);

                return redirect('/payments/status');
            }

            $order->update([
                'payment_method' => Order::$credit
            ]);

            $this->setPaymentAccounting($order, 'credit');

            $order->update([
                'status' => Order::$paid
            ]);

            session()->put($this->order_session_key, $order->id);

            return redirect('/payments/status');
        }

        $paymentChannel = PaymentChannel::where('id', $gateway)
            ->where('status', 'active')
            ->first();

        if (!$paymentChannel) {
            $toastData = [
                'title' => trans('cart.fail_purchase'),
                'msg' => trans('public.channel_payment_disabled'),
                'status' => 'error'
            ];
            return back()->with(['toast' => $toastData]);
        }

        $order->payment_method = Order::$paymentChannel;
        $order->save();


        try {
            $channelManager = ChannelManager::makeChannel($paymentChannel);
            $redirect_url = $channelManager->paymentRequest($order);

            if (in_array($paymentChannel->class_name, PaymentChannel::$gatewayIgnoreRedirect)) {
                return $redirect_url;
            }

            return Redirect::away($redirect_url);

        } catch (\Exception $exception) {
            
            $toastData = [
                'title' => trans('cart.fail_purchase'),
                'msg' => trans('cart.gateway_error'),
                'status' => 'error'
            ];
            return back()->with(['toast' => $toastData]);
        }
    }

    


public function paymentVerify(Request $request, $gateway)
{
    Log::info('Payment verification started', ['gateway' => $gateway]);

    // Log the received request data
    Log::info('Received request data', ['request' => $request->all()]);

    $paymentChannel = PaymentChannel::where('class_name', $gateway)
        ->where('status', 'active')
        ->first();
    
    // Log after querying for the payment channel
    Log::info('Payment channel retrieved', ['payment_channel' => $paymentChannel]);

    try {
        // Create a channel manager
        $channelManager = ChannelManager::makeChannel($paymentChannel);
        Log::info('Channel manager created', ['channel_manager' => $channelManager]);

        // Verify the payment
        $order = $channelManager->verify($request);
        Log::info('Payment verification completed', ['order' => $order]);

        return $this->paymentOrderAfterVerify($order);

    } catch (\Exception $exception) {
        // Log the exception details
        Log::error('Payment verification error', [
            'exception_message' => $exception->getMessage(),
            'exception_stack' => $exception->getTraceAsString(),
            'request' => $request->all(),  // Log the request data
            'gateway' => $gateway,
        ]);

        // Prepare the error message for the user
        $toastData = [
            'title' => trans('cart.fail_purchase'),
            'msg' => trans('cart.gateway_error'),
            'status' => 'error'
        ];

        Log::info('Redirecting user with error', ['toast_data' => $toastData]);

        // Return to the cart with the error message
        return redirect('cart')->with(['toast' => $toastData]);
    }
}


    /*
     * | this methode only run for payku.result
     * */
    public function paykuPaymentVerify(Request $request, $id)
    {
        $paymentChannel = PaymentChannel::where('class_name', PaymentChannel::$payku)
            ->where('status', 'active')
            ->first();

        try {
            $channelManager = ChannelManager::makeChannel($paymentChannel);

            $request->request->add(['transaction_id' => $id]);

            $order = $channelManager->verify($request);

            return $this->paymentOrderAfterVerify($order);

        } catch (\Exception $exception) {
            $toastData = [
                'title' => trans('cart.fail_purchase'),
                'msg' => trans('cart.gateway_error'),
                'status' => 'error'
            ];
            return redirect('cart')->with(['toast' => $toastData]);
        }
    }
private function paymentOrderAfterVerify($order)
{
  $order = $order['order'] ?? null;  // Assuming $order is the array structure in the log

    // Log entry into the method
    Log::debug('Entered paymentOrderAfterVerify method', ['order_id' => $order ?? null]);

    if (!empty($order)) {
        // Log that the order is being processed
        Log::debug('Order found and processing', ['order_id' => $order->id]);

        if ($order->status == Order::$paying) {
            // Log the status check for "paying"
            Log::debug('Order is currently paying', ['order_id' => $order->id]);

            // Call setPaymentAccounting function and log
            $this->setPaymentAccounting($order);
            Log::debug('Payment accounting set for order', ['order_id' => $order->id]);

            // Update order status to "paid"
            $order->update(['status' => Order::$paid]);
            Log::debug('Order status updated to paid', ['order_id' => $order->id]);
        } else {
            // Log the situation where order status is not "paying"
            Log::debug('Order is not paying, checking order type', ['order_id' => $order->id]);

            if ($order->type === Order::$meeting) {
                // Log that the order type is a meeting
                Log::debug('Order type is meeting', ['order_id' => $order->id]);

                $orderItem = OrderItem::where('order_id', $order->id)->first();
                Log::debug('Order item found', ['order_item_id' => $orderItem->id ?? null]);

                if ($orderItem && $orderItem->reserve_meeting_id) {
                    $reserveMeeting = ReserveMeeting::where('id', $orderItem->reserve_meeting_id)->first();
                    Log::debug('Reserve meeting found', ['reserve_meeting_id' => $reserveMeeting->id ?? null]);

                    if ($reserveMeeting) {
                        // Unlock the reserve meeting and log
                        $reserveMeeting->update(['locked_at' => null]);
                        Log::debug('Reserve meeting unlocked', ['reserve_meeting_id' => $reserveMeeting->id]);
                    }
                }
            }
        }

        // Log session storage of order ID
        session()->put($this->order_session_key, $order->id);
        Log::debug('Order ID stored in session', ['order_id' => $order->id]);

        // Redirect to the payment status page
        return redirect('/payments/status');
    } else {
        // Log if order is not found
        Log::debug('Order not found or is empty', ['order_id' => $order->id ?? null]);

        // Handle error and log the error details
        $toastData = [
            'title' => trans('cart.fail_purchase'),
            'msg' => trans('cart.gateway_error'),
            'status' => 'error'
        ];
        Log::debug('Redirecting to cart due to gateway error', ['toast_data' => $toastData]);

        return redirect('cart')->with($toastData);
    }
}

public function setPaymentAccounting($order, $type = null)
{
    // Log entry into the method
    Log::debug('Entered setPaymentAccounting method', ['order_id' => $order->id, 'type' => $type]);

    $cashbackAccounting = new CashbackAccounting();

    // Log checking if charge account is set
    if ($order->is_charge_account) {
        Log::debug('Order is charge account', ['order_id' => $order->id]);

        // Call charge function and log it
        Accounting::charge($order);
        Log::debug('Charge applied to account', ['order_id' => $order->id]);

        // Recharge wallet and log
        $cashbackAccounting->rechargeWallet($order);
        Log::debug('Wallet recharged', ['order_id' => $order->id]);
    } else {
        // Loop over order items and log each order item processing
        foreach ($order->orderItems as $orderItem) {
            Log::debug('Processing order item', ['order_item_id' => $orderItem->id]);

            // Create a sale and log
            $sale = Sale::createSales($orderItem, $order->payment_method);
            Log::debug('Sale created', ['sale_id' => $sale->id, 'order_item_id' => $orderItem->id]);

            // Check if reserve meeting ID exists
            if (!empty($orderItem->reserve_meeting_id)) {
                $reserveMeeting = ReserveMeeting::where('id', $orderItem->reserve_meeting_id)->first();

                if ($reserveMeeting) {
                    $reserveMeeting->update([
                        'sale_id' => $sale->id,
                        'reserved_at' => time()
                    ]);
                    Log::debug('Reserve meeting updated', ['reserve_meeting_id' => $reserveMeeting->id]);

                    $reserver = $reserveMeeting->user;

                    if ($reserver) {
                        Log::debug('Handling meeting reserve reward', ['user_id' => $reserver->id]);
                        $this->handleMeetingReserveReward($reserver);
                    }
                }
            }

            // Handle gift processing
            if (!empty($orderItem->gift_id)) {
                $gift = $orderItem->gift;

                $gift->update([
                    'status' => 'active'
                ]);
                Log::debug('Gift activated', ['gift_id' => $gift->id, 'order_item_id' => $orderItem->id]);

                // Send notifications when the gift is activated
                $gift->sendNotificationsWhenActivated($orderItem->total_amount);
                Log::debug('Notification sent for activated gift', ['gift_id' => $gift->id, 'amount' => $orderItem->total_amount]);
            }

            // Handle subscription payment
            if (!empty($orderItem->subscribe_id)) {
                Accounting::createAccountingForSubscribe($orderItem, $type);
                Log::debug('Subscription accounting created', ['order_item_id' => $orderItem->id]);
            } elseif (!empty($orderItem->promotion_id)) {
                Accounting::createAccountingForPromotion($orderItem, $type);
                Log::debug('Promotion accounting created', ['order_item_id' => $orderItem->id]);
            } elseif (!empty($orderItem->registration_package_id)) {
                Accounting::createAccountingForRegistrationPackage($orderItem, $type);
                Log::debug('Registration package accounting created', ['order_item_id' => $orderItem->id]);

                if (!empty($orderItem->become_instructor_id)) {
                    BecomeInstructor::where('id', $orderItem->become_instructor_id)
                        ->update([
                            'package_id' => $orderItem->registration_package_id
                        ]);
                    Log::debug('Become Instructor package updated', ['become_instructor_id' => $orderItem->become_instructor_id, 'registration_package_id' => $orderItem->registration_package_id]);
                }
            } elseif (!empty($orderItem->installment_payment_id)) {
                Accounting::createAccountingForInstallmentPayment($orderItem, $type);
                Log::debug('Installment payment accounting created', ['order_item_id' => $orderItem->id]);

                // Update installment order and log it
                $this->updateInstallmentOrder($orderItem, $sale);
                Log::debug('Installment order updated', ['order_item_id' => $orderItem->id, 'sale_id' => $sale->id]);
            } else {
                // For webinar, meeting, product, and bundle
                Accounting::createAccounting($orderItem, $type);
                Log::debug('General accounting created', ['order_item_id' => $orderItem->id]);

                TicketUser::useTicket($orderItem);
                Log::debug('Ticket used', ['order_item_id' => $orderItem->id]);

                if (!empty($orderItem->product_id)) {
                    $this->updateProductOrder($sale, $orderItem);
                    Log::debug('Product order updated', ['product_id' => $orderItem->product_id, 'sale_id' => $sale->id]);
                }
            }
        }

        // Set cashback accounting for all order items
        $cashbackAccounting->setAccountingForOrderItems($order->orderItems);
        Log::debug('Cashback accounting set for order items', ['order_id' => $order->id]);
    }

    // Empty the cart for the user
    Cart::emptyCart($order->user_id);
    Log::debug('Cart emptied for user', ['user_id' => $order->user_id]);
}


    public function payStatus(Request $request)
{
    // Log entry into the method
    Log::debug('Entered payStatus method', ['request' => $request->all()]);

    $orderId = $request->get('order_id', null);

    // Log the order ID received from the request
    Log::debug('Received order_id from request', ['order_id' => $orderId]);

    // Check if order session exists and fetch it from session
    if (!empty(session()->get($this->order_session_key, null))) {
        $orderId = session()->get($this->order_session_key, null);
        session()->forget($this->order_session_key);

        // Log session-based order ID retrieval
        Log::debug('Retrieved order_id from session', ['order_id' => $orderId]);
    }

    // Retrieve the order from the database
    $order = Order::where('id', $orderId)
                  ->where('user_id', auth()->id())
                  ->first();

    // Log the retrieved order or if not found
    if (!empty($order)) {
        Log::debug('Found order for user', ['order_id' => $order->id, 'user_id' => $order->user_id]);
    } else {
        Log::warning('Order not found', ['order_id' => $orderId, 'user_id' => auth()->id()]);
    }

    // If the order exists, prepare the data and return the view
    if (!empty($order)) {
        $data = [
            'pageTitle' => trans('public.cart_page_title'),
            'order' => $order,
        ];

        // Log the data being passed to the view
        Log::debug('Returning view with order details', ['data' => $data]);

        return view('web.default.cart.status_pay', $data);
    }

    // Log redirection if order is not found
    Log::warning('Redirecting to /panel due to missing order', ['order_id' => $orderId]);

    return redirect('/panel');
}


    private function handleMeetingReserveReward($user)
    {
        if ($user->isUser()) {
            $type = Reward::STUDENT_MEETING_RESERVE;
        } else {
            $type = Reward::INSTRUCTOR_MEETING_RESERVE;
        }

        $meetingReserveReward = RewardAccounting::calculateScore($type);

        RewardAccounting::makeRewardAccounting($user->id, $meetingReserveReward, $type);
    }

    private function updateProductOrder($sale, $orderItem)
    {
        $product = $orderItem->product;

        $status = ProductOrder::$waitingDelivery;

        if ($product and $product->isVirtual()) {
            $status = ProductOrder::$success;
        }

        ProductOrder::where('product_id', $orderItem->product_id)
            ->where(function ($query) use ($orderItem) {
                $query->where(function ($query) use ($orderItem) {
                    $query->whereNotNull('buyer_id');
                    $query->where('buyer_id', $orderItem->user_id);
                });

                $query->orWhere(function ($query) use ($orderItem) {
                    $query->whereNotNull('gift_id');
                    $query->where('gift_id', $orderItem->gift_id);
                });
            })
            ->update([
                'sale_id' => $sale->id,
                'status' => $status,
            ]);

        if ($product and $product->getAvailability() < 1) {
            $notifyOptions = [
                '[p.title]' => $product->title,
            ];
            sendNotification('product_out_of_stock', $notifyOptions, $product->creator_id);
        }
    }

    private function updateInstallmentOrder($orderItem, $sale)
    {
        $installmentPayment = $orderItem->installmentPayment;

        if (!empty($installmentPayment)) {
            $installmentOrder = $installmentPayment->installmentOrder;

            $installmentPayment->update([
                'sale_id' => $sale->id,
                'status' => 'paid',
            ]);

            /* Notification Options */
            $notifyOptions = [
                '[u.name]' => $installmentOrder->user->full_name,
                '[installment_title]' => $installmentOrder->installment->main_title,
                '[time.date]' => dateTimeFormat(time(), 'j M Y - H:i'),
                '[amount]' => handlePrice($installmentPayment->amount),
            ];

            if ($installmentOrder and $installmentOrder->status == 'paying' and $installmentPayment->type == 'upfront') {
                $installment = $installmentOrder->installment;

                if ($installment) {
                    if ($installment->needToVerify()) {
                        $status = 'pending_verification';

                        sendNotification("installment_verification_request_sent", $notifyOptions, $installmentOrder->user_id);
                        sendNotification("admin_installment_verification_request_sent", $notifyOptions, 1); // Admin
                    } else {
                        $status = 'open';

                        sendNotification("paid_installment_upfront", $notifyOptions, $installmentOrder->user_id);
                    }

                    $installmentOrder->update([
                        'status' => $status
                    ]);

                    if ($status == 'open' and !empty($installmentOrder->product_id) and !empty($installmentOrder->product_order_id)) {
                        $productOrder = ProductOrder::query()->where('installment_order_id', $installmentOrder->id)
                            ->where('id', $installmentOrder->product_order_id)
                            ->first();

                        $product = Product::query()->where('id', $installmentOrder->product_id)->first();

                        if (!empty($product) and !empty($productOrder)) {
                            $productOrderStatus = ProductOrder::$waitingDelivery;

                            if ($product->isVirtual()) {
                                $productOrderStatus = ProductOrder::$success;
                            }

                            $productOrder->update([
                                'status' => $productOrderStatus
                            ]);
                        }
                    }
                }
            }


            if ($installmentPayment->type == 'step') {
                sendNotification("paid_installment_step", $notifyOptions, $installmentOrder->user_id);
                sendNotification("paid_installment_step_for_admin", $notifyOptions, 1); // For Admin
            }

        }
    }

}
