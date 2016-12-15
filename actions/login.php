<?php
include_once('../database/users.php');
include_once('../utils/user_access_handler.php');
session_start(['cookie_httponly' => true]);

$username = htmlspecialchars($_POST['username']);
$password = htmlspecialchars($_POST['password']);

if ($username && $password) {
    login($username, $password);
    header('Location: ../pages/index.php?page=profile.php&id=' . $_SESSION['userId']);
    die();
} else
    echo 'The username and the password do not match.';
