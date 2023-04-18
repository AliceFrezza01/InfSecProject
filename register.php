<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Register</title>

    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

</head>
<body>
<?php
include ('connect.php');

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

    $search_result = $con->query("SELECT * FROM user WHERE email = '$username'");

    if($search_result->num_rows == 1){
        echo('<p style="color:red">User with this email already exists</p>');
    }else{
        //create new user
        $isVendor = ($usertype == 'vendor');
        $result = $con->query("INSERT INTO user(`name`, `email`, `password`, `isVendor`) VALUES ('$name','$username','$password','$isVendor')");
        if (!$result) {
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

<div>
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
        <input type="submit" name="register" value="REGISTER">
    </form>
    <a href="login.php">To login page</a>
</div>


</body>
</html>