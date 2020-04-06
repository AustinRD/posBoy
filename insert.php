<?php
require_once 'config.php';
require_once 'db.php';

$db = connect(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);
$record = [
    'First_Name' => 'Kevin',
    'Last_Name' => 'Fields',
    'Email' => 'test3@hawkmail.newpaltz.edu',
    'Phone' => '777-777-7777',
    'Address' => 'SUNY Newpaltz'
];

insertRecord($db, $record);
?>