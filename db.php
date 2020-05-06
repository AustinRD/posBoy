<?php
#This file contains functions that access the database.
#Connect - establishes a mysqli connection using the information passed as a parameter.
function connect($dbHost, $dbName, $dbUsername, $dbPassword)
{
    $db = new mysqli(
        $dbHost,
        $dbUsername,
        $dbPassword,
        $dbName
    );
    if($db->connect_error)
    {
        die("Cannot connect to database: <br>"
        . $db->connect_error 
        . "<br>"
        . $dp->connect_errno
        );
    }
    return $db;
}

/**
 * Function for inserting new customer data into the database..
 * @param mysqli $db
 * @param array $record
 * @return array
*/
function insertRecord(mysqli $db, array $record)
{
    $sql = "INSERT INTO `CustomerData` "; #Database name
    $sql.= "(`First_Name`, `Last_Name`, `Email`, `Phone`, `Address`) ";
    $sql.= "VALUES ";
    $sql.= "(";
    $sql.= "'".$record['First_Name']."', ";
    $sql.= "'".$record['Last_Name']."', ";
    $sql.= "'".$record['Email']."', ";
    $sql.= "'".$record['Phone']."', ";
    $sql.= "'".$record['Address']."'";
    $sql.= ");";

    $db->query($sql);

    return $db;
}
#Function for sending a new customer's data to the database.
function createCustomer(mysqli $db, array $record)
{
    $sql = "INSERT INTO `CustomerData` "; #Database name
    $sql.= "(`First_Name`, `Last_Name`, `Email`, `Phone`, `Address`) ";
    $sql.= "VALUES ";
    $sql.= "(";
    $sql.= "'".$record['First_Name']."', ";
    $sql.= "'".$record['Last_Name']."', ";
    $sql.= "'".$record['Email']."', ";
    $sql.= "'".$record['Phone']."', ";
    $sql.= "'".$record['Address']."'";
    $sql.= ");";

    $db->query($sql);
}
#Function for sending timesheet data to database.
function createTimesheet(mysqli $db, array $record)
{
    $sql = "INSERT INTO `TimesheetData` ";
    $sql.= "(`employeeID`, `actionType`, `date`, `time`) ";
    $sql.= "VALUES ";
    $sql.= "(";
    $sql.= "'".$record['employeeID']."', ";
    $sql.= "'".$record['actionType']."', ";
    $sql.= "'".$record['date']."', ";
    $sql.= "'".$record['time']."'";
    $sql.= ");";

    $db->query($sql);
}

function findCustomerByName(mysqli $db, array $customerName)
{  
    #If the user has only entered a first or last name.
    if(sizeof($customerName) == 1)
    {
        $sql = "SELECT * FROM `CustomerData` WHERE `First_Name` LIKE '%";
        $sql.= $customerName[0] . "%'";
        $sql.= "OR `Last_Name` LIKE '%";
        $sql.= $customerName[0] . "%'";

        return $db->query($sql);
    }
    #If the user entered both a first and last name.
    else if(sizeof($customerName) > 1)
    {
        $sql = "SELECT * FROM `CustomerData` WHERE `First_Name` LIKE '%";
        $sql.= $customerName[0] . "%'";
        $sql.= "AND `Last_Name` LIKE '%";
        $sql.= $customerName[1] . "%'";
        
        return $db->query($sql);
    }
}

function findCustomerByEmail(mysqli $db, string $email)
{
    $sql = "SELECT * FROM `CustomerData` WHERE `Email` LIKE '";
    $sql.= $email . "'";

    return $db->query($sql);
}

function findCustomerByPhone(mysqli $db, string $phone)
{
    $sql = "SELECT * FROM `CustomerData` WHERE `Phone` LIKE '";
    $sql.= $phone . "'";

    return $db->query($sql);
}
#Function to find product at sale.
function findProduct(mysqli $db, string $product)
{
    $sql = "SELECT * FROM `Inventory` WHERE `ProductName` LIKE '%";
    $sql.= $product . "%' OR ";
    $sql.= "`SKU` LIKE '%";
    $sql.= $product . "%'";

    return $db->query($sql);
}
?>
