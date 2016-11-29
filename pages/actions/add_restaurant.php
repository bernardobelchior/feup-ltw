<?php
include_once('../database/restaurants.php');

$name = $_POST['name'];
$address = $_POST['address'];
$description = $_POST['description'];
$ownerId = $_POST['ownerId'];
unset($_POST['ownerId']);

if (isset($name) && isset($address))
    addRestaurant($ownerId, $name, $address, $description);


