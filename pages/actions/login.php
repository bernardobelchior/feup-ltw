<?php
include_once('../../database/users.php');

session_start();
$username = $_POST['username'];
$password = $_POST['password'];

if ($username && $password) {
    if (login($username, $password)) {
        $_SESSION['username'] = $username;
        $_SESSION['name'] = getUserField($username, 'Name');
        header('Location: ../profile.php');
    } else
        header('Location: ../login.php');
}
