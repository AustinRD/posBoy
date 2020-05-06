<html>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<div class = "screen">
<h3>[Data]</h3>
  <?php
  session_start();

  if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false){
      header("Location: login.php");
  }
  echo $_SESSION["navbar"];

  echo '<body>';

  if($_SESSION['permission']==(1 || 3 || 4)){
    echo'<a href="customerSearch.php">Customer Search</a>
    <br>
    <br>';
  }
  if($_SESSION['permission']==(3 || 4)){
    echo'<a href="employeeSearch.php">Employee Search</a>
    <br>
    <br>';
  }
  if($_SESSION['permission']==(1 || 3 || 4)){
    echo'<a href="transQuery.php">Transaction Lookup</a>
    <br>
    <br>
    <a href="zReport.php">Z-Report</a>
    <br>
    <br>';
  }
        echo'<a href="https://www.tax.ny.gov/forms/withholding_cur_forms.htm"target="_blank">Tax Information</a>
        <br>
        <br>
        </body>';

	if($_SESSION['permission']==(3 || 4)){
    echo'
    <br>
    <br>
    <br>
    <p>Manager Settings</p>
    <a href="employeeManage.php">Employee Manager</a>
    <br>
    <br>
    <a href="timeSheetSearch.php">View Timesheets</a>';
  	}

  ?>

</div>
</html>

