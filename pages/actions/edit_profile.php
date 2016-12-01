<?php
session_start(['cookie_httponly' => true]);

include_once('../../database/users.php');
include_once('../utils/utils.php');

// If the user didn't come from the edit profile page.
if ($_SESSION['update-token'] !== $_POST['update-token']) {
    header('HTTP/1.0 403 Not Found');
    header('Location: ../403.php');
    die();
}

$_SESSION['update-token'] = generateRandomToken();

$id = htmlspecialchars($_POST['id']);

// Check for permissions or if the user is editing his/hers own profile.
if (!groupIdHasPermissions($_SESSION['groupId'], 'EDIT_ANY_PROFILE') &&
    $id !== $_SESSION['userId']
) {
    header('HTTP/1.0 404 Not Found');
    header('Location: 404.php');
    die();
}

$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$date = htmlspecialchars($_POST['date']);
$gender = htmlspecialchars($_POST['gender']);
$picture;

if (updateUser($id, $name, $email, $date, $gender) == 0) {
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;
}

header('Location: ../profile.php?id=' . $id);
die();
