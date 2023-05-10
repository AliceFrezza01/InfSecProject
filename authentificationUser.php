<?php

    global $con;

    if(!isset($_SESSION['loginsession'])){
        header('location: login.php');
    }
    $userid = $_SESSION['loginsession'];

    //this query retrieves all the information from the user, from which the session is recorded
    $userqueryresult = $con->prepare("SELECT * FROM user WHERE id = ?");
    $userqueryresult->bind_param('i', $userid);
    $userqueryresult->execute();
    $result = $userqueryresult->get_result();
    $nr_results = $result->num_rows;

    if($nr_results!= 1){
        //redirect also on login page because the userid does not exist or exists multiple times
        header('location: login.php');
    }

    $user = $result->fetch_assoc();

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