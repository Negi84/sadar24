@extends('backend.layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12 mx-auto">
        <div class="card">
			 <form class="" action="" id="sort_orders" method="GET">
				<div class="card-header row gutters-5">
					<div class="col">
						<h5 class="mb-0 h6">{{translate('Customers Registration Report')}}</h5>
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
                <table class="table table-bordered aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ translate('Name') }}</th>
							<th>{{ translate('Email') }}</th>
							<th>{{ translate('Phone') }}</th>
							<th>{{ translate('Address') }}</th>
							<th>{{ translate('City') }}</th>
							<th>{{ translate('State') }}</th>
							<th>{{ translate('Registration Date') }}</th>
							<th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $key => $customer)
                        @if ($customer->user != null)
							@php															
								$user_phone = "";
								$user_add = "";
								$user_city = "";
								$user_state = "";
								
								$user_details = App\Address::where('user_id', $customer->user->id)->first();								
								if($user_details){
									$user_phone = $user_details->phone;
									$user_add = $user_details->address;
									$user_city = $user_details->city;
									$user_state = $user_details->state;	
								}									
							@endphp	
                            <tr>
                                <td>{{ ($key+1) + ($customers->currentPage() - 1)*$customers->perPage() }}</td>                                
                                <td>@if($customer->user->banned == 1) <i class="fa fa-ban text-danger" aria-hidden="true"></i> @endif {{$customer->user->name}}</td>
								<td>{{$customer->user->email}}</td>
                                <td>{{ $customer->user->phone ? $customer->user->phone : $user_phone }}</td>
								<td>{{ $customer->user->address ? $customer->user->address : $user_add }}</td>
								<td>{{ $customer->user->city ? $customer->user->city : $user_city }}</td>
								<td>{{ $customer->user->state ? $customer->user->state : $user_state }}</td>
								<td>{{ $customer->user->created_at }}</td>
								<td>
									<a class="btn btn-soft-primary btn-sm" target="_blank" href="{{ route('customers.purchase_history', $customer->user->id) }}">Purchase history</a>
								</td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination mt-4">
                    {{ $customers->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
