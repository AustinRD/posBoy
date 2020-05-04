<?php
session_start();
require_once 'config.php';
require_once 'db.php';
$db = connect(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false){
        header("Location: login.php");
}
$output = "";
if(isset($_POST['searchButton'])){

if($_POST['searchType']==1){
	$val = "`ProductName`";
	#echo "set name";
}
if($_POST['searchType']==2){
	$val = "`SKU`";
	#echo "set SKU";
}
if($_POST['searchType']==3){
	$val = "`UPC`";
	#echo "set UPC";
}  
	$temp = "'%".$_POST['search']."%'";
	#echo "SELECT * FROM `Inventory` WHERE ".$val." LIKE ".$temp;
	$query = mysqli_query($db, "SELECT * FROM `Inventory` WHERE ".$val." LIKE ".$temp) or die('could not search');
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
<div class = "screen">
<h3>[Inventory]</h3>


<?php
  echo $_SESSION["navbar"];

  echo '<body>';
if($_SESSION['permission'] == (2 || 3 || 4)){
  echo'<a href="inventoryManage.php">Inventory Manager</a>';
}
?>

  <form action="inventory.php" method="post">
          <br>
        <p>Inventory Query:</p>
        <input type="text" name="search" placeholder="input"/>
        <br>
        <input type="radio"name="searchType"checked="yes"value=1/>Name<br/>
        <input type="radio"name="searchType"value=2/>SKU<br/>
        <input type="radio"name="searchType"value=3/>UPC<br/>
          <input type="submit" value="search" name="searchButton"/>
  </form>

<?php
  print("$output");
  echo'</body>';


?>

</div>
</html>
