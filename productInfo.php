<?php
session_start();

//error detection
ini_set( 'error_reporting', E_ALL );
ini_set( 'display_errors', true );

//imports
include 'connect.php';

global $con;

//count ALL Products!
$sqlAllProducts = "SELECT COUNT(*) AS count FROM product;";
$resultAllProducts = $con->query($sqlAllProducts);
$rowAP = mysqli_fetch_array($resultAllProducts);

$nrAllProducts = $rowAP['count'];


//get productID from Landing Page
$productID = $_GET['productId'];

//if invalid ProductID -> LANDINGPAGE
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

//get Name of logged in user
$sqlLoggedIn = "SELECT name FROM user WHERE id = '$loggedInUserID'";
$resultLoggedIn = $con->query($sqlLoggedIn);
$rowLI = mysqli_fetch_array($resultLoggedIn);

$loggedInUserName = $rowLI['name'];

//LOGOUT BUTTON -> only for testing purposes TODO delete this here
if (isset($_POST['logout'])) {
    session_destroy();
    $isLoggedIn = false;
    header('location: login.php');
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
    header("Refresh:0");
}


//get ALL REVIEWS for ProductID
$sqlReview = "SELECT id, text, replyOfReviewID, userID FROM review WHERE productID = '$productID' ORDER BY replyOfReviewID DESC, id ";
$resultReview = $con->query($sqlReview);
$nrReviews = $resultReview->num_rows;

console_log('result NR: ' . $nrReviews); //TODO delete when done


//get Reviewer User Names
if($nrReviews > 0){
    $reviews = [];
    while ($row = $resultReview->fetch_assoc()) {
        $reviews[] = $row;
    }

    $ids = array_column($reviews, 'userID');
    $reviewerIds = implode(',', $ids);

    $reviewUsers = "SELECT name, id FROM user where id in ($reviewerIds)";
    $resultAllUserNames = $con->query($reviewUsers);

    $allUserIds = [];
    $allUserNames = [];
    while ($row = $resultAllUserNames->fetch_assoc()) {
        $allUserIds[] = $row['id'];
        $allUserNames[] = $row['name'];
    }

    mysqli_data_seek($resultAllUserNames, 0);


    $positionArray = [];
    $positionNamesArray = [];

    $j = 1;
    $p = 0;
    for($i = 0; $i < count($allUserIds); $i++){
        for(;$j <= $allUserIds[count($allUserIds)-1]; $j++){
            if($allUserIds[$i] == $j){
                $positionArray[$p] = $i;
                $positionNamesArray[$p] = $allUserNames[$i];
                $j++;
                $p++;
                break;
            }
            else {
                $positionArray[$j] = 0;
                $positionNamesArray[$j-1] = 'null';
                $p++;
            }
        }
    }
}



//write Review
if(isset($_POST['writeReview'])){
    $text = input($_POST['reviewText']);
    $replyOfReviewID = input($_POST['currentReviewID']);

    $sqlWriteReview = "INSERT INTO review (`productID`, `userID`, `text`, `replyOfReviewID`) VALUES ('$productID', '$loggedInUserID', '$text', '$replyOfReviewID')";
    $result = $con->query($sqlWriteReview);

    header("Refresh:0");
}


// submit review FUNCTION
function inputFunction($currentReviewID, $buttonName, $placeholder){
    echo "<form action=\"\" method=\"post\" style=\"text-indent:30px;\">";
        echo "<input type='hidden' name='currentReviewID' value='$currentReviewID'/>";
        echo "<input required type=\"text\" name=\"reviewText\" placeholder=\"$placeholder\"  class=\"input-review\">";
        echo "<input type=\"submit\" name=\"writeReview\" value=\"$buttonName\"  class=\"button\">";
    echo "</form>";
}

//chat link or Text
function chatLink($loggedInUserID, $currentUserID, $reviewerName, $productCreatorID){
    $setColor = NULL ;

    if ($currentUserID == $productCreatorID){
        $setColor = '#8282f1';
    }
    else {
        $setColor = '#669986';
    }

    if ($loggedInUserID == $currentUserID){
        echo "$reviewerName";
    }
    else {
        echo "<a style='color: $setColor' href='chat.php?id=$currentUserID'>" . "$reviewerName" ."</a>";
    }
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
            <h1> Welcome <?php echo $loggedInUserName; ?>! </h1>
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
                    Seller: <?php echo $productCreatorName; ?>

                    <?php if(!$isProductOwner){ ?>
                    <a href="chat.php?id=<?php echo $productCreatorID  ?>">Start Chat</a><br>
                    <?php } ?>

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

            mysqli_data_seek($resultReview, 0);     //resets fetched data pointer to 0

            $currentBulkID = -1;
            $rowRR = NULL;

            if($nrReviews != 0){
                $rowRR = mysqli_fetch_array($resultReview);
                $currentBulkID = $rowRR['replyOfReviewID'];
            }


            //NEW REVIEW
            if(!$isProductOwner){
                echo "<p style=\"color: red\">" . inputFunction($currentBulkID+1, 'Submit Review', 'Add New Review...'). "</p><br/>";
            }

            //DISPLAY ALL REVIEWS
            $x = 0;
            while($x < $nrReviews){

                //get Review User Name
                $reviewerName = $positionNamesArray[$rowRR['userID']-1];
                console_log( $x . " name: " . $reviewerName);

                //DISPLAY BULK of REVIEWS
                if($currentBulkID == $rowRR['replyOfReviewID']){
                    if($productCreatorID != $rowRR['userID']){
                        // Display 1st Review
                        if($x == 0){
                            echo "<span class='review-indent'>" . "Review by User " . "<i class='reviewer-name'>";
                            chatLink($loggedInUserID, $rowRR['userID'], $reviewerName, $productCreatorID);
                            echo "</i> : " . "</span>";
                            echo "<div class='review-mix' >" . $rowRR['text'] . "</div>";
                        }
                        //display next reviews
                        else{
                            echo "<div class='review-indent' >" . "<i class='reviewer-name'>";
                            chatLink($loggedInUserID, $rowRR['userID'], $reviewerName, $productCreatorID);
                            echo "</i> : ";
                            echo "<span class='review-text'>" . $rowRR['text'] . "</span> " ."</div>";
                        }
                    }
                    //Display vendor response
                    else {
                        echo "<div class='review-indent' >". "Vendor " . "<i class='vendor-name'>";
                        chatLink($loggedInUserID, $rowRR['userID'], $reviewerName, $productCreatorID);
                        echo "</i> : " ."<span class='review-text'>" . $rowRR['text'] . "</span> " ."</div>";
                    }
                }
                else{
                    //RESPOND to Review
                    if(!$isProductOwner){
                        echo "<p>" . inputFunction($currentBulkID, 'Submit Review', 'Respond to Review...'). "</p>";
                    }
                    else {
                        echo "<p>" . inputFunction($currentBulkID, 'Submit Response', 'Respond to Review...'). "</p>";
                    }
                    //DISPLAY NEW BULK
                    echo "<span class='review-indent'>" . "Review by User " . "<i class='reviewer-name'>";
                    chatLink($loggedInUserID, $rowRR['userID'], $reviewerName, $productCreatorID);
                    echo "</i> : " . "</span> ";
                    echo "<div class='review-mix' >" . $rowRR['text'] . "</div>";

                    $currentBulkID--;
                }
                $x++;
                $rowRR = mysqli_fetch_array($resultReview);
            }
            //RESPOND to last Review
            if ($nrReviews > 0){
                if(!$isProductOwner){
                    echo "<p>" . inputFunction($currentBulkID, 'Submit Review', 'Respond to Review...'). "</p>";
                }
                else {
                    echo "<p>" . inputFunction($currentBulkID, 'Submit Response', 'Respond to Review...'). "</p>";
                }
            }

            ?>

        </div>
    </body>
</html>
