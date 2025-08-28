<?php $__env->startPush('styles_top'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="bg-white">
    <section class="cart-banner position-relative text-center">
        <h1 class="font-30 text-white font-weight-bold"><?php echo e(trans('cart.checkout')); ?></h1>
        <span
            class="payment-hint font-20 text-white d-block"><?php echo e(handlePrice($total) . ' ' . trans('cart.for_items', ['count' => $count])); ?></span>
    </section>

    <section class="container mt-45">

        <?php if(!empty($totalCashbackAmount)): ?>
            <div class="d-flex align-items-center mb-25 p-15 success-transparent-alert">
                <div class="success-transparent-alert__icon d-flex align-items-center justify-content-center">
                    <i data-feather="credit-card" width="18" height="18" class=""></i>
                </div>

                <div class="ml-10">
                    <div class="font-14 font-weight-bold "><?php echo e(trans('update.get_cashback')); ?></div>
                    <div class="font-12 ">
                        <?php echo e(trans('update.by_purchasing_this_cart_you_will_get_amount_as_cashback', ['amount' => handlePrice($totalCashbackAmount)])); ?>

                    </div>
                </div>
            </div>
        <?php endif; ?>
      <div class="row my-30">
        <div class="col-12 col-lg-6">
            <section class="mt-45  ">
              
                        <h3 class="section-title"><?php echo e(trans('cart.cart_totals')); ?></h3>
                <div class="rounded-sm shadow-xl mt-20 pb-20 px-20">

                    <div class="cart-checkout-item">
                        <h4 class="text-secondary font-14 font-weight-500"><?php echo e(trans('cart.sub_total')); ?></h4>
                        <span class="font-14 text-gray font-weight-bold"><?php echo e(handlePrice($total)); ?></span>
                    </div>

                    <div class="cart-checkout-item">
                        <h4 class="text-secondary font-14 font-weight-500"><?php echo e(trans('public.discount')); ?></h4>
                        <span class="font-14 text-gray font-weight-bold">
                            <span id="totalDiscount"><?php echo e(handlePrice($totalDiscount ?? 0)); ?></span>
                        </span>
                    </div>

                    <div class="cart-checkout-item">
                        <h4 class="text-secondary font-14 font-weight-500"><?php echo e(trans('cart.tax')); ?>


                            <span class="font-14 text-gray ">(<?php echo e($tax ??0); ?>%)</span>
                        </h4>
                        <span class="font-14 text-gray font-weight-bold"><span
                                id="taxPrice"><?php echo e(handlePrice($taxPrice ?? 0)); ?></span></span>
                    </div>

                    <?php if(!empty($productDeliveryFee)): ?>
                        <div class="cart-checkout-item">
                            <h4 class="text-secondary font-14 font-weight-500">
                                <?php echo e(trans('update.delivery_fee')); ?>

                            </h4>
                            <span class="font-14 text-gray font-weight-bold"><span
                                    id="taxPrice"><?php echo e(handlePrice($productDeliveryFee)); ?></span></span>
                        </div>
                    <?php endif; ?>

                    <div class="cart-checkout-item border-0">
                        <h4 class="text-secondary font-14 font-weight-500"><?php echo e(trans('cart.total')); ?></h4>
                        <span class="font-14 text-gray font-weight-bold"><span
                                id="totalAmount"><?php echo e(handlePrice($total)); ?></span></span>
                    </div>

                </div>
            </section>
        </div>
        <div class="col-12 col-lg-6">
            <section class="mt-45  ">
              
                <h3 class="section-title"><?php echo e(trans('cart.coupon_code')); ?></h3>
                <div class="rounded-sm shadow-xl mt-20 py-25 px-20">
                    <p class="text-gray font-14"><?php echo e(trans('cart.coupon_code_hint')); ?></p>

                    <?php if(!empty($userGroup) and !empty($userGroup->discount)): ?>
                        <p class="text-gray mt-25">
                            <?php echo e(trans('cart.in_user_group', ['group_name' => $userGroup->name, 'percent' => $userGroup->discount])); ?>

                        </p>
                    <?php endif; ?>

                    <form action="/carts/coupon/validate" method="Post">
                        <?php echo e(csrf_field()); ?>

                        <div class="form-group">
                            <input type="text" name="coupon" id="coupon_input" class="form-control mt-25"
                                placeholder="<?php echo e(trans('cart.enter_your_code_here')); ?>">
                            <span class="invalid-feedback"><?php echo e(trans('cart.coupon_invalid')); ?></span>
                            <span class="valid-feedback"><?php echo e(trans('cart.coupon_valid')); ?></span>
                        </div>

                        <button type="submit" id="checkCoupon"
                            class="btn btn-sm btn-primary mt-50"><?php echo e(trans('cart.validate')); ?></button>
                    </form>
                </div>
            </section>
        </div>
      </div>
        <?php
            $isMultiCurrency = !empty(getFinancialCurrencySettings('multi_currency'));
            $userCurrency = currency();
            $invalidChannels = [];
        ?>

        <h2 class="section-title"><?php echo e(trans('financial.select_a_payment_gateway')); ?></h2>

        <!-- Main Payment Form -->
        <form action="/payments/payment-request" method="post" class="mt-25 pb-24!">
            <?php echo e(csrf_field()); ?>

            <input type="hidden" name="order_id" value="<?php echo e($order->id); ?>">

            <div class="row">
                <?php if(!empty($paymentChannels)): ?>
                    <?php $__currentLoopData = $paymentChannels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paymentChannel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(!$isMultiCurrency or !empty($paymentChannel->currencies) and in_array($userCurrency, $paymentChannel->currencies)): ?>
                            <div class="col-6 col-lg-4 mb-40 charge-account-radio">
                                <input type="radio" name="gateway" id="<?php echo e($paymentChannel->title); ?>"
                                    data-class="<?php echo e($paymentChannel->class_name); ?>" value="<?php echo e($paymentChannel->id); ?>">
                                <label for="<?php echo e($paymentChannel->title); ?>"
                                    class="rounded-sm p-20 p-lg-45 d-flex flex-column align-items-center justify-content-center">
                                    <img src="<?php echo e($paymentChannel->image); ?>" width="120" height="60" alt="">
                                    <p class="mt-30 mt-lg-50 font-weight-500 text-dark-blue">
                                        <?php echo e(trans('financial.pay_via')); ?>

                                        <span class="font-weight-bold font-14"><?php echo e($paymentChannel->title); ?></span>
                                    </p>
                                </label>
                            </div>
                        <?php else: ?>
                            <?php
                                $invalidChannels[] = $paymentChannel;
                            ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>

                <div class="col-6 col-lg-4 mb-40 charge-account-radio">
                    <input type="radio" <?php if(empty($userCharge) or $total > $userCharge): ?> disabled <?php endif; ?> name="gateway" id="offline"
                        value="credit">
                    <label for="offline"
                        class="rounded-sm p-20 p-lg-45 d-flex flex-column align-items-center justify-content-center">
                        <img src="/assets/default/img/activity/pay.svg" width="120" height="60" alt="">
                        <p class="mt-30 mt-lg-50 font-weight-500 text-dark-blue">
                            <?php echo e(trans('financial.account')); ?>

                            <span class="font-weight-bold"><?php echo e(trans('financial.charge')); ?></span>
                        </p>
                        <span class="mt-5"><?php echo e(handlePrice($userCharge)); ?></span>
                        <!-- Voucher Form HTML -->
                        <div class="mt-25">
                            <div class="voucher-input">
                                <input type="text" id="voucher_code_input" class="form-control mb-2 mt-5"
                                    placeholder="<?php echo e(trans('cart.enter_your_voucher_code_here')); ?>">
                                <button type="button" id="checkVoucher" class="btn btn-sm btn-primary w-100">
                                    <?php echo e(trans('cart.validate')); ?>

                                </button>
                            </div>
                        </div>

                    </label>

                </div>
            </div>

            <div class="d-flex align-items-center justify-content-between mt-45">
                <span class="text-2xl! font-semibold! text-gray"><?php echo e(trans('financial.total_amount')); ?>

                    <?php echo e(handlePrice($total)); ?></span>
                <button type="button" id="paymentSubmit" disabled
                    class="btn btn btn-primary px-8! py-4! text-2xl! text-white text-base md:text-xl bg-[#65C83C]! [opacity:1]!  border-4! border-[#FFDD33]! rounded-[25px]! transition-colors duration-300"><?php echo e(trans('public.start_payment')); ?></button>
            </div>
        </form>
        <!-- End of Main Payment Form -->




        <?php if(!empty($invalidChannels) and empty(getFinancialSettings('hide_disabled_payment_gateways'))): ?>
            <div class="d-flex align-items-center mt-30 rounded-lg border p-15">
                <div class="size-40 d-flex-center rounded-circle bg-gray200">
                    <i data-feather="info" class="text-gray" width="20" height="20"></i>
                </div>
                <div class="ml-5">
                    <h4 class="font-14 font-weight-bold text-gray"><?php echo e(trans('update.disabled_payment_gateways')); ?></h4>
                    <p class="font-12 text-gray"><?php echo e(trans('update.disabled_payment_gateways_hint')); ?></p>
                </div>
            </div>

            <div class="row mt-20">
                <?php $__currentLoopData = $invalidChannels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invalidChannel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-6 col-lg-4 mb-40 charge-account-radio">
                        <div
                            class="disabled-payment-channel bg-white border rounded-sm p-20 p-lg-45 d-flex flex-column align-items-center justify-content-center">
                            <img src="<?php echo e($invalidChannel->image); ?>" width="120" height="60" alt="">
                            <p class="mt-30 mt-lg-50 font-weight-500 text-dark-blue">
                                <?php echo e(trans('financial.pay_via')); ?>

                                <span class="font-weight-bold font-14"><?php echo e($invalidChannel->title); ?></span>
                            </p>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>

        <?php if(!empty($razorpay) and $razorpay): ?>
            <form action="/payments/verify/Razorpay" method="get">
                <input type="hidden" name="order_id" value="<?php echo e($order->id); ?>">
                <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="<?php echo e(getRazorpayApiKey()['api_key']); ?>"
                    data-amount="<?php echo e((int) ($order->total_amount * 100)); ?>" data-buttontext="product_price" data-description="Razorpay"
                    data-currency="<?php echo e(currency()); ?>" data-image="<?php echo e($generalSettings['logo']); ?>"
                    data-prefill.name="<?php echo e($order->user->full_name); ?>" data-prefill.email="<?php echo e($order->user->email); ?>"
                    data-theme.color="#43d477"></script>
            </form>
        <?php endif; ?>
    </section>
  </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts_bottom'); ?>
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make(getTemplate() . '.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/codinger/htdocs/codinger.online/resources/views/web/default/cart/payment.blade.php ENDPATH**/ ?>