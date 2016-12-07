<?php
session_start(['cookie_httponly' => true]);

include_once('../utils/utils.php');
include_once('../../database/users.php');

// If the user didn't come from a valid page.
if ($_SESSION['token'] !== $_POST['token']) {
    header('HTTP/1.0 403 Forbidden');
    header('Location: ../index.php?page=403.html');
    die();
}

$id = htmlspecialchars($_POST['id']);

$_SESSION['token'] = generateRandomToken();
$_POST['token'] = $_SESSION['token'];
if (!$_FILES['photo']['name']) {
    echo 'No file uploaded.';
    header('Location: ../index.php?page=edit_profile.php');
    die();
}

if ($_FILES['photo']['error']) {
    echo 'Error uploading';
    header('Location: ../index.php?page=edit_profile.php');
    die();
}

$extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
$picturePath = 'profile_pictures/' . $id . '.' . $extension;
move_uploaded_file($_FILES['photo']['tmp_name'], '../../' . $picturePath);
var_dump(changeProfilePicture($id, $picturePath));
var_dump(getUserField($id, 'Picture'));

die();
header('Location: ../index.php?page=profile.php&id=' . $id);
die();
