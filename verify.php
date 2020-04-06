<?php
session_start();
require_once('tempLogConn.php');



if(isset($_POST['Login']))
{
        if(empty($_POST['employeeid']) || empty($_POST['password']))
        {
                header("Location:login.php?ErrorMess=Please Enter Both Your Employee ID and Password");
        }
        else
        {
                $query="SELECT * FROM EmployeeDatabase WHERE  EmployeeID='".$_POST['employeeid']."' AND PlaintextPass='".$_POST['password']."'";
                $result=mysqli_query($db,$query);
                if(mysqli_fetch_assoc($result))
                {
                        $_SESSION['userid'] = $_POST['employeeid'];
                        $_SESSION['loggedin'] = true;
                        header("Location:main.php");
                }
                else
                {
                        header("Location:login.php?ErrorMess=Invalid Credentials, Please Try Again");
                }
        }
}
else
{
        echo 'Error';
}
?>