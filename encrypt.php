<?php

$key="Your Key! Dont Lose It. Or you will not be able to decrypt encrypted string";
$plaintext="The quick brown fox jump over a lazy dev";

/********** */
echo "<h3>using openssl_encrypt with AES-128-CBC chiper, sha256 binary hash, and base64_encode</h3><br>";
echo "Encripted text: ".encriptwithhash($plaintext, $key);
echo "<br>";
echo "Decripted text: ".decriptwithhash(encriptwithhash($plaintext, $key),$key);
echo "<br><hr>";
echo "<h3>using openssl_encrypt AES-128-CBC chiper + base64_encode</h3><br>";
echo "Encripted text: ".encript($plaintext, $key);
echo "<br>";
echo "Decripted text: ".decript(encript($plaintext, $key),$key);
/********** */



// using openssl_encrypt with AES-128-CBC chiper, sha256 binary hash, and base64_encode
function encriptwithhash($plaintext, $key){
    $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
    $iv = openssl_random_pseudo_bytes($ivlen);
    $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
    $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
    $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
    return $ciphertext;
}

function decriptwithhash($ciphertext, $key){
    $c = base64_decode($ciphertext);
    $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
    $iv = substr($c, 0, $ivlen);
    $hmac = substr($c, $ivlen, $sha2len=32);
    $ciphertext_raw = substr($c, $ivlen+$sha2len);
    $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
    $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
    if (hash_equals($hmac, $calcmac))//PHP 5.6+ timing attack safe comparison
    {
        return $original_plaintext."\n";
    }
}

// only using openssl_encrypt AES-128-CBC chiper + base64_encode, just a little bit shorter result, better for numeric input as it much shorter in db
function encript($plaintext, $key){
    $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
    $iv = openssl_random_pseudo_bytes($ivlen);
    $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
    $ciphertext = base64_encode($iv.$ciphertext_raw );
    return $ciphertext;
}
function decript($ciphertext, $key){
    $c = base64_decode($ciphertext);
    $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
    $iv = substr($c, 0, $ivlen);    
    $ciphertext_raw = substr($c, $ivlen);
    $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
    return $original_plaintext."\n";   
}
?>
