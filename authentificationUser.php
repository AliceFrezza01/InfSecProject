<?php

    global $con;

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