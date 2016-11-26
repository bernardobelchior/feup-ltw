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
    if (strlen($username))
        echo 'A username needs to be at least 8 characters long.';

    if (usernameExists($username))
        echo 'That username is already in use. Try a new one.';

    if (strlen($password))
        echo 'A password needs to be at least 7 characters long.';

    if ($password !== $password_repeat)
        echo 'The passwords provided do not match. Try again.';

    $password = password_hash($password, PASSWORD_DEFAULT);

    if (emailExists($email))
        echo 'That email is already in use. Use different one.';

    json_encode(createUser($username, $password, $email, $name, $dateOfBirth, $gender, $picture));
}
