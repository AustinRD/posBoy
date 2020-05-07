<html>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<div class = "screen">
<h3>[Inventory Manager]</h3>
  <?php
  session_start();

  if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false){
      header("Location: login.php");
  }


if(!(($_SESSION['permission'] == 2)||($_SESSION['permission'] == 3)||($_SESSION['permission'] == 4))){
  header("Location: inventory.php");
}

  echo $_SESSION["navbar"];



  ?>
<body>
    <p>Create a new Item</p>
    <form method="post" action="createItem.php">
    SKU: <br/> <input type="text" name="sku" placeholder="6 Digit Number"><br/>
    Name:<br/><input type="text"name="name" placeholder="Full Name"><br/>
    Stock:<br/><input type="text"name="stock" placeholder="Starting Stock"><br/>
    Price:<br/><input type="text"name="price"placeholder="Dollars and Cents"><br/>
    UPC:<br/><input type="text"name="upc"placeholder="12 Digit Number"><br/><br/>
    <input type="submit" value="Submit New Item" name="submitButton"><br/><br/>
    </form>
    <p>Edit a Pre-Existing Item</p>
    <form method="post" action="editItem.php">
    Exact Item SKU: <br/> <input type="text" name="sku" placeholder="6 Digit Number"><br/>
    New Value:<br/><input type="text"name="value" placeholder="Input"><br/>
    <input type="radio"name="type"checked="yes"value=0/>Changed Stock<br/>
    <input type="radio"name="type"value=1/>Changed Price<br/><br/>
    <input type="submit" value="Submit Changes" name="submitButton"><br/>
    </form>

<?php
    if(@$_GET['ReturnMess']==true){
?>

	<div class="addText"><?php echo $_GET['ReturnMess'] ?></div>
        <?php
}
?>


</body>

</div>
</html>

