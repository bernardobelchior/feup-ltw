<?php
include_once('../database/users.php');
include_once('../utils.php');
session_start(['cookie_httponly' => true]);

// Check if the user came from the Sign Up page.
if ($_SESSION['signup-token'] !== $_POST['signup-token']) {
    header('HTTP/1.0 403 Forbidden');
    header('Location: ../pages/index.php?page=403.html');
    die();
}
$_SESSION['signup-token'] = generateRandomToken();

$username = htmlspecialchars($_POST['username']);
$password = htmlspecialchars($_POST['password']);
$password_repeat = htmlspecialchars($_POST['password-repeat']);
$email = htmlspecialchars($_POST['email']);
$name = htmlspecialchars($_POST['name']);

if ($username && $password && $password_repeat && $email && $name) {
    if (strlen($username) < 8) {
        $_SESSION['signup-error'] = 'A username needs to be at least 8 characters long.';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    }

    if (usernameExists($username)) {
        $_SESSION['signup-error'] = 'That username is already in use. Try a new one.';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    }

    if (strlen($password) < 7) {
        $_SESSION['signup-error'] = 'A password needs to be at least 7 characters long.';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    }

    if ($password !== $password_repeat) {
        $_SESSION['signup-error'] = 'The passwords provided do not match. Try again.';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    if (emailExists($email)) {
        $_SESSION['signup-error'] = 'That email is already in use. Use a different one.';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    }

    if (createUser($username, $password, $email, $name)[0] == 0) {
        unset($_SESSION['signup-error']);
        //Logs the user in.
        include_once('login.php');
    }
}
