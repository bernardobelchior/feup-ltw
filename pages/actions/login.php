<?php

include_once('../../database/users.php');

$username = $_POST['username'];
$password = $_POST['password'];

if ($username && $password) {
    if (login($username, $password)) {
        session_start();
        $_SESSION['username'] = $username;
        header('Location: ../profile.php');
    } else
        header('Location: ../login.php');
}