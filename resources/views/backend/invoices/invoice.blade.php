<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{  translate('INVOICE') }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="UTF-8">
	<style media="all">
        @page {
			margin: 0;
			padding:0;
		}
		body{
			font-size: 0.875rem;
            font-family: '<?php echo  $font_family ?>';
            font-weight: normal;
            direction: <?php echo  $direction ?>;
            text-align: <?php echo  $text_align ?>;
			padding:0;
			margin:0; 
		}
		.gry-color *,
		.gry-color{
			color:#000;
		}
		table{
			width: 100%;
		}
		table th{
			font-weight: normal;
		}
		table.padding th{
			padding: .25rem .7rem;
		}
		table.padding td{
			padding: .25rem .7rem;
		}
		table.sm-padding td{
			padding: .1rem .7rem;
		}
		.border-bottom td,
		.border-bottom th{
			border-bottom:1px solid #eceff4;
		}
		.text-left{
			text-align:<?php echo  $text_align ?>;
		}
		.text-right{
			text-align:<?php echo  $not_text_align ?>;
		}
		.text-center{
			text-align:center;
		}
	</style>
</head>
<body>
	<div>

		@php
			$logo = get_setting('system_logo_black');
		@endphp

		<div style="padding: 1rem;">
			<table>
				@php
					$shipping_address = json_decode($order->shipping_address);
					$seller_details = $seller->user->shop;
					
				@endphp
				<tr>
					<td>
						<img src="{{ uploaded_asset($logo) }}" height="60" style="display:inline-block;">
					</td>
					<td style="font-size: 1.5rem;" class="text-right strong">{{  translate('Tax Invoice/Bill of Supply/Cash Memo') }} <br/> {{  translate('(Original for Recipient)') }}</td>
				</tr>
			</table>
			<table>
				<tr>
					<td style="font-size: 1rem;" class="strong">{{ translate('Sold By') }} :</td>
					<td class="text-right">{{ translate('Billed To') }} :</td>
				</tr>
				<tr>
					<td style="font-size: 1rem;" class="strong">{{ $seller_details->name }}</td>
					<td class="text-right">{{ $shipping_address->name }}</td>
				</tr>
				<tr>
					<td class="gry-color small">{{ $seller_details->address }}, {{ $seller_details->city }}, {{ $seller_details->state }}, {{ $seller_details->country }}</td>
					<td class="text-right">{{ $shipping_address->address }}, {{ $shipping_address->city }},  {{ $shipping_address->state}}, {{ $shipping_address->country }}</td>
				</tr>
				<tr>
					<td class="gry-color small">Pan Number: {{ $seller_details->pan_number }}</td>
					<td class="text-right"> {{ $shipping_address->city }}, {{ $shipping_address->state }}, {{ $shipping_address->postal_code }}</td>
				</tr>
				<tr>
					<td class="gry-color small">{{  translate('GST Number') }}: {{ $seller_details->gst_number }}</td>
					<td class="text-right"><br/></td>
				</tr>
				<tr>
					<td style="font-size: 1rem;" class="strong"></td>
					<td class="text-right">{{ translate('Shipped To') }} :</td>
				</tr>
				<tr>
					<td style="font-size: 1rem;" class="strong"></td>
					<td class="text-right">{{ $shipping_address->name }}</td>
				</tr>
				<tr>
					<td class="gry-color small"></td>
					<td class="text-right">{{ $shipping_address->address }}, {{ $shipping_address->city }}, {{ $shipping_address->state }}, {{ $shipping_address->country }}</td>
				</tr>
				<tr>
					<td class="gry-color small"></td>
					<td class="text-right"> {{ $shipping_address->city }}, {{ $shipping_address->postal_code }}</td>
				</tr>
			</table>

		</div>
		
		<div style="padding: 1rem;padding-bottom: 0">
            <table>
				@php
					$shipping_address = json_decode($order->shipping_address);					;
					$order->payment_type = str_replace("_", " ", $order->payment_type);					
				@endphp
				
				<tr>
				<td class="gry-color small"></td>
				<td class="text-right">{{ translate('Place of Delivery') }}: {{ $shipping_address->state }}</td>
				</tr>
				<tr>
				<td class="gry-color small"></td>
				<td class="text-right">{{ translate('Place of Supply') }}: {{ $shipping_address->state }}</td>
				</tr>
				
			</table>
		</div>
		
		<div style="padding: 1rem;padding-bottom: 0">
			<table>
				<tr>
					<td class="gry-color small"><span class="gry-color small">{{  translate('Order Number') }}:</span> <span class="strong">{{ $order->code }}</span></td>
					<td class="text-right small"><span class="gry-color small">{{  translate('Invoice Number') }}:</span> <span class="strong">{{ $order->code }}</span></td>
				</tr>
				<tr>
					<td class="gry-color small"><span class="gry-color small">{{  translate('Order Date') }}:</span> <span class=" strong">{{ date('d-m-Y', $order->date) }}</span></td>
					<td class="text-right small"><span class="gry-color small">{{  translate('Invoice Date') }}:</span> <span class=" strong">{{ date('d-m-Y', $order->date) }}</span></td>
				</tr>
				<tr>
					<td class="strong  gry-color"><span class="gry-color small">{{  translate('Payment Method') }}:</span> <span class="strong">{{ $order->payment_type }}</span></td>
					<td class="strong text-right  gry-color"></td>
				</tr>
				<tr>
					<td class="strong  gry-color"><span class="gry-color small">{{  translate('Payment Status') }}:</span> <span class="strong">{{ $order->payment_status }}</span></td>
					<td class="strong text-right  gry-color"></td>
				</tr>
			</table>
		
		</div>

	    <div style="padding: 1rem;">
			<table class="padding text-left small border-bottom">
				<thead>
	                <tr class="gry-color" style="background: #eceff4;">
	                    <th width="26%" class="text-center">{{ translate('Product Name') }}</th>
						{{-- <th width="12%" class="text-center">{{ translate('Unit Price') }}</th> --}}
						<th width="7%" class="text-center">{{ translate('Qty') }}</th>
						<th width="12%" class="text-center">{{ translate('Net Amount') }}</th>
						<th width="8%" class="text-center" >{{ translate('Tax') }}</th>
						<th width="10%" class="text-center" >{{ translate('Tax Type') }}</th>
						<th width="10%" class="text-center">{{ translate('Tax Amount') }}</th>
	                    <th width="15%" class="text-right">{{ translate('Total') }}</th>
	                </tr>
				</thead>
				<tbody class="strong">
	                @foreach ($order->orderDetails as $key => $orderDetail)
		                @if ($orderDetail->product != null)
						@php						
								$check_product_gst = \App\ProductTax::select('tax')->where('product_id', $orderDetail->product_id)->first();	
								if ($check_product_gst === null) {								    
									$gstper = $orderDetail->product->category->gst;
								}else{
									$gstper = $check_product_gst->tax;
								}
								
								$gstval = $orderDetail->price - ($orderDetail->price *(100/(100+$gstper)));
								$unit_price  = $orderDetail->price - $gstval;								
								$vendor_state=	$orderDetail->product->user->state;
								$customer_state =	$shipping_address->state;
							@endphp
							<tr class="">
								<td>
									{{ $orderDetail->product->name }} 
									@if($orderDetail->product->stocks->first()->variant != null) ({{ $orderDetail->product->stocks->first()->variant  }}) @endif	
									<hr>
									@if(!empty($orderDetail->variation))													
										<p style="margin: 0; line-height: 9pt; font-size:10px;font-weight: bold;">Size : {{ $orderDetail->variation }}</p>
									@endif	
									@if(!empty($orderDetail->product->category->sku))													
										<p style="margin: 0; line-height: 9pt; font-size:10px;font-weight: bold;">SKU : {{ $orderDetail->product->category->sku }}</p>
									@endif	
									@if(!empty($orderDetail->product->category->hsn))													
										<p style="margin: 0; line-height: 9pt; font-size:10px;font-weight: bold;">HSN : {{ $orderDetail->product->category->hsn }}</p>
									@endif
								</td>
								{{-- <td class="currency text-center">{{ single_price($unit_price/$orderDetail->quantity) }}</td> --}}
								<td class="text-center">{{ $orderDetail->quantity }}</td>
								<td class="currency text-center">{{ single_price($unit_price) }}</td>
								
								@if (strtolower($customer_state) == strtolower($vendor_state))
								<td class="currency text-center">{{ $gstper/2 }}% <br/> {{ $gstper/2 }}% </td>
								<td class="currency text-center" colspan="1">
								{{ translate('SGST') }}
								<br/>
								{{ translate('CGST') }}
								</td>
								
								<td class="currency text-center" colspan="1">
								{{ single_price_with_decimal(($gstval)/2) }}
								<br/>
								{{ single_price_with_decimal(($gstval)/2) }}
								</td>
																
								@else
								<td class="currency text-center">{{ $gstper }}%</td>
								<td class="currency text-center" >
								{{ translate('IGST') }}
								</td>
								<td class="currency text-center" >
								{{ single_price_with_decimal($gstval) }}
								</td>
								
								@endif
								</td>
			                    <td class="text-right currency">{{ single_price($orderDetail->price) }}</td>
							</tr>
		                @endif
					@endforeach
	            </tbody>
			</table>
		</div>		
	    <div style="padding:0 1.5rem;">
	        <table class="text-right sm-padding small strong">
	        	<thead>
	        		<tr>
	        			<th width="60%"></th>
	        			<th width="40%"></th>
	        		</tr>
	        	</thead>
		        <tbody>
			        <tr>
			            <td>
			            </td>
			            <td>
					        <table class="text-right sm-padding small strong">
						        <tbody>
							        <tr>
							            <th class="gry-color text-left">{{ translate('Sub Total') }}</th>
							            <td class="currency">{{ single_price($order->orderDetails->sum('price')) }}</td>
							        </tr>
							        <tr>
							            <th class="gry-color text-left">{{ translate('Shipping Cost') }}</th>
							           <td class="currency">{{ single_price($order->orderDetails->sum('shipping_cost')) }}</td>
							        </tr>
									@if (strtolower($customer_state) == strtolower($vendor_state))
										<tr class="border-bottom">
											<th class="gry-color text-left">{{ translate('SGST') }}</th>
											<td class="currency">{{ single_price($order->orderDetails->sum('tax') / 2) }}</td>
										</tr>
										<tr class="border-bottom">
											<th class="gry-color text-left">{{ translate('CGST') }}</th>
											<td class="currency">{{ single_price($order->orderDetails->sum('tax') / 2) }}</td>
										</tr>
									@else
										<tr class="border-bottom">
											<th class="gry-color text-left">{{ translate('IGST') }}</th>
											<td class="currency">{{ single_price($order->orderDetails->sum('tax')) }}</td>
										</tr>	
									@endif
							        <tr class="border-bottom">
							            <th class="gry-color text-left">{{ translate('Coupon Discount') }}</th>
							            <td class="currency">{{ single_price($order->coupon_discount) }}</td>
							        </tr>
									<tr>
							            <th class="text-left strong">{{ translate('Round Off') }}</th>
							           <td class="currency">{{ single_price(round($order->grand_total)-$order->grand_total) }}</td>
							        </tr>
							        <tr>
							            <th class="text-left strong">{{ translate('Grand Total') }}</th>
							            <td class="currency">{{ single_price($order->grand_total) }}</td>
							        </tr>									
									<tr>
							            <td class="text-right strong" colspan="2"><br/><br/>{{ $seller_details->name }} <br/><br/><br/></td>
							        </tr>
									<tr>							            
							            <td class="text-right strong" colspan="2">{{ translate('Authorized Signatory') }}<br/><br/></td>
							        </tr>
						        </tbody>
						    </table>
			            </td>
			        </tr>
					
					<tr>
			            <td class="text-left" colspan="2">
							<hr/>
							{{ translate('Declaration : The goods sold as part of this shipment are intended for end-user consumption and not for retail sale.') }}
			            </td>
					</tr>
		        </tbody>
		    </table>
	    </div>

	</div>
</body>
</html>
