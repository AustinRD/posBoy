<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false){
        header("Location: login.php");
}

require_once 'config.php';
require_once 'db.php';

$db = connect(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);

if($db instanceof mysqli)
{
   echo "CONNECTED";
}
else{
   echo "NOT CONNECTED";
}

$output ='';

if(isset($_POST['search'])) {
   $searchq = $_POST['search'];
   $searchq = preg_replace("#[^0-9a-z]#i","",$searchq);

   $query = mysqli_query($db, "SELECT * FROM Inventory WHERE SKU LIKE '%$searchq%' OR ProductName LIKE '%$searchq%' O
R AvailableStock LIKE '%$searchq%' OR Price LIKE '%$searchq%' OR UPC LIKE '%$searchq%'" ) or die("could not search");
   $count = mysqli_num_rows($query);
   if($count == 0){
        $output = 'There were no search results';
   }else{
        while($row = mysqli_fetch_array($query)){
           $SKU = $row['SKU'];
           $Pname = $row['ProductName'];
           $AvailStock = $row['AvailableStock'];
           $price = $row['Price'];
           $UPC = $row['UPC'];

           $output .= '<div>'.$SKU.' '.$Pname.' '.$AvailStock.' '.$price.' '.$UPC.'</div>';
   }
}
}
?>


<html>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
<div class="screen">
<head>
<h3>[Inventory]</h3>
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
<br>
<?php
        if($_SESSION['permission'] == (2 || 3 || 4)){
?>
                <html>
                        <a href="inventoryManage.php">Inventory Manager</a>
                </html>
<?php
        }
?>


<form action="inventory.php" method="post">
        <br>
	<p>Inventory Query:</p>
	<input type="text" name="search" placeholder="input"/>
	<br>
	<input type="radio"name="searchType"checked="yes"/>All Fields<br/>
	<input type="radio"name="searchType"/>Name<br/>
	<input type="radio"name="searchType"/>SKU<br/>
	<input type="radio"name="searchType"/>UPC<br/>
        <input type="submit" value="search"/>
</form>
<?php print("$output"); ?>

<div>
<?php
        if(@$_GET['ErrorMess']==true){
?>
        <div class="addText"><?php echo $_GET['ErrorMess'] ?></div>
<?php
                }
?>
</body>
</div>
</html>
