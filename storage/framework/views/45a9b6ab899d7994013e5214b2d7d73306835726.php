<?php $__env->startSection('content'); ?>

    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">
                <?php echo $__env->make('frontend.inc.user_side_nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="aiz-user-panel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6"><?php echo e(translate('Send Refund Request')); ?></h5>
                        </div>
                        <div class="card-body">
                          <form class="" action="<?php echo e(route('refund_request_send', $order_detail->id)); ?>" method="POST" enctype="multipart/form-data" id="choice_form">
                              <?php echo csrf_field(); ?>
                              <div class="form-box bg-white mt-4">
                                  <div class="form-box-content p-3">
                                      <div class="row">
                                          <div class="col-md-3">
                                              <label><?php echo e(translate('Product Name')); ?> <span class="text-danger">*</span></label>
                                          </div>
                                          <div class="col-md-9">
                                              <input type="text" class="form-control mb-3" name="name" placeholder="<?php echo e(translate('Product Name')); ?>" value="<?php echo e($order_detail->product->getTranslation('name')); ?>" readonly>
                                          </div>
                                      </div>
                                      <div class="row">
                                          <div class="col-md-3">
                                              <label><?php echo e(translate('Product Price')); ?> <span class="text-danger">*</span></label>
                                          </div>
                                          <div class="col-md-9">
                                              <input type="number" class="form-control mb-3" name="name" placeholder="<?php echo e(translate('Product Price')); ?>" value="<?php echo e($order_detail->product->unit_price); ?>" readonly>
                                          </div>
                                      </div>
                                      <div class="row">
                                          <div class="col-md-3">
                                              <label><?php echo e(translate('Order Code')); ?> <span class="text-danger">*</span></label>
                                          </div>
                                          <div class="col-md-9">
                                              <input type="text" class="form-control mb-3" name="code" value="<?php echo e($order_detail->order->code); ?>" readonly>
                                          </div>
                                      </div>
                                      <div class="row">
                                          <div class="col-md-3">
                                              <label><?php echo e(translate('Refund Reason')); ?> <span class="text-danger">*</span></label>
                                          </div>
                                          <div class="col-md-9">
                                              <textarea name="reason" rows="8" class="form-control mb-3"></textarea>
                                          </div>
                                      </div>
                                      <div class="form-group mb-0 text-right">
                                          <button type="submit" class="btn btn-primary"><?php echo e(translate('Send Request')); ?></button>
                                      </div>
                                  </div>
                              </div>
                          </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sadar24_aws/resources/views/refund_request/frontend/refund_request/create.blade.php ENDPATH**/ ?>