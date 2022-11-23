<?php
session_start();
if( !isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true  ) {
$_SESSION["loggedin"] = false;
$_SESSION["pfile"] = htmlspecialchars($_SERVER["PHP_SELF"]);
header("location: login.php");
exit;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>All Migrants</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    
  </head>
  <body>
    <h1 class="text-primary text-center">All Migrant Page Wise List </h1>
    <div class="container">
      <p>
        <a href="/tmc" class="btn btn-info "> Back  </a>
        <a href="logout.php" class="btn btn-danger float-right">Sign Out</a>
      </p>
    </div>
    <div class="container-fluid">
      <?php
      // connect to database
      require "../conn.php";
      // define how many results you want per page
      $results_per_page = 100;
      $dpage = 10;
      // find out the number of results stored in database
      $sql = "SELECT    count(id)  from tmc_migrants;";
      $result = mysqli_query($conn, $sql);
      if(! $result ) {
      die('Could not get data: ' . mysqli_error($conn));
      }
      $row = mysqli_fetch_array($result, MYSQLI_NUM );
      $number_of_results = $row[0];
      //$number_of_results = mysqli_num_rows($result);
      // determine number of total pages available
      $number_of_pages = ceil($number_of_results/$results_per_page);
      // determine which page number visitor is currently on
      if (!isset($_GET['page'])) {
      $page = 1;
      } else {
      $page = (int)$_GET['page'];
      }
      $cpage=$page;
      
      if(($cpage - $dpage) <= 1){
      $spg=1;
      }else{
      $spg= ($cpage - $dpage);
      }
      if(($cpage + $dpage) >= $number_of_pages){
      $epg= $number_of_pages;
      }else{
      $epg= ($cpage + $dpage);
      }
      // determine the sql LIMIT starting number for the results on the displaying page
      $this_page_first_result = ($page-1)*$results_per_page;
      // retrieve selected results from database and display them on page
      $sql ="select  tmc_migrants.id ,tmc_migrants.tmc_cd , tmc_migrants.mname,tmc_migrants.age, tmc_migrants.sex,tmc_migrants.mobileno, tmc_state.sname,DATE_FORMAT(tmc_migrants.endate,'%d-%m-%Y') as endate   ,DATE_FORMAT(tmc_migrants.exdate,'%d-%m-%Y') as exdate , tmc.block,tmc.gp,tmc.tmc_name ,DATEDIFF(exdate,current_date()) as days
      from    tmc_migrants, tmc,tmc_state
      where  tmc_migrants.tmc_cd = tmc.id and tmc_migrants.scode=tmc_state.scode   order by tmc_migrants.id
      LIMIT  ". $this_page_first_result." , ". $results_per_page." ;";
      // $sql='SELECT * FROM alphabet LIMIT ' . $this_page_first_result . ',' .  $results_per_page;
      $slno=$this_page_first_result;
      $result = mysqli_query($conn, $sql);
      //
      $filename= htmlspecialchars($_SERVER["PHP_SELF"]);
      PagesDispaly($spg,$epg,$cpage, $number_of_pages, $filename);
      //
      $data= "";
      $data .= "<table class='table table-bordered table-striped'>
        <thead class='text-primary' >
          <tr>
            <th># </th>
            <th>Entry Date</th>
            <th>Name</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Mobile No</th>
            <th>Came From</th>
            <th>TMC Address</th>
            <th>Exit Date</th>
            
          </tr>
        </thead>";
        
        
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $slno=$slno+1;
        $data .= "<tr><td>" . $slno ."</td>";
        $data .= "<td>" . $row['endate']."</td>";
        $data .= "<td>" . $row['mname'] . "</td>";
        $data .= "<td>" . $row['age'] . "</td>";
        $data .= "<td>" . $row['sex'] . "</td>";
        $data .= "<td>" . $row['mobileno'] . "</td>";
        $data .= "<td>" . $row['sname'] . "</td>";
        $data .= "<td>" . $row['tmc_name'] . ",<br>".$row['gp'] .", ".$row['block']."</td>";
        //
        if((int)$row['days'] <= 0){
        $data .= "<td class='font-weight-bold text-success'>" .$row['exdate']."</td>";
        }else{
        if((int)$row['days'] == 1){
        $data .= "<td class='font-weight-bold text-info'>" .$row['exdate']."</td>";
        }else{
        $data .= "<td>" .$row['exdate']."</td>";
        }
        }
        //
        
      $data .= "</tr>";
      echo $data;
      $data="";
      }
    echo "</table> </div> <div class='container'>";
    // display the links to the pages
    $active="";
    echo '<ul class="pagination float-none">';
      if ( $spg > 1 ) {
      echo '<li class="page-item   '.$active.'"><a class="page-link" href="'.htmlspecialchars($_SERVER["PHP_SELF"]).'?page=1' . "" . '"> First Page</a></li>';
      }
      for ($page= $spg;$page<=$epg;$page++) {
        if($cpage == $page){
          $active="active";
        }else{
          $active="";
        }
      echo '<li class="page-item   '.$active.'"><a class="page-link" href="'.htmlspecialchars($_SERVER["PHP_SELF"]).'?page=' . $page . '">' . $page . '</a></li>';
      
      }
      if ( $epg < $number_of_pages) {
      echo '<li class="page-item   '.$active.'"><a class="page-link" href="'.htmlspecialchars($_SERVER["PHP_SELF"]).'?page=' . $number_of_pages . '"> Last Page</a></li>';
      }
    echo '</ul>';
    //----------------------- Function  for Pages number Dispalyed ----------------
    function PagesDispaly($spg,$epg,$cpage, $number_of_pages, $filename){
    $active="";
    echo "<div class='container float-right'>";
      echo '<ul class="pagination">';
        if ( $spg > 1 ) {
        echo '<li class="page-item   '.$active.'"><a class="page-link" href="'.$filename.'?page=1' . "" . '"> First Page</a></li>';
        }
        for ($page= $spg;$page<=$epg;$page++) {
          if($cpage == $page){
            $active="active";
          }else{
            $active="";
          }
        echo '<li class="page-item   '.$active.'"><a class="page-link" href="'.$filename.'?page=' . $page . '">' . $page . '</a></li>';
        }
        if ( $epg < $number_of_pages) {
        echo '<li class="page-item   '.$active.'"><a class="page-link" href="'.$filename.'?page=' . $number_of_pages . '"> Last Page</a></li>';
        }
      echo '</ul>';
    echo "</div>";
    }
    //----------------------------- End of Function  ----------------------------
    ?>
  </div>
</body>
</html>