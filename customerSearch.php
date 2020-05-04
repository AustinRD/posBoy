<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false){
        header("Location: login.php");
}

?>

<?php
require_once 'config.php';
require_once 'db.php';

$db =connect(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);

$search_result = '';

if(isset($_POST['search'])){                                                       $valueToSearch=$_POST['valueToSearch'];                                            $valueToSearch= preg_replace("#[^0-9a-z]#i","",$valueToSearch);                    $search_result=mysqli_query($db, "SELECT * FROM CustomerData WHERE Customer_ID LIKE '%$valueToSearch%' OR First_Name LIKE '%$valueToSearch%' OR Last_Name LIKE '%$valueToSearch%' OR Email LIKE '%$valueToSearch%' OR Address LIKE '%$valueToSearch%' OR Phone LIKE '%$valueToSearch%'") or die("No Search Results");
}
else{
$search_result=mysqli_query($db, "SELECT * FROM CustomerData");
}

?>


<html>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
<div class="screen">

<?php
echo '<head><h3>[Customer Search]</h3>'
    . $_SESSION['navbar']
    . '</head>';
?>
<body>
<br>

<form action="customerSearch.php" method="post">
<input type="text" name="valueToSearch" placeholder="Value To Search"><br><br>
<input type="submit" name="search" value="search">
<table border='1'>
<tr>
<th>CustomerID</th>
<th>FirstName</th>
<th>LastName</th>
<th>Email</th>
<th>Address</th>
<th>Phone</th>
</tr>

<?php while($row = mysqli_fetch_array($search_result)):?>
<tr>
<td><?php echo $row['Customer_ID'];?></td>
<td><?php echo $row['First_Name'];?></td>
<td><?php echo $row['Last_Name'];?></td>
<td><?php echo $row['Email'];?></td>
<td><?php echo $row['Address'];?></td>
<td><?php echo $row['Phone'];?></td>
</tr>
<?php endwhile;?>
</table>

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
