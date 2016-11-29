<?php
include_once('../database/restaurants.php');
$id = $_GET['id'];

if (!isset($id)) {
    header('HTTP/1.0 404 Not Found');
    header('Location: 404.php');
}


?>


