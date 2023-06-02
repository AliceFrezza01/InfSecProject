<?php

/**
 * PRODUCT INFORMATION PAGE
 *
 * holds all the information such as Price, Description, Seller ecc. of a Product
 * allows to purchase a Product (Buy Product)
 * Reviews can be written or replied to
 * Seller can be directly contacted using the Chat function
 */


session_start();

//IMPORTS
include ('connect.php');
include ('authenticationUser.php');
include ('xssSanitation.php');


//GLOBAL VARIABLES
global $con;
global $user;


/**
 * Only allow for valid Product Pages
 * otherwise redirect to LandingPage
 */
//count ALL Products!
$sqlAllProducts = "SELECT COUNT(*) AS count FROM product;";
$resultAllProducts = $con->query($sqlAllProducts);
$rowAP = mysqli_fetch_array($resultAllProducts);

$nrAllProducts = $rowAP['count'];

//get productID from Landing Page
$productID = $_GET['productId'];

//if invalid ProductID -> LANDING PAGE
if(is_int($productID) && $productID != NULL && $nrAllProducts <= $productID) {
    header('location: landingPage.php');
}


/**
 * get Product Information from DB using ProductID passed from landingPage.php
 */
//DB Calls for Product
$sqlProduct = "SELECT name, price, imgLink, creatorUserID FROM product WHERE id =?";
$result = $con->prepare($sqlProduct);
$result->bind_param('i', $productID);
$result->execute();
$result = $result->get_result();
$row = $result->fetch_assoc();

$productName = $row['name'];
$productPrice = $row['price'];
$productImgLink = $row['imgLink'];
$productCreatorID = $row['creatorUserID'];

/**
 * get Seller Information using the CreatorsID
 */
//DB calls for Product Creator Details
$sqlCreator = "SELECT name, email FROM user WHERE id=?";
$resultCreator = $con->prepare($sqlCreator);
$resultCreator->bind_param('i', $productCreatorID);
$resultCreator->execute();
$resultCreator = $resultCreator->get_result();
$rowC = $resultCreator->fetch_assoc();

$productCreatorName = $rowC['name'];


/**
 * Count how often the Product has been purchased
 */
//DB calls for purchased Product
$sqlPurchase = "SELECT COUNT(productID) AS count FROM purchasedBy WHERE productID =?";
$resultPurchase = $con->prepare($sqlPurchase);
$resultPurchase->bind_param('i', $productID);
$resultPurchase->execute();
$resultPurchase = $resultPurchase->get_result();
$rowPur = $resultPurchase->fetch_assoc();

$productPurchasedCount = $rowPur['count'];


/**
 * Verify if the Logged in User is also the Seller of the Product
 * necessary to determine whether the logged in User can purchase the Product and reply or write reviews
 */
$isProductOwner = false;
$isLoggedIn = false;

if(isset($_SESSION['loginsession'])){
    $loggedInUserID = $_SESSION['loginsession'];
    $isLoggedIn = true;
    console_log( 'Logged In User ID: '. $loggedInUserID);

    if($productCreatorID == $loggedInUserID)
        $isProductOwner = true;
}

/**
 * get the Name and private RSA-Key of a User to be able to purchase a Product
 */
if(!$isProductOwner){
    $sqlLoggedIn = "SELECT name, privateKey FROM user WHERE id =?";
    $resultLoggedIn = $con->prepare($sqlLoggedIn);
    $resultLoggedIn->bind_param('i', $loggedInUserID);
    $resultLoggedIn->execute();
    $resultLoggedIn = $resultLoggedIn->get_result();
    $rowLI = $resultLoggedIn->fetch_assoc();

    $loggedInUserName = $rowLI["name"];
    $privateKey = $rowLI["privateKey"];
}


/**
 * buy product function triggered by clicking "BUY PRODUCT" Button
 * uses digital Signature to ensure the purchase is done by a valid user
 */
//BUY PRODUCT BUTTON
if (isset($_POST['buyProduct'])) {
    if($isLoggedIn){

        //Validate Session Token -> prevent XSRF
        $token = input($_POST['token']);

        if (verifyToken($token)) {
            $date = date('Y-m-d H:i:s');

            //Digital Signature Algorithm (=DSA)
            $signature = createSignature($privateKey);

            //send to DB
            $sqlBuyProduct = "INSERT INTO purchasedBy (`productID`, `userID`, `buyDate`, `signature`) VALUES (?,?,?,?)";
            $result = $con->prepare($sqlBuyProduct);
            $result->bind_param('iiss', $productID, $loggedInUserID, $date, $signature);
            $result->execute();

            //immediate response if the purchase was successful or not
            if($result->affected_rows != 1) {
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
        header("Refresh:0");
        }
        else {
            exit('invalid token');
        }
    }
}

/**
 * get all Reviews for the product, using ProductID
 */
$sqlReview = "SELECT id, text, replyOfReviewID, userID FROM review WHERE productID = ? ORDER BY replyOfReviewID DESC, id ";
$resultReview = $con->prepare($sqlReview);
$resultReview->bind_param('i', $productID);
$resultReview->execute();
$resultReview = $resultReview->get_result();
$nrReviews = $resultReview->num_rows;

/**
 * get the Reviewers User Names
 * stores them in an array where the arrays indexes matches their userIDs
 */
if($nrReviews > 0){
    $reviews = [];
    while ($row = $resultReview->fetch_assoc()) {
        $reviews[] = $row;
    }

    $ids = array_column($reviews, 'userID');
    $reviewerIds = implode(',', array_fill(0, count($ids), '?'));

    $reviewUsers = "SELECT name, id FROM user WHERE id IN ($reviewerIds)";
    $stmt = $con->prepare($reviewUsers);

    // bind the parameters
    $types = str_repeat('i', count($ids)); // 'i' represents an integer type
    $stmt->bind_param($types, ...$ids); // use the splat operator to unpack the array of IDs
    $stmt->execute();
    $resultAllUserNames = $stmt->get_result();


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


/**
 * post Review to DB, triggered by "WRITE REVIEW" Button in the inputFunction()
 */
if(isset($_POST['writeReview'])){

    $token = input($_POST['token']);

    if (verifyToken($token)) {
        try {
            $text = input(sanitation($_POST['reviewText'], "string", false));
        } catch (Exception $e) {
            echo "invalid input";
        }
        $replyOfReviewID = input($_POST['currentReviewID']);

        $sqlWriteReview = "INSERT INTO review (`productID`, `userID`, `text`, `replyOfReviewID`) VALUES (?,?,?,?)";
        $result = $con->prepare($sqlWriteReview);
        $result->bind_param('iisi', $productID, $loggedInUserID, $text, $replyOfReviewID);
        $result->execute();

        header("Refresh:0");
    }
}

/**
 * The Submit-Review Form
 * @param $currentReviewID Integer userID of logged in user
 * @param $buttonName String can be either "submit review" or "submit response", depending whether the logged in user is also the seller
 * @param $placeholder String which holds the user input text
 */
function inputFunction(int $currentReviewID, String $buttonName, String $placeholder){
    echo "<form action=\"\" method=\"post\" style=\"text-indent:30px;\">";
        echo "<input type='hidden' name='token' value='{$_SESSION['token']}'/>";
        echo "<input type='hidden' name='currentReviewID' value='$currentReviewID'/>";
        echo "<input required type=\"text\" name=\"reviewText\" placeholder=\"$placeholder\"  class=\"input-review\">";
        echo "<input type=\"submit\" name=\"writeReview\" value=\"$buttonName\"  class=\"button\">";
    echo "</form>";
}

/**
 * CHAT LINK to Seller or PLAIN TEXT in Reviews
 * determines the color of the Reviewers name as well as whether there is a link to the CHAT function or not
 * @param $loggedInUserID Integer userID of logged in user
 * @param $currentUserID Integer userID of user who wrote the Review/Response
 * @param $reviewerName String name of the user who wrote the Review/Response
 * @param $productCreatorID Integer userID of Seller
 */
function chatLink(int $loggedInUserID, int $currentUserID, String $reviewerName, int $productCreatorID){
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


<!--HTML-->
<!DOCTYPE html>
<html lang="en-us">
<!--HEADER-->
<?php $title = 'Shop: '. $productName; include('head.php') ?>
<!--BODY-->
    <body>
<!--    MENU BAR-->
     <?php include('menu.php') ?>
     <div class="productInfo">
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
                            <input type="hidden" name="token" value="<?=$_SESSION["token"]?>">
                            <input type="submit" name="buyProduct" value="BUY PRODUCT" class="button">
                        </form>
                    <?php } ?>
                </div>
            </div>
        </div>
<!--    DISPLAY REVIEWS-->
        <div style="padding: 14px 16px;" class="reviews">
            <h2 class="title2"> Reviews </h2>

            <?php
            mysqli_data_seek($resultReview, 0);     //resets fetched data pointer to 0

            $currentBulkID = -1;    //Bulk refers to a Set of Reviews which belong together, it consists of an initial Review with responses
            $rowRR = NULL;

            if($nrReviews != 0){
                $rowRR = $resultReview->fetch_assoc();
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
     </div>
    </body>
</html>
