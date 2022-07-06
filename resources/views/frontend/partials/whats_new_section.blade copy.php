@php
$best_selling_products = Cache::remember('best_selling_products', 100, function () {
    return filter_products(\App\Product::where('published', 1)->orderBy('num_of_sale', 'desc'))
        ->limit(20)
        ->get();
});
@endphp

@if (get_setting('best_selling') == 1)
    <div class="col-0 col-md-12 d-none d-md-block">
        @foreach ($best_selling_products as $key => $product)
            <div class="row my-1">
                <div class="col-2 px-0">
                    <img class="img-fit lazyload mx-auto" style="object-fit: contain;"
                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                        data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                        alt="{{ $product->getTranslation('name') }}"
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                        style="object-fit: scale-down;">
                </div>
                <div class="col">
                    <div class="row">
                        <a href="{{ route('product', $product->slug) }}"
                            class="text-reset text-truncate">{{ $product->getTranslation('name') }}</a>
                    </div>
                    <div class="row">
                        @if (home_base_price($product) != home_discounted_base_price($product))
                            <del class="fw-600 opacity-50 mr-1">{{ home_base_price($product) }}</del>
                        @endif
                        <span class="fw-700 text-primary">{{ home_discounted_base_price($product) }}</span>
                    </div>
                    <div class="row">
                        @if (addon_is_activated('club_point'))
                            <div class="rounded px-2 mt-2 bg-soft-primary border-soft-primary border">
                                {{ translate('Club Point') }}:
                                <span class="fw-700 float-right">{{ $product->earn_point }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{-- horizontal scrolling Products --}}
    {{-- vertical scrolling Products --}}
    <div class="col-12 col-md-0 d-block d-md-none px-0">
        <div class="aiz-carousel gutters-10 half-outside-arrow py-2" data-items="5" data-xl-items="5" data-lg-items="4"
            data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true' data-infinite='true'>
            @foreach ($best_selling_products as $key => $product)
                <div class="carousel-box">
                    @include('frontend.partials.product_box_1', [
                        'product' => $product,
                    ])
                </div>
            @endforeach
        </div>
    </div>
@endif
{{-- vertical scrolling Products --}}

<script language="javascript" type="text/javascript">
    document.getElementById("ro1-co2").style.height = document.getElementById("ro1-co1").clientHeight + "px";
    window.addEventListener('resize', resizeSlide);

    function resizeSlide() {
        document.getElementById("ro1-co2").style.height = document.getElementById("ro1-co1").clientHeight +
            "px";
    }
</script>
