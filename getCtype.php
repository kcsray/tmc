<?php
//
if(isset($_POST['ctype'])){
require "config.php";
 
$sql="SELECT  select ccode,ctype from tmc_comtype;";

if($result = $pdo->query($sql)){
	$data = "<option value='' disable> ----- Select One ------ </option>";
	 
	$vn=0;			
	if($result->rowCount() > 0){
    
 
	while($row = $result->fetch()){
		 
		 

		$data .= "<option  value='". $row['ccode']."'>". $row['ctype'] .  "</option>";
		 
	
	}
	 
																									
	}else{
	   $data = "<option value=''> ----- No Data ------ </option>";
	}
	}
	echo $data;
	}
	//


	?>