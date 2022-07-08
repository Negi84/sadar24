<style>
    /*footer*/
    .col_white_amrc {
        color: #FFF;
    }

    footer {
        width: 100%;
        background-color: #19212a;
        min-height: 250px;
        padding: 10px 0px 25px 0px;
    }

    .pt2 {
        padding-top: 40px;
        margin-bottom: 20px;
    }

    footer p {
        font-size: 13px;
        color: #CCC;
        padding-bottom: 0px;
        margin-bottom: 8px;
    }

    footer a {
        color: #CCC;
    }

    .mb10 {
        padding-bottom: 15px;
    }

    .footer_ul_amrc {
        margin: 0px;
        list-style-type: none;
        font-size: 14px;
        padding: 0px 0px 10px 0px;
    }

    .footer_ul_amrc li {
        padding: 0px 0px 5px 0px;
    }

    .footer_ul_amrc li a {
        color: #CCC;
    }

    .footer_ul_amrc li a:hover {
        color: #fff;
        text-decoration: none;
    }

    .fleft {
        float: left;
    }

    .padding-right {
        padding-right: 10px;
    }

    .footer_ul2_amrc {
        margin: 0px;
        list-style-type: none;
        padding: 0px;
    }

    .footer_ul2_amrc li p {
        display: table;
    }

    .footer_ul2_amrc li a:hover {
        text-decoration: none;
    }

    .footer_ul2_amrc li i {
        margin-top: 5px;
    }

    .bottom_border {
        border-bottom: 1px solid #323f45;
        padding-bottom: 20px;
    }

    .foote_bottom_ul_amrc {
        list-style-type: none;
        padding: 0px;
        display: table;
        margin-top: 10px;
        margin-right: auto;
        margin-bottom: 10px;
        margin-left: auto;
    }

    .foote_bottom_ul_amrc li {
        display: inline;
    }

    .foote_bottom_ul_amrc li a {
        color: #999;
        margin: 0 12px;
    }

    .social_footer_ul {
        display: table;
        margin: 15px auto 0 auto;
        list-style-type: none;
    }

    .social_footer_ul li {
        padding-left: 20px;
        padding-top: 10px;
        float: left;
    }

    .social_footer_ul li a {
        color: #CCC;
        border: 1px solid #CCC;
        padding: 8px;
        border-radius: 50%;
    }

    .social_footer_ul li i {
        width: 20px;
        height: 20px;
        text-align: center;
    }

    .top-hover {
        background-color: #37475A;
        cursor: pointer;
    }

    .top-hover:hover {
        background-color: #475768;
    }

    #dropdownMenuLink::after {
        display: inline-block;
        width: 0;
        height: 0;
        margin-left: .255em;
        vertical-align: .255em;
        content: "";
        border-top: .3em solid;
        border-right: .3em solid transparent;
        border-bottom: 0;
        border-left: .3em solid transparent;
        color: #ccc;

    }

    @media  only screen and (max-width: 550px) {
        .mb-d-n {
            display: none;
        }
    }

</style>

<div class="container-fluid  top-hover" id="toTop" style="">
    <div class="text-center p-2">
        <small class="text-light">Back to top</small>
    </div>
</div>
<!--footer starts from here-->
<footer class="footer pt-5" style="font-family: Arial, Helvetica, sans-serif;">
    <div class="container px-0">
        <div class="row">
            <div class="col--md-12">
                <div class="row">
                    <div class="col-12 px-0 mb-4" style="font-weight: 700;color: white;">
                        <ul class="footer_ul2_amrc"
                            style="font-weight: 100;font-size:12px; text-align:justify; line-height: 1.8rem;color: #ffffff ;">
                            <?php
                                $i = 0;
                                $status = 'true';
                            ?>
                            <?php while($status == 'true'): ?>
                                <?php if(get_setting('widget_' . $i . '_labels', null, App::getLocale()) != null): ?>
                                        <li class="d-inline pl-2 font-weight-bolder">
                                            <?php echo e(get_setting('widget_' . $i, null, App::getLocale())); ?> :</li>
                                        <?php $__currentLoopData = json_decode(get_setting('widget_' . $i . '_labels', null, App::getLocale()), true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="d-inline px-2 border-right">
                                                <a
                                                    href="<?php echo e(json_decode(get_setting('widget_' . $i . '_links'), true)[$key]); ?>">
                                                    <?php echo e($value); ?>

                                                </a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <br>
                                    <?php $i = ++$i; ?>
                                <?php else: ?>
                                    <?php if($i == 0): ?>
                                        <?php $i = ++$i; ?>
                                    <?php else: ?>
                                        <?php
                                            $status = 'false';
                                        ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container px-0 bottom_border">
        <div class="row">
            <div class="col-md-12">
                <div class="row m-0">
                    <div class=" col-sm-6 col-md  col-6 col mb-4" style="font-weight: 700;color: white;">
                        <?php echo e(get_setting('widget_one', null, App::getLocale())); ?>

                        <ul class="footer_ul2_amrc"
                            style="font-weight: 100;font-size:14px; line-height: 1.8rem;color: #dddddb ;">
                            <?php if(get_setting('widget_one_labels', null, App::getLocale()) != null): ?>
                                <?php $__currentLoopData = json_decode(get_setting('widget_one_labels', null, App::getLocale()), true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <a href="<?php echo e(json_decode(get_setting('widget_one_links'), true)[$key]); ?>">
                                            <?php echo e($value); ?>

                                        </a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </ul>
                    </div>

                    <div class=" col-sm-6 col-md  col-6 col mb-4" style="font-weight: 700;color: white;">
                        <?php echo e(translate('My Account')); ?>

                        <ul class="footer_ul2_amrc"
                            style="font-weight: 100;font-size:14px; line-height: 1.8rem;color: #dddddb ;">
                            <?php if(Auth::check()): ?>
                                <li>
                                    <a href="<?php echo e(route('logout')); ?>">
                                        <?php echo e(translate('Logout')); ?>

                                    </a>
                                </li>
                            <?php else: ?>
                                <li>
                                    <a href="<?php echo e(route('user.login')); ?>">
                                        <?php echo e(translate('Login')); ?>

                                    </a>
                                </li>
                            <?php endif; ?>
                            <li>
                                <a href="<?php echo e(route('purchase_history.index')); ?>">
                                    <?php echo e(translate('Order History')); ?>

                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('wishlists.index')); ?>">
                                    <?php echo e(translate('My Wishlist')); ?>

                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('orders.track')); ?>">
                                    <?php echo e(translate('Track Order')); ?>

                                </a>
                            </li>
                            <?php if(addon_is_activated('affiliate_system')): ?>
                                <li>
                                    <a
                                        href="<?php echo e(route('affiliate.apply')); ?>"><?php echo e(translate('Be an affiliate partner')); ?></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                        <!--footer_ul_amrc ends here-->
                    </div>
                    <div class=" col-sm-6 col-md  col-6 col mb-4" style="font-weight: 700;color: white;">
                        <?php echo e(translate('Let Us Help You')); ?>

                        <ul class="footer_ul2_amrc"
                            style="font-weight: 100;font-size:14px; line-height: 1.8rem;color: #dddddb ;">
                            <li>
                                <a href="<?php echo e(route('terms')); ?>">
                                    <?php echo e(translate('Terms & conditions')); ?>

                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('returnpolicy')); ?>">
                                    <?php echo e(translate('Return Policy')); ?>

                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('supportpolicy')); ?>}">
                                    <?php echo e(translate('Support Policy')); ?>

                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('privacypolicy')); ?>">
                                    <?php echo e(translate('Privacy Policy')); ?>

                                </a>
                            </li>
                        </ul>

                        <!--footer_ul_amrc ends here-->
                    </div>

                    <div class=" col-sm-6 col-md  col-6 d-block d-sm-none col mb-4"
                        style="font-weight: 700;color: white;">
                        <?php echo e(translate('Connect with us')); ?>

                        <?php if(get_setting('show_social_links')): ?>
                            <ul class=" footer_ul2_amrc"
                                style="font-weight: 100;font-size:14px; line-height: 1.8rem;color: #dddddb ;">
                                <?php if(get_setting('facebook_link') != null): ?>
                                    <li>
                                        <a href="<?php echo e(get_setting('facebook_link')); ?>" target="_blank"
                                            class="facebook"><i class="lab la-facebook-f"></i>
                                            <?php echo e(translate('Facebook')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if(get_setting('twitter_link') != null): ?>
                                    <li>
                                        <a href="<?php echo e(get_setting('twitter_link')); ?>" target="_blank"
                                            class="twitter"><i class="lab la-twitter"></i>
                                            <?php echo e(translate('Twitter')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if(get_setting('instagram_link') != null): ?>
                                    <li>
                                        <a href="<?php echo e(get_setting('instagram_link')); ?>" target="_blank"
                                            class="instagram"><i class="lab la-instagram"></i>
                                            <?php echo e(translate('Instagram')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if(get_setting('youtube_link') != null): ?>
                                    <li>
                                        <a href="<?php echo e(get_setting('youtube_link')); ?>" target="_blank"
                                            class="youtube"><i class="lab la-youtube"></i>
                                            <?php echo e(translate('Youtube')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if(get_setting('linkedin_link') != null): ?>
                                    <li>
                                        <a href="<?php echo e(get_setting('linkedin_link')); ?>" target="_blank"
                                            class="linkedin"><i class="lab la-linkedin-in"></i>
                                            <?php echo e(translate('Linked In')); ?></a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        <?php endif; ?>

                        <!--footer_ul_amrc ends here-->
                    </div>

                    <div class=" col-sm-6 col-md  col-12 col mb-4" style="font-weight: 700;color: white;">
                        <?php echo e(translate('Contact Info')); ?>

                        <ul class="footer_ul2_amrc"
                            style="font-weight: 100;font-size:14px; line-height: 1.8rem;color: #dddddb ;">
                            <li>
                                <span><?php echo e(translate('Address')); ?>:
                                    <?php echo e(get_setting('contact_address', null, App::getLocale())); ?></span>
                            </li>
                            <li>
                                <span><?php echo e(translate('Phone')); ?>: <?php echo e(get_setting('contact_phone')); ?></span>
                            </li>
                            <li>
                                <span>
                                    <?php echo e(translate('Email')); ?>: <a href="mailto:<?php echo e(get_setting('contact_email')); ?>"
                                        class="text-reset"><?php echo e(get_setting('contact_email')); ?></a>
                                </span>
                            </li>
                        </ul>
                        
                        <div class="w-300px mw-100 mx-auto mx-md-0 play-store">
                            <?php if(get_setting('play_store_link') != null): ?>
                                <a href="<?php echo e(get_setting('play_store_link')); ?>" target="_blank"
                                    class="d-inline-block mr-3 ml-0">
                                    <img src="<?php echo e(static_asset('assets/img/play.png')); ?>" class="mx-100 h-40px">
                                </a>
                            <?php endif; ?>
                            <?php if(get_setting('app_store_link') != null): ?>
                                <a href="<?php echo e(get_setting('app_store_link')); ?>" target="_blank" class="d-inline-block">
                                    <img src="<?php echo e(static_asset('assets/img/app.png')); ?>" class="mx-100 h-40px">
                                </a>
                            <?php endif; ?>
                        </div>
                        <!--footer_ul2_amrc ends here-->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container px-0 pt-3">
        <div class="row">
            <div class="col-4">

            </div>
            <div class="col-lg-4 col-12 text-light text-center pb-3 pl-md-5 pr-md-5">
                <?php
                    $header_logo = get_setting('header_logo');
                ?>
                <?php if($header_logo != null): ?>
                    <img src="<?php echo e(uploaded_asset($header_logo)); ?>" alt="<?php echo e(env('APP_NAME')); ?>"
                        class="mw-100 h-60px">
                <?php else: ?>
                    <img src="<?php echo e(static_asset('assets/img/logo.png')); ?>" alt="<?php echo e(env('APP_NAME')); ?>"
                        class="mw-100 h-60px">
                <?php endif; ?>

            </div>
            <div class="col-3 my-auto d-none">
                <div class="dropdown">
                    <a class="btn dropdown-toggle pl-3 pr-3" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                        style="border: 1px solid #464545;width: -moz-fit-content;width: fit-content;">
                        <small style="color: #abaaaa;"><i class="fas fa-globe"></i> English</small>
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="#">English</a>
                    </div>
                </div>
            </div>
            <div class="col-4"></div>
        </div>
    </div>

    <div class="container px-0 pb-md-0 pb-5">
        <!-- <ul class="foote_bottom_ul_amrc">
                <li><a href="www.google.com"></a><small class="text-light">Australia</small></li>
                <li><a href="www.google.com"></a><small class="text-light">Brazil</small></li>
                <li><a href="www.google.com"></a><small class="text-light">Africa</small></li>
                <li><a href="www.google.com"></a><small class="text-light">America</small></li>
                <li><a href="www.google.com"></a><small class="text-light">Australia</small></li>
                <li><a href="www.google.com"></a><small class="text-light">Brazil</small></li>
                <li><a href="www.google.com"></a><small class="text-light">Africa</small></li>
                <li><a href="www.google.com"></a><small class="text-light">America</small></li>
                <li><a href="www.google.com"></a><small class="text-light">Australia</small></li>
                <li><a href="www.google.com"></a><small class="text-light">Brazil</small></li>
                <li><a href="www.google.com"></a><small class="text-light">Africa</small></li>
                <li><a href="www.google.com"></a><small class="text-light">America</small></li>
            </ul> -->
        <!--foote_bottom_ul_amrc ends here-->

        <p class="text-center" current-verison="<?php echo e(get_setting('current_version')); ?>"><?php echo get_setting('frontend_copyright_text', null, App::getLocale()); ?></p>
        <div class="row mb-d-n">
            <div class="col-6">
                <?php if(get_setting('show_social_links')): ?>
                    <ul class="social_footer_ul float-left" style="padding: 0;">
                        <?php if(get_setting('facebook_link') != null): ?>
                            <li>
                                <a href="<?php echo e(get_setting('facebook_link')); ?>" target="_blank"
                                    class="facebook"><i class="lab la-facebook-f"></i></a>
                            </li>
                        <?php endif; ?>
                        <?php if(get_setting('twitter_link') != null): ?>
                            <li>
                                <a href="<?php echo e(get_setting('twitter_link')); ?>" target="_blank" class="twitter"><i
                                        class="lab la-twitter"></i></a>
                            </li>
                        <?php endif; ?>
                        <?php if(get_setting('instagram_link') != null): ?>
                            <li>
                                <a href="<?php echo e(get_setting('instagram_link')); ?>" target="_blank"
                                    class="instagram"><i class="lab la-instagram"></i></a>
                            </li>
                        <?php endif; ?>
                        <?php if(get_setting('youtube_link') != null): ?>
                            <li>
                                <a href="<?php echo e(get_setting('youtube_link')); ?>" target="_blank" class="youtube"><i
                                        class="lab la-youtube"></i></a>
                            </li>
                        <?php endif; ?>
                        <?php if(get_setting('linkedin_link') != null): ?>
                            <li>
                                <a href="<?php echo e(get_setting('linkedin_link')); ?>" target="_blank"
                                    class="linkedin"><i class="lab la-linkedin-in"></i></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                <?php endif; ?>

            </div>
            <div class="col-6">
                <ul class="social_footer_ul float-right border border-0">
                    <?php if(get_setting('payment_method_images') != null): ?>
                        <?php $__currentLoopData = explode(',', get_setting('payment_method_images')); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><a class="border-0" href=""><img src="<?php echo e(uploaded_asset($value)); ?>" alt=""
                                        height="30" class="mw-100 h-auto" style="max-height: 30px"></a></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>

                </ul>
            </div>
        </div>
        <!--social_footer_ul ends here-->
    </div>

</footer>



<div class="aiz-mobile-bottom-nav d-xl-none fixed-bottom bg-white shadow-lg border-top rounded-top"
    style="box-shadow: 0px -1px 10px rgb(0 0 0 / 15%)!important; ">
    <div class="row align-items-center gutters-5">
        <div class="col">
            <a href="<?php echo e(route('home')); ?>" class="text-reset d-block text-center pb-2 pt-3">
                <i
                    class="las la-home fs-20 opacity-60 <?php echo e(areActiveRoutes(['home'], 'opacity-100 text-primary')); ?>"></i>
                <span
                    class="d-block fs-10 fw-600 opacity-60 <?php echo e(areActiveRoutes(['home'], 'opacity-100 fw-600')); ?>"><?php echo e(translate('Home')); ?></span>
            </a>
        </div>
        <div class="col">
            <a href="<?php echo e(route('categories.all')); ?>" class="text-reset d-block text-center pb-2 pt-3">
                <i
                    class="las la-list-ul fs-20 opacity-60 <?php echo e(areActiveRoutes(['categories.all'], 'opacity-100 text-primary')); ?>"></i>
                <span
                    class="d-block fs-10 fw-600 opacity-60 <?php echo e(areActiveRoutes(['categories.all'], 'opacity-100 fw-600')); ?>"><?php echo e(translate('Categories')); ?></span>
            </a>
        </div>
        <?php
            if (auth()->user() != null) {
                $user_id = Auth::user()->id;
                $cart = \App\Cart::where('user_id', $user_id)->get();
            } else {
                $temp_user_id = Session()->get('temp_user_id');
                if ($temp_user_id) {
                    $cart = \App\Cart::where('temp_user_id', $temp_user_id)->get();
                }
            }
        ?>
        <div class="col-auto">
            <a href="<?php echo e(route('cart')); ?>" class="text-reset d-block text-center pb-2 pt-3">
                <span
                    class="align-items-center bg-primary border border-white border-width-4 d-flex justify-content-center position-relative rounded-circle size-50px"
                    style="margin-top: -33px;box-shadow: 0px -5px 10px rgb(0 0 0 / 15%);border-color: #fff !important;">
                    <i class="las la-shopping-bag la-2x text-white"></i>
                </span>
                <span
                    class="d-block mt-1 fs-10 fw-600 opacity-60 <?php echo e(areActiveRoutes(['cart'], 'opacity-100 fw-600')); ?>">
                    <?php echo e(translate('Cart')); ?>

                    <?php
                        $count = isset($cart) && count($cart) ? count($cart) : 0;
                    ?>
                    (<span class="cart-count"><?php echo e($count); ?></span>)
                </span>
            </a>
        </div>
        <div class="col">
            <a href="<?php echo e(route('all-notifications')); ?>" class="text-reset d-block text-center pb-2 pt-3">
                <span class="d-inline-block position-relative px-2">
                    <i
                        class="las la-bell fs-20 opacity-60 <?php echo e(areActiveRoutes(['all-notifications'], 'opacity-100 text-primary')); ?>"></i>
                    <?php if(Auth::check() && count(Auth::user()->unreadNotifications) > 0): ?>
                        <span
                            class="badge badge-sm badge-dot badge-circle badge-primary position-absolute absolute-top-right"
                            style="right: 7px;top: -2px;"></span>
                    <?php endif; ?>
                </span>
                <span
                    class="d-block fs-10 fw-600 opacity-60 <?php echo e(areActiveRoutes(['all-notifications'], 'opacity-100 fw-600')); ?>"><?php echo e(translate('Notifications')); ?></span>
            </a>
        </div>
        <div class="col">
            <?php if(Auth::check()): ?>
                <?php if(isAdmin()): ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-reset d-block text-center pb-2 pt-3">
                        <span class="d-block mx-auto">
                            <?php if(Auth::user()->photo != null): ?>
                                <img src="<?php echo e(custom_asset(Auth::user()->avatar_original)); ?>"
                                    class="rounded-circle size-20px">
                            <?php else: ?>
                                <img src="<?php echo e(static_asset('assets/img/avatar-place.png')); ?>"
                                    class="rounded-circle size-20px">
                            <?php endif; ?>
                        </span>
                        <span class="d-block fs-10 fw-600 opacity-60"><?php echo e(translate('Account')); ?></span>
                    </a>
                <?php else: ?>
                    <a href="javascript:void(0)" class="text-reset d-block text-center pb-2 pt-3 mobile-side-nav-thumb"
                        data-toggle="class-toggle" data-backdrop="static" data-target=".aiz-mobile-side-nav">
                        <span class="d-block mx-auto">
                            <?php if(Auth::user()->photo != null): ?>
                                <img src="<?php echo e(custom_asset(Auth::user()->avatar_original)); ?>"
                                    class="rounded-circle size-20px">
                            <?php else: ?>
                                <img src="<?php echo e(static_asset('assets/img/avatar-place.png')); ?>"
                                    class="rounded-circle size-20px">
                            <?php endif; ?>
                        </span>
                        <span class="d-block fs-10 fw-600 opacity-60"><?php echo e(translate('Account')); ?></span>
                    </a>
                <?php endif; ?>
            <?php else: ?>
                <a href="<?php echo e(route('user.otplogin')); ?>" class="text-reset d-block text-center pb-2 pt-3">
                    <span class="d-block mx-auto">
                        <img src="<?php echo e(static_asset('assets/img/avatar-place.png')); ?>"
                            class="rounded-circle size-20px">
                    </span>
                    <span class="d-block fs-10 fw-600 opacity-60"><?php echo e(translate('Account')); ?></span>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php if(Auth::check() && !isAdmin()): ?>
    <div class="aiz-mobile-side-nav collapse-sidebar-wrap sidebar-xl d-xl-none z-1035">
        <div class="overlay dark c-pointer overlay-fixed" data-toggle="class-toggle" data-backdrop="static"
            data-target=".aiz-mobile-side-nav" data-same=".mobile-side-nav-thumb"></div>
        <div class="collapse-sidebar bg-white">
            <?php echo $__env->make('frontend.inc.user_side_nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\sadar24\resources\views/frontend/inc/footer.blade.php ENDPATH**/ ?>