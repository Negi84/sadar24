<?php $__env->startSection('content'); ?>

<?php
    $refund_time_config = \App\BusinessSetting::where('type', 'refund_request_time')->first();
?>
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6"><?php echo e(translate('Set Refund Time')); ?></h5>
            </div>
            <form class="form-horizontal" action="<?php echo e(route('refund_request_time_config')); ?>" method="POST" enctype="multipart/form-data">
            	<?php echo csrf_field(); ?>
                <div class="card-body">
                    <div class="form-group row">
                        <input type="hidden" name="type" value="refund_request_time">
                        <label class="col-lg-4 col-from-label"><?php echo e(translate('Set Time for sending Refund Request')); ?></label>
                        <div class="col-lg-5">
                            <input type="number" min="0" step="1" <?php if($refund_time_config != null): ?> value="<?php echo e($refund_time_config->value); ?>" <?php endif; ?> placeholder="" name="value" class="form-control">
                        </div>
                        <div class="col-lg-3">
                            <option class="form-control">days</option>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-sm btn-primary"><?php echo e(translate('Save')); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0 h6"><?php echo e(translate('Set Refund Sticker')); ?></h6>
            </div>
            <form class="form-horizontal" action="<?php echo e(route('refund_sticker_config')); ?>" method="POST" enctype="multipart/form-data">
            	<?php echo csrf_field(); ?>
                <div class="card-body">
                  <div class="form-group row">
                    <input type="hidden" name="type" value="refund_sticker">
                      <label class="col-md-2 col-form-label" for="signinSrEmail"><?php echo e(translate('Sticker')); ?></label>
                      <div class="col-md-10">
                          <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="false">
                              <div class="input-group-prepend">
                                  <div class="input-group-text bg-soft-secondary font-weight-medium"><?php echo e(translate('Browse')); ?></div>
                              </div>
                              <div class="form-control file-amount"><?php echo e(translate('Choose File')); ?></div>
                              <input type="hidden" name="logo" class="selected-files" value="<?php echo e(get_setting('refund_sticker')); ?>">
                          </div>
                          <div class="file-preview box sm">
                          </div>
                      </div>
                    </div>

                    <!-- <div class="form-group row">
                        <input type="hidden" name="type" value="refund_sticker">
                        <div class="form-group row">
                            <label class="col-lg-3 col-from-label" for="logo"><?php echo e(translate('Sticker')); ?></label>
                            <div class="col-lg-5">
                                <input type="file" id="logo" name="logo" class="form-control">
                            </div>
                        </div>
                    </div> -->
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-sm btn-primary"><?php echo e(translate('Save')); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sadar24_aws/resources/views/refund_request/config.blade.php ENDPATH**/ ?>