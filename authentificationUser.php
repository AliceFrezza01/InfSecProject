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

        $token = input($_POST['token']);

        if (verifyToken($token)) {      //TODO is it necessary here?
            session_destroy();
            ?>
            <script>
                window.location.replace("login.php");
            </script>
            <?php
        }

    }


// CSRF TOKEN VERIFICATION
function verifyToken($postToken){
    $validToken = false;

    if(!$postToken || !isset($_SESSION["token"])){
        console_log('token not set');
//        exit("token not set!");
    }

    if($postToken == $_SESSION["token"]){

        if (time() >= $_SESSION["token-expiry"]) {
            console_log('token expired');
            header('location: login.php');  //redirects to login
        }
        console_log('valid token');
        $validToken = true;
//        unset($_SESSION["token"]); //not necessary as session_destroy will destroy also token
    }
    else {
        console_log('invalid token');
//        exit("invalid token");
    }
    return $validToken;

}

//$token = input($_POST['token']);
//
//if (verifyToken($token)) {}






?>