<?php
//
session_start();


if(isset($_POST['bcode'])){

if( !isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true  ) {


 $_SESSION["loggedin"] = false;

$_SESSION["pfile"] = "MigrantsShifted.php";
header("location: login.php");
exit;
}

require "config.php";
$bcd =$_POST['bcode'];

$sql ="SELECT  tmc_migrants.id ,tmc_migrants.tmc_cd , tmc_migrants.mname,tmc_migrants.age, tmc_migrants.sex,tmc_migrants.mobileno, tmc_state.sname,DATE_FORMAT(tmc_migrants.endate,'%d-%m-%Y') as endate   ,DATE_FORMAT(tmc_migrants.exdate,'%d-%m-%Y') as exdate , tmc.block,tmc.gp,tmc.tmc_name,DATEDIFF(exdate,current_date()) as days ,DATE_FORMAT(tmc_migrants.udate,'%d-%m-%Y') as udate, tmc_migrants.userby
from    tmc_migrants, tmc, tmc_state
where  tmc_migrants.tmc_cd = tmc.id and tmc_migrants.scode=tmc_state.scode  and tmc.bcd = '".$bcd."' and tmc_migrants.sts  ='E'  order by tmc.id;";


if($result = $pdo->query($sql)){
	$data = "<table class='table table-bordered table-striped'>
	<thead class='text-primary' >
		<tr>
			<th># </th>
			<th>Entry Date</th>
			<th>Name</th>
			<th>Age</th>
			<th>Gender</th>
			<th>Mobile No</th>
			<th>Came From</th>
			<th>TMC Address</th>
			<th>Exit Date</th>
			<th>Updated Date<br>Database</th>	
			<th>Updated By<br>User</th>	 
			</tr>
			</thead>";
				
	if($result->rowCount() > 0){

    $data .= "<tbody>";
	$slno=0;
	while($row = $result->fetch()){
		$slno=$slno+1;	
		$data .= "<tr><td>" . $slno ."</td>";
		$data .= "<td>" . $row['endate']."</td>";
		$data .= "<td>" . $row['mname'] . "</td>";
		$data .= "<td>" . $row['age'] . "</td>";
		$data .= "<td>" . $row['sex'] . "</td>";
		$data .= "<td>" . $row['mobileno'] . "</td>";
		$data .= "<td>" . $row['sname'] . "</td>";
		$data .= "<td>" . $row['tmc_name'] . ",<br>".$row['gp'] .", ".$row['block']."</td>";												
		//
         if((int)$row['days'] <= 0){
         	$data .= "<td class='font-weight-bold text-success'>" .$row['exdate']."</td>";
         }else{
         	if((int)$row['days'] == 1){
         		$data .= "<td class='weight-bold text-info'>" .$row['exdate']."</td>";
         	}else{
         		$data .= "<td>" .$row['exdate']."</td>";
         	}
         }
         $data .= "<td>" .$row['udate']."</td>";
         $data .= "<td>" .$row['userby']."</td>";
		 // 

	}
	$data .= "</tbody></table>";
																									
	}else{
	   $data .="<tr><td colspan='10'>No Record</td></tr>";
	}
	}
	echo $data;
	}
		?>