<?php
session_start(['cookie_httponly' => true]);

include_once('../utils/utils.php');
include_once('../database/users.php');
require_once('../utils/ImageManipulator.php');
include_once('../database/users.php');

// If the user didn't come from a valid page.
if ($_SESSION['token'] !== $_POST['token']) {
    header('HTTP/1.0 403 Forbidden');
    header('Location: ../pages/index.php?page=403.html');
    die();
}

$id = htmlspecialchars($_POST['id']);

$_SESSION['token'] = generateRandomToken();

if (!$_FILES['photo']['name']) {
    echo 'No file uploaded.';
    header('Location: ../pages/index.php?page=edit_profile.php');
    die();
}

if ($_FILES['photo']['error']) {
    echo 'Error uploading';
    header('Location: ../pages/index.php?page=edit_profile.php');
    die();
}

// Delete old picture. move_upload_file only overwrites the old picture if it has the same extension. This prevents
// having a lot of old pictures laying around.
$oldPicture = getUserField($id, 'Picture');
if ($oldPicture !== null)
    unlink('../' . $oldPicture);

// Save new photo
$extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);

$file = $_FILES['photo']['tmp_name'];
$manipulator = new ImageManipulator($file);
$width = $manipulator->getWidth();
$height = $manipulator->getHeight();
$centerX = round($width / 2);
$centerY = round($height / 2);

//for 256x256 img
$x1_256 = $centerX - 128;
$y1_256 = $centerY - 128;

$x2_256 = $centerX + 128;
$y2_256 = $centerY + 128;

$newImage = $manipulator->crop($x1_256, $y1_256, $x2_256, $y2_256);
$picturePath = 'profile_pictures/' . $id . '.' . $extension;
$manipulator->save('../' . $picturePath);
changeProfilePicture($id, $picturePath);

header('Location: ' . $_SERVER['HTTP_REFERER']);
die();
