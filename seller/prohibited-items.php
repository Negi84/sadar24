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
							<h1>List of banned or Prohibited Products</h1>							
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 order-1-mobile">
						<figure class="collage-banner text-right">
							<img data-src="seller/images/prohibited-items.jpg" alt="List of banned or Prohibited Products" class="lazyload w-100 img-fluid"> 
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
							<p class="pb-3"><strong>Dangerous Goods</strong></p>
							<ul class="pb-3">
								<li>Oil-based paint and thinners (flammable liquids)</li>
								<li>Industrial solvents</li>
								<li>Insecticides, garden chemicals (fertilizers, poisons)</li>
								<li>Lithium batteries</li>
								<li>Magnetized materials</li>
								<li>Machinery (chain saws, outboard engines containing fuel or that have contained fuel) </li>
								<li>Fuel for camp stoves, lanterns, torches or heating elements</li>
								<li>Automobile batteries</li>
								<li>Infectious substances</li>
								<li>Any compound, liquid or gas that has toxic characteristics </li>
								<li>Bleach</li>
								<li>Flammable adhesives</li>
								<li>Arms and ammunitions</li>
								<li>Dry ice (Carbon Dioxide, Solid)</li>
							</ul>							 
							<p class="pb-3"><strong>Restricted Items</strong></p>
							<ul class="pb-3">
								<li>Precious stones, gems and jewellery</li>
								<li>Uncrossed (bearer) drafts / cheque, currency and coins</li>
								<li>Poison</li>
								<li>Firearms, explosives and military equipment</li>
								<li>Hazardous and radioactive material</li>
								<li>Foodstuff and liquor</li>
								<li>Any pornographic material</li>
								<li>Hazardous chemical item</li>
							</ul>
						</div>
					</div>					
				</div>
			</div>
		</section>
		
		<?php include('inc/footer.php'); ?>
	</body>
</html>