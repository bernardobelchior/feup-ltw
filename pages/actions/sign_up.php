<?php
include_once('../../database/users.php');
include_once('../utils/utils.php');
session_start(['cookie_httponly' => true]);

var_dump($_SESSION['token']);
var_dump($_POST['token']);

// Check if the user came from the Sign Up page.
if($_SESSION['token'] !== $_POST['token']) {
    header('HTTP/1.0 403 Not Found');
    header('Location: ../403.php');
    die();
}

$username = htmlspecialchars($_POST['username']);
$password = htmlspecialchars($_POST['password']);
$password_repeat = htmlspecialchars($_POST['password-repeat']);
$email = htmlspecialchars($_POST['email']);
$name = htmlspecialchars($_POST['name']);
$groupID = 3; //Regular user group ID
$dateOfBirth;
$gender;
$picture;


if ($username && $password && $password_repeat && $email && $groupID && $name) {
    if (strlen($username) < 8) {
        echo 'A username needs to be at least 8 characters long.';
        return;
    }

    if (usernameExists($username)) {
        echo 'That username is already in use. Try a new one.';
        return;
    }

    if (strlen($password) < 7) {
        echo 'A password needs to be at least 7 characters long.';
        return;
    }

    if ($password !== $password_repeat) {
        echo 'The passwords provided do not match. Try again.';
        return;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    if (emailExists($email)) {
        echo 'That email is already in use. Use a different one.';
        return;
    }

    $_SESSION['token'] = generateRandomToken();
    if(createUser($username, $password, $email, $name, $groupID, $dateOfBirth, $gender, $picture) == 0) {
        //Logs the user in.
        $_POST['token'] = $_SESSION['token'];
        include_once('login.php');
    }
}
