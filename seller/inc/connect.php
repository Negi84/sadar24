<?php
	// $servername = "sadar24-beta.cxaxatche1zj.ap-south-1.rds.amazonaws.com";
	// $username = "admin";
	// $password = "sadar24_beta";
	// $dbname = "sadar24_seller";
	// $dbport = 3306;
	$servername = "sadar24-21-03-22.cxaxatche1zj.ap-south-1.rds.amazonaws.com";
	$username = "admin";
	$password = "sadar_db_user_1";
	$dbname = "sadar24_seller";
	$dbport = 3306;
	// $servername = "localhost";
	// $username = "root";
	// $password = "";
	// $dbname = "sadar24_seller";
	// $dbport = 3306;

    
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname,$dbport);
    // Check connection
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

	
?>
