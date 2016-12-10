<?php

/** Generates a 16 byte token
 * @return string token.
 */
function generateRandomToken() {
    return bin2hex(openssl_random_pseudo_bytes(16));
}

/** Constructs the html for the restaurant's average.
 * @param $value float Average
 * @return string HTML for the average.
 */
function getStarsHTML($value) {
    if ($value === null || $value < 0)
        $value = 0;
    else if ($value > 5)
        $value = 5;

    $halfStars = intval($value * 2);

    $fullStars = intdiv($halfStars, 2);
    $halfStar = $halfStars % 2;

    $html = '';

    $i = 0;
    for (; $i < $fullStars; $i++) {
        $html = $html . '
            <i class="star fa fa-star" aria-hidden="true"></i>';
    }

    if ($halfStar) {
        $html = $html . '
            <i class="star fa fa-star-half-o" aria-hidden="true"></i>';
        $i++;
    }

    for (; $i < 5; $i++) {
        $html = $html . '
            <i class="star fa fa-star-o" aria-hidden="true"></i>';
    }

    return $html;
}