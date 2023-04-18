<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Landingpage</title>

    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

</head>
<body>
    <?php
    include ('connect.php');

    //check if user is authenticated else redirect him to the login
    if(!isset($_SESSION['loginsession'])){
        header('location: login.php');
    }

    $userid = $_SESSION['loginsession'];
    $userqueryresult = $con->query("SELECT * FROM user WHERE id = '$userid'");
    if($userqueryresult->num_rows != 1){
        //redirect also on login page because the userid does not exist or exists multiple times
        header('location: login.php');
    }

    $user = $userqueryresult->fetch_assoc();


    //function for the logout button
    if (isset($_POST['logout'])) {
        session_destroy();
        ?>
        <script>
            window.location.replace("login.php");
        </script>
        <?php
    }
    ?>
    <h1>Landingpage</h1>
    <p>Hello <?php echo $user['name'] ?></p>
    <form action='' method='post'>
        <input type="submit" name="logout" value="LOG OUT">
    </form>
</body>
</html>