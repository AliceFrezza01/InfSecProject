<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Loginpage</title>

    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

</head>
<body>
    <?php
    //verbindung mit der Datenbank db herstellen
    include ('connect.php');

    //a prepare statement (for the secure version)
    $search_user = $con->prepare("SELECT id FROM user WHERE Benutzer = ? AND Passwort = ?");
    $search_user->bind_param('ss',$benutzer,$passwort);
    $search_user->execute();
    $search_result =$search_user->get_result();

    //query normale di sql
    $con->query("INSERT INTO `user`(`Bezeichnung`,`Datum`,`FibuID`,`Betrag`) VALUES ('$bezeichnung', '$datum', '$fibuid', '$betrag')");
    $res = $con->query("SELECT * FROM `user` WHERE id = 1 ");
    if ($res->num_rows > 0) {
    while ($i = $res->fetch_assoc()) {
        $username = $i['name'];
    }
    ?>

    <h1>Login! ciao <?php echo $username ?></h1>


</body>
</html>