<?php session_start();
include_once('../../database/users.php');

$id = $_SESSION['userId'];
$name = $_POST['name'];
$email = $_POST['email'];
$date = $_POST['date'];
$gender = $_POST['gender'];
$picture;

if(updateUser($id, $name, $email, $date, $gender) == 0){
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;
}

header('Location: ../profile.php?id=' . $_SESSION['userId']);
