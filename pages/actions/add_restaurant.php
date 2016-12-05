<?php
include_once('../../database/restaurants.php');
include_once('../utils/utils.php');

session_start(['cookie_httponly' => true]);

// Check if the user comes from the Add Restaurant page.
if ($_SESSION['token'] !== $_POST['token']) {
    header('HTTP/1.0 403 Forbidden');
    header('Location: ../403.php');
    die();
}

$name = htmlspecialchars($_POST['name']);
$address = htmlspecialchars($_POST['address']);
$description = htmlspecialchars($_POST['description']);

//Sets the owner. If no owner is set, the owner is the user signed in.
$ownerId = isset($_SESSION['ownerId']) ? $_SESSION['ownerId'] : $_SESSION['userId'];

if (isset($name) && isset($address)) {
    $result = addRestaurant($ownerId, $name, $address, $description);

    if($result[1] === 0) //If an error ocurred, print the error message.
        echo $result[2];
    else {
        header('Location: ../profile.php?id=' . $_SESSION['userId']);
        die();
    }
}

$_SESSION['token'] = generateRandomToken();
