@extends('backend.layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12 mx-auto">
        <div class="card">
			<form action="" id="sort_orders" method="GET">
				<div class="card-header row gutters-5">
					<div class="col">
						<h5 class="mb-0 h6">{{translate('Best Selling Product Report')}}</h5>
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
			
			<div class="card-body p-3">
				<table class="table aiz-table mb-0 table-resposnive">
					<thead>
						<tr>
							<th>#</th>
							<th>{{ translate('Image')}}</th>
							<th data-breakpoints="md">{{ translate('Name')}}</th>
							<th>{{ translate('Shop Name') }}</th>	
							<th>{{ translate('Seller Name') }}</th>                            						
							<th data-breakpoints="md">{{ translate('Quantity')}}</th>
						</tr>
					</thead>
					<tbody>
												
						 @foreach ($best_selling_items as $key => $product_orderDetail)						 
							@php								
								$product = \App\Product::findOrFail($product_orderDetail->product_id);
								$seller = \App\Seller::where('user_id', $product_orderDetail->seller_id)->first();
							@endphp
							<tr>
								<td>{{ ($key+1) + ($best_selling_items->currentPage() - 1) * $best_selling_items->perPage() }}</td>
								<td><img src="{{ uploaded_asset($product->thumbnail_img)}}" alt="Image" class="size-50px img-fit"></td>
								<td>{{ $product->getTranslation('name') }}</td>
								@if($seller->user->shop != null)
									<td>{{ $seller->user->shop->name }}</td>
								@else
									<td>--</td>
								@endif										
								<td>{{ $seller->user->name }}</td>								
								<td>{{ $product_orderDetail->number_of_sale }}</td> 
							</tr>
                            @endforeach
					</tbody>
				</table>				
				<div class="aiz-pagination">			
					{{ $best_selling_items->appends(request()->input())->links() }}
				</div>			
			</div>					
		</div>
    </div>
</div>

@endsection
