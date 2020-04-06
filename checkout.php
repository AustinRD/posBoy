<?php
require_once 'config.php';
require_once 'db.php';

session_start();

$db = connect(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false){
    header("Location: login.php");
}

?>


<html>
<link rel = "stylesheet" type = "text/css" href = "mystyle.css">
<div class="screen">
<head>
    <h3>[Customer Checkout]</h3>
    <nav>
        <a href="main.php">Home</a> |
        <a href="inventory.php">Inventory</a> |
        <a href="sales.php">Sales<a> |
        <a href="customerSearch.php">Customer Search<a> |
        <a href="EmployeeSearch.php">Employee Search<a> |
        <a href="checkout.php">Checkout</a>
    </nav>
</head>

<body>
<p>Will this be a New or Returning Customer?</p>
<input type ="button" onclick="openForm('newForm')" value ="New">
<input type ="button" onclick="openForm('retForm')" value ="Returning">
<input type ="button" onclick="location.href = 'sale.php'" value ="Skip">

<div class ="form-popup" id ="newForm" style="display:none;">
    <form method="post" action="createCustomer.php" >
        <h3>[Create New Customer]</h3>
        <input type ="text" name="fname" placeholder="First Name" required><br>
        <input type ="text" name="lname" placeholder="Last Name" required><br>
        <input type ="email" name="email" placeholder="E-mail" required><br>
        <input type ="text" name="phone" placeholder="Phone" required><br>
        <input type ="text" name="address" placeholder ="Address" required><br>
        <input type ="submit" name="create">
        <input type ="button" onclick="closeForm('newForm')" value="Cancel">
    </form>
</div>

<div class ="form-popup" id="retForm" style="display:none;">
    <form>
        <h3>[Customer Lookup]</h3>
        <input type="text" placeholder="Customer Name"><br>
        <input type="text" placeholder="Customer Address"><br>
        <input type="submit">
        <input type="button" onclick="closeForm('retForm')" value ="Cancel">
    </form>
</div>

</body>

</div>

</html>

<script>
function openForm(formName)
{
    document.getElementById(formName).style.display = "block";
}
function closeForm(formName)
{
    document.getElementById(formName).style.display = "none";
}

</script>