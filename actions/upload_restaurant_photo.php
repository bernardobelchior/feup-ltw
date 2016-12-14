<?php
session_start(['cookie_httponly' => true]);

include_once('../utils/utils.php');
include_once('../database/restaurants.php');

// If the user didn't come from a valid page.
if ($_SESSION['token'] !== $_POST['token']) {
    header('HTTP/1.0 403 Forbidden');
    header('Location: ../pages/index.php?page=403.html');
    die();
}

$id = htmlspecialchars($_POST['restaurant_id']);

$_SESSION['token'] = generateRandomToken();

if (!file_exists('../restaurant_pictures/' . $id))
    mkdir('../restaurant_pictures/' . $id, 0777, true);

$lastPicNr = getMaxPhotoName($id) + 1;
for ($i = 0; $i < count($_FILES['photos']['name']); $i++) {
    $picNumber = $i + $lastPicNr;
    $extension = pathinfo($_FILES['photos']['name'][$i], PATHINFO_EXTENSION);
    $picturePath = 'restaurant_pictures/' . $id . '/' . $picNumber . '.' . $extension;
    if (move_uploaded_file($_FILES['photos']['tmp_name'][$i], '../' . $picturePath))
        addPhoto($id, $picturePath);
}

$_SESSION['token'] = generateRandomToken();
header('Location: ../pages/index.php?page=edit_restaurant.php&id=' . $id);
die();
