@extends('frontend.layouts.user_panel')

@section('panel_content')
{{-- {{dd($shop)}} --}}
    <div class="aiz-titlebar mt-2 mb-4">
      <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{ translate('Shop Settings')}}
                <a href="{{ route('shop.visit', $shop->shop->slug) }}" class="btn btn-link btn-sm" target="_blank">({{ translate('Visit Shop')}})<i class="la la-external-link"></i>)</a>
            </h1>
        </div>
      </div>
    </div>

    {{-- Basic Info --}}
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Basic Info') }}</h5>
        </div>
        {{-- {{dd($shop)}} --}}
        {{-- Auth::user()->seller->verification_status == 0 --}}
        <div class="card-body">
            <form class="" action="{{ route('shops.update', $shop->id) }}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PATCH">
                @csrf
                <div class="row">
                    <label class="col-md-2 col-form-label">{{ translate('Shop Name') }}<span class="text-danger text-danger">*</span></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3" @if(Auth::user()->seller->verification_status == 1) disabled @endif placeholder="{{ translate('Shop Name')}}" name="name" value="{{ $shop->name }}" required >
                    </div>
                </div>
                 <div class="row">
                    <label class="col-md-2 col-form-label">{{ translate('Shop Description') }}<span class="text-danger text-danger">*</span></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3" @if(Auth::user()->seller->verification_status == 1) disabled @endif placeholder="{{ translate('Shop Description')}}" name="user_description" value="{{ $shop->user_description }}" required >
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-md-2 col-form-label">{{ translate('Shop Logo') }}</label>
                    <div class="col-md-10">
                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="logo" value="{{ $shop->logo }}" @if(Auth::user()->seller->verification_status == 1) disabled @endif class="selected-files">
                        </div>
                        <div class="file-preview box sm">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-2 col-form-label">
                        {{ translate('Shop Phone') }}
                    </label>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3" placeholder="{{ translate('Phone')}}" @if(Auth::user()->seller->verification_status == 1) disabled @endif name="phone" value="{{ $shop->phone }}" required>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-2 col-form-label">{{ translate('Shop Address') }} <span class="text-danger text-danger">*</span></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3" @if(Auth::user()->seller->verification_status == 1) disabled @endif placeholder="{{ translate('Shop Address')}}" name="address" value="{{ $shop->address }}" required>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-2 col-form-label">{{ translate('Pickup Address') }} <span class="text-danger text-danger">*</span></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3" @if(Auth::user()->seller->verification_status == 1) disabled @endif placeholder="{{ translate('Pickup Address')}}" name="pickup_address" value="{{ $shop->pickup_address }}" required>
                    </div>
                </div>
                @if (get_setting('shipping_type') == 'seller_wise_shipping')
                    <div class="row">
                        <div class="col-md-2">
                            <label>{{ translate('Shipping Cost')}} <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-10">
                            <input type="number" lang="en" min="0" @if(Auth::user()->seller->verification_status == 1) disabled @endif class="form-control mb-3" placeholder="{{ translate('Shipping Cost')}}" name="shipping_cost" value="{{ $shop->shipping_cost }}" required>
                        </div>
                    </div>
                @endif 
                @if (get_setting('pickup_point') == 1)
                <div class="row mb-3">
                    <label class="col-md-2 col-form-label">{{ translate('Pickup Points') }}</label>
                    <div class="col-md-10">
                        <select class="form-control aiz-selectpicker" @if(Auth::user()->seller->verification_status == 1) disabled @endif data-placeholder="{{ translate('Select Pickup Point') }}" id="pick_up_point" name="pick_up_point_id[]" multiple>
                            @foreach (\App\PickupPoint::all() as $pick_up_point)
                                @if (Auth::user()->shop->pick_up_point_id != null)
                                    <option value="{{ $pick_up_point->id }}" @if (in_array($pick_up_point->id, json_decode(Auth::user()->shop->pick_up_point_id))) selected @endif>{{ $pick_up_point->getTranslation('name') }}</option>
                                @else
                                    <option value="{{ $pick_up_point->id }}">{{ $pick_up_point->getTranslation('name') }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                @endif
				
				<div class="row">
                    <label class="col-md-2 col-form-label">
                        {{ translate('GST Number') }} <span class="text-danger text-danger">*</span>
                    </label>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3" @if(Auth::user()->seller->verification_status == 1) disabled @endif placeholder="{{ translate('GST Number')}}" name="gst_number" value="{{ $shop->shop->gst_number }}" required>
                    </div>
                </div>
				
				<div class="row">
                    <label class="col-md-2 col-form-label">
                        {{ translate('PAN Number') }} <span class="text-danger text-danger">*</span>
                    </label>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3" @if(Auth::user()->seller->verification_status == 1) disabled @endif placeholder="{{ translate('Pan Number')}}" name="pan_number" value="{{ $shop->shop->pan_number }}" required>
                    </div>
                </div>	
				
				<div class="row">
					<label class="col-md-2 col-form-label">{{ translate('Bank Name') }}</label>
					<div class="col-md-9">
						<input type="text" class="form-control mb-3" @if(Auth::user()->seller->verification_status == 1) disabled @endif placeholder="{{ translate('Bank Name')}}" value="{{ Auth::user()->seller->bank_name }}" name="bank_name">
					</div>
				</div>
				<div class="row">
					<label class="col-md-2 col-form-label">{{ translate('Bank Account Name') }}</label>
					<div class="col-md-10">
						<input type="text" class="form-control mb-3" @if(Auth::user()->seller->verification_status == 1) disabled @endif placeholder="{{ translate('Bank Account Name')}}" value="{{ Auth::user()->seller->bank_acc_name }}" name="bank_acc_name">
					</div>
				</div>
				<div class="row">
					<label class="col-md-2 col-form-label">{{ translate('Bank Account Number') }}</label>
					<div class="col-md-9">
						<input type="text" class="form-control mb-3" @if(Auth::user()->seller->verification_status == 1) disabled @endif placeholder="{{ translate('Bank Account Number')}}" value="{{ Auth::user()->seller->bank_acc_no }}" name="bank_acc_no">
					</div>
				</div>	
				<div class="row">
					<label class="col-md-2 col-form-label">{{ translate('Account Type') }} <span class="text-danger text-danger">*</span></label>
					<div class="col-md-10">
						<select id="account_type" @if(Auth::user()->seller->verification_status == 1) disabled @endif class="form-control mb-3" name="account_type">
							<option value="">Select Your Account Type</option>
							<option value="Savings" <?php if(Auth::user()->seller->account_type == 'Savings'){echo "selected";}?>>Savings</option>
							<option value="Current" <?php if(Auth::user()->seller->account_type == 'Current'){echo "selected";}?>>Current</option>
						</select>
					</div>
				</div>			
				<div class="row">
					<label class="col-md-2 col-form-label">{{ translate('IFSC Code') }} <span class="text-danger text-danger">*</span></label>
					<div class="col-md-10">
						<input type="text" class="form-control mb-3" @if(Auth::user()->seller->verification_status == 1) disabled @endif placeholder="{{ translate('IFSC Code')}}"  name="ifsc_code" value="{{ Auth::user()->seller->ifsc_code }}">
					</div>
				</div>			
				<div class="row">
					<label class="col-md-2 col-form-label">{{ translate('Branch') }} <span class="text-danger text-danger">*</span></label>
					<div class="col-md-10">
					   <input type="text" placeholder="{{ translate('Branch')}}" @if(Auth::user()->seller->verification_status == 1) disabled @endif class="form-control mb-3" name="branch" value="{{ Auth::user()->seller->branch }}">
					</div>
				</div>

                <div class="row d-none">
                    <label class="col-md-2 col-form-label">{{ translate('Meta Title') }}<span class="text-danger text-danger">*</span></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3" @if(Auth::user()->seller->verification_status == 1) disabled @endif placeholder="{{ translate('Meta Title')}}" name="meta_title" value="{{ $shop->meta_title }}">
                    </div>
                </div>
                <div class="row d-none">
                    <label class="col-md-2 col-form-label">{{ translate('Meta Description') }}<span class="text-danger text-danger">*</span></label>
                    <div class="col-md-10">
                        <textarea name="meta_description" rows="3" @if(Auth::user()->seller->verification_status == 1) disabled @endif class="form-control mb-3">{{ $shop->meta_description }}</textarea>
                    </div>
                </div>
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                </div>
            </form>
        </div>
    </div>

    @if (addon_is_activated('delivery_boy'))
        {{-- <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Delivery Boy Pickup Point') }}</h5>
            </div>
            <div class="card-body">
                <form class="" action="{{ route('shops.update', $shop->id) }}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="PATCH">
                    @csrf

                    @if (get_setting('google_map') == 1)
                        <div class="row mb-3">
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
                                <input type="text" class="form-control mb-3" id="longitude" name="delivery_pickup_longitude" readonly="" value="{{ $shop->delivery_pickup_longitude }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2" id="">
                                <label for="exampleInputuname">Latitude</label>
                            </div>
                            <div class="col-md-10" id="">
                                <input type="text" class="form-control mb-3" id="latitude" name="delivery_pickup_latitude" readonly="" value="{{ $shop->delivery_pickup_latitude }}">
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-md-2" id="">
                                <label for="exampleInputuname">Longitude</label>
                            </div>
                            <div class="col-md-10" id="">
                                <input type="text" class="form-control mb-3" id="longitude" name="delivery_pickup_longitude" value="{{ $shop->delivery_pickup_longitude }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2" id="">
                                <label for="exampleInputuname">Latitude</label>
                            </div>
                            <div class="col-md-10" id="">
                                <input type="text" class="form-control mb-3" id="latitude" name="delivery_pickup_latitude" value="{{ $shop->delivery_pickup_latitude }}">
                            </div>
                        </div>
                    @endif

                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                    </div>
                </form>
            </div>
        </div> --}}
    @endif

    {{-- Banner Settings --}}
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Banner Settings') }}</h5>
        </div>
        <div class="card-body">
            <form class="" action="{{ route('shops.update', $shop->id) }}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PATCH">
                @csrf

                <div class="row mb-3">
                    <label class="col-md-2 col-form-label">{{ translate('Banners') }} (1500x450)</label>
                    <div class="col-md-10">
                        <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="sliders" value="{{ $shop->sliders }}" class="selected-files">
                        </div>
                        <div class="file-preview box sm">
                        </div>
                        <small class="text-muted">{{ translate('We had to limit height to maintian consistancy. In some device both side of the banner might be cropped for height limitation.') }}</small>
                    </div>
                </div>

                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Social Media Link --}}
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Social Media Link') }}</h5>
        </div>
        <div class="card-body">
            <form class="" action="{{ route('shops.update', $shop->id) }}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PATCH">
                @csrf
                <div class="form-box-content p-3">
                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label">{{ translate('Facebook') }}</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" placeholder="{{ translate('Facebook')}}" name="facebook" value="{{ $shop->facebook }}">
                            <small class="text-muted">{{ translate('Insert link with https ') }}</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label">{{ translate('Twitter') }}</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" placeholder="{{ translate('Twitter')}}" name="twitter" value="{{ $shop->twitter }}">
                            <small class="text-muted">{{ translate('Insert link with https ') }}</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label">{{ translate('Google') }}</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" placeholder="{{ translate('Google')}}" name="google" value="{{ $shop->google }}">
                            <small class="text-muted">{{ translate('Insert link with https ') }}</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label">{{ translate('Youtube') }}</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" placeholder="{{ translate('Youtube')}}" name="youtube" value="{{ $shop->youtube }}">
                            <small class="text-muted">{{ translate('Insert link with https ') }}</small>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                </div>
            </form>
        </div>
    </div>

@endsection
