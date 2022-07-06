@extends('frontend.layouts.user_panel')

@section('panel_content')

@php	
    $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();		
@endphp
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Purchase History') }}</h5>
        </div>
        @if (count($orders) > 0)
			
            <div class="card-body">
				@foreach ($orders as $key => $order)	
					@php							
						$p_id = "";
					@endphp
					@foreach ($order->orderDetails as $key => $orderDetail)						
						@php
							$product_id = $order->orderDetails->first()->product_id;
							$thumbnail_img = \App\Product::where('id', $product_id)->first()->thumbnail_img;
						@endphp
						<form id="option-choice-form-{{ $orderDetail->product->id }}">
							@csrf
							<input type="hidden" name="id" value="{{ $orderDetail->product->id }}">
							<input type="hidden" name="quantity" class="col border-0 text-center flex-grow-1 fs-16 input-number" value="{{ $orderDetail->quantity }}" >
						</form>
						@php
							$p_id = $p_id.",".$orderDetail->product->id;
						@endphp
						
						<div class="box-layout">
							<div class="row ">								
								<div class="col-md-5">
									<div class="product_details">
										<img src="{{ uploaded_asset($thumbnail_img)}}" alt="Image" class="img-fit">
									
										@if ($orderDetail->product != null && $orderDetail->product->auction_product == 0)
											<a href="{{ route('product', $orderDetail->product->slug) }}"
												target="_blank">{{ $orderDetail->product->getTranslation('name') }}</a>
										@elseif($orderDetail->product != null && $orderDetail->product->auction_product == 1)
											<a href="{{ route('auction-product', $orderDetail->product->slug) }}"
												target="_blank">{{ $orderDetail->product->getTranslation('name') }}</a>
										@else
											<strong>{{ translate('Product Unavailable') }}</strong>
										@endif
									</div>
								</div>
								<div class="col-md-2">
									{{ single_price($orderDetail->price) }}
								</div>
								<div class="col-md-5">									
									@if($order->delivery_status == 'cancelled')										
										<span class="icons-design cancelled-icon"> </span> {{ translate(ucfirst(str_replace('_', ' ', $order->delivery_status))) }} on  {{ $orderDetail->updated_at}}
									@elseif($order->delivery_status == 'delivered')
										<span class="icons-design delivered-icon"> </span> {{ translate(ucfirst(str_replace('_', ' ', $order->delivery_status))) }} on  {{ $orderDetail->updated_at}}
									@else 
										<span class="icons-design pending-icon"> </span> {{ translate(ucfirst(str_replace('_', ' ', $order->delivery_status))) }} on  {{ $orderDetail->updated_at}}
									@endif
									<div class="clearfix mb-10"></div>
									
									<a href="{{ route('purchase_history.order_details', encrypt($order->id)) }}" target="_blank" class="btn btn-soft-success btn-small" title="{{ translate('Order Details') }}">View Details</a>
									
									@if ($order->orderDetails->first()->delivery_status == 'cancelled' || $order->orderDetails->first()->delivery_status == 'delivered')
										<a href="javascript:;" class="btn btn-soft-secondary btn-small" onclick="rebuyNow('{{ ltrim($p_id,',') }}')" title="{{ translate('Order Details') }}">Re-Order</a>
									@endif
									
									@if ($order->orderDetails->first()->delivery_status == 'pending')
										<a href="javascript:void(0)" class="btn btn-soft-danger btn-small confirm-cancel" data-href="{{route('orders.cancel', $order->id)}}" title="{{ translate('Cancel') }}">Cancel</a>
									@endif
									
									@if ($order->waybill != null)																					
										<a class="btn btn-soft-info btn-small" target="_blank" href="https://www.delhivery.com/track/package/{{$order->waybill}}" title="{{ translate('Track Order') }}">Track Order</a>					
									@endif
									
								</div>
							</div>	
						</div>
					@endforeach
                @endforeach		
                  
                <div class="aiz-pagination">
					{{ $orders->links() }}
              	</div>
            </div>
        @endif
    </div>
@endsection

@section('modal')
    @include('modals.cancel_modal')

    <div class="modal" id="order_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div id="order-details-modal-body">

                </div>
            </div>
        </div>
    </div>


    <div class="modal" id="payment_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div id="payment_modal_body">

                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $('#order_details').on('hidden.bs.modal', function () {
            location.reload();
        })
		function rebuyNow(stringid){
			//alert(stringid);
			var ids = stringid.split(',');
			
            if(checkAddToCartValidity()) {
                $('#addToCart-modal-body').html(null);
                $('#addToCart').modal("show");
                $('.c-preloader').show();
				console.log(ids);
			console.log(ids.length);

				for (let i = 0; i < ids.length; i++) {
				  console.log($('#option-choice-form-'+ids[i]).serializeArray());
				  $.ajax({
					   type:"POST",
					   url: '{{route("cart.addToCart")}}',
					   data: $('#option-choice-form-'+ids[i]).serializeArray(),
					   success: function(data){
						   if(data.status == 1){

								$('#addToCart-modal-body').html(data.modal_view);
								updateNavCart(data.nav_cart_view,data.cart_count);
								if(i == ids.length-1){
									window.location.replace("{{route('cart')}}");
								}
						   }
						   else{
								$('#addToCart-modal-body').html(null);
								$('.c-preloader').hide();
								$('#modal-size').removeClass('modal-lg');
								$('#addToCart-modal-body').html(data.modal_view);
						   }
					   }
				   });
				}
                $.ajax({
                   type:"POST",
                   url: '{{route("cart.addToCart")}}',
                   data: $('#option-choice-form').serializeArray(),
                   success: function(data){
                       if(data.status == 1){

                            $('#addToCart-modal-body').html(data.modal_view);
                            updateNavCart(data.nav_cart_view,data.cart_count);

                            window.location.replace("https://sadar24.com/cart");
                       }
                       else{
                            $('#addToCart-modal-body').html(null);
                            $('.c-preloader').hide();
                            $('#modal-size').removeClass('modal-lg');
                            $('#addToCart-modal-body').html(data.modal_view);
                       }
                   }
               });
            }
            else{
                AIZ.plugins.notify('warning', "Please choose all the options");
            }
        }

    </script>

@endsection
