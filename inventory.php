<html>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<div class = "screen">
<h3>[Inventory]</h3>
  <?php

  session_start();
  require_once 'config.php';
  require_once 'db.php';

  if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false){
          header("Location: login.php");
  }

  echo $_SESSION["navbar"];

  echo '<body>';
if($_SESSION['permission'] == (2 || 3 || 4)){
  echo '<a href="inventoryManage.php">Inventory Manager</a>';
}
 

  ?>

<form action="inventory.php" method="post">
          <br>
        <p>Inventory Query:</p>
        <input type="text" name="search" placeholder="input"/>
        <br>
        <input type="radio"name="searchType"checked="yes"value=0/>All Fields<br/>
        <input type="radio"name="searchType"value=1/>Name<br/>
        <input type="radio"name="searchType"value=2/>SKU<br/>
        <input type="radio"name="searchType"value=3/>UPC<br/>
          <input type="submit" value="search"/>
  </form>
</body>
</div>
</html>

