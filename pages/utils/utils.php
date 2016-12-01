<?php

/** Generates a 16 byte token
 * @return string token.
 */
function generateRandomToken() {
   return bin2hex(openssl_random_pseudo_bytes(16));
}
