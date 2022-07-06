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
							<h1>Photography Instructions</h1>							
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 order-1-mobile">
						<figure class="collage-banner text-right">
							<img data-src="seller/images/Photography-Instructions.jpg" alt="Photography Instructions" class="lazyload w-100 img-fluid"> 
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
							<p class="pb-3">Good Photographs are the key to online marketing platforms . Your product will attract more customers only if your product’s photographs & description is good. So we advice some tips for good photograph.</p>
							
							<ul class="pb-3">
								<li>Always use white background.</li>
								<li>Make sure that your products is in the centre of the photograph & it should cover 75% of the photo frame.</li>
								<li>The photograph should be in  1000X1000  pixel & between 100-125 KB.</li>
								<li>Please do not post any blurred image of your product as all vendors trained in their product photography & product uploading. Yet for the vendors who are at initial stage of  E-commerce business & face any difficulty in photography of product can send us an email requesting an assistance on our Mail-Id  <a href="mailto:sellercare@sadar24.com">sellercare@sadar24.com</a>  regarding help in photography .The company is providing a free photo shoot of 10 products of your choice and  at your place by an official /professional photographers free of cost.</li>
								<li>In case you want to display more products or you  want to get clicked more products you can get that done but it will be charged at 50/- ( fifty rupees per product).</li>
								<li>Please note that all the photographs  clicked by our photographer ( free/ paid) are for the sole purpose of uploading on platform sadar24. Com. At any point of time it will not be given to you or shared with you, you can get it on our platform i.e Sadar24.com where your all products have been listed. </li>

							</ul>							
						</div>
					</div>					
				</div>
			</div>
		</section>
		
		<?php include('inc/footer.php'); ?>
	</body>
</html>