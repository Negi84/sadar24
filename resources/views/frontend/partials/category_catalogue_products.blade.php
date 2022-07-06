@php
$i = 0;
$status = 'true';
$lang ="en";
@endphp
@while ($status == 'true')
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
            <div class="col-12 col-md-10 col-lg-10" style="height:fit-content;" id="fro2-co{{ $i }}">
                <div class="aiz-carousel gutters-10 half-outside-arrow py-2" data-items="6" data-xl-items="6"
                    data-lg-items="4" data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true'
                    data-infinite='true'>
                    @foreach ($featured_products as $key => $product)
                        @php
                            $product = DB::table('products')->where('slug', str_replace('https://sadar24.com/product/', '', $product))
                                ->where('approved', '1')->where('published', '1')
                                ->select('products.id', 'products.slug', 'products.photos', 'products.name', 'products.rating', 'products.purchase_price', 'products.discount', 'products.unit_price', 'products.discount_type', 'products.holiday', 'products.discount_start_date','products.discount_end_date')
                                ->first();
                            // print_r($product);

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
@endwhile
