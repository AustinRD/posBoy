<?php
session_start();
date_default_timezone_set("America/New_York");

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false){
    header("Location: login.php");
}

require_once 'config.php';
require_once 'db.php';
$db = connect(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);


$search_result = "";
$date = "'".date("Y-m")."%'";
#echo "SELECT * FROM `TimesheetData` WHERE `date` LIKE $date AND `employeeID` LIKE INPUT";

if(isset($_POST['searchButton'])){
  $temp = "'".$_POST['search']."'";
  $search_result = mysqli_query($db, "SELECT * FROM `TimesheetData` WHERE `date` LIKE $date AND `employeeID` LIKE $temp") or die('could not search');
}else{
$search_result="";
  }




?>


<html>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<div class = "screen">
<h3>[Search Timesheets]</h3>
  <?php

  echo $_SESSION["navbar"];


  ?>
<body>



  <form action="timeSheetSearch.php" method="post">
        <br>
        <input type="text" name="search" placeholder="Employee ID"/>
        <br>
        <input type="submit" value="search" name="searchButton"/>




        <table border='1'>
        <tr>
        <th>Employee ID</th>
        <th>Action Type</th>
        <th>Date</th>
        <th>Time</th>
        </tr>
        <?php 
	if($search_result != ""):
	while($row = mysqli_fetch_array($search_result)):?>
        <tr>
        <td><?php echo $row['employeeID'];?></td>
        <td><?php echo $row['actionType'];?></td>
        <td><?php echo $row['date'];?></td>
        <td><?php echo $row['time'];?></td>
        </tr>
        <?php endwhile;
	endif;
	?>
        </table>

</body>
</div>
</html>

