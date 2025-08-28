@extends(getTemplate() . '.layouts.app')

@push('styles_top')
@endpush

@section('content')
<section class="bg-white">
    <section class="cart-banner position-relative text-center">
        <h1 class="font-30 text-white font-weight-bold">{{ trans('cart.checkout') }}</h1>
        <span
            class="payment-hint font-20 text-white d-block">{{ handlePrice($total) . ' ' . trans('cart.for_items', ['count' => $count]) }}</span>
    </section>

    <section class="container mt-45">

        @if (!empty($totalCashbackAmount))
            <div class="d-flex align-items-center mb-25 p-15 success-transparent-alert">
                <div class="success-transparent-alert__icon d-flex align-items-center justify-content-center">
                    <i data-feather="credit-card" width="18" height="18" class=""></i>
                </div>

                <div class="ml-10">
                    <div class="font-14 font-weight-bold ">{{ trans('update.get_cashback') }}</div>
                    <div class="font-12 ">
                        {{ trans('update.by_purchasing_this_cart_you_will_get_amount_as_cashback', ['amount' => handlePrice($totalCashbackAmount)]) }}
                    </div>
                </div>
            </div>
        @endif
      <div class="row my-30">
        <div class="col-12 col-lg-6">
            <section class="mt-45  ">
              
                        <h3 class="section-title">{{ trans('cart.cart_totals') }}</h3>
                <div class="rounded-sm shadow-xl mt-20 pb-20 px-20">

                    <div class="cart-checkout-item">
                        <h4 class="text-secondary font-14 font-weight-500">{{ trans('cart.sub_total') }}</h4>
                        <span class="font-14 text-gray font-weight-bold">{{ handlePrice($total) }}</span>
                    </div>

                    <div class="cart-checkout-item">
                        <h4 class="text-secondary font-14 font-weight-500">{{ trans('public.discount') }}</h4>
                        <span class="font-14 text-gray font-weight-bold">
                            <span id="totalDiscount">{{ handlePrice($totalDiscount ?? 0) }}</span>
                        </span>
                    </div>

                    <div class="cart-checkout-item">
                        <h4 class="text-secondary font-14 font-weight-500">{{ trans('cart.tax') }}

                            <span class="font-14 text-gray ">({{ $tax ??0 }}%)</span>
                        </h4>
                        <span class="font-14 text-gray font-weight-bold"><span
                                id="taxPrice">{{ handlePrice($taxPrice ?? 0) }}</span></span>
                    </div>

                    @if (!empty($productDeliveryFee))
                        <div class="cart-checkout-item">
                            <h4 class="text-secondary font-14 font-weight-500">
                                {{ trans('update.delivery_fee') }}
                            </h4>
                            <span class="font-14 text-gray font-weight-bold"><span
                                    id="taxPrice">{{ handlePrice($productDeliveryFee) }}</span></span>
                        </div>
                    @endif

                    <div class="cart-checkout-item border-0">
                        <h4 class="text-secondary font-14 font-weight-500">{{ trans('cart.total') }}</h4>
                        <span class="font-14 text-gray font-weight-bold"><span
                                id="totalAmount">{{ handlePrice($total) }}</span></span>
                    </div>

                </div>
            </section>
        </div>
        <div class="col-12 col-lg-6">
            <section class="mt-45  ">
              
                <h3 class="section-title">{{ trans('cart.coupon_code') }}</h3>
                <div class="rounded-sm shadow-xl mt-20 py-25 px-20">
                    <p class="text-gray font-14">{{ trans('cart.coupon_code_hint') }}</p>

                    @if (!empty($userGroup) and !empty($userGroup->discount))
                        <p class="text-gray mt-25">
                            {{ trans('cart.in_user_group', ['group_name' => $userGroup->name, 'percent' => $userGroup->discount]) }}
                        </p>
                    @endif

                    <form action="/carts/coupon/validate" method="Post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="text" name="coupon" id="coupon_input" class="form-control mt-25"
                                placeholder="{{ trans('cart.enter_your_code_here') }}">
                            <span class="invalid-feedback">{{ trans('cart.coupon_invalid') }}</span>
                            <span class="valid-feedback">{{ trans('cart.coupon_valid') }}</span>
                        </div>

                        <button type="submit" id="checkCoupon"
                            class="btn btn-sm btn-primary mt-50">{{ trans('cart.validate') }}</button>
                    </form>
                </div>
            </section>
        </div>
      </div>
        @php
            $isMultiCurrency = !empty(getFinancialCurrencySettings('multi_currency'));
            $userCurrency = currency();
            $invalidChannels = [];
        @endphp

        <h2 class="section-title">{{ trans('financial.select_a_payment_gateway') }}</h2>

        <!-- Main Payment Form -->
        <form action="/payments/payment-request" method="post" class="mt-25 pb-24!">
            {{ csrf_field() }}
            <input type="hidden" name="order_id" value="{{ $order->id }}">

            <div class="row">
                @if (!empty($paymentChannels))
                    @foreach ($paymentChannels as $paymentChannel)
                        @if (!$isMultiCurrency or !empty($paymentChannel->currencies) and in_array($userCurrency, $paymentChannel->currencies))
                            <div class="col-6 col-lg-4 mb-40 charge-account-radio">
                                <input type="radio" name="gateway" id="{{ $paymentChannel->title }}"
                                    data-class="{{ $paymentChannel->class_name }}" value="{{ $paymentChannel->id }}">
                                <label for="{{ $paymentChannel->title }}"
                                    class="rounded-sm p-20 p-lg-45 d-flex flex-column align-items-center justify-content-center">
                                    <img src="{{ $paymentChannel->image }}" width="120" height="60" alt="">
                                    <p class="mt-30 mt-lg-50 font-weight-500 text-dark-blue">
                                        {{ trans('financial.pay_via') }}
                                        <span class="font-weight-bold font-14">{{ $paymentChannel->title }}</span>
                                    </p>
                                </label>
                            </div>
                        @else
                            @php
                                $invalidChannels[] = $paymentChannel;
                            @endphp
                        @endif
                    @endforeach
                @endif

                <div class="col-6 col-lg-4 mb-40 charge-account-radio">
                    <input type="radio" @if (empty($userCharge) or $total > $userCharge) disabled @endif name="gateway" id="offline"
                        value="credit">
                    <label for="offline"
                        class="rounded-sm p-20 p-lg-45 d-flex flex-column align-items-center justify-content-center">
                        <img src="/assets/default/img/activity/pay.svg" width="120" height="60" alt="">
                        <p class="mt-30 mt-lg-50 font-weight-500 text-dark-blue">
                            {{ trans('financial.account') }}
                            <span class="font-weight-bold">{{ trans('financial.charge') }}</span>
                        </p>
                        <span class="mt-5">{{ handlePrice($userCharge) }}</span>
                        <!-- Voucher Form HTML -->
                        <div class="mt-25">
                            <div class="voucher-input">
                                <input type="text" id="voucher_code_input" class="form-control mb-2 mt-5"
                                    placeholder="{{ trans('cart.enter_your_voucher_code_here') }}">
                                <button type="button" id="checkVoucher" class="btn btn-sm btn-primary w-100">
                                    {{ trans('cart.validate') }}
                                </button>
                            </div>
                        </div>

                    </label>

                </div>
            </div>

            <div class="d-flex align-items-center justify-content-between mt-45">
                <span class="text-2xl! font-semibold! text-gray">{{ trans('financial.total_amount') }}
                    {{ handlePrice($total) }}</span>
                <button type="button" id="paymentSubmit" disabled
                    class="btn btn btn-primary px-8! py-4! text-2xl! text-white text-base md:text-xl bg-[#65C83C]! [opacity:1]!  border-4! border-[#FFDD33]! rounded-[25px]! transition-colors duration-300">{{ trans('public.start_payment') }}</button>
            </div>
        </form>
        <!-- End of Main Payment Form -->




        @if (!empty($invalidChannels) and empty(getFinancialSettings('hide_disabled_payment_gateways')))
            <div class="d-flex align-items-center mt-30 rounded-lg border p-15">
                <div class="size-40 d-flex-center rounded-circle bg-gray200">
                    <i data-feather="info" class="text-gray" width="20" height="20"></i>
                </div>
                <div class="ml-5">
                    <h4 class="font-14 font-weight-bold text-gray">{{ trans('update.disabled_payment_gateways') }}</h4>
                    <p class="font-12 text-gray">{{ trans('update.disabled_payment_gateways_hint') }}</p>
                </div>
            </div>

            <div class="row mt-20">
                @foreach ($invalidChannels as $invalidChannel)
                    <div class="col-6 col-lg-4 mb-40 charge-account-radio">
                        <div
                            class="disabled-payment-channel bg-white border rounded-sm p-20 p-lg-45 d-flex flex-column align-items-center justify-content-center">
                            <img src="{{ $invalidChannel->image }}" width="120" height="60" alt="">
                            <p class="mt-30 mt-lg-50 font-weight-500 text-dark-blue">
                                {{ trans('financial.pay_via') }}
                                <span class="font-weight-bold font-14">{{ $invalidChannel->title }}</span>
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if (!empty($razorpay) and $razorpay)
            <form action="/payments/verify/Razorpay" method="get">
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="{{ getRazorpayApiKey()['api_key'] }}"
                    data-amount="{{ (int) ($order->total_amount * 100) }}" data-buttontext="product_price" data-description="Razorpay"
                    data-currency="{{ currency() }}" data-image="{{ $generalSettings['logo'] }}"
                    data-prefill.name="{{ $order->user->full_name }}" data-prefill.email="{{ $order->user->email }}"
                    data-theme.color="#43d477"></script>
            </form>
        @endif
    </section>
  </section>
@endsection

@push('scripts_bottom')
    <script>
        document.getElementById('checkVoucher').addEventListener('click', function(event) {
            event.preventDefault();
            const voucherCode = document.getElementById('voucher_code_input').value;

            if (!voucherCode) {
                Swal.fire({
                    icon: 'error',
                    title: 'Voucher Code Required',
                    text: 'Please enter a voucher code.',
                });
                return;
            }

            // Show loading spinner using SweetAlert
            Swal.fire({
                title: 'Validating and Applying Voucher...',
                text: 'Please wait while we validate and apply your voucher.',
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch('/cart/voucher/validate', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify({
                        code: voucherCode
                    })
                })
                .then(response => response.json())
                .then(data => {
                    Swal.close(); // Close the loading spinner

                    if (data.valid) {
                        // Voucher is valid, proceed to apply it
                        return fetch('/cart/voucher/use', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            },
                            body: JSON.stringify({
                                code: voucherCode
                            })
                        });
                    } else {
                        throw new Error(data.message || 'Voucher is invalid');
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Voucher Applied Successfully!',
                            text: `Amount Applied: ${data.amount}`,
                            timer: 5000, // Alert closes after 5 seconds
                            timerProgressBar: true,
                            showConfirmButton: true, // Hide confirm button
                            didDestroy: () => {
                                location.reload(); // Reload page after alert closes
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed to Apply Voucher',
                            text: data.message,
                        });
                    }
                })
                .catch(error => {
                    Swal.close(); // Close the loading spinner
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message ||
                            'An error occurred during voucher validation and application.',
                    });
                });
        });
    </script>

    <script src="/assets/default/js/parts/payment.min.js"></script>
@endpush
