<?php
session_start(['cookie_httponly' => true]);

include_once('../utils/utils.php');
include_once('../../database/users.php');
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

$extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);

$file =  $_FILES['photo']['tmp_name'];
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

$newNamePrefix = '256_';
$newImage = $manipulator->crop($x1_256, $y1_256, $x2_256, $y2_256);
$picturePath = 'profile_pictures/' . $newNamePrefix . $id.'.'.$extension;
$manipulator->save('../../' . $picturePath);


//$picturePath = 'profile_pictures/' . $id . '.' . $extension;
//move_uploaded_file($_FILES['photo']['tmp_name'], '../../' . $picturePath);
var_dump(changeProfilePicture($id, $picturePath));
var_dump(getUserField($id, 'Picture'));

$picturePath = 'profile_pictures/' . $newNamePrefix . $id . '.' . $extension;

// Delete old picture. move_upload_file only overwrites the old picture if it has the same extension. This prevents
// having a lot of old pictures laying around.

$oldPicture = getUserField($id, 'Picture');

if ($oldPicture !== null)
    unlink('../' . $oldPicture);


//If the file has been moved correctly, update the path in the database
if (move_uploaded_file($_FILES['photo']['tmp_name'], '../../' . $picturePath))
    changeProfilePicture($id, $picturePath);

header('Location: ../pages/index.php?page=profile.php&id=' . $id);
die();
