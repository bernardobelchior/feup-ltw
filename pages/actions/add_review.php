<?php
include_once('../../database/restaurants.php');
include_once('../utils/utils.php');

session_start(['cookie_httponly' => true]);

// Check if the user comes from a valid page.
if ($_SESSION['token'] !== $_POST['token']) {
    header('HTTP/1.0 403 Not Found');
    header('Location: ../403.php');
    die();
}

$restaurantId = $_SESSION['restaurantId'];
$reviewerId = $_SESSION['userId'];
$title = $_POST['title'];
$score = $_POST['score'];
$comment = $_POST['comment'];

if($score >= 1 && score <= 5) {
    $result = addReview($restaurantId, $reviewerId, $title, $score, $comment);
} else {
    echo 'Score not valid.';
}

$_SESSION['token'] = generateRandomToken();
header('Location: ../restaurant_profile.php?id=' . $restaurantId);
die();
