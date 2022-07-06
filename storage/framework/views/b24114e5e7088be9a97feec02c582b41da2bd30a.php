<div class="card-body">
    <?php
    $contents = [];
    ?>
    <?php $__currentLoopData = $carts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $contents[] = [
                'id' => $item['id'],
                'quantity' => $item['quantity'],
            ];
        ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <div class="col-12 p-0">

        <div class="row ">

            <div class="col-12 border-bottom py-2 px-0">
                <p class="text-muted custom-text font-weight-bolder small" style="letter-spacing: 1px;">
                    ORDER DETAILS </p>
            </div>

        </div>
        <form class="form-default" action="<?php echo e(route('checkout.store_delivery_info')); ?>" id="delivery_info"
            role="form" method="POST">
            <?php echo csrf_field(); ?>
            <?php
                $admin_products = [];
                $seller_products = [];
                foreach ($carts as $key => $cartItem) {
                    $product = \App\Product::find($cartItem['product_id']);
                
                    if ($product->added_by == 'admin') {
                        array_push($admin_products, $cartItem);
                    } else {
                        $product_ids = [];
                        if (isset($seller_products[$product->user_id])) {
                            $product_ids = $seller_products[$product->user_id];
                        }
                        array_push($product_ids, $cartItem);
                        $seller_products[$product->user_id] = $product_ids;
                    }
                }
                $subtotal = 0;
                $tax = 0;
                $shipping = 0;
                $product_shipping_cost = 0;
                // $shipping_region = $shipping_info['city'];
                $gstper = 0;
                $gstval = 0;
            ?>

            <?php if(!empty($admin_products)): ?>
                <div class="card mb-3 shadow-sm border-0 rounded">
                    
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <?php $__currentLoopData = $admin_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cartItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                
                                <?php
                                    $product = \App\Product::find($cartItem->product_id);
                                    $category_id = $product->category_id;
                                    $category = \App\Category::select('gst')
                                        ->where('id', $category_id)
                                        ->first();
                                    //$category->gst;
                                    //$gstper = ($category->gst)/100;
                                    //$gstval = $cartItem->price * $gstper;
                                    $subtotal += ($cartItem->price - $gstval) * $cartItem->quantity;
                                    //$tax += $cartItem->tax * $cartItem->quantity;
                                    
                                    $product_shipping_cost = $cartItem->shipping_cost;
                                    $tax += $product_shipping_cost * 0.18 * $cartItem->quantity;
                                    $shipping += $product_shipping_cost * $cartItem->quantity;
                                    
                                    $product_name_with_choice = $product->getTranslation('name');
                                    if ($cartItem->variant != null) {
                                        $product_name_with_choice = $product->getTranslation('name') . ' - ' . $cartItem->variant;
                                    }
                                    //$user_id = $cartItem->user_id;
                                    $vendor_id = $product['user_id'];
                                    $address_id = $cartItem->address_id;
                                    //$user = \App\User::select('state')->where('id', $user_id)->first();
                                    $address = \App\Address::select('state')
                                        ->where('id', $address_id)
                                        ->first();
                                    $vendor = \App\User::select('state')
                                        ->where('id', $vendor_id)
                                        ->first();
                                    
                                ?>
                                <li class="list-group-item px-0">
                                    <div class="row py-1">

                                        <div class="col-3">
                                            <img src="<?php echo e(uploaded_asset($product->thumbnail_img)); ?>"
                                                alt="<?php echo e($product->getTranslation('name')); ?>" style="max-width: 100%;">
                                        </div>

                                        <div class="col-5 ">
                                            <p class="small text-muted custom-right-text text-truncate-2">
                                                <?php echo e($product_name_with_choice); ?>

                                            </p>
                                        </div>

                                        <div class="col-4 ">
                                            <p class="small text-right text-muted custom-right-text  mb-0">
                                                <?php echo e(single_price(($cartItem['price'] - $gstval) * $cartItem['quantity'])); ?>

                                            </p>
                                            <p class="small text-muted text-right custom-right-text">Qty:
                                                <?php echo e($cartItem->quantity); ?>

                                            </p>
                                        </div>

                                    </div>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>

                        <div class="row pt-1 d-none">
                            <div class="col-md-12 px-0">
                                <h6 class="fs-14 fw-600"><?php echo e(translate('Choose Delivery Type')); ?></h6>
                            </div>
                            <div class="col-md-12 px-0">
                                <div class="row gutters-5">
                                    <div class="col-6">
                                        <label class="aiz-megabox d-block bg-white mb-0">
                                            <input type="radio"
                                                name="shipping_type_<?php echo e(\App\User::where('user_type', 'admin')->first()->id); ?>"
                                                value="home_delivery" onchange="show_pickup_point(this)"
                                                data-bs-target=".pickup_point_id_admin" checked>
                                            <span class="d-flex py-2 px-1 aiz-megabox-elem">
                                                <span class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                                <span
                                                    class="flex-grow-1 pl-3 fw-600"><?php echo e(translate('Home Delivery')); ?></span>
                                            </span>
                                        </label>
                                    </div>
                                    <?php if(\App\BusinessSetting::where('type', 'pickup_point')->first()->value == 1): ?>
                                        <div class="col-6">
                                            <label class="aiz-megabox d-block bg-white mb-0">
                                                <input type="radio"
                                                    name="shipping_type_<?php echo e(\App\User::where('user_type', 'admin')->first()->id); ?>"
                                                    value="pickup_point" onchange="show_pickup_point(this)"
                                                    data-bs-target=".pickup_point_id_admin">
                                                <span class="d-flex py-2 px-1 aiz-megabox-elem">
                                                    <span class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                                    <span
                                                        class="flex-grow-1 pl-3 fw-600"><?php echo e(translate('Local Pickup')); ?></span>
                                                </span>
                                            </label>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="mt-4 pickup_point_id_admin d-none">
                                    <select class="form-control aiz-selectpicker"
                                        name="pickup_point_id_<?php echo e(\App\User::where('user_type', 'admin')->first()->id); ?>"
                                        data-live-search="true">
                                        <option><?php echo e(translate('Select your nearest pickup point')); ?></option>
                                        <?php $__currentLoopData = \App\PickupPoint::where('pick_up_status', 1)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $pick_up_point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($pick_up_point->id); ?>" data-content="<span class='d-block'>
                                                            <span class='d-block fs-16 fw-600 mb-2'><?php echo e($pick_up_point->getTranslation('name')); ?></span>
                                                            <span class='d-block opacity-50 fs-12'><i class='las la-map-marker'></i> <?php echo e($pick_up_point->getTranslation('address')); ?></span>
                                                            <span class='d-block opacity-50 fs-12'><i class='las la-phone'></i><?php echo e($pick_up_point->phone); ?></span>
                                                        </span>">
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            <?php endif; ?>
            <?php if(!empty($seller_products)): ?>
                <?php $__currentLoopData = $seller_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $seller_product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card mb-3 shadow-sm border-0 rounded">
                        
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                <?php $__currentLoopData = $seller_product; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cartItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    
                                    
                                    <?php
                                        $product = \App\Product::find($cartItem->product_id);
                                        $category_id = $product->category_id;
                                        $category = \App\Category::select('gst')
                                            ->where('id', $category_id)
                                            ->first();
                                        //$category->gst;
                                        //$gstper = ($category->gst)/100;
                                        //$gstval = $cartItem->price * $gstper;
                                        $subtotal += ($cartItem->price - $gstval) * $cartItem->quantity;
                                        //$tax += $cartItem->tax * $cartItem->quantity;
                                        
                                        $product_shipping_cost = $cartItem->shipping_cost;
                                        // $tax += $product_shipping_cost * 0.18 * $cartItem->quantity;
                                        // $shipping += $product_shipping_cost * $cartItem->quantity;
                                        
                                        $product_name_with_choice = $product->getTranslation('name');
                                        if ($cartItem->variant != null) {
                                            $product_name_with_choice = $product->getTranslation('name') . ' - ' . $cartItem->variant;
                                        }
                                        //$user_id = $cartItem->user_id;
                                        $vendor_id = $product['user_id'];
                                        $address_id = $cartItem->address_id;
                                        //$user = \App\User::select('state')->where('id', $user_id)->first();
                                        $address = \App\Address::select('state')
                                            ->where('id', $address_id)
                                            ->first();
                                        $vendor = \App\User::select('state')
                                            ->where('id', $vendor_id)
                                            ->first();
                                        
                                    ?>
                                    <li class="list-group-item px-0">
                                        <div class="row py-1">

                                            <div class="col-3">
                                                <img src="<?php echo e(uploaded_asset($product->thumbnail_img)); ?>"
                                                    alt="<?php echo e($product->getTranslation('name')); ?>"
                                                    style="max-width: 100%;">
                                            </div>

                                            <div class="col-5 ">
                                                <p class="small text-muted custom-right-text  text-truncate-2">
                                                    <?php echo e($product_name_with_choice); ?>

                                                </p>
                                            </div>

                                            <div class="col-4 ">
                                                <p class="small text-right text-muted custom-right-text mb-0">
                                                    <?php echo e(single_price(($cartItem['price'] - $gstval) * $cartItem['quantity'])); ?>

                                                </p>
                                                <p class="small text-muted text-right custom-right-text">Qty:
                                                    <?php echo e($cartItem->quantity); ?></p>
                                            </div>

                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>

                            <div class="row pt-1 d-none">
                                <div class="col-md-12">
                                    <h6 class="fs-14 fw-600"><?php echo e(translate('Choose Delivery Type')); ?></h6>
                                </div>
                                <div class="col-md-12">
                                    <div class="row gutters-5">
                                        <div class="col-6">
                                            <label class="aiz-megabox d-block bg-white mb-0">
                                                <input type="radio" name="shipping_type_<?php echo e($key); ?>"
                                                    value="home_delivery" onchange="show_pickup_point(this)"
                                                    data-bs-target=".pickup_point_id_<?php echo e($key); ?>" checked>
                                                <span class="d-flex py-2 px-1 aiz-megabox-elem">
                                                    <span class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                                    <span
                                                        class="flex-grow-1 pl-3 fw-600"><?php echo e(translate('Home Delivery')); ?></span>
                                                </span>
                                            </label>
                                        </div>
                                        <?php if(\App\BusinessSetting::where('type', 'pickup_point')->first()->value == 1): ?>
                                            <?php if(is_array(json_decode(\App\Shop::where('user_id', $key)->first()->pick_up_point_id))): ?>
                                                <div class="col-6">
                                                    <label class="aiz-megabox d-block bg-white mb-0">
                                                        <input type="radio" name="shipping_type_<?php echo e($key); ?>"
                                                            value="pickup_point" onchange="show_pickup_point(this)"
                                                            data-bs-target=".pickup_point_id_<?php echo e($key); ?>">
                                                        <span class="d-flex py-2 px-1 aiz-megabox-elem">
                                                            <span class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                                            <span
                                                                class="flex-grow-1 pl-3 fw-600"><?php echo e(translate('Local Pickup')); ?></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                    <?php if(\App\BusinessSetting::where('type', 'pickup_point')->first()->value == 1): ?>
                                        <?php if(is_array(json_decode(\App\Shop::where('user_id', $key)->first()->pick_up_point_id))): ?>
                                            <div class="mt-4 pickup_point_id_<?php echo e($key); ?> d-none">
                                                <select class="form-control aiz-selectpicker"
                                                    name="pickup_point_id_<?php echo e($key); ?>" data-live-search="true">
                                                    <option><?php echo e(translate('Select your nearest pickup point')); ?>

                                                    </option>
                                                    <?php $__currentLoopData = json_decode(\App\Shop::where('user_id', $key)->first()->pick_up_point_id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pick_up_point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if(\App\PickupPoint::find($pick_up_point) != null): ?>
                                                            <option
                                                                value="<?php echo e(\App\PickupPoint::find($pick_up_point)->id); ?>"
                                                                data-content="<span class='d-block'>
                                                                        <span class='d-block fs-16 fw-600 mb-2'><?php echo e(\App\PickupPoint::find($pick_up_point)->getTranslation('name')); ?></span>
                                                                        <span class='d-block opacity-50 fs-12'><i class='las la-map-marker'></i> <?php echo e(\App\PickupPoint::find($pick_up_point)->getTranslation('address')); ?></span>
                                                                        <span class='d-block opacity-50 fs-12'><i class='las la-phone'></i> <?php echo e(\App\PickupPoint::find($pick_up_point)->phone); ?></span>
                                                                    </span>">
                                                            </option>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            
        </form>
        <div class="row bg-dark error-container" style="display: none;">
            <div class="col-md-12 d-flex justify-content-center my-2">
                <small
                    class="text-white text-uppercase custom-right-text font-weight-bolder discount-coupon-error"></small>
            </div>
        </div>
        <div class="row my-2">
            <div class="col-6 small text-muted custom-right-text">Subtotal</div>
            <div class="col-6 custom-right-text small text-muted text-right">
                <?php echo e(single_price($subtotal)); ?></div>
        </div>

        <div class="row my-2">
            <div class="col-6 custom-right-text small text-muted">Shipping</div>
            <div class="col-6 custom-right-text small text-muted text-right">
                <?php echo e(single_price($shipping)); ?></div>
        </div>

        <div class="row my-2">
            <div class="col-6 custom-right-text small text-muted">Tax</div>
            <div class="col-6 custom-right-text small text-muted text-right">
                <?php echo e(single_price($tax)); ?></div>
        </div>
        <?php if(Session::has('club_point')): ?>
            <div class="row my-2">
                <div class="col-6 custom-right-text small text-muted">Redeem point</div>
                <div class="col-6 custom-right-text small text-muted text-right">
                    <?php echo e(single_price(Session::get('club_point'))); ?></div>
            </div>
        <?php endif; ?>
        <?php if(addon_is_activated('club_point')): ?>
            <?php if(Session::has('club_point')): ?>
                <div class="row my-2 credit-container" style="display: none;">
                    <form class="" action="<?php echo e(route('checkout.remove_club_point')); ?>" method="POST"
                        enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="input-group">
                            <div class="col-6 custom-right-text small text-danger">Club Points
                            </div>
                            <div class="col-6">
                                <p class=" custom-right-text small text-danger text-right credit-discount-amount">
                                    <?php echo e(Session::get('club_point')); ?></p>
                            </div>
                            <div class="input-group-append">
                                <button type="submit"
                                    class="btn btn-primary"><?php echo e(translate('Remove Redeem Point')); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        

        
        <?php if(Session::has('club_point')): ?>
            <div class="row my-2 discount-container">
                <div class="col-6 custom-right-text small "><?php echo e(translate('Redeem point')); ?></div>
                <div class="col-6 custom-right-text small  text-right discount-amount">
                    <?php echo e(single_price(Session::get('club_point'))); ?>

                </div>
            </div>
        <?php endif; ?>
        <?php if($carts->sum('discount') > 0): ?>
            <div class="row my-2 discount-container">
                <div class="col-6 custom-right-text small ">Discount via Coupon</div>
                <div class="col-6 custom-right-text small  text-right discount-amount">
                    <?php echo e(single_price($carts->sum('discount'))); ?>

                </div>
            </div>
        <?php endif; ?>
        <?php if(Auth::check() && get_setting('coupon_system') == 1): ?>
            <?php if($carts[0]['discount'] > 0): ?>
                <div class="mt-3 bef-pay-hide">
                    <form class="" id="remove-coupon-form" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="owner_id" value="<?php echo e($carts[0]['owner_id']); ?>">
                        <div class="input-group">
                            <div class="form-control"><?php echo e($carts[0]['coupon_code']); ?></div>
                            <button type="button" id="coupon-remove"
                                class="btn btn-sm text-right s-check text-white btn-dark custom-right-text small w-auto">Remove
                                Coupon</button>
                        </div>
                        
                    </form>
                </div>
            <?php else: ?>
                <div class="mt-3 bef-pay-hide">
                    <form class="" id="apply-coupon-form" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="owner_id" value="<?php echo e($carts[0]['owner_id']); ?>">
                        <div class="input-group">
                            <input title="Discount Coupon" type="text" onkeydown="return event.key != 'Enter';"
                                placeholder="<?php echo e(translate('Have coupon code? Enter here')); ?>"
                                class="small custom-right-text rounded-0 border-top-0 border-right-0 border-left-0 form-control h-75 float-right coupon-code"
                                name="code" placeholder="Enter Coupon Code" required />
                            <button type="button" id="coupon-apply"
                                class="btn btn-sm text-right s-check text-white btn-dark custom-right-text small w-auto">Apply</button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <div class="row mt-3">
        <div class="col-6 ">
            <p class="custom-right-text small text-muted font-weight-bolder">Grand Total</p>
        </div>
        <?php
            $total = $subtotal + $tax + $shipping;
            if (Session::has('club_point')) {
                $total -= Session::get('club_point');
            }
            if ($carts->sum('discount') > 0) {
                $total -= $carts->sum('discount');
            }
        ?>
        <div class="col-6 pr-0">
            <p class="custom-right-text small text-muted text-right font-weight-bolder grand-amount-after-discount">
                <?php echo e(single_price($total)); ?>

            </p>
            <p style="font-size: 9px;" class="text-muted text-right font-weight-bolder">
                Inclusive of all taxes
            </p>
            <?php if(Auth::check()): ?>
                <button type="button" onclick="showPayment(this)"
                    class="btn btn-sm text-right btn-dark s-check text-white custom-right-text small w-auto float-right bef-pay-hide">Continue
                    &#8594;</button>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
    fbq('track', 'InitiateCheckout', {
        content_type: 'product',
        contents: <?php echo json_encode($contents); ?>,
        value: <?php echo e($total); ?>,
        currency: 'INR'
    });
</script>
<script>
    fbq('track', 'AddPaymentInfo');
</script>
<?php /**PATH /var/www/sadar24_aws/resources/views/frontend/partials/cart_summary.blade.php ENDPATH**/ ?>