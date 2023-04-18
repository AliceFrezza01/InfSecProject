<?php
//verbindung mit der Datenbank db herstellen
$servername = "localhost";
$user = "root";
$pw = "";
$db = "ecommerce";

$con = new mysqli($servername, $user, $pw, $db);
if ($con->connect_error) {
    die("Verbindung konnte nicht hergestellt werden" . $con->connect_error);
}
echo('verbindung')
?>
