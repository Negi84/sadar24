<?php $__env->startSection('content'); ?>

<div class="aiz-titlebar text-left mt-2 mb-3">
    <h5 class="mb-0 h6"><?php echo e(translate('Attribute Information')); ?></h5>
</div>

<div class="col-lg-8 mx-auto">
    <div class="card">
        <div class="card-body p-0">
          <ul class="nav nav-tabs nav-fill border-light">
            <?php $__currentLoopData = \App\Language::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li class="nav-item">
                <a class="nav-link text-reset <?php if($language->code == $lang): ?> active <?php else: ?> bg-soft-dark border-light border-left-0 <?php endif; ?> py-3" href="<?php echo e(route('attributes.edit', ['id'=>$attribute->id, 'lang'=> $language->code] )); ?>">
                  <img src="<?php echo e(static_asset('assets/img/flags/'.$language->code.'.png')); ?>" height="11" class="mr-1">
                  <span><?php echo e($language->name); ?></span>
                </a>
              </li>
             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul>
          <form class="p-4" action="<?php echo e(route('attributes.update', $attribute->id)); ?>" method="POST">
              <input name="_method" type="hidden" value="PATCH">
              <input type="hidden" name="lang" value="<?php echo e($lang); ?>">
              <?php echo csrf_field(); ?>
              <div class="form-group row">
                  <label class="col-sm-3 col-from-label" for="name"><?php echo e(translate('Name')); ?> <i class="las la-language text-danger" title="<?php echo e(translate('Translatable')); ?>"></i></label>
                  <div class="col-sm-9">
                      <input type="text" placeholder="<?php echo e(translate('Name')); ?>" id="name" name="name" class="form-control" required value="<?php echo e($attribute->getTranslation('name', $lang)); ?>">
                  </div>
              </div>
              <div class="form-group mb-0 text-right">
                  <button type="submit" class="btn btn-primary"><?php echo e(translate('Save')); ?></button>
              </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sadar24_aws/resources/views/backend/product/attribute/edit.blade.php ENDPATH**/ ?>