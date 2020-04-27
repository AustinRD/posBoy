<?php

//fetch.php

$db = connect(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);

$output = '';

$query = '';

if(isset($_POST['query']))
{
 $search = str_replace(",", "|", $_POST['query']);
 $search = preg_replace("#[^0-9a-z]#i","",$search) 
 $query = ($db, "SELECT * FROM CustomerData 
 WHERE Customer_ID REGEXP '".$search."' 
 OR First_Name REGEXP '".$search."' 
 OR Last_Name REGEXP '".$search."' 
 OR Email REGEXP '".$search."' 
 OR Phone REGEXP '".$search."'
 OR Address REGEXP '".$search."'
 ");
}
else
{
 $query =($db, "SELECT * FROM CustomerData ORDER BY Customer_ID
 ");
}

$statement = $connect->prepare($query);
$statement->execute();

while($row = $statement->fetch(PDO::FETCH_ASSOC))
{
 $data[] = $row;
}

echo json_encode($data);

?>
