<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <meta http-equiv="Content-Type" content="text/html;" />
    <meta charset="UTF-8">
    <style media="all">
        @font-face {
            font-family: 'Roboto';
            src: url("<?php echo e(static_asset('fonts/Roboto-Regular.ttf')); ?>") format("truetype");
            font-weight: normal;
            font-style: normal;
        }

        * {
            margin: 0;
            padding: 0;
            line-height: 1.3;
            font-family: 'Roboto';
			font-weight: bold;
            color: black;
        }

        body {
            font-size: .875rem;
        }

        .gry-color *,
        .gry-color {
            color: #878f9c;
        }

        table {
            width: 100%;
        }

        table th {
            font-weight: normal;
        }

        table.padding th {
            padding: .5rem .7rem;
        }

        table.padding td {
            padding: .7rem;
        }

        table.sm-padding td {
            padding: .2rem .7rem;
        }

        .border-bottom td,
        .border-bottom th {
            border-bottom: 1px solid #eceff4;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .small {
            font-size: .85rem;
        }

        .currency {}

        #ship_det>tr>td {
            margin: 0px;
            width: 30%;
            border-left: 2px solid whitesmoke;
            padding: 5px;
			vertical-align:top;
			background-color: #232F3E;

        }

		.text-white{
			color:white!important;
		}
    </style>
</head>

<body>
    <div>
        <?php
            $logo = get_setting('header_logo');
            $inv = '';
        ?>
        <div style="    background: #131921;
  padding: 10px 20px;
  border-bottom: 5px solid whitesmoke;">
            <table>
                <tr>
                    <td>
                        <img src="https://sadar24.com/public/uploads/all/idE2ZcXje5TXUNjFNP7MipsKtzrXhIaAFt91qoe2.png""
                            height="60" style="display:inline-block;">
                    </td>
                    <td style="font-size: 1.5rem;" class="text-right strong"><?php echo e($inv); ?></td>

                </tr>
            </table>


        </div>

        <div style="padding: 13px;">
            <?php
                $shipping_address = json_decode($order->shipping_address);
                $seller = \App\Seller::where('user_id', $order->seller_id)->first();
                $seller_details = $seller->user->shop;
            ?>

            <table>
                <tbody id="ship_det">
                    <tr>
                        <td>
                            <table>
                                <tbody>
                                    <tr>
                                        <td style="font-size: 1.4rem; font-weight:bold;" class="strong text-white">SOLD BY
                                            :</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 1rem;" class="strong text-white"><?php echo e($seller_details->name); ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="small text-white"><?php echo e($seller_details->address); ?>,
                                            <?php echo e($seller_details->city); ?>,
                                            <?php echo e($seller_details->state); ?>, <?php echo e($seller_details->country); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="small text-white"><?php echo e(translate('Pan Number')); ?>:
                                            <?php echo e($seller_details->pan_number); ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="small text-white"><?php echo e(translate('GST Number')); ?>:
                                            <?php echo e($seller_details->gst_number); ?>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td>
                            <table>
                                <tbody>
                                    <tr>
										<td style="font-size: 1.4rem; font-weight:bold;" class="strong text-white">BILLED TO
                                            :</td>
                                    </tr>
                                    <tr>
                                        <td class="text-white"><?php echo e($shipping_address->name); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="small text-white"><?php echo e($shipping_address->address); ?>,
                                            <?php echo e($shipping_address->city); ?>,
                                            <?php echo e($shipping_address->country); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="small text-white"> <?php echo e($shipping_address->city); ?>,
                                            <?php echo e($shipping_address->state); ?>,
                                            <?php echo e($shipping_address->postal_code); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td>
                            <table>
                                <tbody>
                                    <tr>
										<td style="font-size: 1.4rem; font-weight:bold;" class="strong text-white">SHIPPED TO
                                            :</td>
                                    </tr>
                                    <tr>
                                        <td class="text-white"><?php echo e($shipping_address->name); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="small text-white"><?php echo e($shipping_address->address); ?>,
                                            <?php echo e($shipping_address->city); ?>,
                                            <?php echo e($shipping_address->state); ?>, <?php echo e($shipping_address->country); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="small text-white"> <?php echo e($shipping_address->city); ?>,
                                            <?php echo e($shipping_address->postal_code); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="padding: 1rem;padding-bottom: 0">
            <table>
                <?php
                    $orignalorder = $order->getOriginal();
                    
                ?>

                <tr>
                    <td class="gry-color small"><span class="gry-color small">Order Number:</span> <span
                            class="strong"><?php echo e($order->code); ?></span></td>
                    
                </tr>
                <tr>
                    <td class="gry-color small"><span class="gry-color small">Order Date:</span> <span
                            class=" strong"><?php echo e(date('d-m-Y', $order->date)); ?></span></td>
                    
                </tr>
                <tr>
                    <td class="strong  gry-color"><span class="gry-color small">Payment Method:</span> <span
                            class="strong"><?php echo e($order->payment_type); ?></span></td>
                    <td class="strong text-right  gry-color"></td>
                </tr>
                <tr>
                    <td class="strong  gry-color"><span class="gry-color small">Payment Status:</span> <span
                            class="strong"><?php echo e($order->payment_status); ?></span></td>
                    <td class="strong text-right  gry-color"></td>
                </tr>
            </table>
        </div>
		<div style="padding: 1rem;padding-bottom: 0">
            <table>
                <?php
                    $order_test = json_decode($order);
                    $shipping_address = json_decode($order->shipping_address);
                    $order->payment_type = str_replace('_', ' ', $order->payment_type);
                    $orignalorder = $order->getOriginal();
                    
                ?>
                <tr>
                    <td class="gry-color small"></td>
                    <td class="text-left"><?php echo e(translate('Place of Delivery')); ?>:
                        <?php echo e($shipping_address->state); ?></td>
                </tr>
                <tr>
                    <td class="gry-color small"></td>
                    <td class="text-left"><?php echo e(translate('Place of Supply')); ?>: <?php echo e($shipping_address->state); ?>

                    </td>
                </tr>
            </table>
        </div>
        <?php
            $order_test = json_decode($order);
            $shipping_address = json_decode($order->shipping_address);
            $address_state = '';
            $vendor_state = '';
            $order->payment_type = str_replace('_', ' ', $order->payment_type);
            $seller = \App\Seller::where('user_id', $order->seller_id)->first();
            $seller_details = $seller->user->shop;
            $address_state = $seller_details->state;
            
        ?>

        <div style="padding: 1.5rem;">
            <table class="padding text-left small border-bottom" >
                <thead>
                    <tr class="text-white" style="background: #c2151b;">
                        <th width="26%" class="text-center text-white"><?php echo e(translate('Product Name')); ?></th>
                        
                        <th width="7%" class="text-center text-white"><?php echo e(translate('Qty')); ?></th>
                        <th width="12%" class="text-center text-white"><?php echo e(translate('Net Amount')); ?></th>
                        <th width="8%" class="text-center text-white"><?php echo e(translate('Tax')); ?></th>
                        <th width="10%" class="text-center text-white"><?php echo e(translate('Tax Type')); ?></th>
                        <th width="10%" class="text-center text-white"><?php echo e(translate('Tax Amount')); ?></th>
                        <th width="15%" class="text-right text-white"><?php echo e(translate('Total')); ?></th>
                    </tr>
                </thead>
                <tbody class="strong">
                    <?php $__currentLoopData = $order->orderDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $orderDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($orderDetail->product != null): ?>
                            <?php
                                $product_id = $orderDetail->product->id;
                                $product = \App\Product::select('category_id', 'user_id')
                                    ->where('id', $product_id)
                                    ->first();
                                $category_id = $product->category_id;
                                $category = \App\Category::select('gst')
                                    ->where('id', $category_id)
                                    ->first();
                                $gstper = $category->gst;
                                $orignal_price = $orderDetail->price;
                                $gstval = $orignal_price - $orignal_price * (100 / (100 + $gstper));
                                $unit_price = $orignal_price - $gstval;
                                $gst_tax = $gstval;
                                $vendor_id = $product->user_id;
                                
                                $vendor = \App\User::select('state')
                                    ->where('id', $vendor_id)
                                    ->first();
                                $vendor_state = $vendor->state;
                                $orderDetail->tax = ($orderDetail->shipping_cost * $gstper) / 100;
                            ?>
                            <tr class="">
                                <td><?php echo e($orderDetail->product->name); ?> <?php if($orderDetail->variation != null): ?>
                                        (<?php echo e($orderDetail->variation); ?>)
                                    <?php endif; ?>
                                </td>
                                
                                </td>
                                <td class=""><?php echo e($orderDetail->quantity); ?></td>
                                <td class="currency"><?php echo e(single_price($unit_price)); ?></td>

                                <?php if(strtolower($address_state) == strtolower($vendor_state)): ?>
                                    <td class="currency text-center"><?php echo e($gstper / 2); ?>% <br /> <?php echo e($gstper / 2); ?>%
                                    </td>
                                    <td class="currency text-center" colspan="1">
                                        <?php echo e(translate('SGST')); ?>

                                        <br />
                                        <?php echo e(translate('CGST')); ?>

                                    </td>

                                    <td class="currency text-center" colspan="1">
                                        <?php echo e(single_price($gst_tax / 2)); ?>

                                        <br />
                                        <?php echo e(single_price($gst_tax / 2)); ?>

                                    </td>

                                <?php else: ?>
                                    <td class="currency text-center"><?php echo e($gstper); ?>%</td>
                                    <td class="currency text-center">
                                        <?php echo e(translate('IGST')); ?>

                                    </td>
                                    <td class="currency text-center">
                                        <?php echo e(single_price($gst_tax)); ?>

                                    </td>
                                <?php endif; ?>
                                </td>
                                <td class="text-right currency"><?php echo e(single_price($orderDetail->price)); ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <?php
            $subtotal = $order->orderDetails->sum('price');
            $shiping_cost = $subtotal * 0.05;
            $shipping_tax = $shiping_cost * 0.18;
            $order->grand_total = $subtotal + $shiping_cost + $shipping_tax;
            //$f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
            $round_of_amount = number_format((float) $order->grand_total, 0, '.', '');
        ?>
        <div style="padding:0 1.5rem;">
			<div style="background-color: #c2151b;width: 60% !important; float:left;">
				<div
					style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">

					<table style="font-family:'Lato',sans-serif;" role="presentation"
						width="100%" cellspacing="0" cellpadding="0" border="0">
						<tbody>
							<tr>
								<td style="overflow-wrap:break-word;word-break:break-word;padding:30px 20px;font-family:'Lato',sans-serif;"
									align="left">

									<div
										style="color: #ffffff; line-height: 140%; text-align: justify; word-wrap: break-word;">
										<p style="font-size: 14px; line-height: 140%;" class="text-white">To ensure
											your safety, the delivery agent will drop the
											package at your doorstep, ring the doorbell and then
											move back 2 meters while waiting for you to collect
											your package.</p>
										<p style="font-size: 14px; line-height: 140%;">&nbsp;
										</p>
										<p style="font-size: 14px; line-height: 140%;" class="text-white">Happy
											Shopping</p>
										<p style="font-size: 14px; line-height: 140%;"><a
												href="https://sadar24.com/"
												style="color: #fff;text-decoration: none;">Sadar24.com
											</a></p>
										<p style="font-size: 14px; line-height: 140%;" class="text-white">
											7800-708-708</p>
										<p
											style="font-size: 14px; line-height: 140%;color: #fff;">
											customercare@sadar24.com</p>
										<p
											style="font-size: 14px; line-height: 140%;/*! position: absolute; */text-align: right;">
											<a href="#" target="_blank"
												class="d-inline-block mr-3 ml-0"
												style="margin-right: 10px;">
												<img src="https://sadar24.com/public/assets/img/play.png"
													class="mx-100 h-40px"
													style="height: 40px;">
											</a>
											<a href="#" target="_blank" class="d-inline-block">
												<img src="https://sadar24.com/public/assets/img/app.png"
													class="mx-100 h-40px"
													style="height: 40px;">
											</a>
										</p>

									</div>

								</td>
							</tr>
						</tbody>
					</table>

				</div>
			</div>
            <table style="width: 40%; background-color:#232F3E; float:right; padding:10px;" class="text-right sm-padding small strong">
                <tbody>
                    <tr>
                        <th class="text-white text-left"><?php echo e(translate('Sub Total')); ?></th>
                        <td class="currency text-white"><?php echo e(single_price($order->orderDetails->sum('price'))); ?></td>
                    </tr>
                    <tr>
                        <th class="text-white text-left"><?php echo e(translate('Shipping Cost')); ?></th>
                        <td class="currency text-white"><?php echo e(single_price($shiping_cost)); ?></td>
                    </tr>
                    <?php if(strtolower($address_state) == strtolower($vendor_state)): ?>
                        <tr class="border-bottom">
                            <th class="text-white text-left"><?php echo e(translate('SGST')); ?></th>
                            <td class="currency text-white"><?php echo e(single_price($shipping_tax / 2)); ?></td>
                        </tr>
                        <tr class="border-bottom">
                            <th class="text-white text-left"><?php echo e(translate('CGST')); ?></th>
                            <td class="currency text-white"><?php echo e(single_price($shipping_tax / 2)); ?></td>
                        </tr>


                    <?php else: ?>
                        <tr class="border-bottom">
                            <th class="text-white text-left"><?php echo e(translate('IGST')); ?></th>
                            <td class="currency text-white"><?php echo e(single_price($shipping_tax)); ?></td>
                        </tr>
                    <?php endif; ?>

                    <tr class="border-bottom">
                        <th class="text-white text-left"><?php echo e(translate('Coupon Discount')); ?></th>
                        <td class="currency text-white"><?php echo e(single_price($order->coupon_discount)); ?></td>
                    </tr>
                    <tr>
                        <th class="text-left strong text-white"><?php echo e(translate('Grand Total')); ?></th>
                        <td class="currency text-white"><?php echo e(single_price($order->grand_total)); ?></td>
                    </tr>
                    <tr>
                        <th class="text-left strong text-white"><?php echo e(translate('Round Off Amount')); ?></th>
                        <td class="currency text-white"><?php echo e(single_price($round_of_amount)); ?></td>
                    </tr>
                    <tr>
                        <td class="text-right strong text-white" colspan="2"><br /><br /><?php echo e($seller_details->name); ?>

                            <br /><br /><br />
                        </td>

                    </tr>
                    <tr>

                        <td class="text-right strong text-white" colspan="2">
                            <?php echo e(translate('Authorized Signatory')); ?><br /><br />
                        </td>
                    </tr>
                </tbody>
            </table>
            <hr />
            <?php echo e(translate('Declaration : The goods sold as part of this shipment are intended for end-user consumption and not for retail sale.')); ?>

        </div>

    </div>
    
</body>

</html>
<?php /**PATH /var/www/sadar24_aws/resources/views/emails/invoice.blade.php ENDPATH**/ ?>