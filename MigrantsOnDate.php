<?php
session_start();
if( !isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true  ) {
$_SESSION["loggedin"] = false;
$_SESSION["pfile"] = htmlspecialchars($_SERVER["PHP_SELF"]);
header("location: login.php");
exit;
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
		<title>Migrants on Date</title>
	</head>
	<body>
		<div class="container">
			<h1 class="text-primary text-center">Migrant List Entry Datewise</h1>
			<p>
				<a href="/tmc" class="btn btn-info "> Back  </a>
				<a href="logout.php" class="btn btn-danger float-right">Sign Out</a>
			</p>
			<hr>
			 
			<label for="en_dt">Entry Date:</label>
			<input  id ="en_dt"  name="en_dt" type="date" data-date="" data-date-format="DD MMMM YYYY" value="2020-05-04" required >
			<div class="invalid-feedback">Please fill out this field with vadid Data</div>
			 
			<button id="btnqry" class="btn btn-primary" onclick="readRecord()">Submit</button>
	</div>
			<hr>
			<div class="container-fluid">
				<div id="record_contain">
				</div>
			</div>
	
		
		<!--      ----------------------------------------------------------------------------------------------------------  -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
		<!--      ----------------------------------------------------------------------------------------------------------  -->
		<script type="text/javascript">
		
		function readRecord(){
		var endate=$('#en_dt').val();
		 
		$.ajax({
			url:"getMigrants.php",
			type:'POST',
			data:{endate:endate},
			success:function(data,status){
				$('#record_contain').html(data);
			}
		});
		}
		</script>
	</body>
</html>