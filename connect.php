<?php
//create connection to the database
$servername = "localhost:3307";
$user = "root";
$pw = "";
$db = "ecommerce";

$con = new mysqli($servername, $user, $pw, $db);
if ($con->connect_error) {
    die("Error connecting to the database: " . $con->connect_error);
}


//function to secure the input values
function input($data) {
    //todo implement in the secure version
    /*$data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    $data = str_replace("'", "''", $data);*/
    return $data;
}
?>
