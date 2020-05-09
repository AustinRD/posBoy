<html>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<div class="screen">

<?php
require_once 'config.php';
require_once 'db.php';

session_start();

date_default_timezone_set("America/New_York");

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false){
    header("Location: login.php");
}

echo '<head><h3>[Checkout - Payment]</h3></head>';

$receiptData = $_SESSION['receipt'];

echo '<body>
<p>Please select a payment type:</p>

<form method="post">
    <input type="button" onclick="openForm(\'cash\')" value ="Cash">
    <input type="button" onclick="openForm(\'credit\')" value ="Credit">
    <input type="button" onclick="openForm(\'debit\')" value ="Debit">
    <input type="submit" name="cancel" value ="Cancel">
</form>

<div class ="form-popup" id ="cash" style="display:none;">
    <form method="post">
        <h3>[Cash]</h3>
	<p>Amount due: ' . $receiptData['Total'] . '</p>
        <input type="text" name="cashAmt" placeholder="Cash Amount"><br>
	<input type="submit" name="finalize" value="Finalize">
	<input type="button" onclick="closeForm(\'cash\')" value="Cancel">
    </form>
</div>

<div class ="form-popup" id="credit" style="display:none;">
    <form method="post">
        <h3>[Credit]</h3>
	<p>Amount Due: ' . $receiptData['Total'] . '</p>
	<input type="password" placeholder="Card Number" required><br>
	<input type="text" placeholder="Expiration" required><br>
        <input type="password" placeholder="CRN" required><br>
        <input type="text" placeholder="Name" required><br>
	<input type="hidden" name="cardType" value="credit">
	<input type="submit" name="process" value="Process">
        <input type="button" onclick="closeForm(\'credit\')" value ="Cancel">
    </form>
</div>

<div class ="form-popup" id="debit" style="display:none;">                                                                <form method="post">
        <h3>[Debit]</h3>
        <p>Amount Due: ' . $receiptData['Total'] . '</p>
        <input type="password" placeholder="Card Number" required><br>
	<input type="password" placeholder="Pin" required><br>
	<input type="text" placeholder="Expiration" required><br>
	<input type="password" placeholder="CRN" required><br>
	<input type="text" placeholder="Name" required><br>
	<input type="hidden" name="cardType" value="debit">
	<input type="submit" name="process" value="Process"> 
        <input type="button" onclick="closeForm(\'debit\')" value ="Cancel">
    </form>
</div>
</body>';

if(isset($_POST['cancel']))
{
    header("Location: checkout.php");
}
if(isset($_POST['finalize']))
{
    if(floatval($_POST['cashAmt']) < floatval(str_replace("$", "", $receiptData['Total'])))
    {
	echo "Cash given is less than amount due.";
    }
    else
    {
	$customerData = $_SESSION['customer'];
	$changeDue = floatval($_POST['cashAmt']) - floatval(str_replace("$", "", $receiptData['Total']));
	$_SESSION['receipt'] += array('PaymentType' => 'cash');
	$_SESSION['receipt'] += array('ChangeDue' => $changeDue);
	$_SESSION['receipt'] += array('CustomerID' => $customerData['Customer_ID']);
	$_SESSION['receipt'] += array('EmployeeID' => $_SESSION['userid']);
	$_SESSION['receipt'] += array('DOS' => date("Y-m-d"));	
	print_r(array_keys($_SESSION['receipt']));
	
	#createReceipt($db, $_SESSION['receipt']);
        #header("Location: receipt.php");
    }
}
if(isset($_POST['process']))
{
    if($_POST['cardType'] == 'credit')
    {
	
    }
    else
    {

    }
}
?>
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
