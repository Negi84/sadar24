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
							<h1>Packing Instruction</h1>							
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 order-1-mobile">
						<figure class="collage-banner text-right">
							<img data-src="seller/images/packing-instruction.jpg" alt="slider" class="lazyload w-100 img-fluid"> 
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
							<p class="pb-3">Sadar24.com advices every vendor to pack there goods in such a manner so that it does not get spoil in transit. As the product changes many Hands/Processes before being finally reaching into customer’s hand from your place.</p>							
							<p class="pb-3"><strong>It helps in many ways to vendors</strong></p>
							<ul>
								<li>As it prevents the loss of damage in transit</li>
								<li>It reduces the returns of products</li>
								<li>It generates repeat orders.</li>
							 </ul>
							<p class="pb-3"><strong>Do’s & Don’t of Packing</strong></p>
							<ul class="pb-3">
								<li>You should not use packing material of other E-commerce companies for packing product for Sadar24.com.</li>
								<li>Do not stick any advertisement in or out of packing box.</li>
								<li>Put all the necessary documents like manuals, warranty papers (if any) etc. In box with the product. Take print out of the invoice & paste it on top of the box so that it can be easily recognized at every step of delivery.</li>
								<li>You can use any plain packaging material you require to keep your safe like corrugated boxes, shrink wrap etc but it should not carry brand of any other e-commerce company.</li>
								<li>Please make sure whenever you pack a product. You should pack your box with sadar24.com branded tape , It will help in recognizing your product in transit.</li>
								<li>As we welcomes you in our family we will be sending you a welcome kit which will have (4) four sadar24 branded tapes.</li>
								<li>In future you can send us your requirements of packing material on sellercaresadar24.com & we will provide it at your doorsteps. The charges for packing material are-</li>
							</ul>
							
							<table class="table table-bordered">															
								<tr>
									<td><strong>Size (index)</strong></td>
									<td><strong>Rate</strong></td>
								</tr>
								<tr>
									<td>6x8</td>
									<td>160 (100 piece)</td>
								</tr>
								<tr>
									<td>8x10</td>
									<td>200 (100 piece)</td>
								</tr>
								<tr>
									<td>12x16</td>
									<td>350 (100 piece)</td>
								</tr>
								<tr>
									<td>14x18</td>
									<td>425 (100 piece)</td>
								</tr>
								<tr>
									<td>16x20</td>
									<td>510 (100 piece)</td>
								</tr>
								<tr>
									<td>20x24</td>
									<td>750 (100 piece)</td>
								</tr>
							</table>							
						</div>
					</div>					
				</div>
			</div>
		</section>
		
		<?php include('inc/footer.php'); ?>
	</body>
</html>