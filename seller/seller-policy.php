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
							<h1>Processes &amp; Policies</h1>							
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 order-1-mobile">
						<figure class="collage-banner text-right">
							<img data-src="seller/images/seller-policy.jpg" alt="slider" class="lazyload w-100 img-fluid"> 
						</figure>
					</div>
				</div>
			</div>
		</section>
		<div class="clearfix"></div>		
		
		<section class="with-100 pb-5">
			<div class="container container-header">
				<div class="row justify-content-center">
					<div class="col-sm-12">
						<div class="content-mrkt-places">							
							<p>In order to find an effective and easy way to sell on Sadar24, you need to adhere to certain guidelines and policies. These will not only help build a seamless process for you but also keep it away from any kind of glitches that you might face. Sometimes, without realising it, non-adherence to these policies could lead to a drop in sales and even delayed payouts.</p>
							<p>We want you to be on top of it all, so we’ve put together a couple of essential policies and processes that you need to know and adhere to. Have a look:</p>
						</div>
					</div>					
				</div>
			</div>
		</section>		
		<section class="with-100 pb-5">
			<div class="container container-header seller_policy">				
				<div class="row justify-content-center mt-5">
					<div class="col-md-3">
						<div class="leaf-col-flex leaf-text text-center">
							<figure class="icon-leval-2">
								<img data-src="seller/images/seller-policy/signup.svg" alt="Sign Up Documents" class="lazyload img-fluid">  
							</figure>
							<h5>Sign Up Documents</h5>
							<a href="singup-docs" target="_blank">Read More</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="leaf-col-flex leaf-text text-center">
							<figure class="icon-leval-2">
								<img data-src="seller/images/seller-policy/listing.svg" alt="Listing of Products" class="lazyload img-fluid"> 
							</figure>
							<h5>Listing of Products</h5>
							<a href="listing-of-products" target="_blank">Read More</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="leaf-col-flex leaf-text text-center">
							<figure class="icon-leval-2">
								<img data-src="seller/images/seller-policy/prohibition.svg" alt="Prohibited Items" class="lazyload img-fluid"> 
							</figure>
							<h5>Prohibited Items</h5>
							<a href="prohibited-items" target="_blank">Read More</a>
						</div>
					</div>	
					<div class="col-md-3">
						<div class="leaf-col-flex leaf-text text-center">
							<figure class="icon-leval-2">
								<img data-src="seller/images/seller-policy/photography.svg" alt="Photography Instruction" class="lazyload img-fluid">    
							</figure>
							<h5>Photography Instruction</h5>
							<a href="photography-policy" target="_blank">Read More</a>
						</div>
					</div>
					
				</div>
				<div class="row justify-content-center mt-5">
					<div class="col-md-3">
						<div class="leaf-col-flex leaf-text text-center">
							<figure class="icon-leval-2">
								<img data-src="seller/images/seller-policy/package.svg" alt="Packing Instruction" class="lazyload img-fluid">  
							</figure>
							<h5>Packing Instruction</h5>
							<a href="packing-instruction" target="_blank">Read More</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="leaf-col-flex leaf-text text-center">
							<figure class="icon-leval-2">
								<img data-src="seller/images/seller-policy/credit-card.svg" alt="logo" class="lazyload img-fluid">  
							</figure>
							<h5>Payment Policy</h5>
							<a href="fee-structure" target="_blank">Read More</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="leaf-col-flex leaf-text text-center">
							<figure class="icon-leval-2">
								<img data-src="seller/images/seller-policy/rate.svg" alt="Seller Code Of Conduct" class="lazyload img-fluid">  
							</figure>
							<h5>Seller Code Of Conduct</h5>
							<a href="sale-of-conduct" target="_blank">Read More</a>
						</div>
					</div>					
					<div class="col-md-3">
						<div class="leaf-col-flex leaf-text text-center">
							<figure class="icon-leval-2">
								<img data-src="seller/images/seller-policy/customer-service.svg" alt="logo" class="lazyload img-fluid"> 
							</figure>
							<h5>Help and Support</h5>
							<a href="https://sadar24.com/home/contact/" target="_blank">Read More</a>
						</div>
					</div>
				</div>				
			</div>
		</section>		
		<?php include('inc/footer.php'); ?>		
	</body>
</html>