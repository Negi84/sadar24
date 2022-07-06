@extends('frontend.layouts.user_panel')

@section('panel_content')

	<div class="card">
		<form id="sort_orders" action="" method="GET">
			<div class="card-header row gutters-5">
				<div class="col text-center text-md-left">
					<h5 class="mb-md-0 h6">{{ translate('Orders') }}</h5>
				</div>
				<div class="col-md-3 ml-auto">
					<select class="form-control aiz-selectpicker" data-placeholder="{{ translate('Filter by Payment Status')}}" name="payment_status" onchange="sort_orders()">
						<option value="">{{ translate('Filter by Payment Status')}}</option>
						<option value="paid" @isset($payment_status) @if($payment_status == 'paid') selected @endif @endisset>{{ translate('Paid')}}</option>
						<option value="unpaid" @isset($payment_status) @if($payment_status == 'unpaid') selected @endif @endisset>{{ translate('Un-Paid')}}</option>
					</select>
				</div>

				<div class="col-md-3 ml-auto">
					<select class="form-control aiz-selectpicker" data-placeholder="{{ translate('Filter by Payment Status')}}" name="delivery_status" onchange="sort_orders()">
						<option value="">{{ translate('Filter by Deliver Status')}}</option>
						<option value="pending" @isset($delivery_status) @if($delivery_status == 'pending') selected @endif @endisset>{{ translate('Pending')}}</option>
						<option value="confirmed" @isset($delivery_status) @if($delivery_status == 'confirmed') selected @endif @endisset>{{ translate('Confirmed')}}</option>
						<option value="on_delivery" @isset($delivery_status) @if($delivery_status == 'on_delivery') selected @endif @endisset>{{ translate('On delivery')}}</option>
						<option value="delivered" @isset($delivery_status) @if($delivery_status == 'delivered') selected @endif @endisset>{{ translate('Delivered')}}</option>
					</select>
				</div>
				<div class="col-md-3">
					<div class="from-group mb-0">
						<input type="text" class="form-control" id="search" name="search" @isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type Order code & hit Enter') }}">
					</div>
				</div>
			</div>
		</form>

		@if (count($orders) > 0)
		<div class="card-body p-3">    
			@foreach ($orders as $key => $order_id)
				@php
					$order = \App\Order::find($order_id->id);
					$odate = date('Y-m-d H:i:s', $order->date);
				@endphp
				@if($order != null)
					
				<div class="box-layout seller_order_panel">
					<div class="row">
						<div class="col-md-8 remove_space">		
							@foreach ($order->orderDetails->where('seller_id', Auth::user()->id) as $key => $orderDetail)	
							
								<div class="row">	
									<div class="col-md-8 remove_space">
										<div class="product_details">
											@if ($orderDetail->product != null && $orderDetail->product->auction_product == 0)
												<img height="50" src="{{ uploaded_asset($orderDetail->product->thumbnail_img) }}">
											@elseif ($orderDetail->product != null && $orderDetail->product->auction_product == 1)												
												<img height="50" src="{{ uploaded_asset($orderDetail->product->thumbnail_img) }}">
											@else
												<strong>{{ translate('N/A') }}</strong>
											@endif
											<div class="">		
												@if ($orderDetail->product != null && $orderDetail->product->auction_product == 0)
													
													<a href="{{ route('product', $orderDetail->product->slug) }}"
														target="_blank">{{ $orderDetail->product->getTranslation('name') }}</a>
												@elseif($orderDetail->product != null && $orderDetail->product->auction_product == 1)
													<a href="{{ route('auction-product', $orderDetail->product->slug) }}"
														target="_blank">{{ $orderDetail->product->getTranslation('name') }}</a>
												@else
													<strong>{{ translate('Product Unavailable') }}</strong>
												@endif
												
												@if(!empty($orderDetail->variation))													
												<p style="margin: 0; line-height: 9pt; font-size:10px;font-weight: bold;">Size : {{ $orderDetail->variation }}</p>
												@endif												
											</div>
										</div>
									</div>
									<div class="col-md-4">
										{{ single_price($orderDetail->price) }}
									</div>	
								</div>
							@endforeach	
						</div>
						<div class="col-md-4 remove_space">
							<div class="product_details seller_details">
								<p><strong>Order ID:</strong> {{ $order->code }}</p>
								<p><strong>Order Date:</strong> {{ date('d-m-Y', $order->date) }}</p>
								@if ($order->waybill != null)
									<p><strong>AWB Number:</strong> {{ $order->waybill }}</p>
								@endif
								
								<p><strong> Customer Name:</strong> 
									@if ($order->user_id != null)
									{{ $order->user->name }}
									@else
									Guest ({{ $order->guest_id }})
									@endif
								</p>
								<p><strong>Grand Total:</strong> {{ single_price($order->grand_total) }}</p>
								@if($order->delivery_status == 'cancelled')										
									<span class="icons-design cancelled-icon"> </span> {{ translate(ucfirst(str_replace('_', ' ', $order->delivery_status))) }} on  {{ $orderDetail->updated_at}}
								@elseif($order->delivery_status == 'delivered')
									<span class="icons-design delivered-icon"> </span> {{ translate(ucfirst(str_replace('_', ' ', $order->delivery_status))) }} on  {{ $orderDetail->updated_at}}
								@else 
									<span class="icons-design pending-icon"> </span> {{ translate(ucfirst(str_replace('_', ' ', $order->delivery_status))) }} on  {{ $orderDetail->updated_at}}
								@endif
							</div>
						</div>
						<div class="clearfix mb-10"></div>	
						<div class="col-md-12 remove_space">
						
							<div class="clearfix mb-10"></div>	
							
							<a href="{{ route('orders.seller_order_details', encrypt($order->id)) }}" target="_blank" class="btn btn-soft-success btn-small" title="{{ translate('Order Details') }}">View Details</a>
							
							<a href="{{ route('invoice.download', $order->id) }}" class="btn btn-soft-warning btn-small" title="{{ translate('Download Invoice') }}">Invoice</a>
							
							@if($order->waybill == null && $order->orderDetails->first()->delivery_status == 'pending')
								<a class="btn btn-soft-danger btn-small" href="{{route('seller_orders.ready_to_ship', encrypt($order->id))}}" title="{{ translate('ReadyToShip') }}">Ready to Ship</a>						
							@endif  
							
							@if ($order->waybill != null && $order->orderDetails->first()->delivery_status != 'deliverd')
								<a class="btn btn-soft-info btn-small" href="{{route('seller_orders.packing_slip', encrypt($order->id))}}" title="{{ translate('Packing Slip') }}" target="_blank">Packing Slip</a>	
							@endif							
						</div>	
					</div>	
				</div>
				@endif
			@endforeach
			<div class="aiz-pagination">
				{{ $orders->links() }}
			</div>
		</div>
		@endif
	</div>

@endsection

@section('script')
    <script type="text/javascript">
        function sort_orders(el){
            $('#sort_orders').submit();
        }
    </script>
@endsection
