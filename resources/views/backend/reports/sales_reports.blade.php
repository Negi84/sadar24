@extends('backend.layouts.app')

@section('content') 
<div class="card">
		<form action="" id="sort_orders" method="GET">
			<div class="card-header row gutters-5">
				<div class="aiz-titlebar text-left mt-2 mb-3 col-lg-12">
					<h5 class="mb-0 h6">{{translate('Sales Report')}}</h5>
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
				<div class="col-lg-3">
					<div class="form-group mb-0">
						<input type="text" class="aiz-date-range form-control" value="{{ $date }}" name="date" placeholder="{{ translate('Filter by date') }}" data-format="DD-MM-Y" data-separator=" to " data-advanced-range="true" autocomplete="off">
					</div>
				</div>
				<div class="col-md-3">
					<button class="btn btn-md btn-primary" type="submit">
						{{ translate('Filter') }}
					</button>
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
						<th data-breakpoints="lg">Image</th>
						<th data-breakpoints="lg">Order&nbsp;Date</th>
						<th data-breakpoints="lg">Order&nbsp;ID</th>							
						<th data-breakpoints="lg">Customer&nbsp;Name</th>
						<th data-breakpoints="lg">Product&nbsp;Name</th>
						<th data-breakpoints="lg">Product&nbsp;Price</th>
						<th data-breakpoints="lg">Category</th>
						<th data-breakpoints="lg">Customer&nbsp;State</th>
						<th data-breakpoints="lg">Customer&nbsp;City</th>
						<th data-breakpoints="lg">Customer&nbsp;Phone</th>
						<th data-breakpoints="lg">Delivery&nbsp;Status</th>
						<th data-breakpoints="lg">Payment&nbsp;Status</th>
						<th data-breakpoints="lg">Payment&nbsp;Method</th>
						<th data-breakpoints="lg">Seller&nbsp;Name</th>
						<th data-breakpoints="lg">Seller&nbsp;Phone</th>
                    </tr>
                </thead>
                
				<tbody>
					@foreach ($sales as $key => $sales_details)
					@php
						$shipping_address = json_decode($sales_details->order->shipping_address);						
					@endphp
					<tr>
						<td>{{ ($key+1) + ($sales->currentPage() - 1) * $sales->perPage() }}</td>								
						<td><img src="{{ uploaded_asset($sales_details->product->thumbnail_img)}}" alt="Image" class="size-50px img-fit"></td>
						<td>{{ $sales_details->created_at }}</td>
						<td>{{ $sales_details->order->code }}</td>						
						<td>{{ $sales_details->order->user->name }}</td>
						<td>{{ $sales_details->product->getTranslation('name') }}</td>	
						<td>{{ single_price($sales_details->price) }}</td>	
						<td>{{ $sales_details->product->category->name }}</td>	
						<td>{{ $shipping_address->state }}</td>
						<td>{{ $shipping_address->city }}</td>
						<td>{{ $shipping_address->phone }}</td>
						<td>{{ $sales_details->delivery_status }}</td>
						<td>{{ $sales_details->payment_status }}</td>
						<td>{{ $sales_details->order->payment_type }}</td>
						<td>
							@if($sales_details->seller)
							{{ $sales_details->seller->name }}
							@endif
						</td>
						<td>
							@if($sales_details->seller)
							{{ $sales_details->seller->phone }}
							@endif
						</td>
					</tr>
					@endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
               {{ $sales->appends(request()->input())->links() }}
            </div>

        </div>
    </form>
</div>

@endsection