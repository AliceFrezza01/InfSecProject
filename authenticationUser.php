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

        if (verifyToken($token)) {
            session_destroy();
            ?>
            <script>
                window.location.replace("login.php");
            </script>
            <?php
        }

    }


// CSRF TOKEN VERIFICATION
/**
 * verifies if a CSRF Token has been set and if it is valid or not
 * @param $postToken token provided by Form submission
 * @return bool True if valid, else False and exits page
 */
function verifyToken($postToken){
    $validToken = false;

    if(!$postToken || !isset($_SESSION["token"])){
        exit("token not set!");
    }

    if($postToken == $_SESSION["token"]){               //check if token from Form matches Session Token

        if (time() >= $_SESSION["token-expiry"]) {      //check if token is expired
//            console_log('token expired');
            header('location: login.php');
        }
//        console_log('valid token');
        $validToken = true;
    }
    else {
        exit("invalid token");
    }
    return $validToken;

}


?>