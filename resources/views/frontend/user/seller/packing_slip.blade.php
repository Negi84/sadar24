


<?php //echo "<pre>";print_r($order->orderDetails);die; ?>
	@php
		$logo = get_setting('system_logo_black');
	@endphp
	
	<div id='printMe' class='printMe'>
		<div class="a4">
				 <table class="table-container" style="width:800px;background: #fff;margin:20px auto 20px;" cellpadding="0"
					cellspacing="0">
					<tr>
					   <td>
						  <table width="100%" style="border: 1px solid #000000;" cellpadding="5" cellspacing="0">
							 <tr>
								<td width="50%"
								   style="border-right: 1px solid #000000; color: #394263; vertical-align: middle"
								   align="center">
								   <img src="{{ uploaded_asset($logo) }}"  height="60"  alt="image" style="padding:5px;">
								</td>
								<td width="50%" align="center">
								   <img style="padding:5px;" src="{{$slip['packages'][0]['delhivery_logo']}}">
								</td>
							 </tr>
						  </table>
						  <table width="100%"
							 style="border-right: 1px solid #000000; border-left: 1px solid #000000;border-bottom: 1px solid #000000; "
							 cellpadding="5" cellspacing="0">
							 <tr>
								<td width="100%">
								   <img style="margin: auto;display: block;" src="{{$slip['packages'][0]['barcode']}}">
								   <p class="" style="text-align: center;font-size:17px; margin:0;"><?//=$oid?></p>
								   
								</td>
							 </tr>
							  <tr>
								<td width="50%">
								   <p style="font-weight:bold; margin: 0">{{$slip['packages'][0]['pin']}}</p>
								   
								</td>
								<td width="50%" align="center" style="vertical-align: middle;">
								   <p style="font-size:14px; font-weight:bold; margin: 0">
										{{$slip['packages'][0]['sort_code']}}
								   </p>								  
								</td>
							 </tr>
						  </table>
						 
						  <table width="100%"
							 style="border-right: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000;"
							 cellpadding="5" cellspacing="0">
							 <tr>
								<td width="70%" style="border-right: 1px solid #000000;">
								   <p style="font-weight:bold; margin: 0">Shipping Address:</p>
								   <p style="font-weight:bold; margin: 0; font-size: 14px">
										{{$slip['packages'][0]['name']}}
								   </p>
								   <p style="margin: 0; line-height: 9pt; font-size:10px;">   
									   {{$slip['packages'][0]['address']}}
								   </p>
								   
								   <p style="margin: 0; font-size:10px;">
									  <strong>PIN: {{$slip['packages'][0]['pin']}}</strong>
								   </p>
								</td>
								<td width="30%" align="center" style="vertical-align: middle;">
								   <p style="font-size:14px; font-weight:bold; margin: 0">
										{{$slip['packages'][0]['pt']}}
								   </p>
								   <p style="font-size:14px;font-weight:bold; margin: 0">
										{{$slip['packages'][0]['cod']}}
								   </p>
								</td>
							 </tr>
						  </table>
						  <table width="100%"
							 style="border-right: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000;"
							 cellpadding="5" cellspacing="0">
							 <tr>
								<td width="60%" style="border-right: 1px solid #000000;">
								   <p style="margin: 0; line-height: 9pt; font-size:10px;"> <strong> Seller:</strong> 
										{{$slip['packages'][0]['snm']}}
								   </p>
								   <!--<p style="margin: 0; line-height: 9pt; font-size:10px;"><strong> IRN:</strong>
									  06AAPCS9575E1ZR
								   </p>-->
								   <p style="margin: 0; line-height: 9pt; font-size:10px;"><strong> Address:</strong>
										{{$slip['packages'][0]['sadd']}}
								   </p>
								</td>
								<td width="40%">
								  <p style="margin: 0; line-height: 9pt; font-size:10px;"> 
									<strong>Invoice No:</strong> {{$slip['packages'][0]['si']}}
								   </p>
								   <p style="margin: 0; line-height: 9pt; font-size:10px;"> 
									<strong>Dt:</strong> {{$slip['packages'][0]['sid']}}
								   </p>
								</td>
							 </tr>
						  </table>
						  <table width="100%"
							 style="border-right: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000;"
							 cellpadding="0" cellspacing="0">
							 <tr>
								<td width="60%" style="border-right: 1px solid #000000; padding: 0;">
								   <table width="100%" cellpadding="5" cellspacing="0">
									  <tr>
										 <td>
											<p style="margin: 0; line-height: 9pt; font-size:10px; font-weight: bold;">Product Descripition</p>
										 </td>
									  </tr>
								   </table>
								</td>
								<td width="40%"style="padding: 0;">
								   <table width="100%" cellpadding="5" cellspacing="0">
									  <tr>
										 <td width="50%" align="center" style="border-right: 1px solid #000000;">
											<p style="margin: 0; line-height: 9pt; font-size:10px;text-align: center; font-weight: bold;">Price</p>
										 </td>
										 <td width="50%" align="center">
											<p style="margin: 0; line-height: 9pt; font-size:10px; text-align: center; font-weight: bold;">Total</p>
										 </td>
									  </tr>
								   </table>
								</td>
							 </tr>
						  </table>
						  @foreach ($order->orderDetails as $key => $orderDetail)						  
								
							  <table width="100%"
								 style="border-right: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000;"
								 cellpadding="0" cellspacing="0">
								 <tr>
									<td width="60%" style="border-right: 1px solid #000000; padding: 0;">
									   <table width="100%" cellpadding="5" cellspacing="0">
											<tr>
												<td>
													@if ($orderDetail->product != null && $orderDetail->product->auction_product == 0)
														<p style="margin: 0; line-height: 9pt; font-size:10px;font-weight: bold;">{{ $orderDetail->product->getTranslation('name') }}</p>														
													@elseif ($orderDetail->product != null && $orderDetail->product->auction_product == 1)
														<p style="margin: 0; line-height: 9pt; font-size:10px;font-weight: bold;">{{ $orderDetail->product->getTranslation('name') }}</p>
													@else
														<p style="margin: 0; line-height: 9pt; font-size:10px;text-align: center; font-weight: bold;">{{ translate('Product Unavailable') }}</p>
													@endif
													<hr>
													@if(!empty($orderDetail->variation))													
													<p style="margin: 0; line-height: 9pt; font-size:10px;font-weight: bold;">Size : {{ $orderDetail->variation }}</p>
													@endif
												</td>
											</tr>
									   </table>
									</td>
									<td width="40%"style="padding: 0;">
									   <table width="100%" cellpadding="5" cellspacing="0">
										  <tr>
											 <td width="50%" align="center" style="border-right: 1px solid #000000;">
												<p style="margin: 0; line-height: 9pt; font-size:10px;text-align: center;">{{$slip['packages'][0]['rs']}}</p>
											 </td>
											 <td width="50%" align="center">
												<p style="margin: 0; line-height: 9pt; font-size:10px; text-align: center;">{{$slip['packages'][0]['rs']}}</p>
											 </td>
										  </tr>
									   </table>
									</td>
								 </tr>
							  </table>
						   @endforeach
						  <table width="100%"
							 style="border-right: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000;"
							 cellpadding="0" cellspacing="0">
							 <tr>
								<td width="60%" style="border-right: 1px solid #000000;padding: 0;">
								   <table width="100%" cellpadding="5" cellspacing="0">
									  <tr>
										 <td>
											<p style="margin: 0; line-height: 9pt; font-size:10px;">
											   <strong>Total</strong>
											</p>
										 </td>
									  </tr>
								   </table>
								</td>
								<td width="40%" style="padding: 0;">
								   <table width="100%" cellpadding="5" cellspacing="0">
									  <tr>
										 <td width="50%" align="center" style="border-right: 1px solid #000000;">
											<p style="margin: 0; line-height: 9pt; font-size:10px; font-weight: 700;">
												{{$slip['packages'][0]['rs']}}
											</p>
										 </td>
										 <td width="50%" align="center">
											<p style="margin: 0; line-height: 9pt; font-size:10px; font-weight: 700;">
												{{$slip['packages'][0]['rs']}}
											</p>
										 </td>
									  </tr>
								   </table>
								</td>
							 </tr>
						  </table>
						  <table width="100%" style="border-right: 1px solid #000000; border-left: 1px solid #000000;"
							 cellpadding="5" cellspacing="0">
							 <tr>
								<td width="100%">
								   <img style="margin: auto;display: block;" height="70" src="{{$slip['packages'][0]['oid_barcode']}}">
								   <p class="" style="text-align: center;font-size:17px; padding:0; margin:0;"><?//=$oid?></p>
								</td>
							 </tr>
						  </table>
						  <table width="100%"
							 style="border-right: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000;border-top: 1px solid #000000;"
							 cellpadding="5" cellspacing="0">
							 <tr>
								<td width="60%" align="left">
								   <p class="" style="width: 100%;margin:0;font-size: 10px;"> <strong >Return Address:</strong>
									{{$slip['packages'][0]['radd']}}, {{$slip['packages'][0]['rst']}} {{$slip['packages'][0]['rcty']}} {{$slip['packages'][0]['rpin']}}
								   </p>
								</td>
							 </tr>
						  </table>
					   </td>
					</tr>
				 </table>
			</div>
	</div>

	<div class="slip-print-btn"id="printPageButton" style="padding: 30px 0px 30px;background: #fff;text-align: center;position: sticky;top: 0;z-index: 1;">
		<button class="btn-submit"style="padding: 12px 30px;color:#fff;text-decoration:none;" onclick="window.print();">Print</button>
	</div>



@section('script')
<script type="text/javascript">
    function printDiv(divName){
      var printContents = document.getElementById(divName).innerHTML;
      var originalContents = document.body.innerHTML;
	  var printButton = document.getElementById("printpagebutton");

      document.body.innerHTML = printContents;
		 printButton.style.visibility = 'hidden';
      window.print();

      document.body.innerHTML = originalContents;

    }
  </script>


@endsection
