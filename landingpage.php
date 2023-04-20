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

    //function for the search button
    if (isset($_POST['search'])) {
        $lowerStringInserted = LOWER($_POST['toSearch']);
    }

    //function for the reset button
    if (isset($_POST['resetSearch'])) {
        $lowerStringInserted = "";
    }

    //sql query for retrieving all the products
    if ($lowerStringInserted==null && $lowerStringInserted=="")
        $search_result = $con->query("SELECT name, price, imgLink FROM PRODUCT");
    else 
        //it retrieves the product is their name is a substring of what the user searched for
        $search_result = $con->query("SELECT name, price, imgLink FROM PRODUCT WHERE LOWER(name) LIKE '%$lowerStringInserted%'");
    $nr_results = $search_result->num_rows;
    $rows_needed = ceil($nr_results/3);
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
                    border-color: black;
                }

                .container-fluid:hover {
                    background-color: #FDF5E6;
                }

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
                    height: 
                }

                .link_products {
                    text-decoration: none;
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
                <form method="post">
                    <input type="text" name="toSearch" placeholder="Search..">
                    <input type="submit" name="search" value="Search" />
                    <input type="submit" name="resetSearch" value="Reset" />                 
                </form>
            </div>
            <!-- ADD NEW PRODUCT -->
            <div style="margin-top: 25px">
                <button type="submit">Add new Product</button>
            </div>
        </div>
        <!-- PRODUCT MENU -->
        <div class="container text-center">
            <?php
                for ($x = 0; $x < $rows_needed; $x++) 
                {
                    echo "<div class='row'>";

                        for ($y = 0; $y<3; $y++) 
                        {
                            $row = mysqli_fetch_array($search_result);
                            if ($row!=null) {
                                echo "<div class='col'><a className=\"link_products\" href=\"#product\">";
                                    echo "<div class='container-fluid'>";
                                        echo "<b>" . $row['name'] . "</b><br/>";
                                        echo $row['price'] . "€";
                                        echo "<br/><img src='" . $row['imgLink'] . "' height=\"100\" />";
                                    echo "</div>";
                                echo "</a></div>";
                            }
                        }
                    echo "</div>";
                }
            ?>
            </div>
        </div>
    </body>
</html>