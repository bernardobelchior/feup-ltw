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

$img = $_POST['src'];

deleteRestaurantPhoto($img);
unlink('../../' . $img);
