<?php
session_start(['cookie_httponly' => true]);

include_once('../database/users.php');
include_once('../utils/utils.php');
include_once('../utils/user_access_handler.php');


// Check if the user came from the Sign Up page.
if ($_SESSION['signup-token'] !== $_POST['signup-token']) {
    header('HTTP/1.0 403 Forbidden');
    header('Location: ../pages/index.php?page=403.html');
    die();
}


$username = htmlspecialchars($_POST['username']);
$password = htmlspecialchars($_POST['password']);
$password_repeat = htmlspecialchars($_POST['password-repeat']);
$email = htmlspecialchars($_POST['email']);
$name = htmlspecialchars($_POST['name']);

if (($ret = signupVerify($username, $password, $password_repeat, $email, $name)) === true) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    if (createUser($username, $hashed_password, $email, $name)[0] == 0) {
        $_SESSION['signup-token'] = generateRandomToken();
        login($username, $password);
        echo json_encode(true);
    }
} else
    echo json_encode($ret);


