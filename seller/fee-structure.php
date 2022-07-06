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
							<h1>The lowest cost of doing business in the industry</h1>							
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 order-1-mobile">
						<figure class="collage-banner text-right">
							<img data-src="seller/images/fee_structure.jpg" alt="slider" class="lazyload w-100 img-fluid"> 
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
							<p class="pb-3">Your payment will be process within 3 working days after the date of delivery of the product conditionally that your products are non refundable/non returnable .In case your products falls in categories of refundable / returnable goods then the payment cycle will start from day of return end.</p>
							
							<ol>
								<li><strong>Please note that the payment is made after deducting the sum of:</strong></li>								
								<ul>
									<li>Platform Charges, Material Handling Charges, Payment Collection Charges  Rs. 50/- per order.</li>
									<li>GST + Penalty (if any) + TDS (0.75) on base price + TCS (1% on base price) from your Selling Price. </li>
								</ul>
								<li>Tax deducted at source (TDS) u/s 194- O mandates e-commerce companies to deduct TDS on sales of goods & services through their platform. This is effective from October1,2020. The rate of TDS applicable will be 0.75% (of base sale price) from October 1, 2020.</li>	
								<li>Once the product is delivered to the customer, the payment will get processed within 3 working days from the date of delivery of the product.</li>	
								<li>Payment is transferred every day except for bank holidays and it is processed during the banking hours only .</li>	
							</ul>
						</div>
					</div>					
				
					<div class="col-sm-12 ">
						<h5 class="pt-3 pb-3">**This table of calculation is for representation purposes only**</h5>
						<table class="table table-bordered">
							<tr>
								<th>PAYOUT</th>
								<th colspan="2">EXAMPLE: (Product) TOYS</th>
							</tr>
							<tr>
								<td>Selling Price</td>
								<td>₹ 1,000.00</td>
							</tr>
							<tr>
								<td>
									<p>1. Marketplace Handling Fees</p>
									<p>2. Payment gateway fee</p>
									<p>3. Logistic charges</p>
									<p>4. Fixed closing fee(as per product price)</p>
								</td>
								<td class="align-middle">₹ 50</td>
							</tr>
							<tr>
								<td>GST @ 18%</td>
								<td>₹ 9.00[18%*(50)]</td>
							</tr>
							<tr>
								<td>TCS (1%) On basis price</td>
								<td>₹ 8.47[1% *(selling price applicable GST on the product)]</td>
							</tr>
							<tr>
								<td>TDS (0.75%*) ON BASE PRICE</td>
								<td>₹ 6.36[0.75% *(selling price applicable GST on the product)]</td>
							</tr>
							<tr>
								<td><strong>Final Payout</strong></td>
								<td>₹ 926.17[(1000) - (50-9-8.47-6.56)]</td>
							</tr>
						</table>
						<p>*Tax deducted at source (TDS) u/s 194-O mandates e-commerce companies to deduct TDS on
							sales of goods and services through their platform.The rate of TDS applicable is 0.75% ( of the
							base selling price) from October 1 2020. However in cases where in the PAN is unavailable or
							invalid, TDS at 5% will be applicable.
						</p>
					</div>
					
				</div>
			</div>
		</section>
		
		<?php include('inc/footer.php'); ?>	
	</body>
</html>