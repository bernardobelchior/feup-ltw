<?php session_start();
include_once('../../database/users.php');

$userId = $_SESSION['userId'];
$username = $_SESSION['username'];
$password = $_POST['old-password'];

if(login($username, $password) != 0){
    updateUserPassword($userId, $password);
    header('Location: ../profile.php?id=' . $_SESSION['userId']);
}
else {
    echo "<p> Wrong Password , click <a href='../edit_profile.php'>here</a> to go back.</p>";
}
