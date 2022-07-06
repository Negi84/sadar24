@extends('backend.layouts.app')

@php
$sla_charge = get_setting('sla_charge',0);
$sla_charge_type = get_setting('sla_charge_type','per');

@endphp
@section('content')

	<div class="card">
	   <form action="" id="sort_orders" method="GET">
			<div class="card-header row gutters-5">
				<div class="col">
					<h5 class="mb-md-0 h6">{{ translate('Recently Viewd Items') }}</h5>
				</div>
				
				<div class="col-lg-2">
					<div class="form-group mb-0">
						<input type="text" class="aiz-date-range form-control" value="{{ $date }}" name="date" placeholder="{{ translate('Filter by date') }}" data-format="DD-MM-Y" data-separator=" to " data-advanced-range="true" autocomplete="off">
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
						<th data-breakpoints="lg">{{translate('Items')}}</th>
						<th >Session</th>
						<th >{{translate('Customer')}}</th>
                        <th >{{translate('Type')}}</th>
						<th>{{translate('IP Address')}}</th>
						
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recently as $key => $recent)
                    @php
                    $prod_name = [];
                    $products = \App\Product::whereIn('id', explode(',',$recent->products))->get();
                        foreach ($products as $k => $value) {
                            $prod_name[] = $value->getTranslation('name');
                        }

                    @endphp
                    <tr>
						<td>
                            {{ ($key+1) + ($recently->currentPage() - 1)*$recently->perPage() }}
                        </td>
                        <td>
							{!! implode('<br>',$prod_name) !!}
						</td>
						<td>{{ humanDateFormat($recent->created_at) }} to {{humanDateFormat($recent->updated_at)}}</td>                        
                        <td>
                            @if ($recent->type =='guest')
                            {{ 'Guest' }} @if($recent->user_id!=0){{'_'.$recent->user_id}} @endif
                            @else
                            {{ $recent->user->name }}
                            @endif
                        </td>
						<td>
							{{ucfirst($recent->type)}}
						</td>
                        <td>
                            {{ $recent->ip_address }}
                        </td>
                        
                        {{-- <td class="text-right">
                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('all_orders.show', encrypt($order->id))}}" title="{{ translate('View') }}">
                                <i class="las la-eye"></i>
                            </a>
                        </td> --}}
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="aiz-pagination">
                {{ $recently->appends(request()->input())->links() }}
            </div>

        </div>   
	</div>

@endsection
