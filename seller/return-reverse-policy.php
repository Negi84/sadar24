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
							<h1>Return &amp; Reverse Logistic Policy</h1>							
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 order-1-mobile">
						<figure class="collage-banner text-right">
							<img data-src="seller/images/return-policy.jpg" alt="slider" class="lazyload w-100 img-fluid"> 
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
							<p class="pb-3">Return is a scheme provided by respective sellers directly under this policy in terms of which the option of exchange, replacement and/ or refund is offered by the respective sellers to you. For all products, the returns/replacement policy provided on the product page shall prevail over the general returns policy. Do refer the respective item's applicable return/replacement policy on the product page for any exceptions to this returns policy and the table below.</p>
							
							<p class="pb-3">This Return Policy will govern the request to return any of the product ("Product") purchased by buyer (referred to as "Buyer", you, your, etc.) from any third-party seller using this Platform. For the purposes of this Policy, the term Buyer and Seller are collectively referred to as "User".</p>
							
							<ol class="pb-3">
								<li>You understand that we are an intermediary platform and will only be responsible to mediate the return request raised by you with the Seller. It shall be sole responsibility of the Seller to resolve the issues/ concerns raised by you in your return request. We shall not assume any liability for any failure on the part of the Seller to resolve your issue.</li>
								<li>Products are returnable within the applicable return window if you’ve received them in a condition that is physically damaged, has missing parts or accessories, defective or different from their description on the product detail page on Sadar24.</li>
								<li>Return will be processed only if:
								<ul>
									<li>it is determined that the product was not damaged while in your possession;</li>
									<li>the product is different from what was shipped to you;</li>
									<li>the product is returned in original condition (with brand’s/manufacturer's box, MRP tag intact, user manual, warranty card and all the accessories therein);</li>
									<li>there are issues related to the quality of the Product delivered;</li>
									<li>the product is not specifically excluded from Return Policy;</li>
									<li>there are no product specific or seller specific unique return policies</li>
								</ul>								
								<li>If you wish to return an electronic device that stores any personal information, please ensure that you have removed all such personal information from the device prior to returning. Sadar24 shall not be liable in any manner for any misuse or usage of such information.</li>
								<li>Products marked as "non-returnable" on the product detail page cannot be returned.</li>
								<li>Additional information is not required to return an eligible order unless otherwise noted in the category specific policy.</li>
								<li>Products may be eligible for replacement only if the same seller has the exact same item in stock.</li>
							</ol>
							
							<p class="pb-3"><strong>Categories with associated return window and exceptions, if any:</strong></p>
							
							<table class="table table-bordered pb-3">
								<tr>
									<th>CATEGORY</th>
									<th colspan="2">RETURN POLICY</th>
								</tr>
								<tr>
									<td>Jewellery</td>
									<td>Fashion Changes on daily basis & so its accessories. This item is non refundable/returnable. However, in the unlikely event of damage, defect, or different item delivered to you, we will provide a full refund or free replacement as applicable.	Please keep the item in its original condition, with brand outer box, MRP tags attached, user manual, warranty cards, and original accessories in manufacturer packaging for a successful return pick-up. We may contact you to ascertain the damage or defect in the product prior to issuing refund/replacement.
									</td>
								</tr>
								<tr>
									<td>Sports & Outdoors</td>
									<td>This item is eligible for free replacement, within five days of delivery, in an unlikely event of damaged, defective or different item delivered to you. You can also return the product within five days of delivery for full refund. Please keep the item in its original condition, with brand outer box, MRP tags attached, warrant cards, and original accessories in manufacturer packaging for a successful return pick-up.</td>
								</tr>
								<tr>
									<td>Home & Living</td>
									<td>This item is eligible for free replacement, within five days of delivery, in an unlikely event of damaged, defective or different item delivered to you. You can also return the product within five days of delivery for full refund. Please keep the item in its original condition, with brand outer box, MRP tags attached, user manual, warranty cards, and original accessories in manufacturer packaging for a successful return pick-up.</td>
								</tr>
								<tr>
									<td>Bags & Luggage</td>
									<td>This item is eligible for free replacement, within five days of delivery, in an unlikely event of damaged, defective or different item delivered to you. You can also return the product within five days of delivery for full refund. Please keep the item in its original condition, with brand outer box, MRP tags attached, user manual, warranty cards, and original accessories in manufacturer packaging for a successful return pick-up.</td>
								</tr>
								<tr>
									<td>Stationary</td>
									<td>This item is eligible for free replacement, within five days of delivery, in an unlikely event of damaged, defective or different item delivered to you. Please keep the item in its original condition, with outer box or case, accessories, CDs, user manual, warranty cards, scratch cards, and other accompaniments in manufacturer packaging for a successful return pick-up.</td>
								</tr>
								<tr>
									<td>Electronics</td>
									<td>This item is eligible for free replacement, within five days of delivery, in an unlikely event of damaged, defective or different item delivered to you. Please keep the item in its original condition, with brand outer box, user manual, warranty cards, and original accessories in manufacturer packaging for a successful return pick-up. We may contact you to ascertain the damage or defect in the product prior to issuing replacement.
									</td>
								</tr>
								<tr>
									<td>Appliances</td>
									<td>This item is eligible for free replacement, within five days of delivery, in an unlikely event of damaged, defective or different item delivered to you. Please keep the item in its original condition, with brand outer box, user manual, warranty cards, and original accessories in manufacturer packaging for a successful return pick-up.</td>
								</tr>
								<tr>
									<td>Women’s Fashion	</td>
									<td>Fashion Changes on daily basis & so its accessories. This item is eligible for return within five days of delivery. You can exchange this item for a different size/color or return for a full refund. Please keep the item in its original condition, with brand outer box, MRP tags attached, warranty cards, and original accessories in manufacturer packaging for a successful refund/replacement.
									</td>
								</tr>
								<tr>
									<td>Toys, Kids & Baby</td>
									<td>This item is eligible for free replacement, within five days of delivery. You can avail replacement, in an unlikely event of damaged, defective, or different item delivered to you. You can also return the product for a full refund. Please keep the item in its original condition, with brand outer box, user manual, warranty cards, and original accessories in manufacturer packaging for a successful return pick-up.</td>
								</tr>
								<tr>
									<td>Others</td>
									<td>This item is eligible for free replacement, within five days of delivery, in an unlikely event of damaged, defective or different item delivered to you. Please keep the item in its original condition, with brand outer box, user manual, warranty cards, and original accessories in manufacturer packaging for a successful return pick-up.</td>
								</tr>
								<tr>
									<td>Festival</td>
									<td>Festivals are colours of life & so its items but significance may fade away once the festival is over. So, these items are non returnable/refundable. However, in the unlikely event of damaged, defective, or different item delivered to you, we will provide a full of refund or free replacement as applicable. We may contact you to ascertain the damage or defect in the product prior to issuing replacement.</td>
								</tr>
								<tr>
									<td>Garden & Outdoors</td>
									<td>This item is eligible for free replacement, within five days of delivery, in an unlikely event of damaged, defective or different item delivered to you. Please keep the item in its original condition, with brand outer box, user manual, warranty cards, and original accessories in manufacturer packaging for a successful return pick-up.</td>
								</tr>
								<tr>
									<td>Home Improvement</td>
									<td>This item is non returnable due to consumable nature of the product. However, in an unlikely event of damaged, defective or different item delivered to you, we will provide a full of refund or free replacement as applicable. Please keep the item in its original condition, with brand outer box, user manual, warranty cards, and original accessories in manufacturer packaging for a successful return pick-up.</td>
								</tr>
								<tr>
									<td>Baby Care</td>
									<td>This item is non returnable due to consumable nature of the product. However, in an unlikely event of damaged, defective or different item delivered to you, we will provide a full of refund or free replacement as applicable. Please keep the item in its original condition, with brand outer box, user manual, warranty cards, and original accessories in manufacturer packaging for a successful return pick-up.</td>
								</tr>
							</table>
														
							<h5 class="pb-4 pt-4">REVERSE LOGISTIC CHARGES</h5>
							
							<p class="pb-3">These are the charges levied on orders that are returned to you. Returnswhich are requested by customer as per return policy. Such orders are called return after delivery or DTO. These are calculated basis on pre-defined weight slabs of the product Its schedule is:-</p>
							
							<table class="table table-bordered pb-3">
								<tr>
								  <td>Upto 500 grams</td>
								  <td>₹ 100/-</td>
								</tr>
								<tr>
									<td>501 gram to 1 kg</td>
									<td>₹ 130/-</td>
								</tr>
								<tr>
									<td>1 Kg - 1.5 kg</td>
									<td>₹ 200/-</td>
								</tr>
								<tr>
									<td>1.5 Kg - 2 Kg</td>
									<td>₹ 220/-</td>
								</tr>
								<tr>
									<td>2 Kg - 5 Kg</td>
									<td>₹ 375/-</td>
								</tr>
								<tr>
									<td>5 Kg - 10 Kg</td>
									<td>₹ 700/-</td>
								</tr>
							</table>
					
							<p class="pb-3">This has been illustrated with following example <strong>Payout Calculation</strong>. Amount to be recovered in use of DTO Orders (Returned order by customers).</p>
														
							<table class="table table-bordered pb-3">
								<tr>
									<td>Payout Calculation</td>
									<td>Example: Toy = ₹ 1000/-</td>
								</tr>
								<tr>
									<td>Selling price</td>
									<td>₹ 1,000</td>
								</tr>
								<tr>
									<td>(-) Reverse Logistic Charges (ex. 500 grams )</td>
									<td>₹ 100</td>
								</tr>
								<tr>
									<td>(-)GST(9%)</td>
									<td>₹ 9</td>
								</tr>
								<tr>
									<td>Amount to recovered</td>
									<td>₹ 109</td>
								</tr>
							</table>
							<p class="pb-3"><strong>Example of Payout if the product is replaces to customers :-</strong></p>
							<table class="table table-bordered pb-3">
								<tr>
									<td>Payout calculation</td>
									<td>For Example for 500 grams Toys ₹ 1,000</td>
								</tr>
								<tr>
									<td>Selling price</td>
									<td>₹ 1,000</td>
								</tr>
								<tr>
									<td>(-) Platform Charges Material Handling charges Payment collection charges</td>
									<td>₹ 50/-</td>
								</tr>
								<tr>
									<td>(-) GST@ 18%</td>
									<td>₹ 9/-</td>
								</tr>
								<tr>
									<td>(-)TDS (0.75%)</td>
									<td>₹ 6.36 (0.75 % of Selling price)</td>
								</tr>
								<tr>
									<td>(-) TCS (1%)</td>
									<td>₹ 8.47 (1 % of Selling price)</td>
								</tr>
								<tr>
									<td>Expected Payout</td>
									<td>₹ 926 - ₹ 17 {1000 - (50+9+6.36+8.47)}</td>
								</tr>
								<tr>
									<td>(-) Reverse Logistic Charges GST (eg. 500 grams)</td>
									<td>₹ 109 (Reverse Logistic Charges = ₹ 100 + GST 9%)</td>
								</tr>
								<tr>
									<td>(-)Forward Logistics Charges (Replacement X GST (eg 500 grams)</td>
									<td>₹ 68.44(Logistic Charges ₹ 58 + GST 18%)</td>
								</tr>
								<tr>
									<td>Final Payout</td>
									<td>₹ 748.73 (1926 - 17(107 + 68.44)</td>
								</tr>
								<tr>
									<td>Cancellation and SLA breach Penalties levied on you in case of order cancellation and or breach SLA</td>
									<td>10% of Selling Price or ₹ 50/- whichever is higher</td>
								</tr>
							</table>
							  
							<p><strong>Abbreviations used for this calculations are :-</strong></p>
							<ul class="pb-3">
								<li>TCS = Tax Collected at Source</li>
								<li>TDS = Tax Deducted at Source</li>
								<li>RTO = Return To Origin (Return Before Delivery)</li>
								<li>DTO = Delivered To Origin (Return After Delivery)</li>
								<li>SLA = Service Level Agreement</li>
							</ul>
							
							
							
							
							
						</div>
					</div>					
				</div>
			</div>
		</section>
		
		<?php include('inc/footer.php'); ?>
	</body>
</html>