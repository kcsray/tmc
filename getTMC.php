<?php
session_start();
// Start  of State function
if( isset($_POST['m_scode']) ){

	if( !isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true ) {
        $_SESSION["loggedin"] = false;

      $_SESSION["pfile"] = "MigrantBlock.php";
      header("location: login.php");
      exit;
    }
require "config.php";
 
 $m_scode = $_POST['m_scode'];

$sql=" select  scode, sname  from tmc_state  order by sname; ";
if($result = $pdo->query($sql)){
	 
	$vn=0;			
	if($result->rowCount() > 0){
     
	while($row = $result->fetch()){
	
	$data .= "<option  value='". $row['scode']."'". (($row['scode'] == $m_scode)? 'selected':'')  .">". $row['sname'] . "</option>";
	
	} 
																									
	}else{
	   $data = "<option value=''> ----- No Data ------ </option>";
	}
	}
	echo $data;
	}
	//--------------------------------

//--- End of edit migrant State
// Start  of State function
if(isset($_POST['scode']) ){
require "config.php";
 

$sql=" select  scode, sname  from tmc_state  order by sname; ";
if($result = $pdo->query($sql)){
	$data = "<option value='' disable> ----- Select One ------ </option>";
	 
	$vn=0;			
	if($result->rowCount() > 0){
    
 
	while($row = $result->fetch()){
		 
		 

		$data .= "<option  value='". $row['scode']."'>". $row['sname'] . "</option>";
		 
	
	}
	 
																									
	}else{
	   $data = "<option value=''> ----- No Data ------ </option>";
	}
	}
	echo $data;
	}
	//--------------------------------

// end of State function
if(isset($_POST['abcode'])){
require "config.php";

$sql=" SELECT  tmc_block.bname,sum(tmc.totbed) as capacity,sum(tmc.filbed) as filled ,sum(tmc.totbed) - sum(tmc.filbed) as vacancy  from tmc,tmc_block where  tmc.bcd =tmc_block.bcode group by tmc_block.bname ";
if($result = $pdo->query($sql)){
	$data = "<table class='table table-sm table-bordered table-striped'>
	<thead class='text-info  ' >
		<tr>
			 
			<th>BLOCK/ULB</th>
			<th>Capacity</th>
			<th>Filled</th>
			<th>Available</th>
	  			 
			</tr>
			</thead>";
				
	if($result->rowCount() > 0){
  
     $ctotal= $ftotal= $vtotal=0;

    $data .= "<tbody>";
	 
	while($row = $result->fetch()){
		 
		 $data .= "<tr>";

		$data .= "<td class='text-dark font-weight-bold'> " . $row['bname']." </td>";
		$data .= "<td class='text-primary font-weight-bold'> " . $row['capacity'] . " </td>";
		$data .= "<td class='text-danger font-weight-bold'> " . $row['filled'] . " </td>";
		$data .= "<td class='text-success font-weight-bold'> " . $row['vacancy'] . " </td>";
		
		$ctotal= $ctotal+ $row['capacity']  ;
		$ftotal= $ftotal+ $row['filled'] ;
		$vtotal= $vtotal+ $row['vacancy'] ; 
														
		$data .= "</tr>";
		

	}
  	 $data .= "<tr>";
  	 	$data .= "<th class='text-dark font-weight-bold'> Total  </td>";
		$data .= "<th><span class='badge badge-pill badge-primary '> " . $ctotal . " </span></th>";
		$data .= "<th> <span class='badge badge-pill badge-danger'>" . $ftotal . " </span></th>";
		$data .= "<th> <span class='badge badge-pill badge-success'>" . $vtotal . " </span></th>";
  	 $data .= "</tr>";

	$data .= "</tbody></table>";
																									
	}else{
	   $data .="<tr><td colspan='4'>No Record</td></tr>";
	}
	}
	echo $data;

}

//
if(isset($_POST['block']) ){
require "config.php";
 
$sql=" SELECT bcode,bname  from tmc_block where type='R' or type='U' ; ";
if($result = $pdo->query($sql)){
	$data = "<option value='' disable> ----- Select One ------ </option>";
	 
	$vn=0;			
	if($result->rowCount() > 0){
    
 
	while($row = $result->fetch()){
		 
		 

		$data .= "<option  value='". $row['bcode']."'>". $row['bname'] . "</option>";
		 
	
	}
	 
																									
	}else{
	   $data = "<option value=''> ----- No Data ------ </option>";
	}
	}
	echo $data;
	}
	//-------------------------------- end of block --
if(isset($_POST['ccode']) ){
require "config.php";
 
$sql=" SELECT  ccode,ctype from tmc_comtype ; ";
if($result = $pdo->query($sql)){
	$data = "<option value='' disable> ----- Select One ------ </option>";
	 
	$vn=0;			
	if($result->rowCount() > 0){
    
 
	while($row = $result->fetch()){
		 
		 

		$data .= "<option  value='". $row['ccode']."'>". $row['ctype'] . "</option>";
		 
	
	}
	 
																									
	}else{
	   $data = "<option value=''> ----- No Data ------ </option>";
	}
	}
	echo $data;
	}
	//

//
if(isset($_POST['bcode']) ){

require "config.php";
 
$sql="SELECT id,gp,tmc_name,totbed ,filbed FROM  tmc   where bcd='" .$_POST['bcode']."' ; ";
if($result = $pdo->query($sql)){
	$data = "<option value='' disable> ----- Select One ------ </option>";
	 
	$vn=0;			
	if($result->rowCount() > 0){
    
 
	while($row = $result->fetch()){
		 
		$vn = (int)$row['totbed'] - (int)$row['filbed'];

		$data .= "<option  value='". $row['id']."'>". $row['tmc_name'] . ", ".$row['gp'] .", Total Bed: " .$row['totbed'] .",Vacancy: ".$vn. "</option>";
		 
	
	}
	 
																									
	}else{
	   $data = "<option value=''> ----- No Data ------ </option>";
	}
	}
	echo $data;
	}
	//

if(isset($_POST['tmc_cd']) ){
require "config.php";

$tmc_cd =$_POST['tmc_cd'];
$sql="SELECT  bcd, totbed,filbed ,(totbed-filbed ) as vacbed  from tmc   where id=" . $tmc_cd. ";";
if($result = $pdo->query($sql)){
	 $data = " ";
 		
	if($result->rowCount() > 0){
    
 
	while($row = $result->fetch()){
		 
		$data .= "<p class='btn btn-warning'>" . $row['totbed'] . "</p>";
		$data .= "<p class='btn btn'>   </p>";
		$data .= "<p class='btn btn-danger'>" . $row['filbed'] . "</p>";
		$data .= "<p class='btn btn'>   </p>";
		$data .= "<p class='btn btn-success'> " . $row['vacbed'] . "</p>";	 

		$_SESSION["tmcbcd"]= $row['bcd'];
		}
	 																									
	}else{
	    $data = " ";
	}
	}
	echo $data;
}



?>