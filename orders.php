<?php
    session_start();
?>
<?php

    include ('connect.php');
    include ('authentificationUser.php');

    global $con;
    global $user;

    $vendorId = $_GET['vendorId'];

    //is the user is a buyer, it should not be able to see its orders, since it has none
    if ($user['isVendor']==0) {
        header('location: landingPage.php');
    }

    //this query shows all the orders that the sellers received from buyers
    $search_result = $con->prepare("SELECT * FROM product
                        INNER JOIN purchasedby ON product.id=purchasedBy.productID 
                        WHERE product.creatorUserID=? ORDER BY buyDate DESC;");
    $search_result->bind_param('i', $userid);
    $search_result->execute();
    $result = $search_result->get_result();

    $nr_results = $result->num_rows;
?>

<!DOCTYPE html>
<html lang="en-us">
<?php include('head.php') ?>
    <body>
        <!-- TOP MENU -->
        <?php include('menu.php') ?>
        <div class="headerHello">
            <div class="container">
            <h1>Orders</h1>
            </div>
        </div>
        <!-- TABLE OF ORDERS -->
        <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <!-- header of the table -->
                    <th scope="col" class="orderTable">#</th>
                    <th scope="col" class="orderTable">Product Name</th>
                    <th scope="col" class="orderTable">Price</th>
                    <th scope="col" class="orderTable">Date of Purchacee</th>
                    <th scope="col" class="orderTable">Email of Buyer</th>
                </tr>
            </thead>
            <tbody>
                <?php
                 if ($nr_results==0)
                    echo "<h3>Noone has purchased your items yet. Come back later.</h3>";
                 else {
                    echo "<h3 class=\"orderTable\">List of your orders:</h3>";
                    for ($x = 0; $x < $nr_results; $x++) 
                    {
                        $row = $result->fetch_assoc();
   
                       //this query retrieves the email address of the buyer starting from its ID
                       $nameBuyer = $con->prepare("SELECT email FROM user WHERE id =?");
                       $nameBuyer->bind_param('i', $row['userID']);
                       $nameBuyer->execute();
                       $nameBuyer = $nameBuyer->get_result();
                       $rowNameBuyer = $nameBuyer->fetch_assoc();

                       //contect of the table: name, price, buyerdate and email of the buyer
                       echo "<tr>";
                           echo "<th scope=\"row\">" . ($x + 1) . "</th>";
                           echo "<td class=\"orderTable\">" . $row['name'] . "</td>";
                           echo "<td class=\"orderTable\">" . $row['price'] . "</td>";
                           echo "<td class=\"orderTable\">" . $row['buyDate'] . "</td>";
                           echo "<td class=\"orderTable\">" . $rowNameBuyer['email'] . "</td>";
                       echo "</tr>";
                    }
                }

                 $con->close();
                ?>
            </tbody>
        </table>
        </div>
    </body>
</html>
