<?php
include_once('../../database/users.php');
session_start(['cookie_httponly' => true]);

var_dump($_SESSION['token']);
var_dump($_POST['token']);

// Check if the user came from a valid page.
if($_SESSION['token'] !== $_POST['token']) {
    header('HTTP/1.0 403 Not Found');
//    header('Location: ../403.php');
    die();
}

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
