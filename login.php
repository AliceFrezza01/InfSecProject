<?php
session_start();

include ('connect.php');

global $con;

//check if already logged in
if(isset($_SESSION['loginsession'])){
    header('location: landingpage.php');
}

//if button is clicked
if(isset($_POST['login'])){

    // GENERATE RANDOM CSRF TOKEN + SET TIMEOUT FOR TOKEN
    try {
        $_SESSION["token"] = bin2hex(random_bytes(32));
        $_SESSION["token-expiry"] = time() + 3600;  //after 1h
        console_log('token generated');
    } catch (Exception $e) {
        console_log('token not generated');
        echo "token not generated";
    }

    $username = input($_POST['user']);
    $password = input($_POST['password']);


    //check if login is correct
    $search_user = $con->prepare("SELECT * FROM user WHERE email = ?");
    $search_user->bind_param('s',$username);
    $search_user->execute();
    $search_result =$search_user->get_result();

    if($search_result->num_rows == 1){
        $search_object = $search_result->fetch_object();
        $salt = $search_object->salt;
        $concat = $password . $salt;
        $password = hash('sha384', $concat);
        if($password == $search_object->password){
            $_SESSION['loginsession'] = $search_object->id;
            header('location: landingpage.php');
        }else{
            echo('<p style="color:red">Wrong data</p>');
        }
    }else{
        echo('<p style="color:red">Wrong data</p>');
    }
}

$con->close();
?>


<!--HTML CODE-->

<!DOCTYPE html>
<html lang="en-us">
<?php include('head.php') ?>
<body>
    <div class="logindiv">
        <h1> Login </h1>
        <form action="" method="post">
            <p >Email</p>
            <input required type="text" name="user" >
            <p>Password</p>
            <input required type="password" name="password" >
            <br><br>
            <input class="button" type="submit" name="login" value="LOG IN">
        </form>
        <br>
        <a href="register.php">To register page</a>
    </div>


</body>
</html>