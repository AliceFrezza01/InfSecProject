<?php
session_start();

//error detection
ini_set( 'error_reporting', E_ALL );
ini_set( 'display_errors', true );

//imports
include 'connect.php';


//count ALL Products!
$sqlAllProducts = "SELECT COUNT(*) AS count FROM product;";
$resultAllProducts = $con->query($sqlAllProducts);
$rowAP = mysqli_fetch_array($resultAllProducts);

$nrAllProducts = $rowAP['count'];


//get productID from Landing Page
$productID = $_GET['productId'];

//if invalid ProductID
if($productID == NULL || $nrAllProducts < $productID) {
    header('location: landingpage.php');
}


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

//BACK BUTTON
if(isset($_POST['back'])){
    header('location: landingpage.php');
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


$replyOfReviewID = 1;

//get ALL REVIEWS for ProductID
$sqlReview = "SELECT id, text, replyOfReviewID, userID FROM review WHERE productID = '$productID' ORDER BY id ASC, replyOfReviewID ";
$resultReview = $con->query($sqlReview);
$nrReviews = $resultReview->num_rows;

console_log('result NR: ' . $nrReviews);


// if not NULL -> get Last to determine whether vendor can respond or not.
//if($nrReviews != 0) {
//    $sqlLastReview = "SELECT replyOfReviewID, userID FROM review WHERE productID = '$productID' ORDER BY productID DESC LIMIT 1";
//    $resultLastReview = $con->query($sqlLastReview);
//    $rowLR = mysqli_fetch_array($resultLastReview);
//
//    $lastReply = $rowLR['replyOfReviewID'];
//    $lastUser = $rowLR['userID'];
//    console_log("lastreplyID = " . $lastReply . "lastUSerID = " .$lastUser);
//}


//write Review
if(isset($_POST['writeReview'])){
    $text = input($_POST['reviewText']);
    $replyOfReviewID = input($_POST['currentReviewID']) + 1;

    $sqlwriteReview = "INSERT INTO review (`productID`, `userID`, `text`, `replyOfReviewID`) VALUES ('$productID', '$loggedInUserID', '$text', '$replyOfReviewID')";
    $result = $con->query($sqlwriteReview);
}


function inputFunction($currentReviewID){
    echo "<form action=\"\" method=\"post\">";
        echo "<input type='hidden' name='currentReviewID' value='$currentReviewID'/>";
        echo "<input required type=\"text\" name=\"reviewText\" placeholder=\"Review...\">";
        echo "<input type=\"submit\" name=\"writeReview\" value=\"WRITE REVIEW\"  class=\"button\">";
    echo "</form>";
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

    <body class="productInfo">
<!--    TODO TO BE REMOVED-->
        <?php if($isLoggedIn){ ?>
            <form action='' style="padding: 14px 16px;" method='post'>
                <input type="submit" name="logout" value="LOG OUT" class="button">
            </form>
        <?php } ?>
        <form action='' style="padding: 14px 16px;" method='post'>
            <input type="submit" name="back" value="BACK" class="button">
        </form>
<!--    DISPLAY PRODUCT-->
        <div style="padding: 14px 16px;">
            <h1 class="title1"> <?php echo $productName; ?> </h1>
            <div class="display-flex">
                <img class="imgProductInfo" src="<?php echo $productImgLink; ?>" alt="Product Picture" ><br>
                <div class="wrap-text">
                    Price: <?php echo $productPrice; ?> €<br>
                    Sold: <?php echo $productPurchasedCount; ?>x<br>
                    Seller: <?php echo $productCreatorName; ?><a href="chat.php?id=<?php echo $productCreatorID  ?>">Start Chat</a><br>
                    <?php if(!$isLoggedIn){ ?>
                        <p class="textPlain"> login to buy the product</p>
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
            <h2 class="title2"> Reviews </h2>

            <?php
                if($nrReviews != 0) {
                    $x = 0;
                    $lastReviewID = 0;
                    while ($x < $nrReviews) {
                        $rowRR = mysqli_fetch_array($resultReview);

                        if($rowRR['replyOfReviewID'] < $lastReviewID){
                            if (!$isProductOwner) {
                                echo "<p style=\"color: red\">". "C". inputFunction($lastReviewID). "</p><br/>";
                            }
                            else if($lastReviewID == $loggedInUserID) {
                                echo "<p style=\"color: red\">" . "V". inputFunction($lastReviewID). "</p><br/>";
                            }
                        }

                        if ($rowRR['replyOfReviewID'] == 0){
                            echo "<br/><p>" . "START User Review" . $rowRR['text'] . "</p><br/>";

                        }
                        else {
                            if($rowRR['replyOfReviewID'] != $loggedInUserID){
                                echo "<p style=\"text-indent:10px;\">" . "User Review " . $rowRR['text'] . "</p><br/>";
                            }
                            else {
                                echo "<p style=\"text-indent:10px;\">" . "Vendor Response " . $rowRR['text'] . "</p><br/>";
                            }
                        }
                        $x = $x +1;
                        $lastReviewID = $rowRR['replyOfReviewID'];
                    }

                    if (!$isProductOwner) {
                        echo "<p style=\"color: red\">" . "C". inputFunction($lastReviewID). "</p><br/>";
                    }
                    else if($lastReviewID == $loggedInUserID){
                        echo "<p style=\"color: red\">" ."V". inputFunction($lastReviewID) . "</p><br/>";
                    }

                }
                else {
                    echo "<p style=\"color: red\">" . "C". inputFunction(-1). "</p><br/>";
                }
            ?>

            <?php if(!$isLoggedIn){ ?>
                <p class="textPlain"> please log in to review the product</p>
                <a href="login.php">To login page</a>
            <?php } ?>

            <?php if(!$isProductOwner && $isLoggedIn){ ?>
                <p class="textPlain"> is customer -> can write review</p>
            <?php } ?>

            <?php if($isProductOwner && $isLoggedIn){ ?>
                <p class="textPlain" style="color: red"> is vendor -> can respond to reviews</p>
            <?php } ?>
        </div>
    </body>
</html>
