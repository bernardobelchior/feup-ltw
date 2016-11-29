<?php
include_once('../../database/restaurants.php');
session_start();

$name = $_POST['name'];
$address = $_POST['address'];
$description = $_POST['description'];
$ownerId = $_SESSION['ownerId'];
//FIXME: Bug with insert
if (isset($name) && isset($address))
    var_dump(addRestaurant($ownerId, $name, $address, $description));

var_dump($name);
var_dump($address);
var_dump($description);
var_dump($ownerId);

unset($_SESSION['ownerId']);
