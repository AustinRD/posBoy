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

<form method="post">
    <input type ="button" onclick="openForm(\'newForm\')" value ="New">
    <input type ="button" onclick="openForm(\'retForm\')" value ="Returning">
    <input type ="submit" name="skip" value ="Skip">
</form>

<div class ="form-popup" id ="newForm" style="display:none;">
    <form method="post">
        <h3>[Create New Customer]</h3>
        <input type ="text" name="fname" placeholder="First Name" required><br>
        <input type ="text" name="lname" placeholder="Last Name" required><br>
        <input type ="email" name="email" placeholder="E-mail" required><br>
        <input type ="text" name="phone" placeholder="Phone" required><br>
        <input type ="text" name="address" placeholder ="Address" required><br>
        <input type ="submit" name="create" value="Create">
        <input type ="button" onclick="closeForm(\'newForm\')" value="Cancel">
    </form>
</div>

<div class ="form-popup" id="retForm" style="display:none;">
    <form method="post">
        <h3>[Customer Lookup]</h3>
	<p>Select a search method:</p>
        <input type="radio" name="searchMethod" value=1>Name<br>
        <input type="radio" name="searchMethod" value=2>Email<br>
        <input type="radio" name="searchMethod" value=3>Phone<br><br>
	<input type="text" name="customer" placeholder="Customer"><br>
        <input type="submit" name="custSearch" value="Search">
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

    $_SESSION['customer'] = $customerData;
    header("Location: sale.php");
}
#If the customer doesn't want to give their information, reciept is stored in
#a generic guest account.
if(isset($_POST['skip']))
{
    $_SESSION['customer'] = [
	'Customer_ID' => 0,
        'First_Name' => "Guest",
        'Last_Name' => "Customer",
        'Email' => "store@store.com",
        'Phone' => "(000)-000-000",
        'Address' => "1 Hawk Drive, Newpaltz NY"
        ];
    header("Location: sale.php");
}
#If customer search is used to find a customer.
#Searches based on first field entered.
if(isset($_POST['custSearch']) AND isset($_POST['searchMethod']))
{
    $db = connect(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);

    echo '<table style="width:60%;" border="1">
	<tr>
	    <th>Customer</th>
	    <th>Phone</th>
	    <th>Email</th>
	    <th>Choice</th>
	</tr>';

    if($_POST['searchMethod'] == 1)
    {
        $custName = explode(" ", $_POST['customer']);
	$customerList = findCustomerByName($db, $custName);
	$numResults = mysqli_num_rows($customerList);

	if($numResults > 0)
	{
	    while($row = mysqli_fetch_array($customerList))
	    {
		echo "<tr><form method='post'>"
		    . "<td><label>" . $row['First_Name'] . " " . $row['Last_Name'] . "</label></td>"
			. "<input type='hidden' name='cid' value='" . $row['Customer_ID'] . "'>"
		    	. "<input type='hidden' name='fname' value='" . $row['First_Name'] . "'>"
		        . "<input type='hidden' name='lname' value='" . $row['Last_Name'] . "'>"
		    . "<td>" . $row['Phone'] . "</td>"
			. "<input type='hidden' name='phone' value='" . $row['Phone'] . "'>"
		    . "<td>" . $row['Email'] . "</td>"
			. "<input type='hidden' name='email' value='" . $row['Email'] . "'>"
		    . "<td>" . "<input type='submit' name='select' value='[Select]'>" . "</td>"
		    . "</form></tr>";
	    }
	}
        else
	{
	    echo "No results.";
	}
    }
    else if($_POST['searchMethod'] == 2)
    {
        $customerList = findCustomerByEmail($db, $_POST['customer']);
	$numResults = mysqli_num_rows($customerList);

	if($numResults > 0)
	{
	    while($row = mysqli_fetch_array($customerList))
	    {
		echo "<tr><form method='post'>"
                    . "<td><label>" . $row['First_Name'] . " " . $row['Last_Name'] . "</label></td>"
                        . "<input type='hidden' name='fname' value='" . $row['First_Name'] . "'>"
                        . "<input type='hidden' name='lname' value='" . $row['Last_Name'] . "'>"
			. "<input type='hidden' name='cid' value='" . $row['Customer_ID'] . "'>"
                    . "<td>" . $row['Phone'] . "</td>"
                        . "<input type='hidden' name='phone' value='" . $row['Phone'] . "'>"
                    . "<td>" . $row['Email'] . "</td>"
                        . "<input type='hidden' name='email' value='" . $row['Email'] . "'>"
                    . "<td>" . "<input type='submit' name='select' value='[Select]'>" . "</td>"
                    . "</form></tr>";
	    }
	}
	else
	{
	    echo "No results.";
	}
    }
    else if($_POST['searchMethod'] == 3)
    {
        $customerList = findCustomerByPhone($db, $_POST['customer']);
	$numResults = mysqli_num_rows($customerList);

	if($numResults > 0)
	{
	    while($row = mysqli_fetch_array($customerList))
	    {
	        echo "<tr><form method='post'>"
                    . "<td><label>" . $row['First_Name'] . " " . $row['Last_Name'] . "</label></td>"
			. "<input type='hidden' name='cid' value='" . $row['Customer_ID'] . "'>"
                        . "<input type='hidden' name='fname' value='" . $row['First_Name'] . "'>"
                        . "<input type='hidden' name='lname' value='" . $row['Last_Name'] . "'>"
                    . "<td>" . $row['Phone'] . "</td>"
                        . "<input type='hidden' name='phone' value='" . $row['Phone'] . "'>"
                    . "<td>" . $row['Email'] . "</td>"
                        . "<input type='hidden' name='email' value='" . $row['Email'] . "'>"
                    . "<td>" . "<input type='submit' name='select' value='[Select]'>" . "</td>"
                    . "</form></tr>";
	    }
	}
	else
	{
	    echo "No results.";
	}
    }
}
if(isset($_POST['select']))
{
    $_SESSION['customer'] = [
	'Customer_ID' => $_POST['cid'],
	'First_Name' => $_POST['fname'],
	'Last_Name' => $_POST['lname'],
	'Email' => $_POST['email'],
	'Phone' => $_POST['phone']
    ];
    header("Location: sale.php");
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
