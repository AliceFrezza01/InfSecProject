<?php
session_start();
?>
<?php
    include ('connect.php');
    include ('authentificationUser.php');

    global $con;
    global $user;

    //is the user is a buyer, it should not be able to add new products
    if ($user['isVendor']==0) {
        header('location: landingPage.php');
    }

    $con->close();
?>

<!DOCTYPE html>
<html lang="en-us">
<?php include('head.php') ?>
    <body>
        <!-- TOP MENU -->
        <?php include('menu.php') ?>
        <div class="headerHello">
            <div class="container">
                <h1>Add a new Product</h1>
            </div>
        </div>

        <!-- FORM -->
        <div class="container">
        <form class="formAddNewProduct" method='post'>
            <div class="form-group">
                <label for="inputEmail">Name product</label>
                <input type="text" class="form-control" name="nameproduct" placeholder="Enter the name of the product">
            </div>
            <div class="form-group">
                <label for="inputPrice">Price</label>
                <input type="text" class="form-control" name="priceproduct" placeholder="Enter the name of the product">
            </div>
            <div class="form-group">
                <label for="inputLink">Picture link</label>
                <input type="text" class="form-control" name="linkproduct" placeholder="Enter the name of the product">
            </div>
            <input type="submit" name="sendForm" value="Add Product" class="button">
        </form>
        </div>
    </body>
</html>
