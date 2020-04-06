<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false){
        header("Location: login.php");
}

?>

<?php
require_once 'config.php';
require_once 'db.php';

$db = connect(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);


$output ='';

if(isset($_POST['search'])) {
   $searchq = $_POST['search'];
   $searchq = preg_replace("#[^0-9a-z]#i","",$searchq);

   $query = mysqli_query($db, "SELECT * FROM EmployeeDatabase WHERE EmployeeID LIKE '%$searchq%' OR FirstName LIKE '%
$searchq%' OR LastName LIKE '%$searchq%' OR BankAccountNum LIKE '%$searchq%' OR RoutingNum LIKE '%$searchq%' OR Addre
ss LIKE '%$searchq%' OR PhoneNumber LIKE '%$searchq%' OR PlaintextPass LIKE '%$searchq%'" ) or die("could not search"
);
   $count = mysqli_num_rows($query);
   if($count == 0){
        $output = 'There were no search results';
   }else{
        while($row = mysqli_fetch_array($query)){
           $ID = $row['EmployeeID'];
           $fname = $row['FirstName'];
           $lname = $row['LastName'];
           $BankAccountNum = $row['BankAccountNum'];
           $RoutingNum = $row['RoutingNum'];
           $address = $row['Address'];
           $phone = $row['PhoneNumber'];
           $pass = $row['PlaintextPass'];

           $output .= '<div>'.$ID.' '.$fname.' '.$lname.' '.$BankAccountNum.' '.$RoutingNum.' '.$address.' '.$phone.'
 '.$pass.'</div>';
   }
}
}
?>


<html>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
<div class="screen">
<head>
<h3>[Employee Search]</h3>
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

<form action="EmployeeSearch.php" method="post">
        <input type="text" name="search" placeholder="search"/>
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