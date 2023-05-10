<?php
session_start();

include 'connect.php';

global $con;

//check if already logged in
if(isset($_SESSION['loginsession'])){
    header('location: landingpage.php');
}

//if button is clicked
if(isset($_POST['register'])){

    $usertype = input($_POST['usertype']);
    $name = input($_POST['name']);
    $username = input($_POST['user']);
    $password = input($_POST['password']);

    //check if user already exists
    $search_result = $con->prepare("SELECT * FROM user WHERE email=?");
    $search_result->bind_param('s', $username);
    $search_result->execute();
    $result = $search_result->get_result();

    if($result->num_rows == 1){
        echo('<p style="color:red">User with this email already exists</p>');
    }else{
        //create new user
        if($usertype == 'vendor'){
            $isVendor = 1;
        }else{
            $isVendor = 0;
        }
        $salt = lcg_value();
        $concat = $password . $salt;
        $password = hash('sha384', $concat);

        $insertion_query = $con->prepare("INSERT INTO user(`name`, `email`, `password`, `isVendor`, `salt`) VALUES (?,?,?,?,?)");
        $insertion_query->bind_param('sssii', $name, $user, $password, $isVendor, $salt);
        $insertion_query->execute();

        if ($insertion_query->affected_rows != 1) {
            echo('<p style="color:red">Error creating user</p>');
        } else {
            $createduserid = mysqli_insert_id($con);
            $_SESSION['loginsession'] = $createduserid;
            header('location: landingpage.php');
        }

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
    <h1> Register </h1>
    <form action="" method="post">

        <input checked type="radio" id="costumer" name="usertype" value="costumer">
        <label for="costumer">costumer</label><br>
        <input type="radio" id="vendor" name="usertype" value="vendor">
        <label for="vendor">vendor</label><br>

        <p>Name</p>
        <input required type="text" name="name" >
        <p>Email</p>
        <input required type="text" name="user" >
        <p>Password</p>
        <input required type="password" name="password" >
        <br><br>
        <input class="button" type="submit" name="register" value="REGISTER">
    </form>
    <br>
    <a href="login.php">To login page</a>
</div>


</body>
</html>