@extends('frontend.layouts.user_panel')

@section('panel_content')

@php
	$status = $order->orderDetails->where('seller_id', Auth::user()->id)->first()->delivery_status;
	$payment_status = $order->orderDetails->where('seller_id', Auth::user()->id)->first()->payment_status;
	$refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();

@endphp

	<div class="modal-body gry-bg px-3 pt-0">
		<div class="py-4">
			<div class="row gutters-5 text-center aiz-steps">
				<div class="col @if ($status == 'pending') active @else done @endif">
					<div class="icon">
						<i class="las la-file-invoice"></i>
					</div>
					<div class="title fs-12">{{ translate('Order placed')}}</div>
				</div>
				<div class="col @if ($status == 'Shipment details manifested') active @elseif($status == 'Pickup scheduled' || $status == 'delivered') done @endif">
					<div class="icon">
						<i class="las la-newspaper"></i>
					</div>
				  <div class="title fs-12">{{ translate('Shipped')}}</div>
				</div>
				<div class="col @if ($status == 'Out for Pickup') active @elseif($status == 'delivered') done @endif">
					<div class="icon">
						<i class="las la-truck"></i>
					</div>
					<div class="title fs-12">{{ translate('Out for Delivery')}}</div>
				</div>
				<div class="col @if ($status == 'delivered') done @endif">
					<div class="icon">
						<i class="las la-clipboard-check"></i>
					</div>
					<div class="title fs-12">{{ translate('Delivered')}}</div>
				</div>
			</div>
		</div>
	</div>

	<div class="card order_details">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Order Summary') }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <table class="table table-borderless">
                        <tr>
                            <td class="w-50 fw-600">{{ translate('Order Code') }}:</td>
                            <td>{{ $order->code }}</td>
                        </tr>
                        <tr>
                            <td class="w-50 fw-600">{{ translate('Customer') }}:</td>
                            <td>{{ json_decode($order->shipping_address)->name }}</td>
                        </tr>
                        <tr>
                            <td class="w-50 fw-600">{{ translate('Email') }}:</td>
                            @if ($order->user_id != null)
                                <td>{{ $order->user->email }}</td>
                            @endif
                        </tr>
                        <tr>
                            <td class="w-50 fw-600">{{ translate('Shipping address') }}:</td>
                            <td>{{ json_decode($order->shipping_address)->address }},
                                {{ json_decode($order->shipping_address)->city }},
                                {{ json_decode($order->shipping_address)->postal_code }},
                                {{ json_decode($order->shipping_address)->country }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-lg-6">
                    <table class="table table-borderless">
                        <tr>
                            <td class="w-50 fw-600">{{ translate('Order date') }}:</td>
                            <td>{{ date('d-m-Y H:i A', $order->date) }}</td>
                        </tr>
                        <tr>
                            <td class="w-50 fw-600">{{ translate('Order status') }}:</td>
                            <td>{{ translate(ucfirst(str_replace('_', ' ', $order->delivery_status))) }}</td>
                        </tr>
                        <tr>
                            <td class="w-50 fw-600">{{ translate('Total order amount') }}:</td>
                            <td>{{ single_price($order->orderDetails->sum('price') + $order->orderDetails->sum('tax')) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="w-50 fw-600">{{ translate('Shipping method') }}:</td>
                            <td>{{ translate('Flat shipping rate') }}</td>
                        </tr>
                        <tr>
                            <td class="w-50 fw-600">{{ translate('Payment method') }}:</td>
                            <td>{{ translate(ucfirst(str_replace('_', ' ', $order->payment_type))) }}</td>
                        </tr>
                        @if ($order->tracking_code)
                            <tr>
                                <td class="w-50 fw-600">{{ translate('Tracking code') }}:</td>
                                <td>{{ $order->tracking_code }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
	
	<div class="row order_details pt-10">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Order Details') }}</h5>
                </div>
                <div class="card-body">
                    <table class="table aiz-table">
                        <thead>
                            <tr>
                                <th>#</th>
								<th data-breakpoints="md">Image</th>
                                <th width="30%">{{ translate('Product') }}</th>
                                <th data-breakpoints="md">{{ translate('Variation') }}</th>
                                <th data-breakpoints="md">{{ translate('Quantity') }}</th>
                                <th>{{ translate('Price') }}</th>
                                @if ($refund_request_addon != null && $refund_request_addon->activated == 1)
                                    <th data-breakpoints="md">{{ translate('Refund')}}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderDetails as $key => $orderDetail)								
                                <tr>
                                    <td>{{ $key + 1 }}</td>
									<td>
										@if ($orderDetail->product != null && $orderDetail->product->auction_product == 0)
											<img height="50" src="{{ uploaded_asset($orderDetail->product->thumbnail_img) }}">
										@elseif ($orderDetail->product != null && $orderDetail->product->auction_product == 1)												
											<img height="50" src="{{ uploaded_asset($orderDetail->product->thumbnail_img) }}">
										@else
											<strong>{{ translate('N/A') }}</strong>
										@endif									
									</td>									
                                    <td>
                                        @if ($orderDetail->product != null)
                                            <a href="{{ route('product', $orderDetail->product->slug) }}"
                                                target="_blank">{{ $orderDetail->product->getTranslation('name') }}</a>
                                        @else
                                            <strong>{{ translate('Product Unavailable') }}</strong>
                                        @endif
                                    </td>
                                    <td>{{ $orderDetail->variation }}</td>
                                    <td>{{ $orderDetail->quantity }}</td>									
                                    <td>{{ single_price($orderDetail->price) }}</td>
									@if ($refund_request_addon != null && $refund_request_addon->activated == 1)
                                        <td>
                                            @if ($orderDetail->refund_request != null && $orderDetail->refund_request->refund_status == 0)
                                                <b class="text-info">{{ translate('Pending') }}</b>
                                            @elseif ($orderDetail->refund_request != null && $orderDetail->refund_request->refund_status == 2)
                                                <b class="text-success">{{ translate('Rejected') }}</b>
                                            @elseif ($orderDetail->refund_request != null && $orderDetail->refund_request->refund_status == 1)
                                                <b class="text-success">{{ translate('Approved') }}</b>
                                            @elseif ($orderDetail->product->refundable != 0)
                                                <b>{{ translate('N/A') }}</b>
                                            @else
                                                <b>{{ translate('Non-refundable') }}</b>
                                            @endif
                                        </td>
                                    @endif                              
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <b class="fs-15">{{ translate('Order Ammount') }}</b>
                </div>
                <div class="card-body pb-0">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td class="w-50 fw-600">{{ translate('Subtotal')}}</td>
                                <td class="text-right">
                                    <span class="strong-600">{{ single_price($order->orderDetails->sum('price')) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-50 fw-600">{{ translate('Shipping')}}</td>
                                <td class="text-right">
                                    <span class="text-italic">{{ single_price($order->orderDetails->sum('shipping_cost')) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-50 fw-600">{{ translate('Tax')}}</td>
                                <td class="text-right">
                                    <span class="text-italic">{{ single_price($order->orderDetails->sum('tax')) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-50 fw-600">{{ translate('Coupon')}}</td>
                                <td class="text-right">
                                    <span class="text-italic">{{ single_price($order->coupon_discount) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-50 fw-600">{{ translate('Total')}}</td>
                                <td class="text-right">
                                    <strong><span>{{ single_price($order->grand_total) }}</span></strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($order->manual_payment && $order->manual_payment_data == null)
                <button onclick="show_make_payment_modal({{ $order->id }})" class="btn btn-block btn-primary">{{ translate('Make Payment')}}</button>
            @endif
        </div>
    </div>

@endsection

