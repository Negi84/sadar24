<form class="form-default" role="form" action="{{ route('addresses.update', $address_data->id) }}" method="POST">
    @csrf
    <div class="p-3">
        <div class="row">
            <div class="col-md-2">
                <label>{{ translate('Address') }}</label>
            </div>
            <div class="col-md-10">
                <textarea class="form-control mb-3" placeholder="{{ translate('Your Address') }}" rows="2" name="address"
                    required>{{ $address_data->address }}</textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <label>{{ translate('Country') }}</label>
            </div>
            <div class="col-md-10">
                <div class="mb-3">
                    <select class="form-control aiz-selectpicker" data-live-search="true"
                        data-placeholder="{{ translate('Select your country') }}" name="country" id="edit_country"
                        required>
                        @foreach (\App\Country::where('status', 1)->get() as $key => $country)
                            <option value="{{ $country->name }}" @if ($address_data->country == $country->name) selected @endif>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <label>{{ translate('Pincode') }}</label>
            </div>
            <div class="col-md-10">
                {{-- <input type="text" class="form-control mb-3 edit-pincode"
                    placeholder="{{ translate('Your Pincode') }}" value="{{ $address_data->postal_code }}"
                    name="postal_code" value="" required minlength="6" maxlength="6"
                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"> --}}
                <input type="number" class="form-control mb-3 edit-pincode"
                    placeholder="{{ translate('Your Pincode') }}" name="postal_code" value="{{ $address_data->postal_code }}" required
                    maxlength="6" minlength="6"
                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                <small class="text-danger custom-text editpincodeError" style="display: none;">Zip code
                    must be of 6 digits only</small>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <label>{{ translate('State') }}</label>
            </div>
            <div class="col-md-10">
                <input class="form-control mb-3 edit-state" placeholder="{{ translate('state') }}" name="state"
                    required />
                {{-- <select name="state" id="state" class="form-control mb-3 aiz-selectpicker" data-live-search="true" required>
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
				</select> --}}
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">
                <label>{{ translate('City') }}</label>
            </div>
            <div class="col-md-10">
                <input class="form-control mb-3 edit-city" placeholder="{{ translate('City') }}" name="city"
                    required />
            </div>
        </div>

        @if (get_setting('google_map') == 1)
            <div class="row">
                <input id="edit_searchInput" class="controls" type="text" placeholder="Enter a location">
                <div id="edit_map"></div>
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
                    <input type="text" class="form-control mb-3" id="edit_longitude" name="longitude"
                        value="{{ $address_data->longitude }}" readonly="">
                </div>
            </div>
            <div class="row">
                <div class="col-md-2" id="">
                    <label for="exampleInputuname">Latitude</label>
                </div>
                <div class="col-md-10" id="">
                    <input type="text" class="form-control mb-3" id="edit_latitude" name="latitude"
                        value="{{ $address_data->latitude }}" readonly="">
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-2">
                <label>{{ translate('Phone') }}</label>
            </div>
            <div class="col-md-10">
                {{-- <input type="text" class="form-control mb-3" placeholder="{{ translate('+880') }}"
                    value="{{ $address_data->phone }}" name="phone" value="" required> --}}
                <input type="text" maxlength="10" minlength="10" onkeypress="phoneno()"
                    title="Please enter valid phone number without +91 or 0." class="form-control"
                    placeholder="{{ translate('Enter 10 digit phone number') }}" id="edit-phone-code" name="phone"
                    required>
            </div>
        </div>
        <div class="form-group text-right">
            <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $(".edit-pincode").keyup(function(e) {
            var e = $(".edit-pincode").val();
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
                        $(".edit-city").val(response[0].PostOffice[0].District);
                        $(".edit-state").val(response[0].PostOffice[0].State);
                    }
                });
            }
        });
    });
    function phoneno() {
            $('#edit-phone-code').keypress(function(e) {
                var a = [];
                var k = e.which;

                for (i = 48; i < 58; i++)
                    a.push(i);

                if (!(a.indexOf(k) >= 0))
                    e.preventDefault();
            });
        }

        document.querySelector('.edit-pincode').addEventListener('input', function() {
            if (this.value.length === 6) {
                checkDeliveryAvailability(this.value, 'billing');
            }
        });

        function checkDeliveryAvailability(pincode, type) {
            let errorClass = '';
            if (type === 'billing') {
                errorClass = '.editpincodeError';
            } else {
                errorClass = '.seditpincodeError';
            }
            if (pincode.length < 6 || pincode.length > 6) {
                document.querySelector('.editpincodeError').textContent = `Zip code must be of 6 digits only`;
                document.querySelector('.editpincodeError').classList.remove('text-success');
                document.querySelector('.editpincodeError').classList.add('text-danger');
                document.querySelector('.editpincodeError').style.display = 'block';
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
