<html>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<div class = "screen">
<h3>[Inventory Manager]</h3>
  <?php
  session_start();

  if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false){
      header("Location: login.php");
  }

  if($_SESSION['permission'] != (4 || 2)){
  	header("Location: inventory.php");
  }

  echo $_SESSION["navbar"];



  ?>

</div>
</html>

