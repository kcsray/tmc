<?php
session_start();
/*
if( !isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true  ) {
$_SESSION["loggedin"] = false;
$_SESSION["pfile"] = htmlspecialchars($_SERVER["PHP_SELF"]);
header("location: login.php");
exit;

}
*/
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
			<h1 class="text-primary text-center">Migrants Exit from TMC Abstract</h1>
			<p>
				<a href="/tmc" class="btn btn-info "> Back  </a>
				<a href="MigrantsShifted.php" class="btn btn-primary float-right">View Detail </a>
			</p>
			<hr>
			 
<?php
// Start of Date wise procedure
//

 require "config.php";

 
$sql ="SELECT   tmc_migrants.id ,tmc_migrants.tmc_cd , tmc_migrants.sts ,  ucase(tmc.block ) as block  
from    tmc_migrants, tmc 
where  tmc_migrants.tmc_cd = tmc.id   order by  ucase(tmc.block ),tmc_migrants.sts ;";


if($result = $pdo->query($sql)){
	$data = "<table class='table table-bordered table-striped'>
	<thead class='text-primary' >
		<tr>
			<th># </th>
			<th>Block/ULB</th>
			<th>Total Migrants <br>Registerd</th>
			<th>Exit or Shifted<br> From TMC</th>
			<th>Remaining in TMC</th>			 
			</tr>
			</thead>";
				
	if($result->rowCount() > 0){

    $data .= "<tbody>";
	$slno=0;
    $bname="";
    $nbt=0;
    $nbex=0;
    $nbTotal = $nbexTotal=0;
    echo $data ;

	while($row = $result->fetch()){
		
     if(!empty($bname)  && $bname !== $row['block'] ){
         $slno=$slno+1;	
        	echo "<tr><td >".$slno."</td><td class='font-weight-bold'>".$bname."</td><td class='font-weight-bold text-info'>".$nbt."</td><td class='font-weight-bold text-success'>".$nbex."</td><td class='font-weight-bold text-danger'>".($nbt-$nbex)."</td></tr>";   
         $bname="";
        $nbt=0;
        $nbex=0;   
     }
        $bname=$row['block'];
        $nbt=$nbt+1;
        $nbTotal = $nbTotal+1;
        //
      if($row['sts']=== 'E'){
          $nbex= $nbex+1;
          $nbexTotal= $nbexTotal+1;
      } 	

	} // wend While loop

  if(!empty($bname)  && $bname !== $row['block'] ){
  	$slno=$slno+1;	
      	echo "<tr><td >".$slno."</td><td class='font-weight-bold'>".$bname."</td><td class='font-weight-bold text-info'>".$nbt."</td><td class='font-weight-bold text-success'>".$nbex."</td><td class='font-weight-bold text-danger'>".($nbt-$nbex)."</td></tr>";  
      $bname="";
      $nbt=0;
      $nbex=0;
      
     }
     echo "<tr><td colspan='2' class='font-weight-bold'>Total</td><td class='font-weight-bold text-info'>".$nbTotal."</td><td class='font-weight-bold text-success'>".$nbexTotal."</td><td class='font-weight-bold text-danger'>".($nbTotal-$nbexTotal)."</td></tr>";  
	echo  "</tbody></table>";
																								
	}else{
	   echo "<tr><td colspan='5'>No Record </td></tr>";
	   echo  "</tbody></table>";
	}
	}
	 
	 
 


//  --- end of Date procedure   ---
?>
	</div>
	</body>
</html>
