@extends('frontend.layouts.user_panel')

@section('panel_content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Payment History') }}</h5>
        </div>	
        @if (count($payments) > 0)
            <div class="card-body">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
							<th>#</th>
							<th data-breakpoints="lg">{{translate('Order Id')}}</th>
							<th>{{translate('Amount')}}</th>
							<th>{{translate('Payment Mode')}}</th>
							<th>{{translate('Transaction Type')}}</th>
							<th data-breakpoints="lg">{{translate('Date')}}</th>                           
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $key => $payment)
                            <tr>
                                <td>{{ $key+1 }}</td>
								<td>{{ $payment->order_id }}</td>
								<td>{{ single_price($payment->amount) }}</td>
								<td>{{ $payment->payment_details }}</td>
								 <td>
                                    {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }} @if ($payment->txn_code != null) ({{  translate('TRX ID') }} : {{ $payment->txn_code }}) @endif
                                </td>
                                <td>{{ date('d-m-Y', strtotime($payment->created_at)) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination">
                	{{ $payments->links() }}
              	</div>
            </div>
	@else
		<div class="card-body">
			<h5 class="mb-0 h6">{{ translate('No payment history available') }}</h5>
		</div>
        @endif
    </div>

@endsection
