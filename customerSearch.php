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

//if($db instanceof mysqli)
//{
//   echo "CONNECTED";
//}
//else{
//   echo "NOT CONNECTED";
//}

$output ='';

if(isset($_POST['search'])) {
   $searchq = $_POST['search'];
   $searchq = preg_replace("#[^0-9a-z]#i","",$searchq);

   $query = mysqli_query($db, "SELECT * FROM CustomerData WHERE Customer_ID LIKE '%$searchq%' OR First_Name LIKE '%$s
earchq%' OR Last_Name LIKE '%$searchq%' OR Email LIKE '%$searchq%' OR Phone LIKE '%$searchq%' OR Address LIKE '%$sear
chq%'" ) or die("could not search");
   $count = mysqli_num_rows($query);
   if($count == 0){
        $output = 'There were no search results';
   }else{
        while($row = mysqli_fetch_array($query)){
           $ID = $row['Customer_ID'];
           $fname = $row['First_Name'];
           $lname = $row['Last_Name'];
           $email = $row['Email'];
           $phone = $row['Phone'];
           $address = $row['Address'];

           $output .= '<div>'.$ID.' '.$fname.' '.$lname.' '.$email.' '.$phone.' '.$address.'</div>';
   }
}
}
?>


<html>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
<div class="screen">
<head>
<h3>[Customer Search]</h3>
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

<form action="customerSearch.php" method="post">
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