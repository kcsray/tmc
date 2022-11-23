<?php
session_start();
// Start of Date wise procedure
//

if(isset($_POST['endate'])){
require "config.php";
$endate =$_POST['endate'];
$fdata="";

$sql ="select  tmc_migrants.id ,tmc_migrants.tmc_cd , tmc_migrants.mname,tmc_migrants.age, tmc_migrants.sex,tmc_migrants.mobileno, tmc_state.sname,DATE_FORMAT(tmc_migrants.endate,'%d-%m-%Y') as endate   ,DATE_FORMAT(tmc_migrants.exdate,'%d-%m-%Y') as exdate , tmc.block,tmc.gp,tmc.tmc_name,DATEDIFF(exdate,current_date()) as days 
from    tmc_migrants, tmc,tmc_state
where  tmc_migrants.tmc_cd = tmc.id and tmc_migrants.scode=tmc_state.scode and tmc_migrants.endate  = '". $endate ."'   order by tmc.block, tmc.gp ;";


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
				 
			</tr>
			</thead>";
				
	if($result->rowCount() > 0){

    $data .= "<tbody>";
	$slno=0;
    $bname="";
    $nbt=0;

	while($row = $result->fetch()){
		$slno=$slno+1;	
     if(!empty($bname)  && $bname !== $row['block'] ){
        $fdata .= "<span class='badge badge-pill badge-info '> " .$bname .":</span><span class='badge badge-pill badge-primary '> ".$nbt."</span>";
      $bname="";
      $nbt=0;
     }
        $bname=$row['block'];
        $nbt=$nbt+1;
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
		 // 
		

	}
  if(!empty($bname)  && $bname !== $row['block'] ){
      $fdata .= "<span class='badge badge-pill badge-info '> " .$bname .":</span><span class='badge badge-pill badge-primary '> ".$nbt."</span>";
      $bname="";
      $nbt=0;
     }
	$data .= "</tbody></table>";
	$fdata	.= " <br><span class='badge badge-pill badge-warning '>Total: </span><span class='badge badge-pill badge-danger '>".$slno."</span>";																							
	}else{
	   $data .="<tr><td colspan='9'>No Record </td></tr>";
	}
	}
	$fdata .=$data;
	echo $fdata;
	}


//  --- end of Date procedure   ---
 
// for tmc
/*
sadmin  --- User
Su#321  --- Password 
*/
if(isset($_POST['bcode_tmc'])){
require "config.php";
$bcdtmc =$_POST['bcode_tmc'];

$sql ="select id,bcd,block,gp,tmc_name,totbed,filbed ,(totbed-filbed ) as vacbed
 from tmc where bcd='". $bcdtmc ."' order by tmc.gp,tmc.tmc_name;";


if($result = $pdo->query($sql)){
	$data = "<table class='table table-bordered table-striped'>
	<thead class='text-primary' >
		<tr>
			<th># </th>
			<th>TMC</th>
			
			<th>Capacity</th>
			<th>Filled</th>
			<th>Available</th>";
if(   isset($_SESSION["loggedin"]) && isset($_SESSION["role"]) &&  $_SESSION["role"] ==='A' && $_SESSION["loggedin"] === true  && $_SESSION["username"] ==='sadmin' ){
	  		$data .="<th>Action</th>";
}
			$data .=" </tr></thead>";
				
	if($result->rowCount() > 0){

    $data .= "<tbody>";
	$slno=0;
	while($row = $result->fetch()){
		$slno=$slno+1;	
		$data .= "<tr><td>" . $slno ."</td>";
		$data .= "<td>" . $row['tmc_name'] . ",<br>".$row['gp'] .", ".$row['block']."</td>";
		$data .= "<td><p class='btn btn-warning'>" . $row['totbed'] . "</p></td>";
		$data .= "<td><p class='btn btn-danger'>" . $row['filbed'] . "</p></td>";
		$data .= "<td><p class='btn btn-success'> " . $row['vacbed'] . "</p></td>";
		if(   isset($_SESSION["loggedin"]) && isset($_SESSION["role"]) &&  $_SESSION["role"] ==='A' && $_SESSION["loggedin"] === true && $_SESSION["username"] ==='sadmin' ){
			//$data .= "<td><p class='btn btn-info'> " . "EDIT" . "</p></td>";
			$data .= "<td> <a href='TMCEdit.php?tmcd="  .$row['id']. "' class='btn btn-info ' >Edit</a></td>";
		} 
														
		$data .= "</tr>";
		

	}
	$data .= "</tbody></table>";
																									
	}else{
	   $data .="<tr><td colspan='5'>No Record</td></tr>";
	}
	}
	echo $data;
	}

	//--------------------------------
//

if(isset($_POST['bcode'])){
require "config.php";
$bcd =$_POST['bcode'];

$sql ="SELECT  tmc_migrants.id ,tmc_migrants.tmc_cd , tmc_migrants.mname,tmc_migrants.age, tmc_migrants.sex,tmc_migrants.mobileno, tmc_state.sname,DATE_FORMAT(tmc_migrants.endate,'%d-%m-%Y') as endate   ,DATE_FORMAT(tmc_migrants.exdate,'%d-%m-%Y') as exdate , tmc.block,tmc.gp,tmc.tmc_name,DATEDIFF(exdate,current_date()) as days 
from    tmc_migrants, tmc, tmc_state
where  tmc_migrants.tmc_cd = tmc.id and tmc_migrants.scode=tmc_state.scode  and tmc.bcd = '".$bcd."' and tmc_migrants.sts  is null  order by tmc.id;";


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
		 // 
		

	}
	$data .= "</tbody></table>";
																									
	}else{
	   $data .="<tr><td colspan='9'>No Record</td></tr>";
	}
	}
	echo $data;
	}

	//   
	// ---------------- Start of Edit Delete  Migrant Block wise

if(isset($_POST['bcode_ed'])){
require "config.php";
$bcd =$_POST['bcode_ed'];
 
$username =$_POST['username'];


$sql ="select  tmc_migrants.id , tmc_migrants.tmc_cd ,tmc_migrants.mname,tmc_migrants.age, tmc_migrants.sex,tmc_migrants.mobileno,tmc_state.sname,DATE_FORMAT(tmc_migrants.endate,'%d-%m-%Y') as endate   ,DATE_FORMAT(tmc_migrants.exdate,'%d-%m-%Y') as exdate , tmc.block,tmc.gp,tmc.tmc_name, DATEDIFF(exdate,current_date()) as days 
from    tmc_migrants, tmc, tmc_state
where  tmc_migrants.tmc_cd = tmc.id and tmc_migrants.scode=tmc_state.scode  and tmc.bcd = '". $bcd ."'  and  tmc_migrants.sts is null order by tmc_migrants.id ;";


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
			<th >Exit Date</th>
		   <th colspan='3'>Action</th>
		 	 
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
         		$data .= "<td class='weight-bold text-warning'>" .$row['exdate']."</td>";
         	}else{
         		$data .= "<td>" .$row['exdate']."</td>";
         	}
         }
		 //   
		
		$data .= "<td> <a href='MigrantDelete.php?mcode="  .$row['id'].  "&tmc_cd=".$row['tmc_cd']."' class='btn btn-danger ' >Delete</a></td>";
		$data .= "<td> <a href='MigrantsUpdate.php?mcode="  .$row['id']."' class='btn btn-info ' >Edit</a></td>";
		
		// $data .= "<td> <a href='MigrantEdit.php?mcode="  .$row['id'].  "&tmc_cd=".$row['tmc_cd']."&user=".$username."' class='btn btn-warning ' >Exit</a></td>";

		 
		

		$data .= "</tr>";

	}
	$data .= "</tbody></table>";
																									
	}else{
	   $data .="<tr><td colspan='12'>No Record</td></tr>";
	}
	}
	echo $data;
	}
	 
	// ---------------- End of Edit Delete  Migrant Block wise
	//
	// ---------------- Start of Edit Delete  Migrant TMC wise

if(isset($_POST['tmc_ed']) ){
require "config.php";
$tmc_code =$_POST['tmc_ed'];
 
$username =$_POST['username'];


$sql ="select  tmc_migrants.id , tmc_migrants.tmc_cd ,tmc_migrants.mname,tmc_migrants.age, tmc_migrants.sex,tmc_migrants.mobileno,tmc_state.sname,DATE_FORMAT(tmc_migrants.endate,'%d-%m-%Y') as endate   ,DATE_FORMAT(tmc_migrants.exdate,'%d-%m-%Y') as exdate , tmc.block,tmc.gp,tmc.tmc_name, DATEDIFF(exdate,current_date()) as days 
from    tmc_migrants, tmc, tmc_state
where  tmc_migrants.tmc_cd = tmc.id and tmc_migrants.scode=tmc_state.scode  and tmc.id = '". $tmc_code ."'  and  tmc_migrants.sts is null order by tmc_migrants.id ;";


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
			<th >Exit Date</th>
		   <th colspan='3'>Action</th>
		 	 
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
         		$data .= "<td class='weight-bold text-warning'>" .$row['exdate']."</td>";
         	}else{
         		$data .= "<td>" .$row['exdate']."</td>";
         	}
         }
		 //   
		
		$data .= "<td> <a href='MigrantDelete.php?mcode="  .$row['id'].  "&tmc_cd=".$row['tmc_cd']."' class='btn btn-danger ' >Delete</a></td>";
			$data .= "<td> <a href='MigrantsUpdate.php?mcode="  .$row['id']."' class='btn btn-info ' >Edit</a></td>";
		
		//$data .= "<td> <a href='MigrantEdit.php?mcode="  .$row['id'].  "&tmc_cd=".$row['tmc_cd']."&user=".$username."' class='btn btn-warning ' >Exit</a></td>";

		 
		

		$data .= "</tr>";

	}
	$data .= "</tbody></table>";
																									
	}else{
	   $data .="<tr><td colspan='12'>No Record</td></tr>";
	}
	}
	echo $data;
	}
	 
	// ---------------- End of Edit Delete  Migrant TMC wise

	// ---------------- Start of Edit Delete  Migrant TMC wise

if(isset($_POST['tmc_ex']) ){
require "config.php";
$tmc_code =$_POST['tmc_ex'];
 
$username =$_POST['username'];


$sql ="select  tmc_migrants.id , tmc_migrants.tmc_cd ,tmc_migrants.mname,tmc_migrants.age, tmc_migrants.sex,tmc_migrants.mobileno,tmc_state.sname,DATE_FORMAT(tmc_migrants.endate,'%d-%m-%Y') as endate   ,DATE_FORMAT(tmc_migrants.exdate,'%d-%m-%Y') as exdate , tmc.block,tmc.gp,tmc.tmc_name, DATEDIFF(exdate,current_date()) as days 
from    tmc_migrants, tmc, tmc_state
where  tmc_migrants.tmc_cd = tmc.id and tmc_migrants.scode=tmc_state.scode  and tmc.id = '". $tmc_code ."'  and  tmc_migrants.sts is null order by tmc_migrants.id ;";


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
			<th >Exit Date</th>
		   <th colspan='3'>Action</th>
		 	 
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
         		$data .= "<td class='weight-bold text-warning'>" .$row['exdate']."</td>";
         	}else{
         		$data .= "<td>" .$row['exdate']."</td>";
         	}
         }
		 //   
		
		$data .= "<td> <a href='MigrantEdit.php?mcode="  .$row['id'].  "&tmc_cd=".$row['tmc_cd']."&user=".$username."' class='btn btn-warning ' >Exit</a></td>";		

		$data .= "</tr>";

	}
	$data .= "</tbody></table>";
																									
	}else{
	   $data .="<tr><td colspan='12'>No Record</td></tr>";
	}
	}
	echo $data;
	}
	 
	// ---------------- End of Edit Delete  Migrant TMC wise
	
	?>


	