<?php

include_once('users.php');

$username = $_POST['username'];
$password = $_POST['password'];
$password_repeat = $_POST['password-repeat'];
$email = $_POST['email'];
$name = $_POST['name'];
$dateOfBirth;
$gender = $_POST['gender'];
$picture;

if ($username && $password && $password_repeat && $email && $name && $gender) {
    //TODO: Form validation in the server
    //because the client may have js disabled
    //and the form wont be validated

    if ($password !== $password_repeat)
        return;

    $password = password_hash($password, PASSWORD_DEFAULT);

    createUser($username, $password, $email, $name, $dateOfBirth, $gender, $picture);
}
