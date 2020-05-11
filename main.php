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

#Displaying user-id and creating navbar based on user permission level.
if($_SESSION['permission'] == 0)
{
    echo '<h3>Welcome back, #' . $_SESSION["userid"] . '</h3>';
    #Creating a single navbar to be used across pages.
    $_SESSION["navbar"] = '<nav>
        <a href="main.php">Home</a> |
        <a href="salesData.php">Data<a>
    </nav>
    <br>';
}
else if($_SESSION['permission'] == 1)
{
    echo '<h3>Welcome Employee, #' . $_SESSION["userid"] . '</h3>';
    #Creating a single navbar to be used across pages.
    $_SESSION["navbar"] = '<nav>
        <a href="main.php">Home</a> |
        <a href="inventory.php">Inventory</a> |
        <a href="salesData.php">Data<a> |
        <a href="checkout.php">Checkout</a>
    </nav>
    <br>';
}
else if($_SESSION['permission'] == 2)
{
    echo '<h3>Welcome Inventory Manager, #' . $_SESSION["userid"] . '</h3>';
    #Creating a single navbar to be used across pages.
    $_SESSION["navbar"] = '<nav>
        <a href="main.php">Home</a> |
        <a href="inventory.php">Inventory</a> |
        <a href="salesData.php">Data<a>
    </nav>
    <br>';
}
else if($_SESSION['permission'] == 3)
{
    echo '<h3>Welcome Manager, #' . $_SESSION["userid"] . '</h3>';
    #Creating a single navbar to be used across pages.
    $_SESSION["navbar"] = '<nav>
        <a href="main.php">Home</a> |
        <a href="inventory.php">Inventory</a> |
        <a href="salesData.php">Data<a> |
        <a href="checkout.php">Checkout</a>
    </nav>
    <br>';
}
else if($_SESSION['permission'] == 4)
{
    echo '<h3>Welcome Administrator, #' . $_SESSION["userid"] . '</h3>';
    #Creating a single navbar to be used across pages.
    $_SESSION["navbar"] = '<nav>
        <a href="main.php">Home</a> |
        <a href="inventory.php">Inventory</a> |
        <a href="salesData.php">Data<a> |
        <a href="checkout.php">Checkout</a>
    </nav>
    <br>';
}
echo '<p>Successfully Logged In</p>';

#Printing the navbar followed by the body of this page.
echo $_SESSION["navbar"];

#If the user is an employee they may clock in or out.
if($_SESSION['permission'] == (1 || 2 || 3 || 4))
{
    echo '<body>
      <form method="post">
            <input type="submit" name="clockin"  value="Clock-In">
            <input type="submit" name="clockout"  value="Clock-Out">
            <input type="button" onclick="location.href = \'logout.php\'" value="Logout">
      </form>
    </body>';
}
if($_SESSION['permission'] == 0)
{
    echo '<body>
	<input type="button" onclick="location.href = \'logout.php\'" value="Logout">
	</body>';
}
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
