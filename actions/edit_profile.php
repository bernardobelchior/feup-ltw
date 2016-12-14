<?php
include_once('../database/users.php');
include_once('../utils/utils.php');

session_start(['cookie_httponly' => true]);
$id = htmlspecialchars($_POST['profile_id']);

// If the user didn't come from the edit profile page or does not have permission to edit the profile.
if ($_SESSION['token'] !== $_POST['token'] || (!groupIdHasPermissions($_SESSION['groupId'], 'EDIT_ANY_PROFILE') &&
        $id !== $_SESSION['userId'])
) {
    header('HTTP/1.0 403 Forbidden');
    header('Location: ../pages/index.php?page=403.html');
    die();
}

$type = htmlspecialchars($_POST['type']);
$value = htmlspecialchars($_POST['value']);


switch ($type) {

}

if ($type === 'name')
    updateName($id, $value);
else if ($type === 'gender')
    updateGender($id, $value);
else if ($type === 'email') {
    if (emailExists($value)) {
        header('HTTP/1.0 403 Forbidden'); //FIXME: show info to the user.
        exit;
    }
    updateEmail($id, $value);
} else if ($type === 'dob')
    updateDateOfBirth($id, $value);
else {
    header('HTTP/1.0 403 Forbidden');
    header('Location: ../pages/index.php?page=403.html');
    die();
}

