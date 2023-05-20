<?php

ini_set( 'error_reporting', E_ALL );
ini_set( 'display_errors', true );

//RSA
$config = array(
    'digest_alg' => 'sha256',
    'private_key_bits' => 2048,
    'private_key_type' => OPENSSL_KEYTYPE_RSA,
);

// Create the keypair
$res=openssl_pkey_new($config);

// Get private key
openssl_pkey_export($res, $privateKey);

// Get public key
$publicKey=openssl_pkey_get_details($res);
$publicKey=$publicKey["key"];

echo "$privateKey";
echo "<br>";
echo "$publicKey";


$message = "Bought Product";

//encrypt using public key
openssl_public_encrypt($message, $encrypted, $publicKey);

//decrypt message using private key
openssl_private_decrypt($encrypted, $decrypted, $privateKey);

echo "<br>";
echo "$decrypted";

// RSA SELLER
// Create the keypair
$res1=openssl_pkey_new($config);


// Get private key
openssl_pkey_export($res1, $privateKey1);

// Get public key
$publicKey1=openssl_pkey_get_details($res1);
$publicKey1=$publicKey1["key"];


// RSA BUYER
// Create the keypair
$res2=openssl_pkey_new($config);

// Get private key
openssl_pkey_export($res2, $privateKey2);

// Get public key
$publicKey2=openssl_pkey_get_details($res2);
$publicKey2=$publicKey2["key"];

echo "<br>";
echo "<br>";



/**     DSA     **/

//data you want to sign
$data = 'my data - to be signed';


//create signature
openssl_sign($data, $signature, $privateKey2, OPENSSL_ALGO_SHA256);


echo "$signature";
echo "<br><br>";
$castSignature = base64_encode($signature);
echo "$castSignature"; //-> to DB -> FROM DB

$decodeSignature = base64_decode($castSignature);
echo "<br><br>";
echo "$decodeSignature";

if ($signature == $decodeSignature){
    echo "it's a match!";
}


//save for later
//file_put_contents('private_key.pem', $privateKey);
//file_put_contents('public_key.pem', $publicKey);
//file_put_contents('signature.dat', $signature);

//verify signature
$r = openssl_verify($data, $decodeSignature, $publicKey2, "sha256WithRSAEncryption");

echo "<br>";
echo "$r";
echo "<br>";

if($r == 1){
    echo "$data";
}
else {
    echo  "not ok";
}


//var_dump($r);


?>