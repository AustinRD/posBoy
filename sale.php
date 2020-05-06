<html>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<div class = "screen">

<?php
require_once 'config.php';
require_once 'db.php';

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false)
{
    header("Location: login.php");
}

date_default_timezone_set("America/New_York");
$customer = $_SESSION['customer'];

echo '<head><h3>[Customer Checkout]</h3>';

$row = 0;
#First div for the product information and customer data.
echo '<body>
    <div style="display:table; width:100%; margin-top:1em; margin-bottom:1em;">
    <table id="cart" style="width:70%; float:left;" border="1">
    <tr>
        <th>Product</th>
        <th>SKU</th>
        <th>Quantity</th>
	<th>Unit Price</th>
    </tr>
    <tr>
        <td>Sample Product</td>
	<td>000000001</td>
	<td><input type="button" onclick="addQty(' . ++$row . ')" value="[ + ]">1<input type="button" onclick="subQty(' . $row . ')" value="[ - ]"></td>
	<td>$0.99</td>
    </tr>
    </table>
    <table style="width:25%; float:right;" border="1">
    <tr>
        <th>Customer</th>
    </tr>
    <tr>
    <td>' . $customer['First_Name'] . ' ' . $customer['Last_Name'] . '</td>
    </tr>
    </table>
    </div>';


#Second div for the bottom two tables - Item Search and Total
echo '<div style="display:table; width:100%; margin-top:1em; margin-bottom:1em;">
    <table style="margin-top:1em; width:70%; float:left;" border="1">
    <th colspan=4>Item Search</th>
    <tr>
        <td colspan=4>
        <form method="post">
            <input type="text" name="product" placeholder="Product (Name or SKU)">
            <br>
	    <input type="submit" name="search" value="Search">
        </form>
        </td>
    </tr>';

if(isset($_POST['search']))
{
    $db = connect(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);
    $item = $_POST['product'];
    $inventoryList = findProduct($db, $item);
    $numResults = mysqli_num_rows($inventoryList);

    if($numResults > 0)
    {
	echo "<tr><th>Product</th><th>SKU</th><th>Unit Price</th><th>Option</th></tr>";
	while($row = mysqli_fetch_array($inventoryList))
	{
	    echo "<tr>"
		. "<td>" . $row['ProductName'] . "</td>"
		. "<td>" . $row['SKU'] . "</td>"
		. "<td>" . $row['Price'] . "</td>"
		. "<td>" . "<input type='button' name='select' value='[ + ]'>" . "</td>"
		. "</tr>";
	}
    }
    else
    {
        echo "<tr>No Results Found</tr>";
    }
}

echo '</table>

    <table style="margin-top:1em; width:25%; float:right;" border="1">
    <th colspan="2">Total</th>
    <tr><td>Subtotal:</td><td>$0.00</td></tr>
    <tr><td>Tax:     </td><td>$0.00</td></tr>
    <tr><td>Total:   </td><td>$0.00</td></tr>
    </table>
    </div>

    <form method="post" style="margin-top:1em; float:right;">
        <input type="submit" name="cancelCheckout" value="Cancel Checkout">
    </form>
    </body>';

#If the transaction must be canceled before reaching the payment page.
#Clears the data in the session variable related to the customer previously
#checking out.
if(isset($_POST['cancelCheckout']))
{
    $_SESSION['customer'] = null;
    header("Location: checkout.php");
}

?>

</div>
</html>

<script>
function addQty(row)
{
    var x = document.getElementById("cart").rows[row].cells;
    currentQuantity = parseInt(x[2].innerText);
    x[2].innerHTML = "<input type='button' onclick='addQty(" + row + ")' value='[ + ]'>" + ++currentQuantity + "<input type='button' onclick='subQty(" + row + ")' value='[ - ]'>";
    updateTotal();
}
function subQty(row)
{
    var x = document.getElementById("cart").rows[row].cells;
    currentQuantity = parseInt(x[2].innerText);
    if(currentQuantity > 0)
    {
        x[2].innerHTML = "<input type='button' onclick='addQty(" + row + ")' value='[ + ]'>" + --currentQuantity + "<input type='button' onclick='subQty(" + row + ")' value='[ - ]'>";
        updateTotal();
    }
}
function updateTotal()
{
    var table = document.getElementById("cart").rows;
    var tableLen = table.length;

    if(tableLen > 1)
    {

    }

}
</script>
