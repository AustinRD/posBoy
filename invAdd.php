<?php

require_once('db.php');
require_once('config.php');

session_start();
$db = connect(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);

if(isset($_POST['create']))
{
    $sql = "INSERT INTO `Inventory` "; #Database name
    $sql.= "(`First_Name`, `Last_Name`, `Email`, `Phone`, `Address`) ";
    $sql.= "VALUES ";
    $sql.= "(";
    $sql.= "'".$_POST['fname']."', ";
    $sql.= "'".$_POST['lname']."', ";
    $sql.= "'".$_POST['email']."', ";
    $sql.= "'".$_POST['phone']."', ";
    $sql.= "'".$_POST['address']."'";
    $sql.= ");";

    $db->query($sql);


};
header("Location:inventoryManage.php");
?>


