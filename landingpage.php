<?php
    session_start();
?>
<?php

    include ('connect.php');
    include ('authentificationUser.php');
    include ('xssSanitation.php');

    global $con;
    global $user;
    global $userid;

    $lowerStringInserted = "";

    //function for the search button
    if (isset($_POST['search'])) {          //TODO does it need CSRF prevention?
        $lowerStringInserted = sanitation($_POST['toSearch'], 50, "string");
        echo $lowerStringInserted;
    }

    //function for the reset button
    if (isset($_POST['resetSearch'])) {     //TODO does it need CSRF prevention?
        $lowerStringInserted = "";
    }

    //this query returns the list of products with a name similar at the one inserted by the user in the search bar
    $searchString = "%$lowerStringInserted%";
    $search_result = $con->prepare("SELECT id, name, price, imgLink FROM PRODUCT WHERE LOWER(name) LIKE ?");
    $search_result->bind_param('s', $searchString);
    $search_result->execute();
    $result = $search_result->get_result();
        
    $nr_results = $result->num_rows;
    $rows_needed = ceil($nr_results/3);

    $con->close();
?>

<!DOCTYPE html>
<html lang="en-us">
    <?php include('head.php') ?>
    <body>
       <?php include('menu.php') ?>
        <div class="headerHello">
            <div class="container">
            <h1>Hello <b><?php echo $user['name'] ?></b></h1>
                <!-- ADD NEW PRODUCT -->
                <?php
                if ($user['isVendor']==1) {
                    echo "<div style=\"margin-top: 25px\">";
                    echo "<a href=\"productNew.php\" class=\"button \">Add new Product</a>";
                    echo "</div>";
                }
                ?>
            <!-- SEARCH BAR -->
            <div>
                <form method="post">
                    <input type="text" name="toSearch" placeholder="Search..">
                    <input class="button" type="submit" name="search" value="Search" />
                    <input class="button" type="submit" name="resetSearch" value="Reset" />
                </form>
            </div>
            <?php
            if ($lowerStringInserted!="")
                echo "<p>You searched " . $lowerStringInserted . "</p>";
            ?>
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
                            $row = $result->fetch_assoc();
                            if ($row!=null) {
                                echo "<div class='col'>";
                                //sending the Id of the product through the link to productInfo
                                echo "<a href=\"productInfo.php?productId=" . $row['id'] . "\">";
                                    echo "<div class='container-fluid'>";
                                        echo "<b>" . $row['name'] . "</b><br/>";
                                        echo $row['price'] . "€";
                                        echo "<br/><img alt='\"Product\"' src='" . $row['imgLink'] . "' height=\"100\" />";
                                    echo "</div>";
                                echo "</a></div>";

                            }
                        }
                    echo "</div>";
                }
            ?>
        </div>
    </body>
</html>
