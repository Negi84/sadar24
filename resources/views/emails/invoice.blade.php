<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <meta http-equiv="Content-Type" content="text/html;" />
    <meta charset="UTF-8">
    <style media="all">
        @font-face {
            font-family: 'Roboto';
            src: url("{{ static_asset('fonts/Roboto-Regular.ttf') }}") format("truetype");
            font-weight: normal;
            font-style: normal;
        }

        * {
            margin: 0;
            padding: 0;
            line-height: 1.3;
            font-family: 'Roboto';
			font-weight: bold;
            color: black;
        }

        body {
            font-size: .875rem;
        }

        .gry-color *,
        .gry-color {
            color: #878f9c;
        }

        table {
            width: 100%;
        }

        table th {
            font-weight: normal;
        }

        table.padding th {
            padding: .5rem .7rem;
        }

        table.padding td {
            padding: .7rem;
        }

        table.sm-padding td {
            padding: .2rem .7rem;
        }

        .border-bottom td,
        .border-bottom th {
            border-bottom: 1px solid #eceff4;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .small {
            font-size: .85rem;
        }

        .currency {}

        #ship_det>tr>td {
            margin: 0px;
            width: 30%;
            border-left: 2px solid whitesmoke;
            padding: 5px;
			vertical-align:top;
			background-color: #232F3E;

        }

		.text-white{
			color:white!important;
		}
    </style>
</head>

<body>
    <div>
        @php
            $logo = get_setting('header_logo');
            $inv = '';
        @endphp
        <div style="    background: #131921;
  padding: 10px 20px;
  border-bottom: 5px solid whitesmoke;">
            <table>
                <tr>
                    <td>
                        <img src="https://sadar24.com/public/uploads/all/idE2ZcXje5TXUNjFNP7MipsKtzrXhIaAFt91qoe2.png""
                            height="60" style="display:inline-block;">
                    </td>
                    <td style="font-size: 1.5rem;" class="text-right strong">{{ $inv }}</td>

                </tr>
            </table>


        </div>

        <div style="padding: 13px;">
            @php
                $shipping_address = json_decode($order->shipping_address);
                $seller = \App\Seller::where('user_id', $order->seller_id)->first();
                $seller_details = $seller->user->shop;
            @endphp

            <table>
                <tbody id="ship_det">
                    <tr>
                        <td>
                            <table>
                                <tbody>
                                    <tr>
                                        <td style="font-size: 1.4rem; font-weight:bold;" class="strong text-white">SOLD BY
                                            :</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 1rem;" class="strong text-white">{{ $seller_details->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="small text-white">{{ $seller_details->address }},
                                            {{ $seller_details->city }},
                                            {{ $seller_details->state }}, {{ $seller_details->country }}</td>
                                    </tr>
                                    <tr>
                                        <td class="small text-white">{{ translate('Pan Number') }}:
                                            {{ $seller_details->pan_number }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="small text-white">{{ translate('GST Number') }}:
                                            {{ $seller_details->gst_number }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td>
                            <table>
                                <tbody>
                                    <tr>
										<td style="font-size: 1.4rem; font-weight:bold;" class="strong text-white">BILLED TO
                                            :</td>
                                    </tr>
                                    <tr>
                                        <td class="text-white">{{ $shipping_address->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="small text-white">{{ $shipping_address->address }},
                                            {{ $shipping_address->city }},
                                            {{ $shipping_address->country }}</td>
                                    </tr>
                                    <tr>
                                        <td class="small text-white"> {{ $shipping_address->city }},
                                            {{ $shipping_address->state }},
                                            {{ $shipping_address->postal_code }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td>
                            <table>
                                <tbody>
                                    <tr>
										<td style="font-size: 1.4rem; font-weight:bold;" class="strong text-white">SHIPPED TO
                                            :</td>
                                    </tr>
                                    <tr>
                                        <td class="text-white">{{ $shipping_address->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="small text-white">{{ $shipping_address->address }},
                                            {{ $shipping_address->city }},
                                            {{ $shipping_address->state }}, {{ $shipping_address->country }}</td>
                                    </tr>
                                    <tr>
                                        <td class="small text-white"> {{ $shipping_address->city }},
                                            {{ $shipping_address->postal_code }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="padding: 1rem;padding-bottom: 0">
            <table>
                @php
                    $orignalorder = $order->getOriginal();
                    
                @endphp

                <tr>
                    <td class="gry-color small"><span class="gry-color small">Order Number:</span> <span
                            class="strong">{{ $order->code }}</span></td>
                    {{-- <td class="text-right small"><span class="gry-color small"></span> <span
                            class="strong">{{ $order->code }}</span></td> --}}
                </tr>
                <tr>
                    <td class="gry-color small"><span class="gry-color small">Order Date:</span> <span
                            class=" strong">{{ date('d-m-Y', $order->date) }}</span></td>
                    {{-- <td class="text-right small"><span class="gry-color small"></span> <span
                            class=" strong">{{ date('d-m-Y', $order->date) }}</span></td> --}}
                </tr>
                <tr>
                    <td class="strong  gry-color"><span class="gry-color small">Payment Method:</span> <span
                            class="strong">{{ $order->payment_type }}</span></td>
                    <td class="strong text-right  gry-color"></td>
                </tr>
                <tr>
                    <td class="strong  gry-color"><span class="gry-color small">Payment Status:</span> <span
                            class="strong">{{ $order->payment_status }}</span></td>
                    <td class="strong text-right  gry-color"></td>
                </tr>
            </table>
        </div>
		<div style="padding: 1rem;padding-bottom: 0">
            <table>
                @php
                    $order_test = json_decode($order);
                    $shipping_address = json_decode($order->shipping_address);
                    $order->payment_type = str_replace('_', ' ', $order->payment_type);
                    $orignalorder = $order->getOriginal();
                    
                @endphp
                <tr>
                    <td class="gry-color small"></td>
                    <td class="text-left">{{ translate('Place of Delivery') }}:
                        {{ $shipping_address->state }}</td>
                </tr>
                <tr>
                    <td class="gry-color small"></td>
                    <td class="text-left">{{ translate('Place of Supply') }}: {{ $shipping_address->state }}
                    </td>
                </tr>
            </table>
        </div>
        @php
            $order_test = json_decode($order);
            $shipping_address = json_decode($order->shipping_address);
            $address_state = '';
            $vendor_state = '';
            $order->payment_type = str_replace('_', ' ', $order->payment_type);
            $seller = \App\Seller::where('user_id', $order->seller_id)->first();
            $seller_details = $seller->user->shop;
            $address_state = $seller_details->state;
            
        @endphp

        <div style="padding: 1.5rem;">
            <table class="padding text-left small border-bottom" >
                <thead>
                    <tr class="text-white" style="background: #c2151b;">
                        <th width="26%" class="text-center text-white">{{ translate('Product Name') }}</th>
                        {{-- <th width="12%" class="text-center text-white">{{ translate('Unit Price') }}</th> --}}
                        <th width="7%" class="text-center text-white">{{ translate('Qty') }}</th>
                        <th width="12%" class="text-center text-white">{{ translate('Net Amount') }}</th>
                        <th width="8%" class="text-center text-white">{{ translate('Tax') }}</th>
                        <th width="10%" class="text-center text-white">{{ translate('Tax Type') }}</th>
                        <th width="10%" class="text-center text-white">{{ translate('Tax Amount') }}</th>
                        <th width="15%" class="text-right text-white">{{ translate('Total') }}</th>
                    </tr>
                </thead>
                <tbody class="strong">
                    @foreach ($order->orderDetails as $key => $orderDetail)
                        @if ($orderDetail->product != null)
                            @php
                                $product_id = $orderDetail->product->id;
                                $product = \App\Product::select('category_id', 'user_id')
                                    ->where('id', $product_id)
                                    ->first();
                                $category_id = $product->category_id;
                                $category = \App\Category::select('gst')
                                    ->where('id', $category_id)
                                    ->first();
                                $gstper = $category->gst;
                                $orignal_price = $orderDetail->price;
                                $gstval = $orignal_price - $orignal_price * (100 / (100 + $gstper));
                                $unit_price = $orignal_price - $gstval;
                                $gst_tax = $gstval;
                                $vendor_id = $product->user_id;
                                
                                $vendor = \App\User::select('state')
                                    ->where('id', $vendor_id)
                                    ->first();
                                $vendor_state = $vendor->state;
                                $orderDetail->tax = ($orderDetail->shipping_cost * $gstper) / 100;
                            @endphp
                            <tr class="">
                                <td>{{ $orderDetail->product->name }} @if ($orderDetail->variation != null)
                                        ({{ $orderDetail->variation }})
                                    @endif
                                </td>
                                {{-- <td class="currency">{{ single_price($unit_price / $orderDetail->quantity) }} --}}
                                </td>
                                <td class="">{{ $orderDetail->quantity }}</td>
                                <td class="currency">{{ single_price($unit_price) }}</td>

                                @if (strtolower($address_state) == strtolower($vendor_state))
                                    <td class="currency text-center">{{ $gstper / 2 }}% <br /> {{ $gstper / 2 }}%
                                    </td>
                                    <td class="currency text-center" colspan="1">
                                        {{ translate('SGST') }}
                                        <br />
                                        {{ translate('CGST') }}
                                    </td>

                                    <td class="currency text-center" colspan="1">
                                        {{ single_price($gst_tax / 2) }}
                                        <br />
                                        {{ single_price($gst_tax / 2) }}
                                    </td>

                                @else
                                    <td class="currency text-center">{{ $gstper }}%</td>
                                    <td class="currency text-center">
                                        {{ translate('IGST') }}
                                    </td>
                                    <td class="currency text-center">
                                        {{ single_price($gst_tax) }}
                                    </td>
                                @endif
                                </td>
                                <td class="text-right currency">{{ single_price($orderDetail->price) }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        @php
            $subtotal = $order->orderDetails->sum('price');
            $shiping_cost = $subtotal * 0;
            $shipping_tax = $shiping_cost * 0;
            $order->grand_total = $subtotal + $shiping_cost + $shipping_tax;
            //$f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
            $round_of_amount = number_format((float) $order->grand_total, 0, '.', '');
        @endphp
        <div style="padding:0 1.5rem;">
			<div style="background-color: #c2151b;width: 60% !important; float:left;">
				<div
					style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">

					<table style="font-family:'Lato',sans-serif;" role="presentation"
						width="100%" cellspacing="0" cellpadding="0" border="0">
						<tbody>
							<tr>
								<td style="overflow-wrap:break-word;word-break:break-word;padding:30px 20px;font-family:'Lato',sans-serif;"
									align="left">

									<div
										style="color: #ffffff; line-height: 140%; text-align: justify; word-wrap: break-word;">
										<p style="font-size: 14px; line-height: 140%;" class="text-white">To ensure
											your safety, the delivery agent will drop the
											package at your doorstep, ring the doorbell and then
											move back 2 meters while waiting for you to collect
											your package.</p>
										<p style="font-size: 14px; line-height: 140%;">&nbsp;
										</p>
										<p style="font-size: 14px; line-height: 140%;" class="text-white">Happy
											Shopping</p>
										<p style="font-size: 14px; line-height: 140%;"><a
												href="https://sadar24.com/"
												style="color: #fff;text-decoration: none;">Sadar24.com
											</a></p>
										<p style="font-size: 14px; line-height: 140%;" class="text-white">
											7800-708-708</p>
										<p
											style="font-size: 14px; line-height: 140%;color: #fff;">
											customercare@sadar24.com</p>
										<p
											style="font-size: 14px; line-height: 140%;/*! position: absolute; */text-align: right;">
											<a href="#" target="_blank"
												class="d-inline-block mr-3 ml-0"
												style="margin-right: 10px;">
												<img src="https://sadar24.com/public/assets/img/play.png"
													class="mx-100 h-40px"
													style="height: 40px;">
											</a>
											<a href="#" target="_blank" class="d-inline-block">
												<img src="https://sadar24.com/public/assets/img/app.png"
													class="mx-100 h-40px"
													style="height: 40px;">
											</a>
										</p>

									</div>

								</td>
							</tr>
						</tbody>
					</table>

				</div>
			</div>
            <table style="width: 40%; background-color:#232F3E; float:right; padding:10px;" class="text-right sm-padding small strong">
                <tbody>
                    <tr>
                        <th class="text-white text-left">{{ translate('Sub Total') }}</th>
                        <td class="currency text-white">{{ single_price($order->orderDetails->sum('price')) }}</td>
                    </tr>
                    <tr>
                        <th class="text-white text-left">{{ translate('Shipping Cost') }}</th>
                        <td class="currency text-white">{{ single_price($shiping_cost) }}</td>
                    </tr>
                    @if (strtolower($address_state) == strtolower($vendor_state))
                        <tr class="border-bottom">
                            <th class="text-white text-left">{{ translate('SGST') }}</th>
                            <td class="currency text-white">{{ single_price($shipping_tax / 2) }}</td>
                        </tr>
                        <tr class="border-bottom">
                            <th class="text-white text-left">{{ translate('CGST') }}</th>
                            <td class="currency text-white">{{ single_price($shipping_tax / 2) }}</td>
                        </tr>


                    @else
                        <tr class="border-bottom">
                            <th class="text-white text-left">{{ translate('IGST') }}</th>
                            <td class="currency text-white">{{ single_price($shipping_tax) }}</td>
                        </tr>
                    @endif

                    <tr class="border-bottom">
                        <th class="text-white text-left">{{ translate('Coupon Discount') }}</th>
                        <td class="currency text-white">{{ single_price($order->coupon_discount) }}</td>
                    </tr>
                    @if ($order->payment_type == "razorpay")
                    <tr>
                        <td>
                            <strong class="text-muted text-left">{{translate('Online Discount')}} :</strong>
                        </td>
                         <td class="currency text-white">{{ single_price(20) }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th class="text-left strong text-white">{{ translate('Grand Total') }}</th>
                        <td class="currency text-white">{{ single_price($order->grand_total) }}</td>
                    </tr>
                    <tr>
                        <th class="text-left strong text-white">{{ translate('Round Off Amount') }}</th>
                        <td class="currency text-white">{{ single_price($round_of_amount) }}</td>
                    </tr>
                    <tr>
                        <td class="text-right strong text-white" colspan="2"><br /><br />{{ $seller_details->name }}
                            <br /><br /><br />
                        </td>

                    </tr>
                    <tr>

                        <td class="text-right strong text-white" colspan="2">
                            {{ translate('Authorized Signatory') }}<br /><br />
                        </td>
                    </tr>
                </tbody>
            </table>
            <hr />
            {{ translate('Declaration : The goods sold as part of this shipment are intended for end-user consumption and not for retail sale.') }}
        </div>

    </div>
    {{-- {{ dd('hell') }} --}}
</body>

</html>
