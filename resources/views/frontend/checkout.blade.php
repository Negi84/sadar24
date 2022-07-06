@extends('frontend.layouts.app')

@section('content')
    <section class="mb-4" id="checkout">
        <div class="container-fluid">
            <div class="row mx-0 my-3 ">
                <!-- products cards -->
                <div class="col-md-8 shadow bg-white px-0 px-md-2 mb-4 h-100" style="border-left: 4px solid black;">
                    <div class="col-12 px-1">
                        <div class="row mb-0 mb-md-5 mb-md-0">
                            <div class="col-12 px-0 px-md-4">

                                <div class="row mx-0 payment-options" style="display: none;">
                                    {{-- <div class="col-6">
                                        <button class="btn custom-text text-dark  btn-block rounded-0 py-3 cod" style="border: 1px solid silver;">Cash on Delivery </button>
                                    </div>
                                    <div class="col-6">
                                        <button class="btn custom-text text-dark btn-block rounded-0 py-3 gateway" style="border: 1px solid silver;">Online Payment </button>
                                    </div> --}}

                                    {{-- Payment Gateways --}}
                                    <div class="col-lg-12">
                                        <form action="{{ route('payment.checkout') }}" class="form-default" role="form"
                                            method="POST" id="checkout-form">
                                            @csrf
                                            <input type="hidden" name="owner_id" value="{{ $carts[0]['owner_id'] }}">

                                            <div class="card shadow-sm border-0 rounded">
                                                <div class="card-header p-0">
                                                    <p class="custom-text font-weight-bolder text-uppercase heading-text">{{ translate('Select a payment option') }}</p>
                                                </div>
                                                <div class="card-body text-center p-0">
                                                    <div class="row mx-0">
                                                        <div class="col-xxl-12 col-xl-12 mx-auto px-0">
                                                            <div class="row gutters-10 mx-0">
                                                                @if (get_setting('paypal_payment') == 1)
                                                                    <div class="col-6 col-md-4">
                                                                        <label class="aiz-megabox d-block mb-3">
                                                                            <input value="paypal" class="online_payment"
                                                                                type="radio" name="payment_option" checked>
                                                                            <span class="d-block p-3 aiz-megabox-elem">
                                                                                <img src="{{ static_asset('assets/img/cards/paypal.png') }}"
                                                                                    class="img-fluid mb-2">
                                                                                <span class="d-block text-center">
                                                                                    <span
                                                                                        class="d-block fw-600 fs-12">{{ translate('Paypal') }}</span>
                                                                                </span>
                                                                            </span>
                                                                        </label>
                                                                    </div>
                                                                @endif
                                                                @if (get_setting('stripe_payment') == 1)
                                                                    <div class="col-6 col-md-4">
                                                                        <label class="aiz-megabox d-block mb-3">
                                                                            <input value="stripe" class="online_payment"
                                                                                type="radio" name="payment_option" checked>
                                                                            <span class="d-block p-3 aiz-megabox-elem">
                                                                                <img src="{{ static_asset('assets/img/cards/stripe.png') }}"
                                                                                    class="img-fluid mb-2">
                                                                                <span class="d-block text-center">
                                                                                    <span
                                                                                        class="d-block fw-600 fs-12">{{ translate('Stripe') }}</span>
                                                                                </span>
                                                                            </span>
                                                                        </label>
                                                                    </div>
                                                                @endif
                                                                @if (get_setting('sslcommerz_payment') == 1)
                                                                    <div class="col-6 col-md-4">
                                                                        <label class="aiz-megabox d-block mb-3">
                                                                            <input value="sslcommerz" class="online_payment"
                                                                                type="radio" name="payment_option" checked>
                                                                            <span class="d-block p-3 aiz-megabox-elem">
                                                                                <img src="{{ static_asset('assets/img/cards/sslcommerz.png') }}"
                                                                                    class="img-fluid mb-2">
                                                                                <span class="d-block text-center">
                                                                                    <span
                                                                                        class="d-block fw-600 fs-12">{{ translate('sslcommerz') }}</span>
                                                                                </span>
                                                                            </span>
                                                                        </label>
                                                                    </div>
                                                                @endif
                                                                @if (get_setting('instamojo_payment') == 1)
                                                                    <div class="col-6 col-md-4">
                                                                        <label class="aiz-megabox d-block mb-3">
                                                                            <input value="instamojo" class="online_payment"
                                                                                type="radio" name="payment_option" checked>
                                                                            <span class="d-block p-3 aiz-megabox-elem">
                                                                                <img src="{{ static_asset('assets/img/cards/instamojo.png') }}"
                                                                                    class="img-fluid mb-2">
                                                                                <span class="d-block text-center">
                                                                                    <span
                                                                                        class="d-block fw-600 fs-12">{{ translate('Instamojo') }}</span>
                                                                                </span>
                                                                            </span>
                                                                        </label>
                                                                    </div>
                                                                @endif
                                                                @if (get_setting('razorpay') == 1)
                                                                    <div class="col-6 col-md-4">
                                                                        <label class="aiz-megabox d-block mb-3">
                                                                            <input value="razorpay" class="online_payment"
                                                                                type="radio" name="payment_option" checked>
                                                                            <span class="d-block p-3 aiz-megabox-elem">
                                                                                <img src="{{ static_asset('assets/img/cards/rozarpay.png') }}"
                                                                                    class="img-fluid mb-2">
                                                                                <span class="d-block text-center">
                                                                                    <span
                                                                                        class="d-block fw-600 fs-12">{{ translate('Razorpay') }}</span>
                                                                                </span>
                                                                            </span>
                                                                        </label>
                                                                    </div>
                                                                @endif
                                                                @if (get_setting('paystack') == 1)
                                                                    <div class="col-6 col-md-4">
                                                                        <label class="aiz-megabox d-block mb-3">
                                                                            <input value="paystack" class="online_payment"
                                                                                type="radio" name="payment_option" checked>
                                                                            <span class="d-block p-3 aiz-megabox-elem">
                                                                                <img src="{{ static_asset('assets/img/cards/paystack.png') }}"
                                                                                    class="img-fluid mb-2">
                                                                                <span class="d-block text-center">
                                                                                    <span
                                                                                        class="d-block fw-600 fs-12">{{ translate('Paystack') }}</span>
                                                                                </span>
                                                                            </span>
                                                                        </label>
                                                                    </div>
                                                                @endif
                                                                @if (get_setting('voguepay') == 1)
                                                                    <div class="col-6 col-md-4">
                                                                        <label class="aiz-megabox d-block mb-3">
                                                                            <input value="voguepay" class="online_payment"
                                                                                type="radio" name="payment_option" checked>
                                                                            <span class="d-block p-3 aiz-megabox-elem">
                                                                                <img src="{{ static_asset('assets/img/cards/vogue.png') }}"
                                                                                    class="img-fluid mb-2">
                                                                                <span class="d-block text-center">
                                                                                    <span
                                                                                        class="d-block fw-600 fs-12">{{ translate('VoguePay') }}</span>
                                                                                </span>
                                                                            </span>
                                                                        </label>
                                                                    </div>
                                                                @endif
                                                                @if (get_setting('payhere') == 1)
                                                                    <div class="col-6 col-md-4">
                                                                        <label class="aiz-megabox d-block mb-3">
                                                                            <input value="payhere" class="online_payment"
                                                                                type="radio" name="payment_option" checked>
                                                                            <span class="d-block p-3 aiz-megabox-elem">
                                                                                <img src="{{ static_asset('assets/img/cards/payhere.png') }}"
                                                                                    class="img-fluid mb-2">
                                                                                <span class="d-block text-center">
                                                                                    <span
                                                                                        class="d-block fw-600 fs-12">{{ translate('payhere') }}</span>
                                                                                </span>
                                                                            </span>
                                                                        </label>
                                                                    </div>
                                                                @endif
                                                                @if (get_setting('ngenius') == 1)
                                                                    <div class="col-6 col-md-4">
                                                                        <label class="aiz-megabox d-block mb-3">
                                                                            <input value="ngenius" class="online_payment"
                                                                                type="radio" name="payment_option" checked>
                                                                            <span class="d-block p-3 aiz-megabox-elem">
                                                                                <img src="{{ static_asset('assets/img/cards/ngenius.png') }}"
                                                                                    class="img-fluid mb-2">
                                                                                <span class="d-block text-center">
                                                                                    <span
                                                                                        class="d-block fw-600 fs-12">{{ translate('ngenius') }}</span>
                                                                                </span>
                                                                            </span>
                                                                        </label>
                                                                    </div>
                                                                @endif
                                                                @if (get_setting('iyzico') == 1)
                                                                    <div class="col-6 col-md-4">
                                                                        <label class="aiz-megabox d-block mb-3">
                                                                            <input value="iyzico" class="online_payment"
                                                                                type="radio" name="payment_option" checked>
                                                                            <span class="d-block p-3 aiz-megabox-elem">
                                                                                <img src="{{ static_asset('assets/img/cards/iyzico.png') }}"
                                                                                    class="img-fluid mb-2">
                                                                                <span class="d-block text-center">
                                                                                    <span
                                                                                        class="d-block fw-600 fs-12">{{ translate('Iyzico') }}</span>
                                                                                </span>
                                                                            </span>
                                                                        </label>
                                                                    </div>
                                                                @endif
                                                                @if (get_setting('nagad') == 1)
                                                                    <div class="col-6 col-md-4">
                                                                        <label class="aiz-megabox d-block mb-3">
                                                                            <input value="nagad" class="online_payment"
                                                                                type="radio" name="payment_option" checked>
                                                                            <span class="d-block p-3 aiz-megabox-elem">
                                                                                <img src="{{ static_asset('assets/img/cards/nagad.png') }}"
                                                                                    class="img-fluid mb-2">
                                                                                <span class="d-block text-center">
                                                                                    <span
                                                                                        class="d-block fw-600 fs-12">{{ translate('Nagad') }}</span>
                                                                                </span>
                                                                            </span>
                                                                        </label>
                                                                    </div>
                                                                @endif
                                                                @if (get_setting('bkash') == 1)
                                                                    <div class="col-6 col-md-4">
                                                                        <label class="aiz-megabox d-block mb-3">
                                                                            <input value="bkash" class="online_payment"
                                                                                type="radio" name="payment_option" checked>
                                                                            <span class="d-block p-3 aiz-megabox-elem">
                                                                                <img src="{{ static_asset('assets/img/cards/bkash.png') }}"
                                                                                    class="img-fluid mb-2">
                                                                                <span class="d-block text-center">
                                                                                    <span
                                                                                        class="d-block fw-600 fs-12">{{ translate('Bkash') }}</span>
                                                                                </span>
                                                                            </span>
                                                                        </label>
                                                                    </div>
                                                                @endif
                                                                @if (get_setting('aamarpay') == 1)
                                                                    <div class="col-6 col-md-4">
                                                                        <label class="aiz-megabox d-block mb-3">
                                                                            <input value="aamarpay" class="online_payment"
                                                                                type="radio" name="payment_option" checked>
                                                                            <span class="d-block p-3 aiz-megabox-elem">
                                                                                <img src="{{ static_asset('assets/img/cards/aamarpay.png') }}"
                                                                                    class="img-fluid mb-2">
                                                                                <span class="d-block text-center">
                                                                                    <span
                                                                                        class="d-block fw-600 fs-12">{{ translate('Aamarpay') }}</span>
                                                                                </span>
                                                                            </span>
                                                                        </label>
                                                                    </div>
                                                                @endif
                                                                @if (get_setting('proxypay') == 1)
                                                                    <div class="col-6 col-md-4">
                                                                        <label class="aiz-megabox d-block mb-3">
                                                                            <input value="proxypay" class="online_payment"
                                                                                type="radio" name="payment_option" checked>
                                                                            <span class="d-block p-3 aiz-megabox-elem">
                                                                                <img src="{{ static_asset('assets/img/cards/proxypay.png') }}"
                                                                                    class="img-fluid mb-2">
                                                                                <span class="d-block text-center">
                                                                                    <span
                                                                                        class="d-block fw-600 fs-12">{{ translate('ProxyPay') }}</span>
                                                                                </span>
                                                                            </span>
                                                                        </label>
                                                                    </div>
                                                                @endif
                                                                @if (addon_is_activated('african_pg'))
                                                                    @if (get_setting('mpesa') == 1)
                                                                        <div class="col-6 col-md-4">
                                                                            <label class="aiz-megabox d-block mb-3">
                                                                                <input value="mpesa" class="online_payment"
                                                                                    type="radio" name="payment_option"
                                                                                    checked>
                                                                                <span class="d-block p-3 aiz-megabox-elem">
                                                                                    <img src="{{ static_asset('assets/img/cards/mpesa.png') }}"
                                                                                        class="img-fluid mb-2">
                                                                                    <span class="d-block text-center">
                                                                                        <span
                                                                                            class="d-block fw-600 fs-12">{{ translate('mpesa') }}</span>
                                                                                    </span>
                                                                                </span>
                                                                            </label>
                                                                        </div>
                                                                    @endif
                                                                    @if (get_setting('flutterwave') == 1)
                                                                        <div class="col-6 col-md-4">
                                                                            <label class="aiz-megabox d-block mb-3">
                                                                                <input value="flutterwave"
                                                                                    class="online_payment" type="radio"
                                                                                    name="payment_option" checked>
                                                                                <span class="d-block p-3 aiz-megabox-elem">
                                                                                    <img src="{{ static_asset('assets/img/cards/flutterwave.png') }}"
                                                                                        class="img-fluid mb-2">
                                                                                    <span class="d-block text-center">
                                                                                        <span
                                                                                            class="d-block fw-600 fs-12">{{ translate('flutterwave') }}</span>
                                                                                    </span>
                                                                                </span>
                                                                            </label>
                                                                        </div>
                                                                    @endif
                                                                    @if (get_setting('payfast') == 1)
                                                                        <div class="col-6 col-md-4">
                                                                            <label class="aiz-megabox d-block mb-3">
                                                                                <input value="payfast"
                                                                                    class="online_payment" type="radio"
                                                                                    name="payment_option" checked>
                                                                                <span class="d-block p-3 aiz-megabox-elem">
                                                                                    <img src="{{ static_asset('assets/img/cards/payfast.png') }}"
                                                                                        class="img-fluid mb-2">
                                                                                    <span class="d-block text-center">
                                                                                        <span
                                                                                            class="d-block fw-600 fs-12">{{ translate('payfast') }}</span>
                                                                                    </span>
                                                                                </span>
                                                                            </label>
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                                @if (addon_is_activated('paytm'))
                                                                    <div class="col-6 col-md-4">
                                                                        <label class="aiz-megabox d-block mb-3">
                                                                            <input value="paytm" class="online_payment"
                                                                                type="radio" name="payment_option" checked>
                                                                            <span class="d-block p-3 aiz-megabox-elem">
                                                                                <img src="{{ static_asset('assets/img/cards/paytm.jpg') }}"
                                                                                    class="img-fluid mb-2">
                                                                                <span class="d-block text-center">
                                                                                    <span
                                                                                        class="d-block fw-600 fs-12">{{ translate('Paytm') }}</span>
                                                                                </span>
                                                                            </span>
                                                                        </label>
                                                                    </div>
                                                                @endif
                                                                @if (get_setting('cash_payment') == 1)
                                                                    @php
                                                                        $digital = 0;
                                                                        $cod_on = 1;
                                                                        foreach ($carts as $cartItem) {
                                                                            $product = \App\Product::find($cartItem['product_id']);
                                                                            if ($product['digital'] == 1) {
                                                                                $digital = 1;
                                                                            }
                                                                            if ($product['cash_on_delivery'] == 0) {
                                                                                $cod_on = 0;
                                                                            }
                                                                        }
                                                                    @endphp
                                                                    {{-- @if ($digital != 1 && $cod_on == 1 && $total > 100) --}}
                                                                    <div class="col-6 col-md-4">
                                                                        <label class="aiz-megabox d-block mb-3">
                                                                            <input value="cash_on_delivery"
                                                                                class="online_payment" type="radio"
                                                                                name="payment_option" checked>
                                                                            <span class="d-block p-3 aiz-megabox-elem">
                                                                                <img src="{{ static_asset('assets/img/cards/cod.png') }}"
                                                                                    class="img-fluid mb-2">
                                                                                <span class="d-block text-center">
                                                                                    <span
                                                                                        class="d-block fw-600 fs-12">{{ translate('Cash on Delivery') }}</span>
                                                                                </span>
                                                                            </span>
                                                                        </label>
                                                                    </div>
                                                                    {{-- @endif --}}
                                                                @endif
                                                                @if (Auth::check())
                                                                    @if (addon_is_activated('offline_payment'))
                                                                        @foreach (\App\ManualPaymentMethod::all() as $method)
                                                                            <div class="col-6 col-md-4">
                                                                                <label class="aiz-megabox d-block mb-3">
                                                                                    <input value="{{ $method->heading }}"
                                                                                        type="radio" name="payment_option"
                                                                                        onchange="toggleManualPaymentData({{ $method->id }})"
                                                                                        data-id="{{ $method->id }}"
                                                                                        checked>
                                                                                    <span
                                                                                        class="d-block p-3 aiz-megabox-elem">
                                                                                        <img src="{{ uploaded_asset($method->photo) }}"
                                                                                            class="img-fluid mb-2">
                                                                                        <span class="d-block text-center">
                                                                                            <span
                                                                                                class="d-block fw-600 fs-12">{{ $method->heading }}</span>
                                                                                        </span>
                                                                                    </span>
                                                                                </label>
                                                                            </div>
                                                                        @endforeach

                                                                        @foreach (\App\ManualPaymentMethod::all() as $method)
                                                                            <div id="manual_payment_info_{{ $method->id }}"
                                                                                class="d-none">
                                                                                @php echo $method->description @endphp
                                                                                @if ($method->bank_info != null)
                                                                                    <ul>
                                                                                        @foreach (json_decode($method->bank_info) as $key => $info)
                                                                                            <li>{{ translate('Bank Name') }}
                                                                                                - {{ $info->bank_name }},
                                                                                                {{ translate('Account Name') }}
                                                                                                -
                                                                                                {{ $info->account_name }},
                                                                                                {{ translate('Account Number') }}
                                                                                                -
                                                                                                {{ $info->account_number }},
                                                                                                {{ translate('Routing Number') }}
                                                                                                -
                                                                                                {{ $info->routing_number }}
                                                                                            </li>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                @endif
                                                                            </div>
                                                                        @endforeach
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @if (addon_is_activated('offline_payment'))
                                                        <div class="bg-white border mb-3 p-3 rounded text-left d-none">
                                                            <div id="manual_payment_description">

                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if (Auth::check() && get_setting('wallet_system') == 1)
                                                        <div class="separator mb-3">
                                                            <span class="bg-white px-3">
                                                                <span
                                                                    class="opacity-60">{{ translate('Or') }}</span>
                                                            </span>
                                                        </div>
                                                        <div class="text-center py-4">
                                                            <div class="h6 mb-3">
                                                                <span
                                                                    class="opacity-80">{{ translate('Your wallet balance :') }}</span>
                                                                <span
                                                                    class="fw-600">{{ single_price(Auth::user()->balance) }}</span>
                                                            </div>
                                                            @if (Auth::user()->balance < $total)
                                                                <button type="button" class="btn btn-secondary" disabled>
                                                                    {{ translate('Insufficient balance') }}
                                                                </button>
                                                            @else
                                                                <button type="button" onclick="use_wallet()"
                                                                    class="btn btn-primary fw-600">
                                                                    {{ translate('Pay with wallet') }}
                                                                </button>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="pt-0 pt-md-3 fs-11">
                                                <label class="aiz-checkbox">
                                                    <input type="checkbox" checked required id="agree_checkbox">
                                                    <span class="aiz-square-check"></span>
                                                    <span>{{ translate('I agree to the') }}</span>
                                                </label>
                                                <a
                                                    href="{{ route('terms') }}">{{ translate('terms and conditions') }}</a>,
                                                <a
                                                    href="{{ route('returnpolicy') }}">{{ translate('return policy') }}</a>
                                                &
                                                <a
                                                    href="{{ route('privacypolicy') }}">{{ translate('privacy policy') }}</a>
                                            </div>

                                            <div class="row align-items-center py-3">
                                                <div class="col-0 col-md-6 d-none d-md-block">
                                                    <a href="" onclick="showAddress()" class="link link--style-3">
                                                        <i class="las la-arrow-left"></i>
                                                        {{ translate('Return to address') }}
                                                    </a>
                                                </div>
                                                <div class="col-12 col-md-12 text-center" style="text-align-left:center;">
                                                    <button type="button" onclick="submitOrder(this)"
                                                        class="btn btn-dark fw-600">{{ translate('Complete Order') }}</button>
                                                </div>
                                                <div class="col-12 mt-3 text-center col-md-0 dblock d-md-none">
                                                    <a href="" onclick="showAddress()" class="link link--style-3">
                                                        <i class="las la-arrow-left"></i>
                                                        {{ translate('Return to address') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    {{-- Payment Gateways --}}
                                </div>
                                @if (Auth::check())
                                    <div class="row billing-shipping-form pb-4" id="shipping_address_section">
                                        @include('frontend.partials.shippingAddress')
                                    </div>
                                @else
                                    <div class="row billing-shipping-form pb-4" id="shipping_address_section">
                                    </div>
                                    <div class="row billing-shipping-form py-4" id="loggin_section">
                                        <div class="col-12 px-2">
                                            <div class="row mx-0 py-4 px-2">
                                                <div class="col-6">
                                                    <p class="custom-text font-weight-bolder text-uppercase heading-text">
                                                        Guest Detail</p>
                                                </div>
                                            </div>
                                        </div>
                                        <form id="reg-form" class="form-default" role="form">
                                            @csrf
                                            <div class="form-group">
                                                <input type="text"
                                                    class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                    value="{{ old('name') }}"
                                                    placeholder="{{ translate('Full Name') }}" name="name">
                                                @if ($errors->has('name'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            @if (addon_is_activated('otp_system'))
                                                <div class="form-group phone-form-group mb-1" style="display:none;">
                                                    <input type="hidden" id="phone-code"
                                                        class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                                        value="{{ old('phone') }}" placeholder="" name="phone"
                                                        autocomplete="off">
                                                </div>

                                                <input type="hidden" name="country_code" value="">

                                                <div class="form-group email-form-group mb-1 d-none">
                                                    <input type="email"
                                                        class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                        value="{{ old('email') }}"
                                                        placeholder="{{ translate('Email') }}" name="email"
                                                        autocomplete="off">
                                                    @if ($errors->has('email'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="form-group text-right">
                                                    <button class="btn btn-link p-0 opacity-50 text-reset" type="button"
                                                        onclick="toggleEmailPhone(this)">{{ translate('Use Email Instead') }}</button>
                                                </div>
                                            @else
                                                <div class="form-group phone-form-group" style="display:none;">
                                                    <input type="hidden" id="phone-code"
                                                        class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                                        value="{{ old('phone') }}" placeholder="" name="phone"
                                                        autocomplete="off" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="email"
                                                        class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                        value="{{ old('email') }}"
                                                        placeholder="{{ translate('Email') }}" name="email" required>
                                                    @if ($errors->has('email'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            @endif
                                            @if (get_setting('google_recaptcha') == 1)
                                                <div class="form-group">
                                                    <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_KEY') }}">
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="mb-5">
                                                <button type="button" id="guest_login_btn"
                                                    class="btn btn-dark btn-block fw-600">{{ translate('Continue') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>


                </div>

                <!-- products cards which will show the final products and the grand total with all the data-processing -->
                <div class="col-md-4 p-0 px-0 px-md-4 my-4 my-md-0 pb-4">
                    <div class="card mx-0 mx-md-4 border-0 rounded-0 shadow w-100 sticky-top" id="cart_summary"
                        style="z-index: 1!important;">
                        @include('frontend.partials.cart_summary')
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
@section('modal')
    <div class="modal" id="new-address-modal" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-zoom" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">{{ translate('New Address') }}</h6>
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
                                    <label>{{ translate('Address') }}</label>
                                </div>
                                <div id="type-selector" class="pac-controls d-none">
                                    <input type="radio" name="type" id="changetype-all" checked="checked" />
                                    <label for="changetype-all">All</label>

                                    <input type="radio" name="type" id="changetype-establishment" />
                                    <label for="changetype-establishment">establishment</label>

                                    <input type="radio" name="type" id="changetype-address" />
                                    <label for="changetype-address">address</label>

                                    <input type="radio" name="type" id="changetype-geocode" />
                                    <label for="changetype-geocode">geocode</label>

                                    <input type="radio" name="type" id="changetype-cities" />
                                    <label for="changetype-cities">(cities)</label>

                                    <input type="radio" name="type" id="changetype-regions" />
                                    <label for="changetype-regions">(regions)</label>
                                </div>
                                <div id="strict-bounds-selector" class="pac-controls d-none">
                                    <input type="checkbox" id="use-location-bias" value="" checked />
                                    <label for="use-location-bias">Bias to map viewport</label>

                                    <input type="checkbox" id="use-strict-bounds" value="" />
                                    <label for="use-strict-bounds">Strict bounds</label>
                                </div>
                                <div class="col-md-10" id="pac-container">
                                    <textarea class="form-control textarea-autogrow mb-3" placeholder="{{ translate('Your Address') }}" id="pac-input"
                                        rows="1" name="address" required></textarea>
                                </div>
                                <div id="infowindow-content">
                                    <span id="place-name" class="title"></span><br />
                                    <span id="place-address"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ translate('Country') }}</label>
                                </div>
                                <div class="col-md-10">
                                    <select class="form-control mb-3 aiz-selectpicker" data-live-search="true"
                                        name="country" required>
                                        <option value="India">India</option>
                                        @foreach (\App\Country::where('status', 1)->get() as $key => $country)
                                            <option value="{{ $country->name }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ translate('Pincode') }}</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="number" class="form-control mb-3 add-pincode"
                                        placeholder="{{ translate('Pincode') }}" name="postal_code" value="" required
                                        maxlength="6" minlength="6"
                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                    <small class="text-danger custom-text pincodeError" style="display: none;">Zip code
                                        must be of 6 digits only</small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ translate('State') }}</label>
                                </div>
                                <div class="col-md-10">
                                    <input class="form-control mb-3" placeholder="{{ translate('state') }}" name="state"
                                        required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ translate('City') }}</label>
                                </div>
                                <div class="col-md-10">
                                    <input class="form-control mb-3" placeholder="{{ translate('City') }}" name="city"
                                        required />
                                </div>
                            </div>

                            @if (get_setting('google_map') == 1)
                                <div class="row">
                                    <input id="searchInput" class="controls" type="text"
                                        placeholder="{{ translate('Enter a location') }}">
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
                                        <input type="text" class="form-control mb-3" id="longitude" name="longitude"
                                            readonly="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2" id="">
                                        <label for="exampleInputuname">Latitude</label>
                                    </div>
                                    <div class="col-md-10" id="">
                                        <input type="text" class="form-control mb-3" id="latitude" name="latitude"
                                            readonly="">
                                    </div>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ translate('Phone') }}</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" maxlength="10" minlength="10" onkeypress="phoneno()"
                                        title="Please enter valid phone number without +91 or 0." class="form-control"
                                        placeholder="{{ translate('Enter 10 digit phone number') }}" id="phone-code"
                                        name="phone" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="edit-address-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap&libraries=places&v=weekly" async>
    </script>
    @php
	$cart_items = [];
	foreach ($carts as $index => $item) {
		$cart_items[] = [            
			'item_id' => $item->product_id,
			'item_name' => DB::table('products')->where('id', $item->product_id)->pluck('name')->first(),
			'affiliation' => 'Google Merchandise Store',
			'coupon' => '',
			'currency' => 'INR',
			'discount' => 0,
			'index' => $index,
			'item_brand' => 'Sadar24',            
			'item_category' => DB::table('categories')->where('id',DB::table('products')->where('id', $item->product_id)->pluck('category_id')->first(),)->pluck('name')->first(),
			'item_category2'=> DB::table('categories')->where('id',DB::table('products')->where('id', $item->product_id)->pluck('category_id')->first(),)->pluck('name')->first(),
			'item_category3'=> DB::table('categories')->where('id',DB::table('products')->where('id', $item->product_id)->pluck('category_id')->first(),)->pluck('name')->first(),
			'item_category4'=> DB::table('categories')->where('id',DB::table('products')->where('id', $item->product_id)->pluck('category_id')->first(),)->pluck('name')->first(),
			'item_category5'=> DB::table('categories')->where('id',DB::table('products')->where('id', $item->product_id)->pluck('category_id')->first(),)->pluck('name')->first(),
			'item_list_id' => $item->product_id,
			'item_list_name' => DB::table('products')->where('id', $item->product_id)->pluck('name')->first(),
			'item_variant' => $item->variation,
			'location_id' => $index,
			'price' => $item->price,
			'quantity' => $item->quantity,
		];
	}
    @endphp
    {{-- gtag begin checkout tag --}}
    <script>
        $(document).ready(function() {
            wigzo("track", "checkoutstarted");
        });

        gtag('event', 'begin_checkout', {
            currency: "INR",
            value: {{$total}},
            coupon: "",
            "items": <?php echo json_encode($cart_items); ?>
        });

        // This example requires the Places library. Include the libraries=places
        // parameter when you first load the API. For example:
        // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
        function initMap() {
            const map = new google.maps.Map(document.getElementById("map"), {
                center: {
                    lat: 40.749933,
                    lng: -73.98633
                },
                zoom: 13,
                mapTypeControl: false,
            });
            const card = document.getElementById("pac-card");
            const input = document.getElementById("pac-input");
            const biasInputElement = document.getElementById("use-location-bias");
            const strictBoundsInputElement = document.getElementById("use-strict-bounds");
            const options = {
                fields: ["formatted_address", "geometry", "name"],
                strictBounds: false,
                types: ["establishment"],
            };

            map.controls[google.maps.ControlPosition.TOP_LEFT].push(card);

            const autocomplete = new google.maps.places.Autocomplete(input, options);

            // Bind the map's bounds (viewport) property to the autocomplete object,
            // so that the autocomplete requests use the current map bounds for the
            // bounds option in the request.
            autocomplete.bindTo("bounds", map);

            const infowindow = new google.maps.InfoWindow();
            const infowindowContent = document.getElementById("infowindow-content");

            infowindow.setContent(infowindowContent);

            const marker = new google.maps.Marker({
                map,
                anchorPoint: new google.maps.Point(0, -29),
            });

            autocomplete.addListener("place_changed", () => {
                infowindow.close();
                marker.setVisible(false);

                const place = autocomplete.getPlace();

                if (!place.geometry || !place.geometry.location) {
                    // User entered the name of a Place that was not suggested and
                    // pressed the Enter key, or the Place Details request failed.
                    window.alert("No details available for input: '" + place.name + "'");
                    return;
                }

                // If the place has a geometry, then present it on a map.
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }

                marker.setPosition(place.geometry.location);
                marker.setVisible(true);
                infowindowContent.children["place-name"].textContent = place.name;
                infowindowContent.children["place-address"].textContent =
                    place.formatted_address;
                infowindow.open(map, marker);
            });

            // Sets a listener on a radio button to change the filter type on Places
            // Autocomplete.
            function setupClickListener(id, types) {
                const radioButton = document.getElementById(id);

                radioButton.addEventListener("click", () => {
                    autocomplete.setTypes(types);
                    input.value = "";
                });
            }

            setupClickListener("changetype-all", []);
            setupClickListener("changetype-address", ["address"]);
            setupClickListener("changetype-establishment", ["establishment"]);
            setupClickListener("changetype-geocode", ["geocode"]);
            setupClickListener("changetype-cities", ["(cities)"]);
            setupClickListener("changetype-regions", ["(regions)"]);
            biasInputElement.addEventListener("change", () => {
                if (biasInputElement.checked) {
                    autocomplete.bindTo("bounds", map);
                } else {
                    // User wants to turn off location bias, so three things need to happen:
                    // 1. Unbind from map
                    // 2. Reset the bounds to whole world
                    // 3. Uncheck the strict bounds checkbox UI (which also disables strict bounds)
                    autocomplete.unbind("bounds");
                    autocomplete.setBounds({
                        east: 180,
                        west: -180,
                        north: 90,
                        south: -90
                    });
                    strictBoundsInputElement.checked = biasInputElement.checked;
                }

                input.value = "";
            });
            strictBoundsInputElement.addEventListener("change", () => {
                autocomplete.setOptions({
                    strictBounds: strictBoundsInputElement.checked,
                });
                if (strictBoundsInputElement.checked) {
                    biasInputElement.checked = strictBoundsInputElement.checked;
                    autocomplete.bindTo("bounds", map);
                }

                input.value = "";
            });
        }

        $(document).ready(function() {
            $(".online_payment").click(function() {
                $('#manual_payment_description').parent().addClass('d-none');
            });
            toggleManualPaymentData($('input[name=payment_option]:checked').data('id'));
        });

        function showAddress() {
            $('.online_payment').hide();
            $('.billing-shipping-form').hide();
            $('.payment-options').show();
            $(".bef-pay-hide").show();
            document.body.scrollTop = 0; // For Safari
            document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
        }

        function showPayment(e) {

            // checking form valiations before showing payment options
            var d = $("#delivery_info").serialize();
            //$(".overlay").show();
            // console.log(d);
            $.ajax({
                type: "POST",
                url: "{{ route('checkout.store_delivery_info') }}",
                data: d,
                // dataType: "dataType",
                success: function(response) {
                    // console.log(response.status);
                    if (response.status == 1) {
                        var f = $("#submit_shipping_info").serialize();
                        // console.log(f);
                        $.ajax({
                            type: "GET",
                            url: "{{ route('checkout.store_shipping_infostore') }}",
                            data: f,
                            // dataType: "dataType",
                            success: function(response) {
                                // console.log(response);
                                if (response.status == 1) {
                                    $(".bef-pay-hide").hide();
                                    $('.billing-shipping-form').hide();
                                    $('.payment-options').show();
                                    document.body.scrollTop = 0; // For Safari
                                    document.documentElement.scrollTop =
                                        0; // For Chrome, Firefox, IE and Opera
                                    // //$(".overlay").hide();
                                } else {

                                }
                            }
                        });
                    } else {

                    }
                }
            });

        }

        function use_wallet() {
            $('input[name=payment_option]').val('wallet');
            if ($('#agree_checkbox').is(":checked")) {
                $('#checkout-form').submit();
                //$(".overlay").show();
            } else {
                AIZ.plugins.notify('danger', '{{ translate('You need to agree with our policies') }}');
            }
        }

        function submitOrder(el) {
            $(el).prop('disabled', true);
            if ($('#agree_checkbox').is(":checked")) {
                $('#checkout-form').submit();
                //$(".overlay").show();
            } else {
                AIZ.plugins.notify('danger', '{{ translate('You need to agree with our policies') }}');
                $(el).prop('disabled', false);
            }
        }

        function toggleManualPaymentData(id) {
            if (typeof id != 'undefined') {
                $('#manual_payment_description').parent().removeClass('d-none');
                $('#manual_payment_description').html($('#manual_payment_info_' + id).html());
            }
        }
        $(document).ready(function() {
            $(".add-pincode").keyup(function(e) {
                var e = $(".add-pincode").val();
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
                            // console.log(response[0].PostOffice[0]);
                            $("input[name='city']").val(response[0].PostOffice[0].District);
                            $("input[name='state']").val(response[0].PostOffice[0].State);
                        }
                    });
                }
            });
        });

        $(document).on("click", "#coupon-apply", function() {
            var data = new FormData($('#apply-coupon-form')[0]);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: "{{ route('checkout.apply_coupon_code') }}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data, textStatus, jqXHR) {
                    AIZ.plugins.notify(data.response_message.response, data.response_message.message);
                    //                    console.log(data.response_message);
                    $("#cart_summary").html(data.html);
                }
            });
        });

        $(document).on("click", "#coupon-remove", function() {
            var data = new FormData($('#remove-coupon-form')[0]);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: "{{ route('checkout.remove_coupon_code') }}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data, textStatus, jqXHR) {
                    $("#cart_summary").html(data);
                }
            });
        });

        $(document).ready(function() {
            $("#guest_login_btn").click(function() {
                // e.preventDefault();
                if ($("input[name='name']").val() != "" && $("input[name='email']") != "") {
                    //// $(".overlay").show();
                    var form = $("#reg-form").serialize();
                    var url = "{{ route('user.checkoutGuestRegister') }}";
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: form,
                        // dataType: "dataType",
                        success: function(response) {
                            // console.log("{{ Auth::user() }}");
                            // $("#shipping_address_section").reload();
                            $("#loggin_section").hide();
                            $("#shipping_address_section").html(response.shipping_address);
                            $("#cart_summary").html(response.summary);
                            updateNavCart(response.nav_cart_view, response.cart_count);
                            $("#loggin_section").html("");
                            //$(".overlay").hide();
                        }
                    });
                } else {
                    Swal.fire(
                        '',
                        'Name And Email Field Is Required!',
                        'question'
                    )
                    // Swal.fire('');
                }
            });

            $("selector").click(function(e) {
                e.preventDefault();

            });
        });

        function loginRegisterBtn() {
            $('.slide-me-down').slideToggle(1000);
        }

        function edit_address(address) {
            var url = '{{ route('addresses.edit', ':id') }}';
            url = url.replace(':id', address);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: 'GET',
                success: function(response) {
                    $('#edit_modal_body').html(response.html);
                    $('#edit-address-modal').modal('show');
                    AIZ.plugins.bootstrapSelect('refresh');

                    var country = $("#edit_country").val();
                    get_city(country);

                    @if (get_setting('google_map') == 1)
                        var lat = -33.8688;
                        var long = 151.2195;

                        if (response.data.address_data.latitude && response.data.address_data.longitude) {
                            lat = parseFloat(response.data.address_data.latitude);
                            long = parseFloat(response.data.address_data.longitude);
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
                url: "{{ route('get-city') }}",
                type: 'POST',
                data: {
                    country_name: country
                },
                success: function(response) {
                    var obj = JSON.parse(response);
                    if (obj != '') {
                        $('[name="city"]').html(obj);
                        AIZ.plugins.bootstrapSelect('refresh');
                    }
                }
            });
        }

        function add_new_address() {
            $('#new-address-modal').modal('show');
        }
        $("#continue_di").click(function() {
            if ($('input[name=address_id]:checked').length > 0) {

            }
        });

        function phoneno() {
            $('#phone-code').keypress(function(e) {
                var a = [];
                var k = e.which;

                for (i = 48; i < 58; i++)
                    a.push(i);

                if (!(a.indexOf(k) >= 0))
                    e.preventDefault();
            });
        }

        document.querySelector('.add-pincode').addEventListener('input', function() {
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
    </script>
    @if (get_setting('google_map') == 1)
        @include('frontend.partials.google_map')
    @endif
@endsection
