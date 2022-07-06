<?php $__env->startSection('content'); ?>
    <div class="container-fluid px-0 px-md-4 py-3">
        
        <div class="row x-y-shadow py-2 py-md-3 px-0 px-md-3 mt-0 mt-md-2 bg-white">
            
            <div class="col-12 col-md-8 col-lg-8 px-0" style="height:fit-content;" id="ro1-co1">
                <div id="main_slider" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#main_slider" data-bs-slide-to="0" class="active"
                            aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#main_slider" data-bs-slide-to="1"
                            aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#main_slider" data-bs-slide-to="2"
                            aria-label="Slide 3"></button>
                        <button type="button" data-bs-target="#main_slider" data-bs-slide-to="3"
                            aria-label="Slide 4"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <a href="https://sadar24.com/category/women-s-fashion">
                                <img class="d-block mw-100 img-fit rounded shadow-sm overflow-hidden"
                                    src="<?php echo e(static_asset('assets/img/temp-main-banner/Website 1.jpg')); ?>"
                                    alt="<?php echo e(env('APP_NAME')); ?> promo"
                                    <?php if(count($featured_categories) == 0): ?> height="auto" <?php else: ?> height="auto" <?php endif; ?>
                                    onerror="this.onerror=null;this.src='<?php echo e(static_asset('assets/img/placeholder-rect.jpg')); ?>';">
                                
                            </a>
                        </div>
                        <div class="carousel-item">
                            <a href="https://sadar24.com/category/bags-and-luggage">
                                <img class="d-block mw-100 img-fit rounded shadow-sm overflow-hidden"
                                    src="<?php echo e(static_asset('assets/img/temp-main-banner/Website 2.jpg')); ?>"
                                    alt="<?php echo e(env('APP_NAME')); ?> promo"
                                    <?php if(count($featured_categories) == 0): ?> height="auto" <?php else: ?> height="auto" <?php endif; ?>
                                    onerror="this.onerror=null;this.src='<?php echo e(static_asset('assets/img/placeholder-rect.jpg')); ?>';">
                                
                            </a>

                        </div>
                        <div class="carousel-item">
                            <a href="https://sadar24.com/category/sports-and-fitness">
                                <img class="d-block mw-100 img-fit rounded shadow-sm overflow-hidden"
                                    src="<?php echo e(static_asset('assets/img/temp-main-banner/Website 3.jpg')); ?>"
                                    alt="<?php echo e(env('APP_NAME')); ?> promo"
                                    <?php if(count($featured_categories) == 0): ?> height="auto" <?php else: ?> height="auto" <?php endif; ?>
                                    onerror="this.onerror=null;this.src='<?php echo e(static_asset('assets/img/placeholder-rect.jpg')); ?>';">
                                
                            </a>

                        </div>
                        <div class="carousel-item">
                            <a href="https://sadar24.com/category/speakers--earphones-j1xeg">
                                <img class="d-block mw-100 img-fit rounded shadow-sm overflow-hidden"
                                    src="<?php echo e(static_asset('assets/img/temp-main-banner/Website 4.jpg')); ?>"
                                    alt="<?php echo e(env('APP_NAME')); ?> promo"
                                    <?php if(count($featured_categories) == 0): ?> height="auto" <?php else: ?> height="auto" <?php endif; ?>
                                    onerror="this.onerror=null;this.src='<?php echo e(static_asset('assets/img/placeholder-rect.jpg')); ?>';">
                                
                            </a>

                        </div>
                    </div>
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
            
            
            <div class="col-12 col-md-8 col-lg-8 px-0 d-none">
                <div class="home-banner-area mt-1">
                    <div class="container-fluid" style="padding-right: 5px;padding-left: 5px;">
                        <div class="row px-0 gutters-10 position-relative">
                            <?php
                                $num_todays_deal = count($todays_deal_products);
                            ?>
                            
                        </div>
                    </div>
                </div>
            </div>
            

            <div class="col-12 col-md-4 col-lg-4 mt-2 mt-md-0 h-scroll" style="min-height: 295px;" id="ro1-co2">
                <div class="row px-0" id="section_whats_new_products">

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
                                                class="img-fluid lazyload w-100  on-hov-shadow" style="border-radius:20px;">
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        
        
        
        
        <div class="row x-y-shadow py-2 py-md-3 px-0 mt-2 bg-white mt-4" id="sadar_recomendation">
            <div class="px-2 py-4 px-md-4 py-md-3 bg-white rounded">
                <div class="d-flex mb-3 align-items-baseline border-bottom justify-content-center">
                    <h3 class="h5 fw-700 mb-0">
                        <span
                            class="border-bottom border-primary border-width-2 pb-3 d-inline-block"><?php echo e(translate('Best Sellers Category')); ?></span>
                    </h3>
                </div>
                <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="6" data-xl-items="5" data-lg-items="4"
                    data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true' data-infinite='true'
                    data-autoplay='true'>
                    <div class="carousel-box">
                        <div
                            class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
                            <a href="https://sadar24.com/category/speakers" target="_blank" class="d-block">
                                <img class="img-fit lazyload mx-auto"
                                    src="<?php echo e(my_asset('uploads/all/ePiG4O1ge06ow52dnPkLv7m2x4MznEAlC33mtfLh.jpg')); ?>"
                                    data-src="<?php echo e(my_asset('uploads/all/ePiG4O1ge06ow52dnPkLv7m2x4MznEAlC33mtfLh.jpg')); ?>"
                                    alt="Whats hot" style="object-fit: scale-down;" />
                            </a>
                        </div>
                    </div>
                    <div class="carousel-box">
                        <div
                            class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
                            <a href="https://sadar24.com/category/sling-bags" target="_blank" class="d-block">
                                <img class="img-fit lazyload mx-auto"
                                    src="<?php echo e(my_asset('uploads/all/gIRJdBjyf7E19qbzHXpIi6H9RHd1BpQrQKd9cutk.jpg')); ?>"
                                    data-src="<?php echo e(my_asset('uploads/all/gIRJdBjyf7E19qbzHXpIi6H9RHd1BpQrQKd9cutk.jpg')); ?>"
                                    alt="Whats hot" style="object-fit: scale-down;" />
                            </a>
                        </div>
                    </div>
                    <div class="carousel-box">
                        <div
                            class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
                            <a href="https://sadar24.com/category/shoulder-bags" class="d-block">
                                <img class="img-fit lazyload mx-auto"
                                    src="<?php echo e(my_asset('uploads/all/p9Vsbw7iZXYL2c17mNadgmki5ENMvFRGouqTrjiI.jpg')); ?>"
                                    data-src="<?php echo e(my_asset('uploads/all/p9Vsbw7iZXYL2c17mNadgmki5ENMvFRGouqTrjiI.jpg')); ?>"
                                    alt="Whats hot" style="object-fit: scale-down;" />
                            </a>
                        </div>
                    </div>
                    <div class="carousel-box">
                        <div
                            class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
                            <a href="https://sadar24.com/category/t-shirt" class="d-block">
                                <img class="img-fit lazyload mx-auto"
                                    src="<?php echo e(my_asset('uploads/all/c7zzasqqxXQ1JzWuCo01xOrOjySkeJ3Oy83WmwX6.jpg')); ?>"
                                    data-src="<?php echo e(my_asset('uploads/all/c7zzasqqxXQ1JzWuCo01xOrOjySkeJ3Oy83WmwX6.jpg')); ?>"
                                    alt="Whats hot" style="object-fit: scale-down;" />
                            </a>
                        </div>
                    </div>
                    <div class="carousel-box">
                        <div
                            class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
                            <a href="https://sadar24.com/category/candles-and-more" class="d-block">
                                <img class="img-fit lazyload mx-auto"
                                    src="<?php echo e(my_asset('uploads/all/zkngoNbP03SjNlJXhO7DYaKd59bDigIdCHf3lwxX.jpg')); ?>"
                                    data-src="<?php echo e(my_asset('uploads/all/zkngoNbP03SjNlJXhO7DYaKd59bDigIdCHf3lwxX.jpg')); ?>"
                                    alt="Whats hot" style="object-fit: scale-down;" />
                            </a>
                        </div>
                    </div>
                    <div class="carousel-box">
                        <div
                            class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
                            <a href="https://sadar24.com/category/lipsticks" class="d-block">
                                <img class="img-fit lazyload mx-auto"
                                    src="<?php echo e(my_asset('uploads/all/Hw3DPOLY1vwkAx6bxwVkAFiG7zMsA7z43uM3C2nn.jpg')); ?>"
                                    data-src="<?php echo e(my_asset('uploads/all/Hw3DPOLY1vwkAx6bxwVkAFiG7zMsA7z43uM3C2nn.jpg')); ?>"
                                    alt="Whats hot" style="object-fit: scale-down;" />
                            </a>
                        </div>
                    </div>
                    <div class="carousel-box">
                        <div
                            class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
                            <a href="https://sadar24.com/category/gym-accessories-9bbce" class="d-block">
                                <img class="img-fit lazyload mx-auto"
                                    src="<?php echo e(my_asset('uploads/all/6OEiyS6LnpFoieLYID4CJzbBoJxP1L0dH26huJS3.jpg')); ?>"
                                    data-src="<?php echo e(my_asset('uploads/all/6OEiyS6LnpFoieLYID4CJzbBoJxP1L0dH26huJS3.jpg')); ?>"
                                    alt="Whats hot" style="object-fit: scale-down;" />
                            </a>
                        </div>
                    </div>
                    <div class="carousel-box">
                        <div
                            class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
                            <a href="https://sadar24.com/category/earrings" class="d-block">
                                <img class="img-fit lazyload mx-auto"
                                    src="<?php echo e(my_asset('https://sadar24.s3.ap-south-1.amazonaws.com/uploads/all/bGZQpzMUiUfZa2uwyn3BXPo414iPPI410qHyboh9.jpg')); ?>"
                                    data-src="<?php echo e(my_asset('https://sadar24.s3.ap-south-1.amazonaws.com/uploads/all/bGZQpzMUiUfZa2uwyn3BXPo414iPPI410qHyboh9.jpg')); ?>"
                                    alt="Whats hot" style="object-fit: scale-down;" />
                            </a>
                        </div>
                    </div>
                    <div class="carousel-box">
                        <div
                            class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
                            <a href="https://sadar24.com/category/data-cable-charger-connectors" class="d-block">
                                <img class="img-fit lazyload mx-auto"
                                    src="<?php echo e(my_asset('uploads/all/3fPRTPvmbgYW64kgpVKeeYu7LBPVkjHkoR6TFpfk.jpg')); ?>"
                                    data-src="<?php echo e(my_asset('uploads/all/3fPRTPvmbgYW64kgpVKeeYu7LBPVkjHkoR6TFpfk.jpg')); ?>" alt="Whats hot"
                                    style="object-fit: scale-down;" />
                            </a>
                        </div>
                    </div>
                    <div class="carousel-box">
                        <div
                            class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
                            <a href="https://sadar24.com/category/cushions-and-covers" class="d-block">
                                <img class="img-fit lazyload mx-auto"
                                    src="<?php echo e(my_asset('uploads/all/ocFP9VrMvexPzRjHs89BNHQigleZL4arXLjFG7fs.jpg')); ?>"
                                    data-src="<?php echo e(my_asset('uploads/all/ocFP9VrMvexPzRjHs89BNHQigleZL4arXLjFG7fs.jpg')); ?>" alt="Whats hot"
                                    style="object-fit: scale-down;">
                            </a>
                        </div>
                    </div>
                    <div class="carousel-box">
                        <div
                            class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
                            <a href="https://sadar24.com/category/clutch" class="d-block">
                                <img class="img-fit lazyload mx-auto"
                                    src="<?php echo e(my_asset('uploads/all/RNAdxgbufwkqIHGzDHx4xcksRzQHV1iHH7FTu0wi.jpg')); ?>"
                                    data-src="<?php echo e(my_asset('uploads/all/RNAdxgbufwkqIHGzDHx4xcksRzQHV1iHH7FTu0wi.jpg')); ?>" alt="Whats hot"
                                    style="object-fit: scale-down;" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row x-y-shadow py-2 py-md-3 mt-2 bg-white mt-4">
            <div class="col-12 col-md-6 img-hover-zoom-out-colorize" style="position:relative;">
                <a href="category/soft-toys" style="position:relative;" class="d-block">
                    <img src="<?php echo e(static_asset('assets/img/temp-bottom-banners/vanessa-bucceri-gDiRwIYAMA8-unsplash.jpg')); ?>"
                        alt="<?php echo e(env('APP_NAME')); ?> SALE" class="img-fluid lazyload w-100">
                    <div class="row" style="bottom: 0;
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
                    <img src="<?php echo e(static_asset('assets/img/temp-bottom-banners/freestocks-_3Q3tsJ01nc-unsplash.jpg')); ?>"
                        alt="<?php echo e(env('APP_NAME')); ?> SALE" class="img-fluid lazyload w-100">
                    <div class="row" style="bottom: 0;
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
        </div>
        
        <div class="row x-y-shadow py-2 py-md-3 px-0 mt-2 bg-white mt-4" id="sadar_recomendation">
            <div class="px-2 py-4 px-md-4 py-md-3 bg-white rounded">
                <div class="d-flex mb-3 align-items-baseline border-bottom justify-content-center">
                    <h3 class="h5 fw-700 mb-0">
                        <span
                            class="border-bottom border-primary border-width-2 pb-3 d-inline-block"><?php echo e(translate('Recommended on Sadar 24')); ?></span>
                    </h3>
                </div>
                <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="6" data-xl-items="5" data-lg-items="4"
                    data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true' data-infinite='true'
                    data-autoplay='true'>
                    <div class="carousel-box">
                        <div
                            class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
                            <a href="smart-search?keyword=aromasia" target="_blank" class="d-block">
                                <img class="img-fit lazyload mx-auto"
                                    src="<?php echo e(my_asset('uploads/all/VmezZtAw7O9jPbY2UdPoczFeTu8iYvUPGC2yeppM.jpg')); ?>"
                                    data-src="<?php echo e(my_asset('uploads/all/VmezZtAw7O9jPbY2UdPoczFeTu8iYvUPGC2yeppM.jpg')); ?>"
                                    alt="Whats hot" style="object-fit: scale-down;" />
                            </a>
                        </div>
                    </div>
                    <div class="carousel-box">
                        <div
                            class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
                            <a href="smart-search?keyword=gizmore" target="_blank" class="d-block">
                                <img class="img-fit lazyload mx-auto"
                                    src="<?php echo e(my_asset('uploads/all/keKqqsWoZVqvQoczFvBj4dDN5EFOifLS4EvIO7v2.jpg')); ?>"
                                    data-src="<?php echo e(my_asset('uploads/all/keKqqsWoZVqvQoczFvBj4dDN5EFOifLS4EvIO7v2.jpg')); ?>"
                                    alt="Whats hot" style="object-fit: scale-down;" />
                            </a>
                        </div>
                    </div>
                    <div class="carousel-box">
                        <div
                            class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
                            <a href="https://sadar24.com/category/stationary" class="d-block">
                                <img class="img-fit lazyload mx-auto"
                                    src="<?php echo e(my_asset('uploads/all/cfgnbba6m68Bk1xYty2gfztc8sTIY6WU7nawmmtm.jpg')); ?>"
                                    data-src="<?php echo e(my_asset('uploads/all/cfgnbba6m68Bk1xYty2gfztc8sTIY6WU7nawmmtm.jpg')); ?>"
                                    alt="Whats hot" style="object-fit: scale-down;" />
                            </a>
                        </div>
                    </div>
                    <div class="carousel-box">
                        <div
                            class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
                            <a href="https://sadar24.com/category/bedsheets" class="d-block">
                                <img class="img-fit lazyload mx-auto"
                                    src="<?php echo e(my_asset('uploads/all/W6xJHlcvyHYPokTMqL9C3hV0IBYyJSpGMA3AzOVm.jpg')); ?>"
                                    data-src="<?php echo e(my_asset('uploads/all/W6xJHlcvyHYPokTMqL9C3hV0IBYyJSpGMA3AzOVm.jpg')); ?>"
                                    alt="Whats hot" style="object-fit: scale-down;" />
                            </a>
                        </div>
                    </div>
                    <div class="carousel-box">
                        <div
                            class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
                            <a href="https://sadar24.com/category/candles-and-more" class="d-block">
                                <img class="img-fit lazyload mx-auto"
                                    src="<?php echo e(my_asset('uploads/all/tnzEQ8R5jR8Od9jB27wmC5jlLYjdqZjwgQ8tFOLU.jpg')); ?>"
                                    data-src="<?php echo e(my_asset('uploads/all/tnzEQ8R5jR8Od9jB27wmC5jlLYjdqZjwgQ8tFOLU.jpg')); ?>"
                                    alt="Whats hot" style="object-fit: scale-down;" />
                            </a>
                        </div>
                    </div>
                    <div class="carousel-box">
                        <div
                            class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
                            <a href="https://sadar24.com/category/kitchen-and-dining" class="d-block">
                                <img class="img-fit lazyload mx-auto"
                                    src="<?php echo e(my_asset('uploads/all/ypttmDvUYAYqf72497wBaZdO2KEBtBECi6TNwac8.jpg')); ?>"
                                    data-src="<?php echo e(my_asset('uploads/all/ypttmDvUYAYqf72497wBaZdO2KEBtBECi6TNwac8.jpg')); ?>"
                                    alt="Whats hot" style="object-fit: scale-down;" />
                            </a>
                        </div>
                    </div>
                    <div class="carousel-box">
                        <div
                            class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
                            <a href="https://sadar24.com/category/necklace-sets" class="d-block">
                                <img class="img-fit lazyload mx-auto"
                                    src="<?php echo e(my_asset('uploads/all/ttDRTTpan62q62Svrp6CxYqHee3eHfrqIHchklIX.jpg')); ?>"
                                    data-src="<?php echo e(my_asset('uploads/all/ttDRTTpan62q62Svrp6CxYqHee3eHfrqIHchklIX.jpg')); ?>"
                                    alt="Whats hot" style="object-fit: scale-down;" />
                            </a>
                        </div>
                    </div>
                    <div class="carousel-box">
                        <div
                            class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
                            <a href="https://sadar24.com/category/lamp-and-lighting" class="d-block">
                                <img class="img-fit lazyload mx-auto"
                                    src="<?php echo e(my_asset('uploads/all/mOhg07hL7gcANnXnPTlPvROTw1O0CVCNekiey33m.jpg')); ?>"
                                    data-src="<?php echo e(my_asset('uploads/all/mOhg07hL7gcANnXnPTlPvROTw1O0CVCNekiey33m.jpg')); ?>"
                                    alt="Whats hot" style="object-fit: scale-down;" />
                            </a>
                        </div>
                    </div>
                    <div class="carousel-box">
                        <div
                            class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
                            <a href="https://sadar24.com/category/hair-accesserioes" class="d-block">
                                <img class="img-fit lazyload mx-auto"
                                    src="<?php echo e(my_asset('uploads/all/banner300x230Artboard3.jpg')); ?>"
                                    data-src="<?php echo e(my_asset('uploads/all/banner300x230Artboard3.jpg')); ?>" alt="Whats hot"
                                    style="object-fit: scale-down;" />
                            </a>
                        </div>
                    </div>
                    <div class="carousel-box">
                        <div
                            class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
                            <a href="https://sadar24.com/category/Gym-Accessories-9BBcE" class="d-block">
                                <img class="img-fit lazyload mx-auto"
                                    src="<?php echo e(my_asset('uploads/all/banner300x230Artboard6.jpg')); ?>"
                                    data-src="<?php echo e(my_asset('uploads/all/banner300x230Artboard6.jpg')); ?>" alt="Whats hot"
                                    style="object-fit: scale-down;">
                            </a>
                        </div>
                    </div>
                    <div class="carousel-box">
                        <div
                            class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
                            <a href="https://sadar24.com/category/toys-and-games" class="d-block">
                                <img class="img-fit lazyload mx-auto"
                                    src="<?php echo e(my_asset('uploads/all/banner300x230Artboard5.jpg')); ?>"
                                    data-src="<?php echo e(my_asset('uploads/all/banner300x230Artboard5.jpg')); ?>" alt="Whats hot"
                                    style="object-fit: scale-down;" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="row x-y-shadow py-2 py-md-3 px-0 bg-white mt-2 mt-4">
            <div class="col-12 px-0" id="category_catalogue_products">
                
                

                
            </div>
        </div>
        <div class="row x-y-shadow py-2 py-md-3 px-0 bg-white mt-2 mt-4">
            <div class="d-flex align-items-baseline border-bottom justify-content-center mb-4">
                <h3 class="h5 fw-700 mb-0">
                    <span
                        class="border-bottom border-primary border-width-2 pb-3 d-inline-block"><?php echo e(translate('Deal Of The Day')); ?></span>
                </h3>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="category-box p-0 p-md-auto img-hover-zoom--colorize">
                    
                    <a href="https://sadar24.com/category/dining-and-serving" target="_blank"
                        class="img-link on-hov-dis-ef" style="position:relative;"><img
                            src="<?php echo e(static_asset('assets/img/temp-main-banner/1.jpg')); ?>" 
                            class="img-fit zoom" alt="sadar24">

                    </a>
                    <a href="https://sadar24.com/category/dining-and-serving" target="_blank" class="custom-link"
                        target="_blank">Dining &
                        Serving</a>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="category-box p-0 p-md-auto img-hover-zoom--colorize">
                    
                    <a href="https://sadar24.com/category/home-appliances" target="_blank" class="img-link on-hov-dis-ef"
                        style="position:relative;"><img src="<?php echo e(static_asset('assets/img/temp-main-banner/2.jpg')); ?>"
                             class="img-fit zoom" alt="sadar24">

                    </a>
                    <a href="https://sadar24.com/category/home-appliances" target="_blank" class="custom-link"
                        target="_blank">Home
                        Appliance</a>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="category-box p-0 p-md-auto img-hover-zoom--colorize">
                    
                    <a href="https://sadar24.com/category/baby-care" target="_blank" class="img-link on-hov-dis-ef"
                        style="position:relative;"><img src="<?php echo e(static_asset('assets/img/temp-main-banner/3.jpg')); ?>"
                             class="img-fit zoom" alt="sadar24">

                    </a>
                    <a href="https://sadar24.com/category/baby-care" target="_blank" class="custom-link"
                        target="_blank">Baby
                        care</a>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="category-box p-0 p-md-auto img-hover-zoom--colorize">
                    
                    <a href="https://sadar24.com/category/home-decors" target="_blank" class="img-link on-hov-dis-ef"
                        style="position:relative;"><img src="<?php echo e(static_asset('assets/img/temp-main-banner/4.jpg')); ?>"
                             class="img-fit zoom" alt="sadar24">

                        <a href="https://sadar24.com/category/home-decors" target="_blank" class="custom-link"
                            target="_blank">Home
                            And Decors</a>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="category-box p-0 p-md-auto img-hover-zoom--colorize">
                    
                    <a href="https://sadar24.com/category/fashion-jewellery" target="_blank" class="img-link on-hov-dis-ef"
                        style="position:relative;"><img src="<?php echo e(static_asset('assets/img/temp-main-banner/5.jpg')); ?>"
                             class="img-fit zoom" alt="sadar24">

                    </a>
                    <a href="https://sadar24.com/category/fashion-jewellery" target="_blank" class="custom-link"
                        target="_blank">Womens
                        Jewellery</a>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="category-box p-0 p-md-auto img-hover-zoom--colorize">
                    
                    <a href="https://sadar24.com/category/beauty-and-personal-care" target="_blank"
                        class="img-link on-hov-dis-ef" style="position:relative;"><img
                            src="<?php echo e(static_asset('assets/img/temp-main-banner/6.jpg')); ?>" 
                            class="img-fit zoom" alt="sadar24">

                    </a>
                    <a href="https://sadar24.com/category/beauty-and-personal-care" target="_blank" class="custom-link"
                        target="_blank">Beauty</a>
                </div>
            </div>
        </div>
        <div class="row x-y-shadow py-2 py-md-3 mt-2 bg-white mt-4" style="position: relative;">
            <div class="col-12 img-hover-zoom-out-colorize">
                <a href="https://sadar24.com/search?keyword=&brand=&sort_by=price-desc&min_price=0.00&max_price=199">
                    <img src="<?php echo e(static_asset('assets/img/temp-main-banner/sale banner.jpg')); ?>"
                        alt="<?php echo e(env('APP_NAME')); ?> SALE" class="img-fluid lazyload w-100">
                </a>
            </div>
            <div class="col-3 text-center d-none d-md-block" style="position:absolute; bottom:45%; left:70%;">
                <button class="btn btn-black btn-hover-zoom-out-colorize text-white bg-black font-weight-bold" style="
                                                                            width: 220px;
                                                                            height: 75px;
                                                                            font-size: 23px;
                                                                        ">SHOP NOW</button>
            </div>
        </div>

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
                $.post('<?php echo e(route('home.section.category_catalogue_products')); ?>', {
                    _token: '<?php echo e(csrf_token()); ?>'
                }, function(data) {
                    $('#category_catalogue_products').html(data);
                    AIZ.plugins.slickCarousel();
                });
                $.post('<?php echo e(route('home.section.whats_new_products')); ?>', {
                    _token: '<?php echo e(csrf_token()); ?>'
                }, function(data) {
                    $('#section_whats_new_products').html(data);
                    AIZ.plugins.slickCarousel();
                });
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

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sadar24_aws/resources/views/frontend/index.blade.php ENDPATH**/ ?>