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

$restaurant_id = $_POST['restaurant_id'];
$type = $_POST['type'];
$value = $_POST['value'];

if($type == 'name')
  updateRestaurantName($restaurant_id, $value);
else if($type == 'address')
  updateRestaurantAddress($restaurant_id, $value);
else if($type == 'description')
  updateRestaurantDescription($restaurant_id, $value);
