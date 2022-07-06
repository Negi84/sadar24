<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <meta http-equiv="Content-Type" content="text/html;" />
    <meta charset="UTF-8">

    <style type="text/css">
        table,
        td {
            color: #000000;
        }

        @media only screen and (min-width: 620px) {
            .u-row {
                width: 600px !important;
            }

            .u-row .u-col {
                vertical-align: top;
            }

            .u-row .u-col-33p33 {
                width: 199.98px !important;
            }

            .u-row .u-col-50 {
                width: 300px !important;
            }

            .u-row .u-col-66p67 {
                width: 400.02px !important;
            }

            .u-row .u-col-100 {
                width: 600px !important;
            }

        }

        @media (max-width: 620px) {
            .u-row-container {
                max-width: 100% !important;
                padding-left: 0px !important;
                padding-right: 0px !important;
            }

            .u-row .u-col {
                min-width: 320px !important;
                max-width: 100% !important;
                display: block !important;
            }

            .u-row {
                width: calc(100% - 40px) !important;
            }

            .u-col {
                width: 100% !important;
            }

            .u-col>div {
                margin: 0 auto;
            }
        }

        body {
            margin: 0;
            padding: 0;
        }

        table,
        tr,
        td {
            vertical-align: top;
            border-collapse: collapse;
        }

        p {
            margin: 0;
        }

        .ie-container table,
        .mso-container table {
            table-layout: fixed;
        }

        * {
            line-height: inherit;
        }

        a[x-apple-data-detectors='true'] {
            color: inherit !important;
            text-decoration: none !important;
        }

    </style>
</head>

<body class="clean-body u_body"
    style="margin: 0;padding: 0;-webkit-text-size-adjust: 100%;background-color: #fff;color: #000000">
    @php
        $shipping_address = json_decode($order->shipping_address);
        
        $subtotal = $order->orderDetails->sum('price');
        $shiping_cost = $subtotal * 0;
        $shipping_tax = $shiping_cost * 0;
        $shiping_cost = $shiping_cost + $shipping_tax;
        //$order->grand_total = $subtotal + $shiping_cost + $shipping_tax;
        //$f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        $round_of_amount = number_format((float) $order->grand_total, 0, '.', '');
    @endphp
    {{-- {{dd($order,$subtotal,$shipping_address)}} --}}

    <table
        style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 320px;Margin: 0 auto;background-color: #fff;width:100%"
        cellspacing="0" cellpadding="0">
        <tbody>
            <tr style="vertical-align: top">
                <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">


                    <div class="u-row-container" style="padding: 29px 10px 0px;background-color: rgba(255,255,255,0)">
                        <div class="u-row"
                            style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #c2151b;">
                            <div
                                style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">

                                <div class="u-col u-col-33p33"
                                    style="max-width: 320px;min-width: 200px;display: table-cell;vertical-align: top;">
                                    <div style="background-color: #ffffff;width: 100% !important;">
                                        <div
                                            style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">

                                            <table style="font-family:'Lato',sans-serif;" role="presentation"
                                                width="100%" cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:20px;font-family:'Lato',sans-serif;"
                                                            align="left">

                                                            <table width="100%" cellspacing="0" cellpadding="0"
                                                                border="0">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="padding-right: 0px;padding-left: 0px;"
                                                                            align="center">

                                                                            <img src="https://sadar24.com/public/uploads/all/mbJgnLyy0GgYcrcb35MrnFjvFepbp6c4ObyilBm8.png"
                                                                                alt="Image" title="Image"
                                                                                style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 100%;"
                                                                                border="0" align="middle">

                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="u-row-container" style="padding: 0px 10px;background-color: rgba(255,255,255,0)">
                        <div class="u-row"
                            style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #f5f5f5;">
                            <table style="font-family:'Lato',sans-serif;background-color: #c2151b;" role="presentation"
                                width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tbody>
                                    <tr>
                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:30px 20px 20px;font-family:'Lato',sans-serif;"
                                            align="left">

                                            <div
                                                style="color: #fff; line-height: 120%; text-align: left; word-wrap: break-word;">
                                                <p style="font-size: 14px; line-height: 120%;"><strong><span
                                                            style="font-size: 24px; line-height: 28.8px;">Hello
                                                            {{ $shipping_address->name }}</span></strong></p>
                                            </div>

                                        </td>

                                    </tr>
                                    <tr style="/*! background-color: #c2151b; */">
                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:30px 20px;font-family:'Lato',sans-serif;padding-top: 0;"
                                            align="left">

                                            <div
                                                style="color: #fff; line-height: 140%; text-align: justify; word-wrap: break-word;">
                                                <p style="font-size: 14px; line-height: 140%;">Thank you for shopping
                                                    with Sadar24. Your order has been placed successfully with us. We
                                                    will keep you updated once your order gets shipped.</p>



                                            </div>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div
                                style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">

                                <div class="u-col u-col-50"
                                    style="max-width: 320px;min-width: 300px;display: table-cell;vertical-align: top;">
                                    <div style="width: 100% !important;">
                                        <div
                                            style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">

                                            <table style="font-family:'Lato',sans-serif;" role="presentation"
                                                width="100%" cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:35px 20px 10px;font-family:'Lato',sans-serif;"
                                                            align="left">

                                                            <div
                                                                style="color: #c2151b; line-height: 120%; text-align: left; word-wrap: break-word;">
                                                                <p style="font-size: 14px; line-height: 120%;"><span
                                                                        style="font-size: 24px; line-height: 28.8px; color: #c2151b;"><strong>Shipping
                                                                            Address</strong></span></p>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <table style="font-family:'Lato',sans-serif;" role="presentation"
                                                width="100%" cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:10px 20px 30px;font-family:'Lato',sans-serif;"
                                                            align="left">

                                                            <div
                                                                style="color: #757575; line-height: 160%; text-align: left; word-wrap: break-word;">
                                                                <p style="font-size: 14px; line-height: 160%;"><span
                                                                        style="font-size: 14px; line-height: 22.4px;">Mr/Mrs/Ms
                                                                        {{ $shipping_address->name }}</span></p>
                                                                <p style="font-size: 14px; line-height: 160%;"><span
                                                                        style="font-size: 14px; line-height: 22.4px;">{{ $shipping_address->address }},
                                                                        {{ $shipping_address->city }},</span></p>
                                                                <p style="font-size: 14px; line-height: 160%;"><span
                                                                        style="font-size: 14px; line-height: 22.4px;">{{ $shipping_address->postal_code }},
                                                                        {{ $shipping_address->state }},
                                                                        {{ $shipping_address->country }}</span></p>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                                <div class="u-col u-col-50"
                                    style="max-width: 320px;min-width: 300px;display: table-cell;vertical-align: top;">
                                    <div style="width: 100% !important;">
                                        <div
                                            style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">

                                            <table style="font-family:'Lato',sans-serif;" role="presentation"
                                                width="100%" cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:35px 20px 10px;font-family:'Lato',sans-serif;"
                                                            align="left">

                                                            <div
                                                                style="color: #333333; line-height: 120%; text-align: left; word-wrap: break-word;">
                                                                <p style="font-size: 14px; line-height: 120%;">
                                                                    <strong><span
                                                                            style="font-size: 24px; line-height: 28.8px;">Invoice
                                                                            Details</span></strong></p>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <table style="font-family:'Lato',sans-serif;" role="presentation"
                                                width="100%" cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:10px 20px 30px;font-family:'Lato',sans-serif;"
                                                            align="left">

                                                            <div
                                                                style="color: #333333; line-height: 120%; text-align: left; word-wrap: break-word;">
                                                                <p style="font-size: 14px; line-height: 120%;"><span
                                                                        style="font-size: 20px; line-height: 24px;"><strong>Number:
                                                                            {{ $order->code }}</strong></span></p>
                                                                <p style="font-size: 14px; line-height: 120%;"><span
                                                                        style="font-size: 20px; line-height: 24px;"><strong>Date:
                                                                            {{ date('d-m-Y', $order->date) }}</strong></span>
                                                                </p>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>



                    <div class="u-row-container" style="padding: 0px 10px;background-color: rgba(255,255,255,0)">
                        <div class="u-row"
                            style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #ffffff;">
                            <div
                                style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">

                                <div class="u-col u-col-100"
                                    style="max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;">
                                    <div style="width: 100% !important;">
                                        <div
                                            style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">

                                            <table style="font-family:'Lato',sans-serif;" role="presentation"
                                                width="100%" cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:30px 20px 20px;font-family:'Lato',sans-serif;"
                                                            align="left">

                                                            <div
                                                                style="color: #333333; line-height: 120%; text-align: left; word-wrap: break-word;">
                                                                <p style="font-size: 14px; line-height: 120%;">
                                                                    <strong><span
                                                                            style="font-size: 24px; line-height: 28.8px;">Order
                                                                            Summary</span></strong></p>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <table style="font-family:'Lato',sans-serif;" role="presentation"
                                                width="100%" cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:0px;font-family:'Lato',sans-serif;"
                                                            align="left">

                                                            <table
                                                                style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 1px solid #e3e3e3;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%"
                                                                width="100%" height="0px" cellspacing="0"
                                                                cellpadding="0" border="0" align="center">
                                                                <tbody>
                                                                    <tr style="vertical-align: top">
                                                                        <td
                                                                            style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                                            <span>&nbsp;</span>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>



                    <div class="u-row-container" style="padding: 0px 10px;background-color: rgba(255,255,255,0)">
                        <div class="u-row"
                            style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #ffffff;">
                            <div
                                style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">

                                <div class="u-col u-col-66p67"
                                    style="max-width: 320px;min-width: 400px;display: table-cell;vertical-align: top;">
                                    <div style="width: 100% !important;">
                                        <div
                                            style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">

                                            <table style="font-family:'Lato',sans-serif;" role="presentation"
                                                width="100%" cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:40px 20px 20px;font-family:'Lato',sans-serif;"
                                                            align="left">

                                                            <div
                                                                style="color: #333333; line-height: 140%; text-align: left; word-wrap: break-word;">
                                                                <p style="font-size: 14px; line-height: 140%;"><span
                                                                        style="font-size: 18px; line-height: 25.2px;">Item
                                                                        Subtotal</span></p>

                                                            </div>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                                <div class="u-col u-col-33p33"
                                    style="max-width: 320px;min-width: 200px;display: table-cell;vertical-align: top;">
                                    <div style="width: 100% !important;">
                                        <div
                                            style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">

                                            <table style="font-family:'Lato',sans-serif;" role="presentation"
                                                width="100%" cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:40px 20px 20px;font-family:'Lato',sans-serif;"
                                                            align="left">

                                                            <div
                                                                style="color: #333333; line-height: 120%; text-align: left; word-wrap: break-word;">
                                                                <p style="font-size: 14px; line-height: 120%;"><span
                                                                        style="font-size: 24px; line-height: 28.8px;"><strong><span
                                                                                style="line-height: 28.8px; font-size: 18px;">{{ single_price($order->orderDetails->sum('price')) }}</span></strong></span>
                                                                </p>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>



                    <div class="u-row-container" style="padding: 0px 10px;background-color: rgba(255,255,255,0)">
                        <div class="u-row"
                            style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #ffffff;">
                            <div
                                style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">

                                <div class="u-col u-col-100"
                                    style="max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;">
                                    <div style="width: 100% !important;">
                                        <div
                                            style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">

                                            <table style="font-family:'Lato',sans-serif;" role="presentation"
                                                width="100%" cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:0px;font-family:'Lato',sans-serif;"
                                                            align="left">

                                                            <table
                                                                style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 1px solid #e3e3e3;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%"
                                                                width="100%" height="0px" cellspacing="0"
                                                                cellpadding="0" border="0" align="center">
                                                                <tbody>
                                                                    <tr style="vertical-align: top">
                                                                        <td
                                                                            style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                                            <span>&nbsp;</span>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="u-row-container" style="padding: 0px 10px;background-color: rgba(255,255,255,0)">
                        <div class="u-row"
                            style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #ffffff;">
                            <div
                                style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">

                                <div class="u-col u-col-66p67"
                                    style="max-width: 320px;min-width: 400px;display: table-cell;vertical-align: top;">
                                    <div style="width: 100% !important;">
                                        <div
                                            style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">

                                            <table style="font-family:'Lato',sans-serif;" role="presentation"
                                                width="100%" cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:40px 20px 20px;font-family:'Lato',sans-serif;"
                                                            align="left">

                                                            <div
                                                                style="color: #333333; line-height: 140%; text-align: left; word-wrap: break-word;">
                                                                <p style="font-size: 14px; line-height: 140%;"><span
                                                                        style="font-size: 18px; line-height: 25.2px;">Shipping
                                                                        cost</span></p>

                                                            </div>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                                <div class="u-col u-col-33p33"
                                    style="max-width: 320px;min-width: 200px;display: table-cell;vertical-align: top;">
                                    <div style="width: 100% !important;">
                                        <div
                                            style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">

                                            <table style="font-family:'Lato',sans-serif;" role="presentation"
                                                width="100%" cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:40px 20px 20px;font-family:'Lato',sans-serif;"
                                                            align="left">

                                                            <div
                                                                style="color: #333333; line-height: 120%; text-align: left; word-wrap: break-word;">
                                                                <p style="font-size: 14px; line-height: 120%;"><span
                                                                        style="font-size: 24px; line-height: 28.8px;"><strong><span
                                                                                style="line-height: 28.8px; font-size: 18px;">{{ single_price($shiping_cost) }}</span></strong></span>
                                                                </p>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="u-row-container" style="padding: 0px 10px;background-color: rgba(255,255,255,0)">
                        <div class="u-row"
                            style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #ffffff;">
                            <div
                                style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">

                                <div class="u-col u-col-100"
                                    style="max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;">
                                    <div style="width: 100% !important;">
                                        <div
                                            style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">

                                            <table style="font-family:'Lato',sans-serif;" role="presentation"
                                                width="100%" cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:0px;font-family:'Lato',sans-serif;"
                                                            align="left">

                                                            <table
                                                                style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 1px solid #e3e3e3;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%"
                                                                width="100%" height="0px" cellspacing="0"
                                                                cellpadding="0" border="0" align="center">
                                                                <tbody>
                                                                    <tr style="vertical-align: top">
                                                                        <td
                                                                            style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                                            <span>&nbsp;</span>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="u-row-container" style="padding: 0px 10px;background-color: rgba(255,255,255,0)">
                        <div class="u-row"
                            style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #ffffff;">
                            <div
                                style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">

                                <div class="u-col u-col-66p67"
                                    style="max-width: 320px;min-width: 400px;display: table-cell;vertical-align: top;">
                                    <div style="width: 100% !important;">
                                        <div
                                            style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">

                                            <table style="font-family:'Lato',sans-serif;" role="presentation"
                                                width="100%" cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:40px 20px 20px;font-family:'Lato',sans-serif;"
                                                            align="left">

                                                            <div
                                                                style="color: #333333; line-height: 140%; text-align: left; word-wrap: break-word;">
                                                                <p style="font-size: 14px; line-height: 140%;"><span
                                                                        style="font-size: 18px; line-height: 25.2px;">Coupon
                                                                        Discount</span></p>

                                                            </div>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                                <div class="u-col u-col-33p33"
                                    style="max-width: 320px;min-width: 200px;display: table-cell;vertical-align: top;">
                                    <div style="width: 100% !important;">
                                        <div
                                            style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">

                                            <table style="font-family:'Lato',sans-serif;" role="presentation"
                                                width="100%" cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:40px 20px 20px;font-family:'Lato',sans-serif;"
                                                            align="left">

                                                            <div
                                                                style="color: #333333; line-height: 120%; text-align: left; word-wrap: break-word;">
                                                                <p style="font-size: 14px; line-height: 120%;"><span
                                                                        style="font-size: 24px; line-height: 28.8px;"><strong><span
                                                                                style="line-height: 28.8px; font-size: 18px;">{{ single_price($order->coupon_discount) }}</span></strong></span>
                                                                </p>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($order->payment_type == "razorpay")
                    <div class="u-row-container" style="padding: 0px 10px;background-color: rgba(255,255,255,0)">
                        <div class="u-row"
                            style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #ffffff;">
                            <div
                                style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">

                                <div class="u-col u-col-66p67"
                                    style="max-width: 320px;min-width: 400px;display: table-cell;vertical-align: top;">
                                    <div style="width: 100% !important;">
                                        <div
                                            style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">

                                            <table style="font-family:'Lato',sans-serif;" role="presentation"
                                                width="100%" cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:40px 20px 20px;font-family:'Lato',sans-serif;"
                                                            align="left">

                                                            <div
                                                                style="color: #333333; line-height: 140%; text-align: left; word-wrap: break-word;">
                                                                <p style="font-size: 14px; line-height: 140%;"><span
                                                                        style="font-size: 18px; line-height: 25.2px;">Online
                                                                        Discount</span></p>

                                                            </div>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                                <div class="u-col u-col-33p33"
                                    style="max-width: 320px;min-width: 200px;display: table-cell;vertical-align: top;">
                                    <div style="width: 100% !important;">
                                        <div
                                            style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">

                                            <table style="font-family:'Lato',sans-serif;" role="presentation"
                                                width="100%" cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:40px 20px 20px;font-family:'Lato',sans-serif;"
                                                            align="left">

                                                            <div
                                                                style="color: #333333; line-height: 120%; text-align: left; word-wrap: break-word;">
                                                                <p style="font-size: 14px; line-height: 120%;"><span
                                                                        style="font-size: 24px; line-height: 28.8px;"><strong><span
                                                                                style="line-height: 28.8px; font-size: 18px;">{{ single_price(20) }}</span></strong></span>
                                                                </p>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="u-row-container" style="padding: 0px 10px;background-color: rgba(255,255,255,0)">
                        <div class="u-row"
                            style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #ffffff;">
                            <div
                                style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">

                                <div class="u-col u-col-100"
                                    style="max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;">
                                    <div style="width: 100% !important;">
                                        <div
                                            style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">

                                            <table style="font-family:'Lato',sans-serif;" role="presentation"
                                                width="100%" cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:0px;font-family:'Lato',sans-serif;"
                                                            align="left">

                                                            <table
                                                                style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 1px solid #e3e3e3;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%"
                                                                width="100%" height="0px" cellspacing="0"
                                                                cellpadding="0" border="0" align="center">
                                                                <tbody>
                                                                    <tr style="vertical-align: top">
                                                                        <td
                                                                            style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                                            <span>&nbsp;</span>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>










                    <div class="u-row-container" style="padding: 0px 10px;background-color: rgba(255,255,255,0)">
                        <div class="u-row"
                            style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #ffffff;">
                            <div
                                style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">

                                <div class="u-col u-col-66p67"
                                    style="max-width: 320px;min-width: 400px;display: table-cell;vertical-align: top;">
                                    <div style="width: 100% !important;">
                                        <div
                                            style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">

                                            <table style="font-family:'Lato',sans-serif;" role="presentation"
                                                width="100%" cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:40px 20px 20px;font-family:'Lato',sans-serif;"
                                                            align="left">

                                                            <div
                                                                style="color: #333333; line-height: 140%; text-align: left; word-wrap: break-word;">
                                                                <p style="font-size: 14px; line-height: 140%;"><span
                                                                        style="font-size: 24px; line-height: 33.6px;"><strong><span
                                                                                style="line-height: 33.6px; font-size: 24px;">Grand
                                                                                Total</span></strong></span></p>

                                                            </div>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                                <div class="u-col u-col-33p33"
                                    style="max-width: 320px;min-width: 200px;display: table-cell;vertical-align: top;">
                                    <div style="width: 100% !important;">
                                        <div
                                            style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">

                                            <table style="font-family:'Lato',sans-serif;" role="presentation"
                                                width="100%" cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:35px 20px 20px;font-family:'Lato',sans-serif;"
                                                            align="left">

                                                            <div
                                                                style="color: #333333; line-height: 120%; text-align: left; word-wrap: break-word;">
                                                                <p style="font-size: 14px; line-height: 120%;">
                                                                    <strong><span
                                                                            style="font-size: 24px; line-height: 36px;">{{ single_price($order->grand_total) }}</span></strong>
                                                                </p>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="u-row-container" style="padding: 0px 10px;background-color: rgba(255,255,255,0)">
                        <div class="u-row"
                            style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #ffffff;">
                            <div
                                style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">



                                <div class="u-col u-col-100"
                                    style="max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;">
                                    <div style="width: 100% !important;">
                                        <div
                                            style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">

                                            <table style="font-family:'Lato',sans-serif;" role="presentation"
                                                width="100%" cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:0px;font-family:'Lato',sans-serif;"
                                                            align="left">

                                                            <table
                                                                style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 1px solid #e3e3e3;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%"
                                                                width="100%" height="0px" cellspacing="0"
                                                                cellpadding="0" border="0" align="center">
                                                                <tbody>
                                                                    <tr style="vertical-align: top">
                                                                        <td
                                                                            style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                                            <span>&nbsp;</span>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="u-row-container" style="padding: 0px 10px;background-color: rgba(255,255,255,0)">
                        <div class="u-row"
                            style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #ffffff;">
                            <div
                                style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">


                                <div class="u-col u-col-66p67"
                                    style="max-width: 320px;min-width: 400px;display: table-cell;vertical-align: top;">
                                    <div style="width: 100% !important;">
                                        <div
                                            style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">

                                            <table style="font-family:'Lato',sans-serif;" role="presentation"
                                                width="100%" cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:40px 20px 20px;font-family:'Lato',sans-serif;"
                                                            align="left">

                                                            <div
                                                                style="color: #333333; line-height: 140%; text-align: left; word-wrap: break-word;">
                                                                <p style="font-size: 14px; line-height: 140%;"><span
                                                                        style="color: #000000; font-family: 'Open Sans', Arial, sans-serif; text-align: justify; font-size: 18px; line-height: 25.2px;">Round
                                                                        Off Amount</span></p>

                                                            </div>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>

                                <div class="u-col u-col-33p33"
                                    style="max-width: 320px;min-width: 200px;display: table-cell;vertical-align: top;">
                                    <div style="width: 100% !important;">
                                        <div
                                            style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">

                                            <table style="font-family:'Lato',sans-serif;" role="presentation"
                                                width="100%" cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:40px 20px 20px;font-family:'Lato',sans-serif;"
                                                            align="left">

                                                            <div
                                                                style="color: #333333; line-height: 120%; text-align: left; word-wrap: break-word;">
                                                                <p style="font-size: 14px; line-height: 120%;"><span
                                                                        style="font-size: 24px; line-height: 28.8px;"><strong><span
                                                                                style="line-height: 28.8px; font-size: 18px;">{{ single_price($round_of_amount) }}</span></strong></span>
                                                                </p>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="u-row-container" style="padding: 0px 10px 20px;background-color: rgba(255,255,255,0)">
                        <div class="u-row"
                            style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #c2151b;">
                            <div
                                style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">



                                <div class="u-col u-col-100"
                                    style="max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;">
                                    <div style="background-color: #c2151b;width: 100% !important;">
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
                                                                <p style="font-size: 14px; line-height: 140%;">To ensure
                                                                    your safety, the delivery agent will drop the
                                                                    package at your doorstep, ring the doorbell and then
                                                                    move back 2 meters while waiting for you to collect
                                                                    your package.</p>
                                                                <p style="font-size: 14px; line-height: 140%;">&nbsp;
                                                                </p>
                                                                <p style="font-size: 14px; line-height: 140%;">Happy
                                                                    Shopping</p>
                                                                <p style="font-size: 14px; line-height: 140%;"><a
                                                                        href="https://sadar24.com/"
                                                                        style="color: #fff;text-decoration: none;">Sadar24.com
                                                                    </a></p>
                                                                <p style="font-size: 14px; line-height: 140%;">
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
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="u-row-container" style="padding: 30px;background-color: #f0f0f0">
                        <div class="u-row"
                            style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
                            <div
                                style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">



                                <div class="u-col u-col-100"
                                    style="max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;">
                                    <div style="width: 100% !important;">
                                        <div
                                            style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">

                                            <table style="font-family:'Lato',sans-serif;" role="presentation"
                                                width="100%" cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:20px;font-family:'Lato',sans-serif;"
                                                            align="left">

                                                            <div
                                                                style="line-height: 120%; text-align: left; word-wrap: break-word;">
                                                                <div style="font-family: arial, helvetica, sans-serif;">
                                                                    <span
                                                                        style="font-size: 12px; color: #999999; line-height: 14.4px;"></span>
                                                                </div>
                                                                <div style="font-family: arial, helvetica, sans-serif;">
                                                                    &nbsp;</div>
                                                                <div style="font-family: arial, helvetica, sans-serif;">
                                                                    <span
                                                                        style="font-size: 12px; color: #999999; line-height: 14.4px;"></span>
                                                                </div>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </td>
            </tr>
        </tbody>
    </table>



</body>

</html>
