<?php
include_once('../../database/users.php');

session_start();
$username = $_POST['username'];
$password = $_POST['password'];

if ($username && $password) {
    if (login($username, $password)) {
        initializeSession($username);
        header('Location: ../profile.php');
    } else
        header('Location: ../login.php');
}


function initializeSession($username) {
    $_SESSION['username'] = $username;
    $_SESSION['userId'] = getIdByUsername($username);
    $_SESSION['email'] = getUserField($_SESSION['userId'], 'Email');
    $_SESSION['name'] = getUserField($_SESSION['userId'], 'Name');
}
