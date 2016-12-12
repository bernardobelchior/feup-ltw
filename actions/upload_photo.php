<?php
session_start(['cookie_httponly' => true]);

include_once('../utils.php');
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
$picturePath = 'profile_pictures/' . $id . '.' . $extension;

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
