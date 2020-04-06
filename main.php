<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false){
    header("Location: login.php");
}

?>


<html>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<div class = "screen">
    <h3>
    <?php
       echo "Welcome, Employee #" . $_SESSION["userid"];
    ?>
    </h3>
    <p>Successfully Logged In</p>

    <body>
        <nav>
            <a href="main.php">Home</a> |
            <a href="inventory.php">Inventory</a> |
            <a href="sales.php">Sales<a> |
            <a href="customerSearch.php">Customer Search<a> |
            <a href="EmployeeSearch.php">Employee Search<a> |
            <a href="checkout.php">Checkout</a>
        </nav>
        <br>
        <input type="button" onclick=startClock  value="Clock-In">
        <input type="button" onclcik=endClock value="Clock-Out">
        <input type="button" onclick="location.href = 'logout.php'" value="Logout">
    </body>
</div>
</html>