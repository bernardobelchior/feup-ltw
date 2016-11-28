<?php
include_once('../../database/users.php');

session_start();
$username = $_POST['username'];
$password = $_POST['password'];
$password_repeat = $_POST['password-repeat'];
$email = $_POST['email'];
$name = $_POST['name'];
$dateOfBirth;
$gender = $_POST['gender'];
$picture;

if ($username && $password && $password_repeat && $email && $name && $gender) {
    if (strlen($username) < 8) {
        echo 'A username needs to be at least 8 characters long.';
        return;
    }

    if (usernameExists($username)) {
        echo 'That username is already in use. Try a new one.';
        return;
    }

    if (strlen($password) < 7) {
        echo 'A password needs to be at least 7 characters long.';
        return;
    }

    if ($password !== $password_repeat) {
        echo 'The passwords provided do not match. Try again.';
        return;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    if (emailExists($email)) {
        echo 'That email is already in use. Use a different one.';
        return;
    }

    if(createUser($username, $password, $email, $name, $dateOfBirth, $gender, $picture) == 0) {
        //Logs the user in.
        include_once('login.php');
    }
/*    else {
        //May happen if the user refreshes the page after the form has been submitted.
        if(usernameExists($username))
            echo 'That username is already in use. Try a new one.';
        elseif(emailExists($email))
            echo 'That email is already in use. Use a different one.';

    }*/
}
