<?php
namespace App\Http\Controllers\Api\Panel;

use App\Http\Controllers\Controller;
use App\Models\Api\Bundle;
use App\Models\Cart;
use App\Models\Api\Product;
use App\Models\ProductOrder;
use App\Models\ReserveMeeting;
use App\Models\Ticket;
use App\Models\Api\Webinar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Validation\Rule;

class AddCartController extends Controller
{
    public $cookieKey = 'carts';

    public function storeUserWebinarCart($user, $data)
    {
        \Log::info('Storing Webinar to Cart', ['user_id' => $user->id, 'data' => $data]);

        $webinar_id = $data['item_id'];
        $ticket_id = $data['ticket_id'] ?? null;

        validateParam($data, [
            'item_id' => Rule::exists('webinars', 'id')
                ->where('status', 'active')->where('private', false)
        ]);

        $webinar = Webinar::find($webinar_id);

        if (!empty($webinar) && !empty($user)) {
            $checkCourseForSale = $webinar->checkWebinarForSale($user);
            \Log::info('Webinar Sale Check Result', ['result' => $checkCourseForSale]);

            if ($checkCourseForSale != 'ok') {
                return $checkCourseForSale;
            }

            $activeSpecialOffer = $webinar->activeSpecialOffer();
            \Log::info('Webinar Special Offer', ['offer' => $activeSpecialOffer]);

            Cart::updateOrCreate([
                'creator_id' => $user->id,
                'webinar_id' => $webinar_id,
            ], [
                'ticket_id' => $ticket_id,
                'special_offer_id' => !empty($activeSpecialOffer) ? $activeSpecialOffer->id : null,
                'created_at' => time()
            ]);

            \Log::info('Webinar added to Cart', ['user_id' => $user->id, 'webinar_id' => $webinar_id]);
            return 'ok';
        }
    }

    public function storeUserBundleCart($user, $data)
    {
        \Log::info('Storing Bundle to Cart', ['user_id' => $user->id, 'data' => $data]);

        $bundle_id = $data['item_id'];
        $ticket_id = $data['ticket_id'] ?? null;

        validateParam($data, [
            'item_id' => Rule::exists('bundles', 'id')->where('status', 'active')
        ]);

        $bundle = Bundle::where('id', $bundle_id)
            ->where('status', 'active')
            ->first();

        if (!empty($bundle) && !empty($user)) {
            $checkCourseForSale = $bundle->checkWebinarForSale($user);
            \Log::info('Bundle Sale Check Result', ['result' => $checkCourseForSale]);

            if ($checkCourseForSale != 'ok') {
                return $checkCourseForSale;
            }

            $activeSpecialOffer = $bundle->activeSpecialOffer();
            \Log::info('Bundle Special Offer', ['offer' => $activeSpecialOffer]);

            Cart::updateOrCreate([
                'creator_id' => $user->id,
                'bundle_id' => $bundle_id,
            ], [
                'ticket_id' => $ticket_id,
                'special_offer_id' => !empty($activeSpecialOffer) ? $activeSpecialOffer->id : null,
                'created_at' => time()
            ]);

            \Log::info('Bundle added to Cart', ['user_id' => $user->id, 'bundle_id' => $bundle_id]);
            return 'ok';
        }
    }

    public function storeUserProductCart($user, $data)
    {
        \Log::info('Storing Product to Cart', ['user_id' => $user->id, 'data' => $data]);

        $product_id = $data['item_id'];
        $specifications = $data['specifications'] ?? null;
        $quantity = $data['quantity'] ?? 1;

        validateParam($data, [
            'item_id' => Rule::exists('products', 'id')->where('status', 'active')
        ]);

        $product = Product::where('id', $product_id)
            ->where('status', 'active')
            ->first();

        if (!empty($product) && !empty($user)) {
            $checkProductForSale = $product->checkProductForSale($user);
            \Log::info('Product Sale Check Result', ['result' => $checkProductForSale]);

            if ($checkProductForSale != 'ok') {
                return $checkProductForSale;
            }

            $activeDiscount = $product->getActiveDiscount();
            \Log::info('Product Active Discount', ['discount' => $activeDiscount]);

            $productOrder = ProductOrder::updateOrCreate([
                'product_id' => $product->id,
                'seller_id' => $product->creator_id,
                'buyer_id' => $user->id,
                'sale_id' => null,
                'status' => 'pending',
            ], [
                'specifications' => $specifications ? json_encode($specifications) : null,
                'quantity' => $quantity,
                'discount_id' => !empty($activeDiscount) ? $activeDiscount->id : null,
                'created_at' => time()
            ]);

            Cart::updateOrCreate([
                'creator_id' => $user->id,
                'product_order_id' => $productOrder->id,
            ], [
                'product_discount_id' => !empty($activeDiscount) ? $activeDiscount->id : null,
                'created_at' => time()
            ]);

            \Log::info('Product added to Cart', ['user_id' => $user->id, 'product_id' => $product->id]);
            return 'ok';
        }
    }

    public function store(Request $request)
    {
        $user = apiAuth();
        \Log::info('Cart Store Request', ['user_id' => $user->id, 'request' => $request->all()]);

        validateParam($request->all(), [
            'item_id' => 'required',
            'item_name' => 'required|in:webinar,bundle,product',
            'ticket_id' => 'nullable',
            'specifications' => 'nullable',
            'quantity' => 'nullable'
        ]);

        $item_name = $request->input('item_name');
        $data = $request->except('_token');

        $rr = $item_name . '_id';
        if (Cart::where($rr, $request->input('item_id'))->where('creator_id', $user->id)->count()) {
            \Log::warning('Item already in Cart', ['user_id' => $user->id, 'item' => $data]);
            return apiResponse2(0, 'already_in_cart', 'This item is in the cart');
        }

        $result = null;
        if ($item_name == 'webinar') {
            $result = $this->storeUserWebinarCart($user, $data);
        } elseif ($item_name == 'product') {
            $result = $this->storeUserProductCart($user, $data);
        } elseif ($item_name == 'bundle') {
            $result = $this->storeUserBundleCart($user, $data);
        }

        if ($result != 'ok') {
            \Log::error('Error adding to Cart', ['result' => $result]);
            return $result;
        }

        \Log::info('Item successfully added to Cart', ['user_id' => $user->id, 'data' => $data]);
        return apiResponse2(1, 'stored', trans('cart.cart_add_success_msg'));
    }

    public function destroy($id)
    {
        \Log::info('Removing Item from Cart', ['cart_id' => $id]);

        if (auth()->check()) {
            $user_id = auth()->id();
            \Log::info('Authenticated User', ['user_id' => $user_id]);

            $cart = Cart::where('id', $id)
                ->where('creator_id', $user_id)
                ->first();

            if (!empty($cart)) {
                \Log::info('Cart Item Found', ['cart' => $cart]);

                if (!empty($cart->reserve_meeting_id)) {
                    $reserve = ReserveMeeting::where('id', $cart->reserve_meeting_id)
                        ->where('user_id', $user_id)
                        ->first();

                    if (!empty($reserve)) {
                        \Log::info('Removing Reserve Meeting', ['reserve' => $reserve]);
                        $reserve->delete();
                    }
                }

                $cart->delete();
            }
        } else {
            $carts = Cookie::get($this->cookieKey);
            \Log::info('Unauthenticated User', ['cookie' => $carts]);

            if (!empty($carts)) {
                $carts = json_decode($carts, true);

                if (!empty($carts[$id])) {
                    unset($carts[$id]);
                }

                Cookie::queue($this->cookieKey, json_encode($carts), 30 * 24 * 60);
            }
        }

        \Log::info('Item removed from Cart', ['cart_id' => $id]);
        return response()->json([
            'code' => 200,
            'msg' => trans('update.cart_remove_success'),
        ]);
    }
}

