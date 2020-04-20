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

#Header and Navbar
echo '<head><h3>[Customer Checkout]</h3>'
    . $_SESSION['navbar']
    . '</head>';

#Body of the page
echo '<body>
<p>Will this be a New or Returning Customer?</p>
<input type ="button" onclick="openForm(\'newForm\')" value ="New">
<input type ="button" onclick="openForm(\'retForm\')" value ="Returning">
<input type ="button" onclick="location.href = \'sale.php\'" value ="Skip">

<div class ="form-popup" id ="newForm" style="display:none;">
    <form method="post">
        <h3>[Create New Customer]</h3>
        <input type ="text" name="fname" placeholder="First Name" required><br>
        <input type ="text" name="lname" placeholder="Last Name" required><br>
        <input type ="email" name="email" placeholder="E-mail" required><br>
        <input type ="text" name="phone" placeholder="Phone" required><br>
        <input type ="text" name="address" placeholder ="Address" required><br>
        <input type ="submit" name="create">
        <input type ="button" onclick="closeForm(\'newForm\')" value="Cancel">
    </form>
</div>

<div class ="form-popup" id="retForm" style="display:none;">
    <form>
        <h3>[Customer Lookup]</h3>
        <input type="text" placeholder="Customer Name"><br>
        <input type="text" placeholder="Customer Email"><br>
        <input type="text" placeholder="Customer Phone"><br>
        <input type="submit">
        <input type="button" onclick="closeForm(\'retForm\')" value ="Cancel">
    </form>
</div>
</body>';

#Checking if the submit button was pressed to create a customer.
if(isset($_POST['create']))
{
    $db = connect(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);
    $customerData = [
        'First_Name' => $_POST['fname'],
        'Last_Name' => $_POST['lname'],
        'Email' => $_POST['email'],
        'Phone' => $_POST['phone'],
        'Address' => $_POST['address']
    ];
    createCustomer($db, $customerData);

    echo "<br>New customer created.<br>";
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
