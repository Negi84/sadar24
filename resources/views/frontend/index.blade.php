@extends('frontend.layouts.app')

@section('content')
    <div class="container-fluid px-0 px-md-4 py-3">
        {{-- Slider And what's new product --}}
        <div class="row x-y-shadow py-2 py-md-3 px-0 px-md-3 mt-0 mt-md-2 bg-white">
            {{-- Demo header proto --}}
            <div class="col-12 px-0" style="height:fit-content;" id="ro1-co1">
                <div id="main_slider" class="carousel slide" data-bs-ride="carousel">
                    @if ($slider_images != null)
                        <div class="carousel-indicators">
                            @foreach ($slider_images as $key => $value)
                                <button type="button" data-bs-target="#main_slider" data-bs-slide-to="{{ $key }}"
                                    class="@if ($key == 0) active @endif" aria-current="true"
                                    aria-label="Slide {{ $key }}"></button>
                                {{-- <button type="button" data-bs-target="#main_slider" data-bs-slide-to="1"
                            aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#main_slider" data-bs-slide-to="2"
                            aria-label="Slide 3"></button>
                        <button type="button" data-bs-target="#main_slider" data-bs-slide-to="3"
                            aria-label="Slide 4"></button> --}}
                            @endforeach
                        </div>
                    @endif
                    @if ($slider_images != null)
                        <div class="carousel-inner">
                            {{-- @php $slider_images = json_decode(get_setting('home_slider_images'), true);  @endphp --}}
                            @foreach ($slider_images as $key => $value)
                                <div class="carousel-item @if ($key == 0) active @endif ">
                                    <a href="{{ json_decode(get_setting('home_banner1_links'), true)[$key] }}">
                                        <img class="d-block mw-100 img-fit rounded shadow-sm overflow-hidden"
                                            src="{{ uploaded_asset($slider_images[$key]) }}"
                                            alt="{{ env('APP_NAME') }} promo"
                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <button class="carousel-control-prev" type="button" data-bs-target="#main_slider" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#main_slider" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            {{-- Slider And what's new product --}}
        </div>
        {{-- Live Offers --}}
        <div class="row x-y-shadow py-2 py-md-3 px-0 bg-white mt-2 mt-4">
            @if (get_setting('home_banner2_images') != null)
                <div class="">
                    <div class="container-fluid px-0">
                        <div class="py-2 px-0 py-md-3 bg-white rounded">
                            <div class="row px-0 gutters-10">
                                @php $banner_2_imags = json_decode(get_setting('home_banner2_images')); @endphp
                                {{-- @foreach ($banner_2_imags as $key => $value)
                                    <div class="col-xl col-4 col-md-4">
                                        <div class="mb-md-3 mb-2 mb-lg-0">
                                            <a href="{{ json_decode(get_setting('home_banner2_links'), true)[$key] }}"
                                                target="_blank" class="d-block text-reset">
                                                <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                                    data-src="{{ uploaded_asset($banner_2_imags[$key]) }}"
                                                    alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload w-100">
                                            </a>
                                        </div>
                                    </div>
                                @endforeach --}}
                                <div class="col-xl col-4 col-md-4">
                                    <div class="mb-md-3 mb-2 mb-lg-0">
                                        <a href="https://sadar24.com/search?keyword=&brand=&sort_by=price-desc&min_price=0.00&max_price=99"
                                            target="_blank" class="d-block text-reset">
                                            <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                                data-src="{{ static_asset('assets/img/temp-main-banner/Group 1.png') }}"
                                                alt="{{ env('APP_NAME') }} promo"
                                                class="img-fluid lazyload w-100  on-hov-shadow" style="border-radius:20px;">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xl col-4 col-md-4">
                                    <div class="mb-md-3 mb-2 mb-lg-0">
                                        <a href="https://sadar24.com/search?keyword=&brand=&sort_by=price-desc&min_price=0.00&max_price=149"
                                            target="_blank" class="d-block text-reset">
                                            <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                                data-src="{{ static_asset('assets/img/temp-main-banner/Group 2.png') }}"
                                                alt="{{ env('APP_NAME') }} promo"
                                                class="img-fluid lazyload w-100  on-hov-shadow" style="border-radius:20px;">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xl col-4 col-md-4">
                                    <div class="mb-md-3 mb-2 mb-lg-0">
                                        <a href="https://sadar24.com/search?keyword=&brand=&sort_by=price-desc&min_price=0.00&max_price=199"
                                            target="_blank" class="d-block text-reset">
                                            <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                                data-src="{{ static_asset('assets/img/temp-main-banner/Group 3.png') }}"
                                                alt="{{ env('APP_NAME') }} promo"
                                                class="img-fluid lazyload w-100  on-hov-shadow" style="border-radius:20px;">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xl col-4 col-md-4">
                                    <div class="mb-md-3 mb-2 mb-lg-0">
                                        <a href="https://sadar24.com/search?keyword=&brand=&sort_by=price-desc&min_price=0.00&max_price=249"
                                            target="_blank" class="d-block text-reset">
                                            <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                                data-src="{{ static_asset('assets/img/temp-main-banner/Group 4.png') }}"
                                                alt="{{ env('APP_NAME') }} promo"
                                                class="img-fluid lazyload w-100  on-hov-shadow" style="border-radius:20px;">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xl col-4 col-md-4">
                                    <div class="mb-md-3 mb-2 mb-lg-0">
                                        <a href="https://sadar24.com/search?keyword=&brand=&sort_by=price-desc&min_price=0.00&max_price=299"
                                            target="_blank" class="d-block text-reset">
                                            <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                                data-src="{{ static_asset('assets/img/temp-main-banner/Group 5.png') }}"
                                                alt="{{ env('APP_NAME') }} promo"
                                                class="img-fluid lazyload w-100  on-hov-shadow" style="border-radius:20px;">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xl col-4 col-md-4">
                                    <div class="mb-md-3 mb-2 mb-lg-0">
                                        <a href="https://sadar24.com/search?keyword=&brand=&sort_by=price-desc&min_price=0.00&max_price=349"
                                            target="_blank" class="d-block text-reset">
                                            <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                                data-src="{{ static_asset('assets/img/temp-main-banner/Group 6.png') }}"
                                                alt="{{ env('APP_NAME') }} promo"
                                                class="img-fluid lazyload w-100  on-hov-shadow"
                                                style="border-radius:20px;">
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        {{-- Live Offers --}}

        {{-- Best seller products --}}
        {{-- <div class="row x-y-shadow py-2 py-md-3 px-0 mt-2 bg-white mt-4" id="section_featured">
        </div> --}}
        {{-- Best seller products --}}

        {{-- best seller category --}}
        @if (count($best_seller_category) > 0)

        <div class="row x-y-shadow py-2 py-md-3 px-0 mt-2 bg-white mt-4" id="sadar_recomendation">
            <div class="px-2 py-4 px-md-4 py-md-3 bg-white rounded">
                <div class="d-flex mb-3 align-items-baseline border-bottom justify-content-center">
                    <h3 class="h5 fw-700 mb-0">
                        <span
                            class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Best Sellers Category') }}</span>
                    </h3>
                </div>
                <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="6" data-xl-items="5"
                    data-lg-items="4" data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true'
                    data-infinite='true' data-autoplay='true'>
                    @foreach ($best_seller_category as $best_seller)
                        <div class="carousel-box">
                            <div
                                class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
                                <a href="{{ $best_seller['best_seller_category_links'] }}" target="_blank"
                                    class="d-block">
                                    <img class="img-fit lazyload mx-auto"
                                        src="{{ $best_seller['best_seller_category_images'] }}"
                                        data-src="{{ $best_seller['best_seller_category_images'] }}" alt="Whats hot"
                                        style="object-fit: scale-down;" />
                                    <h4 class="font-weight-normal text-center">
                                        {{ $best_seller['best_seller_category_heading'] }}</h4>
                                    <h5 class=" text-center font-weight-normal" style="color:#007345;">
                                        {{ $best_seller['best_seller_category_offer'] }}</h5>
                                    <h5 class="  text-center font-weight-normal" style="color:#858585;">
                                        {{ $best_seller['best_seller_category_tag'] }}</h5>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
        {{-- best seller category --}}
        {{-- <div class="row x-y-shadow py-2 py-md-3 mt-2 bg-white mt-4">
            <div class="col-12 col-md-6 img-hover-zoom-out-colorize" style="position:relative;">
                <a href="category/soft-toys" style="position:relative;" class="d-block">
                    <img src="{{ static_asset('assets/img/temp-bottom-banners/vanessa-bucceri-gDiRwIYAMA8-unsplash.jpg') }}"
                        alt="{{ env('APP_NAME') }} SALE" class="img-fluid lazyload w-100">
                    <div class="row"
                        style="bottom: 0;
                                                                                position: absolute;
                                                                                right: 0;
                                                                                width: 100%;">
                        <div class="col-12 py-1 py-md-4 slide-right d-table"
                            style="background-color: #ff4b4b73 !important;">
                            <h3 class="text-white pl-0 pl-md-4 font-weight-bold mb-0 mb-md-auto">Kids Toys & Games</h3>
                            <h6 class="text-white pl-0 pl-md-4 font-weight-bold mb-0 mb-md-auto">Amazing collection for
                                your
                                little ones.
                            </h6>
                        </div>
                    </div>
                </a>

            </div>
            <div class="col-12 col-md-6 img-hover-zoom-out-colorize" style="position:relative;">
                <a href="category/women-s-fashion" style="position:relative;" class="d-block">
                    <img src="{{ static_asset('assets/img/temp-bottom-banners/freestocks-_3Q3tsJ01nc-unsplash.jpg') }}"
                        alt="{{ env('APP_NAME') }} SALE" class="img-fluid lazyload w-100">
                    <div class="row"
                        style="bottom: 0;
                                                                    position: absolute;
                                                                    right: 0;
                                                                    width: 100%;">
                        <div class="col-12 py-1 py-md-4 slide-right d-table"
                            style="background-color: #ff4b4b73 !important;">
                            <h3 class="text-white pl-0 pl-md-4 font-weight-bold mb-0 mb-md-auto">Women's fashion</h3>
                            <h6 class="text-white pl-0 pl-md-4 font-weight-bold mb-0 mb-md-auto">Shop now at best prices at
                                Sadar24.</h6>
                        </div>
                    </div>
                </a>
            </div>
        </div> --}}
        {{-- Recomended products --}}
        @if (count($recommended_on_sadar) > 0)
        <div class="row x-y-shadow py-2 py-md-3 px-0 mt-2 bg-white mt-4" id="sadar_recomendation">
            <div class="px-2 py-4 px-md-4 py-md-3 bg-white rounded">
                <div class="d-flex mb-3 align-items-baseline border-bottom justify-content-center">
                    <h3 class="h5 fw-700 mb-0">
                        <span
                            class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Recommended on Sadar 24') }}</span>
                    </h3>
                </div>
                <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="8" data-xl-items="8"
                    data-lg-items="5" data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true'
                    data-infinite='true' data-autoplay='true'>
                    @foreach ($recommended_on_sadar as $recommended)
                    <div class="carousel-box">
                        <div
                            class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
                            <a href="{{ $recommended['recommended_on_sadar_links'] }}" target="_blank"
                                class="d-block">
                                <img class="img-fit lazyload mx-auto"
                                    src="{{ $recommended['recommended_on_sadar_images'] }}"
                                    data-src="{{ $recommended['recommended_on_sadar_images'] }}" alt="Whats hot"
                                    style="object-fit: scale-down;" />
                                <h4 class="font-weight-normal text-center">
                                    {{ $recommended['recommended_on_sadar_heading'] }}</h4>
                                <h5 class=" text-center font-weight-normal" style="color:#007345;">
                                    {{ $recommended['recommended_on_sadar_offer'] }}</h5>
                                <h5 class="  text-center font-weight-normal" style="color:#858585;">
                                    {{ $recommended['recommended_on_sadar_tag'] }}</h5>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
        {{-- Recomended products --}}
        {{-- Category Products --}}
        <div class="row x-y-shadow py-2 py-md-3 px-0 bg-white mt-2 mt-4">
            <div class="col-12 px-0" id="category_catalogue_products">
                {{-- {{dd($featured_categories)}} --}}
                @foreach ($featured_categories as $i => $featured)
                    <div class="row mt-2 mt-4">
                        <div class="col-0 col-md-2 col-lg-2 px-0 d-none d-md-block" id="fro1-co{{ $i }}">
                            <img src="{{ $featured['desktop_banner'] }}" class="h-100 w-100"
                                style="object-fit: contain;" alt="">
                        </div>
                        <div class="col-12 col-md-0 d-block d-md-none">
                            <img src="{{ $featured['mobile_banner'] }}" class="h-100 w-100"
                                style="object-fit: contain;" alt="">
                        </div>
                        <div class="col-12 col-md-10 col-lg-10" style="height:fit-content;"
                            id="fro2-co{{ $i }}">
                            <div class="aiz-carousel gutters-10 half-outside-arrow py-2" data-items="6" data-xl-items="6"
                                data-lg-items="4" data-md-items="3" data-sm-items="2" data-xs-items="2"
                                data-arrows='true' data-infinite='true'>
                                @foreach ($featured['products_link'] as $key => $product)
                                    @php
                                        $product = DB::table('products')
                                            ->where('slug', str_replace('https://sadar24.com/product/', '', $product))
                                            ->where('approved', '1')
                                            ->where('published', '1')
                                            ->select('products.id', 'products.slug', 'products.photos', 'products.name', 'products.rating', 'products.purchase_price', 'products.discount', 'products.unit_price', 'products.discount_type', 'products.holiday', 'products.discount_start_date', 'products.discount_end_date')
                                            ->first();
                                        // print_r($product);
                                    @endphp
                                    <div class="carousel-box">
                                        @if (isset($product->holiday))
                                            @if ($product->holiday == 0)
                                                <div
                                                    class="aiz-card-box rounded hov-shadow-md mt-0 ml-0 has-transition bg-white">
                                                    @php
                                                        $photos = explode(',', $product->photos);
                                                    @endphp
                                                    <div class="position-relative">
                                                        <a href="{{ route('product', $product->slug) }}"
                                                            class="d-block">
                                                            <img class="img-fit lazyload mx-auto h-140px h-md-210px"
                                                                style="object-fit: contain;"
                                                                src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                                data-src="{{ uploaded_asset($photos[0]) }}"
                                                                {{-- @endif --}} alt="{{ $product->name }}"
                                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                                style="object-fit: scale-down;">
                                                        </a>
                                                        <div class="absolute-top-right aiz-p-hov-icon">
                                                            <a href="javascript:void(0)"
                                                                onclick="addToWishList({{ $product->id }})"
                                                                data-toggle="tooltip"
                                                                data-title="{{ translate('Add to wishlist') }}"
                                                                data-placement="left">
                                                                <i class="la la-heart-o"></i>
                                                            </a>
                                                            <a href="javascript:void(0)"
                                                                onclick="addToCompare({{ $product->id }})"
                                                                data-toggle="tooltip"
                                                                data-title="{{ translate('Add to compare') }}"
                                                                data-placement="left">
                                                                <i class="las la-sync"></i>
                                                            </a>
                                                            <a href="javascript:void(0)"
                                                                onclick="showAddToCartModal({{ $product->id }})"
                                                                data-toggle="tooltip"
                                                                data-title="{{ translate('Add to cart') }}"
                                                                data-placement="left">
                                                                <i class="las la-shopping-cart"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="p-md-3 p-2 text-left">
                                                        <div class="rating rating-sm mt-1">
                                                            {{ renderStarRating($product->rating) }}
                                                        </div>
                                                        <h3
                                                            class="fw-500 fs-13 text-truncate lh-1-4 mb-0 h-35px text-left">
                                                            <a href="{{ route('product', $product->slug) }}"
                                                                class="d-block text-reset">{{ $product->name }}</a>
                                                        </h3>
                                                        <div class="fs-15 d-flex text-center">
                                                            {{-- {{dd($product)}} --}}
                                                            @php
                                                                $list_price = $product->purchase_price != 0 ? $product->purchase_price : $product->unit_price;
                                                                $discount_price = $list_price - $product->discount;
                                                                $discount = $list_price - $discount_price;
                                                                settype($list_price, 'float');
                                                                settype($discount_price, 'float');
                                                                $discount_percentage = ($discount / $list_price) * 100;
                                                                $discount_percentage = round($discount_percentage, 0);
                                                                $final_price = $product->unit_price;
                                                            @endphp
                                                            @if ($product->discount_type == 'amount')
                                                                @php
                                                                    $list_price = $product->unit_price;
                                                                    $discount_price = $list_price - $product->discount;
                                                                    settype($list_price, 'float');
                                                                    settype($discount_price, 'float');
                                                                    $discount = $list_price - $discount_price;
                                                                    $discount_percentage = ($discount / $list_price) * 100;
                                                                    $discount_percentage = round($discount_percentage, 0);
                                                                    $final_price = $product->unit_price - $product->discount;
                                                                    
                                                                @endphp
                                                            @else
                                                                @php
                                                                    $discount_percentage = $product->discount;
                                                                    $final_price = round(($product->unit_price / 100) * (100 - $product->discount));
                                                                    
                                                                @endphp
                                                            @endif
                                                            {{-- {{dd($product->unit_price,$final_price)}} --}}
                                                            {{-- <span class="fw-700 text-light-gray">MRP: </span> --}}
                                                            @if (home_base_price($product) != home_discounted_base_price($product))
                                                                <del
                                                                    class="fw-600 opacity-50 mr-1">{{ format_price($product->unit_price) }}</del>
                                                            @endif
                                                            <span
                                                                class="fw-700 text-primary">{{ format_price($final_price) }}</span>
                                                        </div>
                                                        @if (addon_is_activated('club_point'))
                                                            <div
                                                                class="rounded px-2 mt-2 bg-soft-primary border-soft-primary border">
                                                                {{ translate('Club Point') }}:
                                                                <span
                                                                    class="fw-700 float-right">{{ $product->earn_point }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        @endif

                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <script language="javascript" type="text/javascript">
                        document.getElementById(`fro1-co{{ $i }}`).style.height = document.getElementById(
                            `fro2-co{{ $i }}`).clientHeight + "px";
                        window.addEventListener('resize', resizeSlide);

                        function resizeSlide() {
                            document.getElementById(`fro1-co{{ $i }}`).style.height = document.getElementById(
                                `fro2-co{{ $i }}`).clientHeight + "px";
                        }
                    </script>
                @endforeach
                {{-- testing prototype --}}
                {{-- @php
                    $i = 0;
                    $status = 'true';
                    $lang = 'en';
                @endphp --}}
                {{-- @while ($status == 'true')
                    @if (get_setting('featured_category_desktop_banner_' . $i . '') != null)
                        <div class="row mt-2 mt-4">
                            <div class="col-0 col-md-2 col-lg-2 px-0 d-none d-md-block" id="fro1-co{{ $i }}">
                                <img src="{{ uploaded_asset(get_setting('featured_category_desktop_banner_' . $i . '')) }}"
                                    class="h-100 w-100" style="object-fit: contain;" alt="">
                            </div>
                            <div class="col-12 col-md-0 d-block d-md-none">
                                <img src="{{ uploaded_asset(get_setting('featured_category_mobile_banner_' . $i . '')) }}"
                                    class="h-100 w-100" style="object-fit: contain;" alt="">
                            </div>
                            @php
                                $featured_products = json_decode(get_setting('featured_category_' . $i . '_links', null, $lang));
                            @endphp
                            <div class="col-12 col-md-10 col-lg-10" style="height:fit-content;"
                                id="fro2-co{{ $i }}">
                                <div class="aiz-carousel gutters-10 half-outside-arrow py-2" data-items="6"
                                    data-xl-items="6" data-lg-items="4" data-md-items="3" data-sm-items="2"
                                    data-xs-items="2" data-arrows='true' data-infinite='true'>
                                    @foreach ($featured_products as $key => $product)
                                        @php
                                            $product = DB::table('products')
                                                ->where('slug', str_replace('https://sadar24.com/product/', '', $product))
                                                ->where('approved', '1')
                                                ->where('published', '1')
                                                ->select('products.id', 'products.slug', 'products.photos', 'products.name', 'products.rating', 'products.purchase_price', 'products.discount', 'products.unit_price', 'products.discount_type', 'products.holiday', 'products.discount_start_date', 'products.discount_end_date')
                                                ->first();
                                            // print_r($product);
                                        @endphp
                                        <div class="carousel-box">
                                            @if (isset($product->holiday))
                                                @if ($product->holiday == 0)
                                                    <div
                                                        class="aiz-card-box rounded hov-shadow-md mt-0 ml-0 has-transition bg-white">
                                                        @php
                                                            $photos = explode(',', $product->photos);
                                                        @endphp
                                                        <div class="position-relative">
                                                            <a href="{{ route('product', $product->slug) }}"
                                                                class="d-block">
                                                                <img class="img-fit lazyload mx-auto h-140px h-md-210px"
                                                                    style="object-fit: contain;" 
                                                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                                    data-src="{{ uploaded_asset($photos[0]) }}"
                                                                     alt="{{ $product->name }}"
                                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                                    style="object-fit: scale-down;">
                                                            </a>
                                                            <div class="absolute-top-right aiz-p-hov-icon">
                                                                <a href="javascript:void(0)"
                                                                    onclick="addToWishList({{ $product->id }})"
                                                                    data-toggle="tooltip"
                                                                    data-title="{{ translate('Add to wishlist') }}"
                                                                    data-placement="left">
                                                                    <i class="la la-heart-o"></i>
                                                                </a>
                                                                <a href="javascript:void(0)"
                                                                    onclick="addToCompare({{ $product->id }})"
                                                                    data-toggle="tooltip"
                                                                    data-title="{{ translate('Add to compare') }}"
                                                                    data-placement="left">
                                                                    <i class="las la-sync"></i>
                                                                </a>
                                                                <a href="javascript:void(0)"
                                                                    onclick="showAddToCartModal({{ $product->id }})"
                                                                    data-toggle="tooltip"
                                                                    data-title="{{ translate('Add to cart') }}"
                                                                    data-placement="left">
                                                                    <i class="las la-shopping-cart"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="p-md-3 p-2 text-left">
                                                            <div class="rating rating-sm mt-1">
                                                                {{ renderStarRating($product->rating) }}
                                                            </div>
                                                            <h3
                                                                class="fw-500 fs-13 text-truncate lh-1-4 mb-0 h-35px text-left">
                                                                <a href="{{ route('product', $product->slug) }}"
                                                                    class="d-block text-reset">{{ $product->name }}</a>
                                                            </h3>
                                                            <div class="fs-15 d-flex text-center">
                                                                @php
                                                                    $list_price = $product->purchase_price != 0 ? $product->purchase_price : $product->unit_price;
                                                                    $discount_price = $list_price - $product->discount;
                                                                    $discount = $list_price - $discount_price;
                                                                    settype($list_price, 'float');
                                                                    settype($discount_price, 'float');
                                                                    $discount_percentage = ($discount / $list_price) * 100;
                                                                    $discount_percentage = round($discount_percentage, 0);
                                                                    $final_price = $product->unit_price;
                                                                @endphp
                                                                @if ($product->discount_type == 'amount')
                                                                    @php
                                                                        $list_price = $product->unit_price;
                                                                        $discount_price = $list_price - $product->discount;
                                                                        settype($list_price, 'float');
                                                                        settype($discount_price, 'float');
                                                                        $discount = $list_price - $discount_price;
                                                                        $discount_percentage = ($discount / $list_price) * 100;
                                                                        $discount_percentage = round($discount_percentage, 0);
                                                                        $final_price = $product->unit_price - $product->discount;
                                                                        
                                                                    @endphp
                                                                @else
                                                                    @php
                                                                        $discount_percentage = $product->discount;
                                                                        $final_price = round(($product->unit_price / 100) * (100 - $product->discount));
                                                                        
                                                                    @endphp
                                                                @endif
                                                                @if (home_base_price($product) != home_discounted_base_price($product))
                                                                    <del
                                                                        class="fw-600 opacity-50 mr-1">{{ format_price($product->unit_price) }}</del>
                                                                @endif
                                                                <span
                                                                    class="fw-700 text-primary">{{ format_price($final_price) }}</span>
                                                            </div>
                                                            @if (addon_is_activated('club_point'))
                                                                <div
                                                                    class="rounded px-2 mt-2 bg-soft-primary border-soft-primary border">
                                                                    {{ translate('Club Point') }}:
                                                                    <span
                                                                        class="fw-700 float-right">{{ $product->earn_point }}</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif

                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <script language="javascript" type="text/javascript">
                            document.getElementById(`fro1-co{{ $i }}`).style.height = document.getElementById(
                                `fro2-co{{ $i }}`).clientHeight + "px";
                            window.addEventListener('resize', resizeSlide);

                            function resizeSlide() {
                                document.getElementById(`fro1-co{{ $i }}`).style.height = document.getElementById(
                                    `fro2-co{{ $i }}`).clientHeight + "px";
                            }
                        </script>
                        @php $i = ++$i; @endphp
                    @else
                        @if ($i == 0)
                        @else
                            @php
                                $status = 'false';
                            @endphp
                        @endif
                    @endif
                @endwhile --}}
                {{-- testing prototype --}}

            </div>
        </div>
        @if (count($deal_of_the_day) > 0)
        <div class="row x-y-shadow py-2 py-md-3 px-0 bg-white mt-2 mt-4">
            <div class="d-flex align-items-baseline border-bottom justify-content-center mb-4">
                <h3 class="h5 fw-700 mb-0">
                    <span
                        class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Deal Of The Day') }}</span>
                </h3>
            </div>
            @foreach ($deal_of_the_day as $deal)
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="category-box p-0 p-md-auto img-hover-zoom--colorize">
                        {{-- <h4>Home Decor</h4> --}}
                        <a href="{{ $deal['deal_of_the_day_links'] }}" target="_blank" class="img-link on-hov-dis-ef"
                            style="position:relative;"><img src="{{ $deal['deal_of_the_day_images'] }}"
                                {{-- src="{{my_asset('uploads/all/W6Im3NOUkoMA9iuaJK4LNbnn7bZ8On0roKb0QiHu.jpg')}}" --}} class="img-fit zoom" alt="sadar24">

                        </a>
                        <a href="{{ $deal['deal_of_the_day_links'] }}" target="_blank" class="custom-link"
                            target="_blank">{{ $deal['deal_of_the_day_heading'] }}</a>
                    </div>
                </div>
            @endforeach
        </div>
        @endif
        {{-- <div class="row x-y-shadow py-2 py-md-3 mt-2 bg-white mt-4" style="position: relative;">
            <div class="col-12 img-hover-zoom-out-colorize">
                <a href="https://sadar24.com/search?keyword=&brand=&sort_by=price-desc&min_price=0.00&max_price=199">
                    <img src="{{ static_asset('assets/img/temp-main-banner/sale banner.jpg') }}"
                        alt="{{ env('APP_NAME') }} SALE" class="img-fluid lazyload w-100">
                </a>
            </div>
            <div class="col-3 text-center d-none d-md-block" style="position:absolute; bottom:45%; left:70%;">
                <button class="btn btn-black btn-hover-zoom-out-colorize text-white bg-black font-weight-bold"
                    style="
                                                                                    width: 220px;
                                                                                    height: 75px;
                                                                                    font-size: 23px;
                                                                                ">SHOP
                    NOW</button>
            </div>
        </div> --}}

    </div>
    </div>
    <div class="row x-y-shadow px-0">
        <div class="container-fluid py-2 py-md-3" style="background-color: #19212a;">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="row">
                        <div class="col-12 col-md-5">
                            <div class="mb-md-3 mb-2 mb-lg-0 text-center">
                                {{-- <span class="text-white">See personalized recommendations</span><br /> --}}
                                <a href="https://sadar24.com/users/login"
                                    class="btn btn-primary btn-sm btn-block text-white">
                                    Sign in
                                </a>
                                <span class='text-white'>New customer? <a href="https://sadar24.com/users/registration"
                                        class="text-white" style="text-decoration: underline;">Start here.</a></span>
                            </div>
                        </div>
                        {{-- <div class="col-12 col-md-7">
                            <h4 class="text-white">Access information article, our latest deals, products launches.</h4>
                        </div> --}}
                    </div>
                </div>
                <div class="col-12 col-md-6 align-self-center">
                    <div class="row">
                        <div class="col-12">
                            <form class="form-inline" method="POST" action="{{ route('subscribers.store') }}">
                                @csrf
                                <div class="form-group mb-0 col col-md-8 pl-0">
                                    <input type="email" class="form-control w-100"
                                        placeholder="{{ translate('Your Email Address') }}" name="email" required>
                                </div>
                                <button type="submit" class="btn btn-primary col-auto col-md-4">
                                    {{ translate('Subscribe') }}
                                </button>
                                <div class="col-12 px-0">
                                    <span class='text-white'>Subscribe to get 10% off on your first order!</span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('script')
        <script>
            $(document).ready(function() {
                // $.post('{{ route('home.section.category_catalogue_products') }}', {
                //     _token: '{{ csrf_token() }}'
                // }, function(data) {
                //     $('#category_catalogue_products').html(data);
                //     AIZ.plugins.slickCarousel();
                // });
                // $.post('{{ route('home.section.whats_new_products') }}', {
                //     _token: '{{ csrf_token() }}'
                // }, function(data) {
                //     $('#section_whats_new_products').html(data);
                //     AIZ.plugins.slickCarousel();
                // });
                // $.post('{{ route('home.section.best_sellers') }}', {
                //     _token: '{{ csrf_token() }}'
                // }, function(data) {
                //     $('#section_best_sellers').html(data);
                //     AIZ.plugins.slickCarousel();
                // });
                // $.post('{{ route('home.section.featured') }}', {
                //     _token: '{{ csrf_token() }}'
                // }, function(data) {
                //     $('#section_featured').html(data);
                //     AIZ.plugins.slickCarousel();
                // });

                // $.post('{{ route('home.section.best_selling') }}', {
                //     _token: '{{ csrf_token() }}'
                // }, function(data) {
                //     $('#section_best_selling').html(data);
                //     AIZ.plugins.slickCarousel();
                // });
                // $.post('{{ route('home.section.auction_products') }}', {
                //     _token: '{{ csrf_token() }}'
                // }, function(data) {
                //     $('#auction_products').html(data);
                //     AIZ.plugins.slickCarousel();
                // });
                // $.post('{{ route('home.section.home_categories') }}', {
                //     _token: '{{ csrf_token() }}'
                // }, function(data) {
                //     $('#section_home_categories').html(data);
                //     AIZ.plugins.slickCarousel();
                // });


            });
        </script>
    @endsection
