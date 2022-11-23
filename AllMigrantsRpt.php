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
        <h1 class="text-primary text-center">All Migrant List </h1>
        <div class="container">
            <p>
                <a href="/tmc" class="btn btn-info "> Back  </a>
                <a href="logout.php" class="btn btn-danger float-right">Sign Out</a>
            </p>
        </div>
        <div class="container-fluid">
            <!--                                            -->
            <?php
            
            require "../conn.php";
            
            $rec_limit = 50;
            
            
            if(! $conn ) {
            die('Could not connect: ' . mysqli_error($conn));
            }
            
            
            /* Get total number of records */
            $sql = "SELECT    count(id)  from tmc_migrants;";
            $retval = mysqli_query($conn ,$sql);
            
            if(! $retval ) {
            die('Could not get data: ' . mysqli_error($conn));
            }
            $row = mysqli_fetch_array($retval, MYSQLI_NUM );
            $rec_count = $row[0];
            
            if( isset($_GET['page'] ) ) {
            $page = (int)$_GET['page'] + 1;
            $offset = $rec_limit * $page ;
            }else {
            $page = 0;
            $offset = 0;
            
            }
            
            $left_rec = $rec_count - ($page * $rec_limit);
            //
            $sql ="select  tmc_migrants.id ,tmc_migrants.tmc_cd , tmc_migrants.mname,tmc_migrants.age, tmc_migrants.sex,tmc_migrants.mobileno, tmc_state.sname,DATE_FORMAT(tmc_migrants.endate,'%d-%m-%Y') as endate   ,DATE_FORMAT(tmc_migrants.exdate,'%d-%m-%Y') as exdate , tmc.block,tmc.gp,tmc.tmc_name
            from    tmc_migrants, tmc,tmc_state
            where  tmc_migrants.tmc_cd = tmc.id and tmc_migrants.scode=tmc_state.scode   order by tmc.block, tmc_migrants.id
            LIMIT  ". $offset." , ". $rec_limit." ;";
            
            $retval = mysqli_query( $conn ,$sql);
            
            if(! $retval ) {
            die('Could not get data: ' . mysqli_error($conn));
            }
            $data="";
            $slno=$offset;
            echo  "<table class='table table-bordered table-striped'>
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
                while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
                $slno=$slno+1;
                $data .= "<tr><td>" . $slno ."</td>";
                $data .= "<td>" . $row['endate']."</td>";
                $data .= "<td>" . $row['mname'] . "</td>";
                $data .= "<td>" . $row['age'] . "</td>";
                $data .= "<td>" . $row['sex'] . "</td>";
                $data .= "<td>" . $row['mobileno'] . "</td>";
                $data .= "<td>" . $row['sname'] . "</td>";
                $data .= "<td>" . $row['tmc_name'] . ",<br>".$row['gp'] .", ".$row['block']."</td>";
                $data .= "<td>" .$row['exdate']."</td>";
                
            $data .= "</tr>";
            echo $data;
            $data="";
            }
            $_SESSION["slno"]=$slno;
        echo "</table> </div> <div class='container'>";
       /*
        if( $page > 0 ) {

      
           $last = $page - 2;
           echo "<a class='btn btn-info float-left' href = '".htmlspecialchars($_SERVER["PHP_SELF"])."?page=$last'>Previous $rec_limit Records</a>$left_rec ";
           echo "<a class='btn btn-info float-right' href ='".htmlspecialchars($_SERVER["PHP_SELF"])."?page=$page'>Next $rec_limit Records</a> $left_rec";

        }else if( $page == 0 ) {
        echo "<a class='btn btn-info float-right'  href = '". htmlspecialchars($_SERVER["PHP_SELF"]) ."?page=$page' >Next $rec_limit Records</a> $left_rec";
        }else if( $left_rec < $rec_limit ) {
        $last = $page - 2;
        echo "<a class='btn btn-info float-left' href ='".htmlspecialchars($_SERVER["PHP_SELF"])."?page=$last' >Last $left_rec Records</a> $left_rec";
        }
      */
        if( $page > 0  && $left_rec > $rec_limit ) {
           $last = $page - 2;
           
           if(($left_rec - $rec_limit) < $rec_limit ){
           echo "<a class='btn btn-info float-left' href = '".htmlspecialchars($_SERVER["PHP_SELF"])."?page=$last'>Previous $rec_limit Records</a>";
           echo "<a class='btn btn-info float-right' href ='".htmlspecialchars($_SERVER["PHP_SELF"])."?page=$page'>Last ". ($left_rec - $rec_limit)."  Record(s)</a> ";
           }else{

           echo "<a class='btn btn-info float-left' href = '".htmlspecialchars($_SERVER["PHP_SELF"])."?page=$last'>Previous $rec_limit Records</a> ";
           echo "<a class='btn btn-info float-right' href ='".htmlspecialchars($_SERVER["PHP_SELF"])."?page=$page'>Next $rec_limit Records</a> ";

           }
        }

       if( $page == 0 ) {
        if( ($left_rec - $rec_limit) > 0 ){
          if(($left_rec - $rec_limit) < $rec_limit ){  
          echo "<a class='btn btn-info float-right' href ='".htmlspecialchars($_SERVER["PHP_SELF"])."?page=$page'>Last ". ($left_rec - $rec_limit)."  Record(s)</a> ";
          }else{
             echo "<a class='btn btn-info float-right'  href = '". htmlspecialchars($_SERVER["PHP_SELF"]) ."?page=$page' >Next $rec_limit Records</a> ";
          }
        }
        }

        if( $left_rec < $rec_limit  && $page > 0 ) {
           
          $last = $page - 2;
          echo "<a class='btn btn-info float-left' href ='".htmlspecialchars($_SERVER["PHP_SELF"])."?page=$last' >Previous $rec_limit Records</a> ";
         
       }
        mysqli_close($conn);
        ?>
    </div>
    <!--                                            -->
</body>
</html>