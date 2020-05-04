<?php
require_once 'config.php';
require_once 'db.php';
$db = connect(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);


if($_POST['type']==0){
        $val = "AvailableStock";
}
if($_POST['type']==1){
        $val = "Price";
}



$sql = "UPDATE `Inventory` SET ".$val."=".$_POST['value']." WHERE SKU=".$_POST['sku'];




if ($db->query($sql) === TRUE) {
    header("Location:inventoryManage.php?ReturnMess=Successfully Updated");
} else {
    header("Location:inventoryManage.php?ReturnMess=Error Updating, Please Try Again");
}
$db->close();





?>
