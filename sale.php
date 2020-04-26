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


echo '<head><h3>[Customer Checkout]</h3>'
    . $_SESSION['navbar']
    . '</head>';

#HTML for the page layout.
echo '<body>
    <div>
    <table style="width:45%; float:left;" border="1">
    <tr>
        <th>Product</th>
        <th>SKU</th>
        <th>UPC</th>
        <th>Quantity</th>
    </tr>
    </table>';

echo '<table style="width:45%; float:right;" border="1">
    <tr>
        <th>Customer</th>
    </tr>
    <tr>
    <td>'
    . $customer['First_Name']
    . '</td>
    </tr>';

echo '</table>
    </div>
    <div>
    <table style="margin-top:1em; width:45%; float:left;" border="1">
    <th>Item Search</th>
    <tr>
        <td>
        <form method="post">
            <input type="text" name="product" placeholder="Product (Name, SKU, or UPC)">
            <br> 
            <input type="submit" name="search" value="Search">
        </form>
        </td>
    </tr>
    </table>

    <table style="margin-top:1em; width:45%; float:right;" border="1">
    <th>Total</th>
    </table>
    </div>

    <form style="margin-top:1em; float:right";>
    <input type="button" onclick="" value="Cancel Checkout">
    </form>
    </body>';

?>

</div>
</html>

