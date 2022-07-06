<?php $__env->startSection('content'); ?>
    <section class="mb-4" id="cart-summary">
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
                            // dump($cartItem);
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
                                        <p class="text-dark my-2 custom-text text-truncate-2">
                                            <?php echo e($product_name_with_choice); ?></p>
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
                                    <div class="col-6 custom-text small text-muted text-right">
                                        <?php echo e(single_price($shipping)); ?></div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-6 custom-text small text-muted">Tax</div>
                                    <div class="col-6 custom-text small text-muted text-right d-grand-total">
                                        <?php echo e(single_price($tax)); ?>

                                    </div>
                                </div>
                                <?php
                                    $grandTotal = $total + $shipping + $tax;
                                    // dump($grandTotal);
                                ?>
                                <div class="row my-2">
                                    <div class="col-6 custom-text small text-muted font-weight-bolder">Grand Total</div>
                                    <div
                                        class="col-6 custom-text small text-muted text-right font-weight-bolder d-grand-total">
                                        <?php echo e(single_price($grandTotal)); ?>

                                    </div>
                                </div>

                                <input type="hidden" name="" class="grand-tot"
                                    value="<?php echo e(single_price($grandTotal)); ?>">

                                <hr>
                                <div class="row my-1">
                                    <div class="col-12 text-right pr-0">
                                        <!-- <a href="checkout.php" class="btn btn-block rounded-0 custom-text text-white py-2 mt-2 s-check">SECURE CHECKOUT &#8594;</a> -->
                                        <?php if(Auth::check()): ?>
                                            <a href="<?php echo e(route('checkout.view_checkout')); ?>" class="btn btn-dark fw-600">
                                                <?php echo e(translate('Continue to Shipping')); ?>

                                            </a>
                                        <?php else: ?>
                                            
                                            <div class="btn-group mt-2 d-flex justify-content-center">
                                                <a class="btn btn-sm rounded-0 custom-text btn-outline-dark  mt-2 a-hov-ef slide-me-down"
                                                    data-bs-toggle="modal" data-bs-target="#login-modal">Login / Register
                                                </a>
                                            </div>
                                            <div class="btn-group mt-1 d-flex justify-content-center">
                                                <a href="<?php echo e(route('checkout.view_checkout')); ?>"
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
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal'); ?>
    <div class="modal" id="login-modal">
        <div class="modal-dialog modal-dialog-zoom">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="h4 fw-600"><?php echo e(translate('Login to your account.')); ?></h6>
                    <button type="button" class="close" data-bs-dismiss="modal">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="p-3">
                        <form class="form-default" role="form" action="<?php echo e(route('user.mobilelogin')); ?>" method="POST">
                            <?php echo csrf_field(); ?>

                            <div class="form-group phone-form-group mb-1">
                                <input type="tel" id="phone-code"
                                    class="form-control<?php echo e($errors->has('phone') ? ' is-invalid' : ''); ?>" name="phone"
                                    value="<?php echo e(old('phone')); ?>" placeholder="Enter Phone Number" name="phone"
                                    autocomplete="off">
                            </div>
                            <?php if(session('errors')): ?>
                                <?php
                                    flash(translate('The phone format is invalid. The phone must be 10 digits. !!!'))->error();
                                ?>
                            <?php endif; ?>
                            <div class="mb-5">
                                <button type="submit"
                                    class="btn btn-primary btn-block fw-600"><?php echo e(translate('Login')); ?></button>
                            </div>
                        </form>

                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <div class="text-center mb-3">
                                <p class="text-muted mb-0"><?php echo e(translate('Checkout as')); ?></p>
                                <a href="<?php echo e(route('user.guestRegistration')); ?>"><?php echo e(translate('Guest')); ?></a>
                            </div>
                        </div>
                        <div class="col-6 text-right">
                            <div class="text-center mb-3">
                                <p class="text-muted mb-0"><?php echo e(translate('Dont have an account?')); ?></p>
                                <a href="<?php echo e(route('user.registration')); ?>"><?php echo e(translate('Register Now')); ?></a>
                            </div>
                        </div>
                    </div>


                    <div class="separator mb-3">
                        <span class="bg-white px-3 opacity-60"><?php echo e(translate('Or Login With')); ?></span>

                    </div>
                    <div class="mb-3 text-center">
                        <a href="<?php echo e(route('user.login')); ?>"
                            class="btn btn-primary fw-600"><?php echo e(translate('Email ID & Password')); ?></a>
                    </div>
                    <?php if(get_setting('google_login') == 1 || get_setting('facebook_login') == 1 || get_setting('twitter_login') == 1): ?>
                        <div class="separator mb-3">
                            <span class="bg-white px-3 opacity-60"><?php echo e(translate('Or Login With')); ?></span>
                        </div>
                        <ul class="list-inline social colored text-center mb-3">
                            <?php if(get_setting('facebook_login') == 1): ?>
                                <li class="list-inline-item">
                                    <a href="<?php echo e(route('social.login', ['provider' => 'facebook'])); ?>"
                                        class="facebook">
                                        <i class="lab la-facebook-f"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(get_setting('google_login') == 1): ?>
                                <li class="list-inline-item">
                                    <a href="<?php echo e(route('social.login', ['provider' => 'google'])); ?>"
                                        class="google">
                                        <i class="lab la-google"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(get_setting('twitter_login') == 1): ?>
                                <li class="list-inline-item">
                                    <a href="<?php echo e(route('social.login', ['provider' => 'twitter'])); ?>"
                                        class="twitter">
                                        <i class="lab la-twitter"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    
    <?php
    $ids = [];
    ?>
    <?php $__currentLoopData = $carts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            array_push($ids, $item->id);
            // dd($carts );
            // dd($cart_items);
        ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php
        $cart_items = [];
            foreach($carts as $index=>$item){
                $cart_items[] = [
                        "id"=> $item->product_id,
                        "name"=> DB::table('products')->where('id',$item->product_id)->pluck('name')->first(),
                        "list_name"=> "cart",
                        "brand"=> "Sadar24",
                        "category"=> DB::table('categories')->where('id',DB::table('products')->where('id',$item->product_id)->pluck('category_id')->first())->pluck('name')->first(),
                        "variant"=> $item->variation,
                        "list_position"=> $index,
                        "quantity"=> $item->quantity,
                        "price"=> $item->price,
                ];
            }
    ?>
    <script>
        fbq('track', 'AddToCart', {
            content_type: 'product',
            value: "<?php echo e(round($grandTotal)); ?>",
            currency: 'INR',
            content_ids: <?php echo e(json_encode($ids)); ?>

        });

        gtag('event', 'add_to_cart', {
  "items": <?php echo json_encode($cart_items); ?>,
});
    </script>
    

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
		<?php	
			if(Auth::check()){
				$user_details = array(
					'email'=> Auth::user()->email,
					'phone'=> Auth::user()->phone,
					'fullName'=>  Auth::user()->name,			
				);				
				$event_name = 'identify';
				wigzo_identify($event_name, $user_details);
			}	
			function wigzo_identify($event, $data ){
				echo '<script>';
				echo 'wigzo('.'"'.strval($event).'"'.', '. json_encode( $data ) .')';
				echo '</script>';
			}
		?>

    <script type="text/javascript">
        function removeFromCartView(e, key) {
            e.preventDefault();
            removeFromCart(key);
        }

        function updateQuantity(key, element) {
            console.log(key, element);
            $.post('<?php echo e(route('cart.updateQuantity')); ?>', {
                _token: AIZ.data.csrf,
                id: key,
                quantity: element
            }, function(data) {
                // console.log(data);
                updateNavCart(data.nav_cart_view, data.cart_count);
                $('#cart-summary').html(data.cart_view);
            });
        }

        function showCheckoutModal() {
            $('#login-modal').modal("show");
            // var modalToggle = document.getElementById('login-modal')
            // myModal.show()
        }

        function increaseQuantity(e) {
            // console.log(e.attr('data-type').value);

            q = $(e).siblings("input").attr("value");
            c = $(e).siblings("input").attr("max");
            // console.log(q,$(e).siblings("input").attr("max"));
            // console.log(parseInt(q) < parseInt(c));

            if (parseInt(q) < parseInt(c)) {
                $(e).siblings("input").attr("value", ++q);
                updateQuantity($(e).attr("data-id"), $(e).siblings("input").val());
            }
        }

        function decreaseQuantity(e) {
            console.log($(e).attr("data-id"));
            q = $(e).siblings("input").attr("value");
            if (q > $(e).siblings("input").attr("min")) {
                $(e).siblings("input").attr("value", --q);
                updateQuantity($(e).attr("data-id"), $(e).siblings("input").val());
            }


        }
    </script>
    <script type="text/javascript">
        function loginRegisterBtn() {

            $('.slide-me-down').slideToggle(1000);

        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sadar24_aws/resources/views/frontend/view_cart.blade.php ENDPATH**/ ?>