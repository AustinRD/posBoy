<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false){
    header("Location: login.php");
}

require_once 'config.php';
require_once 'db.php';
$db = connect(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);


$search_result = "";
$items = "";

if(isset($_POST['searchButton'])){
$temp = "'".$_POST['search']."'";
  $search_result = mysqli_query($db, "SELECT * FROM `Sale` WHERE `TRANSID` LIKE $temp") or die('could not search');
}else{
$search_result="";
 }

if(isset($_POST['searchButton'])){
$temp = "'".$_POST['search']."'"; 
$items = mysqli_query($db, "SELECT * FROM `SalesData` WHERE `TRANSID` LIKE $temp") or die('could not search');
}else{
$items="";
}



?>


<html>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<div class = "screen">
<h3>[Search Transactions]</h3>
  <?php

  echo $_SESSION["navbar"];


  ?>
<body>



  <form action="transQuery.php" method="post">
        <br>
        <input type="text" name="search" placeholder="Transaction ID"/>
        <br>
        <input type="submit" value="search" name="searchButton"/>
        <br><br>

        <?php
        if($search_result != ""):
	$row = mysqli_fetch_array($search_result)?>

<?php echo "Transaction Number: ".$row['TRANSID'];  ?>
<br>

        <?php echo "Customer: ".$row['Customer_ID'];?>
<br>
        <?php echo "Employee: ".$row['EmployeeID'];?>
<br>
        <?php echo "Date of Sale: ".$row['DOS'];?>
<br>
        <?php echo "Payment Type: ".$row['PaymentType'];?>
<br>        
	<?php while($newRow = mysqli_fetch_array($items)): ?>
        <?php
	$tempNum = $newRow['SKU'];
	$itemstemp = mysqli_query($db, "SELECT * FROM `Inventory` WHERE `SKU` LIKE $tempNum");
        $items_temp = mysqli_fetch_array($itemstemp);
	echo $tempNum."    ".$items_temp['ProductName']."    $".$items_temp['Price'];
	?>
	<br>
      <?php endwhile; ?>
        <?php echo "Subtotal: $".$row['PreTax'];?>
<br>
        <?php echo "Tax: $".$row['TaxAmount'];?>
<br>
        <?php echo "Total: $".$row['TotalSaleAmount'];?>
        <?php
        endif;
        ?>
        </table>

</body>
</div>
</html>

