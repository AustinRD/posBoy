<html>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<div class="screen">

<?php
require_once 'config.php';
require_once 'db.php';

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false){
    header("Location: login.php");
}

echo '<head><h3>[Checkout - Payment]</h3></head>';

echo '<body>
<p>Please select a payment type:</p>

<form method="post">
    <input type ="button" onclick="openForm(\'cash\')" value ="Cash">
    <input type ="button" onclick="openForm(\'credit\')" value ="Credit">
    <input type ="button" onclick="openForm(\'debit\')" value ="Debit">
    <input type ="submit" name="cancel" value ="Cancel">
</form>

<div class ="form-popup" id ="cash" style="display:none;">
    <form method="post">
        <h3>[Cash]</h3>
	<p>Amount due:</p>
        <input type ="text" placeholder="Cash Tendered"><br>
	<input type ="button" onclick="closeForm(\'cash\')" value="Cancel">
    </form>
</div>

<div class ="form-popup" id="credit" style="display:none;">
    <form method="post">
        <h3>[Credit]</h3>
	<p>Amount Due:</p>
	<input type="password" placeholder="Card Number" required><br>
	<input type="text" placeholder="Expiration" required><br>
        <input type="password" placeholder="CRN" required><br>
        <input type="text" placeholder="Name" required><br>
        <input type="button" onclick="closeForm(\'credit\')" value ="Cancel">
    </form>
</div>

<div class ="form-popup" id="debit" style="display:none;">                                                                <form method="post">
        <h3>[Debit]</h3>
        <p>Amount Due:</p>
        <input type="password" placeholder="Card Number" required><br>
	<input type="password" placeholder="Pin" required><br>
	<input type="text" placeholder="Expiration" required><br>
	<input type="password" placeholder="CRN" required><br>
	<input type="text" placeholder="Name" required><br>
        <input type="button" onclick="closeForm(\'debit\')" value ="Cancel">
    </form>
</div>
</body>';
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
