<?php
session_start();

//error detection
ini_set( 'error_reporting', E_ALL );
ini_set( 'display_errors', true );

//imports
include 'connect.php';

//test variables TODO delete afterwards -> pass variable from landing page
$productID = 2;

//DB Calls for Product
$sqlProduct = "SELECT name, price, imgLink, creatorUserID FROM product WHERE id = '$productID'";
$result = $con->query($sqlProduct);
$row = mysqli_fetch_array($result);

$productName = $row['name'];
$productPrice = $row['price'];
$productImgLink = $row['imgLink'];
$productCreatorID = $row['creatorUserID'];

console_log('Product Creator ID: ' . $productCreatorID);

//DB calls for Product Creator Details
$sqlCreator = "SELECT name, email FROM user WHERE id = '$productCreatorID'";
$resultCreator = $con->query($sqlCreator);
$rowC = mysqli_fetch_array($resultCreator);

$productCreatorName = $rowC['name'];

//DB calls for purchased Product
$sqlPurchase = "SELECT COUNT(productID) AS count FROM purchasedBy WHERE productID = '$productID'";
$resultPurchase = $con->query($sqlPurchase);
$rowPur = mysqli_fetch_array($resultPurchase);

$productPurchasedCount = $rowPur['count'];
console_log($productPurchasedCount);

//Verify if loggedInUser is Vendor of this product
$isProductOwner = false;
$isLoggedIn = false;

if(isset($_SESSION['loginsession'])){
    $loggedInUserID = $_SESSION['loginsession'];
    $isLoggedIn = true;
    console_log( 'Logged In User ID: '. $loggedInUserID);

    if($productCreatorID == $loggedInUserID)
        $isProductOwner = true;

}

//LOGOUT BUTTON -> only for testing purposes TODO delete this here
if (isset($_POST['logout'])) {
    session_destroy();
    $isLoggedIn = false;
}

//BUY PRODUCT BUTTON
if (isset($_POST['buyProduct'])) {
    $date = date('Y-m-d H:i:s');
    console_log($date);

    if($isLoggedIn){
        $sqlBuyProduct = "INSERT INTO purchasedBy (`productID`, `userID`, `buyDate`) VALUES ('$productID', '$loggedInUserID', '$date')";
        $result = $con->query($sqlBuyProduct);
        if(!$result) {
            ?>
            <script>
                window.alert("Purchase Failed");
            </script>
            <?php
        }
        else {
            ?>
            <script>
                window.alert("Product bought successfully");
            </script>
            <?php
        }
    }
    console_log('bought product');

}

$con->close();
?>



<!--HTML CODE-->



<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="UTF-8">
        <title>Product Info: <?php echo $productName; ?>  </title>
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="stylesheet" href="styles.css">
    </head>

    <body>
<!--    TODO TO BE REMOVED-->
        <?php if($isLoggedIn){ ?>
            <form action='' style="padding: 14px 16px;" method='post'>
                <input type="submit" name="logout" value="LOG OUT" class="button">
            </form>
        <?php } ?>
<!--    DISPLAY PRODUCT-->
        <div style="padding: 14px 16px;">
            <h1> <?php echo $productName; ?> </h1>
            <div class="display-flex">
                <img src="<?php echo $productImgLink; ?>" alt="Product Picture" ><br>
                <div class="wrap-text">
                    Price: <?php echo $productPrice; ?> €<br>
                    Sold: <?php echo $productPurchasedCount; ?>x<br>
                    Seller: <?php echo $productCreatorName; ?><a href="chat.php?id=<?php echo $productCreatorID  ?>">Start Chat</a><br>
                    <?php if(!$isLoggedIn){ ?>
                        <p> login to buy the product</p>
                        <a href="login.php">To login page</a>
                    <?php } ?>

                    <?php if(!$isProductOwner && $isLoggedIn){ ?>
                        <form action="" method="post">
                            <input type="submit" name="buyProduct" value="BUY PRODUCT" class="button">
                        </form>
                    <?php } ?>
                </div>
            </div>
        </div>
<!--    REVIEWS-->
        <div style="padding: 14px 16px;" class="reviews">
            <h2> Reviews </h2>
            <?php if(!$isLoggedIn){ ?>
                <p> please log in to review the product</p>
                <a href="login.php">To login page</a>
            <?php } ?>

            <?php if(!$isProductOwner && $isLoggedIn){ ?>
                <p> is customer -> can write review</p>
            <?php } ?>

            <?php if($isProductOwner && $isLoggedIn){ ?>
                <p style="color: red"> is vendor -> can respond to reviews</p>
            <?php } ?>
        </div>
    </body>
</html>
