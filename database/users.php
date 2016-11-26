<?php
include_once('connection.php');

function createUser($username, $password, $email, $name, $dateOfBirth, $gender, $picture)
{
    global $db;

    $statement = $db->prepare('INSERT INTO Users VALUES(NULL, ?, ?, ?, ?, ?, ?, ?)');
    $password = password_hash($password, PASSWORD_DEFAULT);
    $statement->execute([$username, $password, $email, $name, $dateOfBirth, $gender, $picture]);

    $statement = $db->prepare('SELECT * FROM Users;');
    $statement->execute();
    echo $statement->errorInfo();
}

function login($username, $password) {
    global $db;

    $statement = $db->prepare('SELECT Password FROM Users WHERE Username = "?"');
    $statement->execute([$username]);
    $hashed_password = $statement->fetch();
    return password_verify($password, $hashed_password);
}

function usernameExists($username)
{
    global $db;

    $statement = $db->prepare('SELECT * FROM Users WHERE Username = "?"');
    $statement->execute([$username]);
    return $statement->rowCount();
}

function emailExists($email)
{
    global $db;

    $statement = $db->prepare('SELECT * FROM Users WHERE Email = "?"');
    $statement->execute([$email]);
    return $statement->rowCount();
}