@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <h5 class="mb-0 h6">{{translate('Edit Seller Information')}}</h5>
</div>


<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{translate('Seller Information')}}</h5>
        </div>
        <div class="card-body">
             <form action="{{ route('sellers.update', $seller->id) }}" method="POST">
                <input name="_method" type="hidden" value="PATCH">
            	@csrf
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="col-from-label" for="name">{{translate('Name')}} <span class="text-danger">*</span></label>							
							<input type="text" placeholder="{{translate('Name')}}" id="name" name="name" class="form-control" value="{{$seller->user->name}}" required>
						</div>
					</div>
					<div class="col-md-4">
						 <div class="form-group">
							<label class="col-from-label" for="email">{{translate('Email Address')}} <span class="text-danger">*</span></label>
							<input type="text" placeholder="{{translate('Email Address')}}" id="email" name="email" value="{{$seller->user->email}}" class="form-control" required>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="col-from-label" for="phone">{{translate('Phone')}} <span class="text-danger">*</span></label>
							<input type="text" placeholder="{{translate('Phone')}}" id="phone" name="phone" value="{{$seller->user->phone}}" class="form-control" required>
						</div>
					</div>	
					{{-- <div class="col-md-3">
						<div class="form-group">
							<label>{{ translate('Your Password') }} <span class="text-danger">*</span></label>
							<input type="password"
								class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
								placeholder="{{ translate('Password') }}" name="password" value="{{$seller->user->password}}" required>
						</div>
					</div>				 --}}
				</div>	
				<h5 class="pt-3 h6">{{translate('Company Information')}}</h5>
				<hr>
				<br/>				
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label class="col-form-label">{{ translate('Company Name') }} <span class="text-danger text-danger">*</span></label>
							<input type="text" placeholder="{{ translate('Company Name')}}" id="company" class="form-control" name="company" value="{{ $seller->user->shop->name }}" required>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label class="col-form-label">{{ translate('Types of business') }} <span class="text-danger text-danger">*</span></label>
							<select id="types_of_business" class="form-control" name="types_of_business" required>
								<option value="">Select Your Account Type</option>
								<option value="Sole Proprietorship">Sole Proprietorship</option>
								<option value="Partnership">Partnership</option>
								<option value="LLP">LLP</option>
								<option value="Private Limited">Private Limited</option>
							</select>							
						</div>
					</div>
					<div class="col-md-3">
						 <div class="form-group">
							<label class="col-form-label">{{ translate('GST Number') }} <span class="text-danger text-danger">*</span></label>
							<input type="text" placeholder="{{ translate('GST Number')}}" id="gst_number" class="form-control" name="gst_number" value="{{ $seller->user->shop->gst_number }}" required>
							<small class="text-success custom-text">GST has to be 15 digit!</small>
                            <small class="text-danger custom-text gstError" style="display: none;"></small>
						</div>
					</div>
					
					<div class="col-md-3">
						 <div class="form-group">
							<label class="col-form-label">{{ translate('PAN Card Number') }} <span class="text-danger text-danger">*</span></label>
							<input type="text" placeholder="{{ translate('PAN Card Number')}}" id="pan_number" class="form-control" name="pan_number" value="{{ $seller->user->shop->pan_number }}" required>
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group">
							<label>{{ translate('Company Description') }} <span
									class="text-danger"></span></label>
							<input type="text" class="form-control"
								placeholder="{{ translate('Company Description') }}" name="user_description"
								>
						</div>
					</div>
				</div>
				
				
				<h5 class="pt-3 h6">{{translate('Company Address')}}</h5>
				<hr>
				<br/>				
				<div class="row">
					<div class="col-md-5">
						 <div class="form-group">
							<label class="col-form-label">{{ translate('Address') }} <span class="text-danger text-danger">*</span></label>
							<input type="text" placeholder="{{ translate('Address')}}" id="address" class="form-control mb-3" name="address" value="{{ $seller->user->shop->address }}" required>
						</div>
					</div>
					
					<div class="col-md-2">
						 <div class="form-group">
							<label class="col-form-label">{{ translate('Pincode') }} <span class="text-danger text-danger">*</span></label>
							<input type="text" placeholder="{{ translate('pincode')}}" id="postal_code" class="form-control mb-3" name="postal_code" value="{{ $seller->user->shop->postal_code }}" required>
							<small class="text-danger custom-text pincodeError" style="display: none;">Zip code
								must be of 6 digits only</small>
						</div>
					</div>	
					<div class="col-md-3">
						<div class="form-group">
						   <label class="col-form-label">{{ translate('State') }} <span class="text-danger text-danger">*</span></label>
						   <input type="text" disabled="" placeholder="{{ translate('State')}}" id="state" class="form-control mb-3" name="state" value="{{ $seller->user->shop->state }}" required>
					   </div>
				   </div>
				   
				   <div class="col-md-2">
						<div class="form-group">
						   <label class="col-form-label">{{ translate('City') }} <span class="text-danger text-danger">*</span></label>
						   <input type="text" disabled="" placeholder="{{ translate('City')}}" id="city" class="form-control mb-3" name="city" value="{{ $seller->user->shop->city }}" required>
					   </div>
				   </div>					
				</div>
				<h5 class="pt-3 h6">{{ translate('Pickup Address') }}</h5>
				<hr>
				<br />
				<div class="row p-3">
					<div class="col-md-5">
						<div class="form-group">
							<label>{{ translate('Pickup Address') }} <span class="text-danger">*</span></label>
							<input type="text" class="form-control mb-3"
								placeholder="{{ translate('Pickup Address') }}" name="pickup_address" value="{{ $seller->user->pickup_address }}" required>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label class="col-form-label">{{ translate('Pickup Pincode') }} <span
									class="text-danger text-danger">*</span></label>
							<input type="text" placeholder="{{ translate('Pickup Pincode') }}"
								id="pickup_postal_code" class="form-control mb-3" name="pickup_postal_code"
								maxlength="6" minlength="6"
								oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
								value="{{ $seller->user->pickup_postal_code }}"
								required>
							<small class="text-danger custom-text pickuppincodeError" style="display: none;">Zip code
								must be of 6 digits only</small>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label class="col-form-label">{{ translate('Pickup State') }} <span
									class="text-danger text-danger">*</span></label>
							<input type="text" disabled="" placeholder="{{ translate('Pickup State') }}"
								id="pickup_state" class="form-control mb-3" name="pickup_state" value="{{ $seller->user->pickup_state }}" required>
						</div>
					</div>

					<div class="col-md-2">
						<div class="form-group">
							<label class="col-form-label">{{ translate('Pickup City') }} <span
									class="text-danger text-danger">*</span></label>
							<input type="text" disabled="" placeholder="{{ translate('Pickup City') }}"
								id="pickup_city" class="form-control mb-3" name="pickup_city" value="{{ $seller->user->pickup_city }}" required>
						</div>
					</div>
				</div>
				<h5 class="pt-3 h6">{{translate('Bank Information')}}</h5>
				<hr>
				<br/>				
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="col-form-label">{{ translate('bank_name') }} <span class="text-danger text-danger">*</span></label>
							<input type="text" placeholder="{{ translate('bank_name')}}" id="bank_name" class="form-control" name="bank_name" value="{{ $seller->user->seller->bank_name }}" required>
						</div>
					</div>
					<div class="col-md-4">
						 <div class="form-group">
							<label class="col-form-label">{{ translate('bank_acc_name') }} <span class="text-danger text-danger">*</span></label>
							<input type="text" placeholder="{{ translate('bank_acc_name')}}" id="bank_acc_name" class="form-control" name="bank_acc_name" value="{{ $seller->user->seller->bank_acc_name }}" required>
						</div>
					</div>
					<div class="col-md-4">
						 <div class="form-group">
							<label class="col-form-label">{{ translate('Bank Account number') }} <span class="text-danger text-danger">*</span></label>
							<input type="text" placeholder="{{ translate('Bank Account number')}}" id="bank_acc_no" class="form-control mb-3" name="bank_acc_no" value="{{ $seller->user->seller->bank_acc_no }}" required>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="col-form-label">{{ translate('Account Type') }} <span class="text-danger text-danger">*</span></label>
							<select id="account_type" class="form-control" name="account_type" required>
								<option value="">Select Your Account Type</option>
								<option value="Savings">Savings</option>
								<option value="Current">Current</option>
							</select>							
						</div>
					</div>
					<div class="col-md-4">
						 <div class="form-group">
							<label class="col-form-label">{{ translate('IFSC Code') }} <span class="text-danger text-danger">*</span></label>
							<input type="text" placeholder="{{ translate('IFSC Code')}}" id="ifsc_code" class="form-control" name="ifsc_code" value="{{ $seller->user->seller->ifsc_code }}" required>
						</div>
					</div>
					<div class="col-md-4">
						 <div class="form-group">
							<label class="col-form-label">{{ translate('Branch') }} <span class="text-danger text-danger">*</span></label>
							<input type="text" placeholder="{{ translate('Branch')}}" id="branch" class="form-control mb-3" name="branch" value="{{ $seller->user->seller->branch }}" required>
						</div>
					</div>						
				</div>				
				
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@section('script')
    {{-- validate email phone gst --}}
    <script>
        function validatePhoneFields() {
            $(document).ready(function () {
            var phone = $("#phone").val() != null ? $("#phone").val() : "";
            // var email = $("#email").val() != null ? $("#email").val() : "";
            // var gst = $("#gst_number").val() != null ? $("#gst_number").val() : "";
            var url = "<?php echo route('validatePhoneFields'); ?>";
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    phone: phone,
                    // email: email,
                    // gst: gst,
                    _token: "{{ csrf_token() }}"
                },
                //   dataType: "dataType",
                success: function(response) {
                    console.log(response);
                    document.querySelector(".phoneError").textContent = response.status;
                    document.querySelector(".phoneError").style.display = 'block';
                }
            });
        });
        }
        function validateEmailFields() {
            $(document).ready(function () {
            // var phone = $("#phone").val() != null ? $("#phone").val() : "";
            var email = $("#email").val() != null ? $("#email").val() : "";
            // var gst = $("#gst_number").val() != null ? $("#gst_number").val() : "";
            var url = "<?php echo route('validateEmailFields'); ?>";
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    // phone: phone,
                    email: email,
                    // gst: gst,
                    _token: "{{ csrf_token() }}"
                },
                //   dataType: "dataType",
                success: function(response) {
                    console.log(response);
                    document.querySelector(".emailError").textContent = response.status;
                    document.querySelector(".emailError").style.display = 'block';
                }
            });
        });
        }
        function validateGstFields() {
            $(document).ready(function () {
            // var phone = $("#phone").val() != null ? $("#phone").val() : "";
            // var email = $("#email").val() != null ? $("#email").val() : "";
            var gst = $("#gst_number").val() != null ? $("#gst_number").val() : "";
            var url = "<?php echo route('validateGstFields'); ?>";
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    // phone: phone,
                    // email: email,
                    gst: gst,
                    _token: "{{ csrf_token() }}"
                },
                //   dataType: "dataType",
                success: function(response) {
                    console.log(response);
                    document.querySelector(".gstError").textContent = response.status;
                    document.querySelector(".gstError").style.display = 'block';
                }
            });
        });
        }
    </script>
    {{-- validate email phone gst --}}
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script type="text/javascript">
        // making the CAPTCHA  a required field for form submission
        $(document).ready(function() {
            // alert('helloman');
            $("#shop").on("submit", function(evt) {
                var response = grecaptcha.getResponse();
                if (response.length == 0) {
                    //reCaptcha not verified
                    alert("please verify you are humann!");
                    evt.preventDefault();
                    return false;
                }
                //captcha verified
                //do the rest of your validations here
                $("#reg-form").submit();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $("#pickup_postal_code").keyup(function(e) {
                var e = $("#pickup_postal_code").val();
                // console.log($(".add-pincode").val().lenght);
                console.log(e.length);
                if (e.length == 6) {
                    let url = "https://api.postalpincode.in/pincode/" + e + "";
                    $.ajax({
                        type: "GET",
                        url: url,
                        // data: "data",
                        // dataType: "dataType",
                        success: function(response) {
                            console.log(response[0].PostOffice[0]);
                            $("#pickup_city").val(response[0].PostOffice[0].District);
                            $("#pickup_state").val(response[0].PostOffice[0].State);
                        }
                    });
                }
            });

            $("#postal_code").keyup(function(e) {
                var e = $("#postal_code").val();
                // console.log($(".add-pincode").val().lenght);
                console.log(e.length);
                if (e.length == 6) {
                    let url = "https://api.postalpincode.in/pincode/" + e + "";
                    $.ajax({
                        type: "GET",
                        url: url,
                        // data: "data",
                        // dataType: "dataType",
                        success: function(response) {
                            console.log(response[0].PostOffice[0]);
                            $("#city").val(response[0].PostOffice[0].District);
                            $("#state").val(response[0].PostOffice[0].State);
                        }
                    });
                }
            });
        });

        function phoneno() {
            $('#phone').keypress(function(e) {
                var a = [];
                var k = e.which;

                for (i = 48; i < 58; i++)
                    a.push(i);

                if (!(a.indexOf(k) >= 0))
                    e.preventDefault();
            });
        }

        document.querySelector('#postal_code').addEventListener('input', function() {
            if (this.value.length === 6) {
                checkDeliveryAvailability(this.value, 'billing');
            }
        });

        function checkDeliveryAvailability(pincode, type) {
            let errorClass = '';
            if (type === 'billing') {
                errorClass = '.pincodeError';
            } else {
                errorClass = '.spincodeError';
            }
            if (pincode.length < 6 || pincode.length > 6) {
                document.querySelector('.pincodeError').textContent = `Zip code must be of 6 digits only`;
                document.querySelector('.pincodeError').classList.remove('text-success');
                document.querySelector('.pincodeError').classList.add('text-danger');
                document.querySelector('.pincodeError').style.display = 'block';
            }
            $.ajax({
                url: "{{ route('check-pincode-availability') }}",
                method: "get",
                data: {
                    pincode
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data.response);
                    if (data.exists) {
                        if (data.response.pre_paid === 'Y' && data.response.cash === 'Y') {
                            document.querySelector(errorClass).textContent =
                                `Delivery to pincode ${pincode} in ${data.response.district} is available`;
                            document.querySelector(errorClass).style.display = 'block';
                            document.querySelector(errorClass).classList.add('text-success');
                            document.querySelector(errorClass).classList.remove('text-danger');
                            // document.querySelector('.cod-pay').removeAttribute('disabled');
                            // document.querySelector('.online-pay').removeAttribute('disabled');
                            // document.querySelector('.order-button').style.display = 'block';
                            return true;
                        } else if (data.response.pre_paid === 'Y' && data.response.cash === 'N') {
                            document.querySelector(errorClass).textContent =
                                `Delivery to pincode ${pincode} in ${data.response.district} is available but COD is not available`;
                            document.querySelector(errorClass).style.display = 'block';
                            document.querySelector(errorClass).classList.add('text-success');
                            document.querySelector(errorClass).classList.remove('text-danger');
                            // document.querySelector('.cod-pay').setAttribute('disabled', true);
                            // document.querySelector('.cod-pay').removeAttribute('checked');
                            // document.querySelector('.online-pay').removeAttribute('disabled');
                            // document.querySelector('.order-button').style.display = 'block';
                            return true;
                        } else {
                            document.querySelector(errorClass).textContent =
                                `Delivery to pincode ${pincode} in ${data.response.district} is not available`;
                            document.querySelector(errorClass).style.display = 'block';
                            document.querySelector(errorClass).classList.remove('text-success');
                            document.querySelector(errorClass).classList.add('text-danger');
                            document.querySelector('.order-button').style.display = 'none';
                            return false;
                        }
                    } else {
                        document.querySelector(errorClass).textContent =
                            `Wrong pincode or this pincode is not serviceable, Please enter a correct pincode`;
                        document.querySelector(errorClass).style.display = 'block';
                        document.querySelector(errorClass).classList.remove('text-success');
                        document.querySelector(errorClass).classList.add('text-danger');
                        document.querySelector('.order-button').style.display = 'none';
                        return false;
                    }
                }
            });
        }

        document.querySelector('#pickup_postal_code').addEventListener('input', function() {
            if (this.value.length === 6) {
                checkPickupDeliveryAvailability(this.value, 'billing');
            }
        });

        function checkPickupDeliveryAvailability(pincode, type) {
            let errorClass = '';
            if (type === 'billing') {
                errorClass = '.pickuppincodeError';
            } else {
                errorClass = '.spickuppincodeError';
            }
            if (pincode.length < 6 || pincode.length > 6) {
                document.querySelector('.pickuppincodeError').textContent = `Zip code must be of 6 digits only`;
                document.querySelector('.pickuppincodeError').classList.remove('text-success');
                document.querySelector('.pickuppincodeError').classList.add('text-danger');
                document.querySelector('.pickuppincodeError').style.display = 'block';
            }
            $.ajax({
                url: "{{ route('check-pincode-availability') }}",
                method: "get",
                data: {
                    pincode
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data.response);
                    if (data.exists) {
                        if (data.response.pre_paid === 'Y' && data.response.cash === 'Y') {
                            document.querySelector(errorClass).textContent =
                                `Delivery to pincode ${pincode} in ${data.response.district} is available`;
                            document.querySelector(errorClass).style.display = 'block';
                            document.querySelector(errorClass).classList.add('text-success');
                            document.querySelector(errorClass).classList.remove('text-danger');
                            // document.querySelector('.cod-pay').removeAttribute('disabled');
                            // document.querySelector('.online-pay').removeAttribute('disabled');
                            // document.querySelector('.order-button').style.display = 'block';
                            return true;
                        } else if (data.response.pre_paid === 'Y' && data.response.cash === 'N') {
                            document.querySelector(errorClass).textContent =
                                `Delivery to pincode ${pincode} in ${data.response.district} is available but COD is not available`;
                            document.querySelector(errorClass).style.display = 'block';
                            document.querySelector(errorClass).classList.add('text-success');
                            document.querySelector(errorClass).classList.remove('text-danger');
                            // document.querySelector('.cod-pay').setAttribute('disabled', true);
                            // document.querySelector('.cod-pay').removeAttribute('checked');
                            // document.querySelector('.online-pay').removeAttribute('disabled');
                            // document.querySelector('.order-button').style.display = 'block';
                            return true;
                        } else {
                            document.querySelector(errorClass).textContent =
                                `Delivery to pincode ${pincode} in ${data.response.district} is not available`;
                            document.querySelector(errorClass).style.display = 'block';
                            document.querySelector(errorClass).classList.remove('text-success');
                            document.querySelector(errorClass).classList.add('text-danger');
                            document.querySelector('.order-button').style.display = 'none';
                            return false;
                        }
                    } else {
                        document.querySelector(errorClass).textContent =
                            `Wrong pincode or this pincode is not serviceable, Please enter a correct pincode`;
                        document.querySelector(errorClass).style.display = 'block';
                        document.querySelector(errorClass).classList.remove('text-success');
                        document.querySelector(errorClass).classList.add('text-danger');
                        document.querySelector('.order-button').style.display = 'none';
                        return false;
                    }
                }
            });
        }
    </script>
@endsection