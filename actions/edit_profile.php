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

//FIXME: Show info to user
switch ($type) {
    case 'name':
        updateName($id, $value);
        break;
    case 'gender':
        updateGender($id, $value);
        break;
    case 'password':
        $old_password = htmlspecialchars($_POST['old_password']);
        $new_password = htmlspecialchars($_POST['new_password']);
        $confirm_password = htmlspecialchars($_POST['confirm_password']);

        if ($new_password === $confirm_password)
            updatePassword($id, $old_password, $new_password);
        break;
    case 'email':
        updateEmail($id, $value);
        break;
    case 'dob':
        updateDateOfBirth($id, $value);
        break;
    default:
        header('HTTP/1.0 403 Forbidden');
        header('Location: ../pages/index.php?page=403.html');
        die();
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
