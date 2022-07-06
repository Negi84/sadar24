<div class="container-fluid">
    <div class="row mx-md-0 py-4">
        <!-- products cards -->
        <div class="col-md-8 bg-white px-0 px-md-2 mb-4 h-100 shadow">

            <div class="col-12 px-1 px-md-2">
                <div class="row mx-0">
                    <div class="col-6 border-top border-bottom col-md-6 my-3 " style="background-color: #e8e8ea">
                        <p class="small custom-text my-2 text-muted font-weight-bolder" style="letter-spacing: 1px;">
                            Cart
                            Items</p>


                    </div>
                    <div class="col-6 border-top border-bottom col-md-6 my-3 " style="background-color: #e8e8ea">
                        <p class="small custom-text text-muted my-2 font-weight-normal float-right"
                            style="letter-spacing: 1px;"></p>


                    </div>
                </div>
            </div>
            <?php
                $total = 0;
                $shipping = 0;
                $product_shipping_cost = 0;
                $tax = 0;
                
            ?>
            <?php $__currentLoopData = $carts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cartItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $product = \App\Product::find($cartItem['product_id']);
                    $product_stock = $product->stocks->where('product_id', $cartItem['product_id'])->first();
                    $category_id = $product->category_id;
                    $category = \App\Category::select('gst')
                        ->where('id', $category_id)
                        ->first();
                    //$category->gst;
                    $product_shipping_cost = $cartItem->shipping_cost;
                    $gstper = $category->gst;
                    $orignal_price = $cartItem['price'];
                    $gstval = $orignal_price - $orignal_price * (100 / (100 + $gstper));
                    $unit_price = $orignal_price - $gstval;
                    $gst_tax = $gstval;
                    // $tax += $product_shipping_cost * 0.18 * $cartItem->quantity;
                    // $shipping += $product_shipping_cost * $cartItem->quantity;
                    //$vendor_id = $product->user_id;
                    //$gstper = ($category->gst)/100;
                    //$gstval = $cartItem['price'] * $gstper;
                    //$cartItem['price'] = $cartItem['price'] - $gstval;
                    //$cartItem['tax'] = $gstval;
                    $total = $total + ($cartItem['price'] + $cartItem['tax']) * $cartItem['quantity'];
                    $product_name_with_choice = $product->getTranslation('name');
                    if ($cartItem['variation'] != null) {
                        $product_name_with_choice = $product->getTranslation('name') . ' - ' . $cartItem['variation'];
                    }
                    // $totalPrice[] = $item->price * $item->qty;
                ?>

                <div class="col-12 px-0 px-md-0">
                    <div class="row mx-0 py-1 py-md-3">
                        <div class="col-2 bg-white">

                            <a href="<?php echo e(route('product', [$product->slug])); ?>">
                                <img style="max-width: 100%;" class=""
                                    src="<?php echo e(uploaded_asset($product->thumbnail_img)); ?>"
                                    alt="<?php echo e($product->getTranslation('name')); ?>">
                            </a>

                        </div>

                        <div class="col-10 col-md-8 bg-white">

                            <a href="<?php echo e(route('product', [$product->slug])); ?>">
                                <p class="text-dark my-2 custom-text text-truncate-2"><?php echo e($product_name_with_choice); ?>

                                </p>
                            </a>

                            
                            <p class="text-muted small my-2 custom-text">Rs <?php echo e($orignal_price); ?>

                            </p>
                            <div class="row d-block d-md-none">
                                <div class="col-12 col-md-2 bg-white pl-0">
                                    
                                    <?php if($cartItem['digital'] != 1 && $product->auction_product == 0): ?>
                                        <button data-type="minus" style="width:15%;"
                                            data-field="quantity[<?php echo e($cartItem['id']); ?>]"
                                            class="btn btn-sm s-check px-0 btn-dark text-white <?php echo e('decrease-button' . $cartItem['id']); ?>"
                                            onclick="decreaseQuantity(this)" data-id="<?php echo e($cartItem['id']); ?>"><i
                                                class="las la-minus"></i></button>
                                        
                                        <input type="number" style="width: 30px;"
                                            name="quantity[<?php echo e($cartItem['id']); ?>]"
                                            class="my-2 small text-muted custom-text <?php echo e('d-quantity' . $cartItem['id']); ?>"
                                            min="<?php echo e($product->min_qty); ?>" max="<?php echo e($product_stock->qty); ?>"
                                            value="<?php echo e($cartItem['quantity']); ?>" readonly >
                                        <button data-field="quantity[<?php echo e($cartItem['id']); ?>]" style="width:15%;"
                                            class=" my-md-0 btn btn-sm px-0 s-check btn-dark text-white <?php echo e('increase-button' . $cartItem['id']); ?>"
                                            data-type="plus" data-id="<?php echo e($cartItem['id']); ?>"
                                            onclick="increaseQuantity(this)"><i class="las la-plus"></i>
                                        </button>
                                    <?php elseif($product->auction_product == 1): ?>
                                        <span class="fw-600 fs-16">Qty: 1</span>
                                    <?php endif; ?>

                                </div>

                            </div>
                            <a onclick="removeFromCartView(event, <?php echo e($cartItem['id']); ?>)">
                                <p class="text-danger small my-2 custom-text">Remove Product</p>
                            </a>


                        </div>

                        <div class="ml-auto col-6 col-md-2 bg-white d-none d-md-block">
                            
                            <?php if($cartItem['digital'] != 1 && $product->auction_product == 0): ?>
                                <button data-type="minus" style="width:30%;"
                                    data-field="quantity[<?php echo e($cartItem['id']); ?>]"
                                    class="btn btn-sm s-check  btn-dark text-white <?php echo e('decrease-button' . $cartItem['id']); ?>"
                                    onclick="decreaseQuantity(this)" data-id="<?php echo e($cartItem['id']); ?>"><i
                                        class="las la-minus"></i></button>
                                
                                <input type="number" style="width: 30px;" name="quantity[<?php echo e($cartItem['id']); ?>]"
                                    class="my-2 small text-muted custom-text <?php echo e('d-quantity' . $cartItem['id']); ?>"
                                    min="<?php echo e($product->min_qty); ?>" max="<?php echo e($product_stock->qty); ?>"
                                    value="<?php echo e($cartItem['quantity']); ?>" readonly >
                                <button data-field="quantity[<?php echo e($cartItem['id']); ?>]" style="width:30%;"
                                    class=" my-md-0 btn btn-sm s-check btn-dark text-white <?php echo e('increase-button' . $cartItem['id']); ?>"
                                    data-type="plus" data-id="<?php echo e($cartItem['id']); ?>"
                                    onclick="increaseQuantity(this)"><i class="las la-plus"></i>
                                </button>
                            <?php elseif($product->auction_product == 1): ?>
                                <span class="fw-600 fs-16">Qty: 1</span>
                            <?php endif; ?>

                        </div>

                    </div>
                </div>
                <hr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>

        <!-- products cards -->
        <div class="col-md-4 p-0 px-0 px-md-4 my-4 my-md-0 ">

            <div class="card shadow mx-0 mx-md-4 border-0 rounded-0 w-100 sticky-top" style="z-index:1!important;">
                <div class="card-body">
                    <div class="col-12 p-0">
                        <div class="row my-2">
                            <div class="col-6 small text-muted custom-text">Subtotal</div>
                            <div class="col-6 custom-text small text-muted text-right d-sub-total">
                                <?php echo e(single_price($total)); ?></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6 custom-text small text-muted">Shipping</div>
                            <div class="col-6 custom-text small text-muted text-right"><?php echo e(single_price($shipping)); ?>

                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6 custom-text small text-muted">Tax</div>
                            <div
                                class="col-6 custom-text small text-muted text-right d-grand-total">
                                <?php echo e(single_price($tax)); ?>

                            </div>
                        </div>
                        <?php
                            $grandTotal = $total + $shipping + $tax;
                            // dump($grandTotal);
                        ?>
                        <div class="row my-2">
                            <div class="col-6 custom-text small text-muted font-weight-bolder">Grand Total</div>
                            <div class="col-6 custom-text small text-muted text-right font-weight-bolder d-grand-total">
                                 <?php echo e(single_price($grandTotal)); ?>

                            </div>
                        </div>
                        <input type="hidden" name="" class="grand-tot" value="<?php echo e(single_price($grandTotal)); ?>">

                        <hr>
                        <div class="row my-1">
                            <div class="col-12">
                                <?php if(Auth::check()): ?>
                                    <a href="<?php echo e(route('checkout.view_checkout')); ?>"
                                        class="btn btn-dark fw-600 float-right">
                                        <?php echo e(translate('Continue to Shipping')); ?>

                                    </a>
                                <?php else: ?>
                                    
                                    <div class="btn-group mt-2 d-flex justify-content-center">
                                        <a class="btn btn-sm rounded-0 custom-text btn-outline-dark  mt-2 a-hov-ef slide-me-down"
                                            data-bs-toggle="modal" data-bs-target="#login-modal">Login / Register </a>
                                    </div>
                                    <div class="btn-group mt-1 d-flex justify-content-center">
                                        <a href="<?php echo e(route('user.guestRegistration')); ?>"
                                            class="btn btn-sm rounded-0 custom-text btn-outline-dark a-hov-ef mt-2 slide-me-down">Checkout
                                            as guest</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>
</div>

<script type="text/javascript">
    AIZ.extra.plusMinus();
</script>
<?php /**PATH /var/www/sadar24_aws/resources/views/frontend/partials/cart_details.blade.php ENDPATH**/ ?>