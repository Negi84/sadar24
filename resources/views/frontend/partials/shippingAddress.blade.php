<div class="col-12 px-2">
    <div class="row mx-0 py-4 px-2">
        <div class="col-6">
            <p class="custom-text font-weight-bolder text-uppercase heading-text">
                Shipping</p>
        </div>
    </div>
</div>
<div class="col-12 px-0 mx-auto">
    <form class="form-default" data-toggle="validator" id="submit_shipping_info"
        {{-- action="{{ route('checkout.create_order') }}" --}} role="form" method="POST">
        @csrf
        @php
            $i = 1;
        @endphp
        @if (Auth::check())
            <div class="shadow-sm bg-white rounded mb-4">
                <div class="row gutters-5">
                    @foreach (Auth::user()->addresses as $key => $address)
                        @php
                            $pincode = $address->postal_code;

                            $url = 'https://track.delhivery.com/c/api/pin-codes/json/?filter_codes=' . $pincode;
                            
                            $curl = curl_init($url);
                            curl_setopt($curl, CURLOPT_URL, $url);
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                            
                            $headers = ['Authorization: Bearer 13e6e16ea6506989bb0d3fbaef437402278bffeb'];
                            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                            //for debug only!
                            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                            $disable = '';
                            $bg_color = '';
                            $resp = curl_exec($curl);
                            curl_close($curl);
                            $resp1 = json_decode($resp, true);
                            // dump($resp1['delivery_codes']);
                            //print_r($delivery_codes);
                            //$status =  $resp1['Status'];
                            //var_dump($resp);
                            
                        @endphp
                        @if (empty($resp1['delivery_codes']) || !isset($resp1['delivery_codes']))
                            @php
                                flash(translate('No such pincode avialable!!! Pincode:- ' . $pincode))->warning();
                                $disable = 'disabled';
                                $bg_color = 'bg-light';
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
                                    // flash(translate('Delivery available on current Pincode:- ' . $pincode))->success();
                                @endphp
                            @else
                                @php
                                    flash(translate('Delivery not available on current Pincode:- ' . $pincode))->warning();
                                    $disable = 'disabled';
                                    $bg_color = 'bg-light';
                                @endphp
                                <script>
                                    document.getElementById("add_div_{{ $pincode }}").disabled = true;
                                </script>
                            @endif
                        @endif
                        <div class="col-md-6 mb-3" id="add_div_{{ $pincode }}">
                            <fieldset {{ $disable }}>
                                <label
                                    class="aiz-megabox d-block bg-white {{ $bg_color }} mb-0">
                                    <input type="radio" name="address_id"
                                        value="{{ $address->id }}"
                                        @if ($address->set_default)
                                        @if (empty($resp1['delivery_codes']) || !isset($resp1['delivery_codes']))
                                        @else
                                        checked     
                                        @endif
                                        @endif
                                        required
                                        @if ($i == 1 || empty($resp1['delivery_codes']) || !isset($resp1['delivery_codes']))

                                        @elseif($i == 2)
                                        checked     
                                        @endif
                                        >
                                    <span class="d-flex p-3 aiz-megabox-elem">
                                        <span
                                            class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                        <span class="flex-grow-1 pl-3 text-left">
                                            <div>
                                                <span
                                                    class="opacity-60">{{ translate('Address') }}:</span>
                                                <span
                                                    class="fw-600 ml-2">{{ $address->address }}</span>
                                            </div>
                                            <div>
                                                <span
                                                    class="opacity-60">{{ translate('Country') }}:</span>
                                                <span
                                                    class="fw-600 ml-2">{{ $address->country }}</span>
                                            </div>
                                            <div>
                                                <span
                                                    class="opacity-60">{{ translate('State') }}:</span>
                                                <span
                                                    class="fw-600 ml-2">{{ $address->state }}</span>
                                            </div>
                                            <div>
                                                <span
                                                    class="opacity-60">{{ translate('City') }}:</span>
                                                <span
                                                    class="fw-600 ml-2">{{ $address->city }}</span>
                                            </div>
                                            <div>
                                                <span
                                                    class="opacity-60">{{ translate('Pincode') }}:</span>
                                                <span
                                                    class="fw-600 ml-2">{{ $address->postal_code }}</span>
                                            </div>
                                            <div>
                                                <span
                                                    class="opacity-60">{{ translate('Phone') }}:</span>
                                                <span
                                                    class="fw-600 ml-2">{{ $address->phone }}</span>
                                            </div>
                                        </span>
                                    </span>
                                </label>
                                <div class="dropdown position-absolute right-0 top-0">
                                    <button class="btn bg-gray px-2" type="button"
                                        data-toggle="dropdown">
                                        <i class="la la-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right"
                                        aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item"
                                            onclick="edit_address('{{ $address->id }}')">
                                            {{ translate('Edit') }}
                                        </a>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                    <input type="hidden" name="checkout_type" value="logged">
                    <div class="col-md-6 mx-auto mb-3">
                        <div class="border p-3 rounded mb-3 c-pointer text-center bg-white h-100 d-flex flex-column justify-content-center"
                            onclick="add_new_address()">
                            <i class="las la-plus la-2x mb-3"></i>
                            <div class="alpha-7">
                                {{ translate('Add New Address') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="shadow-sm bg-white p-4 rounded mb-4">
                <div class="form-group">
                    <label class="control-label">{{ translate('Name') }}</label>
                    <input type="text" class="form-control" name="name"
                        placeholder="{{ translate('Name') }}" required>
                </div>

                <div class="form-group">
                    <label class="control-label">{{ translate('Email') }}</label>
                    <input type="text" class="form-control" name="email"
                        placeholder="{{ translate('Email') }}" required>
                </div>

                <div class="form-group">
                    <label class="control-label">{{ translate('Address') }}</label>
                    <input type="text" class="form-control" name="address"
                        placeholder="{{ translate('Address') }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label
                                class="control-label">{{ translate('Select your country') }}</label>
                            <select class="form-control aiz-selectpicker"
                                data-live-search="true" name="country">
                                <option value="India">India</option>
                                @foreach (\App\Country::where('status', 1)->get() as $key => $country)
                                    <option value="{{ $country->name }}">
                                        {{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            <label
                                class="control-label">{{ translate('State') }}</label>
                            <select name="state" id="state"
                                class="form-control mb-3 aiz-selectpicker"
                                data-live-search="true" required>
                                <option value="Andhra Pradesh">Andhra Pradesh
                                </option>
                                <option value="Andaman and Nicobar Islands">Andaman
                                    and Nicobar Islands</option>
                                <option value="Arunachal Pradesh">Arunachal Pradesh
                                </option>
                                <option value="Assam">Assam</option>
                                <option value="Bihar">Bihar</option>
                                <option value="Chandigarh">Chandigarh</option>
                                <option value="Chhattisgarh">Chhattisgarh</option>
                                <option value="Dadar and Nagar Haveli">Dadar and
                                    Nagar Haveli</option>
                                <option value="Daman and Diu">Daman and Diu</option>
                                <option value="Delhi">Delhi</option>
                                <option value="Lakshadweep">Lakshadweep</option>
                                <option value="Puducherry">Puducherry</option>
                                <option value="Goa">Goa</option>
                                <option value="Gujarat">Gujarat</option>
                                <option value="Haryana">Haryana</option>
                                <option value="Himachal Pradesh">Himachal Pradesh
                                </option>
                                <option value="Jammu and Kashmir">Jammu and Kashmir
                                </option>
                                <option value="Jharkhand">Jharkhand</option>
                                <option value="Karnataka">Karnataka</option>
                                <option value="Kerala">Kerala</option>
                                <option value="Madhya Pradesh">Madhya Pradesh
                                </option>
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
                            <label
                                class="control-label">{{ translate('City') }}</label>
                            <input class="form-control mb-3"
                                placeholder="{{ translate('City') }}" name="city"
                                required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            <label
                                class="control-label">{{ translate('Pincode') }}</label>
                            <input type="text" class="form-control"
                                placeholder="{{ translate('Pincode') }}"
                                name="postal_code" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            <label
                                class="control-label">{{ translate('Phone') }}</label>
                            <input type="number" lang="en" min="0"
                                class="form-control"
                                placeholder="{{ translate('Phone') }}" name="phone"
                                required>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="checkout_type" value="guest">
            </div>
        @endif
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-left order-1 order-md-0">
                <a href="{{ route('cart') }}" class="link link--style-3">
                    <i class="las la-arrow-left"></i>
                    {{ translate('Return to cart') }}
                </a>
            </div>
        </div>
    </form>
</div>