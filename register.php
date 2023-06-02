<?php
session_start();

include ('connect.php');
include ('xssSanitation.php');
include('RSAandDSA.php');

global $con;

//check if already logged in
if(isset($_SESSION['loginsession'])){
    header('location: landingPage.php');
}

//if button is clicked
if(isset($_POST['register'])){

    $usertype = input($_POST['usertype']);
    try {
        $name = input(sanitation($_POST['name'], "string", false));
    } catch (Exception $e) {
        echo "invalid input";
    } //username
    try {
        $username = input(sanitation($_POST['user'], "email", true));
    } catch (Exception $e) {
        echo "invalid input";
    } //email
    $password = input($_POST['password']);

    if ($name=="" || $username=="" || $password=="") {
        echo "<script type='text/javascript'>alert('The account is not created, due to the credentials. Check the types and that the values are not empty. Then retry.');</script>";
    } else {

    $isPWComplex = validatePassword($password);
    if($isPWComplex){
        //check if user already exists
        $search_result = $con->prepare("SELECT * FROM user WHERE email=?");
        $search_result->bind_param('s', $username);
        $search_result->execute();
        $result = $search_result->get_result();

        if($result->num_rows == 1){
            echo('<p style="color:red">User with this email already exists</p>');
        }else {
            //create new user
            if($usertype == 'vendor'){
                $isVendor = 1;
            }else{
                $isVendor = 0;
            }
            $salt = lcg_value();
            $salt = intval($salt*10000);
            $concat = $password . $salt;
            $password = hash('sha384', $concat);


            //RSA
            $keyPair = generateKeypair();     // Create the keypair
            $privateKey = getPrivateKey($keyPair);
            $publicKey = getPublicKey($keyPair);


            //DB Register User
            $insertion_query = $con->prepare("INSERT INTO user(`name`, `email`, `password`, `isVendor`, `salt`, `privateKey`, `publicKey`) VALUES (?,?,?,?,?,?,?)");
            $insertion_query->bind_param('sssiiss', $name, $username, $password, $isVendor, $salt, $privateKey, $publicKey);
            $insertion_query->execute();

            if ($insertion_query->affected_rows != 1) {
                echo('<p style="color:red">Error creating user</p>');
            } else {
                $createdUserId = mysqli_insert_id($con);
                $_SESSION['loginsession'] = $createdUserId;

                // GENERATE RANDOM CSRF TOKEN + SET TIMEOUT FOR TOKEN
                try {
                    $_SESSION["token"] = bin2hex(random_bytes(32));
                    $_SESSION["token-expiry"] = time() + 3600;  //after 1h
                    console_log('token generated');
                } catch (Exception $e) {
                    console_log('token not generated');
                    echo "token not generated";
                }

                header('location: landingPage.php');
            }

        }
    }
    }

}

function validatePassword($password){

    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
        echo('<p style="color:red">Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.</p>');
        return false;
    }else{
        return true;
    }
}

$con->close();
?>



<!--HTML CODE-->

<!DOCTYPE html>
<html lang="en-us">
<?php $title = 'Shop: Register'; include('head.php') ?>
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