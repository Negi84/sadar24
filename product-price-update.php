<?php

	$servername = "localhost";
	$username = "sadar24_kahtu";
	$password = "sadar24_kahtu";
	$dbname = "sadar24_kahtu";
	
	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	// Check connection
	if (!$conn) {
	  die("Connection failed: " . mysqli_connect_error());
	}	
   // echo "Hello";die;
	$sql = "SELECT * FROM products WHERE unit_price < 1000 ORDER BY id ASC";
	
	$result = mysqli_query($conn, $sql);	
	if (mysqli_num_rows($result) > 0) {
		
		echo "<table>";
		echo "<tr><th>Product ID</th><th>Product Name</th><th>MRP</th><th>Discpunt Type</th><th>Discount</th><th>Sale Price</th><th>URL</th></tr>";
		while($row = mysqli_fetch_assoc($result)) {
			$commission = 10;
			$product_id = $row['id'];
			$product_id = $row['id'];
			$price = $row['unit_price'];
			$purchase_price = $row['purchase_price'];
			$discount   = (!empty($row['discount'])) ? $row['discount'] : 0;
			$discount_type = (!empty($row['discount_type'])) ? $row['discount_type'] : "amount";	
			
			if($discount_type == 'amount'){				
				$old_price = $price - $discount;				
			}else if($discount_type == 'percent'){				
				$discount_value = ($price / 100) * $discount;
				$old_price = $price - $discount_value;
			}else{
			    $discount_type = "amount";
				$old_price = $price - $discount;
			}
			
		
			
			echo "<tr>";
			echo "<td>".$row['id']."</td>";
			echo "<td>".$row['name']."</td>";
			echo "<td>".$row['unit_price']."</td>";
			echo "<td>".$row['discount_type']."</td>";
			echo "<td>".$row['discount']."</td>";
			echo "<td>".$old_price."</td>";
			echo "<td>https://sadar24.com/product/".$row['slug']."</td>";
			echo "<td>".$row['created_at']."</td>";
			echo "<td>".$row['updated_at']."</td>";
			echo "</tr>";
		
			
		}
		echo "</table>";
	}
	
	mysqli_close($conn);
?>