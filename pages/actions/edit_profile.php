<?php
session_start(['cookie_httponly' => true]);

include_once('../../database/users.php');
include_once('../utils/utils.php');

// If the user didn't come from the edit profile page.
if ($_SESSION['token'] !== $_POST['token']) {
    header('HTTP/1.0 403 Forbidden');
    header('Location: ../index.php?page=403.html');
    die();
}

$id = htmlspecialchars($_POST['profile_id']);

// Check for permissions or if the user is editing his/hers own profile.
if (!groupIdHasPermissions($_SESSION['groupId'], 'EDIT_ANY_PROFILE') &&
    $id !== $_SESSION['userId']
) {
    header('HTTP/1.0 404 Not Found');
    header('Location: ../index.php?page=404.html');
    die();
}

$type = $_POST['type'];
$value = $_POST['value'];

if($type == 'name')
  updateName($id, $value);
else if($type == 'gender')
  updateGender($id, $value);
  else if($type == 'email')
  updateEmail($id, $value);
else if($type == 'dob')
  updateDateOfBirth($id, $value);


die();
