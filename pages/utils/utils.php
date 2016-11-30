<?php

/** Generates a 16 byte token
 * @return string token.
 */
function generateRandomToken() {
   return bin2hex(openssl_random_pseudo_bytes(16));
}

/** Goes to the page specified by path
 * @param $path
 * @param $httpCode
 */
function goToPage($path, $httpCode) {
    if(isset($httpCode)) {
        header('HTTP/1.0 403 Not Found');
    }
}