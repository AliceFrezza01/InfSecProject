<?php
session_start();

include ('connect.php');

global $con;

//check if already logged in
if(isset($_SESSION['loginsession'])){
    header('location: landingPage.php');
}

//if button is clicked
if(isset($_POST['login'])){

    $username = input($_POST['user']);
    $password = input($_POST['password']);

    //check if login is correct

    //todo for the secure version
    /*$search_user = $con->prepare("SELECT * FROM user WHERE email = ? AND password = ?");
    $search_user->bind_param('ss',$username,$password);
    $search_user->execute();
    $search_result =$search_user->get_result();*/

    $search_result = $con->query("SELECT * FROM user WHERE email = '$username' AND password = '$password'");

    if($search_result->num_rows == 1){
        $search_object = $search_result->fetch_object();
        $_SESSION['loginsession'] = $search_object->id;
        header('location: landingPage.php');
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