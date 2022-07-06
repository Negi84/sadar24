<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */
// use App\Mail\SupportMailManager;
//demo
  Route::get('/demo/cron_1', 'DemoController@cron_1');
  Route::get('/demo/cron_2', 'DemoController@cron_2');
  Route::get('/convert_assets', 'DemoController@convert_assets');
  Route::get('/convert_category', 'DemoController@convert_category');
  Route::get('/convert_tax', 'DemoController@convertTaxes');
  Route::get('/insert_product_variant_forcefully', 'DemoController@insert_product_variant_forcefully');
  Route::get('/update_seller_id_in_orders/{id_min}/{id_max}', 'DemoController@update_seller_id_in_orders');
  Route::get('/migrate_attribute_values', 'DemoController@migrate_attribute_values');

  /************testing routes*****************/

  Route::post('/productfil', 'ProductController@productfil');		

  /************testing routes*****************/

  Route::get('/proxy-pay', 'ProxypayController@create_reference');
  Route::get('/mock_payments', 'ProxypayController@webhook_response');
  Route::post('/test-me', 'ProxypayController@mock_payment');


  Route::get('/refresh-csrf', function() {
    return csrf_token();
});

  Route::post('/aiz-uploader', 'AizUploadController@show_uploader');
  Route::post('/aiz-uploader/upload', 'AizUploadController@upload');
  Route::get('/aiz-uploader/get_uploaded_files', 'AizUploadController@get_uploaded_files');
  Route::post('/aiz-uploader/get_file_by_ids', 'AizUploadController@get_preview_files');
  Route::get('/aiz-uploader/download/{id}', 'AizUploadController@attachment_download')->name('download_attachment');


  Auth::routes(['verify' => true]);
  Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
  Route::get('/email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
  Route::get('/verification-confirmation/{code}', 'Auth\VerificationController@verification_confirmation')->name('email.verification.confirmation');
  Route::get('/email_change/callback', 'HomeController@email_change_callback')->name('email_change.callback');
  Route::post('/password/reset/email/submit', 'HomeController@reset_password_with_code')->name('password.update');


  Route::post('/language', 'LanguageController@changeLanguage')->name('language.change');
  Route::post('/currency', 'CurrencyController@changeCurrency')->name('currency.change');

  Route::get('/social-login/redirect/{provider}', 'Auth\LoginController@redirectToProvider')->name('social.login');
  Route::get('/social-login/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->name('social.callback');
  Route::get('/users/login', 'HomeController@login')->name('user.login');
  Route::get('/users/registration', 'HomeController@registration')->name('user.registration');
//Route::post('/users/login', 'HomeController@user_login')->name('user.login.submit');
  Route::post('/users/login/cart', 'HomeController@cart_login')->name('cart.login.submit');

//Home Page
  Route::get('/', 'HomeController@index')->name('home');
  Route::post('/home/section/featured', 'HomeController@load_featured_section')->name('home.section.featured');
  Route::post('/home/section/best_selling', 'HomeController@load_best_selling_section')->name('home.section.best_selling');
  Route::post('/home/section/whats_new_products', 'HomeController@load_whats_new_products')->name('home.section.whats_new_products');
  Route::post('/home/section/category_catalogue_products', 'HomeController@load_category_catalogue_products')->name('home.section.category_catalogue_products');
  Route::post('/home/section/home_categories', 'HomeController@load_home_categories_section')->name('home.section.home_categories');
  Route::post('/home/section/best_sellers', 'HomeController@load_best_sellers_section')->name('home.section.best_sellers');
//category dropdown menu ajax call
  Route::post('/category/nav-element-list', 'HomeController@get_category_items')->name('category.elements');

//Flash Deal Details Page
  Route::get('/flash-deals', 'HomeController@all_flash_deals')->name('flash-deals');
  Route::get('/flash-deal/{slug}', 'HomeController@flash_deal_details')->name('flash-deal-details');


  Route::get('/sitemap.xml', function() {
    return base_path('sitemap.xml');
});


  Route::get('/customer-products', 'CustomerProductController@customer_products_listing')->name('customer.products');
  Route::get('/customer-products?category={category_slug}', 'CustomerProductController@search')->name('customer_products.category');
  Route::get('/customer-products?city={city_id}', 'CustomerProductController@search')->name('customer_products.city');
  Route::get('/customer-products?q={search}', 'CustomerProductController@search')->name('customer_products.search');
  Route::get('/customer-products/admin', 'IyzicoController@initPayment')->name('profile.edit');
  Route::get('/customer-product/{slug}', 'CustomerProductController@customer_product')->name('customer.product');
  Route::get('/customer-packages', 'HomeController@premium_package_index')->name('customer_packages_list_show');

  Route::get('/search', 'SearchController@index')->name('search');
  Route::get('/search?keyword={search}', 'SearchController@index')->name('suggestion.search');
  Route::get('/smart-search', 'SearchController@smart_search')->name('smartsearch');
  Route::get('/smart-search?keyword={search}', 'SearchController@smart_search')->name('suggestion.smartsearch');
  Route::post('/ajax-search', 'SearchController@ajax_search')->name('search.ajax');
  Route::post('/ajax-search-pred', 'SearchController@ajax_search_pred')->name('search.ajaxpred');
  Route::get('/category/{category_slug}', 'SearchController@listingByCategory')->name('products.category');
  Route::get('/brand/{brand_slug}', 'SearchController@listingByBrand')->name('products.brand');

  // old product system route
  Route::get('/product/{slug}', 'HomeController@product')->name('product');
  Route::post('/product/variant_price', 'HomeController@variant_price')->name('products.variant_price');
  Route::get('/shop/{slug}', 'HomeController@shop')->name('shop.visit');
  Route::get('/shop/{slug}/{type}', 'HomeController@filter_shop')->name('shop.visit.type');
  // old product system route

  // new product system route
  Route::get('/pilot_product/{slug}', 'HomeController@pilot_product')->name('pilot.product');
  // Route::post('/product/variant_price', 'HomeController@variant_price')->name('products.variant_price');
  // Route::get('/shop/{slug}', 'HomeController@shop')->name('shop.visit');
  // Route::get('/shop/{slug}/{type}', 'HomeController@filter_shop')->name('shop.visit.type');
  // new product system route

  Route::get('/cart', 'CartController@index')->name('cart');
  Route::post('/cart/show-cart-modal', 'CartController@showCartModal')->name('cart.showCartModal');
  Route::post('/cart/addtocart', 'CartController@addToCart')->name('cart.addToCart');
  Route::post('/cart/removeFromCart', 'CartController@removeFromCart')->name('cart.removeFromCart');
  Route::post('/cart/updateQuantity', 'CartController@updateQuantity')->name('cart.updateQuantity');
  Route::get('/checkout/view_checkout', 'CheckoutController@view_checkout')->name('checkout.view_checkout');

//Checkout Routes
  Route::group(['prefix' => 'checkout', 'middleware' => ['user', 'verified', 'unbanned']], function() {
    Route::get('/', 'CheckoutController@get_shipping_info')->name('checkout.shipping_info');
    Route::any('/delivery_info', 'CheckoutController@store_shipping_info')->name('checkout.store_shipping_infostore');
    Route::post('/payment_select', 'CheckoutController@store_delivery_info')->name('checkout.store_delivery_info');

    Route::get('/order-confirmed', 'CheckoutController@order_confirmed')->name('order_confirmed');
    Route::post('/payment', 'CheckoutController@checkout')->name('payment.checkout');
    Route::post('/get_pick_up_points', 'HomeController@get_pick_up_points')->name('shipping_info.get_pick_up_points');
    Route::get('/payment-select', 'CheckoutController@get_payment_info')->name('checkout.payment_info');
    Route::post('/apply_coupon_code', 'CheckoutController@apply_coupon_code')->name('checkout.apply_coupon_code');
    Route::post('/remove_coupon_code', 'CheckoutController@remove_coupon_code')->name('checkout.remove_coupon_code');
    //Club point
    Route::post('/apply-club-point', 'CheckoutController@apply_club_point')->name('checkout.apply_club_point');
    Route::post('/remove-club-point', 'CheckoutController@remove_club_point')->name('checkout.remove_club_point');
});

//Paypal START
  Route::get('/paypal/payment/done', 'PaypalController@getDone')->name('payment.done');
  Route::get('/paypal/payment/cancel', 'PaypalController@getCancel')->name('payment.cancel');
//Paypal END
// SSLCOMMERZ Start
  Route::get('/sslcommerz/pay', 'PublicSslCommerzPaymentController@index');
  Route::POST('/sslcommerz/success', 'PublicSslCommerzPaymentController@success');
  Route::POST('/sslcommerz/fail', 'PublicSslCommerzPaymentController@fail');
  Route::POST('/sslcommerz/cancel', 'PublicSslCommerzPaymentController@cancel');
  Route::POST('/sslcommerz/ipn', 'PublicSslCommerzPaymentController@ipn');
//SSLCOMMERZ END
//Stipe Start
  Route::get('stripe', 'StripePaymentController@stripe');
  Route::post('/stripe/create-checkout-session', 'StripePaymentController@create_checkout_session')->name('stripe.get_token');
  Route::any('/stripe/payment/callback', 'StripePaymentController@callback')->name('stripe.callback');
  Route::get('/stripe/success', 'StripePaymentController@success')->name('stripe.success');
  Route::get('/stripe/cancel', 'StripePaymentController@cancel')->name('stripe.cancel');
//Stripe END

  Route::get('/compare', 'CompareController@index')->name('compare');
  Route::get('/compare/reset', 'CompareController@reset')->name('compare.reset');
  Route::post('/compare/addToCompare', 'CompareController@addToCompare')->name('compare.addToCompare');

  Route::resource('subscribers', 'SubscriberController');

  Route::get('/brands', 'HomeController@all_brands')->name('brands.all');
  Route::get('/categories', 'HomeController@all_categories')->name('categories.all');
  Route::get('/sellers', 'HomeController@all_seller')->name('sellers');
  Route::get('/coupons', 'HomeController@all_coupons')->name('coupons.all');
  Route::get('/inhouse', 'HomeController@inhouse_products')->name('inhouse.all');

  Route::get('/sellerpolicy', 'HomeController@sellerpolicy')->name('sellerpolicy');
  Route::get('/returnpolicy', 'HomeController@returnpolicy')->name('returnpolicy');
  Route::get('/supportpolicy', 'HomeController@supportpolicy')->name('supportpolicy');
  Route::get('/terms', 'HomeController@terms')->name('terms');
  Route::get('/privacypolicy', 'HomeController@privacypolicy')->name('privacypolicy');

  Route::group(['middleware' => ['user', 'verified', 'unbanned']], function() {
    Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
    Route::get('/profile', 'HomeController@profile')->name('profile');
    Route::post('/new-user-verification', 'HomeController@new_verify')->name('user.new.verify');
    Route::post('/new-user-email', 'HomeController@update_email')->name('user.change.email');
    Route::post('/customer/update-profile', 'HomeController@customer_update_profile')->name('customer.profile.update');
    Route::post('/seller_panel/update-profile', 'HomeController@seller_update_profile')->name('seller.profile.update');

    Route::resource('purchase_history', 'PurchaseHistoryController');
    Route::post('/purchase_history/details', 'PurchaseHistoryController@purchase_history_details')->name('purchase_history.details');
    Route::get('/purchase_history/destroy/{id}', 'PurchaseHistoryController@destroy')->name('purchase_history.destroy');
	Route::get('/purchase_history/order_details/{id}', 'PurchaseHistoryController@purchase_history_order_details')->name('purchase_history.order_details');

    Route::resource('wishlists', 'WishlistController');
    Route::post('/wishlists/remove', 'WishlistController@remove')->name('wishlists.remove');

    Route::get('/wallet', 'WalletController@index')->name('wallet.index');
    Route::post('/recharge', 'WalletController@recharge')->name('wallet.recharge');

    Route::resource('support_ticket', 'SupportTicketController');
    Route::post('support_ticket/reply', 'SupportTicketController@seller_store')->name('support_ticket.seller_store');

    Route::post('/customer_packages/purchase', 'CustomerPackageController@purchase_package')->name('customer_packages.purchase');
    Route::resource('customer_products', 'CustomerProductController');
    Route::get('/customer_products/{id}/edit', 'CustomerProductController@edit')->name('customer_products.edit');
    Route::post('/customer_products/published', 'CustomerProductController@updatePublished')->name('customer_products.published');
    Route::post('/customer_products/status', 'CustomerProductController@updateStatus')->name('customer_products.update.status');

    Route::get('digital_purchase_history', 'PurchaseHistoryController@digital_index')->name('digital_purchase_history.index');

    Route::get('/all-notifications', 'NotificationController@index')->name('all-notifications');
});

  Route::get('/customer_products/destroy/{id}', 'CustomerProductController@destroy')->name('customer_products.destroy');

  Route::group(['prefix' => 'seller_panel', 'middleware' => ['seller', 'verified', 'user']], function() {
    Route::get('/products', 'HomeController@seller_product_list')->name('seller.products');
	  Route::get('/product_list', 'HomeController@seller_product_list_new')->name('seller.product_list');
    Route::get('/product/upload', 'HomeController@show_product_upload_form')->name('seller.products.upload');
    Route::get('/product/{id}/edit', 'HomeController@show_product_edit_form')->name('seller.products.edit');
    Route::resource('payments', 'PaymentController');

    Route::get('/shop/apply_for_verification', 'ShopController@verify_form')->name('shop.verify');
    Route::post('/shop/apply_for_verification', 'ShopController@verify_form_store')->name('shop.verify.store');

    Route::get('/reviews', 'ReviewController@seller_reviews')->name('reviews.seller');

    //digital Product
    Route::get('/digitalproducts', 'HomeController@seller_digital_product_list')->name('seller.digitalproducts');
    Route::get('/digitalproducts/upload', 'HomeController@show_digital_product_upload_form')->name('seller.digitalproducts.upload');
    Route::get('/digitalproducts/{id}/edit', 'HomeController@show_digital_product_edit_form')->name('seller.digitalproducts.edit');

    //Coupon
    Route::get('/coupons', 'CouponController@sellerIndex')->name('seller.coupon.index');
    Route::get('/coupons/create', 'CouponController@sellerCreate')->name('seller.coupon.create');
    Route::post('/coupons/store', 'CouponController@sellerStore')->name('seller.coupon.store');
    Route::get('/coupon/edit/{id}', 'CouponController@sellerEdit')->name('seller.coupon.edit');
    Route::get('/coupon/destroy/{id}', 'CouponController@sellerDestroy')->name('seller.coupon.destroy');
    Route::patch('/coupons/update/{id}', 'CouponController@sellerUpdate')->name('seller.coupon.update');

    //Upload
    Route::any('/uploads', 'AizUploadController@index')->name('my_uploads.all');
    Route::any('/uploads/new', 'AizUploadController@create')->name('my_uploads.new');
    Route::any('/uploads/file-info', 'AizUploadController@file_info')->name('my_uploads.info');
    Route::get('/uploads/destroy/{id}', 'AizUploadController@destroy')->name('my_uploads.destroy');

    // add brand
    Route::get('brands', 'BrandController@seller_index')->name('seller.brands');
    Route::post('brands/add', 'BrandController@seller_brand_store')->name('seller.brands.add');
    Route::get('/brands/edit/{id}', 'BrandController@edit')->name('seller.brands.edit');
    Route::get('/brands/destroy/{id}', 'BrandController@destroy')->name('seller.brands.destroy');
    // add brand

});

  Route::group(['middleware' => ['auth']], function() {
    Route::post('/products/store/', 'ProductController@store')->name('products.store');
    Route::post('/products/update/{id}', 'ProductController@update')->name('products.update');
    Route::get('/products/destroy/{id}', 'ProductController@destroy')->name('products.destroy');
    Route::get('/products/duplicate/{id}', 'ProductController@duplicate')->name('products.duplicate');
    Route::post('/products/sku_combination', 'ProductController@sku_combination')->name('products.sku_combination');
    Route::post('/products/update_tags', 'ProductController@update_tags')->name('products.update_tags');
	Route::post('/products/sku_combination_edit', 'ProductController@sku_combination_edit')->name('products.sku_combination_edit');
    Route::post('/products/seller/featured', 'ProductController@updateSellerFeatured')->name('products.seller.featured');
    Route::post('/products/published', 'ProductController@updatePublished')->name('products.published');
	Route::post('/products/seller-on-vacation', 'ProductController@updateSellerOnVacation')->name('products.seller-on-vacation');

    Route::post('/products/add-more-choice-option', 'ProductController@add_more_choice_option')->name('products.add-more-choice-option');

    Route::get('invoice/{order_id}', 'InvoiceController@invoice_download')->name('invoice.download');

    Route::resource('orders', 'OrderController');
	
    Route::get('/orders/destroy/{id}', 'OrderController@destroy')->name('orders.destroy');
    
    Route::get('/orders/cancel/{id}', 'OrderController@cancel')->name('orders.cancel');

    Route::get('/seller_orders/{id}/readytoship', 'OrderController@readyToShip')->name('seller_orders.ready_to_ship');

    Route::get('/seller_orders/{id}/track_order', 'OrderController@trackOrder')->name('seller_orders.track_order');

    Route::get('/seller_orders/{id}/packing_slip', 'OrderController@packingSlip')->name('seller_orders.packing_slip');

    Route::get('/seller_orders/{id}/return_order', 'OrderController@returnOrder')->name('seller_orders.return_order');

    Route::post('/orders/details', 'OrderController@order_details')->name('orders.details');
    Route::post('/orders/update_delivery_status', 'OrderController@update_delivery_status')->name('orders.update_delivery_status');
    Route::post('/orders/update_payment_status', 'OrderController@update_payment_status')->name('orders.update_payment_status');
    Route::post('/orders/delivery-boy-assign', 'OrderController@assign_delivery_boy')->name('orders.delivery-boy-assign');
	Route::get('/orders/order_details/{id}', 'OrderController@seller_order_details')->name('orders.seller_order_details');

    Route::resource('/reviews', 'ReviewController');

    Route::resource('/withdraw_requests', 'SellerWithdrawRequestController');
    Route::get('/withdraw_requests_all', 'SellerWithdrawRequestController@request_index')->name('withdraw_requests_all');
    Route::post('/withdraw_request/payment_modal', 'SellerWithdrawRequestController@payment_modal')->name('withdraw_request.payment_modal');
    Route::post('/withdraw_request/message_modal', 'SellerWithdrawRequestController@message_modal')->name('withdraw_request.message_modal');

    Route::resource('conversations', 'ConversationController');
    Route::get('/conversations/destroy/{id}', 'ConversationController@destroy')->name('conversations.destroy');
    Route::post('conversations/refresh', 'ConversationController@refresh')->name('conversations.refresh');
    Route::resource('messages', 'MessageController');

    //Product Bulk Upload
    Route::post('/brand-bulk-sheet-generate', 'SheetGeneratorController@generateSheet')->name('brand.bulk.sheet.generate');
    Route::get('/product-bulk-upload/index', 'ProductBulkUploadController@index')->name('product_bulk_upload.index');
    // Route::post('/bulk-product-upload', 'ProductBulkUploadController@bulk_upload')->name('bulk_product_upload');
    Route::post('/bulk-product-upload', 'ProductBulkUploadController@store_bulk_product_sheet')->name('bulk_product_upload');
    Route::get('/product-csv-download/{type}', 'ProductBulkUploadController@import_product')->name('product_csv.download');
    Route::get('/vendor-product-csv-download/{id}', 'ProductBulkUploadController@import_vendor_product')->name('import_vendor_product.download');
    Route::group(['prefix' => 'bulk-upload/download'], function() {
        Route::get('/category', 'ProductBulkUploadController@pdf_download_category')->name('pdf.download_category');
        Route::get('/brand', 'ProductBulkUploadController@pdf_download_brand')->name('pdf.download_brand');
        Route::get('/seller', 'ProductBulkUploadController@pdf_download_seller')->name('pdf.download_seller');
    });

    //Product Export
    Route::get('/product-bulk-export', 'ProductBulkUploadController@export')->name('product_bulk_export.index');

    Route::resource('digitalproducts', 'DigitalProductController');
    Route::get('/digitalproducts/edit/{id}', 'DigitalProductController@edit')->name('digitalproducts.edit');
    Route::get('/digitalproducts/destroy/{id}', 'DigitalProductController@destroy')->name('digitalproducts.destroy');
    Route::get('/digitalproducts/download/{id}', 'DigitalProductController@download')->name('digitalproducts.download');

    //Reports
    Route::get('/commission-log', 'ReportController@commission_history')->name('commission-log.index');

    //Coupon Form
    Route::post('/coupon/get_form', 'CouponController@get_coupon_form')->name('coupon.get_coupon_form');
    Route::post('/coupon/get_form_edit', 'CouponController@get_coupon_form_edit')->name('coupon.get_coupon_form_edit');
});

Route::resource('shops', 'ShopController');
Route::get('/shops/create', 'ShopController@create')->name('shops.create');

Route::get('/track-your-order', 'HomeController@trackOrder')->name('orders.track');

Route::get('/instamojo/payment/pay-success', 'InstamojoController@success')->name('instamojo.success');

Route::post('rozer/payment/pay-success', 'RazorpayController@payment')->name('payment.rozer');

Route::get('/paystack/payment/callback', 'PaystackController@handleGatewayCallback');

Route::get('/vogue-pay', 'VoguePayController@showForm');
Route::get('/vogue-pay/success/{id}', 'VoguePayController@paymentSuccess');
Route::get('/vogue-pay/failure/{id}', 'VoguePayController@paymentFailure');

//Iyzico
Route::any('/iyzico/payment/callback/{payment_type}/{amount?}/{payment_method?}/{combined_order_id?}/{customer_package_id?}/{seller_package_id?}', 'IyzicoController@callback')->name('iyzico.callback');

Route::post('/get-city', 'CityController@get_city')->name('get-city');

Route::resource('addresses', 'AddressController');
Route::post('/addresses/update/{id}', 'AddressController@update')->name('addresses.update');
Route::get('/addresses/destroy/{id}', 'AddressController@destroy')->name('addresses.destroy');
Route::get('/addresses/set_default/{id}', 'AddressController@set_default')->name('addresses.set_default');
Route::get('check-pincode-availability', 'HomeController@checkPincodeAvailability')->name('check-pincode-availability');

//payhere below
Route::get('/payhere/checkout/testing', 'PayhereController@checkout_testing')->name('payhere.checkout.testing');
Route::get('/payhere/wallet/testing', 'PayhereController@wallet_testing')->name('payhere.checkout.testing');
Route::get('/payhere/customer_package/testing', 'PayhereController@customer_package_testing')->name('payhere.customer_package.testing');

Route::any('/payhere/checkout/notify', 'PayhereController@checkout_notify')->name('payhere.checkout.notify');
Route::any('/payhere/checkout/return', 'PayhereController@checkout_return')->name('payhere.checkout.return');
Route::any('/payhere/checkout/cancel', 'PayhereController@chekout_cancel')->name('payhere.checkout.cancel');

Route::any('/payhere/wallet/notify', 'PayhereController@wallet_notify')->name('payhere.wallet.notify');
Route::any('/payhere/wallet/return', 'PayhereController@wallet_return')->name('payhere.wallet.return');
Route::any('/payhere/wallet/cancel', 'PayhereController@wallet_cancel')->name('payhere.wallet.cancel');

Route::any('/payhere/seller_package_payment/notify', 'PayhereController@seller_package_notify')->name('payhere.seller_package_payment.notify');
Route::any('/payhere/seller_package_payment/return', 'PayhereController@seller_package_payment_return')->name('payhere.seller_package_payment.return');
Route::any('/payhere/seller_package_payment/cancel', 'PayhereController@seller_package_payment_cancel')->name('payhere.seller_package_payment.cancel');

Route::any('/payhere/customer_package_payment/notify', 'PayhereController@customer_package_notify')->name('payhere.customer_package_payment.notify');
Route::any('/payhere/customer_package_payment/return', 'PayhereController@customer_package_return')->name('payhere.customer_package_payment.return');
Route::any('/payhere/customer_package_payment/cancel', 'PayhereController@customer_package_cancel')->name('payhere.customer_package_payment.cancel');

//N-genius
Route::any('ngenius/cart_payment_callback', 'NgeniusController@cart_payment_callback')->name('ngenius.cart_payment_callback');
Route::any('ngenius/wallet_payment_callback', 'NgeniusController@wallet_payment_callback')->name('ngenius.wallet_payment_callback');
Route::any('ngenius/customer_package_payment_callback', 'NgeniusController@customer_package_payment_callback')->name('ngenius.customer_package_payment_callback');
Route::any('ngenius/seller_package_payment_callback', 'NgeniusController@seller_package_payment_callback')->name('ngenius.seller_package_payment_callback');

//bKash
Route::post('/bkash/createpayment', 'BkashController@checkout')->name('bkash.checkout');
Route::post('/bkash/executepayment', 'BkashController@excecute')->name('bkash.excecute');
Route::get('/bkash/success', 'BkashController@success')->name('bkash.success');

//Nagad
Route::get('/nagad/callback', 'NagadController@verify')->name('nagad.callback');

//aamarpay
Route::post('/aamarpay/success','AamarpayController@success')->name('aamarpay.success');
Route::post('/aamarpay/fail','AamarpayController@fail')->name('aamarpay.fail');


//Blog Section
Route::get('/blogs', 'BlogController@all_blog')->name('blog');
Route::get('/blog/{slug}', 'BlogController@blog_details')->name('blog.details');


//mobile app balnk page for webview
Route::get('/mobile-page/{slug}', 'PageController@mobile_custom_page')->name('mobile.custom-pages');
 
//Custom page
Route::get('/{slug}', 'PageController@show_custom_page')->name('custom-pages.show_custom_page');

//Phone based login
Route::get('/users/otplogin', 'HomeController@otplogin')->name('user.otplogin');
Route::post('/users/mobilelogin', 'HomeController@mobilelogin')->name('user.mobilelogin');
Route::post('/users/otp', 'HomeController@otp')->name('user.otp');

Route::get('/google/feed', 'ProductController@google_feed')->name('feed.all');
Route::get('/google/feed_0', 'ProductController@google_feed_0')->name('feed.all_0');
Route::get('/google/feed_1', 'ProductController@google_feed_1')->name('feed.all_1');
Route::get('/google/feed_2', 'ProductController@google_feed_2')->name('feed.all_2');
Route::get('/google/feed_3', 'ProductController@google_feed_3')->name('feed.all_3');

//Custom Update Database
Route::get('/updateShippingData/curl',  'OrderUpdateController@update_wrong_shipping')->name('update_wrong_shipping.all');
Route::get('/orderCurrentStatus/crul',  'OrderUpdateController@orders_delhivery_current_status')->name('orders_delhivery_current_status.all');
Route::get('/orderCommissionHistory/curl', 'OrderUpdateController@update_seller_order_history')->name('update_seller_order_history.all');
Route::get('/updateDelhiveryDate/curl', 'OrderUpdateController@update_delhivery_date')->name('update_delhivery_date.all');
Route::get('update/invoice_amount/{orderid}/{amount}', 'OrderUpdateController@update_invoice_total')->name('update_invoice_total');
Route::get('/clearComission/curl', 'OrderUpdateController@clear_commission_histories')->name('clear_commission_histories.all');
Route::get('/updateCategoryForProduct/curl',  'OrderUpdateController@update_category_for_product')->name('update_category_for_product.all');
Route::get('/updateTagsForProduct/curl',  'OrderUpdateController@update_tags_for_product')->name('update_tags_for_product.all');
Route::get('category_data/getproduct/{catid}', 'OrderUpdateController@get_product_category')->name('get_product_category');
Route::get('category_data/updateproduct/{catid}/{product_id}', 'OrderUpdateController@update_product_category')->name('update_product_category');


//Guest Based login
Route::get('/users/guestRegistration', 'HomeController@guestRegistration')->name('user.guestRegistration');
Route::post('/users/guestRegister', 'HomeController@guestRegister')->name('user.guestRegister');


//Firebase Notification 

//Firebase Notification 

Route::get('/firebase/testing-page', 'HomeController@firebaseTokenTest')->name('firebaseTokenTest');
Route::any('/firebase/save-token', 'HomeController@saveToken')->name('save-token');
Route::any('/firebase/send-notification', 'HomeController@sendNotification')->name('send.notification');
Route::get('/user/get-user', 'HomeController@getuser')->name('get-user');
Route::any('/firebase/ios-device-token', 'HomeController@iostoken')->name('ios-device-token');

Route::any('/firebase/android-device-token', 'HomeController@androidtoken')->name('android-device-token');

Route::get('/firebase/sendNotificationios', 'HomeController@sendnotifications')->name('sendNotificationios');
Route::get('/firebase/sendNotificationandroid', 'HomeController@sendNotificationandroid')->name('sendNotificationandroid');
Route::post('/users/checkoutGuestRegister', 'HomeController@checkoutGuestRegister')->name('user.checkoutGuestRegister');
   
// Ajax Call
Route::post('/validate_email_fields','ajaxCallController@validateEmailFields')->name('validateEmailFields');
Route::post('/validate_phone_fields','ajaxCallController@validatePhoneFields')->name('validatePhoneFields');
Route::post('/validate_gst_fields','ajaxCallController@validateGstFields')->name('validateGstFields');
// Ajax Call

