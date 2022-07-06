<?php $__env->startSection('content'); ?>

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-auto">
                <h1 class="h3"><?php echo e(translate('All products')); ?></h1>
            </div>
            <?php if($type != 'Seller'): ?>
                <div class="col text-right">
                    <a href="<?php echo e(route('products.create')); ?>" class="btn btn-circle btn-info">
                        <span><?php echo e(translate('Add New Product')); ?></span>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <br>

    <div class="card">
        <form class="" id="sort_products" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col">
                    <h5 class="mb-md-0 h6"><?php echo e(translate('All Product')); ?></h5>
                </div>

                <div class="dropdown mb-2 mb-md-0">
                    <button class="btn border dropdown-toggle" type="button" data-toggle="dropdown">
                        <?php echo e(translate('Bulk Action')); ?>

                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#" onclick="bulk_delete()">
                            <?php echo e(translate('Delete selection')); ?></a>
                    </div>
                </div>

                <?php if($type == 'Seller'): ?>
                    <div class="col-md-2 ml-auto">
                        <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" id="user_id"
                            name="user_id" data-live-search="true" onchange="sort_products()">
                            <option value=""><?php echo e(translate('All Sellers')); ?></option>
                            <?php $__currentLoopData = App\Seller::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $seller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($seller->user != null && $seller->user->shop != null): ?>
                                    <option value="<?php echo e($seller->user->id); ?>"
                                        <?php if($seller->user->id == $seller_id): ?> selected <?php endif; ?>><?php echo e($seller->user->shop->name); ?>

                                        (<?php echo e($seller->user->name); ?>)
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                <?php endif; ?>
                <?php if($type == 'All'): ?>
                    <div class="col-md-2 ml-auto">
                        <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" id="user_id"
                            name="user_id" data-live-search="true" onchange="sort_products()">
                            <option value=""><?php echo e(translate('All Sellers')); ?></option>
                            <?php $__currentLoopData = App\User::where('user_type', '=', 'admin')->orWhere('user_type', '=', 'seller')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $seller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($seller->id); ?>" <?php if($seller->id == $seller_id): ?> selected <?php endif; ?>>
                                    <?php echo e($seller->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                <?php endif; ?>
                <div class="col-md-2 ml-auto">
                    <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" name="type" id="type"
                        onchange="sort_products()">
                        <option value=""><?php echo e(translate('Sort By')); ?></option>
                        
                        <option value="unit_price,desc"
                            <?php if(isset($col_name, $query)): ?> <?php if($col_name == 'unit_price' && $query == 'desc'): ?> selected <?php endif; ?> <?php endif; ?>>
                            <?php echo e(translate('Base Price (High > Low)')); ?></option>
                        <option value="unit_price,asc"
                            <?php if(isset($col_name, $query)): ?> <?php if($col_name == 'unit_price' && $query == 'asc'): ?> selected <?php endif; ?> <?php endif; ?>>
                            <?php echo e(translate('Base Price (Low > High)')); ?></option>
                        <option value="published,desc"
                            <?php if(isset($col_name, $query)): ?> <?php if($col_name == 'published' && $query == 'desc'): ?> selected <?php endif; ?> <?php endif; ?>>
                            <?php echo e(translate('Published')); ?></option>
                        <option value="published,asc"
                            <?php if(isset($col_name, $query)): ?> <?php if($col_name == 'published' && $query == 'asc'): ?> selected <?php endif; ?> <?php endif; ?>>
                            <?php echo e(translate('Un Published')); ?></option>
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-0">
                        <form action="/productfil" method="post" id="data">
                            <?php echo e(csrf_field()); ?>

                            <input type="text" class="form-control form-control-sm" id="search" name="search"
                                <?php if(isset($sort_search)): ?> value="<?php echo e($sort_search); ?>" <?php endif; ?>
                                placeholder="<?php echo e(translate('Type & Enter')); ?>">
                            <input type="submit" style="display:none;" id="data" />
                        </form>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>
                                <div class="form-group">
                                    <div class="aiz-checkbox-inline">
                                        <label class="aiz-checkbox">
                                            <input type="checkbox" class="check-all">
                                            <span class="aiz-square-check"></span>
                                        </label>
                                    </div>
                                </div>
                            </th>
                            <!--<th data-breakpoints="lg">#</th>-->
                            <th><?php echo e(translate('Name')); ?></th>
                            <?php if($type == 'Seller' || $type == 'All'): ?>
                                <th data-breakpoints="lg"><?php echo e(translate('Added By')); ?></th>
                            <?php endif; ?>
                            <th data-breakpoints="sm"><?php echo e(translate('Info')); ?></th>
                            <th data-breakpoints="md"><?php echo e(translate('Total Stock')); ?></th>
                            <th data-breakpoints="lg"><?php echo e(translate('Todays Deal')); ?></th>
                            <th data-breakpoints="lg"><?php echo e(translate('Published')); ?></th>
                            <?php if(get_setting('product_approve_by_admin') == 1 && $type == 'Seller'): ?>
                                <th data-breakpoints="lg"><?php echo e(translate('Approved')); ?></th>
                            <?php endif; ?>
                            <th data-breakpoints="lg"><?php echo e(translate('Featured')); ?></th>
                            <th data-breakpoints="sm" class="text-right"><?php echo e(translate('Options')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $photos = explode(',', $product->photos);
                            ?>
                            <tr>
                                <!--<td><?php echo e($key + 1 + ($products->currentPage() - 1) * $products->perPage()); ?></td>-->
                                <td>
                                    <div class="form-group d-inline-block">
                                        <label class="aiz-checkbox">
                                            <input type="checkbox" class="check-one" name="id[]"
                                                value="<?php echo e($product->id); ?>">
                                            <span class="aiz-square-check"></span>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="row gutters-5 w-200px w-md-300px mw-100">
                                        <div class="col-auto">
                                            <img src="<?php if(count($photos) > 1): ?> <?php if($photos[0] == 0): ?><?php echo e(uploaded_asset($photos[1])); ?><?php else: ?><?php echo e(uploaded_asset($photos[0])); ?> <?php endif; ?>
                            <?php else: ?>
                                <?php echo e(uploaded_asset($photos[0])); ?> <?php endif; ?>" alt="Image" class="size-50px img-fit">
                                        </div>
                                        <div class="col">
                                            <span
                                                class="text-muted text-truncate-2"><?php echo e($product->getTranslation('name')); ?></span>
                                        </div>
                                    </div>
                                </td>
                                <?php if($type == 'Seller' || $type == 'All'): ?>
                                    <td><?php echo e($product->user->name); ?></td>
                                <?php endif; ?>
                                <td>
                                    <strong><?php echo e(translate('Num of Sale')); ?>:</strong> <?php echo e($product->num_of_sale); ?>

                                    <?php echo e(translate('times')); ?> </br>
                                    <strong><?php echo e(translate('MRP')); ?>:</strong>
                                    <?php echo e(single_price($product->unit_price)); ?> </br>
                                    <strong><?php echo e(translate('Selling Price')); ?>:</strong>
                                    <?php echo e(single_price($product->unit_price - $product->discount)); ?> </br>
                                    <strong><?php echo e(translate('Rating')); ?>:</strong> <?php echo e($product->rating); ?> </br>
                                </td>
                                <td>
                                    <?php
                                        $qty = 0;
                                        if ($product->variant_product) {
                                            foreach ($product->stocks as $key => $stock) {
                                                $qty += $stock->qty;
                                                echo $stock->variant . ' - ' . $stock->qty . '<br>';
                                            }
                                        } else {
                                            //$qty = $product->current_stock;
                                            $qty = optional($product->stocks->first())->qty;
                                            echo $qty;
                                        }
                                    ?>
                                    <?php if($qty <= $product->low_stock_quantity): ?>
                                        <span class="badge badge-inline badge-danger">Low</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input onchange="update_todays_deal(this)" value="<?php echo e($product->id); ?>"
                                            type="checkbox" <?php if ($product->todays_deal == 1) {
    echo 'checked';
} ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input onchange="update_published(this)" value="<?php echo e($product->id); ?>"
                                            type="checkbox" <?php if ($product->published == 1) {
    echo 'checked';
} ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <?php if(get_setting('product_approve_by_admin') == 1 && $type == 'Seller'): ?>
                                    <td>
                                        <label class="aiz-switch aiz-switch-success mb-0">
                                            <input onchange="update_approved(this)" value="<?php echo e($product->id); ?>"
                                                type="checkbox" <?php if ($product->approved == 1) {
    echo 'checked';
} ?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                <?php endif; ?>
                                <td>
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input onchange="update_featured(this)" value="<?php echo e($product->id); ?>"
                                            type="checkbox" <?php if ($product->featured == 1) {
    echo 'checked';
} ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td class="text-right">
                                    <a class="btn btn-soft-success btn-icon btn-circle btn-sm"
                                        href="<?php echo e(route('product', $product->slug)); ?>" target="_blank"
                                        title="<?php echo e(translate('View')); ?>">
                                        <i class="las la-eye"></i>
                                    </a>
                                    <?php if($type == 'Seller'): ?>
                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                            href="<?php echo e(route('products.seller.edit', ['id' => $product->id, 'lang' => env('DEFAULT_LANGUAGE')])); ?>"
                                            title="<?php echo e(translate('Edit')); ?>">
                                            <i class="las la-edit"></i>
                                        </a>
                                    <?php else: ?>
                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                            href="<?php echo e(route('products.admin.edit', ['id' => $product->id, 'lang' => env('DEFAULT_LANGUAGE')])); ?>"
                                            title="<?php echo e(translate('Edit')); ?>">
                                            <i class="las la-edit"></i>
                                        </a>
                                    <?php endif; ?>
                                    <a class="btn btn-soft-warning btn-icon btn-circle btn-sm"
                                        onclick="dubProd('<?php echo e(route('products.duplicate', ['id' => $product->id, 'type' => 'In House'])); ?>')"
                                        
                                        title="<?php echo e(translate('Duplicate')); ?>">
                                        <i class="las la-copy"></i>
                                    </a>
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                        data-href="<?php echo e(route('products.destroy', $product->id)); ?>"
                                        title="<?php echo e(translate('Delete')); ?>">
                                        <i class="las la-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <div class="aiz-pagination">
                    <?php echo e($products->appends(request()->input())->links()); ?>

                </div>
            </div>
        </form>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal'); ?>
    <?php echo $__env->make('modals.delete_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

     <!-- Confirm Dublicate Modal -->
     <div class="modal fade" id="dubProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="GET" id="dubProductM">
                    <div class="modal-body">
                        <h5>Are you sure you wanna duplicate this product!?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-success" onclick="submitbtn(this)">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Confirm Dublicate Modal -->
<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
    <script type="text/javascript">
     function dubProd(e) {
            document.getElementById("dubProductM").setAttribute("action", e);
            $("#dubProduct").modal("show");
        }

        function submitbtn(e) {
            e.disabled = true;
            document.getElementById("dubProductM").submit();
            //Validation code goes here
        }

        $(document).on("change", ".check-all", function() {
            if (this.checked) {
                // Iterate each checkbox
                $('.check-one:checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $('.check-one:checkbox').each(function() {
                    this.checked = false;
                });
            }

        });

        $(document).ready(function() {
            //$('#container').removeClass('mainnav-lg').addClass('mainnav-sm');
        });

        function update_todays_deal(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('<?php echo e(route('products.todays_deal')); ?>', {
                _token: '<?php echo e(csrf_token()); ?>',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '<?php echo e(translate('Todays Deal updated successfully')); ?>');
                } else {
                    AIZ.plugins.notify('danger', '<?php echo e(translate('Something went wrong')); ?>');
                }
            });
        }

        function update_published(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('<?php echo e(route('products.published')); ?>', {
                _token: '<?php echo e(csrf_token()); ?>',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '<?php echo e(translate('Published products updated successfully')); ?>');
                } else {
                    AIZ.plugins.notify('danger', '<?php echo e(translate('Something went wrong')); ?>');
                }
            });
        }

        function update_approved(el) {
            if (el.checked) {
                var approved = 1;
            } else {
                var approved = 0;
            }
            $.post('<?php echo e(route('products.approved')); ?>', {
                _token: '<?php echo e(csrf_token()); ?>',
                id: el.value,
                approved: approved
            }, function(data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '<?php echo e(translate('Product approval update successfully')); ?>');
                } else {
                    AIZ.plugins.notify('danger', '<?php echo e(translate('Something went wrong')); ?>');
                }
            });
        }

        function update_featured(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('<?php echo e(route('products.featured')); ?>', {
                _token: '<?php echo e(csrf_token()); ?>',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '<?php echo e(translate('Featured products updated successfully')); ?>');
                } else {
                    AIZ.plugins.notify('danger', '<?php echo e(translate('Something went wrong')); ?>');
                }
            });
        }

        function sort_products(el) {
            $('#sort_products').submit();
        }

        function bulk_delete() {
            var data = new FormData($('#sort_products')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "<?php echo e(route('bulk-product-delete')); ?>",
                type: 'POST',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response == 1) {
                        location.reload();
                    }
                }
            });
        }
        $('#search').focusout(function() {
            $('#data').trigger("click");
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sadar24_aws/resources/views/backend/product/products/index.blade.php ENDPATH**/ ?>