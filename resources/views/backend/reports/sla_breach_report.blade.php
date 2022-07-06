@extends('backend.layouts.app')

@php
$sla_charge = get_setting('sla_charge',0);
$sla_charge_type = get_setting('sla_charge_type','flat');

@endphp
@section('content')

	<div class="card">
	   <form action="" id="sort_orders" method="GET">
			<div class="card-header row gutters-5">
				<div class="col">
					<h5 class="mb-md-0 h6">{{ translate('SLA breached Orders') }}</h5>
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
						<th >#</th>
						<th >{{translate('Order Code')}}</th>
						<th >Date</th>
						<th >{{translate('Customer')}}</th>
						<th>{{translate('Seller')}}</th>
						<th >{{translate('Amount')}}</th>
                        <th >{{translate('SLA Breach Charge')}}</th>
						<th >{{translate('Delivery Status')}}</th>
						<th class="text-right" >{{translate('Options')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $key => $order)
                    <tr>
						<td>
                            {{ ($key+1) + ($orders->currentPage() - 1)*$orders->perPage() }}
                        </td>
                        <td>
							{{ $order->code }}@if($order->viewed == 0) <span class="badge badge-inline badge-info">{{translate('New')}}</span>@endif
						</td>
						<td>{{ humanDateFormat($order->created_at) }}</td>                        
                        <td>
                            @if ($order->user != null)
                            {{ $order->user->name }}
                            @else
                            Guest ({{ $order->guest_id }})
                            @endif
                        </td>
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
                                // $charge =0;
                                // if($sla_charge_type == 'per') {
                                //     $charge = ($order->grand_total*$sla_charge)/100;
                                // }
                                // else $charge = $sla_charge;

                            @endphp
                            {{ single_price($order->slaBreach->sla_amount) }}

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
						
                        <td class="text-right">
                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('all_orders.show', encrypt($order->id))}}" title="{{ translate('View') }}">
                                <i class="las la-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="aiz-pagination">
                {{ $orders->appends(request()->input())->links() }}
            </div>

        </div>   
	</div>

@endsection

