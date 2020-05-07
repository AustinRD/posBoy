<?php
require_once 'config.php';
require_once 'db.php';
$db = connect(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);


$tempPass = "'".$_POST['value']."'";
$employeeID = $_POST['employeeID'];
$sql = "UPDATE `EmployeeDatabase` SET `PlaintextPass`=$tempPass WHERE EmployeeID=$employeeID";




if ($db->query($sql) === TRUE) {
    header("Location:employeeManage.php?ReturnMess=Successfully Updated");
} else {
    header("Location:employeeManage.php?ReturnMess=Error Updating, Please Try Again");
}
$db->close();





?>

