@extends('backend.layouts.app')

@section('content')

<?php //echo "<pre>";print_r($sellers); die; ?>
<div class="row">
    <div class="col-md-12 mx-auto">
        <div class="card">
			<form action="" id="sort_orders" method="GET">
				<div class="card-header row gutters-5">
					<div class="col">
						<h5 class="mb-0 h6">{{translate('Seller Registration Report')}}</h5>
					</div>					
					<div class="col-md-3">
						<div class="form-group mb-0">
							<input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type email or name & Enter') }}">
						</div>
					</div>
					<div class="col-md-3">
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
            <div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered aiz-table mb-0">
						<thead>
							<tr>
								<th>#</th>
								<th>{{ translate('Seller ID') }}</th>
								<th>{{ translate('Company') }}</th>
								<th>{{ translate('Name') }}</th>
								<th>{{ translate('Email') }}</th>
								<th>{{ translate('Phone') }}</th>
								<th>{{ translate('Address') }}</th>
								<th>{{ translate('City') }}</th>
								<th>{{ translate('State') }}</th>
								<th>{{ translate('Pincode') }}</th>
								<th>{{ translate('GST Number') }}</th>
								<th>{{ translate('PAN Number') }}</th>
								<th>{{ translate('Beneficiary Name') }}</th>
								<th>{{ translate('Bank Name') }}</th>
								<th>{{ translate('Account Number') }}</th>
								<th>{{ translate('Account Type') }}</th>
								<th>{{ translate('IFSC') }}</th>
								<th>{{ translate('Branch') }}</th>								
								<th>{{ translate('Total Products') }}</th>
								<th>{{ translate('Published') }}</th>
								<th>{{ translate('Unpublished') }}</th>
								<th>{{ translate('Registration Date') }}</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($sellers as $key => $seller)

								@if($seller->user != null)
									<tr>
										<td>{{ ($key+1) + ($sellers->currentPage() - 1)*$sellers->perPage() }}</td>
										
										
										<td>{{ $seller->user->id }}</td>
										
										@if($seller->user->shop != null)
											<td>{{ $seller->user->shop->name }}</td>
										@else
											<td>--</td>
										@endif
										
										<td>{{ $seller->user->name }}</td>
										<td>{{ $seller->user->email }}</td>
										
										@if($seller->user->shop != null)
											<td>{{ $seller->user->shop->phone }}</td>
										@else
											<td>--</td>
										@endif
										
										@if($seller->user->shop != null)
											<td>{{ $seller->user->shop->address }}</td>
										@else
											<td>--</td>
										@endif
										
										@if($seller->user->shop != null)
											<td>{{ $seller->user->shop->city }}</td>
										@else
											<td>--</td>
										@endif
										
										@if($seller->user->shop != null)
											<td>{{ $seller->user->shop->state }}</td>
										@else
											<td>--</td>
										@endif
										
										@if($seller->user->shop != null)
											<td>{{ $seller->user->shop->postal_code }}</td>
										@else
											<td>--</td>
										@endif	
										
										@if($seller->user->shop != null)
											<td>{{ $seller->user->shop->gst_number }}</td>
										@else
											<td>--</td>
										@endif
										
										@if($seller->user->shop != null)
											<td>{{ $seller->user->shop->pan_number }}</td>
										@else
											<td>--</td>
										@endif	
										
										@if($seller->user->seller != null)
											<td>{{ $seller->user->seller->bank_acc_name }}</td>
										@else
											<td>--</td>
										@endif
										
										@if($seller->user->seller != null)
											<td>{{ $seller->user->seller->bank_name }}</td>
										@else
											<td>--</td>
										@endif
										
										@if($seller->user->seller != null)
											<td>{{ $seller->user->seller->bank_acc_no }}</td>
										@else
											<td>--</td>
										@endif
										
										@if($seller->user->seller != null)
											<td>{{ $seller->user->seller->account_type }}</td>
										@else
											<td>--</td>
										@endif
										
										@if($seller->user->seller != null)
											<td>{{ $seller->user->seller->ifsc_code }}</td>
										@else
											<td>--</td>
										@endif
										
										@if($seller->user->seller != null)
											<td>{{ $seller->user->seller->branch }}</td>
										@else
											<td>--</td>
										@endif
										
										<td>{{ \App\Product::where('user_id', $seller->user->id)->count() }}</td>
										
										<td>{{ \App\Product::where('user_id', $seller->user->id)->where('published', '=', '1')->count() }}</td>

										<td>{{ \App\Product::where('user_id', $seller->user->id)->where('published', '=', '0')->count() }}</td>
										
										@if($seller->user->seller != null)
											<td>{{ $seller->user->seller->created_at }}</td>
										@else
											<td>--</td>
										@endif
										
									</tr>
								@endif
							@endforeach
						</tbody>
					</table>
				</div>
				
				<div class="aiz-pagination mt-4">
					{{ $sellers->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
