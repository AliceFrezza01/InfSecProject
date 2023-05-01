<?php
    session_start();
?>
<?php

    include ('connect.php');
    include ('authentificationUser.php');

    $vendorId = $_GET['vendorId'];

    //is the user is a buyer, it should not be able to see its orders, since it has none
    if ($user['isVendor']==0) {
        header('location: landingPage.php');
    }

    //this query shows all the orders that the sellers received from buyers
    $search_result = $con->query("SELECT * FROM product
                        INNER JOIN purchasedby ON product.id=purchasedBy.productID 
                        WHERE product.creatorUserID=" . $vendorId . 
                        " ORDER BY buyerdate DESC;");

    $nr_results = $search_result->num_rows;
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
            <form action='' style="padding: 14px 16px;" method='post'>
                <input type="submit" name="logout" value="LOG OUT">
            </form>
        </div>
        <div class="headerHello">
            <h1>Hello <b><?php echo $user['name'] ?></b></h1>
            </div>
        </div>
        <!-- TABLE OF ORDERS -->
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
                       $row = mysqli_fetch_array($search_result);
   
                       //this query retrieves the email address of the buyer starting from its ID
                       $nameBuyer = $con->query("SELECT email FROM user WHERE id =" . $row['userID']);
                       $rowNameBuyer = mysqli_fetch_array($nameBuyer);

                       //contect of the table: name, price, buyerdate and email of the buyer
                       echo "<tr>";
                           echo "<th scope=\"row\">" . ($x + 1) . "</th>";
                           echo "<td class=\"orderTable\">" . $row['name'] . "</td>";
                           echo "<td class=\"orderTable\">" . $row['price'] . "</td>";
                           echo "<td class=\"orderTable\">" . $row['buyerdate'] . "</td>";
                           echo "<td class=\"orderTable\">" . $rowNameBuyer['email'] . "</td>";
                       echo "</tr>";
                    }
                }

                 $con->close();
                ?>
            </tbody>
        </table>
    </body>
</html>
