
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
	
	$sql = "SELECT * FROM  metro WHERE published = '1'";	
	$result = mysqli_query($conn, $sql);	
	if (mysqli_num_rows($result) > 0) {	  
		while($row = mysqli_fetch_assoc($result)) {			
			
			$data[] = array(			
				'merchantName'=> preg_replace('/[; & # % ]+/', ' ', trim($row['merchantName'])),
				'merchantURL'=> preg_replace('/[; & # % ]+/', ' ', trim($row['merchantURL'])),
				'image'=> $row['image'],
				'discountCode'=> preg_replace('/[; & # % ]+/', ' ', trim($row['discountCode'])),
				'discountDescription'=> preg_replace('/[; & # % ]+/', ' ', trim($row['discountDescription'])),
				'dicountCategory'=> preg_replace('/[; & # % ]+/', ' ', trim($row['dicountCategory'])),
				'discountCategoryUrl'=> $row['discountCategoryUrl'],
				'discountConditions'=> preg_replace('/[; & # % ]+/', ' ', trim($row['discountConditions'])),
				'startDt'=> preg_replace('/[; & # % ]+/', ' ', trim($row['startDt'])),
				'endDt'=>preg_replace('/[; & # % ]+/', ' ', trim($row['endDt'])),				
			);
		}
		echo json_encode($data,JSON_PRETTY_PRINT);
	} else {
		echo "0 results";
	}
	
	mysqli_close($conn);
?>