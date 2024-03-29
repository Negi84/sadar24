@if (count($featured_products) > 0)
    <section class="">
        <div class="container-fluid px-0">
            <div class="px-2 py-4 px-md-4 py-md-3 bg-white rounded">
                <div class="d-flex mb-3 align-items-baseline  border-bottom justify-content-center">
                    <h3 class="h5 fw-700 mb-0">
                        <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Best Sellers @ Sadar 24') }}</span>
                    </h3>
                </div>
                <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="6" data-xl-items="5" data-lg-items="4"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true'>
                    @foreach ($featured_products as $key => $product)
                    <div class="carousel-box">
                        @include('frontend.partials.product_box_1',['product' => $product])
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>   
@endif