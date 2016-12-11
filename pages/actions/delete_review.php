<?php
include_once('../../database/restaurants.php');
include_once('../utils/utils.php');

session_start(['cookie_httponly' => true]);

// Check if the user comes from a valid page.
if ($_SESSION['token'] !== $_POST['token'] && !groupIdHasPermissions($_SESSION['groupId'], 'REMOVE_ANY_REVIEW') && $review['ReviewerID'] !== $_SESSION['userId']) {
    header('HTTP/1.0 403 Forbidden');
    header('Location: ../index.php?page=403.html');
    die();
}

$_SESSION['token'] = generateRandomToken();
$reviewId = htmlspecialchars($_POST['review-id']);

removeReview($reviewId);
header('Location: ../index.php?page=restaurant_profile.php&id=' . $_SESSION['restaurantId']);
die();
