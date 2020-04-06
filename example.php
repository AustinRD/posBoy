<?php
require_once 'config.php';
require_once 'db.php';
echo "<h1>Main Page</h1>";

$db = connect(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);

#Testing mysqli connection
/*if($db instanceof mysqli)
{
   echo "Client Info: " . $db->client_info . "<br>";
   echo "Client Version: " . $db->client_version . "<br>";
}*/
#Testing fetchAll function
/*
if($db instanceof mysqli)
{
    $records = fetchAll($db);
    var_dump($records);
}*/
$records = fetchAll($db);
$records1 = fetchObject($db);
?>
<html>
    <head>
        <title>Select all from MYSQL table</title>
    </head>
    <body>
        <h1>Example Table Using fetchAll function:</h1>
        <table>
            <thead>
            <tr>
                <th>Customer ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
            </tr>
            </thead>

            <tbody>
            <?php
            if(count($records) > 0):
                foreach($records as $record): ?>
                    <tr>
                        <td><?php echo $record['Customer_ID'];?></td>
                        <td><?php echo $record['First_Name'];?></td>
                        <td><?php echo $record['Last_Name'];?></td>
                        <td><?php echo $record['Email'];?></td>
                        <td><?php echo $record['Phone'];?></td>
                    </tr>
            <?php endforeach;
            else: ?>
                <tr>
                    <td colspan="5">Cannot find any records</td>
                </tr>

            <?php endif ?>
            </tbody>
         </table>

        <h1>Example Table Using fetchObject function:</h1>
        <table>
            <thead>
            <tr>
                <th>Customer ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if(count($records) > 0):
                foreach($records1 as $record1): ?>
                    <tr>
                        <td><?php echo $record1->Customer_ID;?></td>
                        <td><?php echo $record1->First_Name;?></td>
                        <td><?php echo $record1->Last_Name;?></td>
                        <td><?php echo $record1->Email;?></td>
                        <td><?php echo $record1->Phone;?></td>
                     </tr>
                    </tr>
            <?php endforeach;
            else: ?>
                <tr>
                    <td colspan = "5">Cannot find any records</td>
                </tr>
            <?php endif ?>
            </tbody>
         </table>
    </body>
</html>