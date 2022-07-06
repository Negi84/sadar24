<?php 

	// include('inc/connect.php');
	
	// if(isset($_POST['Ssubmit'])){
	// 	$mobile = $_POST['phone_number'];
	// 	$sql = "SELECT phone FROM tbl_seller_query WHERE phone = '$mobile'";
	// 	$result = mysqli_query($conn, $sql);

	// 	if (mysqli_num_rows($result) > 0) {
	// 	    header("Location: https://sadar24.com/shops/create"); 
	// 	} else {
			
	// 		$sql = "INSERT INTO tbl_seller_query (phone) VALUES ('$mobile')";
	// 		if (mysqli_query($conn, $sql)) {
	// 			//echo "New record created successfully";
	// 		header("Location: https://sadar24.com/shops/create"); 
	// 		} else {
	// 			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	// 		}
	// 	}
	// 	mysqli_close($conn);
	// }
?>

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
		<style>
			.banner-caption h1 {
				font-size: 40px;
			}
			.banner-caption h4 {
				font-size: 20px;
				color: #000;
			}
			.download-app-button{
				background: #ef484c;
				color: #fff !important;
				font-weight: 600;
				padding: 5px 20px;
				text-align: center;
				border-radius: 3px;
				display:none;
			}
			
			@media only screen and (max-width: 568px) {
				.content-mrkt-places h4 {
					text-align:center;
				}
				.content-mrkt-places ul li {
					text-align: justify;
				}
				.content-mrkt-places h4 {
					text-align:center;
				}
				.download-app-button{
					display:block;
				}
			}
			
			@media only screen and (max-width: 400px) {
				
				.download-app-button{
					padding: 5px 10px;
				}
			}
			@media only screen and (max-width: 370px) {
				
				.download-app-button{
					text-align: center;
				}
				.download-app-button span{
					word-break: break-all;
				}
			}
		
		</style>
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
							<h1>Sell on Sadar24 <br/> at 0% Commission</h1>
							<h4>India is buying from Sadar24. <br/> Be here, grow your business.</h4>
							
							<div class="button-banner">
								<a href="javascript:void(0)" class="btn-quote" data-toggle="modal" data-target="#myModal">START SELLING</a>
							</div>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 order-1-mobile">
						<figure class="collage-banner text-right">
							<img data-src="seller/images/banner-01.jpg" alt="slider" class="lazyload w-100 img-fluid"> 
						</figure>
					</div>
				</div>
			</div>
		</section>
		<div class="clearfix"></div>
		<section class="with-100 position-relative pt-5 pb-5 bgGradiant-grey">
			<div class="container container-header">
				<div class="row">
					<div class="col-md-12">
						<div class="header-h2-main text-center">
							<h2>Join Sadar24 – The Fastest Moving Marketplace</h2>
						</div>
					</div>
				</div>
				<div class="row mt-5">
					<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
						<div class="creative-icons">
							<figure class="icons">
								<img data-src="seller/images/icons-seller/01-03.svg" alt="logo" class="lazyload img-fluid">    
							</figure>
							<div class="icons-contents">
								<h4>Sell at 0% Commission</h4>
								<p>Give your goods the right marketplace. List your products easily, make a sale.</p>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
						<div class="creative-icons">
							<figure class="icons">
								<img data-src="seller/images/icons-seller/01-04.svg" alt="logo" class="lazyload img-fluid">    
							</figure>
							<div class="icons-contents">
								<h4>Attractive Platform</h4>
								<p>Our platform makes it easy for you to manage, promote and grow your business. Ab sale ki chinta nahi!</p>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
						<div class="creative-icons">
							<figure class="icons">
								<img data-src="seller/images/icons-seller/01-05.svg" alt="logo" class="lazyload img-fluid">    
							</figure>
							<div class="icons-contents">
								<h4>Product Listing Support</h4>
								<p>Reach out to us for help anytime and learn how to list your product as well as sell successfully. </p>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
						<div class="creative-icons">
							<figure class="icons">
								<img data-src="seller/images/icons-seller/01-06.svg" alt="logo" class="lazyload img-fluid">    
							</figure>
							<div class="icons-contents">
								<h4>Secure Marketplace</h4>
								<p>Sadar Bazaar is now online and is catering to a large range of customers looking for a huge variety of products.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<div class="clearfix"></div>
		<section class="with-100 position-relative pt-5 pb-5 bg-white">
			<div class="container container-header">
				<div class="row justify-content-center">
					<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
						<figure class="mrkt-place text-center">
							<img data-src="seller/images/seller-01-mrkt.jpg" alt="logo" class="lazyload img-fluid">
							<div class="circle">
								<img data-src="seller/images/seller-01circle-mrkt.jpg" alt="logo" class="lazyload img-fluid">
							</div>
						</figure>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
						<div class="content-mrkt-places">
							<h4>Why Sell on Sadar24 – One of Its Kind Market Place</h4>
							<ul>
								<li>It helps focus on a specific product category that is in demand &amp; ensures variety</li>
								<li>Helps in Targeting a more specific and involved group of customers</li>
								<li>Ability to address the needs of those customers by offering a more holistic set of specialized products</li>
								<li>The engagement and interaction with customers is higher, more personal and thematic, leading to repeat visits</li>
								<li>Draws in lots of digital traffic, which means greater exposure for the brands that want to sell.</li>
								<li>Brand Identity gets defined and embedded in the customer’s consciousness with their category-specific approach</li>
								<li>Gives consumers the ease of shopping for their specific needs at their own disposal</li>
								<li> Generates a sense of community, trust and support that shares a common greater interest.</li>
							</ul>
						</div>
						<div class="button-banner text-center mt-3">
							<a href="javascript:void(0)" class="btn-quote" data-toggle="modal" data-target="#myModal">START SELLING</a>
						</div>
					</div>
				</div>
			</div>
		</section>
		<div class="clearfix"></div>
		<section class="with-100 position-relative paddingCustomize bg-line-moving">
			<div class="container container-header">
				<div class="row justify-content-center">
					<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
						<figure class="mrkt-place text-center">
							<img data-src="seller/images/seller-02-mrkt.jpg" alt="logo" class="lazyload img-fluid">
							<div class="circle">
								<img data-src="seller/images/seller-02circle-mrkt.jpg" alt="logo" class="lazyload img-fluid">
							</div>
						</figure>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
						<div class="content-mrkt-places">
							<h4>Listing on Sadar24 Is Easy</h4>
							<ul>
								<li>Listing on our platform is totally free with easy to use self-serve portal.</li>
								<!--<li>Pay only when your product is ordered.</li>
								<li>We would be charging only the basic marketplace fees.</li>-->
								<li>Maximize your sales across India with easy dashboard and analytics support</li>
								<li>Hassle-free pick-up and delivery across India.</li>
								<li>Package would be picked-up by our logistic partner once you pack and keep the product ready</li>
								<li>Receive on time and reliable payments</li>
								<li>Maximize your sales across India with easy dashboard and analytics support</li>
								<li>Pay Only when your product is ordered</li>
							</ul>
						</div>
						<div class="button-banner text-center mt-3">
							<a href="javascript:void(0)" class="btn-quote" data-toggle="modal" data-target="#myModal">START SELLING</a>
						</div>
					</div>
				</div>
			</div>
		</section>
		<div class="clearfix"></div>
		<section class="with-100 position-relative">
			<div class="container bg-white shodow-custom conatinerpadding">
				<div class="row">
					<div class="col-md-12">
						<div class="header-h2-main text-center">
							<h2>Why Sell on Sadar24</h2>
						</div>
					</div>
				</div>
				<div class="row justify-content-center mt-5">
					<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6">
						<div class="leaf-col-flex leaf-text text-left">
							<figure class="icon-leval-2">
								<img data-src="seller/images/icons-seller/01-07.svg" alt="logo" class="lazyload img-fluid">    
							</figure>
							<h5>Sell Online and Grow</h5>
							<p>Widen your reach and increase sales</p>
						</div>
					</div>
					<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6">
						<div class="leaf-col-flex leaf-text text-left">
							<figure class="icon-leval-2">
								<img data-src="seller/images/icons-seller/01-08.svg" alt="logo" class="lazyload img-fluid">  
							</figure>
							<h5>No Upfront Cost</h5>
							<p>Sell Online with no upfront or recurring cost</p>
						</div>
					</div>
					<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6">
						<div class="leaf-col-flex leaf-text text-left">
							<figure class="icon-leval-2">
								<img data-src="seller/images/icons-seller/01-11.svg" alt="logo" class="lazyload img-fluid">  
							</figure>
							<h5>Easily Accessible</h5>
							<p>Manage your online store anytime and anywhere**</p>
						</div>
					</div>
					<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6">
						<div class="leaf-col-flex leaf-text text-left">
							<figure class="icon-leval-2">
								<img data-src="seller/images/icons-seller/01-09.svg" alt="logo" class="lazyload img-fluid">  
							</figure>
							<h5>Effective Model</h5>
							<p>Cost effective and scalable model**</p>
						</div>
					</div>
				</div>
				<div class="row justify-content-center mt-5">
					<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6">
						<div class="leaf-col-flex leaf-text text-left">
							<figure class="icon-leval-2">
								<img data-src="seller/images/icons-seller/01-10.svg" alt="logo" class="lazyload img-fluid"> 
							</figure>
							<h5>Good Visibility</h5>
							<p>Equal Opportunities for all the Sellers to flourish</p>
						</div>
					</div>
					<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6">
						<div class="leaf-col-flex leaf-text text-left">
							<figure class="icon-leval-2">
								<img data-src="seller/images/icons-seller/01-12.svg" alt="logo" class="lazyload img-fluid"> 
							</figure>
							<h5>Performance Based System</h5>
							<p>Performance based system, pay only if you sell.</p>
						</div>
					</div>
					<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6">
						<div class="leaf-col-flex leaf-text text-left">
							<figure class="icon-leval-2">
								<img data-src="seller/images/icons-seller/01-13.svg" alt="logo" class="lazyload img-fluid"> 
							</figure>
							<h5>Easy as ABC</h5>
							<p>Register, list your products and start selling. Simple!</p>
						</div>
					</div>
					<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6">
						<div class="leaf-col-flex leaf-text text-left">
							<figure class="icon-leval-2">
								<img data-src="seller/images/icons-seller/01-14.svg" alt="logo" class="lazyload img-fluid"> 
							</figure>
							<h5>Help and Support</h5>
							<p>Reach out to us for help and support anytime</p>
						</div>
					</div>
				</div>
				<div class="row mt-5">
					<div class="col-md-12 text-center">
						<div class="button-banner">
							<a href="javascript:void(0)" class="btn-quote" data-toggle="modal" data-target="#myModal">START SELLING</a>
						</div>
					</div>
				</div>
			</div>
		</section>
		<div class="clearfix"></div>
		<!--<section class="with-100 position-relative pt-5 pb-5 bg-white mt-3">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="header-h2-main text-center">
							<h2>Why Choose Sadar24!</h2>
						</div>
					</div>
				</div>
				<div class="row justify-content-center mt-5">
					<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6 pl-2 pr-2">
						<div class="whyChoseUs">
							<h2>01</h2>
							<p>Free listing on the our platform with easy to use the self-serve portal.</p>
						</div>
					</div>
					<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6 pl-2 pr-2">
						<div class="whyChoseUs">
							<h2>02</h2>
							<p>Hassle-free pick-up and delivery across India.</p>
						</div>
					</div>
					<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6 pl-2 pr-2">
						<div class="whyChoseUs">
							<h2>03</h2>
							<p>Pay after you receive an order for your product.</p>
						</div>
					</div>
					<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6 pl-2 pr-2">
						<div class="whyChoseUs">
							<h2>04</h2>
							<p>Maximize your sales across India with easy dashboard and analytics support.</p>
						</div>
					</div>
					<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6 pl-2 pr-2">
						<div class="whyChoseUs">
							<h2>05</h2>
							<p>We would be charging only the basic marketplace fees.</p>
						</div>
					</div>
					<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6 pl-2 pr-2">
						<div class="whyChoseUs">
							<h2>06</h2>
							<p>The package would be shipped by our logistics partners (can also be self-shipped) after you pack and keep the product ready</p>
						</div>
					</div>
				</div>
			</div>
		</section> -->
		<div class="clearfix"></div>
		<section class="w-100 pt-5 pb-5 bgGreyfbfbfb">
<div class="container">
<div class="row">
<div class="col-md-12">
<div class="header-h2-main text-center">
<h2>Trusted Sadar24 Sellers</h2>
</div>
</div>
</div>

    
<div class="row justify-content-center mt-5">
<div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 text-center">
<div class="owl-carousel owl-theme circleQwl">

<div class="item">
<div class="inner-col-testimonials">
<figure class="testiPorfile mb-4" style="text-align: center;display: inline-block;">
<img data-src="seller/images/sandeep_agarwal.jpg" alt="slider" class="lazyload  img-fluid" style="width:100px;"/> 
</figure>
<h5>Sandeep Agarwal</h5>
<p>I have a shop at Sadar Bazaar from many years now. Even though the footfalls in the market are good I wanted to target the online shoppers as well, as I am into the business of fashion jewellery. My friend told me about Sadar24 and I immediately decided to join it. Today I have a parallel sales channel through Sadar24.</p>
</div>
</div>

<div class="item">
<div class="inner-col-testimonials">
<figure class="testiPorfile mb-4" style="text-align: center;display: inline-block;">
<img data-src="seller/images/profile-picture-01.jpg" alt="slider" class="lazyload img-fluid" style="width:100px;"/> 
</figure>
<h5>Lavanya Pandey</h5>
<p>I used to be hesitant about taking my business online. With the high commission of third-party apps and the lengthy documentation procedures, it almost seemed impossible for me. But the Sadar24 seller app has completely transformed the identity of my business. Now, I am selling my product all over India and the platform only takes a minimum commission over my sales. Partnering with Sadar24 was hands down the decision I made for my business.</p>
</div>
</div>

<div class="item">
<div class="inner-col-testimonials">
<figure class="testiPorfile mb-4" style="text-align: center;display: inline-block;">
<img data-src="seller/images/profile-picture-02.jpg" alt="slider" class="lazyload  img-fluid" style="width:100px;"/> 
</figure>
<h5>Pragati Goyal</h5>
<p>Coming from a middle-class family, it was a far-fetched dream for me to start my own business. When I almost gave up on my dream, my friend introduced me to the Sadar24 seller app. I never knew it would be so easy to start up my own business. All I had to do was register and start selling my products to customers. Sadar24 helped me achieve my dream. I strongly recommend this platform.</p>
</div>
</div>

<div class="item">
<div class="inner-col-testimonials">
<figure class="testiPorfile mb-4" style="text-align: center;display: inline-block;">
<img data-src="seller/images/profile-picture-03.jpg" alt="slider" class="lazyload  img-fluid" style="width:100px;"/> 
</figure>
<h5>Deepak Saini</h5>
<p>When I took over my father's shop in Sadar Bazaar, all I wanted to do was take it to another level. With lockdown restrictions and decreasing footfall in the market, I felt helpless. A few months ago, I joined Sadar24 and I must say it is an excellent initiative for all those who have Businesses in Sadar Bazaar. This platform came as a solution to my business's problems. Thank you Sadar24, for making online business so easy for us shopkeepers.</p>
</div>
</div>



</div>
</div>

</div>    
    
    
</div>    
</section>

		
		<?php include('inc/footer.php'); ?>
	</body>
</html>