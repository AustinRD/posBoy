<html>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<div class = "screen"> 

<?php
require_once 'config.php';
require_once 'db.php';

#Starting the session for this page.
session_start();

#Will be needed later for timesheet info.
date_default_timezone_set("America/New_York");

#Checking if the user is logged in on the current session.
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false){
    #Redirecting if the user is not logged in.
    header("Location: login.php");
}

#Displaying user id and sign-in status.
echo '<h3>Welcome, Employee #' . $_SESSION["userid"] . '</h3>';
echo '<p>Successfully Logged In</p>';

#Creating a single navbar to be used across pages.
$_SESSION["navbar"] = '<nav>
    <a href="main.php">Home</a> |
    <a href="inventory.php">Inventory</a> |
    <a href="sales.php">Sales<a> |
    <a href="customerSearch.php">Customer Search<a> |
    <a href="employeeSearch.php">Employee Search<a> |
    <a href="checkout.php">Checkout</a>
</nav>
<br>';

#Printing the navbar followed by the body of this page.
echo $_SESSION["navbar"];
echo '<body>
      <form method="post">
            <input type="submit" name="clockin"  value="Clock-In">
            <input type="submit" name="clockout"  value="Clock-Out">
            <input type="button" onclick="location.href = \'logout.php\'" value="Logout">
      </form>
    </body>';

#Checking if the clockin button was pressed.
#If the button was pressed we gather the information and
#send it to our db function to add it to the TimesheetData table.
if(isset($_POST['clockin']))
{
    $db = connect(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);
    $timesheet = [
        'employeeID' => $_SESSION['userid'],
        'actionType' => 'Clock-In',
        'date' => date("Y-m-d"),
        'time' => date("h:i:sa")
    ];
    createTimesheet($db, $timesheet);

    echo "You've clocked in.<br>";
    echo "Employee: " . $timesheet['employeeID'];
    echo "<br>Date: " . $timesheet['date'];
    echo "<br>Time: " . $timesheet['time'];
}
if(isset($_POST['clockout']))
{
    $db = connect(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);
    $timesheet = [
        'employeeID' => $_SESSION['userid'],
        'actionType' => 'Clock-Out',
        'date' => date("Y-m-d"),
        'time' => date("h:i:sa")
    ];
    createTimesheet($db, $timesheet);

    echo "You've clocked out.<br>";
    echo "Employee: " . $timesheet['employeeID'];
    echo "<br>Date: " . $timesheet['date'];
    echo "<br>Time: " . $timesheet['time'];
}
?>
</div>
</html>
