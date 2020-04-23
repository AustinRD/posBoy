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

if(isset($_POST['search'])){
$valueToSearch=$_POST['valueToSearch'];
$valueToSearch= preg_replace("#[^0-9a-z]#i","",$valueToSearch);
$search_result=mysqli_query($db, "SELECT * FROM EmployeeDatabase WHERE EmployeeID LIKE '%$valueToSearch%' OR FirstName LIKE '%$valueToSearch%' OR LastName LIKE '%$valueToSearch%' OR BankAccountNum LIKE '%$valueToSearch%' OR RoutingNum LIKE '%$valueToSearch%' OR Address LIKE '%$valueToSearch%' OR PhoneNumber LIKE '%$valueToSearch%'") or die("No Search Results");
}
else{
$search_result=mysqli_query($db, "SELECT * FROM EmployeeDatabase");
}
?>

<html>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
<div class="screen">

<?php
echo '<head><h3>[Employee Search]</h3>'
    . $_SESSION['navbar']
    . '</head>';
?>
<body>
<br>

<form action="employeeSearch.php" method="post">
<input type="text" name="valueToSearch" placeholder="Value To Search"><br><br>
<input type="submit" name="search" value="filter"><br><br>
<table border='1'>
<tr>
<th>EmployeeID</th>
<th>FirstName</th>
<th>LastName</th>
<th>BankAccountNumber</th>
<th>RoutingNumber</th>
<th>Address</th>
<th>PhoneNumber</th>
</tr>

<?php while($row = mysqli_fetch_array($search_result)):?>
<tr>
<td><?php echo $row['EmployeeID'];?></td>
<td><?php echo $row['FirstName'];?></td>
<td><?php echo $row['LastName'];?></td>
<td><?php echo $row['BankAccountNum'];?></td>
<td><?php echo $row['RoutingNum'];?></td>
<td><?php echo $row['Address'];?></td>
<td><?php echo $row['PhoneNumber'];?></td>
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
