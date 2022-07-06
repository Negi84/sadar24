<?php $__env->startSection('panel_content'); ?>

<?php	
    $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();		
?>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6"><?php echo e(translate('Purchase History')); ?></h5>
        </div>
        <?php if(count($orders) > 0): ?>
			
            <div class="card-body">
				<?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>	
					<?php							
						$p_id = "";
					?>
					<?php $__currentLoopData = $order->orderDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $orderDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>						
						<?php
							$product_id = $order->orderDetails->first()->product_id;
							$thumbnail_img = \App\Product::where('id', $product_id)->first()->thumbnail_img;
						?>
						<form id="option-choice-form-<?php echo e($orderDetail->product->id); ?>">
							<?php echo csrf_field(); ?>
							<input type="hidden" name="id" value="<?php echo e($orderDetail->product->id); ?>">
							<input type="hidden" name="quantity" class="col border-0 text-center flex-grow-1 fs-16 input-number" value="<?php echo e($orderDetail->quantity); ?>" >
						</form>
						<?php
							$p_id = $p_id.",".$orderDetail->product->id;
						?>
						
						<div class="box-layout">
							<div class="row ">								
								<div class="col-md-5">
									<div class="product_details">
										<img src="<?php echo e(uploaded_asset($thumbnail_img)); ?>" alt="Image" class="img-fit">
									
										<?php if($orderDetail->product != null && $orderDetail->product->auction_product == 0): ?>
											<a href="<?php echo e(route('product', $orderDetail->product->slug)); ?>"
												target="_blank"><?php echo e($orderDetail->product->getTranslation('name')); ?></a>
										<?php elseif($orderDetail->product != null && $orderDetail->product->auction_product == 1): ?>
											<a href="<?php echo e(route('auction-product', $orderDetail->product->slug)); ?>"
												target="_blank"><?php echo e($orderDetail->product->getTranslation('name')); ?></a>
										<?php else: ?>
											<strong><?php echo e(translate('Product Unavailable')); ?></strong>
										<?php endif; ?>
									</div>
								</div>
								<div class="col-md-2">
									<?php echo e(single_price($orderDetail->price)); ?>

								</div>
								<div class="col-md-5">									
									<?php if($order->delivery_status == 'cancelled'): ?>										
										<span class="icons-design cancelled-icon"> </span> <?php echo e(translate(ucfirst(str_replace('_', ' ', $order->delivery_status)))); ?> on  <?php echo e($orderDetail->updated_at); ?>

									<?php elseif($order->delivery_status == 'delivered'): ?>
										<span class="icons-design delivered-icon"> </span> <?php echo e(translate(ucfirst(str_replace('_', ' ', $order->delivery_status)))); ?> on  <?php echo e($orderDetail->updated_at); ?>

									<?php else: ?> 
										<span class="icons-design pending-icon"> </span> <?php echo e(translate(ucfirst(str_replace('_', ' ', $order->delivery_status)))); ?> on  <?php echo e($orderDetail->updated_at); ?>

									<?php endif; ?>
									<div class="clearfix mb-10"></div>
									
									<a href="<?php echo e(route('purchase_history.order_details', encrypt($order->id))); ?>" target="_blank" class="btn btn-soft-success btn-small" title="<?php echo e(translate('Order Details')); ?>">View Details</a>
									
									<?php if($order->orderDetails->first()->delivery_status == 'cancelled' || $order->orderDetails->first()->delivery_status == 'delivered'): ?>
										<a href="javascript:;" class="btn btn-soft-secondary btn-small" onclick="rebuyNow('<?php echo e(ltrim($p_id,',')); ?>')" title="<?php echo e(translate('Order Details')); ?>">Re-Order</a>
									<?php endif; ?>
									
									<?php if($order->orderDetails->first()->delivery_status == 'pending'): ?>
										<a href="javascript:void(0)" class="btn btn-soft-danger btn-small confirm-cancel" data-href="<?php echo e(route('orders.cancel', $order->id)); ?>" title="<?php echo e(translate('Cancel')); ?>">Cancel</a>
									<?php endif; ?>
									
									<?php if($order->waybill != null): ?>																					
										<a class="btn btn-soft-info btn-small" target="_blank" href="https://www.delhivery.com/track/package/<?php echo e($order->waybill); ?>" title="<?php echo e(translate('Track Order')); ?>">Track Order</a>					
									<?php endif; ?>
									
								</div>
							</div>	
						</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>		
                  
                <div class="aiz-pagination">
					<?php echo e($orders->links()); ?>

              	</div>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal'); ?>
    <?php echo $__env->make('modals.cancel_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="modal" id="order_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div id="order-details-modal-body">

                </div>
            </div>
        </div>
    </div>


    <div class="modal" id="payment_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div id="payment_modal_body">

                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script type="text/javascript">
        $('#order_details').on('hidden.bs.modal', function () {
            location.reload();
        })
		function rebuyNow(stringid){
			//alert(stringid);
			var ids = stringid.split(',');
			//console.log(ids);
			//console.log(ids.length);
			
            if(checkAddToCartValidity()) {
                $('#addToCart-modal-body').html(null);
                $('#addToCart').modal("show");
                $('.c-preloader').show();
				for (let i = 0; i < ids.length; i++) {
				  
				  $.ajax({
					   type:"POST",
					   url: 'https://sadar24.com/cart/addtocart',
					   data: $('#option-choice-form-'+ids[i]).serializeArray(),
					   success: function(data){
						   if(data.status == 1){

								$('#addToCart-modal-body').html(data.modal_view);
								updateNavCart(data.nav_cart_view,data.cart_count);
								if(i == ids.length-1){
									window.location.replace("https://sadar24.com/cart");
								}
						   }
						   else{
								$('#addToCart-modal-body').html(null);
								$('.c-preloader').hide();
								$('#modal-size').removeClass('modal-lg');
								$('#addToCart-modal-body').html(data.modal_view);
						   }
					   }
				   });
				}
                $.ajax({
                   type:"POST",
                   url: 'https://sadar24.com/cart/addtocart',
                   data: $('#option-choice-form').serializeArray(),
                   success: function(data){
                       if(data.status == 1){

                            $('#addToCart-modal-body').html(data.modal_view);
                            updateNavCart(data.nav_cart_view,data.cart_count);

                            window.location.replace("https://sadar24.com/cart");
                       }
                       else{
                            $('#addToCart-modal-body').html(null);
                            $('.c-preloader').hide();
                            $('#modal-size').removeClass('modal-lg');
                            $('#addToCart-modal-body').html(data.modal_view);
                       }
                   }
               });
            }
            else{
                AIZ.plugins.notify('warning', "Please choose all the options");
            }
        }

    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.user_panel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sadar24_aws/resources/views/frontend/user/purchase_history.blade.php ENDPATH**/ ?>