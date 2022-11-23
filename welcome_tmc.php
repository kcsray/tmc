<?php
// Initialize the session
session_start();
 if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true  || !isset($_SESSION["bcd"]) ) {
$_SESSION["pfile"] = "regMigrants.php";
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
        <h1>The Migrant: <b><?php echo htmlspecialchars($_SESSION["mname"]); ?></b> has been Added</h1>
    </div>
    <p>
        <a href="regMigrants.php" class="btn btn-warning">Add More Migrants </a>
         <a href="/tmc" class="btn btn-info">Back to main </a>
         <a href="logout.php" class="btn btn-danger float-right">Sign Out</a>
    </p>
</body>
</html>