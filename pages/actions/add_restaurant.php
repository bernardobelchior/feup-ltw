<?php
include_once('../../database/restaurants.php');
include_once('../utils/utils.php');

session_start(['cookie_httponly' => true]);

// Check if the user comes from the Add Restaurant page.
if ($_SESSION['token'] !== $_POST['token']) {
    header('HTTP/1.0 403 Not Found');
    header('Location: ../403.php');
    die();
}

$name = htmlspecialchars($_POST['name']);
$address = htmlspecialchars($_POST['address']);
$description = htmlspecialchars($_POST['description']);

//Sets the owner. If no owner is set, the owner is the user signed in.
$ownerId = isset($_SESSION['ownerId']) ? $_SESSION['ownerId'] : $_SESSION['userId'];

if (isset($name) && isset($address))
    addRestaurant($ownerId, $name, $address, $description);

$_SESSION['token'] = generate_random_token();
