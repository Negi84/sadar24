<?php $__env->startSection('content'); ?>

<div class="aiz-titlebar text-left mt-2 mb-3">
    <h5 class="mb-0 h6"><?php echo e(translate('Category Information')); ?></h5>
</div>

<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-body p-0">
                <ul class="nav nav-tabs nav-fill border-light">
                    <?php $__currentLoopData = \App\Language::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="nav-item">
                        <a class="nav-link text-reset <?php if($language->code == $lang): ?> active <?php else: ?> bg-soft-dark border-light border-left-0 <?php endif; ?> py-3" href="<?php echo e(route('categories.edit', ['id'=>$category->id, 'lang'=> $language->code] )); ?>">
                            <img src="<?php echo e(static_asset('assets/img/flags/'.$language->code.'.png')); ?>" height="11" class="mr-1">
                            <span><?php echo e($language->name); ?></span>
                        </a>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <form class="p-4" action="<?php echo e(route('categories_refund_policy.update', $category->id)); ?>" method="POST" enctype="multipart/form-data">
                    
    	            
                	<?php echo csrf_field(); ?>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label"><?php echo e(translate('Name')); ?> <i class="las la-language text-danger" title="<?php echo e(translate('Translatable')); ?>"></i></label>
                        <div class="col-md-9">
                            <input type="text" name="name" disabled="" value="<?php echo e($category->getTranslation('name', $lang)); ?>" class="form-control" id="name" placeholder="<?php echo e(translate('Name')); ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label"><?php echo e(translate('Parent Category')); ?></label>
                        <div class="col-md-9">
                            <select class="select2 form-control aiz-selectpicker" disabled="" name="parent_id" data-toggle="select2" data-placeholder="Choose ..."data-live-search="true" data-selected="<?php echo e($category->parent_id); ?>">
                                <option value="0"><?php echo e(translate('No Parent')); ?></option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $acategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($acategory->id); ?>"><?php echo e($acategory->getTranslation('name')); ?></option>
                                    <?php $__currentLoopData = $acategory->childrenCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $childCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php echo $__env->make('categories.child_category', ['child_category' => $childCategory], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">
                            <?php echo e(translate('Return Policy')); ?>

                        </label>
                        <div class="col-md-9">
                            <input type="number" name="return_policy" value="<?php echo e($category->return_policy); ?>" class="form-control" id="return_policy" placeholder="<?php echo e(translate('Return Policy')); ?>">
                            <small><?php echo e(translate('0 Days means not returnable child category!')); ?></small>
                        </div>
                    </div>
                    
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary"><?php echo e(translate('Save')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sadar24_aws/resources/views/refund_request/edit_refund_config.blade.php ENDPATH**/ ?>