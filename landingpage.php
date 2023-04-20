<?php
session_start();
?>
<?php
    include ('connect.php');

    //check if user is authenticated else redirect him to the login
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

<!DOCTYPE html>
<html>
    <head>
        <title>Landing Page</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <style>
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

                .container-fluid {
                    border-style: solid;
                    border-width: 5px;
                }
                /* Style the search box inside the navigation bar */
                div input[type=text] {
                    padding: 6px;
                    border: none;
                    margin-top: 8px;
                    margin-right: 5px;
                    font-size: 17px;
                    border-style: solid;
                    border-width: 1px;
                }
                .header {
                    background-color: gray;
                }

                .col {
                    padding: 10px;
                }
        </style>
    </head>
    <body>
        <!-- TOP MENU -->
        <div class="topnav">
            <a class="active" href="#landingpage">Landing Page</a>
            <a href="#chat">Chat</a>
            <a href="#orders">Orders</a>
            <form action='' style="padding: 14px 16px;" method='post'>
                <input type="submit" name="logout" value="LOG OUT">
            </form>
        </div>
        <div class="header">
            <h1>Hello <b><?php echo $user['name'] ?></b></h1>
            <!-- SEARCH BAR -->
            <div>
                <input type="text" placeholder="Search..">
                <button type="submit">Search</button>
            </div>
            <!-- ADD NEW PRODUCT -->
            <div style="margin-top: 25px">
                <button type="submit">Add new Product</button>
            </div>
        </div>
        <!-- PRODUCT MENU -->
        <div class="container text-center">
            <div class="row">
                <div class="col">
                    <div class="container-fluid">
                        product <br/>
                        bla bla bla
                    </div>  
                </div>
                <div class="col">
                    <div class="container-fluid">
                        product <br/>
                        bla bla bla
                    </div>  
                </div>
                <div class="col">
                    <div class="container-fluid">
                        product <br/>
                        bla bla bla
                    </div>  
                </div>
            </div>
        </div>
    </body>
</html>