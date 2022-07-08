<?php $__env->startSection('content'); ?>
    <div class="container-fluid px-0 px-md-4 py-3">
        
        <div class="row x-y-shadow py-2 py-md-3 px-0 px-md-3 mt-0 mt-md-2 bg-white">
            
            <div class="col-12 px-0" style="height:fit-content;" id="ro1-co1">
                <div id="main_slider" class="carousel slide" data-bs-ride="carousel">
                    <?php if($slider_images != null): ?>
                        <div class="carousel-indicators">
                            <?php $__currentLoopData = $slider_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <button type="button" data-bs-target="#main_slider" data-bs-slide-to="<?php echo e($key); ?>"
                                    class="<?php if($key == 0): ?> active <?php endif; ?>" aria-current="true"
                                    aria-label="Slide <?php echo e($key); ?>"></button>
                                
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                    <?php if($slider_images != null): ?>
                        <div class="carousel-inner">
                            
                            <?php $__currentLoopData = $slider_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="carousel-item <?php if($key == 0): ?> active <?php endif; ?> ">
                                    <a href="<?php echo e(json_decode(get_setting('home_banner1_links'), true)[$key]); ?>">
                                        <img class="d-block mw-100 img-fit rounded shadow-sm overflow-hidden"
                                            src="<?php echo e(uploaded_asset($slider_images[$key])); ?>"
                                            alt="<?php echo e(env('APP_NAME')); ?> promo"
                                            onerror="this.onerror=null;this.src='<?php echo e(static_asset('assets/img/placeholder-rect.jpg')); ?>';">
                                    </a>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
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

            
        </div>
        
        <div class="row x-y-shadow py-2 py-md-3 px-0 bg-white mt-2 mt-4">
            <?php if(get_setting('home_banner2_images') != null): ?>
                <div class="">
                    <div class="container-fluid px-0">
                        <div class="py-2 px-0 py-md-3 bg-white rounded">
                            <div class="row px-0 gutters-10">
                                <?php $banner_2_imags = json_decode(get_setting('home_banner2_images')); ?>
                                
                                <div class="col-xl col-4 col-md-4">
                                    <div class="mb-md-3 mb-2 mb-lg-0">
                                        <a href="https://sadar24.com/search?keyword=&brand=&sort_by=price-desc&min_price=0.00&max_price=99"
                                            target="_blank" class="d-block text-reset">
                                            <img src="<?php echo e(static_asset('assets/img/placeholder-rect.jpg')); ?>"
                                                data-src="<?php echo e(static_asset('assets/img/temp-main-banner/Group 1.png')); ?>"
                                                alt="<?php echo e(env('APP_NAME')); ?> promo"
                                                class="img-fluid lazyload w-100  on-hov-shadow" style="border-radius:20px;">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xl col-4 col-md-4">
                                    <div class="mb-md-3 mb-2 mb-lg-0">
                                        <a href="https://sadar24.com/search?keyword=&brand=&sort_by=price-desc&min_price=0.00&max_price=149"
                                            target="_blank" class="d-block text-reset">
                                            <img src="<?php echo e(static_asset('assets/img/placeholder-rect.jpg')); ?>"
                                                data-src="<?php echo e(static_asset('assets/img/temp-main-banner/Group 2.png')); ?>"
                                                alt="<?php echo e(env('APP_NAME')); ?> promo"
                                                class="img-fluid lazyload w-100  on-hov-shadow" style="border-radius:20px;">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xl col-4 col-md-4">
                                    <div class="mb-md-3 mb-2 mb-lg-0">
                                        <a href="https://sadar24.com/search?keyword=&brand=&sort_by=price-desc&min_price=0.00&max_price=199"
                                            target="_blank" class="d-block text-reset">
                                            <img src="<?php echo e(static_asset('assets/img/placeholder-rect.jpg')); ?>"
                                                data-src="<?php echo e(static_asset('assets/img/temp-main-banner/Group 3.png')); ?>"
                                                alt="<?php echo e(env('APP_NAME')); ?> promo"
                                                class="img-fluid lazyload w-100  on-hov-shadow" style="border-radius:20px;">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xl col-4 col-md-4">
                                    <div class="mb-md-3 mb-2 mb-lg-0">
                                        <a href="https://sadar24.com/search?keyword=&brand=&sort_by=price-desc&min_price=0.00&max_price=249"
                                            target="_blank" class="d-block text-reset">
                                            <img src="<?php echo e(static_asset('assets/img/placeholder-rect.jpg')); ?>"
                                                data-src="<?php echo e(static_asset('assets/img/temp-main-banner/Group 4.png')); ?>"
                                                alt="<?php echo e(env('APP_NAME')); ?> promo"
                                                class="img-fluid lazyload w-100  on-hov-shadow" style="border-radius:20px;">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xl col-4 col-md-4">
                                    <div class="mb-md-3 mb-2 mb-lg-0">
                                        <a href="https://sadar24.com/search?keyword=&brand=&sort_by=price-desc&min_price=0.00&max_price=299"
                                            target="_blank" class="d-block text-reset">
                                            <img src="<?php echo e(static_asset('assets/img/placeholder-rect.jpg')); ?>"
                                                data-src="<?php echo e(static_asset('assets/img/temp-main-banner/Group 5.png')); ?>"
                                                alt="<?php echo e(env('APP_NAME')); ?> promo"
                                                class="img-fluid lazyload w-100  on-hov-shadow" style="border-radius:20px;">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xl col-4 col-md-4">
                                    <div class="mb-md-3 mb-2 mb-lg-0">
                                        <a href="https://sadar24.com/search?keyword=&brand=&sort_by=price-desc&min_price=0.00&max_price=349"
                                            target="_blank" class="d-block text-reset">
                                            <img src="<?php echo e(static_asset('assets/img/placeholder-rect.jpg')); ?>"
                                                data-src="<?php echo e(static_asset('assets/img/temp-main-banner/Group 6.png')); ?>"
                                                alt="<?php echo e(env('APP_NAME')); ?> promo"
                                                class="img-fluid lazyload w-100  on-hov-shadow"
                                                style="border-radius:20px;">
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        

        
        
        

        
        <?php if(count($best_seller_category) > 0): ?>
            <div class="row x-y-shadow py-2 py-md-3 px-0 mt-2 bg-white mt-4" id="sadar_recomendation">
                <div class="px-2 py-4 px-md-4 py-md-3 bg-white rounded">
                    <div class="d-flex mb-3 align-items-baseline border-bottom justify-content-center">
                        <h3 class="h5 fw-700 mb-0">
                            <span
                                class="border-bottom border-primary border-width-2 pb-3 d-inline-block"><?php echo e(translate('Best Sellers Category')); ?></span>
                        </h3>
                    </div>
                    <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="6" data-xl-items="5"
                        data-lg-items="4" data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true'
                        data-infinite='true' data-autoplay='true'>
                        <?php $__currentLoopData = $best_seller_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $best_seller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="carousel-box">
                                <div
                                    class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
                                    <a href="<?php echo e($best_seller['best_seller_category_links']); ?>" target="_blank"
                                        class="d-block">
                                        <img class="img-fit lazyload mx-auto"
                                            src="<?php echo e($best_seller['best_seller_category_images']); ?>"
                                            data-src="<?php echo e($best_seller['best_seller_category_images']); ?>"
                                            alt="Whats hot" style="object-fit: scale-down;" />
                                        <h4 class="font-weight-normal text-center">
                                            <?php echo e($best_seller['best_seller_category_heading']); ?></h4>
                                        <h5 class=" text-center font-weight-normal" style="color:#007345;">
                                            <?php echo e($best_seller['best_seller_category_offer']); ?></h5>
                                        <h5 class="  text-center font-weight-normal" style="color:#858585;">
                                            <?php echo e($best_seller['best_seller_category_tag']); ?></h5>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        
        
        <?php if(count($recommended_on_sadar) > 0): ?>
            <div class="row x-y-shadow py-2 py-md-3 px-0 mt-2 bg-white mt-4" id="sadar_recomendation">
                <div class="px-2 py-4 px-md-4 py-md-3 bg-white rounded">
                    <div class="d-flex mb-3 align-items-baseline border-bottom justify-content-center">
                        <h3 class="h5 fw-700 mb-0">
                            <span
                                class="border-bottom border-primary border-width-2 pb-3 d-inline-block"><?php echo e(translate('Recommended on Sadar 24')); ?></span>
                        </h3>
                    </div>
                    <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="8" data-xl-items="8"
                        data-lg-items="5" data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true'
                        data-infinite='true' data-autoplay='true'>
                        <?php $__currentLoopData = $recommended_on_sadar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recommended): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="carousel-box">
                                <div
                                    class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
                                    <a href="<?php echo e($recommended['recommended_on_sadar_links']); ?>" target="_blank"
                                        class="d-block">
                                        <img class="img-fit lazyload mx-auto"
                                            src="<?php echo e($recommended['recommended_on_sadar_images']); ?>"
                                            data-src="<?php echo e($recommended['recommended_on_sadar_images']); ?>"
                                            alt="Whats hot" style="object-fit: scale-down;" />
                                        <h4 class="font-weight-normal text-center">
                                            <?php echo e($recommended['recommended_on_sadar_heading']); ?></h4>
                                        <h5 class=" text-center font-weight-normal" style="color:#007345;">
                                            <?php echo e($recommended['recommended_on_sadar_offer']); ?></h5>
                                        <h5 class="  text-center font-weight-normal" style="color:#858585;">
                                            <?php echo e($recommended['recommended_on_sadar_tag']); ?></h5>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        
        <div class="row x-y-shadow py-2 py-md-3 px-0 bg-white mt-2 mt-4">
            <div class="col-12 px-0" id="category_catalogue_products">
                
                <?php $__currentLoopData = $featured_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $featured): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="row mt-2 mt-4">
                        <div class="col-0 col-md-2 col-lg-2 px-0 d-none d-md-block" id="fro1-co<?php echo e($i); ?>">
                            <img src="<?php echo e($featured['desktop_banner']); ?>" class="h-100 w-100"
                                style="object-fit: contain;" alt="">
                        </div>
                        <div class="col-12 col-md-0 d-block d-md-none">
                            <img src="<?php echo e($featured['mobile_banner']); ?>" class="h-100 w-100"
                                style="object-fit: contain;" alt="">
                        </div>
                        <div class="col-12 col-md-10 col-lg-10" style="height:fit-content;"
                            id="fro2-co<?php echo e($i); ?>">
                            <div class="aiz-carousel gutters-10 half-outside-arrow py-2" data-items="6" data-xl-items="6"
                                data-lg-items="4" data-md-items="3" data-sm-items="2" data-xs-items="2"
                                data-arrows='true' data-infinite='true'>
                                <?php $__currentLoopData = $featured['products_link']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $product = DB::table('products')
                                            ->where('slug', str_replace('https://sadar24.com/product/', '', $product))
                                            ->where('approved', '1')
                                            ->where('published', '1')
                                            ->select('products.id', 'products.slug', 'products.photos', 'products.name', 'products.rating', 'products.purchase_price', 'products.discount', 'products.unit_price', 'products.discount_type', 'products.holiday', 'products.discount_start_date', 'products.discount_end_date')
                                            ->first();
                                        // print_r($product);
                                    ?>
                                    <div class="carousel-box">
                                        <?php if(isset($product->holiday)): ?>
                                            <?php if($product->holiday == 0): ?>
                                                <div
                                                    class="aiz-card-box rounded hov-shadow-md mt-0 ml-0 has-transition bg-white">
                                                    <?php
                                                        $photos = explode(',', $product->photos);
                                                    ?>
                                                    <div class="position-relative">
                                                        <a href="<?php echo e(route('product', $product->slug)); ?>"
                                                            class="d-block">
                                                            <img class="img-fit lazyload mx-auto h-140px h-md-210px"
                                                                style="object-fit: contain;"
                                                                src="<?php echo e(static_asset('assets/img/placeholder.jpg')); ?>"
                                                                data-src="<?php echo e(uploaded_asset($photos[0])); ?>"
                                                                 alt="<?php echo e($product->name); ?>"
                                                                onerror="this.onerror=null;this.src='<?php echo e(static_asset('assets/img/placeholder.jpg')); ?>';"
                                                                style="object-fit: scale-down;">
                                                        </a>
                                                        <div class="absolute-top-right aiz-p-hov-icon">
                                                            <a href="javascript:void(0)"
                                                                onclick="addToWishList(<?php echo e($product->id); ?>)"
                                                                data-toggle="tooltip"
                                                                data-title="<?php echo e(translate('Add to wishlist')); ?>"
                                                                data-placement="left">
                                                                <i class="la la-heart-o"></i>
                                                            </a>
                                                            <a href="javascript:void(0)"
                                                                onclick="addToCompare(<?php echo e($product->id); ?>)"
                                                                data-toggle="tooltip"
                                                                data-title="<?php echo e(translate('Add to compare')); ?>"
                                                                data-placement="left">
                                                                <i class="las la-sync"></i>
                                                            </a>
                                                            <a href="javascript:void(0)"
                                                                onclick="showAddToCartModal(<?php echo e($product->id); ?>)"
                                                                data-toggle="tooltip"
                                                                data-title="<?php echo e(translate('Add to cart')); ?>"
                                                                data-placement="left">
                                                                <i class="las la-shopping-cart"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="p-md-3 p-2 text-left">
                                                        <div class="rating rating-sm mt-1">
                                                            <?php echo e(renderStarRating($product->rating)); ?>

                                                        </div>
                                                        <h3
                                                            class="fw-500 fs-13 text-truncate lh-1-4 mb-0 h-35px text-left">
                                                            <a href="<?php echo e(route('product', $product->slug)); ?>"
                                                                class="d-block text-reset"><?php echo e($product->name); ?></a>
                                                        </h3>
                                                        <div class="fs-15 d-flex text-center">
                                                            
                                                            <?php
                                                                $list_price = $product->purchase_price != 0 ? $product->purchase_price : $product->unit_price;
                                                                $discount_price = $list_price - $product->discount;
                                                                $discount = $list_price - $discount_price;
                                                                settype($list_price, 'float');
                                                                settype($discount_price, 'float');
                                                                $discount_percentage = ($discount / $list_price) * 100;
                                                                $discount_percentage = round($discount_percentage, 0);
                                                                $final_price = $product->unit_price;
                                                            ?>
                                                            <?php if($product->discount_type == 'amount'): ?>
                                                                <?php
                                                                    $list_price = $product->unit_price;
                                                                    $discount_price = $list_price - $product->discount;
                                                                    settype($list_price, 'float');
                                                                    settype($discount_price, 'float');
                                                                    $discount = $list_price - $discount_price;
                                                                    $discount_percentage = ($discount / $list_price) * 100;
                                                                    $discount_percentage = round($discount_percentage, 0);
                                                                    $final_price = $product->unit_price - $product->discount;
                                                                    
                                                                ?>
                                                            <?php else: ?>
                                                                <?php
                                                                    $discount_percentage = $product->discount;
                                                                    $final_price = round(($product->unit_price / 100) * (100 - $product->discount));
                                                                    
                                                                ?>
                                                            <?php endif; ?>
                                                            
                                                            
                                                            <?php if(home_base_price($product) != home_discounted_base_price($product)): ?>
                                                                <del
                                                                    class="fw-600 opacity-50 mr-1"><?php echo e(format_price($product->unit_price)); ?></del>
                                                            <?php endif; ?>
                                                            <span
                                                                class="fw-700 text-primary"><?php echo e(format_price($final_price)); ?></span>
                                                        </div>
                                                        <?php if(addon_is_activated('club_point')): ?>
                                                            <div
                                                                class="rounded px-2 mt-2 bg-soft-primary border-soft-primary border">
                                                                <?php echo e(translate('Club Point')); ?>:
                                                                <span
                                                                    class="fw-700 float-right"><?php echo e($product->earn_point); ?></span>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                    <script language="javascript" type="text/javascript">
                        document.getElementById(`fro1-co<?php echo e($i); ?>`).style.height = document.getElementById(
                            `fro2-co<?php echo e($i); ?>`).clientHeight + "px";
                        window.addEventListener('resize', resizeSlide);

                        function resizeSlide() {
                            document.getElementById(`fro1-co<?php echo e($i); ?>`).style.height = document.getElementById(
                                `fro2-co<?php echo e($i); ?>`).clientHeight + "px";
                        }
                    </script>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
                
                
                

            </div>
        </div>
        <?php if(count($deal_of_the_day) > 0): ?>
            <div class="row x-y-shadow py-2 py-md-3 px-0 bg-white mt-2 mt-4">
                <div class="d-flex align-items-baseline border-bottom justify-content-center mb-4">
                    <h3 class="h5 fw-700 mb-0">
                        <span
                            class="border-bottom border-primary border-width-2 pb-3 d-inline-block"><?php echo e(translate('Deal Of The Day')); ?></span>
                    </h3>
                </div>
                <?php $__currentLoopData = $deal_of_the_day; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-6 col-md-4 col-lg-2">
                        <div class="category-box p-0 p-md-auto img-hover-zoom--colorize">
                            
                            <a href="<?php echo e($deal['deal_of_the_day_links']); ?>" target="_blank"
                                class="img-link on-hov-dis-ef" style="position:relative;"><img
                                    src="<?php echo e($deal['deal_of_the_day_images']); ?>" 
                                    class="img-fit zoom" alt="sadar24">

                            </a>
                            <a href="<?php echo e($deal['deal_of_the_day_links']); ?>" target="_blank" class="custom-link"
                                target="_blank"><?php echo e($deal['deal_of_the_day_heading']); ?></a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
        

    </div>
    </div>
    <div class="row x-y-shadow px-0">
        <div class="container-fluid py-2 py-md-3" style="background-color: #19212a;">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="row">
                        <div class="col-12 col-md-5">
                            <div class="mb-md-3 mb-2 mb-lg-0 text-center">
                                
                                <a href="https://sadar24.com/users/login"
                                    class="btn btn-primary btn-sm btn-block text-white">
                                    Sign in
                                </a>
                                <span class='text-white'>New customer? <a href="https://sadar24.com/users/registration"
                                        class="text-white" style="text-decoration: underline;">Start here.</a></span>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="col-12 col-md-6 align-self-center">
                    <div class="row">
                        <div class="col-12">
                            <form class="form-inline" method="POST" action="<?php echo e(route('subscribers.store')); ?>">
                                <?php echo csrf_field(); ?>
                                <div class="form-group mb-0 col col-md-8 pl-0">
                                    <input type="email" class="form-control w-100"
                                        placeholder="<?php echo e(translate('Your Email Address')); ?>" name="email" required>
                                </div>
                                <button type="submit" class="btn btn-primary col-auto col-md-4">
                                    <?php echo e(translate('Subscribe')); ?>

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
    <?php $__env->stopSection(); ?>

    <?php $__env->startSection('script'); ?>
        <script>
            $(document).ready(function() {
                // $.post('<?php echo e(route('home.section.category_catalogue_products')); ?>', {
                //     _token: '<?php echo e(csrf_token()); ?>'
                // }, function(data) {
                //     $('#category_catalogue_products').html(data);
                //     AIZ.plugins.slickCarousel();
                // });
                // $.post('<?php echo e(route('home.section.whats_new_products')); ?>', {
                //     _token: '<?php echo e(csrf_token()); ?>'
                // }, function(data) {
                //     $('#section_whats_new_products').html(data);
                //     AIZ.plugins.slickCarousel();
                // });
                // $.post('<?php echo e(route('home.section.best_sellers')); ?>', {
                //     _token: '<?php echo e(csrf_token()); ?>'
                // }, function(data) {
                //     $('#section_best_sellers').html(data);
                //     AIZ.plugins.slickCarousel();
                // });
                // $.post('<?php echo e(route('home.section.featured')); ?>', {
                //     _token: '<?php echo e(csrf_token()); ?>'
                // }, function(data) {
                //     $('#section_featured').html(data);
                //     AIZ.plugins.slickCarousel();
                // });

                // $.post('<?php echo e(route('home.section.best_selling')); ?>', {
                //     _token: '<?php echo e(csrf_token()); ?>'
                // }, function(data) {
                //     $('#section_best_selling').html(data);
                //     AIZ.plugins.slickCarousel();
                // });
                // $.post('<?php echo e(route('home.section.auction_products')); ?>', {
                //     _token: '<?php echo e(csrf_token()); ?>'
                // }, function(data) {
                //     $('#auction_products').html(data);
                //     AIZ.plugins.slickCarousel();
                // });
                // $.post('<?php echo e(route('home.section.home_categories')); ?>', {
                //     _token: '<?php echo e(csrf_token()); ?>'
                // }, function(data) {
                //     $('#section_home_categories').html(data);
                //     AIZ.plugins.slickCarousel();
                // });


            });
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sadar24\resources\views/frontend/index.blade.php ENDPATH**/ ?>