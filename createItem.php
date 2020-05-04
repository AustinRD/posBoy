<?php
require_once 'config.php';
require_once 'db.php';
$db = connect(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);


$stock="'".$_POST['stock']."'";
$price="'".$_POST['price']."'";
$name="'".$_POST['name']."'";
$sku="'".$_POST['sku']."'";
$upc="'".$_POST['upc']."'";
$sql = "INSERT INTO Inventory (AvailableStock, Price, ProductName, SKU, Stock, UPC)
VALUES ($stock, $price, $name, $sku, $stock, $upc)";


if ($db->query($sql) === TRUE) {
    header("Location:inventoryManage.php?ReturnMess=Successfully Created");
} else {
    header("Location:inventoryManage.php?ReturnMess=Error Creating, Please Try Again");
}
$db->close();





?>

