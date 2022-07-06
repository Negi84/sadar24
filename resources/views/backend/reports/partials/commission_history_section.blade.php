<form action="" class="" method="GET">
    <div class="card-header row gutters-5">       	
        @if(Auth::user()->user_type != 'seller')
        <div class="col-md-3 ml-auto">           
			<select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" id="demo-ease" data-minimum-results-for-search="Infinity" data-live-search="true" name="seller_id">
				<option value="">{{ translate('Choose Seller') }}</option>
				@foreach (App\Seller::all() as $key => $seller)
					@if ($seller->user != null && $seller->user->shop != null)
					<option value="{{ $seller->user->id }}" @if ($seller->user->id == $seller_id) selected @endif>
						{{$seller->user->id}} - {{ $seller->user->shop->name }} ({{ $seller->user->name }})
					</option>
					@endif
				@endforeach
			</select>
        </div>
        @endif
		<div class="col-md-2 ml-auto">  
			<select class="form-control aiz-selectpicker" name="delivery_status"  data-minimum-results-for-search="Infinity" data-live-search="true">
				<option value="">{{translate('Filter by Delivery Status')}}</option>
				<option value="pending">{{translate('Pending')}}</option>
				<option value="confirmed">{{translate('Confirmed')}}</option>
				<option value="picked_up">{{translate('Picked Up')}}</option>
				<option value="on_the_way">{{translate('On The Way')}}</option>
				<option value="delivered">{{translate('Delivered')}}</option>
				<option value="cancelled">{{translate('Cancel')}}</option>
			</select>
		</div>
        <div class="col-lg-2">
			<div class="form-group mb-0">
				<input type="text" class="aiz-date-range form-control" value="{{ $date }}" name="date" placeholder="{{ translate('Filter by date') }}" data-format="DD-MM-Y" data-separator=" to " data-advanced-range="true" autocomplete="off">
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group mb-0">
				<input type="text" class="form-control" id="search" name="search" @isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type Order code & hit Enter') }}">
			</div>
		</div>
        <div class="col-md-3">
            <button class="btn btn-md btn-primary" name="submit_type" type="submit" value="filter">
                {{ translate('Filter') }}
            </button>
			<button class="btn btn-md btn-primary" name="submit_type"  type="submit" value="export">
                {{ translate('Export Report') }}
            </button>
        </div>
    </div>
</form>

<div class="card-body">	
	<div class="table-responsive">
		<table class="table aiz-table mb-0 text-center">
			<thead>
				<tr>					
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
				@foreach ($commission_history as $key => $history)
				<tr>
					<td> {{ ($key+1) + ($commission_history->currentPage() - 1)*$commission_history->perPage() }}</td>
					<td>
						@if($history->order->seller)
						{{ $history->order->seller->name }}
						@endif
					</td>
					<td>
						@if(isset($history->order))
							{{ $history->order->code }}
						@else
							<span class="badge badge-inline badge-danger">
								translate('Order Deleted')
							</span>
						@endif
					</td>
					<td>{{ $history->order->created_at }}</td>
					<td>
						@if ($history->order->user != null)
						{{ $history->order->user->name }}
						@else
						Guest ({{ $history->order->guest_id }})
						@endif
					</td>
					<td>{{ $history->order->waybill }}</td>
					<td>
						 @php
							$status = $history->order->delivery_status;
							if($history->order->delivery_status == 'delivered') {
								$status = '<span class="badge badge-inline badge-success">'.translate('Delivered').'</span>';
							}
						@endphp
						{!! $status !!}
					</td>
					<td>{{ $history->order->delivered_date }}</td>
					<td>{{ $history->order->payment_type }}</td>					
					<td>{{ single_price($history->product_price) }}</td>
					<td>{{ $history->gst_on_product }}</td>
					<td>{{ single_price($history->gst_on_product_amount) }}</td>
					<td>{{ single_price($history->subtotal) }}</td>
					<td>{{ single_price($history->coupon_discount) }}</td>
					<td>{{ single_price($history->shipping + $history->shipping_with_gst) }}</td>
					<td>{{ single_price($history->invoice_amount) }}</td>
					<td>{{ single_price($history->amount_received) }}</td>
					<td>{{ $history->order->delivered_date }}</td>
					<td>{{ $history->orderDetails->quantity }}</td>
					<td>{{ $history->platform_charges }}</td>
					<td>{{ $history->platform_charges_with_gst }}</td>					
					<td>
						@if(strtoupper($history->order->seller->state) == 'DELHI')										
							<span>CGST</span><br>
							<span>SGST</span>
						@else
							<span>IGST</span>
						@endif						
					</td>
					<td>{{ $history->shipping }}</td>
					<td>{{ $history->shipping_with_gst }}</td>
					<td>
						@if(strtoupper($history->order->seller->state) == 'DELHI')										
							<span>CGST</span><br>
							<span>SGST</span>
						@else
							<span>IGST</span>
						@endif						
					</td>
					<td>{{ $history->tds }}</td>
					<td>{{ $history->tcs }}</td>
					<td>
						@if(strtoupper($history->order->seller->state) == strtoupper(json_decode($history->order->shipping_address)->state))
							<span>CGST</span><br>
							<span>SGST</span>
						@else
							<span>IGST</span>
						@endif
					</td>
					<td>{{ single_price($history->coupon_discount) }}</td>
					<td>{{ single_price($history->seller_earning) }}</td>
					<td>{{ single_price(round($history->seller_earning)) }}</td>
					<td>{{ single_price(round($history->paid_amount)) }}</td>
					<td>{{ $history->paid_date }}</td>
				</tr>
				@endforeach
			</tbody>		
		</table>
		<div class="aiz-pagination mt-4">
			{{ $commission_history->appends(request()->input())->links() }}
		</div>
	</div>
</div>