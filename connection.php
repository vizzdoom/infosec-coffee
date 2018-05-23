<?php
global $conn;
try {
    $conn = new PDO(DB_CONNECTION_STRING, DB_USERNAME, DB_PASSWORD);
}
catch (PDOException $ex){
    die("Connection failed: ".$ex->getMessage());
}
