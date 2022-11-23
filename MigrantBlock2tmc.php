<?php
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
/*
$_SESSION["loggedin"] = true;
$_SESSION["bcd"]='2601 ';
*/
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true  || !isset($_SESSION["bcd"]) ) {
	$_SESSION["loggedin"] !== false;
$_SESSION["pfile"] = htmlspecialchars($_SERVER["PHP_SELF"]);
header("location: login.php");
exit;
}
$user = $_SESSION["username"];
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Migrant List View and Update</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	</head>
	<body>
		<div class="container">
			<h1 class="text-primary text-center">Migrant Edit, Delete</h1>
			<p class="text-dark">
				Delete - <i class="text-danger">Permanently Delete if Wrongly Entered.</i><br>
				 
			</p>
			<p>
				<a href="/tmc" class="btn btn-info "> Back  </a>
				<a href="logout.php" class="btn btn-danger float-right">Sign Out</a>
			</p>
			
			<div class="form-group font-weight-bold" >
				<label for="block" >Select Block </label>
				<select name="block" id="block"   class="form-control-sm w-75"  onchange="getBlockTMC()">
				</select>
				 
			</div>	
				<label for="tmc" class="font-weight-bold" >Select  Tmc </label>
				<select name="tmc" id="tmc" class="form-control-sm w-75"   onchange="getMigrantTMC()" >
				</select>
			
			<br>
		</div>
		<div class="container-fluid">
			<div id="record_contain">
			</div>
			
		</div>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			//
		$(document).ready(function(){
		var icode='block';
		
		$.ajax({
		url:"getTMC.php",
		type:'POST',
		data:{block:icode},
		success:function(data,status){
		$('#block').html(data);
		}
		});
		});
			
		//------- For Tmc
      function getBlockTMC(){
      	var bcd=$('#block').val();
    $.ajax({
    url:"getTMC.php",
    type:'POST',
    data:{bcode:bcd},
    success:function(data,status){
    $('#tmc').html(data);
    }
    });
      }
        //
     function getMigrantTMC(){
     	var tmc=$('#tmc').val();
		var user='<?php echo trim($user); ?>';

       if(tmc ===""){
            alert('Please Select TMC');
       }else{     

		$.ajax({
		url:"getMigrants.php",
		type:'POST',
		data:{tmc_ed:tmc,username:user},
		success:function(data,status){
		$('#record_contain').html(data);
		}
		});
	  }
     }
//
		</script>
	</body>
</html>