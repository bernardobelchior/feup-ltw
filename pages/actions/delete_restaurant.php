<?php
session_start(['cookie_httponly' => true]);

include_once('../utils/utils.php');
include_once('../../database/restaurants.php');

// If the user didn't come from the edit restaurant page.
if ($_SESSION['token'] !== $_POST['token']) {
    header('HTTP/1.0 403 Forbidden');
    header('Location: ../403.php');
    die();
}

$_SESSION['token'] = generateRandomToken();
$restaurant_id = $_POST['restaurant_id'];

deleteRestaurant($restaurant_id);
deleteDir('../../restaurant_pictures/' . $restaurant_id . '/');

header('Location: ../index.php?page=profile.php&id=' . $_SESSION['userId']);
