@extends('backend.layouts.app')

@section('content')
<div class="card">
    <form class="" action="" id="sort_orders" method="GET">
        <div class="card-header row gutters-5"> 
			<div class="col-lg-3">
                <div class="form-group mb-0">
                    <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" id="seller_id" data-live-search="true" name="seller_id">
                        <option value="">{{ translate('All Sellers') }}</option>
                        @foreach (App\Seller::all() as $key => $seller)
                        @if ($seller->user != null && $seller->user->shop != null)
                        <option value="{{ $seller->user->id }}" @if ($seller->user->id == $seller_id) selected @endif>
							{{$seller->user->id}} - {{ $seller->user->shop->name }} ({{ $seller->user->name }})
                        </option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>
			<div class="col-lg-2">
                <select class="form-control aiz-selectpicker" name="delivery_status" id="delivery_status">
                    <option value="">{{translate('Filter by Delivery Status')}}</option>
                    <option value="pending" @if ($delivery_status == 'pending') selected @endif>{{translate('Pending')}}</option>
                    <option value="confirmed" @if ($delivery_status == 'confirmed') selected @endif>{{translate('Confirmed')}}</option>
                    <option value="picked_up" @if ($delivery_status == 'picked_up') selected @endif>{{translate('Picked Up')}}</option>
                    <option value="on_the_way" @if ($delivery_status == 'on_the_way') selected @endif>{{translate('On The Way')}}</option>
                    <option value="delivered" @if ($delivery_status == 'delivered') selected @endif>{{translate('Delivered')}}</option>
                    <option value="cancelled" @if ($delivery_status == 'cancelled') selected @endif>{{translate('Cancel')}}</option>
                </select>
            </div>
			<div class="col-lg-2">
                <div class="form-group mb-0">
                    <input type="text" class="aiz-date-range form-control" value="{{ $order_date }}" name="order_date" placeholder="{{ translate('Filter by Order date') }}" data-format="DD-MM-Y" data-separator=" to " data-advanced-range="true" autocomplete="off">
                </div>
            </div>
			<div class="col-lg-2">
                <div class="form-group mb-0">
                    <input type="text" class="aiz-date-range form-control" value="{{ $delivered_date }}" name="delivered_date" placeholder="{{ translate('Filter by delivered date') }}" data-format="DD-MM-Y" data-separator=" to " data-advanced-range="true" autocomplete="off">
                </div>
            </div>			
			<div class="col-lg-2">
                <div class="form-group mb-0">
                    <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type Order code & hit Enter') }}">
                </div>
            </div>          
		</div>
		
		<div class="card-header row gutters-5">          
			<div class="col-lg-5">
                <div class="form-group mb-0">
					<button type="submit" class="btn btn-primary">{{ translate('Filter') }}</button>
					<a class="btn btn-primary" href="#" onclick="bulk_pay()"> {{translate('Pay Now')}}</a>					
					<button class="btn btn-md btn-primary" name="submit_type"  type="submit" value="export">{{ translate('Export Reports') }}</button>
                </div>
            </div>	           	
        </div>

        <div class="card-body table-responsive">	
            <table class="table aiz-table mb-0 text-center">
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
						<th data-breakpoints="lg">S.&nbsp;NO</th>
						<th data-breakpoints="lg">VENDOR</th>
						<th data-breakpoints="lg">ORDER&nbsp;ID</th>
						<th data-breakpoints="lg">ORDER&nbsp;DATE</th>
						<th data-breakpoints="lg">CUSTOMER</th>
						<th data-breakpoints="lg">WAYBILL</th>
						<th data-breakpoints="lg">DELIVERY&nbsp;STATUS</th>
						<th data-breakpoints="lg">DELIVERY&nbsp;DATE</th>
						<th data-breakpoints="lg">PAYMENT&nbsp;TYPE</th>
						<th data-breakpoints="lg">TAXABLE&nbsp;PRICE</th>
						<th data-breakpoints="lg">GST&nbsp;ON&nbsp;TAXABLE&nbsp;PRICE</th>
						<th data-breakpoints="lg">GST&nbsp;ON&nbsp;TAX&nbsp;AMOUNT</th>
						<th data-breakpoints="lg">SUBTOTAL</th>
						<th data-breakpoints="lg">DISCOUNT</th>
						<th data-breakpoints="lg">SHIPPING</th>							
						<th data-breakpoints="lg">INVOICE&nbsp;AMOUNT</th>						
						<th data-breakpoints="lg">AMOUNT&nbsp;RECEIVED</th>
						<th data-breakpoints="lg">AMOUNT&nbsp;RECEIVED&nbsp;DATE</th>						
						<th data-breakpoints="lg">TOTAL&nbsp;QTY</th>	
						<th data-breakpoints="lg">PLATFORM&nbsp;CHARGES</th>	
						<th data-breakpoints="lg">GST&nbsp;ON&nbsp;PLATFORM&nbsp;CHARGES&nbsp;18%</th>
						<th data-breakpoints="lg">GST&nbsp;TYPE&nbsp;ON&nbsp;PLATFORM&nbsp;CHARGES</th>							
						<th data-breakpoints="lg">SHIPPING</th>	
						<th data-breakpoints="lg">GST&nbsp;ON&nbsp;SHIPPING&nbsp;CHARGES</th>
						<th data-breakpoints="lg">GST&nbsp;TYPE&nbsp;ON&nbsp;SHIPPING&nbsp;CHARGES</th>
						<th data-breakpoints="lg">TDS</th>
						<th data-breakpoints="lg">TCS</th>
						<th data-breakpoints="lg">GST&nbsp;TYPE&nbsp;ON&nbsp;TCS</th>						
						<th data-breakpoints="lg">DISCOUNT&nbsp;AMOUNT</th>						
						<th data-breakpoints="lg">NET&nbsp;PAYABLE&nbsp;AMOUNT</th>
						<th data-breakpoints="lg">ROUND&nbsp;OF&nbsp;NET&nbsp;PAYABLE&nbsp;AMOUNT</th>						
						<th data-breakpoints="lg">PAID&nbsp;AMOUNT</th>	
						<th data-breakpoints="lg">PAID&nbsp;DATE</th>
                    </tr>
                </thead>
                
				<tbody>	
				
                    @foreach ($orders_ledger as $key => $order_ledger)	
						@if($order_ledger->paid_amount >= 0 && $order_ledger->paid_date != NULL)
							<tr class="alert alert-success disabled">
						@else
						<tr>
						@endif	
							<td>
								<div class="form-group">
									<div class="aiz-checkbox-inline">
										<label class="aiz-checkbox">
											<input type="checkbox" class="check-one" name="id[]" value="{{$order_ledger->id}}">
											<span class="aiz-square-check"></span>
										</label>
									</div>
								</div>
							</td>
							<td> {{ ($key+1) + ($orders_ledger->currentPage() - 1)*$orders_ledger->perPage() }}</td>
							<td>
								@if($order_ledger->order->seller)
								{{ $order_ledger->order->seller->name }}
								@endif
							</td>
							<td>{{ $order_ledger->code }}</td>
							<td>{{ $order_ledger->created_at }}</td>
							<td>
								@if ($order_ledger->order->user != null)
									{{ $order_ledger->order->user->name }}
								@else
									Guest ({{ $order_ledger->guest_id }})
								@endif
							</td>
							<td>{{ $order_ledger->order->waybill }}</td>
							<td>
								 @php
									$status = $order_ledger->delivery_status;
									if($order_ledger->delivery_status == 'delivered') {
										$status = '<span class="badge badge-inline badge-success">'.translate('Delivered').'</span>';
									}
								@endphp
								{!! $status !!}
							</td>
							<td>{{ $order_ledger->delivered_date }}</td>
							<td>{{ $order_ledger->order->payment_type }}</td>
							<td>{{ single_price($order_ledger->product_price) }}</td>
							<td>{{ $order_ledger->gst_on_product }}%</td>
							<td>{{ single_price($order_ledger->gst_on_product_amount) }}</td>
							<td>{{ single_price($order_ledger->subtotal) }}</td>							
							<td>{{ single_price($order_ledger->coupon_discount) }}</td>
							<td>{{ single_price($order_ledger->shipping + $order_ledger->shipping_with_gst) }}</td>
							<td>{{ single_price($order_ledger->invoice_amount) }}</td>
							<td>{{ single_price($order_ledger->amount_received) }}</td>
							<td>{{ $order_ledger->delivered_date }}</td>							
							<td>{{ $order_ledger->orderDetails->quantity }}</td>
							<td>{{ single_price($order_ledger->platform_charges) }}</td>							
							<td>
								@if(strtoupper($order_ledger->order->seller->state) == 'DELHI')										
									<span>{{ single_price($order_ledger->platform_charges_with_gst / 2 ) }}</span><br>
									<span>{{ single_price($order_ledger->platform_charges_with_gst / 2 )  }}</span>
                                @else
									<span>{{ single_price($order_ledger->platform_charges_with_gst)  }}</span>
                                @endif								
							</td>
							<td>
								@if(strtoupper($order_ledger->order->seller->state) == 'DELHI')										
									<span>CGST</span><br>
									<span>SGST</span>
                                @else
									<span>IGST</span>
                                @endif								
							</td>		
							<td>{{ single_price($order_ledger->shipping) }}</td>	
							<td>
								@if(strtoupper($order_ledger->order->seller->state) == 'DELHI')										
									<span>{{ single_price($order_ledger->shipping_with_gst / 2 ) }}</span><br>
									<span>{{ single_price($order_ledger->shipping_with_gst / 2 )  }}</span>
                                @else
									<span>{{ single_price($order_ledger->shipping_with_gst)  }}</span>
                                @endif								
							</td>
							<td>
								@if(strtoupper($order_ledger->order->seller->state) == 'DELHI')										
									<span>CGST</span><br>
									<span>SGST</span>
                                @else
									<span>IGST</span>
                                @endif								
							</td>
							<td>{{ single_price($order_ledger->tds) }}</td>	
							<td>
								@if(strtoupper($order_ledger->order->seller->state) == strtoupper(json_decode($order_ledger->order->shipping_address)->state))
									<span>{{ single_price($order_ledger->tcs / 2 ) }}</span><br>
									<span>{{ single_price($order_ledger->tcs / 2 )  }}</span>
                                @else
									<span>{{ single_price($order_ledger->tcs)  }}</span>
                                @endif
							</td>
							<td>
								@if(strtoupper($order_ledger->order->seller->state) == strtoupper(json_decode($order_ledger->order->shipping_address)->state))	
									<span>CGST</span><br>
									<span>SGST</span>
                                @else
									<span>IGST</span>
                                @endif
							</td>
							<td>{{ single_price($order_ledger->coupon_discount) }}</td>	
							<td>{{ single_price($order_ledger->seller_earning) }}</td>	
							<td>{{ single_price(round($order_ledger->seller_earning)) }}</td>	
							<td>{{ single_price(round($order_ledger->paid_amount)) }}</td>
							<td>{{ $order_ledger->paid_date }}</td>
						</tr>
					@endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $orders_ledger->appends(request()->input())->links() }}
            </div>

        </div>
    </form>
</div>

@endsection

@section('modal')
<!-- payment Modal -->
<div class="modal fade" id="payment_modal">
	<div class="modal-dialog">
		<div class="modal-content" id="payment-modal-content">

		</div>
	</div>
</div>

@endsection

@section('script')
    <script type="text/javascript">
        $(document).on("change", ".check-all", function() {
            if(this.checked) {
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
		
       function bulk_pay() {
            var data = new FormData($('#sort_orders')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('bulk-order-pay')}}",
                type: 'POST',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
					$('#payment-modal-content').html(response);
					$('#payment_modal').modal('show', {backdrop: 'static'});								
                }
            });
        }
    </script>
@endsection
