<?php

/*
sadmin
Su#321
*/

session_start();
if( !isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true  || !isset($_SESSION["role"]) || $_SESSION["role"] !=='A' || !isset($_SESSION["username"]) || $_SESSION["username"] !=='sadmin' ) {


 $_SESSION["loggedin"] = false;

$_SESSION["pfile"] = "TMCStatus.php";
header("location: login.php");
exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$name = $totbed = $filbed = "";
$filbed_err = $totbed_err = "";

// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
// Get hidden input value
$id = $_POST["id"];



// Validate Capacity
$input_totbed = trim($_POST["totbed"]);
$input_filbed = trim($_POST["filbed"]);

if(empty($input_totbed)){
$totbed_err = "Please enter the Total Capacity.";
} elseif(!ctype_digit($input_totbed)){
$totbed_err = "Please enter a positive integer value.";
} else{
$totbed = $input_totbed;
}

if(empty($input_totbed)){
$filbed_err = "Please enter the Fillbed.";
} elseif(!ctype_digit($input_filbed)){
$filbed_err = "Please enter a positive integer value.";
} else{
$filbed = $input_filbed;
}

// Check input errors before inserting in database
if(  empty($filbed_err) && empty($totbed_err)  ){
// Prepare an update statement
$sql = "UPDATE tmc  SET   totbed=:totbed , filbed=:filbed  WHERE id=:id";

if($stmt = $pdo->prepare($sql)){
// Bind variables to the prepared statement as parameters

$stmt->bindParam(":totbed", $param_totbed,PDO::PARAM_INT);
$stmt->bindParam(":filbed", $param_filbed,PDO::PARAM_INT);
// $stmt->bindParam(":filbed", $param_filbed,PDO::PARAM_INT);
$stmt->bindParam(":id", $param_id,PDO::PARAM_INT);

// Set parameters
 
$param_totbed = $totbed;
$param_filbed = $filbed;
// $param_filbed = $filbed;
$param_id = $id;

// Attempt to execute the prepared statement
if($stmt->execute()){
// Records updated successfully. Redirect to landing page
header("location: TMCStatus.php");
exit();
} else{
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
if(isset($_GET["tmcd"]) && !empty(trim($_GET["tmcd"]))){
// Get URL parameter
$id =  trim($_GET["tmcd"]);

// Prepare a select statement
$sql = "SELECT * FROM tmc WHERE id = :id";
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
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Retrieve individual field value
$name = $row["tmc_name"].",<br>".$row["gp"].",<br>".$row["block"];
$totbed = $row["totbed"];
$filbed = $row["filbed"];
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
        <title>Update Record</title>
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
                            <h2>Update  Capacity</h2><br><br>
                        </div>
                         
                        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">

                             
                                <label class="font-weight-bold">TMC Name</label>
                                <p class="progress-bar bg-light text-dark text-left"  > <?php echo $name; ?> </p>
                            

                            <div class="form-group <?php echo (!empty($totbed_err)) ? 'has-error' : ''; ?>">
                                <label class="font-weight-bold">Capacity</label>
                                <input type="number" name="totbed" id="totbed" class="form-control text-primary font-weight-bold" value="<?php echo $totbed; ?>">
                                <span class="help-block"><?php echo $totbed_err;?></span>
                            </div>

                            <div class="form-group <?php echo (!empty($totbed_err)) ? 'has-error' : ''; ?>">
                                <label class="font-weight-bold">Filled:</label>
                                <input type="number" name="filbed" id="filbed" class="form-control text-danger font-weight-bold" value="<?php echo $filbed; ?>">
                                <span class="help-block"><?php echo $totbed_err;?></span>
                            </div>


                            <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <a href="TMCStatus.php" class="btn btn-warning  float-right">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>