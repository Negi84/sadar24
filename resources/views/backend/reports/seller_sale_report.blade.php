@extends('backend.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 mx-auto">
        <div class="card">
            <div class="card-body">
                <form action="" id="sort_orders" method="GET">
					<div class="card-header row gutters-5">
						<div class="col">
							<h5 class="mb-0 h6">{{translate('Seller Based Selling Report')}}</h5>
						</div>
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
						<div class="col-lg-3">
							<div class="form-group mb-0">
								<input type="text" class="aiz-date-range form-control" value="{{ $date }}" name="date" placeholder="{{ translate('Filter by date') }}" data-format="DD-MM-Y" data-separator=" to " data-advanced-range="true" autocomplete="off">
							</div>
						</div>
						<div class="col-md-1">
							<button class="btn btn-md btn-primary" type="submit">
								{{ translate('Filter') }}
							</button>
						</div>
						<div class="col-auto">               
							<button class="btn btn-md btn-primary" name="submit_type"  type="submit" value="export">
							{{ translate('Export Report') }}
							</button>
						</div>
					</div>
				</form>	

                <table class="table table-bordered aiz-table mb-0">
                    <thead>
                        <tr>
							<th>#</th>
                            <th>{{ translate('Seller Name') }}</th>
                            <th data-breakpoints="lg">{{ translate('Shop Name') }}</th>
                            <th data-breakpoints="lg">{{ translate('Number of Product Sale') }}</th>
                            <th>{{ translate('Order Amount') }}</th>
							<th>{{ translate('Pending Order') }}</th>
							<th>{{ translate('Cancelled Order') }}</th>
							<th>{{ translate('Cancelled Order Amount') }}</th>
							<th>{{ translate('Delivered Order') }}</th>
							<th>{{ translate('Delivered Order Amount') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                         @foreach ($sellers as $key => $seller_details)						 
							@php
								$seller = \App\Seller::where('user_id', $seller_details->seller_id)->first();
								if ($date != null) {			
									$date_from = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
									$date_to   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));			
									
									$pending = \App\OrderDetail::where('seller_id', $seller_details->seller_id)->where('delivery_status', 'pending')->whereBetween('created_at', [$date_from." 00:00:00",$date_to." 23:59:59"])->count();
									
									$cancelled = \App\OrderDetail::where('seller_id', $seller_details->seller_id)->where('delivery_status', 'cancelled')->whereBetween('created_at', [$date_from." 00:00:00",$date_to." 23:59:59"])->count();
									
									$cancelled_amount = \App\OrderDetail::where('seller_id', $seller_details->seller_id)->where('delivery_status', 'cancelled')->whereBetween('created_at', [$date_from." 00:00:00",$date_to." 23:59:59"])->sum('price');
									
									$delivered = \App\OrderDetail::where('seller_id', $seller_details->seller_id)->where('delivery_status', 'delivered')->whereBetween('created_at', [$date_from." 00:00:00",$date_to." 23:59:59"])->count();
									
									$delivered_amount = \App\OrderDetail::where('seller_id', $seller_details->seller_id)->where('delivery_status', 'delivered')->whereBetween('created_at', [$date_from." 00:00:00",$date_to." 23:59:59"])->sum('price');
								}else{
									$pending = \App\OrderDetail::where('seller_id', $seller_details->seller_id)->where('delivery_status', 'pending')->count();
									
									$cancelled = \App\OrderDetail::where('seller_id', $seller_details->seller_id)->where('delivery_status', 'cancelled')->count();
									
									$cancelled_amount = \App\OrderDetail::where('seller_id', $seller_details->seller_id)->where('delivery_status', 'cancelled')->sum('price');
									
									$delivered = \App\OrderDetail::where('seller_id', $seller_details->seller_id)->where('delivery_status', 'delivered')->count();
									
									$delivered_amount = \App\OrderDetail::where('seller_id', $seller_details->seller_id)->where('delivery_status', 'delivered')->sum('price');
								}
								
							@endphp
							<tr>
								<td>{{ ($key+1) + ($sellers->currentPage() - 1) * $sellers->perPage() }}</td>
								@if($seller->user->shop != null)
									<td>{{ $seller->user->shop->name }}</td>
								@else
									<td>--</td>
								@endif										
								<td>{{ $seller->user->name }}</td>								
								<td>{{ $seller_details->number_of_sale }}</td> 
								<td>{{ $seller_details->total_sale }}</td>								
								<td>{{ $pending }}</td>
								<td>{{ $cancelled }}</td>
								<td>{{ $cancelled_amount }}</td>
								<td>{{ $delivered }}</td>
								<td>{{ $delivered_amount }}</td>
							</tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination mt-4">
                    {{ $sellers->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
