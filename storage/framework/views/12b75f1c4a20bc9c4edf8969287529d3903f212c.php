<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <meta http-equiv="Content-Type" content="text/html;"/>
    <meta charset="UTF-8">
  
    <style type="text/css">
      table, td { color: #000000; } @media  only screen and (min-width: 620px) {
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
  .u-col > div {
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

<body class="clean-body u_body" style="margin: 0;padding: 0;-webkit-text-size-adjust: 100%;background-color: #fff;color: #000000">
			<?php
				$shipping_address = json_decode($order->shipping_address);
				$seller = \App\Seller::where('user_id', $order->seller_id)->first();
				$seller_details = $seller->user->shop;
			?>
  <table style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 320px;Margin: 0 auto;background-color: #fff;width:100%" cellspacing="0" cellpadding="0">
  <tbody>
  <tr style="vertical-align: top">
    <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
    
    

<div class="u-row-container" style="padding: 29px 10px 0px;background-color: rgba(255,255,255,0)">
  <div class="u-row" style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #c2151b;">
    <div style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">

<div class="u-col u-col-33p33" style="max-width: 320px;min-width: 200px;display: table-cell;vertical-align: top;">
  <div style="background-color: #ffffff;width: 100% !important;">
  <div style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">
  
<table style="font-family:'Lato',sans-serif;" role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
  <tbody>
    <tr>
      <td style="overflow-wrap:break-word;word-break:break-word;padding:20px;font-family:'Lato',sans-serif;" align="left">
        
<table width="100%" cellspacing="0" cellpadding="0" border="0">
  <tbody><tr>
    <td style="padding-right: 0px;padding-left: 0px;" align="center">
      
      <img src="https://sadar24.com/public/uploads/all/mbJgnLyy0GgYcrcb35MrnFjvFepbp6c4ObyilBm8.png" alt="Image" title="Image" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 100%;"  border="0" align="middle">
      
    </td>
  </tr>
</tbody></table>

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
  <div class="u-row" style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #f5f5f5;">
    <table style="font-family:'Lato',sans-serif;background-color: #c2151b;" role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
  <tbody>
    <tr>
      <td style="overflow-wrap:break-word;word-break:break-word;padding:30px 20px 20px;font-family:'Lato',sans-serif;" align="left">
        
  <div style="color: #fff; line-height: 120%; text-align: left; word-wrap: break-word;">
    <p style="font-size: 14px; line-height: 120%;"><strong><span style="font-size: 24px; line-height: 28.8px;">Hello <?php echo e($seller_details->name); ?></span></strong></p>
  </div>

      </td>
  
    </tr>
<tr style="/*! background-color: #c2151b; */">
      <td style="overflow-wrap:break-word;word-break:break-word;padding:30px 20px;font-family:'Lato',sans-serif;padding-top: 0;padding-bottom: 0;" align="left">
        
  <div style="color: #fff; line-height: 140%; text-align: justify; word-wrap: break-word;">
    <p style="font-size: 18px; line-height: 140%;">Congratulations!!! you have recieved a new order. Please login to your Profile on seller.sadar24.com or you can login at your seller app to know the details of your current order.  </p>



  </div>

      </td>
    </tr>
  </tbody>
</table>
  </div>
</div>



<div class="u-row-container" style="padding: 0px 10px 20px;background-color: rgba(255,255,255,0)">
  <div class="u-row" style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #c2151b;">
    <div style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">
      
<div class="u-col u-col-100" style="max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;">
  <div style="background-color: #c2151b;width: 100% !important;">
  <div style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">
  
<table style="font-family:'Lato',sans-serif;" role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
  <tbody>
    <tr>
      <td style="overflow-wrap:break-word;word-break:break-word;padding:30px 20px;font-family:'Lato',sans-serif;padding-top: 0;" align="left">
        
  <div style="color: #ffffff; line-height: 140%; text-align: justify; word-wrap: break-word;">
    
<p style="font-size: 14px; line-height: 140%;">&nbsp;</p><p style="font-size: 18px; line-height: 140%;"> Please pack the order as per Sadar24 guidlines &amp; press "Ready to Ship" button present over there so that our team will know &amp; recieve parcel from you.</p><p style="font-size: 14px; line-height: 140%;">&nbsp;</p><p style="font-size: 18px; line-height: 140%;">For any query you may connect with us at :-</p><p style="font-size: 18px; line-height: 140%;/*! text-align: center; */"><span style="margin-right: 7%;">Website</span> :- <a href="https://seller.sadar24.com/" style="color: #fff;text-decoration: none;">seller.Sadar24.com </a></p><p style="font-size: 18px; line-height: 140%;color: #fff;"><span style="/*! width: 40%; */margin-right: 10%;">E-mail</span>    :- seller@sadar24.com</p><p style="font-size: 18px; line-height: 140%;"><span style="margin-right: 6%;">Phone Us</span> :- 7800-708-708</p><p style="font-size: 14px; line-height: 140%;">&nbsp;</p>
<p style="font-size: 18px; line-height: 140%;">Happy Selling</p><p style="font-size: 18px; line-height: 140%;">Team Sadar24</p><p style="font-size: 14px; line-height: 140%;/*! position: absolute; */text-align: right;"> 
  <a href="#" target="_blank" class="d-inline-block mr-3 ml-0" style="margin-right: 10px;">
                                <img src="https://sadar24.com/public/assets/img/play.png" class="mx-100 h-40px" style="height: 40px;">
                            </a>
                                                                            <a href="#" target="_blank" class="d-inline-block">
                                <img src="https://sadar24.com/public/assets/img/app.png" class="mx-100 h-40px" style="height: 40px;">
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
  <div class="u-row" style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
    <div style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">
      
      

<div class="u-col u-col-100" style="max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;">
  <div style="width: 100% !important;">
  <div style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">
  
<table style="font-family:'Lato',sans-serif;" role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
  <tbody>
    <tr>
      <td style="overflow-wrap:break-word;word-break:break-word;padding:20px;font-family:'Lato',sans-serif;" align="left">
        
  <div style="line-height: 120%; text-align: left; word-wrap: break-word;">
    <div style="font-family: arial, helvetica, sans-serif;"><span style="font-size: 12px; color: #999999; line-height: 14.4px;"></span></div>
<div style="font-family: arial, helvetica, sans-serif;">&nbsp;</div>
<div style="font-family: arial, helvetica, sans-serif;"><span style="font-size: 12px; color: #999999; line-height: 14.4px;"></span></div>
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




</body></html><?php /**PATH /var/www/sadar24_aws/resources/views/emails/sellerinvoice.blade.php ENDPATH**/ ?>