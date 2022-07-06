<?php $__env->startSection('content'); ?>

    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6"><?php echo e(translate('Coupon Information Update')); ?></h3>
            </div>
            <form action="<?php echo e(route('coupon.update', $coupon->id)); ?>" method="POST">
                <input name="_method" type="hidden" value="PATCH">
            	<?php echo csrf_field(); ?>
                <div class="card-body">
                    <input type="hidden" name="id" value="<?php echo e($coupon->id); ?>" id="id">
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label" for="name"><?php echo e(translate('Coupon Type')); ?></label>
                        <div class="col-lg-9">
                            <select name="coupon_type" id="coupon_type" class="form-control aiz-selectpicker" onchange="coupon_form()" required>
                                <?php if($coupon->type == "product_base"): ?>)
                                    <option value="product_base" selected><?php echo e(translate('For Products')); ?></option>
                                <?php elseif($coupon->type == "cart_base"): ?>
                                    <option value="cart_base"><?php echo e(translate('For Total Orders')); ?></option>
								<?php elseif($coupon->type == "category_base"): ?>
                                    <option value="category_base"><?php echo e(translate('For category')); ?></option>
                                <?php endif; ?>								
                            </select>
                        </div>
                    </div>
                    <div id="coupon_form">

                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary"><?php echo e(translate('Save')); ?></button>
                    </div>
				</div>
            </form>
        </div>
    </div>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

<script type="text/javascript">

    function coupon_form(){
        var coupon_type = $('#coupon_type').val();
        var id = $('#id').val();
		$.post('<?php echo e(route('coupon.get_coupon_form_edit')); ?>',{_token:'<?php echo e(csrf_token()); ?>', coupon_type:coupon_type, id:id}, function(data){
            $('#coupon_form').html(data);

         //    $('#demo-dp-range .input-daterange').datepicker({
         //        startDate: '-0d',
         //        todayBtn: "linked",
         //        autoclose: true,
         //        todayHighlight: true
        	// });
		});
    }

    $(document).ready(function(){
        coupon_form();
    });


</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sadar24_aws/resources/views/backend/marketing/coupons/edit.blade.php ENDPATH**/ ?>