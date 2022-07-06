<?php if(isset($product->holiday)): ?>
<?php if($product->holiday == 0): ?>
<div class="aiz-card-box rounded hov-shadow-md mt-0 ml-0 has-transition bg-white">
    <?php
        $photos = explode(',', $product->photos);
    ?>
    <div class="position-relative">
        <a href="<?php echo e(route('product', $product->slug)); ?>" class="d-block">
            <img class="img-fit lazyload mx-auto h-140px h-md-210px" style="object-fit: contain;" 
                src="<?php echo e(static_asset('assets/img/placeholder.jpg')); ?>" data-src="<?php echo e(uploaded_asset($photos[0])); ?>"
                 alt="<?php echo e($product->name); ?>"
                onerror="this.onerror=null;this.src='<?php echo e(static_asset('assets/img/placeholder.jpg')); ?>';"
                style="object-fit: scale-down;">
        </a>
        <div class="absolute-top-right aiz-p-hov-icon">
            <a href="javascript:void(0)" onclick="addToWishList(<?php echo e($product->id); ?>)" data-toggle="tooltip"
                data-title="<?php echo e(translate('Add to wishlist')); ?>" data-placement="left">
                <i class="la la-heart-o"></i>
            </a>
            <a href="javascript:void(0)" onclick="addToCompare(<?php echo e($product->id); ?>)" data-toggle="tooltip"
                data-title="<?php echo e(translate('Add to compare')); ?>" data-placement="left">
                <i class="las la-sync"></i>
            </a>
            <a href="javascript:void(0)" onclick="showAddToCartModal(<?php echo e($product->id); ?>)" data-toggle="tooltip"
                data-title="<?php echo e(translate('Add to cart')); ?>" data-placement="left">
                <i class="las la-shopping-cart"></i>
            </a>
        </div>
    </div>
    <div class="p-md-3 p-2 text-left">
        <div class="rating rating-sm mt-1">
            <?php echo e(renderStarRating($product->rating)); ?>

        </div>
        <h3 class="fw-500 fs-13 text-truncate lh-1-4 mb-0 h-35px text-left">
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
                <del class="fw-600 opacity-50 mr-1"><?php echo e(format_price($product->unit_price)); ?></del>
            <?php endif; ?>
            <span class="fw-700 text-primary"><?php echo e(format_price($final_price)); ?></span>
        </div>
        <?php if(addon_is_activated('club_point')): ?>
            <div class="rounded px-2 mt-2 bg-soft-primary border-soft-primary border">
                <?php echo e(translate('Club Point')); ?>:
                <span class="fw-700 float-right"><?php echo e($product->earn_point); ?></span>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>
<?php endif; ?>
<?php /**PATH /var/www/sadar24_aws/resources/views/frontend/partials/product_box_1.blade.php ENDPATH**/ ?>