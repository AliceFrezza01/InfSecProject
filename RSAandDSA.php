<?php
/**
 * Creates RSA KeyPair
 * different config settings necessary for Windows and MAC
 * returns private and public key
 */

/**
 * configures according to OS, WIN or MAC
 * @return array $config settings
 */
function opensslConfig(){
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        $config = array(
            "config" => "C:/xampp/php/extras/openssl/openssl.cnf",
            'digest_alg' => 'sha256',
            'private_key_bits' => 2048,
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
        );
    } else {
        $config = array(
            'digest_alg' => 'sha256',
            'private_key_bits' => 2048,
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
        );
    }
    return $config;
}

/**
 * generate KeyPair
 * @return false|resource
 */
function generateKeypair(){
    $config = opensslConfig();
    return $keyPair=openssl_pkey_new($config);     // Create the keypair
}


/**
 * get privateKey
 * @param $keyPair Object, which holds both keys
 * @return $privateKey
 */
function getPrivateKey($keyPair){
    $config = opensslConfig();
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        openssl_pkey_export($keyPair, $privateKey, NULL, $config);
    } else {
        openssl_pkey_export($keyPair, $privateKey);
    }
    return $privateKey;
}


/**
 * get publicKey
 * @param $keyPair Object, which holds both keys
 * @return $publicKey
 */
function getPublicKey($keyPair){
    $publicKey=openssl_pkey_get_details($keyPair);
    return $publicKey=$publicKey["key"];
}





/**
 * Creates and validates DSA
 */



/**
 * creates Digital Signature using DSA
 * @param $privateKey hashedKey provided by logged in user
 * @param string $signatureMessage provided by developer, in this case "rightful purchase"
 * @return string $signature, which is encoded
 */
function createSignature($privateKey, $signatureMessage = "rightful purchase"){
    openssl_sign($signatureMessage, $signature, $privateKey, OPENSSL_ALGO_SHA256);
    return $castSignature = base64_encode($signature);
}


/**
 * validates signature
 * @param $signature hashedKey stored with each purchase
 * @param $publicKey hashedKey by user who encoded the signature
 * @param string $signatureMessage provided by developer, in this case "rightful purchase"
 * @return string $verifiedPurchase, which shows whether the purchase has a valid signature or not
 */
function validateSignature($signature, $publicKey, $signatureMessage = "rightful purchase"){
    $decodeSignature = base64_decode($signature);

    if ($decodeSignature == null){
        $verifiedPurchase = "no signature given";
    }
    else {
        $verification = openssl_verify($signatureMessage, $decodeSignature, $publicKey, "sha256WithRSAEncryption");
        if ($verification == 1){
            $verifiedPurchase = "valid digital Signature";
        }
        else {
            $verifiedPurchase = "tampered signature";
        }
    }
    return $verifiedPurchase;
}




?>