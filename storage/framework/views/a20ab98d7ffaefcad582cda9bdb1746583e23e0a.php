<?php $__env->startSection('content'); ?>

<div class="card">
    <div class="card-header">
        <h1 class="h2 fs-16 mb-0"><?php echo e(translate('Order Details')); ?></h1>
    </div>
    <div class="card-body">
        <div class="row gutters-5">
            <div class="col text-center text-md-left">
            </div>
            <?php
            $delivery_status = $order->delivery_status;
            $payment_status = $order->payment_status;
            ?>

            <!--Assign Delivery Boy-->
            <?php if(\App\Addon::where('unique_identifier', 'delivery_boy')->first() != null &&
                \App\Addon::where('unique_identifier', 'delivery_boy')->first()->activated): ?>
                <div class="col-md-3 ml-auto">
                    <label for="assign_deliver_boy"><?php echo e(translate('Assign Deliver Boy')); ?></label>
                    <?php if($delivery_status == 'pending' || $delivery_status == 'confirmed' || $delivery_status == 'picked_up'): ?>
                    <select class="form-control aiz-selectpicker" data-live-search="true" data-minimum-results-for-search="Infinity" id="assign_deliver_boy">
                        <option value=""><?php echo e(translate('Select Delivery Boy')); ?></option>
                        <?php $__currentLoopData = $delivery_boys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $delivery_boy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($delivery_boy->id); ?>" <?php if($order->assign_delivery_boy == $delivery_boy->id): ?> selected <?php endif; ?>>
                            <?php echo e($delivery_boy->name); ?>

                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php else: ?>
                        <input type="text" class="form-control" value="<?php echo e(optional($order->delivery_boy)->name); ?>" disabled>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="col-md-3 ml-auto">
                <label for="update_payment_status"><?php echo e(translate('Payment Status')); ?></label>
                <select class="form-control aiz-selectpicker"  data-minimum-results-for-search="Infinity" id="update_payment_status">
                    <option value="unpaid" <?php if($payment_status == 'unpaid'): ?> selected <?php endif; ?>><?php echo e(translate('Unpaid')); ?></option>
                    <option value="paid" <?php if($payment_status == 'paid'): ?> selected <?php endif; ?>><?php echo e(translate('Paid')); ?></option>
                </select>
            </div>
            <div class="col-md-3 ml-auto">
                <label for="update_delivery_status"><?php echo e(translate('Delivery Status')); ?></label>
                <?php if($delivery_status != 'delivered' && $delivery_status != 'cancelled'): ?>
                    <select class="form-control aiz-selectpicker"  data-minimum-results-for-search="Infinity" id="update_delivery_status">
                        <option value="pending" <?php if($delivery_status == 'pending'): ?> selected <?php endif; ?>><?php echo e(translate('Pending')); ?></option>
                        <option value="confirmed" <?php if($delivery_status == 'confirmed'): ?> selected <?php endif; ?>><?php echo e(translate('Confirmed')); ?></option>
                        <option value="picked_up" <?php if($delivery_status == 'picked_up'): ?> selected <?php endif; ?>><?php echo e(translate('Picked Up')); ?></option>
                        <option value="on_the_way" <?php if($delivery_status == 'on_the_way'): ?> selected <?php endif; ?>><?php echo e(translate('On The Way')); ?></option>
                        <option value="delivered" <?php if($delivery_status == 'delivered'): ?> selected <?php endif; ?>><?php echo e(translate('Delivered')); ?></option>
                        <option value="cancelled" <?php if($delivery_status == 'cancelled'): ?> selected <?php endif; ?>><?php echo e(translate('Cancel')); ?></option>
                    </select>
                <?php else: ?>
                    <input type="text" class="form-control" value="<?php echo e($delivery_status); ?>" disabled>
                <?php endif; ?>
            </div>
        </div>
        <div class="row gutters-5">
            <div class="col text-center text-md-left">
                <address>
                    <strong class="text-main"><?php echo e(json_decode($order->shipping_address)->name); ?></strong><br>
                    <?php echo e(json_decode($order->shipping_address)->email); ?><br>
                    <?php echo e(json_decode($order->shipping_address)->phone); ?><br>
                    <?php echo e(json_decode($order->shipping_address)->address); ?>, <?php echo e(json_decode($order->shipping_address)->city); ?>, <?php echo e(json_decode($order->shipping_address)->postal_code); ?><br>
                    <?php echo e(json_decode($order->shipping_address)->country); ?>

                </address>
                <?php if($order->manual_payment && is_array(json_decode($order->manual_payment_data, true))): ?>
                <br>
                <strong class="text-main"><?php echo e(translate('Payment Information')); ?></strong><br>
                <?php echo e(translate('Name')); ?>: <?php echo e(json_decode($order->manual_payment_data)->name); ?>, <?php echo e(translate('Amount')); ?>: <?php echo e(single_price(json_decode($order->manual_payment_data)->amount)); ?>, <?php echo e(translate('TRX ID')); ?>: <?php echo e(json_decode($order->manual_payment_data)->trx_id); ?>

                <br>
                <a href="<?php echo e(uploaded_asset(json_decode($order->manual_payment_data)->photo)); ?>" target="_blank"><img src="<?php echo e(uploaded_asset(json_decode($order->manual_payment_data)->photo)); ?>" alt="" height="100"></a>
                <?php endif; ?>
            </div>
            <div class="col-md-4 ml-auto">
                <table>
                    <tbody>
                        <tr>
                            <td class="text-main text-bold"><?php echo e(translate('Order #')); ?></td>
                            <td class="text-right text-info text-bold">	<?php echo e($order->code); ?></td>
                        </tr>
                        <tr>
                            <td class="text-main text-bold"><?php echo e(translate('Order Status')); ?></td>
                            <td class="text-right">
                                <?php if($delivery_status == 'delivered'): ?>
                                <span class="badge badge-inline badge-success"><?php echo e(translate(ucfirst(str_replace('_', ' ', $delivery_status)))); ?></span>
                                <?php else: ?>
                                <span class="badge badge-inline badge-info"><?php echo e(translate(ucfirst(str_replace('_', ' ', $delivery_status)))); ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-main text-bold"><?php echo e(translate('Order Date')); ?>	</td>
                            <td class="text-right"><?php echo e(date('d-m-Y h:i A', $order->date)); ?></td>
                        </tr>
                        <tr>
                            <td class="text-main text-bold">
                                <?php echo e(translate('Total amount')); ?>

                            </td>
                            <td class="text-right">
                                <?php echo e(single_price($order->grand_total)); ?>

                            </td>
                        </tr>
                        <tr>
                            <td class="text-main text-bold"><?php echo e(translate('Payment method')); ?></td>
                            <td class="text-right"><?php echo e(ucfirst(str_replace('_', ' ', $order->payment_type))); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <hr class="new-section-sm bord-no">
        <div class="row">
            <div class="col-lg-12 table-responsive">
                <table class="table table-bordered aiz-table invoice-summary">
                    <thead>
                        <tr class="bg-trans-dark">
                            <th data-breakpoints="lg" class="min-col">#</th>
                            <th width="10%"><?php echo e(translate('Photo')); ?></th>
                            <th class="text-uppercase"><?php echo e(translate('Description')); ?></th>
							<th data-breakpoints="md"><?php echo e(translate('Variation')); ?></th>
                            <th data-breakpoints="lg" class="min-col text-center text-uppercase"><?php echo e(translate('Qty')); ?></th>
                            <th data-breakpoints="lg" class="min-col text-center text-uppercase"><?php echo e(translate('Price')); ?></th>
                            <th data-breakpoints="lg" class="min-col text-right text-uppercase"><?php echo e(translate('Total')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $order->orderDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $orderDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key+1); ?></td>
                            <td>
                                <?php if($orderDetail->product != null && $orderDetail->product->auction_product == 0): ?>
                                    <a href="<?php echo e(route('product', $orderDetail->product->slug)); ?>" target="_blank"><img height="50" src="<?php echo e(uploaded_asset($orderDetail->product->thumbnail_img)); ?>"></a>
                                <?php elseif($orderDetail->product != null && $orderDetail->product->auction_product == 1): ?>
                                    <a href="<?php echo e(route('auction-product', $orderDetail->product->slug)); ?>" target="_blank"><img height="50" src="<?php echo e(uploaded_asset($orderDetail->product->thumbnail_img)); ?>"></a>
                                <?php else: ?>
                                    <strong><?php echo e(translate('N/A')); ?></strong>
                                <?php endif; ?>
                            </td>							
                            <td>
                                <?php if($orderDetail->product != null && $orderDetail->product->auction_product == 0): ?>
                                    <strong><a href="<?php echo e(route('product', $orderDetail->product->slug)); ?>" target="_blank" class="text-muted"><?php echo e($orderDetail->product->getTranslation('name')); ?></a></strong>                                   
                                <?php elseif($orderDetail->product != null && $orderDetail->product->auction_product == 1): ?>
                                    <strong><a href="<?php echo e(route('auction-product', $orderDetail->product->slug)); ?>" target="_blank" class="text-muted"><?php echo e($orderDetail->product->getTranslation('name')); ?></a></strong>
                                <?php else: ?>
                                    <strong><?php echo e(translate('Product Unavailable')); ?></strong>
                                <?php endif; ?>
                            </td>
							<td><?php echo e($orderDetail->variation); ?></td>
                           
                            <td class="text-center"><?php echo e($orderDetail->quantity); ?></td>
                            <td class="text-center"><?php echo e(single_price($orderDetail->price/$orderDetail->quantity)); ?></td>
                            <td class="text-center"><?php echo e(single_price($orderDetail->price)); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>		
        <div class="clearfix float-right">
            <table class="table">
                <tbody>
                    <tr>
                        <td>
                            <strong class="text-muted"><?php echo e(translate('Sub Total')); ?> :</strong>
                        </td>
                        <td>
                            <?php echo e(single_price($order->orderDetails->sum('price'))); ?>

                        </td>
                    </tr>
					<tr>
                        <td><strong class="text-muted"><?php echo e(translate('Shipping')); ?> :</strong></td>
                        <td class="currency"><?php echo e(single_price($order->orderDetails->sum('shipping_cost'))); ?></td>
                    </tr>
                    <tr>
                        <td>
                            <strong class="text-muted"><?php echo e(translate('Shipping GST')); ?> :</strong>
                        </td>
                        <td>
                            <?php echo e(single_price($order->orderDetails->sum('tax'))); ?>

                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong class="text-muted"><?php echo e(translate('Coupon')); ?> :</strong>
                        </td>
                        <td>
                            <?php echo e(single_price($order->coupon_discount)); ?>

                        </td>
                    </tr>
                    <?php if($order->payment_type == "razorpay"): ?>
                    <tr>
                        <td>
                            <strong class="text-muted"><?php echo e(translate('Online Discount')); ?> :</strong>
                        </td>
                        <td>
                            <?php echo e(single_price(20)); ?>

                        </td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <td>
                            <strong class="text-muted"><?php echo e(translate('TOTAL')); ?> :</strong>
                        </td>
                        <td class="text-muted h5">
                            <?php echo e(single_price($order->grand_total)); ?>

                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="text-right no-print">
                <a href="<?php echo e(route('invoice.download', $order->id)); ?>" type="button" class="btn btn-icon btn-light"><i class="las la-print"></i></a>
            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script type="text/javascript">
        $('#assign_deliver_boy').on('change', function(){
            var order_id = <?php echo e($order->id); ?>;
            var delivery_boy = $('#assign_deliver_boy').val();
            $.post('<?php echo e(route('orders.delivery-boy-assign')); ?>', {
                _token          :'<?php echo e(@csrf_token()); ?>',
                order_id        :order_id,
                delivery_boy    :delivery_boy
            }, function(data){
                AIZ.plugins.notify('success', '<?php echo e(translate('Delivery boy has been assigned')); ?>');
            });
        });

        $('#update_delivery_status').on('change', function(){
            var order_id = <?php echo e($order->id); ?>;
            var status = $('#update_delivery_status').val();
            $.post('<?php echo e(route('orders.update_delivery_status')); ?>', {
                _token:'<?php echo e(@csrf_token()); ?>',
                order_id:order_id,
                status:status
            }, function(data){
                AIZ.plugins.notify('success', '<?php echo e(translate('Delivery status has been updated')); ?>');
            });
        });

        $('#update_payment_status').on('change', function(){
            var order_id = <?php echo e($order->id); ?>;
            var status = $('#update_payment_status').val();
            $.post('<?php echo e(route('orders.update_payment_status')); ?>', {_token:'<?php echo e(@csrf_token()); ?>',order_id:order_id,status:status}, function(data){
                AIZ.plugins.notify('success', '<?php echo e(translate('Payment status has been updated')); ?>');
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sadar24_aws/resources/views/backend/sales/all_orders/show.blade.php ENDPATH**/ ?>