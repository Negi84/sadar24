@extends('frontend.layouts.app')

@section('content')
    {{-- Categories , Sliders . Today's deal --}}
    <div class="home-banner-area mt-1 mb-4">
        <div class="container-fluid" style="padding-right: 5px;padding-left: 5px;">
            <div class="row gutters-10 position-relative">               
                @php
                    $num_todays_deal = count($todays_deal_products);
                @endphp

                <div id="main_slider" class="@if($num_todays_deal > 0) col-lg-12 @else col-lg-12 @endif">
                    @if (get_setting('home_slider_images') != null)
                        <div class="aiz-carousel dots-inside-bottom mobile-img-auto-height" data-arrows="true" data-dots="true" data-autoplay="true">
                            @php $slider_images = json_decode(get_setting('home_slider_images'), true);  @endphp
                            @foreach ($slider_images as $key => $value)
                                <div class="carousel-box">
                                    <a href="{{ json_decode(get_setting('home_slider_links'), true)[$key] }}">
                                        <img
                                            class="d-block mw-100 img-fit rounded shadow-sm overflow-hidden"
                                            src="{{ uploaded_asset($slider_images[$key]) }}"
                                            alt="{{ env('APP_NAME')}} promo"
                                            @if(count($featured_categories) == 0)
                                            height="auto"
                                            @else
                                            height="auto"
                                            @endif
                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';"
                                        >
                                    </a>
                                </div>
                            @endforeach								
                        </div>
                    @endif
                    @if (count($featured_categories) > 0)
                        <ul class="list-unstyled mb-0 row gutters-5">
                            @foreach ($featured_categories as $key => $category)
                                <li class="minw-0 col-4 col-md mt-3">
                                    <a href="{{ route('products.category', $category->slug) }}" class="d-block rounded bg-white p-2 text-reset shadow-sm">
                                        <img src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ uploaded_asset($category->banner) }}" alt="{{ $category->getTranslation('name') }}" class="lazyload img-fit"  height="78" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';"/>
                                        <div class="text-truncate fs-12 fw-600 mt-2 opacity-70">{{ $category->getTranslation('name') }}</div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
 
	
	<div class="container-fluid mb-4 d-none d-md-block" style="margin-top: -20%;">
		<div class="row gutters- mb-4">
			<div class="col-md-4">
				<div class="category-box">
					<h4>Home Decor</h4>
					<a href="category/decoratives" target="_blank"" class="img-link"><img src="//sadar24.com/public/uploads/all/W6Im3NOUkoMA9iuaJK4LNbnn7bZ8On0roKb0QiHu.jpg" class="img-fit" alt="sadar24"></a>
					<a href="category/decoratives" target="_blank"" class="custom-link" target="_blank">See all offers</a>
				</div>
			</div>
			<div class="col-md-4">
				<div class="category-box">
					<h4>Kitchen Appliances</h4>
					<a href="category/kitchen-appliances" target="_blank"" class="img-link"><img src="//sadar24.com/public/uploads/all/iJ5B0yQ69CM3mVuUrXTeP4itmqWV9hpsubMFOd18.jpg" class="img-fit" alt="sadar24"></a>
					<a href="category/kitchen-appliances" target="_blank"" class="custom-link" target="_blank">See all offers</a>
				</div>
			</div>
			<div class="col-md-4">
				<div class="category-box">
					<h4>Fashion Jewellery</h4>
					<a href="category/fashion-jewellery" target="_blank"" class="img-link"><img src="//sadar24.com/public/uploads/all/F0KGwXgjTvb3GuC6uRFOnd7MYaFUMLpkb25pFxwg.jpg" class="img-fit" alt="sadar24"></a>
					<a href="category/fashion-jewellery" target="_blank"" class="custom-link" target="_blank">See all offers</a>
				</div>
			</div>
		</div>
		
		<div class="row gutters-10">
			<div class="col-md-4">
				<div class="category-box">
					<h4>Beauty & Personal Care</h4>
					<a href="category/beauty-and-personal-care" target="_blank" class="img-link"><img src="//sadar24.com/public/uploads/all/iXDYNWrchDR9mlXmNWIdFjMYpGRK1K0zJCc1nyPz.jpg" class="img-fit" alt="sadar24"></a>
					<a href="category/beauty-and-personal-care" target="_blank" class="custom-link" target="_blank">See all offers</a>
				</div>
			</div>
			<div class="col-md-4">
				<div class="category-box">
					<h4>Women's Fashion</h4>
					<a href="category/women-s-fashion" target="_blank"" class="img-link"><img src="//sadar24.com/public/uploads/all/v7UZI1dpUkMJcq9Ysf1gBBervI9iVoxuFNUtoNaF.jpg" class="img-fit" alt="sadar24"></a>
					<a href="category/women-s-fashion" target="_blank"" class="custom-link" target="_blank">See all offers</a>
				</div>
			</div>
			<div class="col-md-4">
				<div class="category-box">
					<h4>Kid's Store</h4>
					<a href="category/soft-toys" target="_blank"" class="img-link"><img src="//sadar24.com/public/uploads/all/vYqDRmfbOohvDqmt3FZvwXifs4awxwW4I8DtApoo.jpg" class="img-fit" alt="sadar24"></a>
					<a href="category/soft-toys" target="_blank"" class="custom-link" target="_blank">See all offers</a>
				</div>
			</div>			
		</div>
	
	</div>
	
	<div class="container-fluid mb-2 d-block d-md-none" style="margin-top: -20%;">
		<div class="row gutters-10 mb-2">
			<div class="col-6 pr-1 pl-1">
				<div class="category-box p-2">					
					<a href="category/decoratives" target="_blank"" class="img-link"><img src="//sadar24.com/public/uploads/all/W6Im3NOUkoMA9iuaJK4LNbnn7bZ8On0roKb0QiHu.jpg" class="img-fit" alt="sadar24"></a>					
				</div>
			</div>
			<div class="col-6 pr-1 pl-1">
				<div class="category-box p-2">					
					<a href="category/kitchen-appliances" target="_blank"" class="img-link"><img src="//sadar24.com/public/uploads/all/iJ5B0yQ69CM3mVuUrXTeP4itmqWV9hpsubMFOd18.jpg" class="img-fit" alt="sadar24"></a>					
				</div>
			</div>
		</div>
		{{-- Banner section 1 --}}
		@if (get_setting('home_banner1_images') != null)
    
            <div class="row gutters-10 mb-2">
                @php $banner_1_imags = json_decode(get_setting('home_banner1_images')); @endphp
                @foreach ($banner_1_imags as $key => $value)
                    <div class="col-md-12 ">
                        <div class=" mb-lg-0">
                            <a href="{{ json_decode(get_setting('home_banner1_links'), true)[$key] }}" class="d-block text-reset">
                                <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" data-src="{{ uploaded_asset($banner_1_imags[$key]) }}" alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload w-100">
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>        
		@endif
		<div class="row gutters-10 mb-2">
			<div class="col-6 pr-1 pl-1">
				<div class="category-box p-2">					
					<a href="category/fashion-jewellery" target="_blank"" class="img-link"><img src="//sadar24.com/public/uploads/all/F0KGwXgjTvb3GuC6uRFOnd7MYaFUMLpkb25pFxwg.jpg" class="img-fit" alt="sadar24"></a>					
				</div>
			</div>
			<div class="col-6 pr-1 pl-1">
				<div class="category-box p-2">					
					<a href="category/beauty-and-personal-care" target="_blank" class="img-link"><img src="//sadar24.com/public/uploads/all/iXDYNWrchDR9mlXmNWIdFjMYpGRK1K0zJCc1nyPz.jpg" class="img-fit" alt="sadar24"></a>					
				</div>
			</div>
		</div>
		
		<div class="row gutters-10">
			<div class="col-6 pr-1 pl-1">
				<div class="category-box p-2">					
					<a href="category/women-s-fashion" target="_blank"" class="img-link"><img src="//sadar24.com/public/uploads/all/v7UZI1dpUkMJcq9Ysf1gBBervI9iVoxuFNUtoNaF.jpg" class="img-fit" alt="sadar24"></a>					
				</div>
			</div>
			<div class="col-6 pr-1 pl-1">
				<div class="category-box p-2">					
					<a href="category/soft-toys" target="_blank"" class="img-link"><img src="//sadar24.com/public/uploads/all/M7dcgWREwsBD0pJtGsrp33ovZhbj7JFLlALFflZA.jpg" class="img-fit" alt="sadar24"></a>					
				</div>
			</div>			
		</div>	
	</div>	
	
	{{-- Flash Deal --}}
    @php
        $flash_deal = \App\FlashDeal::where('status', 1)->where('featured', 1)->first();
    @endphp
    @if($flash_deal != null && strtotime(date('Y-m-d H:i:s')) >= $flash_deal->start_date && strtotime(date('Y-m-d H:i:s')) <= $flash_deal->end_date)
    <section class="mb-4">
        <div class="container-fluid">
            <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">

                <div class="d-flex flex-wrap mb-3 align-items-baseline border-bottom">
                    <h3 class="h5 fw-700 mb-0">
                        <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Flash Sale') }}</span>
                    </h3>
                    <div class="aiz-count-down ml-auto ml-lg-3 align-items-center" data-date="{{ date('Y/m/d H:i:s', $flash_deal->end_date) }}"></div>
                    <a href="{{ route('flash-deal-details', $flash_deal->slug) }}" class="ml-auto mr-0 btn btn-primary btn-sm shadow-md w-100 w-md-auto">{{ translate('View More') }}</a>
                </div>

                <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="6" data-xl-items="5" data-lg-items="4"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true'>
                    @foreach ($flash_deal->flash_deal_products->take(20) as $key => $flash_deal_product)
                        @php
                            $product = \App\Product::find($flash_deal_product->product_id);
                        @endphp
                        @if ($product != null && $product->published != 0)
                            <div class="carousel-box">
                                @include('frontend.partials.product_box_1',['product' => $product])
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif
	
	
	 {{-- Banner section 1 --}}
    @if (get_setting('home_banner1_images') != null)
    <div class="d-none d-md-block">
        <div class="container-fluid">
            <div class="row gutters-10">
                @php $banner_1_imags = json_decode(get_setting('home_banner1_images')); @endphp
                @foreach ($banner_1_imags as $key => $value)
                    <div class="col-md-12 mb-4">
                        <div class="mb-3 mb-lg-0">
                            <a href="{{ json_decode(get_setting('home_banner1_links'), true)[$key] }}" class="d-block text-reset">
                                <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" data-src="{{ uploaded_asset($banner_1_imags[$key]) }}" alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload w-100">
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
	
	{{-- Featured Section --}}
    <div id="section_featured">

    </div>
	
	{{-- Banner Section 2 --}}
    @if (get_setting('home_banner2_images') != null)
    <div class="mb-md-4 ">
        <div class="container-fluid">
			<div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
				<div class="row gutters-10">
					@php $banner_2_imags = json_decode(get_setting('home_banner2_images')); @endphp
					@foreach ($banner_2_imags as $key => $value)
						<div class="col-xl col-4 col-md-4">
							<div class="mb-md-3 mb-2 mb-lg-0">
								<a href="{{ json_decode(get_setting('home_banner2_links'), true)[$key] }}" target="_blank" class="d-block text-reset">
									<img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" data-src="{{ uploaded_asset($banner_2_imags[$key]) }}" alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload w-100">
								</a>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>
    </div>
    @endif

	<section class="mb-md-4 mb-2">
		<div class="container-fluid">
			<div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
				<div class="d-flex mb-3 align-items-baseline border-bottom">
					<h3 class="h5 fw-700 mb-0">
						<span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Recommended on Sadar 24') }}</span>
					</h3>
				</div>
				<div class="aiz-carousel gutters-10 half-outside-arrow" data-items="6" data-xl-items="5" data-lg-items="4"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true' data-infinite='true' data-autoplay='true'>
					<div class="carousel-box">
						<div class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
							<a href="smart-search?keyword=aromasia" target="_blank" class="d-block">
								<img class="img-fit lazyload mx-auto" src="//sadar24.com/public/uploads/all/VmezZtAw7O9jPbY2UdPoczFeTu8iYvUPGC2yeppM.jpg"	data-src="//sadar24.com/public/uploads/all/VmezZtAw7O9jPbY2UdPoczFeTu8iYvUPGC2yeppM.jpg" alt="Whats hot" style="object-fit: scale-down;"/>
							</a>									
						</div>
					</div>	
					<div class="carousel-box">
						<div class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
							<a href="smart-search?keyword=gizmore" target="_blank" class="d-block">
								<img class="img-fit lazyload mx-auto" src="//sadar24.com/public/uploads/all/keKqqsWoZVqvQoczFvBj4dDN5EFOifLS4EvIO7v2.jpg" data-src="//sadar24.com/public/uploads/all/keKqqsWoZVqvQoczFvBj4dDN5EFOifLS4EvIO7v2.jpg" alt="Whats hot" style="object-fit: scale-down;"/>
							</a>									
						</div>
					</div>	
					<div class="carousel-box">
						<div class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
							<a href="https://sadar24.com/category/stationary" class="d-block">
								<img class="img-fit lazyload mx-auto" src="//sadar24.com/public/uploads/all/cfgnbba6m68Bk1xYty2gfztc8sTIY6WU7nawmmtm.jpg" data-src="//sadar24.com/public/uploads/all/cfgnbba6m68Bk1xYty2gfztc8sTIY6WU7nawmmtm.jpg" alt="Whats hot" style="object-fit: scale-down;"/>
							</a>									
						</div>
					</div>
					<div class="carousel-box">
						<div class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
							<a href="https://sadar24.com/category/bedsheets" class="d-block">
								<img class="img-fit lazyload mx-auto" src="//sadar24.com/public/uploads/all/W6xJHlcvyHYPokTMqL9C3hV0IBYyJSpGMA3AzOVm.jpg" data-src="//sadar24.com/public/uploads/all/W6xJHlcvyHYPokTMqL9C3hV0IBYyJSpGMA3AzOVm.jpg" alt="Whats hot" style="object-fit: scale-down;"/>
							</a>									
						</div>
					</div>
					<div class="carousel-box">
						<div class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
							<a href="https://sadar24.com/category/candles-and-more" class="d-block">
								<img class="img-fit lazyload mx-auto" src="//sadar24.com/public/uploads/all/tnzEQ8R5jR8Od9jB27wmC5jlLYjdqZjwgQ8tFOLU.jpg" data-src="//sadar24.com/public/uploads/all/tnzEQ8R5jR8Od9jB27wmC5jlLYjdqZjwgQ8tFOLU.jpg" alt="Whats hot" style="object-fit: scale-down;"/>
							</a>
						</div>
					</div>
					<div class="carousel-box">
						<div class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
							<a href="https://sadar24.com/category/kitchen-and-dining" class="d-block">
								<img class="img-fit lazyload mx-auto" src="//sadar24.com/public/uploads/all/ypttmDvUYAYqf72497wBaZdO2KEBtBECi6TNwac8.jpg" data-src="//sadar24.com/public/uploads/all/ypttmDvUYAYqf72497wBaZdO2KEBtBECi6TNwac8.jpg" alt="Whats hot" style="object-fit: scale-down;"/>
							</a>									
						</div>
					</div>
					<div class="carousel-box">
						<div class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
							<a href="https://sadar24.com/category/necklace-sets" class="d-block">
								<img class="img-fit lazyload mx-auto" src="//sadar24.com/public/uploads/all/ttDRTTpan62q62Svrp6CxYqHee3eHfrqIHchklIX.jpg" 		data-src="//sadar24.com/public/uploads/all/ttDRTTpan62q62Svrp6CxYqHee3eHfrqIHchklIX.jpg" alt="Whats hot" style="object-fit: scale-down;" />
							</a>									
						</div>
					</div>
					<div class="carousel-box">
						<div class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
							<a href="https://sadar24.com/category/lamp-and-lighting" class="d-block">
								<img class="img-fit lazyload mx-auto" src="//sadar24.com/public/uploads/all/mOhg07hL7gcANnXnPTlPvROTw1O0CVCNekiey33m.jpg" data-src="//sadar24.com/public/uploads/all/mOhg07hL7gcANnXnPTlPvROTw1O0CVCNekiey33m.jpg" alt="Whats hot"style="object-fit: scale-down;" />
							</a>									
						</div>
					</div>
					<div class="carousel-box">
						<div class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
							<a href="https://sadar24.com/category/hair-accesserioes" class="d-block">
								<img class="img-fit lazyload mx-auto" src="//sadar24.com/public/uploads/all/banner300x230Artboard3.jpg" data-src="//sadar24.com/public/uploads/all/banner300x230Artboard3.jpg" alt="Whats hot" style="object-fit: scale-down;"/>
							</a>
						</div>
					</div>
					<div class="carousel-box">
						<div class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
							<a href="https://sadar24.com/category/Gym-Accessories-9BBcE" class="d-block">
								<img class="img-fit lazyload mx-auto" src="//sadar24.com/public/uploads/all/banner300x230Artboard6.jpg" data-src="//sadar24.com/public/uploads/all/banner300x230Artboard6.jpg" alt="Whats hot" style="object-fit: scale-down;" >
							</a>									
						</div>
					</div>
					<div class="carousel-box">
						<div class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
							<a href="https://sadar24.com/category/toys-and-games" class="d-block">
								<img class="img-fit lazyload mx-auto" src="//sadar24.com/public/uploads/all/banner300x230Artboard5.jpg" data-src="//sadar24.com/public/uploads/all/banner300x230Artboard5.jpg" alt="Whats hot" style="object-fit: scale-down;" />
							</a>									
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	{{-- Banner Section 3 --}}
    @if (get_setting('home_banner3_images') != null)
    <div class="mb-md-4 ">
        <div class="container-fluid">
            <div class="row gutters-10">
                @php $banner_3_imags = json_decode(get_setting('home_banner3_images')); @endphp
                @foreach ($banner_3_imags as $key => $value)
                    <div class="col-xl col-4 col-md-4 ">
                        <div class="mb-md-3 mb-2 mb-lg-0">
                            <a href="{{ json_decode(get_setting('home_banner3_links'), true)[$key] }}" class="d-block text-reset">
                                <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" data-src="{{ uploaded_asset($banner_3_imags[$key]) }}" alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload w-100">
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
	
	{{-- Best Selling  --}}
    <div id="section_best_selling">

    </div>
	
	
	<div class="mb-md-4 mb-2">
		<div class="container-fluid">
            <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                <div class="d-flex mb-3 align-items-baseline border-bottom">
                    
                </div>
				<div class="col-lg-3 col-md-4 m-auto">
					<div class="mb-md-3 mb-2 mb-lg-0 text-center">
						<span>See personalized recommendations</span><br/>
						<a href="https://sadar24.com/users/login" class="btn btn-primary btn-sm btn-block">
							Sign in
						</a> 
						<span>New customer? <a href="https://sadar24.com/users/registration">Start here.</a></span>
					</div>
				</div>
				<div class="d-flex align-items-baseline border-bottom">
                    
                </div>                
            </div>
        </div>	
	</div>
   <!-- {{-- Category wise Products --}}
    <div id="section_home_categories">

    </div>  -->
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $.post('{{ route('home.section.featured') }}', {_token:'{{ csrf_token() }}'}, function(data){
                $('#section_featured').html(data);
                AIZ.plugins.slickCarousel();
            });
            $.post('{{ route('home.section.best_selling') }}', {_token:'{{ csrf_token() }}'}, function(data){
                $('#section_best_selling').html(data);
                AIZ.plugins.slickCarousel();
            });
            $.post('{{ route('home.section.auction_products') }}', {_token:'{{ csrf_token() }}'}, function(data){
                $('#auction_products').html(data);
                AIZ.plugins.slickCarousel();
            });
            $.post('{{ route('home.section.home_categories') }}', {_token:'{{ csrf_token() }}'}, function(data){
                $('#section_home_categories').html(data);
                AIZ.plugins.slickCarousel();
            });
            $.post('{{ route('home.section.best_sellers') }}', {_token:'{{ csrf_token() }}'}, function(data){
                $('#section_best_sellers').html(data);
                AIZ.plugins.slickCarousel();
            });
        });
    </script>
@endsection
