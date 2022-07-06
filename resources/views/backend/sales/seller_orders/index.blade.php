@extends('backend.layouts.app')

@section('content')
@php
$refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();
@endphp

<div class="card">
    <form class="" action="" method="GET">
        <div class="card-header row gutters-5">
            <div class="col text-center text-md-left">
                <h5 class="mb-md-0 h6">{{ translate('Seller Orders') }}</h5>
            </div>
            <div class="col-lg-2">
                <div class="form-group mb-0">
                    <input type="text" class="aiz-date-range form-control" value="{{ $date }}" name="date" placeholder="{{ translate('Filter by date') }}" data-format="DD-MM-Y" data-separator=" to " data-advanced-range="true" autocomplete="off">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group mb-0">
                    <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" id="seller_id" data-live-search="true" name="seller_id">
                        <option value="">{{ translate('All Sellers') }}</option>
                        @foreach (App\Seller::all() as $key => $seller)
                        @if ($seller->user != null && $seller->user->shop != null)
                        <option value="{{ $seller->user->id }}" @if ($seller->user->id == $seller_id) selected @endif>
                            {{ $seller->user->shop->name }} ({{ $seller->user->name }})
                        </option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group mb-0">
                    <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type Order code & hit Enter') }}">
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary">{{ translate('Filter') }}</button>
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
                    <th data-breakpoints="lg">{{translate('Customer')}}</th>
                    <th>{{translate('Seller')}}</th>
                    <th data-breakpoints="lg">{{translate('Amount')}}</th>
                    <th data-breakpoints="lg">{{translate('Delivery Status')}}</th>
                    <th data-breakpoints="lg">{{translate('Payment Method')}}</th>
                    <th data-breakpoints="lg">{{translate('Payment Status')}}</th>
                    <th data-breakpoints="lg">Waybill</th>
                    @if ($refund_request_addon != null && $refund_request_addon->activated == 1)
                    <th>{{translate('Refund')}}</th>
                    @endif
                    
                    <th class="text-right" width="15%">{{translate('Options')}}</th>
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
                    <td>{{ $order->created_at }}</td>
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
                        $status = $order->delivery_status;
                        @endphp
                        {{ translate(ucfirst(str_replace('_', ' ', $status))) }}
                    </td>
                    <td>
                        {{ translate(ucfirst(str_replace('_', ' ', $order->payment_type))) }}
                    </td>
                    <td>
                        @if ($order->payment_status == 'paid')
                        <span class="badge badge-inline badge-success">{{translate('Paid')}}</span>
                        @else
                        <span class="badge badge-inline badge-danger">{{translate('Unpaid')}}</span>
                        @endif
                    </td>
                    <th data-breakpoints="lg">{{ $order->waybill }}</th>
                    @if ($refund_request_addon != null && $refund_request_addon->activated == 1)
                    <td>
                        @if (count($order->refund_requests) > 0)
                        {{ count($order->refund_requests) }} {{ translate('Refund') }}
                        @else
                        {{ translate('No Refund') }}
                        @endif
                    </td>
                    @endif

                    <td class="text-right">
                        @if ($order->waybill != null)												
						<a class="btn btn-soft-info btn-icon btn-circle btn-sm" target="_blank" href="https://www.delhivery.com/track/package/{{$order->waybill}}" title="{{ translate('Track Order') }}">
						   <i class="las la-truck"></i>
						</a>					
						@endif
						@if($order->waybill == null && $order->orderDetails->first()->delivery_status == 'pending')
							<a class="btn btn-soft-danger btn-icon btn-circle btn-sm" href="{{route('seller_orders.ready_to_ship', encrypt($order->id))}}" title="{{ translate('ReadyToShip') }}"><i class="las la-car"></i></a>						
						@endif  
						
						@if ($order->waybill != null && $order->orderDetails->first()->delivery_status != 'deliverd')
							<a class="btn btn-soft-info btn-icon btn-circle btn-sm" href="{{route('seller_orders.packing_slip', encrypt($order->id))}}" title="{{ translate('Packing Slip') }}" target="_blank"><i class="las la-file-alt"></i></a>	
						@endif	
                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('seller_orders.show', encrypt($order->id))}}" title="{{ translate('View') }}">
                            <i class="las la-eye"></i>
                        </a>
                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{ route('invoice.download', $order->id) }}" title="{{ translate('Download Invoice') }}">
                            <i class="las la-download"></i>
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

@section('modal')
@include('modals.delete_modal')
@endsection

@section('script')
<script type="text/javascript">
    function sort_orders(el){
        $('#sort_orders').submit();
    }
</script>
@endsection
