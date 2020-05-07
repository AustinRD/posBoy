<html>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<div class = "screen">
<h3>[Employee Manager]</h3>
  <?php
  session_start();

  if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false){
      header("Location: login.php");
  }

  if($_SESSION['permission'] != (4 || 3)){
        header("Location: salesData.php");
  }

  echo $_SESSION["navbar"];



  ?>
<body>
    <p>Create a New Employee Account</p>
    <form method="post" action="newEmployee.php">
    First Name:<br/><input type="text"name="fname" placeholder="First Name"><br/>
    Last Name:<br/><input type="text"name="lname" placeholder="Last Name"><br/>
    Address:<br/><input type="text"name="addr" placeholder="Full Address"><br/>
    Phone Number:<br/><input type="text"name="phone"placeholder="(XXX)XXX-XXXX"><br/>
    Starting Password:<br/><input type="password"name="pass"><br/>
    Bank Info:<br/><input type="text"name="bank"placeholder="XXXXXXXX"><br/>
    Permission Type:<br/><input type="text"name="permis"placeholder="[0-3]"><br/><br/>
    <input type="submit" value="Submit New Employe" name="submitButton"><br/><br/>
    </form>
    <p>Edit an Employee's Password</p>
    <form method="post" action="newPassword.php">
    Exact Employee ID: <br/> <input type="text" name="employeeID" placeholder="6 Digit Number"><br/>
    New Password:<br/><input type="text"name="value" placeholder="New Password"><br/>
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

