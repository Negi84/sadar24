<?php 

	include('inc/connect.php');

?>
<!doctype html>
<html lang="en">
	<head>
		<title>Sadar24 seller, Sadar24 seller login, Seller.sadar24, Seller registration of Sadar24</title>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css">

		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

		<script type="text/javascript" src="https://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
	</head>
	<body>
<div class="container">
    <div class="row header" style="text-align:center;color:green">
        <h3>Sadar24 Leads Data</h3>
    </div>
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Phone</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
			<?php 
				$sql = "SELECT * FROM tbl_seller_query where addon > '2021-11-15 07:14:34'  ORDER BY id DESC";
				$result = mysqli_query($conn, $sql);

				if (mysqli_num_rows($result) > 0) {
					$i=1;
					while($row = mysqli_fetch_assoc($result)) {
			?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo $row["phone"]; ?></td>
					<td><?php echo $row["addon"]; ?></td>
				</tr> 	
			<?php 
				$i++;
					}
			} else {
			  echo "0 results";
			}
			?>			
        </tbody>       
    </table>
</div>
<script>
    $(document).ready(function() {
$('#example').DataTable();
} );
</script>
</body>
</html>