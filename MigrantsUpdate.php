<?php

session_start();
if( !isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true ) {


 $_SESSION["loggedin"] = false;

$_SESSION["pfile"] = "MigrantBlock.php";
header("location: login.php");
exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$mname = $sex = $age = $mobileno = $endate=$scode="";
 

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"]) && !empty($_POST["id"])){
// Get hidden input value
$id = $_POST["id"];

 
$input_mname = trim($_POST["mname"]);
$input_sex = trim($_POST["sex"]);
$input_age = trim($_POST["age"]);
$input_mobileno = trim($_POST["mobileno"]);
$input_en_dt  = trim($_POST["en_dt"]);
$input_scode  = trim($_POST["state"]);
$param_id = $id;
if( empty($input_mname )  || empty($input_sex) || empty($input_age) || empty($input_mobileno ) || empty($input_en_dt)){
// Destroy the session.
session_destroy();
header("location: error.php");
exit();
}else{
// Prepare an update statement
$sql = "UPDATE tmc_migrants  
        SET   mname=:mname, sex=:sex,age=:age,mobileno=:mobileno,endate=:endate ,scode=:scode
        WHERE id=:id";

if($stmt = $pdo->prepare($sql)){
// Bind variables to the prepared statement as parameters

$stmt->bindParam(":mname", $input_mname, PDO::PARAM_STR);
$stmt->bindParam(":sex", $input_sex, PDO::PARAM_STR);
$stmt->bindParam(":age", $input_age, PDO::PARAM_INT);
$stmt->bindParam(":mobileno", $input_mobileno, PDO::PARAM_STR);
$stmt->bindParam(":endate",$input_en_dt , PDO::PARAM_STR);
$stmt->bindParam(":scode",$input_scode , PDO::PARAM_STR);
 
$stmt->bindParam(":id", $param_id,PDO::PARAM_INT);

// Set parameters
 
// $param_filbed = $filbed;
$param_id = $id;

// Attempt to execute the prepared statement
if($stmt->execute()){
    $sql ="UPDATE  tmc_migrants SET exdate=adddate(endate,interval 21 day) where id  = :id ;";
    if($stmt = $pdo->prepare($sql)){
        $stmt->bindParam(":id", $param_id,PDO::PARAM_INT);
        $param_id = $id;
      if($stmt->execute()){
         // Records updated successfully. Redirect to landing page
          header("location: MigrantBlock2tmc.php");
          exit();
        }
    }
}else{
echo "Something went wrong. Please try again later.";
}
}

// Close statement
unset($stmt);
}

// Close connection
unset($pdo);
} else{

// Check existence of id parameter before processing further
if(isset($_GET["mcode"]) && !empty(trim($_GET["mcode"]))){
// Get URL parameter
$id =  trim($_GET["mcode"]);

// Prepare a select statement
$sql = "SELECT  * from tmc_migrants  WHERE id = :id";
if($stmt = $pdo->prepare($sql)){
// Bind variables to the prepared statement as parameters
$stmt->bindParam(":id", $param_id,PDO::PARAM_INT);

// Set parameters
$param_id = $id;

// Attempt to execute the prepared statement
if($stmt->execute()){
if($stmt->rowCount() == 1){
/* Fetch result row as an associative array. Since the result set
contains only one row, we don't need to use while loop */
$mname = $sex = $age = $mobileno = $endate=$scode="";
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Retrieve individual field value
$mname = $row["mname"] ;
$sex = $row["sex"];
$age = $row["age"];
$mobileno = $row["mobileno"];
$endate = $row["endate"];
$scode = $row["scode"];
} else{
// URL doesn't contain valid id. Redirect to error page
header("location: error.php");
exit();
}

} else{
echo "Oops! Something went wrong. Please try again later.";
}
}

// Close statement
unset($stmt);

// Close connection
unset($pdo);
}  else{
// URL doesn't contain id parameter. Redirect to error page
header("location: error.php");
exit();
}
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title> Update Migrants Record</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <style type="text/css">
        .wrapper{
        width: 500px;
        margin: 0 auto;
        }
        </style>
    </head>
    <body>
        <div class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header">
                            <h2 class="text-info" >Update Migrants</h2><br>
                        </div>
                         
                        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" class="needs-validation" novalidate>

                             

        <div class="form-group">
          <label for="mname">Migrants *</label>
          <input type="text" class="form-control" id="mname"   name="mname" pattern="[a-zA-Z\-. ]*"  onblur="myFunction()"  required  value="<?php echo $mname; ?>">
          <div class="invalid-feedback">Please fill out this field.</div>
        </div>
                            
        <div class="form-group">
          <label for="age" class="control-label">Age</label>
          <div>
            <input type="number" name="age" id="age"  min="0" max="120" class="form-control" pattern="[0-9]*" required="required" placeholder="Age" value="<?php echo $age; ?>" >
          </div>
        </div>
        <div class="form-group">
          <label for="sex">Gender *</label>
          <select name="sex" id="sex" class="form-control" required="required" data-error="Please Select an Option">
            <option value="M"  <?php echo (($sex == 'M')? 'selected':'') ; ?> >Male </option>
            <option value="F"  <?php echo (($sex == 'F')? 'selected':'') ; ?>  >Female</option>
            <option value="T"  <?php echo (($sex == 'T')? 'selected':'') ; ?> >Transgender</option>
          </select>
          <div class="help-block with-errors"></div>
        </div>   
        <div class="form-group">
          <label for="mobileno" class="control-label">Mobile No*</label>
          <div>
            <input type="text" name="mobileno" id="mobileno"  class="form-control" maxLength="10" pattern="[1-9]{1}[0-9]{9}" required="required" placeholder="Mobile No" data-error="10 digit Mobile No is required."  value="<?php echo $mobileno; ?>">
            <div class="help-block with-errors"></div>
            <div class="messages with-errors"></div>
          </div>
        </div>
        <div class="form-group">
          <label for="en_dt">Entry Date:</label>
          <input  id ="en_dt"  name="en_dt" type="date" data-date="" data-date-format="DD MMMM YYYY" value="<?php echo $endate; ?>" required >
          <div class="invalid-feedback">Please fill out this field with vadid Data</div>
        </div>
        <div class="form-group" >
          <label for="state">Select Came from State</label>
          <select name="state" id="state" class="form-control" required data-error="Please Select State" >         
          </select>
        </div>
                            <input type="hidden" name="id" value="<?php echo $id; ?>" >
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <a href="MigrantBlock2tmc.php" class="btn btn-danger  float-right">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>        
         <script type="text/javascript">
    // Disable form submissions if there are invalid fields
    (function() {
    'use strict';
    window.addEventListener('load', function() {
    // Get the forms we want to add validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
    form.addEventListener('submit', function(event) {
    if (form.checkValidity() === false) {
    event.preventDefault();
    event.stopPropagation();
    }
    form.classList.add('was-validated');
    }, false);
    });
    }, false);
    })();
     
    // 
    function myFunction() {
    var x = document.getElementById("mname");
    x.value = x.value.toUpperCase();
    }
 
//  Sate Function
    //
       $(document).ready(function(){
    var mscode="<?php echo $scode ?>";
    $.ajax({
    url:"getTMC.php",
    type:'POST',
    data:{m_scode:mscode},
    success:function(data,status){
    $('#state').html(data);
    }
    });
    });
    //

    </script>
    </body>
</html>