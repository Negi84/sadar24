<?php
$i = 0;
$status = 'true';
?>
<?php while($status == 'true'): ?>
    <?php if(get_setting('featured_category_desktop_banner_' . $i . '') != null): ?>
        <div class="row mt-2 mt-4">
            <div class="col-0 col-md-2 col-lg-2 px-0 d-none d-md-block" id="fro1-co<?php echo e($i); ?>">
                <img src="<?php echo e(uploaded_asset(get_setting('featured_category_desktop_banner_' . $i . ''))); ?>"
                    class="h-100 w-100" style="object-fit: contain;" alt="">
            </div>
            <div class="col-12 col-md-0 d-block d-md-none">
                <img src="<?php echo e(uploaded_asset(get_setting('featured_category_mobile_banner_' . $i . ''))); ?>"
                    class="h-100 w-100" style="object-fit: contain;" alt="">
            </div>
            <?php
                $featured_products = json_decode(get_setting('featured_category_' . $i . '_links', null, $lang));
            ?>
            <div class="col-12 col-md-10 col-lg-10" style="height:fit-content;" id="fro2-co<?php echo e($i); ?>">
                <div class="aiz-carousel gutters-10 half-outside-arrow py-2" data-items="6" data-xl-items="6"
                    data-lg-items="4" data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true'
                    data-infinite='true'>
                    <?php $__currentLoopData = $featured_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $product = DB::table('products')->where('slug', str_replace('https://sadar24.com/product/', '', $product))
                                ->where('approved', '1')->where('published', '1')
                                ->select('products.id', 'products.slug', 'products.photos', 'products.name', 'products.rating', 'products.purchase_price', 'products.discount', 'products.unit_price', 'products.discount_type', 'products.holiday', 'products.discount_start_date','products.discount_end_date')
                                ->first();
                            // print_r($product);

                        ?>
                        <div class="carousel-box">
                            <?php echo $__env->make('frontend.partials.product_box_1', [
                                'product' => $product,
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
        <?php $i = ++$i; ?>
    <?php else: ?>
        <?php if($i == 0): ?>
        <?php else: ?>
            <?php
                $status = 'false';
            ?>
        <?php endif; ?>
    <?php endif; ?>
<?php endwhile; ?>
<?php /**PATH /var/www/sadar24_aws/resources/views/frontend/partials/category_catalogue_products.blade.php ENDPATH**/ ?>