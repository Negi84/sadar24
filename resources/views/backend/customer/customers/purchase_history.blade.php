@extends('backend.layouts.app')

@section('content')
	<div class="card">
		 <form action="" id="sort_orders" method="GET">
			<div class="card-header row gutters-5">
				<div class="col">
					<h5 class="mb-md-0 h6">{{ translate('Purchase History') }}</h5>
				</div>
				<div class="col-lg-2 ml-auto">
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
						<input type="text" class="aiz-date-range form-control" value="{{ $date }}" name="date" placeholder="{{ translate('Filter by date') }}" data-format="DD-MM-Y" data-separator=" to " data-advanced-range="true" autocomplete="off">
					</div>
				</div>
				<div class="col-lg-2">
					<div class="form-group mb-0">
						<input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type Order code & hit Enter') }}">
					</div>
				</div>
				<div class="col-auto">
					<div class="form-group mb-0">
						<button type="submit" class="btn btn-primary">{{ translate('Filter') }}</button>
					</div>
				</div>
				<div class="col-auto">
					<div class="form-group mb-0">
						<button name="submit_type" type="submit" value="export" class="btn btn-primary">{{ translate('Export Report') }}</button>
					</div>
				</div>
			</div>
		</form>
			
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
						<th data-breakpoints="lg">#</th>
						<th data-breakpoints="lg">{{translate('Order Code')}}</th>
						<th data-breakpoints="lg">Date</th>
						<th data-breakpoints="lg">{{translate('Seller')}}</th>
						<th data-breakpoints="lg">{{translate('Amount')}}</th>
						<th data-breakpoints="lg">{{translate('Delivery Status')}}</th>
						<th data-breakpoints="lg">{{translate('Payment Method')}}</th>
						<th data-breakpoints="lg">{{translate('Payment Status')}}</th>
						<th data-breakpoints="lg">Waybill</th>
						<th>{{translate('Device Type')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchase_history as $key => $order)
                    <tr>
						<td>{{ ($key+1) + ($purchase_history->currentPage() - 1)*$purchase_history->perPage() }}</td>
                        <td>{{ $order->code }}@if($order->viewed == 0) <span class="badge badge-inline badge-info">{{translate('New')}}</span>@endif</td>
						<td>{{ $order->created_at }}</td> 
						<td>
							@if($order->seller)
							{{ $order->seller->name }}
							@endif
						</td>
                        <td>
                            {{ single_price($order->grand_total) }}
                        </td>
                        <td>
                            @php
                                $status = $order->delivery_status;
                                if($order->delivery_status == 'cancelled') {
                                    $status = '<span class="badge badge-inline badge-danger">'.translate('Cancel').'</span>';
                                }

                            @endphp
                            {!! $status !!}
                        </td>
						<td>{{ translate(ucfirst(str_replace('_', ' ', $order->payment_type))) }}</td>
                        <td>
                            @if ($order->payment_status == 'paid')
                            <span class="badge badge-inline badge-success">{{translate('Paid')}}</span>
                            @elseif ($order->payment_status == 'failed')
                            <span class="badge badge-inline badge-danger">{{translate('Failed')}}</span>
							@else
								<span class="badge badge-inline badge-danger">{{translate('Unpaid')}}</span>
                            @endif
                        </td>
						<th data-breakpoints="lg">{{ $order->waybill }}</th>                       
						<td data-breakpoints="lg">{{ $order->device_type }}</td>                       
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="aiz-pagination">
                {{ $purchase_history->appends(request()->input())->links() }}
            </div>
        </div>   
	</div>
@endsection
