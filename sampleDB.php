<?php

//fills DB with sample Data
//TODO check if it works + add some more
include ('connect.php');

global $con;

//USERs
$con->query("TRUNCATE TABLE user");

$keyPair1 = generateKeypair();
$privateKey1 = getPrivateKey($keyPair1);
$publicKey1 = getPublicKey($keyPair1);

$keyPair2 = generateKeypair();
$privateKey2 = getPrivateKey($keyPair2);
$publicKey2 = getPublicKey($keyPair2);

// MARK = mark@gmail.com, psw_mark123! -> ID = 0
$con->query("INSERT INTO user(`name`, `email`, `password`, `isVendor`, `salt`, `privateKey`, `publicKey`) 
            VALUES ('Mark','mark@gmail.com','psw_mark123!',1, 3, '$privateKey1', '$publicKey1')");

// Joe = joe@gmail.com, psw_joe123! -> ID = 1
$con->query("INSERT INTO user(`name`, `email`, `password`, `isVendor`, `salt`, `privateKey`, `publicKey`) 
            VALUES ('Joe','joe@gmail.com','psw_joe123!',0, 2, '$privateKey2', '$publicKey2')");

//PRODUCTs
$con->query("TRUNCATE TABLE product");

//bicycle sold by MARK -> ID = 0
$con->query("INSERT INTO product(name, price, imgLink, creatorUserID) 
            VALUES ('race bikecycle', 250.50, 'https://images.unsplash.com/photo-1589556264800-08ae9e129a8c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80', 0)");

// PURCHASEs
$con->query("TRUNCATE TABLE purchasedby");

$signature1 = createSignature($privateKey1);
$validSignature = validateSignature($signature1, $publicKey1);

// bicycle bought by Joe
$con->query("INSERT INTO purchasedBy (`productID`, `userID`, `buyDate`, `signature`) 
            VALUES (0,1,'2023-04-25 15:30:00','$signature1')");

//REVIEWs
$con->query("TRUNCATE TABLE review");

// Joe asks about bicycle -> BulkID = 0
$con->query("INSERT INTO review(text, replyOfReviewID, userID, productID) 
            VALUES ('is this product new?', 0, 1, 0)");

//MESSAGEs
$con->query("TRUNCATE TABLE chatmessage");
