<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false){
    header("Location: login.php");
}

if($_SESSION['permission'] != (4 || 2)){
	header("Location: inventory.php");
}

?>


<html>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<div class = "screen">
    <h3>
        [Inventory Management System]
    </h3>

        <body>
        <nav>
            <a href="main.php">Home</a> |
            <a href="inventory.php">Inventory</a> |
            <a href="sales.php">Sales<a> |
            <a href="customerSearch.php">Customer Search<a> |
            <a href="EmployeeSearch.php">Employee Search<a> |
            <a href="checkout.php">Checkout</a>
        </nav>
    </body>


</div>
</html>

