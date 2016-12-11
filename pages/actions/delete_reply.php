<?php
include_once('../utils/utils.php');
include_once('../../database/restaurants.php');
include_once('../../database/users.php');
session_start(['cookie_httponly' => true]);

// Check if the user comes from a valid page.
if ($_SESSION['token'] !== $_POST['token'] && !groupIdHasPermissions($_SESSION['groupId'], 'REMOVE_ANY_REPLY') && $reply['ReplierID'] !== $_SESSION['userId']) {
    header('HTTP/1.0 403 Forbidden');
    header('Location: ../index.php?page=403.html');
    die();
}

$replyId = htmlspecialchars($_POST['reply-id']);

deleteReply($replyId);

header('Location: ../index.php?page=restaurant_profile.php&id=' . $_SESSION['restaurantId']);
die();
