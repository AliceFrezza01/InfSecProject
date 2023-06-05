<?php
//create connection to the database
$servername = "localhost:18002";
$user = "root";
$pw = "";
$db = "ecommerce_secure";

$con = new mysqli($servername, $user, $pw, $db);
if ($con->connect_error) {
    die("Error connecting to the database: " . $con->connect_error);
}

include ('mainfunctions.php');
?>