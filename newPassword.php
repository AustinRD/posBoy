<?php
require_once 'config.php';
require_once 'db.php';
$db = connect(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);



$sql = "UPDATE `EmployeeDatabase` SET ".$val."=".$_POST['value']." WHERE EmployeeID=".$_POST['employeeID'];




if ($db->query($sql) === TRUE) {
    header("Location:employeeManage.php?ReturnMess=Successfully Updated");
} else {
    header("Location:employeeManage.php?ReturnMess=Error Updating, Please Try Again");
}
$db->close();





?>

