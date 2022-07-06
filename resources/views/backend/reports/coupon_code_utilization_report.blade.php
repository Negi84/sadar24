@extends('backend.layouts.app')

@section('content') 
<div class="card">
		<form action="" id="sort_orders" method="GET">
			<div class="card-header row gutters-5">
				<div class="col">
					<h5 class="mb-0 h6">{{translate('Coupon Code Utilization Report')}}</h5>
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

        <div class="card-body table-responsive">	
            <table class="table aiz-table mb-0 text-center">
                <thead>
                    <tr>
						<th data-breakpoints="lg">#</th>						
						<th data-breakpoints="lg">Customer&nbsp;Name</th>
						<th data-breakpoints="lg">Customer&nbsp;State</th>
						<th data-breakpoints="lg">Customer&nbsp;City</th>
						<th data-breakpoints="lg">Customer&nbsp;Phone</th>
						<th data-breakpoints="lg">Coupon&nbsp;Code</th>
						<th data-breakpoints="lg">Coupon&nbsp;Discount</th>
						<th data-breakpoints="lg">Discount&nbsp;Type</th>
                    </tr>
                </thead>
                
				<tbody>
					@foreach ($couponUsage as $key => $coupon_usage)
					@php
						$user_data = \App\Address::where('user_id', $coupon_usage->user_id)->first();	
						$coupon_data = \App\Coupon::where('id', $coupon_usage->coupon_id)->first();
					@endphp					
					<tr>
						<td>{{ ($key+1) + ($couponUsage->currentPage() - 1) * $couponUsage->perPage() }}</td>
						<td>{{ $coupon_usage->user->name }}</td>
						<td>{{ $user_data->state }}</td>
						<td>{{ $user_data->city }}</td>
						<td>{{ $user_data->phone }}</td>
						<td>{{ $coupon_data->code }}</td>
						<td>{{ $coupon_data->discount }}</td>
						<td>{{ $coupon_data->discount_type }}</td>
					</tr>
					@endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
               {{ $couponUsage->appends(request()->input())->links() }}
            </div>

        </div>
    </form>
</div>

@endsection