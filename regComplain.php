<?php
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
/* 
$_SESSION["loggedin"] = true;
$_SESSION["username"] ='BHAWANIPATNA';
 */

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true  || !isset($_SESSION["bcd"]) ) {
$_SESSION["pfile"] = htmlspecialchars($_SERVER["PHP_SELF"]);
header("location: login.php");
exit;
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
$input_mname = trim($_POST["mname"]);
$input_mobileno = trim($_POST["mobileno"]);
$input_bcd = trim($_POST["block"]);
$input_tmc = trim($_POST["tmc"]);
$input_comp = trim($_POST["comp"]);
$input_user = $_SESSION["username"] ;
//echo date("Y-m-d", strtotime($input_en_dt));
//exit();
if( empty($input_mname )  ||  empty($input_mobileno ) ||  empty($input_bcd ) || empty($input_tmc) || empty($input_comp) ){
// Destroy the session.
session_destroy();
header("location: verror.php");
exit();
}else{
require_once "config.php";
// Prepare an insert statement
$sql = "INSERT INTO tmc_complain(cname,mobileno,bcd,tmc,ccode,username)
VALUES (upper(:cname), :mobileno,:bcd,:tmc,:ccode,:username)";
if($stmt = $pdo->prepare($sql)){
// Bind variables to the prepared statement as parameters
$stmt->bindParam(":cname", $input_mname, PDO::PARAM_STR);
$stmt->bindParam(":mobileno", $input_mobileno, PDO::PARAM_STR);
$stmt->bindParam(":bcd", $input_bcd, PDO::PARAM_STR);
$stmt->bindParam(":tmc", $input_tmc, PDO::PARAM_STR);
$stmt->bindParam(":ccode",$input_comp , PDO::PARAM_STR);
$stmt->bindParam(":username",$input_user , PDO::PARAM_STR);

// Set parameters
// Attempt to execute the prepared statement
if($stmt->execute()){
// Records created successfully. Redirect to landing page

$_SESSION["mname"] = $input_mname;
header("location: welcome_comp.php");
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
    <title>Cmplain Registration</title>
    
  </head>
  <body>
    <div class="wrapper">
      <div class="page-header">
        <h5 class="text-primary text-center">Registration of Complain from TMC</h5>
         
      </div>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  method="post" class="needs-validation" novalidate>
        
        <div class="form-group">
          <label for="mname">Name *</label>
          <input type="text" class="form-control" id="mname" placeholder="Name of Compaintant *" name="mname" pattern="[a-zA-Z\-. ]*"  onblur="myFunction()"  required>
          <div class="invalid-feedback">Please fill out this field.</div>
        </div>
      
        <div class="form-group">
          <label for="mobileno" class="control-label">Mobile No*</label>
          <div>
            <input type="text" name="mobileno" id="mobileno"  class="form-control" maxLength="10" pattern="[1-9]{1}[0-9]{9}" required="required" placeholder="Mobile No" data-error="10 digit Mobile No is required." >
            <div class="help-block with-errors"></div>
            <div class="messages with-errors"></div>
          </div>
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
          </select>
        </div>
        <div class="form-group" >
          <label for="tmc">Select TMC </label>
          <select name="tmc" id="tmc" class="form-control" required data-error="Please Select TMC" onchange="getComType()" >
            
          </select>
        </div>
                <div class="form-group" >
          <label for="comp">Select Complain Type </label>
          <select name="comp" id="comp" class="form-control" required data-error="Please Select " >
            
          </select>
        </div>
        <hr>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="regomplain.php" class="btn btn-warning btn-outline-danger pull-right"> Cancel </a>
        
      </form>
      <br>
      <p>
        
        <a href="logout.php" class="btn btn-danger pull-right">Sign Out</a>
      </p>
      
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

         
    function getComType(){
    var bcd=$('#block').val();
    $.ajax({
    url:"getTMC.php",
    type:'POST',
    data:{ccode:bcd},
    success:function(data,status){
    $('#comp').html(data);
    }
    });
    }
     
    function myFunction() {
    var x = document.getElementById("mname");
    x.value = x.value.toUpperCase();
    }
    </script>
  </body>
</html>