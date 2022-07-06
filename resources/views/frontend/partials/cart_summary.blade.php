<div class="card-body">
    @php
    $contents = [];
    @endphp
    @foreach ($carts as $key => $item)
        @php
            $contents[] = [
                'id' => $item['id'],
                'quantity' => $item['quantity'],
            ];
        @endphp
    @endforeach
    <div class="col-12 p-0">
        <div class="row ">
            <div class="col-12 border-bottom py-2 px-0">
                <p class="text-muted custom-text font-weight-bolder small" style="letter-spacing: 1px;">ORDER DETAILS </p>
            </div>
        </div>
        <form class="form-default" action="{{ route('checkout.store_delivery_info') }}" id="delivery_info"
            role="form" method="POST">
            @csrf
            @php
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
                // $shipping_region = $shipping_info['city'];
                $gstper = 0;
                $gstval = 0;
            @endphp

            @if (!empty($admin_products))
                <div class="card mb-3 shadow-sm border-0 rounded">
                    {{-- <div class="card-header p-0">
                        <h5 class="fs-16 fw-600 mb-0">{{ get_setting('site_name') }} {{ translate('Products') }}</h5>
                    </div> --}}
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @foreach ($admin_products as $key => $cartItem)                                
                                @php
                                    $product = \App\Product::find($cartItem->product_id);
                                    $category_id = $product->category_id;
                                    $category = \App\Category::select('gst')->where('id', $category_id)->first();
                                    $subtotal += ($cartItem->price - $gstval) * $cartItem->quantity;
                                    $tax += $cartItem->tax * $cartItem->quantity; 
                                    $shipping += $cartItem->shipping_cost * $cartItem->quantity;                                    
                                    $product_name_with_choice = $product->getTranslation('name');
                                    if ($cartItem->variant != null) {
                                        $product_name_with_choice = $product->getTranslation('name') . ' - ' . $cartItem->variant;
                                    }                                   
                                    $vendor_id = $product['user_id'];
                                    $address_id = $cartItem->address_id;                                    
                                    $address = \App\Address::select('state')->where('id', $address_id)->first();
                                    $vendor = \App\User::select('state')->where('id', $vendor_id)->first();                                    
                                @endphp
                                <li class="list-group-item px-0">
                                    <div class="row py-1">

                                        <div class="col-3">
                                            <img src="{{ uploaded_asset($product->thumbnail_img) }}" alt="{{ $product->getTranslation('name') }}" style="max-width: 100%;">
                                        </div>
                                        <div class="col-5 ">
                                            <p class="small text-muted custom-right-text text-truncate-2">{{ $product_name_with_choice }}</p>
                                        </div>
                                        <div class="col-4 ">
                                            <p class="small text-right text-muted custom-right-text  mb-0">
                                                {{ single_price(($cartItem['price'] - $gstval) * $cartItem['quantity']) }}
                                            </p>
                                            <p class="small text-muted text-right custom-right-text">Qty: {{ $cartItem->quantity }}</p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                        <div class="row pt-1 d-none">
                            <div class="col-md-12 px-0">
                                <h6 class="fs-14 fw-600">{{ translate('Choose Delivery Type') }}</h6>
                            </div>
                            <div class="col-md-12 px-0">
                                <div class="row gutters-5">
                                    <div class="col-6">
                                        <label class="aiz-megabox d-block bg-white mb-0">
                                            <input type="radio" name="shipping_type_{{ \App\User::where('user_type', 'admin')->first()->id }}"
                                                value="home_delivery" onchange="show_pickup_point(this)" data-bs-target=".pickup_point_id_admin" checked>
                                            <span class="d-flex py-2 px-1 aiz-megabox-elem">
                                                <span class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                                <span class="flex-grow-1 pl-3 fw-600">{{ translate('Home Delivery') }}</span>
                                            </span>
                                        </label>
                                    </div>
                                    @if (\App\BusinessSetting::where('type', 'pickup_point')->first()->value == 1)
                                        <div class="col-6">
                                            <label class="aiz-megabox d-block bg-white mb-0">
                                                <input type="radio" name="shipping_type_{{ \App\User::where('user_type', 'admin')->first()->id }}"
                                                    value="pickup_point" onchange="show_pickup_point(this)"
                                                    data-bs-target=".pickup_point_id_admin">
                                                <span class="d-flex py-2 px-1 aiz-megabox-elem">
                                                    <span class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                                    <span
                                                        class="flex-grow-1 pl-3 fw-600">{{ translate('Local Pickup') }}</span>
                                                </span>
                                            </label>
                                        </div>
                                    @endif
                                </div>
                                <div class="mt-4 pickup_point_id_admin d-none">
                                    <select class="form-control aiz-selectpicker"
                                        name="pickup_point_id_{{ \App\User::where('user_type', 'admin')->first()->id }}"
                                        data-live-search="true">
                                        <option>{{ translate('Select your nearest pickup point') }}</option>
                                        @foreach (\App\PickupPoint::where('pick_up_status', 1)->get() as $key => $pick_up_point)
                                            <option value="{{ $pick_up_point->id }}" data-content="<span class='d-block'>
													<span class='d-block fs-16 fw-600 mb-2'>{{ $pick_up_point->getTranslation('name') }}</span>
													<span class='d-block opacity-50 fs-12'><i class='las la-map-marker'></i> {{ $pick_up_point->getTranslation('address') }}</span>
													<span class='d-block opacity-50 fs-12'><i class='las la-phone'></i>{{ $pick_up_point->phone }}</span>
												</span>">
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @endif
            @if (!empty($seller_products))
                @foreach ($seller_products as $key => $seller_product)
                    <div class="card mb-3 shadow-sm border-0 rounded">
                        {{-- <div class="card-header p-0">
                            <h5 class="fs-16 fw-600 mb-0">{{ \App\Shop::where('user_id', $key)->first()->name }}
                                {{ translate('Products') }}</h5>
                        </div> --}}
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @foreach ($seller_product as $cartItem)                                   
                                    @php
                                        $product = \App\Product::find($cartItem->product_id);
                                        $category_id = $product->category_id;
                                        $category = \App\Category::select('gst')->where('id', $category_id)->first();                                        
                                        $subtotal += ($cartItem->price - $gstval) * $cartItem->quantity;
                                        $tax += $cartItem->tax * $cartItem->quantity;                                        
                                        $shipping += $cartItem->shipping_cost * $cartItem->quantity;                                        
                                        $product_name_with_choice = $product->getTranslation('name');
                                        if ($cartItem->variant != null) {
                                            $product_name_with_choice = $product->getTranslation('name') . ' - ' . $cartItem->variant;
                                        }
                                        $vendor_id = $product['user_id'];
                                        $address_id = $cartItem->address_id;
                                        $address = \App\Address::select('state')->where('id', $address_id)->first();
                                        $vendor = \App\User::select('state')->where('id', $vendor_id)->first();                                        
                                    @endphp
                                    <li class="list-group-item px-0">
                                        <div class="row py-1">

                                            <div class="col-3">
                                                <img src="{{ uploaded_asset($product->thumbnail_img) }}" alt="{{ $product->getTranslation('name') }}" style="max-width: 100%;">
                                            </div>
                                            <div class="col-5 ">
                                                <p class="small text-muted custom-right-text  text-truncate-2">{{ $product_name_with_choice }}</p>
                                            </div>
                                            <div class="col-4 ">
                                                <p class="small text-right text-muted custom-right-text mb-0">
                                                    {{ single_price(($cartItem['price'] - $gstval) * $cartItem['quantity']) }}
                                                </p>
                                                <p class="small text-muted text-right custom-right-text">Qty: {{ $cartItem->quantity }}</p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="row pt-1 d-none">
                                <div class="col-md-12">
                                    <h6 class="fs-14 fw-600">{{ translate('Choose Delivery Type') }}</h6>
                                </div>
                                <div class="col-md-12">
                                    <div class="row gutters-5">
                                        <div class="col-6">
                                            <label class="aiz-megabox d-block bg-white mb-0">
                                                <input type="radio" name="shipping_type_{{ $key }}"
                                                    value="home_delivery" onchange="show_pickup_point(this)"
                                                    data-bs-target=".pickup_point_id_{{ $key }}" checked>
                                                <span class="d-flex py-2 px-1 aiz-megabox-elem">
                                                    <span class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                                    <span
                                                        class="flex-grow-1 pl-3 fw-600">{{ translate('Home Delivery') }}</span>
                                                </span>
                                            </label>
                                        </div>
                                        @if (\App\BusinessSetting::where('type', 'pickup_point')->first()->value == 1)
                                            @if (is_array(json_decode(\App\Shop::where('user_id', $key)->first()->pick_up_point_id)))
                                                <div class="col-6">
                                                    <label class="aiz-megabox d-block bg-white mb-0">
                                                        <input type="radio" name="shipping_type_{{ $key }}"
                                                            value="pickup_point" onchange="show_pickup_point(this)"
                                                            data-bs-target=".pickup_point_id_{{ $key }}">
                                                        <span class="d-flex py-2 px-1 aiz-megabox-elem">
                                                            <span class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                                            <span
                                                                class="flex-grow-1 pl-3 fw-600">{{ translate('Local Pickup') }}</span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                    @if (\App\BusinessSetting::where('type', 'pickup_point')->first()->value == 1)
                                        @if (is_array(json_decode(\App\Shop::where('user_id', $key)->first()->pick_up_point_id)))
                                            <div class="mt-4 pickup_point_id_{{ $key }} d-none">
                                                <select class="form-control aiz-selectpicker"
                                                    name="pickup_point_id_{{ $key }}" data-live-search="true">
                                                    <option>{{ translate('Select your nearest pickup point') }}
                                                    </option>
                                                    @foreach (json_decode(\App\Shop::where('user_id', $key)->first()->pick_up_point_id) as $pick_up_point)
                                                        @if (\App\PickupPoint::find($pick_up_point) != null)
                                                            <option
                                                                value="{{ \App\PickupPoint::find($pick_up_point)->id }}"
                                                                data-content="<span class='d-block'>
                                                                        <span class='d-block fs-16 fw-600 mb-2'>{{ \App\PickupPoint::find($pick_up_point)->getTranslation('name') }}</span>
                                                                        <span class='d-block opacity-50 fs-12'><i class='las la-map-marker'></i> {{ \App\PickupPoint::find($pick_up_point)->getTranslation('address') }}</span>
                                                                        <span class='d-block opacity-50 fs-12'><i class='las la-phone'></i> {{ \App\PickupPoint::find($pick_up_point)->phone }}</span>
                                                                    </span>">
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            @endif
            {{-- <div class="pt-4 d-flex justify-content-between align-items-center">
                <a href="{{ route('home') }}">
                    <i class="la la-angle-left"></i>
                    {{ translate('Return to shop') }}
                </a>
                <button type="submit" class="btn fw-600 btn-primary">{{ translate('Continue to Payment') }}</button>
            </div> --}}
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
                {{ single_price($subtotal) }}</div>
        </div>

        <div class="row my-2">
            <div class="col-6 custom-right-text small text-muted">Shipping</div>
            <div class="col-6 custom-right-text small text-muted text-right">
                {{ single_price($shipping) }}</div>
        </div>

        <div class="row my-2">
            <div class="col-6 custom-right-text small text-muted">Tax</div>
            <div class="col-6 custom-right-text small text-muted text-right">
                {{ single_price($tax) }}</div>
        </div>
        @if (Session::has('club_point'))
            <div class="row my-2">
                <div class="col-6 custom-right-text small text-muted">Redeem point</div>
                <div class="col-6 custom-right-text small text-muted text-right">
                    {{ single_price(Session::get('club_point')) }}</div>
            </div>
        @endif
        @if (addon_is_activated('club_point'))
            @if (Session::has('club_point'))
                <div class="row my-2 credit-container" style="display: none;">
                    <form class="" action="{{ route('checkout.remove_club_point') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="input-group">
                            <div class="col-6 custom-right-text small text-danger">Club Points
                            </div>
                            <div class="col-6">
                                <p class=" custom-right-text small text-danger text-right credit-discount-amount">
                                    {{ Session::get('club_point') }}</p>
                            </div>
                            <div class="input-group-append">
                                <button type="submit"
                                    class="btn btn-primary">{{ translate('Remove Redeem Point') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
        @endif
        {{-- @if (Session::has('club_point'))
            <tr class="cart-shipping">
                <th>{{ translate('Redeem point') }}</th>
                <td class="text-right">
                    <span class="font-italic">{{ single_price(Session::get('club_point')) }}</span>
                </td>
            </tr>
        @endif --}}

        {{-- @if ($carts->sum('discount') > 0)
        <tr class="cart-shipping">
            <th>{{translate('Coupon Discount')}}</th>
            <td class="text-right">
                <span class="font-italic">{{ single_price($carts->sum('discount')) }}</span>
            </td>
        </tr>
    @endif --}}
        @if (Session::has('club_point'))
            <div class="row my-2 discount-container">
                <div class="col-6 custom-right-text small ">{{ translate('Redeem point') }}</div>
                <div class="col-6 custom-right-text small  text-right discount-amount">
                    {{ single_price(Session::get('club_point')) }}
                </div>
            </div>
        @endif
        @if ($carts->sum('discount') > 0)
            <div class="row my-2 discount-container">
                <div class="col-6 custom-right-text small ">Discount via Coupon</div>
                <div class="col-6 custom-right-text small  text-right discount-amount">
                    {{ single_price($carts->sum('discount')) }}
                </div>
            </div>
        @endif
        @if (Auth::check() && get_setting('coupon_system') == 1)
            @if ($carts[0]['discount'] > 0)
                <div class="mt-3 bef-pay-hide">
                    <form class="" id="remove-coupon-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="owner_id" value="{{ $carts[0]['owner_id'] }}">
                        <div class="input-group">
                            <div class="form-control">{{ $carts[0]['coupon_code'] }}</div>
                            <button type="button" id="coupon-remove"
                                class="btn btn-sm text-right s-check text-white btn-dark custom-right-text small w-auto">Remove
                                Coupon</button>
                        </div>
                        {{-- <div class="input-group">
                            <div class="form-control">{{ $carts[0]['coupon_code'] }}</div>
                            <div class="input-group-append">
                                <button type="button" id="coupon-remove"
                                    class="btn btn-primary">{{ translate('Change Coupon') }}</button>
                            </div>
                        </div> --}}
                    </form>
                </div>
            @else
                <div class="mt-3 bef-pay-hide">
                    <form class="" id="apply-coupon-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="owner_id" value="{{ $carts[0]['owner_id'] }}">
                        <div class="input-group">
                            <input title="Discount Coupon" type="text" onkeydown="return event.key != 'Enter';"
                                placeholder="{{ translate('Have coupon code? Enter here') }}"
                                class="small custom-right-text rounded-0 border-top-0 border-right-0 border-left-0 form-control h-75 float-right coupon-code"
                                name="code" placeholder="Enter Coupon Code" required />
                            <button type="button" id="coupon-apply"
                                class="btn btn-sm text-right s-check text-white btn-dark custom-right-text small w-auto">Apply</button>
                        </div>
                    </form>
                </div>
            @endif
        @endif
    </div>

    <div class="row mt-3">
        <div class="col-6 ">
            <p class="custom-right-text small text-muted font-weight-bolder">Grand Total</p>
        </div>
        @php
            $total = $subtotal + $tax + $shipping;
            if (Session::has('club_point')) {
                $total -= Session::get('club_point');
            }
            if ($carts->sum('discount') > 0) {
                $total -= $carts->sum('discount');
            }
        @endphp
        <div class="col-6 pr-0">
            <p class="custom-right-text small text-muted text-right font-weight-bolder grand-amount-after-discount">
                {{ single_price($total) }}
            </p>
            <p style="font-size: 9px;" class="text-muted text-right font-weight-bolder">
                Inclusive of all taxes
            </p>
            @if (Auth::check())
                <button type="button" onclick="showPayment(this)"
                    class="btn btn-sm text-right btn-dark s-check text-white custom-right-text small w-auto float-right bef-pay-hide">Continue
                    &#8594;</button>
            @endif
        </div>
    </div>
</div>
<script>
    fbq('track', 'InitiateCheckout', {
        content_type: 'product',
        contents: <?php echo json_encode($contents); ?>,
        value: {{ $total }},
        currency: 'INR'
    });
</script>
<script>
    fbq('track', 'AddPaymentInfo');
</script>
