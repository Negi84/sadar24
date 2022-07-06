<div class="card-header mb-2">
    <h3 class="h6"><?php echo e(translate('Add Your Cart Base Coupon')); ?></h3>
</div>
<div class="form-group row">
    <label class="col-lg-3 col-from-label" for="coupon_code"><?php echo e(translate('Coupon code')); ?></label>
    <div class="col-lg-9">
        <input type="text" placeholder="<?php echo e(translate('Coupon code')); ?>" id="coupon_code" name="coupon_code" class="form-control" required>
    </div>
</div>
<div class="form-group row">
   <label class="col-lg-3 col-from-label"><?php echo e(translate('Minimum Shopping')); ?></label>
   <div class="col-lg-9">
      <input type="number" lang="en" min="0" step="0.01" placeholder="<?php echo e(translate('Minimum Shopping')); ?>" name="min_buy" class="form-control" required>
   </div>
</div>
<div class="form-group row">
   <label class="col-lg-3 col-from-label"><?php echo e(translate('Discount')); ?></label>
   <div class="col-lg-7">
      <input type="number" lang="en" min="0" step="0.01" placeholder="<?php echo e(translate('Discount')); ?>" name="discount" class="form-control" required>
   </div>
   <div class="col-lg-2">
       <select class="form-control aiz-selectpicker" name="discount_type">
           <option value="amount"><?php echo e(translate('Amount')); ?></option>
           <option value="percent"><?php echo e(translate('Percent')); ?></option>
       </select>
   </div>
</div>
<div class="form-group row">
   <label class="col-lg-3 col-from-label"><?php echo e(translate('Maximum Discount Amount')); ?></label>
   <div class="col-lg-9">
      <input type="number" lang="en" min="0" step="0.01" placeholder="<?php echo e(translate('Maximum Discount Amount')); ?>" name="max_discount" class="form-control" required>
   </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 control-label" for="start_date"><?php echo e(translate('Date')); ?></label>
    <div class="col-sm-9">
      <input type="text" class="form-control aiz-date-range" name="date_range" placeholder="Select Date">
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function(){
        $('.aiz-selectpicker').selectpicker();
        $('.aiz-date-range').daterangepicker();
    });
</script>
<?php /**PATH /var/www/sadar24_aws/resources/views/partials/coupons/cart_base_coupon.blade.php ENDPATH**/ ?>