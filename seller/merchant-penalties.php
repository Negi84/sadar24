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
							<h1>Merchant Penalties</h1>							
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 order-1-mobile">
						<figure class="collage-banner text-right">
							<img data-src="seller/images/merchant-penalties.jpg" alt="slider" class="lazyload w-100 img-fluid"> 
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
							<p class="pb-3">The penal action that Sadar24.com is authorized to take in case a Seller is found to be committing fraud or using unfair means to gain proceeds from Sadar24.com</p>
							
							<table class="table table-bordered pb-3">
								<tr>
									<th>Acts constituting breach of Contract / Law</th>
									<th colspan="2">Penal Provisions</th>
								</tr>
								<tr>
									<td>Self-Ordering / Seller Buyer Collusion</td>
									<td>Penalty imposed will be = 3 X Total Sale Value + ₹ 25000/(Litigation expenses)</td>
								</tr>
								<tr>
									<td>Dispatch/Delivery of Empty Box or Fake/Duplicate/Defective/Partial/Damaged/Used/Wrong Product or Product of lesser/inflated value</td>
									<td>Penalty imposed will be = Total Sale Value + Claim (If paid) + ₹ 25000/(Litigation expenses)</td>
								</tr>
								<tr>
									<td>MRP issues</td>
									<td>Penalty imposed will be = Total Sale Value + ₹ 25000/(Litigation expenses)</td>
								</tr>
								<tr>
									<td>Penalty for SLA breaches</td>
									<td>Penalty = 10% of selling price or ₹ 50 Whichever is higher</td>
								</tr>
								<tr>
									<td>Penalty for Seller Cancellation</td>
									<td>Penalty = 10% of selling price or ₹ 50 Whichever is higher</td>
								</tr>
								<tr>
									<td>Penalty post-SLA is breached &amp; if the order is Auto-Cancelled</td>
									<td>Penalty = 10% of selling price or ₹ 50 Whichever is higher</td>
								</tr>
							</table>							
							<p class="pb-3">Total Sale Value = Total SALE Value is calculated by taking the sale price per item charged to the customer &amp; multiply this by the number of items sold. For Example is you sell 10 T-shirts @ ₹ 500 per price. So the total Sale value will be 500 X 100 = ₹ 5000/-</p>
						</div>
					</div>					
				</div>
			</div>
		</section>		
		<?php include('inc/footer.php'); ?>		
	</body>
</html>