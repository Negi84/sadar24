@if (isset($product->holiday))
@if ($product->holiday == 0)
<div class="aiz-card-box rounded hov-shadow-md mt-0 ml-0 has-transition bg-white">
    @php
        $photos = explode(',', $product->photos);
    @endphp
    <div class="position-relative">
        <a href="{{ route('product', $product->slug) }}" class="d-block">
            <img class="img-fit lazyload mx-auto h-140px h-md-210px" style="object-fit: contain;" {{-- @if (count($photos) > 1)
                src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ uploaded_asset($photos[1]) }}"
                @else --}}
                src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ uploaded_asset($photos[0] == 0 ? $photos[1] : $photos[0]) }}"
                {{-- @endif --}} alt="{{ $product->name }}"
                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                style="object-fit: scale-down;">
        </a>
        <div class="absolute-top-right aiz-p-hov-icon">
            <a href="javascript:void(0)" onclick="addToWishList({{ $product->id }})" data-toggle="tooltip"
                data-title="{{ translate('Add to wishlist') }}" data-placement="left">
                <i class="la la-heart-o"></i>
            </a>
            <a href="javascript:void(0)" onclick="addToCompare({{ $product->id }})" data-toggle="tooltip"
                data-title="{{ translate('Add to compare') }}" data-placement="left">
                <i class="las la-sync"></i>
            </a>
            <a href="javascript:void(0)" onclick="showAddToCartModal({{ $product->id }})" data-toggle="tooltip"
                data-title="{{ translate('Add to cart') }}" data-placement="left">
                <i class="las la-shopping-cart"></i>
            </a>
        </div>
    </div>
    <div class="p-md-3 p-2 text-left">
        <div class="rating rating-sm mt-1">
            {{ renderStarRating($product->rating) }}
        </div>
        <h3 class="fw-500 fs-13 text-truncate lh-1-4 mb-0 h-35px text-left">
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
                <del class="fw-600 opacity-50 mr-1">{{ format_price($product->unit_price) }}</del>
            @endif
            <span class="fw-700 text-primary">{{ format_price($final_price) }}</span>
        </div>
        @if (addon_is_activated('club_point'))
            <div class="rounded px-2 mt-2 bg-soft-primary border-soft-primary border">
                {{ translate('Club Point') }}:
                <span class="fw-700 float-right">{{ $product->earn_point }}</span>
            </div>
        @endif
    </div>
</div>
@endif
@endif
