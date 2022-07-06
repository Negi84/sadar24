<?php 

	include('inc/connect.php');
	
	if(isset($_POST['Ssubmit'])){
		$mobile = $_POST['phone_number'];
		$sql = "SELECT phone FROM tbl_seller_query WHERE phone = '$mobile'";
		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) > 0) {
		    header("Location: https://sadar24.com/shops/create"); 
		} else {
			
			$sql = "INSERT INTO tbl_seller_query (phone) VALUES ('$mobile')";
			if (mysqli_query($conn, $sql)) {
				//echo "New record created successfully";

			header("Location: https://sadar24.com/shops/create"); 
			} else {
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
		}
		mysqli_close($conn);
	}
?>
<!doctype html>
<html lang="en">
	<head>
		<?php include('inc/head.php'); ?> 
		<title>Sadar24 seller, Sadar24 seller login, Seller.sadar24, Seller registration of Sadar24</title>
	</head>
	<body class="hideSideMenu">
		<?php include('inc/header.php');?> 
		<!--Header Close-->
		<div class="clearfix"></div>
		<section class="seller-carousel">
			<div class="container container-header">
				<div class="row">
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 order-2-mobile">
						<div class="banner-caption">
							<h1>Frequently asked questions</h1>							
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 order-1-mobile">
						<figure class="collage-banner text-right">
							<img data-src="seller/images/faq-banner.jpg" alt="slider" class="lazyload w-100 img-fluid"> 
						</figure>
					</div>
				</div>
			</div>
		</section>
		<div class="clearfix"></div>
		
		<section class="with-100 pb-5">
			<div class="container container-header">
				<div class="row justify-content-center">
					<div class="col-lg-4">
						<div class="nav nav-pills faq-nav" id="faq-tabs" role="tablist" aria-orientation="vertical">
							<a href="#tab2" class="nav-link" data-toggle="pill" role="tab" aria-controls="tab2" aria-selected="false">
								<i class="fa fa-shopping-cart"></i> Getting Started
							</a>
							<a href="#tab1" class="nav-link active" data-toggle="pill" role="tab" aria-controls="tab1" aria-selected="true">
								<i class="fa fa-user"></i> Register as a Seller
							</a>
							<a href="#tab4" class="nav-link" data-toggle="pill" role="tab" aria-controls="tab4" aria-selected="false">
								<i class="fa fa-dashboard"></i> Dashboard
							</a>
							<a href="#tab3" class="nav-link" data-toggle="pill" role="tab" aria-controls="tab3" aria-selected="false">
								<i class="fa fa-address-card"></i> Profile
							</a>							
							<a href="#tab5" class="nav-link" data-toggle="pill" role="tab" aria-controls="tab5" aria-selected="false">
								<i class="fa fa-cube"></i> Cataloguing
							</a>
							<a href="#tab6" class="nav-link" data-toggle="pill" role="tab" aria-controls="tab6" aria-selected="false">
								<i class="fa fa-gift"></i> Order processing
							</a>
							<a href="#tab7" class="nav-link" data-toggle="pill" role="tab" aria-controls="tab6" aria-selected="false">
								<i class="fa fa-bus"></i> Returns
							</a>
							<a href="#tab8" class="nav-link" data-toggle="pill" role="tab" aria-controls="tab6" aria-selected="false">
								<i class="fa fa-credit-card"></i> Payouts
							</a>
						</div>
					</div>
					<div class="col-lg-8">
						<div class="tab-content" id="faq-tab-content">
							<div class="tab-pane show active" id="tab1" role="tabpanel" aria-labelledby="tab1">
								<div class="accordion" id="accordion-tab-1">
									<div class="card">
										<div class="card-header" id="accordion-tab-1-heading-1">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-1-content-1" aria-expanded="false" aria-controls="accordion-tab-1-content-1">Who can sell on Sadar24.com?</button>
											</h5>
										</div>
										<div class="collapse show" id="accordion-tab-1-content-1" aria-labelledby="accordion-tab-1-heading-1" data-parent="#accordion-tab-1">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>Sadar24 always welcomes Traders/ Companies / Entrepreneurs who wish to sell their products online. For this , you need to have the following:</p>
													<ul>
														<li>GST/GSTIN Number(It should be active at the time of registration).</li>
														<li>PAN Card.</li>
														<li>Bank account and supporting KYC documents (It should not be a digital account like Paytm, Airtel Bank etc).</li>
														<li>Brand Authorization Letter/Trademark Certificate (If you wish to sell your product under any particular Brand/Trademark then you will have to provide us for brand approval.</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
									<div class="card">
										<div class="card-header" id="accordion-tab-1-heading-2">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-1-content-2" aria-expanded="false" aria-controls="accordion-tab-1-content-2">How to sell on Sadar24.com?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-1-content-2" aria-labelledby="accordion-tab-1-heading-2" data-parent="#accordion-tab-1">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>You can start selling on Sadar24.com by submitting the required documents. We will assist you through our panel so that you can list your product and start selling.  After that our courier partner will pick up the product and deliver it to the customer.</p>
													<p>Once the order is successfully delivered to the customer, Sadar24.com will initiate your payment which will be processed within 3 working days after the date of delivery of the product.</p>
												</div>
											</div>
										</div>
									</div>
									<div class="card">
										<div class="card-header" id="accordion-tab-1-heading-3">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-1-content-3" aria-expanded="false" aria-controls="accordion-tab-1-content-3">What are the documents required to get registered on Sadar24.com as a Seller?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-1-content-3" aria-labelledby="accordion-tab-1-heading-3" data-parent="#accordion-tab-1">
											<div class="card-body">
												<div class="content-mrkt-places">
													<ul>
														<li>GST/GSTIN Number(It should be active at the time of registration).</li>
														<li>PAN Card.</li>
														<li>Bank account and supporting KYC documents (It should not be a digital account like Paytm, Airtel Bank etc).</li>
														<li>Brand Authorization Letter/Trademark Certificate (If you wish to sell your product under any particular Brand/Trademark then you will have to provide us for brand approval.</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
									<div class="card">
										<div class="card-header" id="accordion-tab-1-heading-4">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-1-content-4" aria-expanded="false" aria-controls="accordion-tab-1-content-4">Can I register if I do not have a GST/GSTIN number?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-1-content-4" aria-labelledby="accordion-tab-1-heading-4" data-parent="#accordion-tab-1">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>No, you must have a valid GST/GSTIN number to register with Sadar24.com. </p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-1-heading-5">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-1-content-5" aria-expanded="false" aria-controls="accordion-tab-1-content-5">Does Sadar24 charges anything for registration?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-1-content-5" aria-labelledby="accordion-tab-1-heading-5" data-parent="#accordion-tab-1">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>Listing of products on Sadar24.com is absolutely free. We don't charge anything for listing your products online.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-1-heading-6">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-1-content-6" aria-expanded="false" aria-controls="accordion-tab-1-content-6">What does message "Verification is still Pending" mean?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-1-content-6" aria-labelledby="accordion-tab-1-heading-6" data-parent="#accordion-tab-1">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>Document verification generally takes up to 1 to 2  working days. If the status is still pending then please send us a query via e-mail at seller@sadar24.com, or call us on our customer care Helpline: 7800-708-708 (Monday to Saturday)(10AM to 6PM) </p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-1-heading-7">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-1-content-7" aria-expanded="false" aria-controls="accordion-tab-1-content-7">My documents got rejected, what should I do?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-1-content-7" aria-labelledby="accordion-tab-1-heading-7" data-parent="#accordion-tab-1">
											<div class="card-body">
												<div class="content-mrkt-places">
													<ul>
														<li>You need to re-submit the correct documents via the Seller Portal. </li>
														<li>Login to the Seller Panel and start the procedure again.</li>
														<li>If Still there is any problem you can mail us seller@sadar24.com or Call us at our SellerCare Helpline: 7800-708-708 (Monday to Saturday)(10AM to 6PM)</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-1-heading-8">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-1-content-8" aria-expanded="false" aria-controls="accordion-tab-1-content-8">How do I start selling on Sadar24.com?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-1-content-8" aria-labelledby="accordion-tab-1-heading-8" data-parent="#accordion-tab-1">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>After all the required documents have been verified and your seller profile is complete, you can upload your pictures and related information  in the Seller Panel and start selling. </p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="tab2">
								<div class="accordion" id="accordion-tab-2">
									<div class="card">
										<div class="card-header" id="accordion-tab-2-heading-1">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-2-content-1" aria-expanded="false" aria-controls="accordion-tab-2-content-1">What is Market Place Agreement ?</button>
											</h5>
										</div>
										<div class="collapse show" id="accordion-tab-2-content-1" aria-labelledby="accordion-tab-2-heading-1" data-parent="#accordion-tab-2">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>It's for new users. You can read all the details and accept the same by clicking on the 'Accept' button (available at the bottom of the page). </p>
												</div>
											</div>
										</div>
									</div>
									<div class="card">
										<div class="card-header" id="accordion-tab-2-heading-2">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-2-content-2" aria-expanded="false" aria-controls="accordion-tab-2-content-2">Will any training be provided for the various functions of the seller panel?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-2-content-2" aria-labelledby="accordion-tab-2-heading-2" data-parent="#accordion-tab-2">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>Yes, we have put together a detailed training guide to help you get a comprehensive understanding of the seller panel. You can view it under our training program or you can go with our supporting videos available on Youtube Channel.</p>
												</div>
											</div>
										</div>
									</div>
									<div class="card">
										<div class="card-header" id="accordion-tab-2-heading-3">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-2-content-3" aria-expanded="false" aria-controls="accordion-tab-2-content-3">What does each tab indicate on seller panel?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-2-content-3" aria-labelledby="accordion-tab-2-heading-3" data-parent="#accordion-tab-2">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>There are various options available on the seller panel that you can use to manage your online business on Sadar24.com. Below are the uses of each tab:</p>
													<ul>
														<li>Dashboard – It helps you to check your performance as a seller on Sadar24.com.</li>
														<li>You can check various results from here such as your total sales, revenue etc. using this. </li>
														<li>Products – It helps you to manage your product’s inventory, MRP, selling price and status. </li>
														<li>Sale – It helps you to process and manage all the orders that you receive on Sadar24.com. You can check it under head of sale (on left of panel).</li>
														<li>Payment From Admin – It helps you to track your payments from Sadar24.</li>
														<li>Discount Coupon – It helps you to manage and track store coupons, flash and splash discounts.</li>
														<li>Ticket – It helps you to manage and track Support Tickets and Queries.</li>
														<li>Reports – It helps you export Reports based on Comparison, Stock and Wishlist.</li>
														<li>Manage Profile – It helps you to manage and track your particulars.</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
									<div class="card">
										<div class="card-header" id="accordion-tab-2-heading-4">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-2-content-4" aria-expanded="false" aria-controls="accordion-tab-2-content-4">Do you have any Helpline Number which I can use if I face/find any difficulty while operating my seller account?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-2-content-4" aria-labelledby="accordion-tab-2-heading-4" data-parent="#accordion-tab-2">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>Yes you may contact our support team on our Helpline Number 7800-708-708 (Monday to Saturday) from 10am to 6 pm or you can e-mail us at seller@sadar24.com</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-2-heading-5">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-2-content-5" aria-expanded="false" aria-controls="accordion-tab-2-content-5">What is my login Password?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-2-content-5" aria-labelledby="accordion-tab-2-heading-3" data-parent="#accordion-tab-2">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>Sadar24.com asks for your mobile number at the time of registration. This Mobile number will be your registered mobile number . So whenever you wish to login to your account an OTP will be send on your registered mobile  number as well as on your registered Mail ID. And after submitting that OTP you will be able to access your account. However Sadar24.com suggest you to not to share OTP with anybody.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-2-heading-6">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-2-content-6" aria-expanded="false" aria-controls="accordion-tab-2-content-6">How much commission does Sadar24.com charge on Selling products?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-2-content-6" aria-labelledby="accordion-tab-1-heading-6" data-parent="#accordion-tab-2">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>Sadar24.com is not charging any commission as of now but surely there will be logistic charges on it. To know more Click <a href="fee-structure">Here</a></p>
												</div>
											</div>
										</div>
									</div>
									
								</div>
							</div>
							
							<div class="tab-pane" id="tab3" role="tabpanel" aria-labelledby="tab3">
								<div class="accordion" id="accordion-tab-3">
									<div class="card">
										<div class="card-header" id="accordion-tab-3-heading-1">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-3-content-1" aria-expanded="false" aria-controls="accordion-tab-3-content-1">How can I check my profile details on the seller panel?</button>
											</h5>
										</div>
										<div class="collapse show" id="accordion-tab-3-content-1" aria-labelledby="accordion-tab-3-heading-1" data-parent="#accordion-tab-3">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>All the details submitted by you during your registration with Sadar24.com will be visible under the Profile tab on your seller panel.</p>
												</div>
											</div>
										</div>
									</div>
									<div class="card">
										<div class="card-header" id="accordion-tab-3-heading-2">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-3-content-2" aria-expanded="false" aria-controls="accordion-tab-3-content-2">I need my registered email ID or contact number changed. What do I need to do?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-3-content-2" aria-labelledby="accordion-tab-3-heading-2" data-parent="#accordion-tab-3">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>To edit your profile details like email id, contact number etc. you can go on manage profile tab of Seller Panel and from there you can update your new	details.</p>
												</div>
											</div>
										</div>
									</div>
									<div class="card">
										<div class="card-header" id="accordion-tab-3-heading-3">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-3-content-3" aria-expanded="false" aria-controls="accordion-tab-3-content-3">If I am going for a vacation/taking a break because of which I would not be able to operate. What shall I do?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-3-content-3" aria-labelledby="accordion-tab-3-heading-3" data-parent="#accordion-tab-3">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>To activate your vacation mode you will have to login in your seller panel from there click on the tab Manage Holidays. You can add holidays from here. Once you activate your vacation mode your products will be unpublished from the website and they will automatically be published when your vacation mode ends. Please Note :</p>
													<ul>
														<li>You need to apply for your scheduled holidays at least 7 days in advance.</li>
														<li>You have to dispatch all your orders before scheduling this mode.</li>
														<li>You can apply for a maximum three scheduled holidays in a calendar year.</li>
													</ul>
												</div>
											</div>
										</div>
									</div>									
								</div>
							</div>
							
							<div class="tab-pane" id="tab4" role="tabpanel" aria-labelledby="tab4">
								<div class="accordion" id="accordion-tab-4">
									<div class="card">
										<div class="card-header" id="accordion-tab-4-heading-1">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-4-content-1" aria-expanded="false" aria-controls="accordion-tab-4-content-1">What is the Dashboard tab and what is its use in the seller panel?</button>
											</h5>
										</div>
										<div class="collapse show" id="accordion-tab-4-content-1" aria-labelledby="accordion-tab-4-heading-1" data-parent="#accordion-tab-4">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>The Dashboard tab contains an overview of the various analytical parameters related to your online business on Sadar24.com. </p>
													<p><strong>You can check your performance based on the following parameters (for a selected date range):</strong></p>
													<ul>
														<li>Total sold means Total revenue generated through sales</li>
														<li>Payments released means Total amount credited/released to your account</li>
														<li>Catalogue out of stock means Percentage of products from your catalogue that were out of stock</li>
														<li>Category wise distribution means Distribution of your sales based on the category of the products</li>
														<li>Top selling products means List of your top ten best-selling products</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
									<div class="card">
										<div class="card-header" id="accordion-tab-4-heading-2">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-4-content-2" aria-expanded="false" aria-controls="accordion-tab-4-content-2">What are Pending Acknowledgement orders?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-4-content-2" aria-labelledby="accordion-tab-4-heading-2" data-parent="#accordion-tab-4">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>These are those orders that you have received but are yet to process. You get a count (or number) of all such orders so that you have an idea of how many new orders are to be processed.</p>
												</div>
											</div>
										</div>
									</div>
									<div class="card">
										<div class="card-header" id="accordion-tab-4-heading-3">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-4-content-3" aria-expanded="false" aria-controls="accordion-tab-4-content-3">What are pending shipment orders?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-4-content-3" aria-labelledby="accordion-tab-4-heading-3" data-parent="#accordion-tab-4">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>These are the orders that are needed to be shipped by generating their manifest and handing them over to the courier partner.</p>
												</div>
											</div>
										</div>
									</div>
									<div class="card">
										<div class="card-header" id="accordion-tab-4-heading-4">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-4-content-4" aria-expanded="false" aria-controls="accordion-tab-4-content-4">Can I apply a category-wise filter while viewing my Dashboard analytics in the graphical form?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-4-content-4" aria-labelledby="accordion-tab-4-heading-4" data-parent="#accordion-tab-4">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>Yes, you can apply a category-wise and a sub-category wise filter while viewing your Dashboard analytics in the graphical form.</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="tab-pane" id="tab5" role="tabpanel" aria-labelledby="tab5">
								<div class="accordion" id="accordion-tab-5">
									<div class="card">
										<div class="card-header" id="accordion-tab-5-heading-1">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-5-content-1" aria-expanded="false" aria-controls="accordion-tab-5-content-1">What is a Catalogue?</button>
											</h5>
										</div>
										<div class="collapse show" id="accordion-tab-5-content-1" aria-labelledby="accordion-tab-5-heading-1" data-parent="#accordion-tab-5">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>Catalogue is a showcase of all your products that are listed on Sadar24.com and visible to the customers . It consists of product details, brand, images, and prices.</p>
												</div>
											</div>
										</div>
									</div>
									<div class="card">
										<div class="card-header" id="accordion-tab-5-heading-2">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-5-content-2" aria-expanded="false" aria-controls="accordion-tab-5-content-2">What documents do I require to upload my catalogue on Sadar24.com?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-5-content-2" aria-labelledby="accordion-tab-5-heading-2" data-parent="#accordion-tab-5">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>To upload your catalogue on Sadar24.com, To upload your catalogue on Sadar24.com. You need to have a fully formatted csv file to listing all the details like Product title, Category, Unit, Weight, Rate etc. as well as the images of the products from different angles.</p>
													<p>Now, you can upload your catalogue using a skeleton template file available in the Bulk Upload Tab.</p>
												</div>
											</div>
										</div>
									</div>
									<div class="card">
										<div class="card-header" id="accordion-tab-5-heading-3">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-5-content-3" aria-expanded="false" aria-controls="accordion-tab-5-content-3">What is a Brand Authorization letter?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-5-content-3" aria-labelledby="accordion-tab-5-heading-3" data-parent="#accordion-tab-5">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>A Brand Authorization Letter is a document required to be submitted by a seller if they are selling products belonging to a particular brand. You will have to provide us the required document so that we can verify and active your brand on our panel.</p>
												</div>
											</div>
										</div>
									</div>
									<div class="card">
										<div class="card-header" id="accordion-tab-5-heading-4">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-5-content-4" aria-expanded="false" aria-controls="accordion-tab-5-content-4">What is a Trademark certificate?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-5-content-4" aria-labelledby="accordion-tab-5-heading-4" data-parent="#accordion-tab-5">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>A Trademark certificate is a document required to be submitted by a seller if they are selling their own (and not belonging to any particular brand) products. It is issued by the Government of India under the Trademark Act, 1999, and offers a seller complete ownership of their products on Sadar24.com.</p>
												</div>
											</div>
										</div>
									</div>									
									<div class="card">
										<div class="card-header" id="accordion-tab-5-heading-5">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-5-content-5" aria-expanded="false" aria-controls="accordion-tab-5-content-5">I want to sell food products. What are the documents I need to submit to list my products?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-5-content-5" aria-labelledby="accordion-tab-5-heading-5" data-parent="#accordion-tab-5">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>No, we are not selling food product through Sadar24.com.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-5-heading-6">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-5-content-6" aria-expanded="false" aria-controls="accordion-tab-5-content-6">How can I list my products on Sadar24.com?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-5-content-6" aria-labelledby="accordion-tab-5-heading-6" data-parent="#accordion-tab-5">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>You can list your products on Sadar24.com seller panel using a catalogue template. Check out this detailed training guide for more details. To list your products etc. you will have to get registered as a vendor on Sadar24.com then to list your products you can follow the guidelines and start selling for further information you can click <a href="learning-guides">here</a></p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-5-heading-7">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-5-content-7" aria-expanded="false" aria-controls="accordion-tab-5-content-7">Where can I check the image guidelines related to product submission?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-5-content-7" aria-labelledby="accordion-tab-5-heading-7" data-parent="#accordion-tab-5">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>You can check the image guidelines by clicking <a href="photography-policy">here</a></p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-5-heading-8">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-5-content-8" aria-expanded="false" aria-controls="accordion-tab-5-content-8">How many images per product are required?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-5-content-8" aria-labelledby="accordion-tab-5-heading-8" data-parent="#accordion-tab-5">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>The images defines your products . They helps in attracting more customers thus generating sales. So the no of images should be sufficient to shows specification of your products preferably sadar24.com advices to upload to 2
													to 4 pictures of your products depending on your products.</p>
													<p>My products already exist on other websites. Can I list my products on Sadar24.com using the same details I used to list them on those websites?</p>
													<p>Yes, you can list those products on Sadar24.com which you have listed on other websites.</p>
													<p><strong>In such cases, you need share the following details with us:</strong></p>
													<ul>
														<li>MRP</li>
														<li>Price</li>
														<li>SKU</li>
														<li>Product weight</li>
														<li>Product warranty (if applicable)</li>
														<li>Packaging dimension (if applicable)</li>
													</ul>
													<p>Along with these, we would also need other mandatory details according to the product type.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-5-heading-9">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-5-content-9" aria-expanded="false" aria-controls="accordion-tab-5-content-9">What is meant by Finance compliance (FC) failed?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-5-content-9" aria-labelledby="accordion-tab-5-heading-9" data-parent="#accordion-tab-5">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>This happens in case your bank account details via a mail with your KYC to supports sellercare@sadar24.com are not verified.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-5-heading-10">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-5-content-10" aria-expanded="false" aria-controls="accordion-tab-5-content-10">How can I update the inventory/stock/quantity of my products?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-5-content-10" aria-labelledby="accordion-tab-5-heading-10" data-parent="#accordion-tab-5">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>You can update inventory/stock/quantity of your products from the seller	panel itself. For that you will have to Select Products from there Select to all products. From here Select the product for which you wish to create	inventory click on stock fill the desired quantity and save.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-5-heading-11">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-5-content-11" aria-expanded="false" aria-controls="accordion-tab-5-content-11">What is product status? How can I update the status of my products?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-5-content-11" aria-labelledby="accordion-tab-5-heading-11" data-parent="#accordion-tab-5">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>The status of your products determines whether they will be visible to the customers or not. When you upload a product it remains Unfeatured in the list that means it is not visible to the customers. So you have to change the status to Featured so that the product is visible to the customers.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-5-heading-12">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-5-content-12" aria-expanded="false" aria-controls="accordion-tab-5-content-12">How can I update the MRP or the selling price of my products?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-5-content-12" aria-labelledby="accordion-tab-5-heading-12" data-parent="#accordion-tab-5">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>You can update the MRP and selling price of your products from the seller panel itself. For that you will have to Select Products from there Select to All products. From here Select the product for which you wish to change the selling price. Go to sale price section of your product list and from here you can edit the sale price.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-5-heading-13">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-5-content-13" aria-expanded="false" aria-controls="accordion-tab-5-content-13">How do I add a size chart for my products?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-5-content-13" aria-labelledby="accordion-tab-5-heading-13" data-parent="#accordion-tab-5">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>To add a size chart for your products, you will have to login to seller panel. In the end of product listing click on to at customer input option from there you can add the different sizes of your products.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-5-heading-14">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-5-content-14" aria-expanded="false" aria-controls="accordion-tab-5-content-14">How can I change the images of my products?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-5-content-14" aria-labelledby="accordion-tab-5-heading-14" data-parent="#accordion-tab-5">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>To change the images of your products. Go to seller panel you will have to Select Products from there Select to All products. From here Select the product for which you wish to change the image. You can delete the existing image and can upload the new image from here.</p>
												</div>
											</div>
										</div>
									</div>
																		
									<div class="card">
										<div class="card-header" id="accordion-tab-5-heading-15">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-5-content-15" aria-expanded="false" aria-controls="accordion-tab-5-content-15">How to update the packaging dimension and weight of my package?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-5-content-15" aria-labelledby="accordion-tab-5-heading-15" data-parent="#accordion-tab-5">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>To update the packaging dimension and weight of your products, you need to follow these steps. Go to seller panel you will have to Select Products from there Select to All Products. From here Select the product for which you wish to change the packing dimension and weight . You can edit the existing packing dimension and weight from here.</p>
												</div>
											</div>
										</div>
									</div>
																		
									<div class="card">
										<div class="card-header" id="accordion-tab-5-heading-16">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-5-content-16" aria-expanded="false" aria-controls="accordion-tab-5-content-16">How can I update description of my products?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-5-content-16" aria-labelledby="accordion-tab-5-heading-16" data-parent="#accordion-tab-5">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>To update the description of your products, you need to follow these steps. Go to seller panel you will have to Select Products from there Select to All Products. From here Select the product for which you wish to change the description. You can edit the description of your product from here.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-5-heading-17">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-5-content-17" aria-expanded="false" aria-controls="accordion-tab-5-content-17">What is the maximum limit of search keywords that can be entered?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-5-content-17" aria-labelledby="accordion-tab-5-heading-17" data-parent="#accordion-tab-5">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>For a single Product ID, you can add multiple keywords up to a maximum character limit of 128 (including spaces).</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-5-heading-18">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-5-content-18" aria-expanded="false" aria-controls="accordion-tab-5-content-18">How can I add/change keywords for products that have already been listed by me?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-5-content-18" aria-labelledby="accordion-tab-5-heading-18" data-parent="#accordion-tab-5">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>To update/change keywords of your products, you need to follow these steps. Go to seller panel you will have to Select Products from there Select to All Products. From here Select the product for which you wish to add/change the keywords. You can edit the add/change the keywords your product from here.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-5-heading-19">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-5-content-19" aria-expanded="false" aria-controls="accordion-tab-5-content-19">Would the inventory of my products get reduced automatically on the seller panel as soon as I receive an order?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-5-content-19" aria-labelledby="accordion-tab-5-heading-19" data-parent="#accordion-tab-5">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>Yes, the inventory of your products will get reduced automatically as soon as the order for them is placed.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-5-heading-20">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-5-content-20" aria-expanded="false" aria-controls="accordion-tab-5-content-20">I want to download a complete list of the all products in my catalogue. How can I do so?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-5-content-20" aria-labelledby="accordion-tab-5-heading-20" data-parent="#accordion-tab-5">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>You can download a complete list of all the products in your catalogue using these simple steps:</p>
													<p>Go to seller panel you will have to Select Products from there Select to All Products. From here you have an option of right side of the screen from where you can download the catalogue of all your products. You can download it in the format of CSV file or in MS EXCEL format.</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="tab-pane" id="tab6" role="tabpanel" aria-labelledby="tab6">
								<div class="accordion" id="accordion-tab-6">
									<div class="card">
										<div class="card-header" id="accordion-tab-6-heading-1">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-6-content-1" aria-expanded="false" aria-controls="accordion-tab-6-content-1">What is an Order?</button>
											</h5>
										</div>
										<div class="collapse show" id="accordion-tab-6-content-1" aria-labelledby="accordion-tab-6-heading-1" data-parent="#accordion-tab-6">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>An order is generated by the system whenever a customer purchases your products(s). All the orders that you receive are visible on your seller panel.</p>
													<p>Once received, you need to process the order as per the guidelines and our shipping partner will take the order from your address to deliver it to the customers.</p>
												</div>
											</div>
										</div>
									</div>
									<div class="card">
										<div class="card-header" id="accordion-tab-6-heading-2">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-6-content-2" aria-expanded="false" aria-controls="accordion-tab-6-content-2">How many types of Orders are there?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-6-content-2" aria-labelledby="accordion-tab-6-heading-2" data-parent="#accordion-tab-6">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p><strong>There are two types of Order:</strong></p>
													<p><strong>Single Item Order</strong> – When a customer purchases a single quantity of your product. This type of order has a single order ID and a single Item ID.</p>
													<p><strong>Multiple Items Order</strong> - When a customer purchases multiple quantities of your product or single/multiple quantities of multiple products belonging to you. This type of order has a single Order ID and multiple Item IDs.</p>
												</div>
											</div>
										</div>
									</div>
									<div class="card">
										<div class="card-header" id="accordion-tab-6-heading-3">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-6-content-3" aria-expanded="false" aria-controls="accordion-tab-6-content-3">What is the difference between an Order ID and an Unique ID?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-6-content-3" aria-labelledby="accordion-tab-6-heading-3" data-parent="#accordion-tab-6">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>For every particular order, a unique order ID is generated and for each item, a unique item ID is generated.</p>
													<p>In case an order has more than one item or more than one quantity of the same item (also known as a Multiple item order), it will have single Order ID and multiple Unique IDs</p>
												</div>
											</div>
										</div>
									</div>
									<div class="card">
										<div class="card-header" id="accordion-tab-6-heading-4">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-6-content-4" aria-expanded="false" aria-controls="accordion-tab-6-content-4">How can I check if I have received a new Order?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-6-content-4" aria-labelledby="accordion-tab-6-heading-4" data-parent="#accordion-tab-6">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>Go to seller panel from there click on to sale tab here you can check for new order received. You will have to click on Confirm button against the order placed and pack it as per instructions.</p>
												</div>
											</div>
										</div>
									</div>									
									<div class="card">
										<div class="card-header" id="accordion-tab-6-heading-5">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-6-content-5" aria-expanded="false" aria-controls="accordion-tab-6-content-5">Will I get any notification if and when I receieve a new order?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-6-content-5" aria-labelledby="accordion-tab-6-heading-5" data-parent="#accordion-tab-6">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>Yes, you will receive a notification on your registered Email Id with the billing and shipping address of the customer.</p>
													<p>You will have to go to sale tab in seller panel to process the order further. But we advise you log in to your seller panel regularly to check if you have received a new order.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-6-heading-6">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-6-content-6" aria-expanded="false" aria-controls="accordion-tab-6-content-6">How can I download a list containing all my new Orders?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-6-content-6" aria-labelledby="accordion-tab-6-heading-6" data-parent="#accordion-tab-6">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p><strong>You can download a list of all your new orders in the CSV format by following these steps:</strong></p>
													<ul>
														<li>Go to the Sale tab</li>
														<li>Click on the (CSV) button available at the right side of the panel</li>
														<li>A pop-up will appear. Select the Date range in this pop-up</li>
														<li>Click on the Download button</li>
														<li>A CSV file will be downloaded in the Downloads.</li>
													</ul>
													<p>You can then download it to your system.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-6-heading-7">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-6-content-7" aria-expanded="false" aria-controls="accordion-tab-6-content-7">Who will process my orders?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-6-content-7" aria-labelledby="accordion-tab-6-heading-7" data-parent="#accordion-tab-6">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>Once you Order You are required to pack the order as per packing instructions. Then our Logistic Partner will pick the shipment from your business address and will deliver it to the customer.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-6-heading-8">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-6-content-8" aria-expanded="false" aria-controls="accordion-tab-6-content-8">How to order the packaging material to pack my orders? When should I order it?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-6-content-8" aria-labelledby="accordion-tab-6-heading-8" data-parent="#accordion-tab-6">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>You will have to go to seller.sadar24.com login with your OTP from there go to packing instructions.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-6-heading-9">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-6-content-9" aria-expanded="false" aria-controls="accordion-tab-6-content-9">What are the set packaging guidelines that I need to follow while packing my products?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-6-content-9" aria-labelledby="accordion-tab-6-heading-9" data-parent="#accordion-tab-6">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>Packing their products in accordance with the set Sadar24.com packaging 	guidelines is a must for all sellers as the courier partner will not pick up the product if they are not being followed. Click <a href="packing-instruction">here</a> to know about these guidelines in detail. The Set packaging guidelines are clearly mentioned on website seller.sadar24.com wherein you can login by OTP and see the details in seller policies under packing instructions.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-6-heading-10">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-6-content-10" aria-expanded="false" aria-controls="accordion-tab-6-content-10">What is the use of the Sort By option?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-6-content-10" aria-labelledby="accordion-tab-6-heading-10" data-parent="#accordion-tab-6">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>The Sort By option makes the sorting of your orders easier. Using this, you can sort your orders according to their Ship By Dates, Manifest Dates, or Order Dates.</p>
													<p>We recommend you sort your orders by their Ship By dates so that the orders with lesser shipping time appear on the top, allowing you to process them first.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-6-heading-11">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-6-content-11" aria-expanded="false" aria-controls="accordion-tab-6-content-11">I have received a multiple item order. Do I need to pack all the items in a single package?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-6-content-11" aria-labelledby="accordion-tab-6-heading-11" data-parent="#accordion-tab-6">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>Yes, you need to pack all the items in a single packet in such cases before processing them.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-6-heading-12">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-6-content-12" aria-expanded="false" aria-controls="accordion-tab-6-content-12">Should I insert the Sadar24.com invoice inside the packet?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-6-content-12" aria-labelledby="accordion-tab-6-heading-12" data-parent="#accordion-tab-6">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>Yes, you are required to insert the invoice inside the packet. And another copy should be pasted outside the package. But first, you first need to fold the Sadar24.com invoice in such a way that its details are not visible outside. Then, you need to insert it into a small transparent pouch and paste that pouch outside the packet.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-6-heading-13">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-6-content-13" aria-expanded="false" aria-controls="accordion-tab-6-content-13">How to paste the packing slip on the packet?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-6-content-13" aria-labelledby="accordion-tab-6-heading-13" data-parent="#accordion-tab-6">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>The document PDF File contains 3 pages 1 is customer copy of invoice that has to be inserted in the package box 2 is the packing slip that has to packed on the ceiling line of the box &amp; 3 is the manifest that contains the unique [QR] Bar code that facilitates the tracking process your package. it has to be posted outside of box.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-6-heading-14">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-6-content-14" aria-expanded="false" aria-controls="accordion-tab-6-content-14">How to process a single item order?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-6-content-14" aria-labelledby="accordion-tab-6-heading-14" data-parent="#accordion-tab-6">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p><strong>You can process your single item orders in three simple steps:</strong></p>
													<p>– Go to the Sale tab</p>
													<p>– Check order status column in the list of orders, the orders that require seller action are marked with the pending status.</p>
													<p>– Click on the Approve button and generate the invoice to start processing the order.</p>
												</div>
											</div>
										</div>
									</div>
																		
									<div class="card">
										<div class="card-header" id="accordion-tab-6-heading-15">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-6-content-15" aria-expanded="false" aria-controls="accordion-tab-6-content-15">At what time should I generate the manifest so that my products can be picked up on the same day?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-6-content-15" aria-labelledby="accordion-tab-6-heading-15" data-parent="#accordion-tab-6">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>If you generate the manifest before 12 noon, your products will be picked up by the courier partners on the same day (anytime till 6* p.m.). If you generate the manifest after 12 noon, your products will be picked up the next day.</p>
													<p>If your orders are not picked up in the timeline mentioned above, you need to raise a ticket for the same using the Ticket tab.</p>
													<p>*5 p.m. for Delhi-NCR sellers</p>
												</div>
											</div>
										</div>
									</div>
																		
									<div class="card">
										<div class="card-header" id="accordion-tab-6-heading-16">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-6-content-16" aria-expanded="false" aria-controls="accordion-tab-6-content-16">Where can I see all the orders I have shipped?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-6-content-16" aria-labelledby="accordion-tab-6-heading-16" data-parent="#accordion-tab-6">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p><strong>Shipped orders are those orders which have been picked up and scanned by the courier. To check your shipped orders, follow these steps:</strong></p>
													<ul>
														<li>– Go to the Orders tab</li>
														<li>– Click on the More tab and select Shipped from the dropdown menu</li>
													</ul>
													<p>You will be able to check all your shipped orders here.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-6-heading-17">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-6-content-17" aria-expanded="false" aria-controls="accordion-tab-6-content-17">Where can I see all the orders that have been delivered?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-6-content-17" aria-labelledby="accordion-tab-6-heading-17" data-parent="#accordion-tab-6">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>Once an order is delivered to the customer, the status of that order gets marked as Delivered. To check all your delivered orders, you can log into your seller panel under the Sale tab you can get all the details of delivered orders.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-6-heading-18">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-6-content-18" aria-expanded="false" aria-controls="accordion-tab-6-content-18">How can I download a duplicate copy of the Packing slip/Manifest?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-6-content-18" aria-labelledby="accordion-tab-6-heading-18" data-parent="#accordion-tab-6">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>To download the duplicate copy of the Packing slip/Manifest you have to login in your seller panel click on Sale click on order from there you can download the duplicate copy of invoice.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-6-heading-19">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-6-content-19" aria-expanded="false" aria-controls="accordion-tab-6-content-19">How can I cancel an order if I want to?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-6-content-19" aria-labelledby="accordion-tab-6-heading-19" data-parent="#accordion-tab-6">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>If You want to cancel an order if, for any reason, you want to do so. You will have to login in your seller panel click on Sale tab from there you can cancel the order you wish to.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-6-heading-20">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-6-content-20" aria-expanded="false" aria-controls="accordion-tab-6-content-20">What are the penalties I can incur if I cancel an order?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-6-content-20" aria-labelledby="accordion-tab-6-heading-20" data-parent="#accordion-tab-6">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>If you cancel an order within its SLA, you will be charged only the Cancellation penalty, i.e., either 10% of the selling price or Rs.50 (whichever is higher).</p>
													<p>However, if you cancel an order after its SLA has been breached, you will also be charged the SLA Breach penalty along with the Cancellation penalty. The SLA Breach penalty is either 33% of the selling price or Rs.35 (whichever is higher). Check out this detailed training guide on the same.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-6-heading-21">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-6-content-21" aria-expanded="false" aria-controls="accordion-tab-6-content-21">Where can I see all my cancelled orders?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-6-content-21" aria-labelledby="accordion-tab-6-heading-21" data-parent="#accordion-tab-6">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>You will have to log into your Seller Panel. From here on clicking the Sale Tab you can check all your cancelled orders.</p>
													<p><strong>There are two types of cancelled orders that you can check here:</strong></p>
													<ul>
														<li>Orders having the status ‘Merchant cancelled’ – These are those orders that have been canceled by you. You will be charged a cancellation penalty for all such orders.</li>
														<li>Orders having the status ‘Cancelled’ – These are those orders that have been cancelled by the customers. You will not be charged any cancellation penalty for such orders.</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-6-heading-22">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-6-content-22" aria-expanded="false" aria-controls="accordion-tab-6-content-22">My product has not been picked yet. What should I do?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-6-content-22" aria-labelledby="accordion-tab-6-heading-22" data-parent="#accordion-tab-6">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>The courier partner is automatically informed for your pickups when you generate the manifest. If you generate the manifest before 12 noon, your products will be picked up by the courier partners on the same day (anytime till 6* p.m.). If you generate the manifest after 12 noon, your products will be picked up the next day.</p>
													<p>If your orders are not picked up in the timeline mentioned above, you you can mail us at sellercare@sadar24.com or you can call us at our Helpline Number 7800-708-708.</p>
													<p>*5 p.m. for Delhi-NCR sellers</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-6-heading-23">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-6-content-23" aria-expanded="false" aria-controls="accordion-tab-6-content-23">How can I check the status of my order?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-6-content-23" aria-labelledby="accordion-tab-6-heading-23" data-parent="#accordion-tab-6">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>To check the status of your orders you will have to log into your seller panel. Under the Sale tab you can check the status of your all product orders.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-6-heading-24">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-6-content-24" aria-expanded="false" aria-controls="accordion-tab-6-content-24">Why is my order appearing as 'Cancelled by merchant' when I didn't cancel the order?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-6-content-24" aria-labelledby="accordion-tab-6-heading-24" data-parent="#accordion-tab-6">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>When an order is not marked ‘Shipped’ within its SLA, the order may get auto-cancelled. The status of such cancelled orders will be ‘Merchant Cancelled’. You can check the order history by log into your Seller Panel then under Sale Tab you can view all the details of orders &#39;Cancelled by merchant&#39;.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-6-heading-25">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-6-content-25" aria-expanded="false" aria-controls="accordion-tab-6-content-25">Do I need to share a scanned copy of the signed manifest?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-6-content-25" aria-labelledby="accordion-tab-6-heading-25" data-parent="#accordion-tab-6">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>No, you do not need to share a scanned copy of the manifest. However, you are advised to keep it with you for future references.</p>
												</div>
											</div>
										</div>
									</div>
									<div class="card">
										<div class="card-header" id="accordion-tab-6-heading-26">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-6-content-26" aria-expanded="false" aria-controls="accordion-tab-6-content-26">How to download the sales report?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-6-content-26" aria-labelledby="accordion-tab-6-heading-26" data-parent="#accordion-tab-6">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>You will have to log into your Seller Panel. On this panel click on the Reports. Under the Reports section a new window of Product Stock will open. From	here you can download your Sales Report.</p>
												</div>
											</div>
										</div>
									</div>									
								</div>
							</div>
							
							<div class="tab-pane" id="tab7" role="tabpanel" aria-labelledby="tab7">
								<div class="accordion" id="accordion-tab-7">
									<div class="card">
										<div class="card-header" id="accordion-tab-7-heading-1">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-7-content-1" aria-expanded="false" aria-controls="accordion-tab-7-content-1">What are Return orders?</button>
											</h5>
										</div>
										<div class="collapse show" id="accordion-tab-7-content-1" aria-labelledby="accordion-tab-7-heading-1" data-parent="#accordion-tab-7">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>When your shipped orders are returned to you due to any reason, they are	called Return orders. There are two types of Return orders:</p>
													<ul>
														<li>Return before delivery or RTO orders – If any order is not delivered to
														the customer due to any reason, it will be returned to you. These orders
														are called Return before delivery or RTO orders.</li>
														<li>Return after delivery or DTO orders – If a customer finds any issue in
														your product, he/she may return it (if applicable) as per the return policy.</li>  
													</ul>
													<p>These orders will be returned to you and are called Return after delivery or	RTO order.</p>
												</div>
											</div>
										</div>
									</div>
									<div class="card">
										<div class="card-header" id="accordion-tab-7-heading-2">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-7-content-2" aria-expanded="false" aria-controls="accordion-tab-7-content-2">In how many days will I receive my Return order?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-7-content-2" aria-labelledby="accordion-tab-7-heading-2" data-parent="#accordion-tab-7">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p><strong>In case of:</strong></p>
													<ul>
														<li>An RTO (Return before delivery) order: The product will be returned to you within 15 days from the date of being marked as "Shipped" on the seller panel.</li>
														<li>A DTO (Return after delivery) order: The product will be returned to you within 15 days from the date of being marked as ‘Return Picked’ on the Seller Panel.</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
									<div class="card">
										<div class="card-header" id="accordion-tab-7-heading-3">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-7-content-3" aria-expanded="false" aria-controls="accordion-tab-7-content-3">Will I get any SMS or email notification for my Return orders?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-7-content-3" aria-labelledby="accordion-tab-7-heading-3" data-parent="#accordion-tab-7">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>Yes , you will not get any notification for your Return orders. However, you can always check and track your Return orders from your seller panel.</p>
												</div>
											</div>
										</div>
									</div>
									<div class="card">
										<div class="card-header" id="accordion-tab-7-heading-4">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-7-content-4" aria-expanded="false" aria-controls="accordion-tab-7-content-4">What charges are deducted for an RTO or Return before delivery order?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-7-content-4" aria-labelledby="accordion-tab-7-heading-4" data-parent="#accordion-tab-7">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>No charges are deducted in case of an RTO or Return before delivery order.</p>
												</div>
											</div>
										</div>
									</div>									
									<div class="card">
										<div class="card-header" id="accordion-tab-7-heading-5">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-7-content-5" aria-expanded="false" aria-controls="accordion-tab-7-content-5">What charges are deducted for a DTO or Return after delivery order?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-7-content-5" aria-labelledby="accordion-tab-7-heading-5" data-parent="#accordion-tab-7">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>In case of a DTO or Return after delivery order, forward and reverse logistics along with the payment gateway fee will be charged. To know more Click <a href="return-reverse-policy">here</a></p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-7-heading-6">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-7-content-6" aria-expanded="false" aria-controls="accordion-tab-7-content-6">What are Reverse logistics charges?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-7-content-6" aria-labelledby="accordion-tab-7-heading-6" data-parent="#accordion-tab-7">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>When a customer returns your product, a shipping fee is charged for its journey back to you. This fee is called Reverse logistics charges. Click <a href="return-reverse-policy">here</a> to know about these charges in full detail.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-7-heading-7">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-7-content-7" aria-expanded="false" aria-controls="accordion-tab-7-content-7">What does 'Return initiated' (under the Return before delivery tab) mean?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-7-content-7" aria-labelledby="accordion-tab-7-heading-7" data-parent="#accordion-tab-7">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>Whenever the delivery of an order to your customer fails, that order will be returned to you. When the reverse journey of such an order is initiated, it will be visible under the ‘Return Initiated’ tab.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-7-heading-8">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-7-content-8" aria-expanded="false" aria-controls="accordion-tab-7-content-8">What does 'Return delivered' (under the Return before delivery tab) mean?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-7-content-8" aria-labelledby="accordion-tab-7-heading-8" data-parent="#accordion-tab-7">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>Whenever the delivery of an order to your customer fails, that order will be returned to you. If this order has been delivered to you. it will be visible under the ‘Return Delivered’ tab.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-7-heading-9">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-7-content-9" aria-expanded="false" aria-controls="accordion-tab-7-content-9">What does 'Approved' (under the Return after delivery tab) mean?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-7-content-9" aria-labelledby="accordion-tab-7-heading-9" data-parent="#accordion-tab-7">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>All DTO orders are approved after a preliminary investigation by Sadar24.com. All orders that have been approved as per this investigation are visible under "Approved" tab.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-7-heading-10">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-7-content-10" aria-expanded="false" aria-controls="accordion-tab-7-content-10">What does 'Picked' (under the Return after delivery tab) mean?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-7-content-10" aria-labelledby="accordion-tab-7-heading-10" data-parent="#accordion-tab-7">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>This tab contains all those DTO orders which have been picked up from the customer by our delivery partner. All such Return orders that have been picked up will be visible under "Picked" tab.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-7-heading-11">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-7-content-11" aria-expanded="false" aria-controls="accordion-tab-7-content-11">What does 'Returned' (under the Return after delivery tab) mean?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-7-content-11" aria-labelledby="accordion-tab-7-heading-11" data-parent="#accordion-tab-7">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>Returned orders are those DTO orders which have been successfully returned to you. All such returned orders will be visible under the ‘Returned’ tab.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-7-heading-12">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-7-content-12" aria-expanded="false" aria-controls="accordion-tab-7-content-12"> How to download the Returns report?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-7-content-12" aria-labelledby="accordion-tab-7-heading-12" data-parent="#accordion-tab-7">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>You can download the Returns report from your seller panel itself.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-7-heading-13">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-7-content-13" aria-expanded="false" aria-controls="accordion-tab-7-content-13">I did not receive my return order but it is marked as 'Return delivered' on my seller panel. What do I do?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-7-content-13" aria-labelledby="accordion-tab-7-heading-13" data-parent="#accordion-tab-7">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>If a return order is marked as Return delivered/RTO delivered/Returned on the seller panel and you have not received it, you need to raise a ticket using the Support tab within the next 7 days from the date it was marked Returned delivered/ROT delivered/Returned on the seller panel. You can also mail us at Seller@sadar24.com or call us as 7800-708-708 from Monday to Saturday (10 am to 6 pm).</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-7-heading-14">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-7-content-14" aria-expanded="false" aria-controls="accordion-tab-7-content-14">I have received a Return order, what should I do before opening the packet?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-7-content-14" aria-labelledby="accordion-tab-7-heading-14" data-parent="#accordion-tab-7">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>Whenever you receive your return order, always check its outer condition and if you find something suspicious, you must mention the same on the POD of the courier partner. Along with this, you should record a non video stop while of opening the packet. If you have any dispute related to your return order, you can raise a claim/dispute using the Support tab on the seller panel.</p>
												</div>
											</div>
										</div>
									</div>
																		
									<div class="card">
										<div class="card-header" id="accordion-tab-7-heading-15">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-7-content-15" aria-expanded="false" aria-controls="accordion-tab-7-content-15">I have some issue with my Return order/I have received a damaged Return order/Item is missing from the Return order. What should I do?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-7-content-15" aria-labelledby="accordion-tab-7-heading-15" data-parent="#accordion-tab-7">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>For any dispute/issue regarding your return orders, you need to raise a claim/dispute using the Support tab on your seller panel.</p>
												</div>
											</div>
										</div>
									</div>						
								</div>
							</div>
							
							<div class="tab-pane" id="tab8" role="tabpanel" aria-labelledby="tab8">
								<div class="accordion" id="accordion-tab-8">
									<div class="card">
										<div class="card-header" id="accordion-tab-8-heading-1">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-8-content-1" aria-expanded="false" aria-controls="accordion-tab-8-content-1">When will I receive my payment for the orders I have shipped?</button>
											</h5>
										</div>
										<div class="collapse show" id="accordion-tab-8-content-1" aria-labelledby="accordion-tab-8-heading-1" data-parent="#accordion-tab-8">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>Your payout will be processed within 3 working days after the date of the delivery of the product. Conditionally that your products are non-refundable/non returnable . In case your products falls in category than the payment	cycle will start from day return ends.</p>
												</div>
											</div>
										</div>
									</div>
									<div class="card">
										<div class="card-header" id="accordion-tab-8-heading-2">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-8-content-2" aria-expanded="false" aria-controls="accordion-tab-8-content-2">What are the charges deducted from my payout?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-8-content-2" aria-labelledby="accordion-tab-8-heading-2" data-parent="#accordion-tab-8">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>Click <a href="fee-structure">here</a> to check the details of the various charges deducted from the selling price of your product. </p>
												</div>
											</div>
										</div>
									</div>
									<div class="card">
										<div class="card-header" id="accordion-tab-8-heading-3">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-8-content-3" aria-expanded="false" aria-controls="accordion-tab-8-content-3">What does TCS mean?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-8-content-3" aria-labelledby="accordion-tab-8-heading-3" data-parent="#accordion-tab-8">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>It is a Govt.-authorized Tax that is deducted from your payout and deposited to the govt. It is charged as 0.75 % of the base price (selling price – applicable GST on the product).</p>
												</div>
											</div>
										</div>
									</div>
									<div class="card">
										<div class="card-header" id="accordion-tab-8-heading-4">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-8-content-4" aria-expanded="false" aria-controls="accordion-tab-8-content-4">What does TDS u/s 194-O mean?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-8-content-4" aria-labelledby="accordion-tab-8-heading-4" data-parent="#accordion-tab-8">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>Tax Deducted at Source (TDS) under section 194-O mandates e-commerce companies to deduct TDS on sales of goods and services through their platform. This will be effective from 1 October 2020. The rate of TDS applicable will be 0.75% (of the base selling price) from October 1 2020 to 31 March 2021 and will be 1% (of the base selling price) post 31st March 2021. However, in cases wherein the PAN is unavailable or invalid, TDS at 5% will be applicable.</p>
												</div>
											</div>
										</div>
									</div>									
									<div class="card">
										<div class="card-header" id="accordion-tab-8-heading-5">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-8-content-5" aria-expanded="false" aria-controls="accordion-tab-8-content-5">What is a UTR number?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-8-content-5" aria-labelledby="accordion-tab-8-heading-5" data-parent="#accordion-tab-8">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>Whenever a transaction is made through a bank, a Unique Transaction Reference (UTR) number is generated by the bank. It can be used as a source of reference for that particular transaction.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-8-heading-6">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-8-content-6" aria-expanded="false" aria-controls="accordion-tab-8-content-6">What are the various penalties that can be levied on me?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-8-content-6" aria-labelledby="accordion-tab-8-heading-6" data-parent="#accordion-tab-8">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>There are various penalties which can be levied on you if you do not adhere to the set Sadar24.com policies and timelines. Click <a href="merchant-penalties">here</a> to know about these penalties in detail.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-8-heading-7">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-8-content-7" aria-expanded="false" aria-controls="accordion-tab-8-content-7">What does Cancellation penalty mean?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-8-content-7" aria-labelledby="accordion-tab-8-heading-7" data-parent="#accordion-tab-8">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>Whenever you cancel your order or it is auto-cancelled in case you have not processed it within its set timeline, you will be charged a Cancellation penalty. For complete information about the same, To know more Click <a href="merchant-penalties">here</a></p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-8-heading-8">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-8-content-8" aria-expanded="false" aria-controls="accordion-tab-8-content-8">What does SLA breach penalty mean?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-8-content-8" aria-labelledby="accordion-tab-8-heading-8" data-parent="#accordion-tab-8">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>Whenever you receive an order, you need to ensure that it is marked as shipped within its set timeline (Ship By Date &amp; time). If you fail to do the same, you will be charged an SLA breach penalty. For complete information about the same, To know more Click <a href="merchant-penalties">here</a></p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-8-heading-9">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-8-content-9" aria-expanded="false" aria-controls="accordion-tab-8-content-9">What charges are deducted for an RTO or return before delivery order?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-8-content-9" aria-labelledby="accordion-tab-8-heading-9" data-parent="#accordion-tab-8">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>No charge is deducted in case of an RTO or return before delivery order.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-8-heading-10">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-8-content-10" aria-expanded="false" aria-controls="accordion-tab-8-content-10">What charges are deducted for a DTO or return after delivery order?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-8-content-10" aria-labelledby="accordion-tab-8-heading-10" data-parent="#accordion-tab-8">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>In case of a DTO or return after delivery order, the forward and reverse logistics along with the payment gateway fee will be charged. To know more about the charges Click <a href="return-reverse-policy">here</a></p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-8-heading-11">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-8-content-11" aria-expanded="false" aria-controls="accordion-tab-8-content-11">What is fraud? What are the penalties that can be levied on me in case of any involvement in fraudulent activities?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-8-content-11" aria-labelledby="accordion-tab-8-heading-11" data-parent="#accordion-tab-8">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>Fraud at Sadar24.com is considered to be a deliberate action of deceiving Sadar24.com or its partners to secure unfair or unlawful gain which may hamper customer experience directly or indirectly as well as may cause damages (Financial, Brand Image, False Representation, Loss of Business) to	Sadar24.com, its resources, or its partners.</p>
													<p><strong>Remember:</strong> Being involved in fraudulent activrties may result in you being penalised. To know all about such penalties Click <a href="merchant-penalties">here</a></p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-8-heading-12">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-8-content-12" aria-expanded="false" aria-controls="accordion-tab-8-content-12">What are the various adjustments that can be made in my payout?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-8-content-12" aria-labelledby="accordion-tab-8-heading-12" data-parent="#accordion-tab-8">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>Any credit or debit made against your order’s payout is called Adjustment. Example of such adjustments are: Return charges for a return order, cancellation penalty (if any), recovery of payment credited against any return order, etc.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-8-heading-13">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-8-content-13" aria-expanded="false" aria-controls="accordion-tab-8-content-13">What is meant by Forward logistics charges?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-8-content-13" aria-labelledby="accordion-tab-8-heading-13" data-parent="#accordion-tab-8">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>Whenever a product is delivered to the customer, the logistics fee charged to you for the forward journey is called Forward logistics charge.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-8-heading-14">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-8-content-14" aria-expanded="false" aria-controls="accordion-tab-8-content-14"> What is meant by Reverse logistics charges?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-8-content-14" aria-labelledby="accordion-tab-8-heading-14" data-parent="#accordion-tab-8">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>Whenever a customer returns your product, the logistics charge is charged to you for the reverse journey is called Reverse logistics charge.</p>
												</div>
											</div>
										</div>
									</div>
																		
									<div class="card">
										<div class="card-header" id="accordion-tab-8-heading-15">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-8-content-15" aria-expanded="false" aria-controls="accordion-tab-8-content-15">How to check the breakup of my payout on the seller panel?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-8-content-15" aria-labelledby="accordion-tab-8-heading-15" data-parent="#accordion-tab-8">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>You can check the payout breakup and details of all charges deducted from your payout on the seller panel itself. Click <a href="fee-structure">here</a> to know more.</p>
												</div>
											</div>
										</div>
									</div>
																		
									<div class="card">
										<div class="card-header" id="accordion-tab-8-heading-16">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-8-content-16" aria-expanded="false" aria-controls="accordion-tab-8-content-16">How to understand the Settlement-wise payout report?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-8-content-16" aria-labelledby="accordion-tab-8-heading-16" data-parent="#accordion-tab-8">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>The Settlement-wise payout report contains the details related to your payout according to your settlements (orders against which payment has been credited to your account).</p>
													<p>Check out this detailed training guide for complete information on the same.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-8-heading-17">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-8-content-17" aria-expanded="false" aria-controls="accordion-tab-8-content-17">How to understand Order-wise payout report?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-8-content-17" aria-labelledby="accordion-tab-8-heading-17" data-parent="#accordion-tab-8">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>The Order-wise payout report contains the details related to your payout according to your orders.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-8-heading-18">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-8-content-18" aria-expanded="false" aria-controls="accordion-tab-8-content-18">How do I download the Sales report?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-8-content-18" aria-labelledby="accordion-tab-8-heading-18" data-parent="#accordion-tab-8">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>The Sales report is the detailed report of your overall sales on Sadar24.com.</p>
													<p><strong>Follow these steps to download it:</strong></p>
													<ul>
														<li>Go to the Payments tab and select Payouts</li>
														<li>Click on Orderwise Payouts</li>
														<li>Hover the mouse on the Download Order Details(New Format)</li>
														<li>Click on Download sales report</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-8-heading-19">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-8-content-19" aria-expanded="false" aria-controls="accordion-tab-8-content-19">What is a commission invoice? What charges are mentioned on it? When and how can I download it?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-8-content-19" aria-labelledby="accordion-tab-8-heading-19" data-parent="#accordion-tab-8">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>A commission invoice is a commercial document issued monthly by Sadar24.com. It includes all the commission details, like the marketplace fee,logistics fee, payment gateway fee etc. of the orders transacted in a particular month.</p>
													<p>The Commission invoice for a particular month will be published on the seller panel on the 5th or 6th of the following month. You can download it from your seller panel itself in two formats – the PDF format (which contains summarised details of all the commission charges) and the CSV format (which contains order level details of all the commission charges).</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-8-heading-20">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-8-content-20" aria-expanded="false" aria-controls="accordion-tab-8-content-20">What is the GST report? When and how can I download it to file my GST returns?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-8-content-20" aria-labelledby="accordion-tab-8-heading-20" data-parent="#accordion-tab-8">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>It is a report that contains the details of all the sales transacted in your seller panel account. You can use this report while filling your GST returns.</p>
													<p>All your GST reports for a particular month will be published on the 2nd of the following month. For example, the GST report for August 2020 will provided to you on 2nd September 2020.</p>
													<p>You can download it from your seller panel itself.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-8-heading-21">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-8-content-21" aria-expanded="false" aria-controls="accordion-tab-8-content-21">How can I check a customer's GSTIN?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-8-content-21" aria-labelledby="accordion-tab-8-heading-21" data-parent="#accordion-tab-8">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>You can check the customer’s GSTIN in the GST report available on the seller panel. Please ensure that you consider those sales as B2B sales where customer GSTIN available and file their return as per the guidelines.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-8-heading-22">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-8-content-22" aria-expanded="false" aria-controls="accordion-tab-8-content-22">I have not received my payment yet. What should I do?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-8-content-22" aria-labelledby="accordion-tab-8-heading-22" data-parent="#accordion-tab-8">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>Your payout will be processed within 3 working days after the date of the delivery of the product". In case you have a query please feel free to reach us at seller@sadar24.com or call us at 7800-708-708(Monday - Saturday from 10:00 AM to 6:00 PM).</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-8-heading-23">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-8-content-23" aria-expanded="false" aria-controls="accordion-tab-8-content-23"> Why I have received a payout different than the one I expected?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-8-content-23" aria-labelledby="accordion-tab-8-heading-23" data-parent="#accordion-tab-8">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>The payout is made to you after deducting the required charges from the selling price of the product.</p>
													<p>If you find that you have been wrongly charged, you can Payment schedule	send us a mail from your registered mail id / Phone number on Sellersupport.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-8-heading-24">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-8-content-24" aria-expanded="false" aria-controls="accordion-tab-8-content-24">Which report will help me with the reconciliation of my account?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-8-content-24" aria-labelledby="accordion-tab-8-heading-24" data-parent="#accordion-tab-8">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>It is advised that you use the Order-wise payout report for this purpose, which will help you with the reconciation of your payout details of your all orders(including those whose payout is pending). For complete details on how to download it.</p>
												</div>
											</div>
										</div>
									</div>
									
									<div class="card">
										<div class="card-header" id="accordion-tab-8-heading-25">
											<h5>
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-8-content-25" aria-expanded="false" aria-controls="accordion-tab-8-content-25">What is meant by Liquidated return orders?</button>
											</h5>
										</div>
										<div class="collapse" id="accordion-tab-8-content-25" aria-labelledby="accordion-tab-8-heading-25" data-parent="#accordion-tab-8">
											<div class="card-body">
												<div class="content-mrkt-places">
													<p>Liquidated return orders are those orders against which no physical product was returned to you and the payout as per the policy has been or will be credited to you.</p>
												</div>
											</div>
										</div>
									</div>																	
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		
		</section>
		
		<div class="clearfix"></div>
		
		<?php include('inc/footer.php'); ?>
		
	</body>
</html>