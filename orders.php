<?php
session_start();
?>
<?php

    include ('connect.php');

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

    $vendorId = $_GET['vendorId'];

    $search_result = $con->query("SELECT * FROM product
                                    INNER JOIN purchasedby ON product.id=purchasedBy.productID WHERE product.creatorUserID=" . $vendorId);
    $nr_results = $search_result->num_rows;

    //product name, prezzo, date, name buyer

    echo $nr_results;
    echo $vendorId;

    $con->close();
?>

<!DOCTYPE html>
<html lang="en-us">
    <head>
        <title>Landing Page</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <style>
                /* Nav Bar Css */
                .topnav {
                background-color: #333;
                overflow: hidden;
                }

                .topnav a {
                float: left;
                color: #f2f2f2;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
                font-size: 17px;
                }

                .topnav a:hover {
                background-color: #ddd;
                color: black;
                }

                .topnav a.active {
                background-color: blue;
                color: white;
                }

                .header {
                    background-color: gray;
                }

        </style>
    </head>
    <body>
        <!-- TOP MENU -->
        <div class="topnav">
            <a class="active" href="landingpage.php">Landing Page</a>
            <a href="#chat">Chat</a>
            <a href="orders.php">Orders</a>
            <form action='' style="padding: 14px 16px;" method='post'>
                <input type="submit" name="logout" value="LOG OUT">
            </form>
        </div>
        <div class="header">
            <h1>Hello <b><?php echo $user['name'] ?></b></h1>
            </div>
        </div>
    </body>
</html>
