<?php
    session_start();
?>
<?php

    include ('connect.php');
    include ('authentificationUser.php');

    $lowerStringInserted = "";
    //function for the search button
    if (isset($_POST['search'])) {
        $lowerStringInserted = $_POST['toSearch'];
    }

    //function for the reset button
    if (isset($_POST['resetSearch'])) {
        $lowerStringInserted = "";
    }

    //this query returns the list of products with a name similar at the one inserted by the user in the search bar
    $search_result = $con->query("SELECT id, name, price, imgLink FROM PRODUCT WHERE LOWER(name) LIKE '%$lowerStringInserted%'");
    $nr_results = $search_result->num_rows;
    $rows_needed = ceil($nr_results/3);

    $con->close();
?>

<!DOCTYPE html>
<html lang="en-us">
    <head>
        <title>Landing Page</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </head>
    <body>
        <!-- TOP MENU -->
        <div class="topnav">
            <a class="active" href="landingpage.php">Landing Page</a>
            <a href="#chat">Chat</a>
            <?php
                if ($user['isVendor']==1) {
                    echo "<a href=\"orders.php?vendorId=<?php echo $userid ?>\">Orders</a>";
                }
            ?>
            <form style="padding: 14px 16px;" method='post'>
                <input type="submit" name="logout" value="LOG OUT">
            </form>
        </div>
        <div class="headerHello">
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
            <?php
                if ($user['isVendor']==1) {
                    echo "<div style=\"margin-top: 25px\">";
                        echo "<a href=\"productNew.php\" class=\"addnewproduct\">Add new Product</a>";
                    echo "</div>";
                }
            ?>
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
                                echo "<div class='col'>";
                                //sending the Id of the product through the link to productInfo
                                echo "<a href=\"productInfo.php?productId=" . $row['id'] . "\">";
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
