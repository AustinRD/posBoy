<?php
require_once 'config.php';
require_once 'db.php';

session_start();

$db = connect(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);

$search_result = "";
$items = "";

$receiptData = $_SESSION['receipt'];


$temp = "'".$receiptData['TransID']."'";
$search_result = mysqli_query($db, "SELECT * FROM `Sale` WHERE `TRANSID` LIKE $temp");

$temp = "'".$receiptData['TransID']."'";
$items = mysqli_query($db, "SELECT * FROM `SalesData` WHERE `TRANSID` LIKE $temp");

?>

<html>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<div class = "screen">

<body>

  <form action="receipt.php" method="post">
        <?php
        if($search_result != ""):
        $row = mysqli_fetch_array($search_result)?>

        <?php echo "Customer: ".$row['Customer_ID'];?>
<br>
        <?php echo "Employee: ".$row['EmployeeID'];?>
<br>
        <?php echo "Date of Sale: ".$row['DOS'];?>
<br>
        <?php echo "Payment Type: ".$row['PaymentType'];?>
<br>
        <?php while($newRow = mysqli_fetch_array($items)): ?>
        <?php echo $newRow['SKU'];

        $items_temp = mysqli_query($db, "SELECT * FROM `Inventory` WHERE `SKU` LIKE '" . $newRow["SKU"] . "'");
        echo " ".$items_temp['ProductName']."    ".$items_temp['Price'];

        ?>
        <br>
      <?php endwhile; ?>
        <?php echo "Subtotal: ".$row['PreTax'];?>
<br>
        <?php echo "Tax: ".$row['TaxAmount'];?>
<br>
	<?php echo "Total: ".$row['TotalSaleAmount'];?>
<br>
	<?php if($row['PaymentType'] == "cash") {
	    echo "Change Due: ".$receiptData['ChangeDue'];
	    }?>

        <?php
        endif;
        ?>
        </table>

</body>
</div>
</html>





#To Austin: Should just need $_POST['TRANSID'] to be the transaction ID. Make sure this runs after the data has been
#Inserted into the sales and salesData tables
