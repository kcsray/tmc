<?php
session_start();
$username ="";
if (isset($_SESSION["username"])){
$username = $_SESSION["username"] ;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Migrants Add update and View  </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style type="text/css">
    body{ font: 14px sans-serif; text-align: center; },
    .bg-purple-light {
    background-color: #f2ccff !important;
    }  
    .bg-info-light {
    background-color: #b3ffff !important;
    }
    </style>
  </head>
  <body>
    <nav class="navbar  navbar-expand-sm bg-info navbar-dark text-white font-weight-bold " >
      <!-- Brand -->
      <span class="navbar-brand text-warning" >TMC</span>
      <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarMenu">
      <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse"   id="navbarMenu">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white " href="#" id="navbardrop" data-toggle="dropdown">
              Admin Section
            </a>
            <div class="dropdown-menu bg-info-light ">
              <a class="dropdown-item" href="login.php">Login</a>
              <a class="dropdown-item" href="logout.php">Logout</a>
            </div>
          </li>
        </ul>
        <!-- Links -->
        <ul class="navbar-nav mr-auto">
          <!-- Dropdown -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white " href="#" id="navbardrop" data-toggle="dropdown">
              Entry Update
            </a>
            <div class="dropdown-menu bg-info-light ">
              <a class="dropdown-item" href="regMigrants.php">Add Migrant Dist Level </a>
              <a class="dropdown-item" href="regMigrantsBlk.php">Add Migrant -Block User </a>
              <a class="dropdown-item" href="MigrantBlock.php">Edit/Delete - Block wise</a>
              <a class="dropdown-item" href="MigrantBlock2tmc.php">Edit/Delete  - TMC wise</a>
              <a class="dropdown-item" href="MigrantExit.php" >Update Migrants Status - Exit from TMC </a>
              <a class="dropdown-item" href="TMCStatus.php">Edit TMC Capacity             </a>
            </div>
          </li>
          <!-- Dropdown -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white " href="#" id="navbardrop" data-toggle="dropdown">
              Report
            </a>
            <div class="dropdown-menu bg-info-light ">
              <a class="dropdown-item" href="MigrantsAbst.php">View Abastract Migrants</a>
              <a class="dropdown-item" href="MigrantsList.php">Block Wise Migrants List</a>
              <a class="dropdown-item" href="AllMigrantsPage.php">All Migrants Page wise</a>
              <a class="dropdown-item" href="AllMigrantsRpt.php">All Migrants Record wise</a>
              <a class="dropdown-item" href="MigrantsOnDate.php">Migrants Entry on a Date</a>
              <a class="dropdown-item" href="MigrantsAbstExit.php" > View Exit Migrants From TMC</a>
              <a class="dropdown-item" href="TMCStatus.php">TMC Status</a>
            </div>
          </li>
        </ul>
      </div>
      <ul class="navbar-nav ml-auto  ">
        <li class="nav-item  ">
          <span class="nav-link text-white ">User : </span>
        </li>
        <li class="nav-item  ">
          <span class="nav-link text-warning "><?php echo $username ?></span>
        </li>
        <li class="nav-item  ">
          <a class="nav-link text-white " href="/">Home</a>
        </li>
      </ul>
    </nav>
    <br>
    <div class="page-header">
      <h3 class="text-success"> Add Migrants and View TMC Status  </h3>
    </div>
    <p><a href="login.php" class="btn btn-warning " role="button">Login </a>
    <a href="logout.php" class="btn btn-danger " role="button">Logout</a>
  </p>
  <hr>
  <p>
    <a href="MigrantsAbst.php" class="btn btn-primary">View Migrants</a>
    <a href="MigrantsOnDate.php" class="btn btn-info">View Migrants<br> on a Date</a>
    <a href="AllMigrantsPage.php" class="btn btn-success">Page wise View <br> of All Migrants</a>
    <a href="MigrantsAbstExit.php" class="btn btn-primary"> View Exit Migrants <br>From TMC</a>
    <a href="TMCStatus.php" class="btn btn-warning">TMC Status</a>
  </p>
  <p>
    <!--   <a href="regMigrants.php" class="btn btn-info">Add Migrants </a>  -->
    <a href="regMigrantsBlk.php" class="btn btn-success">Add Migrants<br>at Block User</a>
    <a href="MigrantBlock2tmc.php" class="btn btn-primary">Update/Edit <br>Migrants</a>
    <a href="MigrantExit.php" class="btn btn-warning">Update Migrants Status<br>Exit from TMC </a>
    
  </p>
  <hr>
  <p>
    <a href="/" class="btn btn-secondary">Back </a>
    
  </p>
  
  <!--      ----------------    -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>