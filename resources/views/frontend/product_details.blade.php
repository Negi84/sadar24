@extends('frontend.layouts.app')

@section('meta_title'){{ $detailedProduct->meta_title }}@stop

@section('meta_description'){{ $detailedProduct->description }}@stop

@section('meta_keywords'){{ $detailedProduct->tags }}@stop

@section('meta')
    <!-- Schema.org markup for Google+ -->
    {{-- <meta itemprop="name" content="{{ $detailedProduct->meta_title }}">
    <meta itemprop="description" content="{{ $detailedProduct->description }}">
    <meta itemprop="image" content="{{ uploaded_asset($detailedProduct->meta_img) }}"> --}}

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="{{ $detailedProduct->meta_title }}">
    <meta name="twitter:description" content="{{ strip_tags($detailedProduct->description) }}">
    <meta name="twitter:creator" content="@author_handle">
    <meta name="twitter:image" content="{{ uploaded_asset($detailedProduct->meta_img) }}">
    <meta name="twitter:data1" content="{{ $detailedProduct->unit_price }}">
    <meta name="twitter:label1" content="Price">
    <style>
        .line-through {
            text-decoration: line-through;
        }
        #tab_default_1 div div ul {
            margin-left: 16px;
        }
        #product_details_ul ul {
            margin-left: 16px;
        }
        .zoom {
            display: inline-block;
            position: relative;
        }
        /* magnifying glass icon */
        .zoom:after {
            content: '';
            display: block;
            width: 33px;
            height: 33px;
            position: absolute;
            top: 0;
            right: 0;
            background: url(icon.png);
        }
        .zoom img {
            display: block;
        }
        .zoom img::selection {
            background-color: transparent;
        }
        .btn-al {
            color: #000;
            background-color: white !important;
            border-color: #c8c8c8 !important;
            color: #c8c8c8 !important;
        }
    </style>
@endsection

@section('content')
    <section class="mb-4 pt-3">
        <div class="container-fluid">
            <div class="bg-white shadow-sm rounded p-3">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 mb-4">
                        <div class="sticky-top z-3 row gutters-10">
                            @php
								$photos = explode(',', $detailedProduct->photos);
                                $refund_time_config = DB::table('categories')->where('id',$detailedProduct->category_id)->pluck('return_policy')->first();
                                // $refund_time_config = \App\BusinessSetting::where('type', 'refund_request_time')->first();
                            @endphp
                            <div class="col order-1 order-md-2">
                                <div class="aiz-carousel product-gallery" data-nav-for='.product-gallery-thumb' data-fade='true' data-auto-height='true'>
                                    @foreach ($photos as $key => $photo)
                                    @if($photo != 0)
                                        <div class="carousel-box img-zoom rounded">
                                            <img class="img-fluid lazyload"
                                                style="width:100%; height:100%; max-height:500px; max-width:500px;"
                                                src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                data-src="{{ uploaded_asset($photo) }}"
                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                        </div>
                                        @endif
                                    @endforeach
                                    @foreach ($detailedProduct->stocks as $key => $stock)
                                        @if ($stock->image != null)
                                            <div class="carousel-box img-zoom rounded">
                                                <img class="img-fluid lazyload"
                                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                    data-src="{{ uploaded_asset($stock->image) }}"
                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-12 col-md-auto w-md-80px order-2 order-md-1 mt-3 mt-md-0">
                                <div class="aiz-carousel product-gallery-thumb" data-items='5'
                                    data-nav-for='.product-gallery' data-vertical='true' data-vertical-sm='false'
                                    data-focus-select='true' data-arrows='true'>
                                    @foreach ($photos as $key => $photo)
                                    @if($photo != 0)
                                        <div class="carousel-box c-pointer border p-1 rounded">
                                            <img class="lazyload mw-100 size-50px mx-auto"
                                                src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                data-src="{{ uploaded_asset($photo) }}"
                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                        </div>
                                    @endif
                                    @endforeach
                                    @foreach ($detailedProduct->stocks as $key => $stock)
                                        @if ($stock->image != null)
                                            <div class="carousel-box c-pointer border p-1 rounded"
                                                data-variation="{{ $stock->variant }}">
                                                <img class="lazyload mw-100 size-50px mx-auto"
                                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                    data-src="{{ uploaded_asset($stock->image) }}"
                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 px-0 px-md-auto product_details_page">
                        <div class="row">
                            <div class="col-12 px-0">
                                <h1 class="mb-0 fs-18 fw-600 d-flex text-justify" style="line-height: 22px;">
                                    {{ $detailedProduct->getTranslation('name') }}
                                </h1>
                            </div>
                        </div>
                        @php
                            $list_price = $detailedProduct->purchase_price != 0 ? $detailedProduct->purchase_price : $detailedProduct->unit_price;
                            $discount_price = $list_price - $detailedProduct->discount;
                            $discount = $list_price - $discount_price;
                            settype($list_price, 'float');
                            settype($discount_price, 'float');
                            $discount_percentage = ($discount / $list_price) * 100;
                            $discount_percentage = round($discount_percentage, 0);
                            $final_price = $detailedProduct->unit_price;
                        @endphp
                        @if (home_price($detailedProduct) != home_discounted_price($detailedProduct))
                            @if ($detailedProduct->discount_type == 'amount')
                                @php
                                    $list_price = $detailedProduct->unit_price;
                                    $discount_price = $list_price - $detailedProduct->discount;
                                    settype($list_price, 'float');
                                    settype($discount_price, 'float');
                                    $discount = $list_price - $discount_price;
                                    $discount_percentage = ($discount / $list_price) * 100;
                                    $discount_percentage = round($discount_percentage, 0);
                                    $final_price = $detailedProduct->unit_price - $detailedProduct->discount;
                                    
                                @endphp
                            @else
                                @php
                                    $discount_percentage = $detailedProduct->discount;
                                    $final_price = round(($detailedProduct->unit_price / 100) * (100 - $detailedProduct->discount));
                                    
                                @endphp
                            @endif
                        @endif


                        <div class="row mt-2">
                            <span class="text-gray col-auto mb-0 pl-0 rp-price h3">Price:</span>
                            @if ($detailedProduct->discount != 0)
                                <del
                                    class="text-gray col-auto mb-0 px-0 rp-price h3">₹{{ $detailedProduct->unit_price }}</del>
                                @if ($detailedProduct->discount_type == 'amount')
                                    <span
                                        class="text-black col-auto mb-0 px-0 ml-2 rp-price h3">₹{{ $final_price }}</span>
                                @else
                                    <span
                                        class="text-black col-auto mb-0 px-0 ml-2 rp-price h3">₹{{ $final_price }}</span>
                                @endif
                                <span class="text-lighter-gray col-auto mb-0 px-0 rp-price h3 font-weight-lighter"> |
                                </span>
                                <span class="text-pink col-auto mb-0 rp-price px-0 h3">{{ $discount_percentage }}%
                                    off</span>
                            @else
                                <span class="text-black col-auto mb-0 px-0 rp-price h3">₹{{ $final_price }}</span>
                            @endif
                        </div>
                        <div class="row">
                            <p class="single-notes pt-0 pb-3">Inclusive of all taxes</p>
                        </div>
                        <form id="option-choice-form">
                            @csrf
                            <input type="hidden" name="id" value="{{ $detailedProduct->id }}">
                            @if (count(json_decode($detailedProduct->colors)) > 0)
                                <div class="row bg-gray py-2 px-2 border-bottom">
                                    <div class="col-auto align-self-center">
                                        <h5 class="mb-0 font-weight-normal">Color</h5>
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="aiz-radio-inline">
                                            @foreach (json_decode($detailedProduct->colors) as $key => $color)
                                                <label class="aiz-megabox pl-0 mb-0 mr-2" style="vertical-align:middle;"
                                                    data-toggle="tooltip"
                                                    data-title="{{ \App\Color::where('code', $color)->first()->name }}">
                                                    <input type="radio" name="color"
                                                        value="{{ \App\Color::where('code', $color)->first()->name }}"
                                                        @if ($key == 0) checked @endif>
                                                    <span
                                                        class="aiz-megabox-elem rounded d-flex align-items-center justify-content-center p-1">
                                                        <span class="size-30px d-inline-block rounded"
                                                            style="background: {{ $color }};"></span>
                                                    </span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($detailedProduct->choice_options != null)
                                <div class="row bg-gray py-2 px-2 border-bottom">

                                    <div class="col-sm-10">
                                        <div class="aiz-radio-inline">
                                            @foreach (json_decode($detailedProduct->choice_options) as $key => $choice)
                                                <div class="row no-gutters">
                                                    <div class="col-sm-2">
                                                        <div class="opacity-50 my-2">
                                                            {{ \App\Attribute::find($choice->attribute_id)->getTranslation('name') }}:
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-10">
                                                        <div class="aiz-radio-inline">
                                                            @foreach ($choice->values as $key => $value)
                                                                <label class="aiz-megabox pl-0 mr-2">
                                                                    <input type="radio"
                                                                        name="attribute_id_{{ $choice->attribute_id }}"
                                                                        value="{{ $value }}"
                                                                        @if ($key == 0) checked @endif>
                                                                    <span
                                                                        class="aiz-megabox-elem rounded d-flex align-items-center justify-content-center py-2 px-3 mb-2">
                                                                        {{ $value }}
                                                                    </span>
                                                                </label>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @php
                                $qty = 0;
                                foreach ($detailedProduct->stocks as $key => $stock) {
                                    $qty += $stock->qty;
                                }
                            @endphp
                            <div class="row bg-gray py-2 px-2 border-bottom">
                                <div class="col-auto align-self-center">
                                    <h5 class="mb-0 font-weight-normal">Quantity</h5>
                                </div>
                                <div class="col-auto pl-0">
                                    <div class="row no-gutters align-items-center aiz-plus-minus mr-3"
                                        style="width: 130px;">
                                        <button class="btn col-auto btn-icon btn-sm btn-circle btn-light btn-al"
                                            type="button" data-type="minus" data-field="quantity">
                                            <i class="fa fa-minus"></i>
                                            {{-- <i data-feather="minus"></i> --}}
                                        </button>
                                        @if ($detailedProduct->max_qty > 0)
                                            <input type="number" name="quantity"
                                                class="col border-0 text-center flex-grow-1 fs-16 input-number mx-2"
                                                placeholder="1" value="{{ $detailedProduct->min_qty }}"
                                                min="{{ $detailedProduct->min_qty }}"
                                                max="{{ $detailedProduct->max_qty }}" />
                                        @else
                                            <input type="number" name="quantity"
                                                class="col border-0 text-center flex-grow-1 fs-16 input-number mx-2"
                                                placeholder="1" value="{{ $detailedProduct->min_qty }}"
                                                min="{{ $detailedProduct->min_qty }}" max="{{ $qty }}" />
                                        @endif

                                        <button class="btn col-auto btn-icon btn-sm btn-circle btn-light btn-al"
                                            type="button" data-type="plus" data-field="quantity">
                                            <i class="fa fa-plus"></i>
                                            {{-- <i data-feather="plus"></i> --}}
                                        </button>
                                    </div>
                                </div>

                                <div class="col-auto align-self-center pl-0">
                                    <div class="avialable-amount opacity-60">
                                        @if ($detailedProduct->stock_visibility_state == 'quantity')

                                            (@if ($qty == 0)
                                                <span class="text-danger">{{ translate('Out Of Stock') }}</span>
                                            @else
                                                <span id="available-quantity">{{ $qty }}</span>
                                                {{ translate('available') }}
                                            @endif)
                                        @elseif($detailedProduct->stock_visibility_state == 'text' && $qty >= 1)
                                            (<span id="available-quantity">{{ translate('In Stock') }}</span>)
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="row bg-gray py-2 px-2 border-bottom">
                            @if ($detailedProduct->external_link != null)
                                @if ($cartStatus == 1)
                                    <div class="col-12 col-md-6">
                                        <a href="{{ route('cart') }}"
                                            class="btn btn-orange  mb-2 mb-md-auto w-100 d-flex align-items-center @if ($qty == 0) disabled @endif">
                                            <i class=" fa fa-shopping-cart mr-2 h5 mb-0 ml-auto"></i>
                                            <span class="h5 mb-0 mr-auto">{{ translate('Visit Cart') }}</span>
                                        </a>
                                        <small class="text-danger text-center">Already in cart</small>
                                    </div>
                                @else
                                    <div class="col-12 col-md-6">
                                        <a href="{{ $detailedProduct->external_link }}"
                                            class="btn btn-orange w-100 d-flex align-items-center mb-2 mb-md-auto addToCartButton @if ($qty == 0) disabled @endif">
                                            <i class=" fa fa-shopping-bag mr-2 h5 mb-0 ml-auto"></i>
                                            <span class="h5 mb-0 mr-auto">{{ translate('Add to cart') }}</span></a>
                                    </div>
                                @endif
                                <div class="col-12 col-md-6">
                                    <a href="{{ $detailedProduct->external_link }}"
                                        class="btn btn-tam w-100 d-flex align-items-center @if ($qty == 0) disabled @endif">
                                        <i class=" fa fa-shopping-cart mr-2 h5 mb-0 ml-auto"></i>
                                        <span class="h5 mb-0 mr-auto ml-auto">{{ translate('Buy Now') }}</span></a>
                                </div>
                            @else
                                @if ($cartStatus == 1)
                                    <div class="col-12 col-md-6">
                                        <a href="{{ route('cart') }}"
                                            class="btn btn-orange  mb-2 mb-md-auto w-100 d-flex align-items-center @if ($qty == 0) disabled @endif">
                                            <i class=" fa fa-shopping-cart mr-2 h5 mb-0 ml-auto"></i>
                                            <span class="h5 mb-0 mr-auto">{{ translate('Visit Cart') }}</span>
                                        </a>
                                        <small class="text-danger text-center">Already in cart</small>
                                    </div>
                                @else
                                    <div class="col-12 col-md-6">
                                        <button onclick="addToCart()" id="addtocartfun"
                                            class="btn btn-orange  mb-2 mb-md-auto w-100 d-flex align-items-center addToCartButton @if ($qty == 0) disabled @endif">
                                            <i class=" fa fa-shopping-bag mr-2 h5 mb-0 ml-auto"></i>
                                            <span class="h5 mb-0 mr-auto">{{ translate('Add to cart') }}</span></button>
                                    </div>
                                @endif
                                <div class="col-12 col-md-6">
                                    <button onclick="buyNow()" id="buynowfun"
                                        class="btn btn-tam w-100 d-flex align-items-center @if ($qty == 0) disabled @endif">
                                        <i class=" fa fa-shopping-cart mr-2 h5 mb-0 ml-auto"></i>
                                        <span class="h5 mb-0 mr-auto">{{ translate('Buy Now') }}</span></button>
                                </div>
                            @endif
                        </div>
                        <div class="row bg-gray py-2 px-2 border-bottom">
                            <div class="col">
                                <a class="d-flex align-items-center btn btn-link btn-icon-left fw-600 px-0 a-hov-ef addToWishlistButton @if ($qty == 0) disabled @endif"
                                    onclick="addToWishList({{ $detailedProduct->id }})">
                                    <span class="mb-0 mr-auto ml-auto">{{ translate('Add to wishlist') }}</span>
                                </a>
                            </div>
                            <!-- Add to compare button -->
                            <div class="col">
                                <a class="d-flex align-items-center btn btn-link btn-icon-left fw-600 px-0 a-hov-ef @if ($qty == 0) disabled @endif"
                                    onclick="addToCompare({{ $detailedProduct->id }})">
                                    <span class="mb-0 mr-auto ml-auto">{{ translate('Add to compare') }}</span>
                                </a>
                            </div>
                            @if (Auth::check() && addon_is_activated('affiliate_system') && (\App\AffiliateOption::where('type', 'product_sharing')->first()->status || \App\AffiliateOption::where('type', 'category_wise_affiliate')->first()->status) && Auth::user()->affiliate_user != null && Auth::user()->affiliate_user->status)
                                @php
                                    if (Auth::check()) {
                                        if (Auth::user()->referral_code == null) {
                                            Auth::user()->referral_code = substr(Auth::user()->id . Str::random(10), 0, 10);
                                            Auth::user()->save();
                                        }
                                        $referral_code = Auth::user()->referral_code;
                                        $referral_code_url = URL::to('/product') . '/' . $detailedProduct->slug . "?product_referral_code=$referral_code";
                                    }
                                @endphp
                                <div>
                                    <button type=button id="ref-cpurl-btn"
                                        class="btn btn-tam w-100 d-flex align-items-center"
                                        data-attrcpy="{{ translate('Copied') }}" onclick="CopyToClipboard(this)"
                                        data-url="{{ $referral_code_url }}">{{ translate('Copy the Promote Link') }}</button>
                                </div>
                            @endif
                        </div>
                        <div class="row my-3">
                            <div class="col-12 pl-0">
                                <h4>Product Details</h4>
                                <div class="mw-100 overflow-hidden text-justify aiz-editor-data" id="product_details_ul">
                                    <?php
                                    echo $detailedProduct->getTranslation('specification');
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="row no-gutters mt-4">
                                    <div class="col-sm-12 pl-0">
                                        <h4>{{ translate('Sold by') }}</h4>
                                    </div>
                                    <div class="col-sm-12 px-0">
                                        <div class="row">
                                            @if ($detailedProduct->added_by == 'seller' && get_setting('vendor_system_activation') == 1)
                                                <div class="col-auto pl-0 align-self-center">
                                                    <a href="{{ route('shop.visit', $detailedProduct->user->shop->slug) }}"
                                                        class="text-reset"><i class="fas fa-store fs-5 pr-1"></i>
                                                        {{ $detailedProduct->user->shop->name }}</a>
                                                </div>
                                                <div class="col pl-0 pr-0">
                                                    <a href="{{ route('shop.visit', $detailedProduct->user->shop->slug) }}"
                                                        class="btn btn-outline-danger"> View Store</a>
                                                </div>
                                            @else
                                                {{ translate('Inhouse product') }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="row no-gutters mt-4">
                                    <div class="col-sm-12 text-left text-md-right">
                                        <h4>{{ translate('Share') }}</h4>
                                    </div>
                                    <div class="col-sm-12">
                                        <!-- AddToAny BEGIN -->
                                        <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                                            <a class="float-left float-md-right a2a_button_facebook"></a>
                                            <a class="float-left float-md-right a2a_button_twitter"></a>
                                            <a class="float-left float-md-right a2a_button_whatsapp"></a>
                                        </div>
                                        <script async src="https://static.addtoany.com/menu/page.js"></script>
                                        <!-- AddToAny END -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row bg-gray py-2 px-0 mt-2 border-bottom">
                            <div class="col-md-12 px-0">
                                <div class="custom-icon-container  justify-content-center">
                                    @if($detailedProduct->refundable == 1)
                                    <div class="custom-icon-box" data-toggle="tooltip" data-placement="top"
                                        title="Returns/replacements are accepted for unused products only in case of defects, damages during delivery, missing, or wrong products delivered. Return requests can be raised on the 'My Order' section within {{ $refund_time_config }} days of delivery.">
                                        <img style="width:30px!important;"
                                            src="{{ static_asset('assets/img/product-icons/exchange.png') }}">
                                        <p class=" ">@if ($refund_time_config != null) {{ $refund_time_config }} @endif Days Easy Return</p>
                                    </div>
                                    @endif
                                    <div class="custom-icon-box">
                                        <img style="width:30px!important;"
                                            src="{{ static_asset('assets/img/product-icons/package.png') }}">
                                        <p class="">No Contact Delivery</p>
                                    </div>
                                    <div class="custom-icon-box">
                                        <img style="width:30px!important;"
                                            src="{{ static_asset('assets/img/product-icons/transaction.png') }}">
                                        <p class="">Secure Transaction</p>
                                    </div>
                                    <div class="custom-icon-box">
                                        <img style="width:30px!important;"
                                            src="{{ static_asset('assets/img/product-icons/credit-card.png') }}">
                                        <p class=" ">Lowest Price</p>
                                    </div>
                                    <div class="custom-icon-box">
                                        <img style="width:30px!important;"
                                            src="{{ static_asset('assets/img/product-icons/cash-on-delivery.png') }}">
                                        <p class="">Cash on Delivery</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    <section class="mb-4">
        <div class="container-fluid">
            <div class="row gutters-10">
                <div class="col-xl-12 order-0 order-xl-1">
                    <div class="bg-white mb-3 shadow-sm rounded">
                        <div class="nav border-bottom aiz-nav-tabs">
                            <a href="#tab_default_1" data-toggle="tab"
                                class="p-3 fs-16 fw-600 text-reset active show">{{ translate('Description') }}</a>
                            @if ($detailedProduct->video_link != null)
                                <a href="#tab_default_2" data-toggle="tab"
                                    class="p-3 fs-16 fw-600 text-reset">{{ translate('Video') }}</a>
                            @endif
                            @if ($detailedProduct->pdf != null)
                                <a href="#tab_default_3" data-toggle="tab"
                                    class="p-3 fs-16 fw-600 text-reset">{{ translate('Downloads') }}</a>
                            @endif
                            <a href="#tab_default_4" data-toggle="tab" class="p-3 fs-16 fw-600 text-reset"
                                style="display:none;">{{ translate('Reviews') }}</a>
                        </div>

                        <div class="tab-content pt-0">
                            <div class="tab-pane fade active show" id="tab_default_1">
                                <div class="p-3">
                                    <div class="mw-100 overflow-hidden text-left aiz-editor-data">
                                        <?php echo $detailedProduct->getTranslation('description'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="tab_default_2">
                                <div class="p-4">
                                    <div class="embed-responsive embed-responsive-16by9">
                                        @if ($detailedProduct->video_provider == 'youtube' && isset(explode('=', $detailedProduct->video_link)[1]))
                                            <iframe class="embed-responsive-item"
                                                src="https://www.youtube.com/embed/{{ explode('=', $detailedProduct->video_link)[1] }}"></iframe>
                                        @elseif ($detailedProduct->video_provider == 'dailymotion' && isset(explode('video/', $detailedProduct->video_link)[1]))
                                            <iframe class="embed-responsive-item"
                                                src="https://www.dailymotion.com/embed/video/{{ explode('video/', $detailedProduct->video_link)[1] }}"></iframe>
                                        @elseif ($detailedProduct->video_provider == 'vimeo' && isset(explode('vimeo.com/', $detailedProduct->video_link)[1]))
                                            <iframe
                                                src="https://player.vimeo.com/video/{{ explode('vimeo.com/', $detailedProduct->video_link)[1] }}"
                                                width="500" height="281" frameborder="0" webkitallowfullscreen
                                                mozallowfullscreen allowfullscreen></iframe>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab_default_3">
                                <div class="p-4 text-center ">
                                    <a href="{{ uploaded_asset($detailedProduct->pdf) }}"
                                        class="btn btn-primary">{{ translate('Download') }}</a>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab_default_4">
                                <div class="p-4">
                                    <ul class="list-group list-group-flush">
                                        @foreach ($detailedProduct->reviews as $key => $review)
                                            @if ($review->user != null)
                                                <li class="media list-group-item d-flex">
                                                    <span class="avatar avatar-md mr-3">
                                                        <img class="lazyload"
                                                            src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                            @if ($review->user->avatar_original != null) data-src="{{ uploaded_asset($review->user->avatar_original) }}"
                                                    @else
                                                        data-src="{{ static_asset('assets/img/placeholder.jpg') }}" @endif>
                                                    </span>
                                                    <div class="media-body text-left">
                                                        <div class="d-flex justify-content-between">
                                                            <h3 class="fs-15 fw-600 mb-0">{{ $review->user->name }}</h3>
                                                            <span class="rating rating-sm">
                                                                @for ($i = 0; $i < $review->rating; $i++)
                                                                    <i class="las la-star active"></i>
                                                                @endfor
                                                                @for ($i = 0; $i < 5 - $review->rating; $i++)
                                                                    <i class="las la-star"></i>
                                                                @endfor
                                                            </span>
                                                        </div>
                                                        <div class="opacity-60 mb-2">
                                                            {{ date('d-m-Y', strtotime($review->created_at)) }}</div>
                                                        <p class="comment-text">
                                                            {{ $review->comment }}
                                                        </p>
                                                    </div>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>

                                    @if (count($detailedProduct->reviews) <= 0)
                                        <div class="text-center fs-18 opacity-70">
                                            {{ translate('There have been no reviews for this product yet.') }}
                                        </div>
                                    @endif

                                    @if (Auth::check())
                                        @php
                                            $commentable = false;
                                        @endphp
                                        @foreach ($detailedProduct->orderDetails as $key => $orderDetail)
                                            @if ($orderDetail->order != null &&
    $orderDetail->order->user_id == Auth::user()->id &&
    $orderDetail->delivery_status == 'delivered' &&
    \App\Review::where('user_id', Auth::user()->id)->where('product_id', $detailedProduct->id)->first() == null)
                                                @php
                                                    $commentable = true;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @if ($commentable)
                                            <div class="pt-4">
                                                <div class="border-bottom mb-4">
                                                    <h3 class="fs-17 fw-600">
                                                        {{ translate('Write a review') }}
                                                    </h3>
                                                </div>
                                                <form class="form-default" role="form"
                                                    action="{{ route('reviews.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="product_id"
                                                        value="{{ $detailedProduct->id }}">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for=""
                                                                    class="text-uppercase c-gray-light">{{ translate('Your name') }}</label>
                                                                <input type="text" name="name"
                                                                    value="{{ Auth::user()->name }}"
                                                                    class="form-control" disabled required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for=""
                                                                    class="text-uppercase c-gray-light">{{ translate('Email') }}</label>
                                                                <input type="text" name="email"
                                                                    value="{{ Auth::user()->email }}"
                                                                    class="form-control" required disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="opacity-60">{{ translate('Rating') }}</label>
                                                        <div class="rating rating-input">
                                                            <label>
                                                                <input type="radio" name="rating" value="1" required>
                                                                <i class="las la-star"></i>
                                                            </label>
                                                            <label>
                                                                <input type="radio" name="rating" value="2">
                                                                <i class="las la-star"></i>
                                                            </label>
                                                            <label>
                                                                <input type="radio" name="rating" value="3">
                                                                <i class="las la-star"></i>
                                                            </label>
                                                            <label>
                                                                <input type="radio" name="rating" value="4">
                                                                <i class="las la-star"></i>
                                                            </label>
                                                            <label>
                                                                <input type="radio" name="rating" value="5">
                                                                <i class="las la-star"></i>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="opacity-60">{{ translate('Comment') }}</label>
                                                        <textarea class="form-control" rows="4" name="comment" placeholder="{{ translate('Your review') }}"
                                                            required></textarea>
                                                    </div>

                                                    <div class="text-right">
                                                        <button type="submit" class="btn btn-primary mt-3">
                                                            {{ translate('Submit review') }}
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="bg-white rounded shadow-sm">
                        {{-- <div class="border-bottom p-3">
                            <h3 class="fs-16 fw-600 mb-0">
                                <span class="mr-4">{{ translate('Related products') }}</span>
                            </h3>
                        </div> --}}
                        <div class="p-3">
                            <div class="aiz-carousel gutters-5 half-outside-arrow" data-items="5" data-xl-items="3"
                                data-lg-items="4" data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true'
                                data-infinite='true'>
                                @foreach (filter_products(\App\Product::where('category_id', $detailedProduct->category_id)->where('id', '!=', $detailedProduct->id))->limit(10)->get()
        as $key => $related_product)
                                    @php
                                        $photos = explode(',', $related_product->photos);
                                    @endphp
                                    <div class="carousel-box">
                                        <div
                                            class="aiz-card-box border border-light rounded hov-shadow-md my-2 has-transition">
                                            <div class="">
                                                <a href="{{ route('product', $related_product->slug) }}"
                                                    class="d-block">
                                                    <img class="img-fit lazyload mx-auto h-140px h-md-210px"
                                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                        style="object-fit: cover;"
                                                        data-src="{{ uploaded_asset($photos[0]) }}"
                                                        alt="{{ $related_product->getTranslation('name') }}"
                                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                </a>
                                            </div>
                                            <div class="p-md-3 p-2 text-left">
                                                <div class="rating rating-sm mt-1">
                                                    {{ renderStarRating($related_product->rating) }}
                                                </div>
                                                <h3 class="fw-500 fs-13 text-truncate-2 lh-1-4 mb-0 h-35px  text-center">
                                                    <a href="{{ route('product', $related_product->slug) }}"
                                                        class="d-block text-reset">{{ $related_product->getTranslation('name') }}</a>
                                                </h3>
                                                <div class="fs-15  text-center">
                                                    @if (home_base_price($related_product) != home_discounted_base_price($related_product))
                                                        <del
                                                            class="fw-600 opacity-50 mr-1">{{ home_base_price($related_product) }}</del>
                                                    @endif
                                                    <span
                                                        class="fw-700 text-primary">{{ home_discounted_base_price($related_product) }}</span>
                                                </div>
                                                @if (addon_is_activated('club_point'))
                                                    <div
                                                        class="rounded px-2 mt-2 bg-soft-primary border-soft-primary border">
                                                        {{ translate('Club Point') }}:
                                                        <span
                                                            class="fw-700 float-right">{{ $related_product->earn_point }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
	
	@if(isset($rv_products)&&count($rv_products)>0)
    <section class="mb-4">
        <div class="container-fluid">
            <div class="bg-white shadow-sm rounded p-3">
                <div class="row" id="recently_viewed">
                    <div class="d-flex mb-3 align-items-baseline border-bottom justify-content-center">
                        <h3 class="h5 fw-700 mb-0">
                            <span
                                class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Recently Viewed Items') }}</span>
                        </h3>
                    </div>
                    <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="6" data-xl-items="5" data-lg-items="4"
                        data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true' data-infinite='true'
                        data-autoplay='true'>
                        @foreach ($rv_products as $key => $product)
                                @php
                                @endphp
                                <div class="carousel-box">
                                    @include('frontend.partials.product_box_1', [
                                        'product' => $product,
                                    ])
                                </div>
                            @endforeach
                    </div>
                </div>
            </div>
        </div> 
    </section>
  @endif
  
    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $detailedProduct->meta_title }}" />
    <meta property="og:type" content="og:product" />
    <meta property="og:url" content="{{ route('product', $detailedProduct->slug) }}" />
    <meta property="og:image" content="{{ uploaded_asset($detailedProduct->meta_img) }}" />
    <meta property="og:description" content="{{ strip_tags($detailedProduct->description) }}" />
    <meta property="og:site_name" content="{{ get_setting('meta_title') }}" />
    <meta property="og:price:amount" content="{{ number_format($final_price, 2) }}" />
    <meta property="product:price:currency"
        content="{{ \App\Currency::findOrFail(get_setting('system_default_currency'))->code }}" />
    <meta property="fb:app_id" content="{{ env('FACEBOOK_PIXEL_ID') }}">
    <meta property="product:brand" content="{{ $detailedProduct->user->shop->name }}">
    <meta property="product:availability" content="in stock">
    <meta property="product:condition" content="new">
    <meta property="product:retailer_item_id" content="{{ $detailedProduct->id }}">
    <meta property="product:item_group_id" content="{{ $detailedProduct->id }}">
    <!-- Open Graph data -->
    {{-- schema org --}}
    <div itemscope itemtype="http://schema.org/Product">
        <meta itemprop='image' content="{{ uploaded_asset($photos[0]) }}" />
        <meta itemprop='name' content="{{ ucfirst(ucwords($detailedProduct->name)) }}" />
        <meta itemprop='description' content="{{ strip_tags($detailedProduct->description) }}" />
        <meta itemprop='sku' content="{{ $detailedProduct->stocks[0]->sku }}" />
        <meta itemprop='productID' content='{{ $detailedProduct->id }}'>
        <meta itemprop='brand' content="{{ $detailedProduct->user->shop->name }}" />
        <meta itemprop="url" content="<?php echo url()->current(); ?>">
        <div itemprop="value" itemscope itemtype="http://schema.org/{{ number_format($final_price, 2) }}">
            <span itemprop="propertyID" content="{{ $detailedProduct->id }}"></span>
            <meta itemprop="value" content="{{ number_format($final_price, 2) }}" />
        </div>
        <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
            <link itemprop="url" href="<?php echo url()->current(); ?>" />
            <link itemprop="availability" href="http://schema.org/InStock">
            <link itemprop="itemCondition" href="http://schema.org/NewCondition">
            <meta itemprop="price" content="{{ number_format($final_price, 2) }}">
            <meta itemprop="priceCurrency" content="INR">
        </div>
    </div>
    {{-- schema org --}}
    {{-- json ld --}}
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Product",
            "productID": "{{ $detailedProduct->id }}",
            "name": "<?php echo $detailedProduct->name; ?>",
            "description": "<?php echo strip_tags($detailedProduct->description); ?>",
            "url": "<?php echo url()->current(); ?>",
            "image": "<?php echo uploaded_asset($photos[0]); ?>",
            "brand": "{{ $detailedProduct->user->shop->name }}",
            "offers": [{
                "@type": "Offer",
                "price": "<?php echo number_format($final_price, 2); ?>",
                "priceCurrency": "INR",
                "itemCondition": "new",
                "availability": "InStock"
            }],
            "additionalProperty": [{
                "@type": "PropertyValue",
                "propertyID": "{{ $detailedProduct->id }}",
                "value": "<?php echo $detailedProduct->name; ?>"
            }]
        }
    </script>
    {{-- json ld --}}
@endsection

@section('modal')
    <div class="modal" id="chat_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative">
                <div class="modal-header">
                    <h5 class="modal-title fw-600 h5">{{ translate('Any query about this product') }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="" action="{{ route('conversations.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $detailedProduct->id }}">
                    <div class="modal-body gry-bg px-3 pt-3">
                        <div class="form-group">
                            <input type="text" class="form-control mb-3" name="title"
                                value="{{ $detailedProduct->name }}" placeholder="{{ translate('Product Name') }}"
                                required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" rows="8" name="message" required
                                placeholder="{{ translate('Your Question') }}">{{ route('product', $detailedProduct->slug) }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary fw-600"
                            data-bs-dismiss="modal">{{ translate('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary fw-600">{{ translate('Send') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal" id="login_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-zoom" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600">{{ translate('Login') }}</h6>
                    <button type="button" class="close" data-bs-dismiss="modal">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="p-3">
                        <form class="form-default" role="form" action="{{ route('cart.login.submit') }}"
                            method="POST">
                            @csrf
                            <div class="form-group">
                                @if (addon_is_activated('otp_system'))
                                    <input type="text"
                                        class="form-control h-auto form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                        value="{{ old('email') }}" placeholder="{{ translate('Email Or Phone') }}"
                                        name="email" id="email">
                                @else
                                    <input type="email"
                                        class="form-control h-auto form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                        value="{{ old('email') }}" placeholder="{{ translate('Email') }}"
                                        name="email">
                                @endif
                                @if (addon_is_activated('otp_system'))
                                    <span
                                        class="opacity-60">{{ translate('Use country code before number') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <input type="password" name="password" class="form-control h-auto form-control-lg"
                                    placeholder="{{ translate('Password') }}">
                            </div>

                            <div class="row mb-2">
                                <div class="col-6">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <span class=opacity-60>{{ translate('Remember Me') }}</span>
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                                <div class="col-6 text-right">
                                    <a href="{{ route('password.request') }}"
                                        class="text-reset opacity-60 fs-14">{{ translate('Forgot password?') }}</a>
                                </div>
                            </div>

                            <div class="mb-5">
                                <button type="submit"
                                    class="btn btn-primary btn-block fw-600">{{ translate('Login') }}</button>
                            </div>
                        </form>

                        <div class="text-center mb-3">
                            <p class="text-muted mb-0">{{ translate('Dont have an account?') }}</p>
                            <a href="{{ route('user.registration') }}">{{ translate('Register Now') }}</a>
                        </div>
                        @if (get_setting('google_login') == 1 || get_setting('facebook_login') == 1 || get_setting('twitter_login') == 1)
                            <div class="separator mb-3">
                                <span class="bg-white px-3 opacity-60">{{ translate('Or Login With') }}</span>
                            </div>
                            <ul class="list-inline social colored text-center mb-5">
                                @if (get_setting('facebook_login') == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ route('social.login', ['provider' => 'facebook']) }}"
                                            class="facebook">
                                            <i class="lab la-facebook-f"></i>
                                        </a>
                                    </li>
                                @endif
                                @if (get_setting('google_login') == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ route('social.login', ['provider' => 'google']) }}"
                                            class="google">
                                            <i class="lab la-google"></i>
                                        </a>
                                    </li>
                                @endif
                                @if (get_setting('twitter_login') == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ route('social.login', ['provider' => 'twitter']) }}"
                                            class="twitter">
                                            <i class="lab la-twitter"></i>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    {{-- CHANGE QUANTITY  --}}
        <script type="text/javascript">
            // $(document).ready(function () {
            //     $("#attribute_id_<?php //echo $choice->attribute_id; ?>").click(function (e) { 
            //         // e.preventDefault();
            //             console.log(e);
            //     });
            // });
        </script>
    {{-- CHANGE QUANTITY  --}}
  {{-- fbq code --}}
    <!-- Facebook Pixel Code -->
    <script type="text/javascript">
        fbq('track', 'ViewContent', {
            content_name: '{{ $detailedProduct->name }}',
            content_category: '',
            content_ids: ['{{ $detailedProduct->id }}'],
            content_type: 'product',
            value: {{ $final_price }},
            currency: 'INR'
        });
        $(document).ready(function() {
        $(".addToCartButton").click(function() {
            // e.preventDefault();
            fbq('track', 'AddToCart', {
                content_type: 'product',
                content_name: '{{ $detailedProduct->name }}',
                value: {{ $final_price }},
                currency: 'INR',
                content_ids: ['{{ $detailedProduct->id }}']
            });
        });
        $(".addToWishlistButton").click(function() {
            // e.preventDefault();
            fbq('track', 'AddToWishlist', {
                content_type: 'product',
                content_name: '{{ $detailedProduct->name }}',
                value: {{ $final_price }},
                currency: 'INR',
                content_ids: ['{{ $detailedProduct->id }}']
            });
        });
        });
        
    </script>
    <!-- End Facebook Pixel Code -->
    {{-- fbq code --}}x
    <script type="text/javascript">
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
        $(document).ready(function() {
            getVariantPrice();
        });
        function CopyToClipboard(e) {
            var url = $(e).data('url');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(url).select();
            try {
                document.execCommand("copy");
                AIZ.plugins.notify('success', '{{ translate('Link copied to clipboard') }}');
            } catch (err) {
                AIZ.plugins.notify('danger', '{{ translate('Oops, unable to copy') }}');
            }
            $temp.remove();
            // if (document.selection) {
            //     var range = document.body.createTextRange();
            //     range.moveToElementText(document.getElementById(containerid));
            //     range.select().createTextRange();
            //     document.execCommand("Copy");
            // } else if (window.getSelection) {
            //     var range = document.createRange();
            //     document.getElementById(containerid).style.display = "block";
            //     range.selectNode(document.getElementById(containerid));
            //     window.getSelection().addRange(range);
            //     document.execCommand("Copy");
            //     document.getElementById(containerid).style.display = "none";
            // }
            // AIZ.plugins.notify('success', 'Copied');
        }
        function show_chat_modal() {
            @if (Auth::check())
                $('#chat_modal').modal('show');
            @else
                $('#login_modal').modal('show');
            @endif
        }
    </script>
    <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
	
	<?php
		function wigzo_call( $event, $data ){
			echo '<script>';
			echo 'wigzo('.'"'.strval($event).'"'.', '. json_encode( $data ) .')';
			echo '</script>';
		}
		
		$category = \App\Category::select('name')->where('id', $detailedProduct->category_id)->first();	
		$product_details = array(
			'canonicalUrl'=> route('product', $detailedProduct->slug),
			'title'=> $detailedProduct->meta_title,
			'description'=>  $detailedProduct->meta_description,
			'price'=> $detailedProduct->unit_price,
			'prevPrice'=> $detailedProduct->unit_price,
			'productId'=> $detailedProduct->id,
			'image'=> uploaded_asset($detailedProduct->thumbnail_img),
			'category'=> $category->name,
			'language'=> 'en'
		);
		$event_name = 'index';
		wigzo_call($event_name, $product_details);
	?>
	<script>
		$(document).ready(function () {
			var productUrl = "<?php echo route('product', $detailedProduct->slug); ?>";		
			wigzo("track", "productview", productUrl);        
		});  
	</script>  
@endsection