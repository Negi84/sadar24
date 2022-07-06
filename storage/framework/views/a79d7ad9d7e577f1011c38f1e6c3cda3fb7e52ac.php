<?php $__env->startSection('content'); ?>
<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3"><?php echo e(translate('Set Categories Refund Policy')); ?></h1>
        </div>
        <div class="col-md-6 text-md-right">
            
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header d-block d-md-flex">
        <h5 class="mb-0 h6"><?php echo e(translate('Child Categories')); ?></h5>
        <form class="" id="sort_categories" action="" method="GET">
            <div class="box-inline pad-rgt pull-left">
                <div class="" style="min-width: 200px;">
                    <input type="text" class="form-control" id="search" name="search"<?php if(isset($sort_search)): ?> value="<?php echo e($sort_search); ?>" <?php endif; ?> placeholder="<?php echo e(translate('Type name & Enter')); ?>">
                </div>
            </div>
        </form>
    </div>
    <div class="card-body">
        <table class="table aiz-table mb-0">
            <thead>
                <tr>
                    <th data-breakpoints="lg">#</th>
                    <th><?php echo e(translate('Name')); ?></th>
                    <th data-breakpoints="lg"><?php echo e(translate('Parent Category')); ?></th>
                    <th data-breakpoints="lg"><?php echo e(translate('Order Level')); ?></th>
                    <th data-breakpoints="lg"><?php echo e(translate('Level')); ?></th>
                    
					<th data-breakpoints="lg"><?php echo e(translate('Return Policy')); ?></th>
                    
                    <th width="10%" class="text-right"><?php echo e(translate('Options')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e(($key+1) + ($categories->currentPage() - 1)*$categories->perPage()); ?></td>
                        <td><?php echo e($category->getTranslation('name')); ?></td>
                        <td>
                            <?php
                                $parent = \App\Category::where('id', $category->parent_id)->first();
                            ?>
                            <?php if($parent != null): ?>
                                <?php echo e($parent->getTranslation('name')); ?>

                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($category->order_level); ?></td>
                        <td><?php echo e($category->level); ?></td>
                        
						<td><?php echo e($category->return_policy); ?></td>
                        
                        <td class="text-right">
                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="<?php echo e(route('categories_refund_policy.edit', ['id'=>$category->id, 'lang'=>env('DEFAULT_LANGUAGE')] )); ?>" title="<?php echo e(translate('Edit')); ?>">
                                <i class="las la-edit"></i>
                            </a>
                            
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <div class="aiz-pagination">
            <?php echo e($categories->appends(request()->input())->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('modal'); ?>
    <?php echo $__env->make('modals.delete_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
    <script type="text/javascript">
        function update_featured(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('<?php echo e(route('categories.featured')); ?>', {_token:'<?php echo e(csrf_token()); ?>', id:el.value, status:status}, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', '<?php echo e(translate('Featured categories updated successfully')); ?>');
                }
                else{
                    AIZ.plugins.notify('danger', '<?php echo e(translate('Something went wrong')); ?>');
                }
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sadar24_aws/resources/views/refund_request/set_refund_config.blade.php ENDPATH**/ ?>