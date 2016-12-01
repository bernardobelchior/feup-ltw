<?php
include_once('../../database/users.php');
session_start(['cookie_httponly' => true]);

$username = htmlspecialchars($_POST['username']);
$password = htmlspecialchars($_POST['password']);

if ($username && $password) {
    if (login($username, $password)) {
        initializeSession($username);
        header('Location: ../profile.php?id=' . $_SESSION['userId']);
        die();
    } else {
        header('Location: ../login.php');
        die();
    }
}

function initializeSession($username) {
    session_regenerate_id(true);
    $_SESSION['username'] = $username;
    $_SESSION['userId'] = getIdByUsername($username);
    $_SESSION['email'] = getUserField($_SESSION['userId'], 'Email');
    $_SESSION['name'] = getUserField($_SESSION['userId'], 'Name');
    $_SESSION['groupId'] = getUserField($_SESSION['userId'], 'GroupID');
}
