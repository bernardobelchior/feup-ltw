<?php
include_once('../utils.php');
include_once('../database/restaurants.php');
include_once('../database/users.php');
session_start(['cookie_httponly' => true]);

// Check if the user comes from a valid page.
if ($_SESSION['token'] !== $_POST['token']) {
    header('HTTP/1.0 403 Forbidden');
    header('Location: ../pages/index.php?page=403.html');
    die();
}

$reviewId = htmlspecialchars($_POST['review-id']);

if (!groupIdHasPermissions($_SESSION['groupId'], 'ADD_REPLY')) {
    echo 'You do not have permission to reply to this review.';
    header('Location: ../pages/index.php?page=restaurant_profile.php&id=' . $_SESSION['restaurantId']);
    die();
}

$reply = htmlspecialchars($_POST['reply']);

addReply($reviewId, $_SESSION['userId'], $reply);

header('Location: ../pages/index.php?page=restaurant_profile.php&id=' . $_SESSION['restaurantId']);
die();
