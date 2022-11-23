<?php
session_start();

 if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true  || !isset($_SESSION["bcd"]) ) {
$_SESSION["pfile"] = "MigrantBlock.php";
header("location: login.php");
exit;
}
// Process delete operation after confirmation
if(isset($_POST["id"]) && !empty($_POST["id"]) && isset($_POST["tmc_cd"]) && !empty($_POST["tmc_cd"])){
// Include config file
require_once "config.php";
// Prepare a delete statement
$sql = "UPDATE tmc_migrants SET sts='E', udate=CURRENT_DATE(), userby=:userby  WHERE id = :id  and tmc_cd = :tmc_cd";
if($stmt = $pdo->prepare($sql)){
// Bind variables to the prepared statement as parameters
$stmt->bindParam(":id", $param_id,PDO::PARAM_INT);
$stmt->bindParam(":tmc_cd", $param_tmc,PDO::PARAM_INT);
$stmt->bindParam(":userby", $param_user,PDO::PARAM_STR);
// Set parameters
$param_id = trim($_POST["id"]);
$param_tmc = trim($_POST["tmc_cd"]);
$param_user = trim($_POST["user"]);
// Attempt to execute the prepared statement
if($stmt->execute()){
// Records deleted successfully. Redirect to landing page
$sql ="UPDATE  tmc SET filbed=filbed-1   where id=".$param_tmc.";";
if($stmt = $pdo->prepare($sql)){
if($stmt->execute()){
}
}

 if($_SESSION["role"] === 'U' || $_SESSION["role"] ==='R'){
   header("location: MigrantExitBlk.php");
   exit();
 }else{
   header("location: MigrantExit.php");
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
} else{
// Check existence of id parameter
if(empty(trim($_GET["mcode"])) || empty(trim($_GET["tmc_cd"]))    ){
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
        <title>View Record</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
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
                            <h1>Delete Record</h1>
                        </div>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="alert alert-danger fade in">
                                <input type="hidden" name="id"  id="id" value="<?php echo trim($_GET["mcode"]); ?>"/>
                                <input type="hidden" name="tmc_cd" id="tmc_cd" value="<?php echo trim($_GET["tmc_cd"]); ?>"/>
                                <input type="hidden" name="user" id="user"value="<?php echo trim($_GET["user"]); ?>"/>
                                <p>Are you sure you want to Update this record.<br> Exit to Home or Shifted from TMC ?</p><br>
                                <p>
                                    <input type="submit" value="Yes" class="btn btn-danger">
                                    <a href="MigrantExit.php" class="btn btn-default">No</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>