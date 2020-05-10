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

#First div for the product information and customer data.
echo '<body>
    <div style="display:table; width:100%; margin-top:1em; margin-bottom:1em;">
    <table id="cart" style="width:70%; float:left;" border="1">
    <tr><th colspan=4>Shopping Cart</th></tr>
    <tr>
        <th>Product</th>
        <th>SKU</th>
        <th>Quantity</th>
	<th>Unit Price</th>
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
    <table id="searchTable" style="margin-top:1em; width:70%; float:left;" border="1">
    <th colspan=4>Item Search</th>
    <tr>
        <td colspan=4>
        <form method="post">
            <input type="text" name="product" placeholder="Product (Name or SKU)">
            <br>
            <input type="hidden" name="cartState" id="cartState" value="">
	    <input type="submit" name="search" value="Search">
        </form>
        </td>
    </tr>';
#When the user selects to search for an item, the list of items matching
#the input is returned in a table.
if(isset($_POST['search']))
{
    $db = connect(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);
    $item = $_POST['product'];
    $inventoryList = findProduct($db, $item);
    $numResults = mysqli_num_rows($inventoryList);

    if($numResults > 0)
    {
	echo "<tr>
		<th>Product</th>
		<th>SKU</th>
		<th>Unit Price</th>
		<th>Option</th>
	    </tr>";

	$rowNum = 2;
	while($row = mysqli_fetch_array($inventoryList))
	{
	    echo "<tr>"
		. "<td>" . $row['ProductName'] . "</td>"
		. "<td>" . $row['SKU'] . "</td>"
		. "<td>" . $row['Price'] . "</td>"
		. "<td>" . "<input type='button' onclick='addToCart(" . ++$rowNum . ")' value='[ + ]'>" . "</td>"
		. "</tr>";
	}
    }
    else
    {
        echo "<tr><td>No Results Found</td></tr>";
    }
    if($_POST['cartState'] != "")
    {    
        $cartState = str_replace("\"", "\\\"", $_POST['cartState']);
	    $cartState = trim(preg_replace('/\s+/', " ", $cartState));
        echo '<br>
	    <script>document.getElementById("cart").innerHTML = "'. $cartState . '";</script>';
    }
}

#The following code uses a hidden form that saves the information on the screen locally
#This is done to avoid loss of data due to POST page refreshing.
echo '</table>

    <table id="totalTable" style="margin-top:1em; width:25%; float:right;" border="1">
    <th colspan="2">Total</th>
    <tr><td>Subtotal:</td><td>$0.00</td></tr>
    <tr><td>Tax:     </td><td>$0.00</td></tr>
    <tr><td>Total:   </td><td>$0.00</td></tr>
    </table>
    </div>

    <form method="post" style="margin-top:1em; float:right;">
	    <input type="hidden" name="hsubtotal" id="hsubtotal" value="">
	    <input type="hidden" name="htax" id="htax" value="">
	    <input type="hidden" name="htotal" id="htotal" value="">
	    <input type="hidden" name="hquantity" id="hquantity" value="">
	    <input type="hidden" name="hcart" id="hcart" value="">
	<input type="submit" name="proceed" value="Proceed">
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
if(isset($_POST['proceed']))
{
    $_SESSION['receipt'] = [
	    'Subtotal' => $_POST['hsubtotal'],
	    'Tax' => $_POST['htax'],
	    'Total' => $_POST['htotal'],
        'NumItems' => $_POST['hquantity'],
	    'Cart' => $_POST['hcart']
    ];
    header("Location: payment.php");
}
?>

</div>
</html>

<script>
//Global variable for tracking table row number.
var cartItems = 1;
function addToCart(row)
{
    //Obtaining current state of the cart.
    var cartTable = document.getElementById("cart");

    //Obtaining information from selected row in search table.
    var currentRow = document.getElementById("searchTable").rows[row].cells;
    var product = currentRow[0].innerText;
    var sku = currentRow[1].innerText;
    var unitPrice = parseFloat(currentRow[2].innerText).toFixed(2);
    var quantity = "<input type='button' onclick='addQty(" +  ++cartItems + ")' value='[ + ]'>1<input type='button' onclick='subQty(" + cartItems + ")' value='[ - ]'>";

    //Placing new row in cart with gathered information.
    var newRow = cartTable.insertRow(cartTable.rows.length);
    var productCol = newRow.insertCell(0);
    var skuCol = newRow.insertCell(1);
    var quantityCol = newRow.insertCell(2);
    var priceCol = newRow.insertCell(3);

    //Placing data in new row.
    productCol.innerText = product;
    skuCol.innerText = sku;
    quantityCol.innerHTML = quantity;
    priceCol.innerText = unitPrice;
    
    //Updating price information since new item was added.
    updateTotal();
}
//When the user selects the '[+]' button to add quantity.
function addQty(row)
{
    var currentRow = document.getElementById("cart").rows[row].cells;
    currentQuantity = parseInt(currentRow[2].innerText);
    currentRow[2].innerHTML = "<input type='button' onclick='addQty(" + row + ")' value='[ + ]'>" + ++currentQuantity + "<input type='button' onclick='subQty(" + row + ")' value='[ - ]'>";
    updateTotal();
}
//When the user selects the '[-]' button to subtract quantity.
function subQty(row)
{
    var currentRow = document.getElementById("cart").rows[row].cells;
    currentQuantity = parseInt(currentRow[2].innerText);
    if(currentQuantity > 0)
    {
        currentRow[2].innerHTML = "<input type='button' onclick='addQty(" + row + ")' value='[ + ]'>" + --currentQuantity + "<input type='button' onclick='subQty(" + row + ")' value='[ - ]'>";
        updateTotal();
    }
    //When the current quantity of the selected item is less than 0 we remove it from the table.
    else
    {
        //A better algorithm is needed for this to work properly.
        document.getElementById("cart").deleteRow(row);
    }
}
function updateTotal()
{
    var table = document.getElementById("cart").rows;
    var tableLen = table.length;

    if(tableLen > 2)
    {
	    var subtotal = 0;
	    var taxPercent = 0.08125;

        for(i = 2; i < tableLen; ++i)
	    {
	        var rowQty = parseInt(table[i].cells[2].innerText);
	        var rowUP = parseFloat(table[i].cells[3].innerText);

	        var rowTotal = parseFloat(rowQty * rowUP);
            subtotal = subtotal + rowTotal;
	    }
        var tax = subtotal * taxPercent;
        var total = subtotal + tax;
        
        var totalTable = document.getElementById("totalTable");
        totalTable.rows[1].cells[1].innerText = "$" + subtotal.toFixed(2);
        totalTable.rows[2].cells[1].innerText = "$" + tax.toFixed(2);
        totalTable.rows[3].cells[1].innerText = "$" + total.toFixed(2);
    }
    document.getElementById("cartState").value = document.getElementById("cart").innerHTML;
    document.getElementById("hsubtotal").value = document.getElementById("totalTable").rows[1].cells[1].innerText;
    document.getElementById("htax").value = document.getElementById("totalTable").rows[2].cells[1].innerText;
    document.getElementById("htotal").value = document.getElementById("totalTable").rows[3].cells[1].innerText;
    document.getElementById("hcart").value = "";
    var quantity = 0;
    if(tableLen > 2)
    {
        for(i = 2; i < tableLen; ++i)
        {
            quantity = quantity + parseInt(table[i].cells[2].innerText);
            for(j = 0; j <= 3; ++j)
            {
                document.getElementById("hcart").value = document.getElementById("hcart").value + table[i].cells[j].innerText + "|";
            }
        }
        document.getElementById("hquantity").value = quantity;
    }
}
</script>
