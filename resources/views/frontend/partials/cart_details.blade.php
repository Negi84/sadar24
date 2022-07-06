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
                            style="letter-spacing: 1px;">{{-- Delivery by Jan 29–Feb 4 --}}</p>


                    </div>
                </div>
            </div>
            @php
                $total = 0;
                $shipping = 0;
                $product_shipping_cost = 0;
                $tax = 0;
                
            @endphp
            @foreach ($carts as $key => $cartItem)
                @php
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
                @endphp

                <div class="col-12 px-0 px-md-0">
                    <div class="row mx-0 py-1 py-md-3">
                        <div class="col-2 bg-white">

                            <a href="{{ route('product', [$product->slug]) }}">
                                <img style="max-width: 100%;" class=""
                                    src="{{ uploaded_asset($product->thumbnail_img) }}"
                                    alt="{{ $product->getTranslation('name') }}">
                            </a>

                        </div>

                        <div class="col-10 col-md-8 bg-white">

                            <a href="{{ route('product', [$product->slug]) }}">
                                <p class="text-dark my-2 custom-text text-truncate-2">{{ $product_name_with_choice }}
                                </p>
                            </a>

                            {{-- <p class="text-muted small my-2 custom-text">Saved Size: {{ $item->size }}</p> --}}
                            <p class="text-muted small my-2 custom-text">Rs {{ $orignal_price }}
                            </p>
                            <div class="row d-block d-md-none">
                                <div class="col-12 col-md-2 bg-white pl-0">
                                    {{-- Decrease quantity button --}}
                                    @if ($cartItem['digital'] != 1 && $product->auction_product == 0)
                                        <button data-type="minus" style="width:15%;"
                                            data-field="quantity[{{ $cartItem['id'] }}]"
                                            class="btn btn-sm s-check px-0 btn-dark text-white {{ 'decrease-button' . $cartItem['id'] }}"
                                            onclick="decreaseQuantity(this)" data-id="{{ $cartItem['id'] }}"><i
                                                class="las la-minus"></i></button>
                                        {{-- Increase quantity button --}}
                                        <input type="number" style="width: 30px;"
                                            name="quantity[{{ $cartItem['id'] }}]"
                                            class="my-2 small text-muted custom-text {{ 'd-quantity' . $cartItem['id'] }}"
                                            min="{{ $product->min_qty }}" max="{{ $product_stock->qty }}"
                                            value="{{ $cartItem['quantity'] }}" readonly {{-- onchange="updateQuantity({{ $cartItem['id'] }}, this)" --}}>
                                        <button data-field="quantity[{{ $cartItem['id'] }}]" style="width:15%;"
                                            class=" my-md-0 btn btn-sm px-0 s-check btn-dark text-white {{ 'increase-button' . $cartItem['id'] }}"
                                            data-type="plus" data-id="{{ $cartItem['id'] }}"
                                            onclick="increaseQuantity(this)"><i class="las la-plus"></i>
                                        </button>
                                    @elseif($product->auction_product == 1)
                                        <span class="fw-600 fs-16">Qty: 1</span>
                                    @endif

                                </div>

                            </div>
                            <a onclick="removeFromCartView(event, {{ $cartItem['id'] }})">
                                <p class="text-danger small my-2 custom-text">Remove Product</p>
                            </a>


                        </div>

                        <div class="ml-auto col-6 col-md-2 bg-white d-none d-md-block">
                            {{-- Decrease quantity button --}}
                            @if ($cartItem['digital'] != 1 && $product->auction_product == 0)
                                <button data-type="minus" style="width:30%;"
                                    data-field="quantity[{{ $cartItem['id'] }}]"
                                    class="btn btn-sm s-check  btn-dark text-white {{ 'decrease-button' . $cartItem['id'] }}"
                                    onclick="decreaseQuantity(this)" data-id="{{ $cartItem['id'] }}"><i
                                        class="las la-minus"></i></button>
                                {{-- Increase quantity button --}}
                                <input type="number" style="width: 30px;" name="quantity[{{ $cartItem['id'] }}]"
                                    class="my-2 small text-muted custom-text {{ 'd-quantity' . $cartItem['id'] }}"
                                    min="{{ $product->min_qty }}" max="{{ $product_stock->qty }}"
                                    value="{{ $cartItem['quantity'] }}" readonly {{-- onchange="updateQuantity({{ $cartItem['id'] }}, this)" --}}>
                                <button data-field="quantity[{{ $cartItem['id'] }}]" style="width:30%;"
                                    class=" my-md-0 btn btn-sm s-check btn-dark text-white {{ 'increase-button' . $cartItem['id'] }}"
                                    data-type="plus" data-id="{{ $cartItem['id'] }}"
                                    onclick="increaseQuantity(this)"><i class="las la-plus"></i>
                                </button>
                            @elseif($product->auction_product == 1)
                                <span class="fw-600 fs-16">Qty: 1</span>
                            @endif

                        </div>

                    </div>
                </div>
                <hr>
            @endforeach

        </div>

        <!-- products cards -->
        <div class="col-md-4 p-0 px-0 px-md-4 my-4 my-md-0 ">

            <div class="card shadow mx-0 mx-md-4 border-0 rounded-0 w-100 sticky-top" style="z-index:1!important;">
                <div class="card-body">
                    <div class="col-12 p-0">
                        <div class="row my-2">
                            <div class="col-6 small text-muted custom-text">Subtotal</div>
                            <div class="col-6 custom-text small text-muted text-right d-sub-total">
                                {{ single_price($total) }}</div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6 custom-text small text-muted">Shipping</div>
                            <div class="col-6 custom-text small text-muted text-right">{{ single_price($shipping) }}
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6 custom-text small text-muted">Tax</div>
                            <div
                                class="col-6 custom-text small text-muted text-right d-grand-total">
                                {{ single_price($tax) }}
                            </div>
                        </div>
                        @php
                            $grandTotal = $total + $shipping + $tax;
                            // dump($grandTotal);
                        @endphp
                        <div class="row my-2">
                            <div class="col-6 custom-text small text-muted font-weight-bolder">Grand Total</div>
                            <div class="col-6 custom-text small text-muted text-right font-weight-bolder d-grand-total">
                                 {{ single_price($grandTotal) }}
                            </div>
                        </div>
                        <input type="hidden" name="" class="grand-tot" value="{{ single_price($grandTotal) }}">

                        <hr>
                        <div class="row my-1">
                            <div class="col-12">
                                @if (Auth::check())
                                    <a href="{{ route('checkout.view_checkout') }}"
                                        class="btn btn-dark fw-600 float-right">
                                        {{ translate('Continue to Shipping') }}
                                    </a>
                                @else
                                    {{-- <div class="btn-group mt-2 d-flex justify-content-center">
                                            <a href="{{ route('checkout.view_checkout') }}"
                                            class="btn btn-dark fw-600">
                                            {{ translate('Continue to Shipping') }}
                                        </a>
                                        </div> --}}
                                    <div class="btn-group mt-2 d-flex justify-content-center">
                                        <a class="btn btn-sm rounded-0 custom-text btn-outline-dark  mt-2 a-hov-ef slide-me-down"
                                            data-bs-toggle="modal" data-bs-target="#login-modal">Login / Register </a>
                                    </div>
                                    <div class="btn-group mt-1 d-flex justify-content-center">
                                        <a href="{{ route('user.guestRegistration') }}"
                                            class="btn btn-sm rounded-0 custom-text btn-outline-dark a-hov-ef mt-2 slide-me-down">Checkout
                                            as guest</a>
                                    </div>
                                @endif
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
