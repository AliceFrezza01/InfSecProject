<?php

include ('mainFunctions.php');

//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');

//create connection to the database
$servername = "localhost";      //localhost:18002
$user = "root";
$pw = "";
$db = "ecommerce_secure";

$con = new mysqli($servername, $user, $pw, $db);
if ($con->connect_error) {
    die("Error connecting to the database: " . $con->connect_error);
}


?>