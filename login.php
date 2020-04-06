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

                <div>
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