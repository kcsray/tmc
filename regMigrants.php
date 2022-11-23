<?php
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
/*
$_SESSION["loggedin"] = true;
$_SESSION["bcd"]='2601';
*/
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true  || !isset($_SESSION["bcd"]) ) {
$_SESSION["pfile"] = htmlspecialchars($_SERVER["PHP_SELF"]);
header("location: login.php");
exit;
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
  $input_mname = trim($_POST["mname"]);
  $input_sex = trim($_POST["sex"]);
  $input_age = trim($_POST["age"]);
  $input_mobileno = trim($_POST["mobileno"]);
  $input_en_dt  = trim($_POST["en_dt"]);
  
  if(isset($_SESSION["tmcbcd"])){
    $input_bcd = $_SESSION["tmcbcd"];
  }else{
    $input_bcd = trim($_POST["block"]);
  }

$input_tmc = trim($_POST["tmc"]);
$input_state = trim($_POST["state"]);


//exit();
if( empty($input_mname )  || empty($input_sex) || empty($input_age) || empty($input_mobileno ) || empty($input_en_dt) || empty($input_bcd ) || empty($input_tmc) || empty($input_state)  ){
// Destroy the session.
session_destroy();
header("location: verror.php");
exit();
}else{
require_once "config.php";
// Prepare an insert statement
$sql = "INSERT INTO tmc_migrants(mname,sex,age,mobileno,endate,bcd,tmc_cd,scode)
VALUES (upper(:mname),:sex,:age,:mobileno,:endate,:bcd,:tmc_cd, :scode)";
if($stmt = $pdo->prepare($sql)){
// Bind variables to the prepared statement as parameters
$stmt->bindParam(":mname", $input_mname, PDO::PARAM_STR);
$stmt->bindParam(":sex", $input_sex, PDO::PARAM_STR);
$stmt->bindParam(":age", $input_age, PDO::PARAM_INT);
$stmt->bindParam(":mobileno", $input_mobileno, PDO::PARAM_STR);
$stmt->bindParam(":endate",$input_en_dt , PDO::PARAM_STR);
$stmt->bindParam(":bcd", $input_bcd, PDO::PARAM_STR);
$stmt->bindParam(":tmc_cd", $input_tmc, PDO::PARAM_STR);
$stmt->bindParam(":scode", $input_state, PDO::PARAM_STR);
// Set parameters
// Attempt to execute the prepared statement
if($stmt->execute()){
// Records created successfully. Redirect to landing page

//
$sql ="UPDATE  tmc SET filbed=filbed+1  , endate='".$input_en_dt. "'  where id=".$input_tmc.";";
if($stmt = $pdo->prepare($sql)){
if($stmt->execute()){
$sql ="UPDATE  tmc_migrants SET exdate=adddate(endate,interval 21 day) where bcd  ='". $input_bcd."'  and exdate is null;";
if($stmt = $pdo->prepare($sql)){
if($stmt->execute()){
}
}
}
}

$_SESSION["mname"] = $input_mname;
header("location: welcome_tmc.php");
exit();
} else{
echo "Something went wrong. Please try again later.";
}
}
// Close statement
unset($stmt);
}
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <style type="text/css">
    .wrapper{
    width: 576px;
    margin: 0 auto;
    }
    </style>
    <title>Tag Migrants to TMC</title>
    
  </head>
  <body>
    <div class="wrapper">
      <div class="page-header">
        <h5 class="text-info text-center">Registration and Tagging of </h5>
        <h6  class="text-danger text-center"> Migrants to TMC </h6>
      </div>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  method="post" class="needs-validation" novalidate>
        
        <div class="form-group">
          <label for="mname">Migrants *</label>
          <input type="text" class="form-control" id="mname" placeholder="Name of Migrants *" name="mname" pattern="[a-zA-Z\-. ]*"  onblur="myFunction()"  required>
          <div class="invalid-feedback">Please fill out this field.</div>
        </div>
        <div class="form-group">
          <label for="age" class="control-label">Age</label>
          <div>
            <input type="number" name="age" id="age"  min="0" max="120" class="form-control" pattern="[0-9]*" required="required" placeholder="Age"  >
            <div class="help-block with-errors"></div>
            <div class="messages with-errors"></div>
          </div>
        </div>
        <div class="form-group">
          <label for="sex">Gender *</label>
          <select name="sex" id="sex" class="form-control" required="required" data-error="Please Select an Option">
            <option value="" selected="" disabled="">-- Select Gender --</option>
            <option value="M" >Male </option>
            <option value="F">Female</option>
            <option value="T">Transgender</option>
          </select>
          <div class="help-block with-errors"></div>
        </div>
        
        <div class="form-group">
          <label for="mobileno" class="control-label">Mobile No*</label>
          <div>
            <input type="text" name="mobileno" id="mobileno"  class="form-control" maxLength="10" pattern="[1-9]{1}[0-9]{9}" required="required" placeholder="Mobile No" data-error="10 digit Mobile No is required." >
            <div class="help-block with-errors"></div>
            <div class="messages with-errors"></div>
          </div>
        </div>
                <div class="form-group" >
          <label for="state">Select Came from State</label>
          <select name="state" id="state" class="form-control" required data-error="Please Select State" >         
          </select>
        </div>
        <div class="form-group">
          <label for="en_dt">Entry Date:</label>
          <input  id ="en_dt"  name="en_dt" type="date" data-date="" data-date-format="DD MMMM YYYY" value="2020-05-04" required >
          <div class="invalid-feedback">Please fill out this field with vadid Data</div>
        </div>
        
        <div class="form-group"  id="blkid">
          <label for="block">Select Block </label>
          <select name="block" id="block" class="form-control" required data-error="Please Select Block"  onchange="readRecord()">
            <option value="" selected="" disabled=""> -- Select TMC Block -- </option>
            <option value="2601" >BHAWANIPATNA</option>
            <option value="2602">KARLAMUNDA</option>
            <option value="2603">KESINGA</option>
            <option value="2604">LANJIGARH</option>
            <option value="2605">MADANPUR-RAMPUR</option>
            <option value="2606">NARLA</option>
            <option value="2607">THUAMUL-RAMPUR</option>
            <option value="2608">DHARAMGARH</option>
            <option value="2609">GOLAMUNDA</option>
            <option value="2610">JAIPATNA</option>
            <option value="2611">JUNAGARH</option>
            <option value="2612">KALAMPUR</option>
            <option value="2613">KOKSARA</option>
            <option value="2701" >BHAWANIPATNA-MPL</option>
			<option value="2702">JUNAGARH-NAC</option>
			<option value="2703">KESINGA-NAC</option>
			<option value="2704">DHARMAGARH-NAC</option>
          </select>
        </div>
        <div class="form-group" >
          <label for="tmc">Select TMC </label>
          <select name="tmc" id="tmc" class="form-control" required data-error="Please Select TMC" onchange="getBeds()">         
          </select>
        </div>
        <div id="bedsts"></div>
        <hr>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="regMigrants.php" class="btn btn-warning btn-outline-danger pull-right"> Cancel </a>
        <a href="logout.php" class="btn btn-danger float-right">Sign Out</a>
      </form>
           
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
    function readRecord(){
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
    function getBeds(){
    var tmc=$('#tmc').val();
    $.ajax({
    url:"getTMC.php",
    type:'POST',
    data:{tmc_cd:tmc},
    success:function(data,status){
    $('#bedsts').html(data);
    }
    });
    }
    //
    function myFunction() {
    var x = document.getElementById("mname");
    x.value = x.value.toUpperCase();
    }
//  Sate Function
    //
       $(document).ready(function(){
    var state='state';
    $.ajax({
    url:"getTMC.php",
    type:'POST',
    data:{scode:state},
    success:function(data,status){
    $('#state').html(data);
    }
    });
    });
    //

//


    </script>
  </body>
</html>