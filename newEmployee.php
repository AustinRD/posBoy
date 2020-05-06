<?php
require_once 'config.php';
require_once 'db.php';
$db = connect(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);

$fname="'".$_POST['fname']."'"
$lname="'".$_POST['lname']."'"
$addr="'".$_POST['addr']."'"
$phone="'".$_POST['phone']."'"
$pass="'".$_POST['pass']."'"
$bank="'".$_POST['bank']."'"
$permis="'".$_POST['permis']."'"
$sql = "INSERT INTO EmployeeDatabase (Address, BankAccountNum, FirstName, LastName, PermissionType, PhoneNumber, PlaintextPass, RoutingNum)
VALUES ($addr, $bank, $fname, $lname, $permis, $phone, $pass, $bank)";



if ($db->query($sql) === TRUE) {
    header("Location:employeeManage.php?ReturnMess=Successfully Created");
} else {
    header("Location:employee.php?ReturnMess=Error Creating, Please Try Again");
}
$db->close();





?>

