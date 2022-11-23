<?php
// Initialize the session
session_start();
 if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true  || !$_SESSION["username"] ) {
$_SESSION["pfile"] = "regComplain.php";
header("location: login.php");
exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>The Complian for: <b><?php echo htmlspecialchars($_SESSION["mname"]); ?></b> has been Registed..</h1>
    </div>
    <p>
        <a href="regComplain.php" class="btn btn-warning">Add More Complain </a>
         <a href="index.php" class="btn btn-info">Back to main </a>
        
    </p>


<?php
 

require "config.php";
 $user = $_SESSION["username"] ;
$data="";

$sql="SELECT  tmc_complain.cname,tmc_complain.mobileno, tmc.tmc_name,tmc.block,  tmc_comtype.ctype,DATE_FORMAT(tmc_complain.rdate,'%d-%m-%Y') as rdate,tmc_complain.pending 
  from tmc_complain, tmc, tmc_comtype  where tmc_complain.username= '".   $user  . "' and   tmc_complain.tmc=  tmc.id  and tmc_complain.ccode =  tmc_comtype.ccode order by  tmc_complain.id desc "  ;

if($result = $pdo->query($sql)){
  $data="<h4  class='text-primary'>Complain regiserd by your ID are:</h4>";
    $data .= "<table class='table table-bordered table-striped'>
    <thead class='text-primary' >
        <tr>
           <th>#</th>
            <th>Reg.Date</th>
            <th>Name</th>     
            <th>Mobile No</th>
            <th>TMC Name</th>
            <th>Complain Type</th>         
        </tr>
    </thead>";
                
    if($result->rowCount() > 0){

    $data .= "<tbody>";
    $slno=0;
    while($row = $result->fetch()){
        $slno=$slno+1;  
        $data .= "<tr><td>".$slno."</td>";
        $data .= "<td>".$row['rdate']."</td>";
        $data .= "<td>" . $row['cname'] . "</td>";
        $data .= "<td>" . $row['mobileno'] . "</td>";
        $data .= "<td>" .$row['tmc_name'].",".$row['block']."</td>";
        $data .= "<td>" . $row['ctype'] . "</td>";                                              
        
         
        $data .= "</tr>";

    }
    $data .= "</tbody></table>";
                                                                                                    
    }else{
       $data .="<tr><td colspan='9'>No Record</td></tr>";
    }
    }
    echo $data;


 

//------------------



?>


</body>
</html>