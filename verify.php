<?php
session_start();
require_once('config.php');
require_once('db.php');
$db = connect(DB_HOST,DB_NAME,DB_USERNAME,DB_PASSWORD);

if(isset($_POST['Login']))
{
	if(empty($_POST['employeeid']) || empty($_POST['password'])){
		header("Location:login.php?ErrorMess=Please Enter Both Your Employee ID and Password");
		}
		else{
		$query="SELECT * FROM EmployeeDatabase WHERE  EmployeeID='".$_POST['employeeid']."' AND PlaintextPass='".$_POST['password']."'";	
		$result=mysqli_query($db,$query);
		if($searched=mysqli_fetch_assoc($result)){
			$_SESSION['userid'] = $_POST['employeeid'];
			$_SESSION['loggedin'] = true;
			$_SESSION['permission'] = $searched['PermissionType'];
			header("Location:main.php");
			}
			else{
				header("Location:login.php?ErrorMess=Invalid Credentials, Please Try Again");
				}
	}




	}
	else{
		echo 'Error';
	}


?>
