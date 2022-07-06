
<?php
	// $servername = "sadar24-21-03-22.cxaxatche1zj.ap-south-1.rds.amazonaws.com";
	// $username = "admin";
	// $password = "sadar_db_user_1";
	// $dbname = "sadar24_kahtu";
	// $dbport = 3306;
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "sadar24_kahtu";
	$dbport = 3306;
	
	$sellerid = $_GET['sellerid'];
	
	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname,$dbport);
	// Check connection
	if (!$conn) {
	  die("Connection failed: " . mysqli_connect_error());
	}
	
	if($sellerid == NULL){
	    echo "sorry! Please enter seller id";
	}else{
	    $sql = "SELECT s.phone AS ComPhone, s.city AS ComCity, s.name AS ComName, s.postal_code AS postalcode, s.address AS comAdd, s.state AS ComState, u.name AS CustName, u.email AS CustEmail FROM  shops s INNER JOIN users u ON s.user_id = u.id WHERE u.id = $sellerid";	
	
    	$result = mysqli_query($conn, $sql);
    	
    	if (mysqli_num_rows($result) > 0) {	  
    		while($row = mysqli_fetch_assoc($result)) {
    			// echo "start";
    			
    			$data = array(			
    				'phone'=> preg_replace('/[; & # % ]+/', ' ', trim($row['ComPhone'])),
    				'city'=> preg_replace('/[; & # % ]+/', ' ', trim($row['ComCity'])),
    				'name'=> preg_replace('/[; & # % ]+/', ' ', trim($row['ComName'])),
    				'pin'=> preg_replace('/[; & # % ]+/', ' ', trim($row['postalcode'])),
    				'address'=> preg_replace('/[; & # % ]+/', ' ', trim($row['comAdd'])),
    				'country'=> 'India',
    				'contact_person'=> preg_replace('/[; & # % ]+/', ' ', trim($row['CustName'])),
    				'email'=>preg_replace('/[; & # % ]+/', ' ', trim($row['CustEmail'])),
    				'registered_name'=> preg_replace('/[; & # % ]+/', ' ', trim($row['ComName'])),
    				'return_address'=> preg_replace('/[; & # % ]+/', ' ', trim($row['comAdd'])),
    				'return_pin'=> preg_replace('/[; & # % ]+/', ' ', trim($row['postalcode'])),
    				'return_city'=> preg_replace('/[; & # % ]+/', ' ', trim($row['ComCity'])),
    				'return_state'=> preg_replace('/[; & # % ]+/', ' ', trim($row['ComState'])),
    				'return_country'=> 'India',
    			);
    			    			
                
                $json_data = json_encode($data);    			
    			// echo "<pre>";print_r($json_data);	die;
	
				
    			$ch = curl_init(); 
    			// Live               
    			// curl_setopt($ch, CURLOPT_URL, "https://track.delhivery.com/api/backend/clientwarehouse/create/");
    			curl_setopt($ch, CURLOPT_URL, "https://staging-express.delhivery.com/api/backend/clientwarehouse/create/");
    			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    			curl_setopt($ch, CURLOPT_HEADER, FALSE);
    			curl_setopt($ch, CURLOPT_POST, TRUE);
    			curl_setopt($ch, CURLOPT_POSTFIELDS,$json_data);
    			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    				"Content-Type: application/json",
    				"Accept : application/json",
    				   "Authorization: Token 13e6e16ea6506989bb0d3fbaef437402278bffeb"
    			)); 
    		    			
    			// $response = curl_exec($ch);
    			// curl_close($ch); 
    			// $res = json_decode($response);
    			// echo '<pre>';print_r($res);die;
				$response = curl_exec($ch);
				//print_r($response);
    			curl_close($ch); 
    			$res = json_decode($response);
    			echo '<pre>';print_r($res);
    			
    		}
    	} else {
    		echo "0 results";
    	}
	}
	
	
	
	mysqli_close($conn);
	?>