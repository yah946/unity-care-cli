<?php
$servername = 'localhost';
$username = 'root';
$passwd = '';
$db_name = 'backoffice unity cc';
try{
    $conn = new PDO("mysql:host=$servername;dbname=$db_name",$username,$passwd);
    $conn->setAttribute(PDO::ATTR_ERRMODE, value: PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}