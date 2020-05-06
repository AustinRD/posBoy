<?php                                                                                                                                                                   session_start();
                                                                                                                                                                        if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false){
        header("Location: login.php");
}
                                                                                                                                                                        ?>

<?php                                                                                                                                                                   require_once 'config.php';
require_once 'db.php';
                                                                                                                                                                        $db =connect(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);

$search_result = '';
$totalDaySale = 0;
$search_result2 = '';
$totalItemsSold = 0; 
$search_result3 = '';  

if(isset($_POST['search'])){
$valueToSearch=$_POST['valueToSearch'];
$search_result=mysqli_query($db, "SELECT TotalSaleAmount FROM Sale WHERE DOS LIKE '%$valueToSearch%'");
while($row = mysqli_fetch_assoc($search_result)){
$totalDaySale += $row['TotalSaleAmount'];
}
}
if(isset($_POST['search'])){
$valueToSearch=$_POST['valueToSearch'];
$search_result2=mysqli_query($db, "SELECT NumberOfItemsSold FROM Sale WHERE DOS LIKE '%$valueToSearch%'");
while($row = mysqli_fetch_assoc($search_result2)){
$totalItemsSold += $row['NumberOfItemsSold'];
}
}
if(isset($_POST['search'])){
$valueToSearch=$_POST['valueToSearch'];
$search_result3=mysqli_query($db, "SELECT * FROM Sale WHERE DOS LIKE '%$valueToSearch%'");
}
?>

<html>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
<div class="screen">

<?php
echo '<head><h3>[Z-Report]</h3>'
    . $_SESSION['navbar']
    . '</head>';
?>

<form action="zReport.php" method="post">
<input type="text" name="valueToSearch" placeholder="Enter Date (yyyy-mm-dd)"><br>
<input type="submit" name="search" value="search"><br>
<body>
<div><h4>Total Sales For Date (In Dollars):</h4><?php print $totalDaySale ?></div>
<div><h4>Total Amount Of Items Sold For Date:</h4><?php print $totalItemsSold ?></div><br><br>

<table border='2'>
<tr>
<th>TransID</th>
<th>Customer ID</th>
<th>Employee ID</th>
<th>Date Of Sale</th>
<th>Payment Type</th>
<th>Number Of Items Sold</th>
<th>Tax Amount</th>
<th>PreTax</th>
<th>Total Sale Amount</th>
<?php while($row = mysqli_fetch_array($search_result3)):?>
<tr>
<td><?php echo $row['TRANSID'];?></td>
<td><?php echo $row['Customer_ID'];?></td>
<td><?php echo $row['EmployeeID'];?></td>
<td><?php echo $row['DOS'];?></td>
<td><?php echo $row['PaymentType'];?></td>
<td><?php echo $row['NumberOfItemsSold'];?></td>
<td><?php echo $row['TaxAmount'];?></td>
<td><?php echo $row['PreTax'];?></td>                                  
<td><?php echo $row['TotalSaleAmount'];?></td>   
</tr>
<?php endwhile;?>
</table>

</html>
