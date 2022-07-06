@extends('frontend.layouts.app')

@section('content')

<?php header('Access-Control-Allow-Origin: https://track.delhivery.com/c/api/pin-codes/json/') ?>
<section class="pt-5 mb-4">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 mx-auto">
                <div class="row aiz-steps arrow-divider">
                    <div class="col done">
                        <div class="text-center text-success">
                            <i class="la-3x mb-2 las la-shopping-cart"></i>
                            <h3 class="fs-14 fw-600 d-none d-lg-block ">{{ translate('1. My Cart')}}</h3>
                        </div>
                    </div>
                    <div class="col active">
                        <div class="text-center text-primary">
                            <i class="la-3x mb-2 las la-map"></i>
                            <h3 class="fs-14 fw-600 d-none d-lg-block ">{{ translate('2. Shipping info')}}</h3>
                        </div>
                    </div>
                    <div class="col">
                        <div class="text-center">
                            <i class="la-3x mb-2 opacity-50 las la-truck"></i>
                            <h3 class="fs-14 fw-600 d-none d-lg-block opacity-50 ">{{ translate('3. Delivery info')}}</h3>
                        </div>
                    </div>
                    <div class="col">
                        <div class="text-center">
                            <i class="la-3x mb-2 opacity-50 las la-credit-card"></i>
                            <h3 class="fs-14 fw-600 d-none d-lg-block opacity-50 ">{{ translate('4. Payment')}}</h3>
                        </div>
                    </div>
                    <div class="col">
                        <div class="text-center">
                            <i class="la-3x mb-2 opacity-50 las la-check-circle"></i>
                            <h3 class="fs-14 fw-600 d-none d-lg-block opacity-50 ">{{ translate('5. Confirmation')}}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mb-4 gry-bg">
    <div class="container">
        <div class="row cols-xs-space cols-sm-space cols-md-space">
            <div class="col-xxl-8 col-xl-10 mx-auto">
                <form class="form-default" data-toggle="validator" action="{{ route('checkout.store_shipping_infostore') }}" role="form" method="POST">
                    @csrf
                        @if(Auth::check())
                        <div class="shadow-sm bg-white p-4 rounded mb-4">
                            <div class="row gutters-5">
                                @foreach (Auth::user()->addresses as $key => $address)
									@php
										$pincode = $address->postal_code;
										$url = "https://track.delhivery.com/c/api/pin-codes/json/?filter_codes=".$pincode;

										$curl = curl_init($url);
										curl_setopt($curl, CURLOPT_URL, $url);
										curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

										$headers = array(
										   "Authorization: Bearer 13e6e16ea6506989bb0d3fbaef437402278bffeb",
										);
										curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
										//for debug only!
										curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
										curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
										$disable = "";
										$bg_color = "";
										$resp = curl_exec($curl);
										curl_close($curl);
										$resp1 = json_decode($resp, true);
										
										//print_r($delivery_codes);
										//$status =  $resp1['Status'];
										//var_dump($resp);
									@endphp
									@if (empty($resp1['delivery_codes']) || !isset($resp1['delivery_codes']))
										@php
										flash(translate('No such pincode avialable!!! Pincode:- '.$pincode))->warning();
										$disable = "disabled";
										$bg_color = "bg-light";
										@endphp
										<script>
										document.getElementById("add_div_{{ $pincode }}").disabled = true;
										</script>
									@else
										@php
											$delivery_codes = $resp1['delivery_codes'];
											$postal_codes = $delivery_codes[0]['postal_code'];
											$repl = $postal_codes['repl'];
										@endphp
										@if ($repl == 'Y')
											@php
											flash(translate('Delivery available on current Pincode:- '.$pincode))->success();
											@endphp
										@else
											@php
											flash(translate('Delivery not available on current Pincode:- '.$pincode))->warning();
											$disable = "disabled";
											$bg_color = "bg-light";
											@endphp
											<script>
											document.getElementById("add_div_{{ $pincode }}").disabled = true;
											</script>
										@endif
										
									@endif
                                    <div class="col-md-6 mb-3" id="add_div_{{ $pincode }}">
										<fieldset {{ $disable }}>
                                        <label class="aiz-megabox d-block bg-white {{ $bg_color }} mb-0">
                                            <input type="radio" name="address_id" value="{{ $address->id }}" @if ($address->set_default)
                                                checked
                                            @endif required>
                                            <span class="d-flex p-3 aiz-megabox-elem">
                                                <span class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                                <span class="flex-grow-1 pl-3 text-left">
                                                    <div>
                                                        <span class="opacity-60">{{ translate('Address') }}:</span>
                                                        <span class="fw-600 ml-2">{{ $address->address }}</span>
                                                    </div>
													<div>
														<span class="opacity-60">{{ translate('Country') }}:</span>
                                                        <span class="fw-600 ml-2">{{ $address->country }}</span>
                                                    </div>
													<div>
                                                        <span class="opacity-60">{{ translate('State') }}:</span>
                                                        <span class="fw-600 ml-2">{{ $address->state }}</span>
                                                    </div>
													<div>
                                                        <span class="opacity-60">{{ translate('City') }}:</span>
                                                        <span class="fw-600 ml-2">{{ $address->city }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="opacity-60">{{ translate('Pincode') }}:</span>
                                                        <span class="fw-600 ml-2">{{ $address->postal_code }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="opacity-60">{{ translate('Phone') }}:</span>
                                                        <span class="fw-600 ml-2">{{ $address->phone }}</span>
                                                    </div>
                                                </span>
                                            </span>
                                        </label>
                                        <div class="dropdown position-absolute right-0 top-0">
                                            <button class="btn bg-gray px-2" type="button" data-toggle="dropdown">
                                                <i class="la la-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" onclick="edit_address('{{$address->id}}')">
                                                    {{ translate('Edit') }}
                                                </a>
                                            </div>
                                        </div>
										</fieldset>
                                    </div>
                                @endforeach
                                <input type="hidden" name="checkout_type" value="logged">
                                <div class="col-md-6 mx-auto mb-3" >
                                    <div class="border p-3 rounded mb-3 c-pointer text-center bg-white h-100 d-flex flex-column justify-content-center" onclick="add_new_address()">
                                        <i class="las la-plus la-2x mb-3"></i>
                                        <div class="alpha-7">{{ translate('Add New Address') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                            <div class="shadow-sm bg-white p-4 rounded mb-4">
                                <div class="form-group">
                                    <label class="control-label">{{ translate('Name')}}</label>
                                    <input type="text" class="form-control" name="name" placeholder="{{ translate('Name')}}" required>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">{{ translate('Email')}}</label>
                                    <input type="text" class="form-control" name="email" placeholder="{{ translate('Email')}}" required>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">{{ translate('Address')}}</label>
                                    <input type="text" class="form-control" name="address" placeholder="{{ translate('Address')}}" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">{{ translate('Select your country')}}</label>
                                            <select class="form-control aiz-selectpicker" data-live-search="true" name="country">
												<option value="India">India</option>
                                                @foreach (\App\Country::where('status', 1)->get() as $key => $country)
                                                    <option value="{{ $country->name }}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
									<div class="col-md-6">
                                        <div class="form-group has-feedback">
                                            <label class="control-label">{{ translate('State')}}</label>
											<select name="state" id="state" class="form-control mb-3 aiz-selectpicker" data-live-search="true" required>
												<option value="Andhra Pradesh">Andhra Pradesh</option>
												<option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
												<option value="Arunachal Pradesh">Arunachal Pradesh</option>
												<option value="Assam">Assam</option>
												<option value="Bihar">Bihar</option>
												<option value="Chandigarh">Chandigarh</option>
												<option value="Chhattisgarh">Chhattisgarh</option>
												<option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
												<option value="Daman and Diu">Daman and Diu</option>
												<option value="Delhi">Delhi</option>
												<option value="Lakshadweep">Lakshadweep</option>
												<option value="Puducherry">Puducherry</option>
												<option value="Goa">Goa</option>
												<option value="Gujarat">Gujarat</option>
												<option value="Haryana">Haryana</option>
												<option value="Himachal Pradesh">Himachal Pradesh</option>
												<option value="Jammu and Kashmir">Jammu and Kashmir</option>
												<option value="Jharkhand">Jharkhand</option>
												<option value="Karnataka">Karnataka</option>
												<option value="Kerala">Kerala</option>
												<option value="Madhya Pradesh">Madhya Pradesh</option>
												<option value="Maharashtra">Maharashtra</option>
												<option value="Manipur">Manipur</option>
												<option value="Meghalaya">Meghalaya</option>
												<option value="Mizoram">Mizoram</option>
												<option value="Nagaland">Nagaland</option>
												<option value="Odisha">Odisha</option>
												<option value="Punjab">Punjab</option>
												<option value="Rajasthan">Rajasthan</option>
												<option value="Sikkim">Sikkim</option>
												<option value="Tamil Nadu">Tamil Nadu</option>
												<option value="Telangana">Telangana</option>
												<option value="Tripura">Tripura</option>
												<option value="Uttar Pradesh">Uttar Pradesh</option>
												<option value="Uttarakhand">Uttarakhand</option>
												<option value="West Bengal">West Bengal</option>
											</select>
											
                                        </div>
                                    </div>									
                                </div>

                                <div class="row">
									<div class="col-md-6">
                                        <div class="form-group has-feedback">
                                            <label class="control-label">{{ translate('City')}}</label>
											<input class="form-control mb-3" placeholder="{{ translate('City')}}" name="city" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group has-feedback">
                                            <label class="control-label">{{ translate('Pincode')}}</label>
                                            <input type="text" class="form-control" placeholder="{{ translate('Pincode')}}" name="postal_code" required>
                                        </div>
                                    </div>                                    
                                </div>
								<div class="row">									
                                    <div class="col-md-6">
                                        <div class="form-group has-feedback">
                                            <label class="control-label">{{ translate('Phone')}}</label>
                                            <input type="number" lang="en" min="0" class="form-control" placeholder="{{ translate('Phone')}}" name="phone" required>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="checkout_type" value="guest">
                            </div>
                        @endif
                    <div class="row align-items-center">
                        <div class="col-md-6 text-center text-md-left order-1 order-md-0">
                            <a href="{{ route('home') }}" class="btn btn-link">
                                <i class="las la-arrow-left"></i>
                                {{ translate('Return to shop')}}
                            </a>
                        </div>
                        <div class="col-md-6 text-center text-md-right">
                            <button type="submit" id="continue_di" class="btn btn-primary fw-600">{{ translate('Continue to Delivery Info')}}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('modal')
<div class="modal" id="new-address-modal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-zoom" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">{{ translate('New Address')}}</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-default" role="form" action="{{ route('addresses.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="p-3">
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{ translate('Address')}}</label>
                            </div>
                            <div class="col-md-10">
                                <textarea class="form-control textarea-autogrow mb-3" placeholder="{{ translate('Your Address')}}" rows="1" name="address" required></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{ translate('Country')}}</label>
                            </div>
                            <div class="col-md-10">
                                <select class="form-control mb-3 aiz-selectpicker" data-live-search="true" name="country" required>
                                    <option value="India">India</option>
                                    @foreach (\App\Country::where('status', 1)->get() as $key => $country)
                                        <option value="{{ $country->name }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
						<div class="row">
                            <div class="col-md-2">
                                <label>{{ translate('State')}}</label>
                            </div>
                            <div class="col-md-10">                               
								<select name="state" id="state" class="form-control mb-3 aiz-selectpicker" data-live-search="true" required>
									<option value="Andhra Pradesh">Andhra Pradesh</option>
									<option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
									<option value="Arunachal Pradesh">Arunachal Pradesh</option>
									<option value="Assam">Assam</option>
									<option value="Bihar">Bihar</option>
									<option value="Chandigarh">Chandigarh</option>
									<option value="Chhattisgarh">Chhattisgarh</option>
									<option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
									<option value="Daman and Diu">Daman and Diu</option>
									<option value="Delhi">Delhi</option>
									<option value="Lakshadweep">Lakshadweep</option>
									<option value="Puducherry">Puducherry</option>
									<option value="Goa">Goa</option>
									<option value="Gujarat">Gujarat</option>
									<option value="Haryana">Haryana</option>
									<option value="Himachal Pradesh">Himachal Pradesh</option>
									<option value="Jammu and Kashmir">Jammu and Kashmir</option>
									<option value="Jharkhand">Jharkhand</option>
									<option value="Karnataka">Karnataka</option>
									<option value="Kerala">Kerala</option>
									<option value="Madhya Pradesh">Madhya Pradesh</option>
									<option value="Maharashtra">Maharashtra</option>
									<option value="Manipur">Manipur</option>
									<option value="Meghalaya">Meghalaya</option>
									<option value="Mizoram">Mizoram</option>
									<option value="Nagaland">Nagaland</option>
									<option value="Odisha">Odisha</option>
									<option value="Punjab">Punjab</option>
									<option value="Rajasthan">Rajasthan</option>
									<option value="Sikkim">Sikkim</option>
									<option value="Tamil Nadu">Tamil Nadu</option>
									<option value="Telangana">Telangana</option>
									<option value="Tripura">Tripura</option>
									<option value="Uttar Pradesh">Uttar Pradesh</option>
									<option value="Uttarakhand">Uttarakhand</option>
									<option value="West Bengal">West Bengal</option>
								</select>
											
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{ translate('City')}}</label>
                            </div>
                            <div class="col-md-10">                               
								<input class="form-control mb-3" placeholder="{{ translate('City')}}" name="city" required />
                            </div>
                        </div>

                        @if (get_setting('google_map') == 1)
                            <div class="row">
                                <input id="searchInput" class="controls" type="text" placeholder="{{translate('Enter a location')}}">
                                <div id="map"></div>
                                <ul id="geoData">
                                    <li style="display: none;">Full Address: <span id="location"></span></li>
                                    <li style="display: none;">Postal Code: <span id="postal_code"></span></li>
                                    <li style="display: none;">Country: <span id="country"></span></li>
                                    <li style="display: none;">Latitude: <span id="lat"></span></li>
                                    <li style="display: none;">Longitude: <span id="lon"></span></li>
                                </ul>
                            </div>

                            <div class="row">
                                <div class="col-md-2" id="">
                                    <label for="exampleInputuname">Longitude</label>
                                </div>
                                <div class="col-md-10" id="">
                                    <input type="text" class="form-control mb-3" id="longitude" name="longitude" readonly="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2" id="">
                                    <label for="exampleInputuname">Latitude</label>
                                </div>
                                <div class="col-md-10" id="">
                                    <input type="text" class="form-control mb-3" id="latitude" name="latitude" readonly="">
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-2">
                                <label>{{ translate('Pincode')}}</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control mb-3" placeholder="{{ translate('Pincode')}}" name="postal_code" value="" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{ translate('Phone')}}</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control mb-3" placeholder="{{ translate('+91')}}" name="phone" value="" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{  translate('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="edit-address-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ translate('Address Edit') }}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" id="edit_modal_body">

            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script type="text/javascript">
        function edit_address(address) {
            var url = '{{ route("addresses.edit", ":id") }}';
            url = url.replace(':id', address);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: 'GET',
                success: function (response) {
                    $('#edit_modal_body').html(response.html);
                    $('#edit-address-modal').modal('show');
                    AIZ.plugins.bootstrapSelect('refresh');

                    var country = $("#edit_country").val();
                    get_city(country);

                    @if (get_setting('google_map') == 1)
                        var lat     = -33.8688;
                        var long    = 151.2195;

                        if(response.data.address_data.latitude && response.data.address_data.longitude) {
                            lat     = parseFloat(response.data.address_data.latitude);
                            long    = parseFloat(response.data.address_data.longitude);
                        }

                        initialize(lat, long, 'edit_');
                    @endif
                }
            });
        }

        $(document).on('change', '[name=country]', function() {
            var country = $(this).val();
            get_city(country);
        });

        function get_city(country) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('get-city')}}",
                type: 'POST',
                data: {
                    country_name: country
                },
                success: function (response) {
                    var obj = JSON.parse(response);
                    if(obj != '') {
                        $('[name="city"]').html(obj);
                        AIZ.plugins.bootstrapSelect('refresh');
                    }
                }
            });
        }

        function add_new_address(){
            $('#new-address-modal').modal('show');
        }
	$("#continue_di").click(function(){
  		if ($('input[name=address_id]:checked').length > 0) {
   		 <?php flash(translate('Please select one address before continuing. '))->warning();  ?>
		}
	}); 
	

    </script>

    @if (get_setting('google_map') == 1)
    
        @include('frontend.partials.google_map')
        
    @endif

@endsection
