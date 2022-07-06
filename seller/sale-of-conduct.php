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
							<h1>Seller Code Of Conduct</h1>							
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 order-1-mobile">
						<figure class="collage-banner text-right">
							<img data-src="seller/images/sale-of-conduct.jpg" alt="Seller Code Of Conduct" class="lazyload w-100 img-fluid"> 
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
							<p class="pb-3">Sadar24 enables you to reach millions of customers worldwide. Sadar24 strives to ensure a fair and trustworthy buyer and seller experience. Violation of the code of conduct principles may result in the loss of your selling privileges and removal from Sadar24 platform.</p>							
							<p class="pb-3"><strong>Seller Code of Conduct Principles:</strong></p>
							<ul>
								<li>Adhere to all applicable laws applicable to and abide by all Sadar24 policies.</li>
								<li>Maintain current account and have GSTIN (if applicable).</li>
								<li>No False Representations</li>
								<li><strong>Never engage in any misleading, inappropriate or offensive behaviour. This applies to all your activities, including but not limited to:</strong>
									<ol>
										<li>Information provided on your account.</li>
										<li>Information provided in listings, content or images.</li>
										<li>Communication between you and Sadar24 or you and our customers.</li>
									</ol>
								</li>
								<li><strong>Act fairly at all times. Unfair behaviour includes but is not limited to the following:</strong>
									<ol>
										<li>Behaviour that could be deemed as manipulation or "gaming" of any part of the buying or selling experience.</li>
										<li>Actions that could be perceived as manipulating customer reviews, including by directly or indirectly contributing false, misleading or inauthentic content.</li>
										<li>Activities that could be perceived as attempting to manipulate Sadar24 search results or sales rankings.</li>
										<li>Actions that intentionally damage another seller, their listings or their ratings.</li>
									</ol>
								</li>
							 </ul>
						</div>
					</div>					
				</div>
			</div>
		</section>
		
		<?php include('inc/footer.php'); ?>
	</body>
</html>