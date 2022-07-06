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
							<h1>Come build the business <br>with us</h1>							
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 order-1-mobile">
						<figure class="collage-banner text-right">
							<img data-src="seller/images/about-us.jpg" alt="slider" class="lazyload w-100 img-fluid"> 
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
							<p>Sadar Bazaar, Delhi is one of the most popular markets in the country. It is the lifeline of trade envisaging the culture and community of Delhi. Lakhs of buyers visit the market every day for purchasing a wide variety of products available there.</p>
							<p>Imagine being able to buy these products from Sadar Bazaar without the hustle and bustle of going there. Sounds interesting, right? This is the vision with which Sadar24.com was founded.</p>
							<p>The promotors of sadar24.com - an online platform joined hands with the sellers of India's oldest and the most loved ‘Sadar Bazaar’with a vision to uphold and elevate its values. The idea is to remove the barriers of the physical market and pass its benefits to the end consumers digitally where buying for them is just a click away.</p>
							<p>We aim to bring Sadar Bazaar to the home of millions of people through Sadar24.com where shopping could be completed within minutes and product will be delivered at your doorstep. We strive to achieve this providing the best customer experience, convenience and service to our valuable buyers through their digital screens and making it available 24x7.</p>
						</div>
					</div>					
				</div>
			</div>
		</section>
		
		<?php include('inc/footer.php'); ?>
	</body>
</html>