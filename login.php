<!DOCTYPE HTML>

<html>
<head>
<link rel="stylesheet" type="text/css" href="mystyle.css">
</head>

        <body>
<div class="screen">
        <p>[Employee Login]<br/><br/></p>
                <form method="post" action="verify.php">
                Employee ID:<br/>
                <input type="text" name="employeeid"><br/>
                Password:<br/>
                <input type="password" name="password"><br/><br/>
                <input type="submit" value="Login" name="Login"><br/>
                </form>
<<<<<<< HEAD
		<form action="https://cs.newpaltz.edu/se/se-s20-g08/posBoy/">
                <input type="submit" value="Return">
		</form>
		<div>
=======
                <form action="https://cs.newpaltz.edu/se/se-s20-g08/posBoy/">
                <input type="submit" value="Return">
                </form>
                <div>
>>>>>>> 693b49bdc1531bd20e9dfd01b3adfbe8069750e7
                <?php
                        if(@$_GET['ErrorMess']==true){
                ?>
                        <div class="addText"><?php echo $_GET['ErrorMess'] ?></div>
                <?php
                                }
                ?>
                </div>
</div>
        </body>
</html>
