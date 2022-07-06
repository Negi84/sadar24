<form class="form-horizontal" action="{{ route('commissions.pay_to_seller') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal-header">
    	<h5 class="modal-title h6">{{translate('Pay to seller')}}</h5>
    	<button type="button" class="close" data-dismiss="modal"></button>
    </div>
    <div class="modal-body">
		<table class="table table-striped table-bordered" >
			<thead>
				<tr>
					<th>Order ID</th>										
					<th>Invoice Amount</th>
					<th>Delivery Status</th>
					<th>Pay Amount</th>					
				</tr>
			</thead>
			<tbody>				
				@php                           
					$total_price = 0;
				@endphp
				@foreach ($orders_pay_amount as $key => $order_pay_amount)
					<tr>
						<td>{{ $order_pay_amount->code }}</td>						
						<td>{{ single_price($order_pay_amount->invoice_amount) }}</td>
						<td>
							 @php
								$status = $order_pay_amount->delivery_status;
								if($order_pay_amount->delivery_status == 'delivered') {
									$status = '<span class="badge badge-inline badge-success">'.translate('Delivered').'</span>';
								}
							@endphp
							{!! $status !!}
						</td>
						<td>{{ single_price($order_pay_amount->seller_earning) }}</td>						
					</tr>
					<input type="hidden" name="payment_id[]" value="{{ $order_pay_amount->id }}"/>	
					@php                           
						$total_price += $order_pay_amount->seller_earning;
					@endphp	
				@endforeach
					<tr>
						<td colspan="3"><strong>Total Paid Amount</strong></td>
						<td>{{ single_price($total_price) }}</td>
					</tr>
            </tbody>
        </table>
		
		<input type="hidden" name="payment_withdraw" value="withdraw_request">
		<div class="form-group row">
			<label class="col-sm-3 col-from-label" for="payment_date">{{translate('Payment Date')}}</label>
			<div class="col-sm-9">			
				<input type="date" class="form-control" name="payment_date"/>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-3 col-from-label" for="payment_method">{{translate('Payment Method')}}</label>
			<div class="col-sm-9">
				<select name="payment_method" id="payment_method" class="form-control demo-select2-placeholder" required>
					<option value="">{{translate('Select Payment Method')}}</option>                        
					<option value="NEFT">{{translate('NEFT')}}</option>
					<option value="RTGS">{{translate('RTGS')}}</option>
					<option value="IMPS">{{translate('IMPS')}}</option>
					<option value="UPI">{{translate('UPI')}}</option>
					<option value="Cheque">{{translate('Cheque')}}</option>
					<option value="google_pay">{{translate('Google Pay')}}</option>
					<option value="paytm">{{translate('Paytm')}}</option>
					<option value="phonepay">{{translate('Phone Pay')}}</option>
				</select>
			</div>
		</div>
	</div>
    <div class="modal-footer">
		<button type="submit" class="btn btn-primary">{{translate('Pay')}}</button>
		<button type="button" class="btn btn-light" data-dismiss="modal">{{translate('Cancel')}}</button>
    </div>
</form>

<script>
$(document).ready(function(){
    $('#payment_method').on('change', function() {
      if ( this.value == 'bank_payment')
      {
        $("#txn_div").show();
      }
      else
      {
        $("#txn_div").hide();
      }
    });
    $("#txn_div").hide();
    AIZ.plugins.bootstrapSelect('refresh');
});
</script>
