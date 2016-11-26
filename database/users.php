<?php
include_once('connection.php');

/**
 * Adds the user to the database.
 * @param $username
 * @param $password It is assumed that the password is already hashed.
 * @param $email
 * @param $name
 * @param $dateOfBirth
 * @param $gender
 * @param $picture User profile picture path.
 * @return Error information.
 */
function createUser($username, $password, $email, $name, $dateOfBirth, $gender, $picture) {
    global $db;

    $statement = $db->prepare('INSERT INTO Users VALUES(NULL, ?, ?, ?, ?, ?, ?, ?)');
    $statement->execute([$username, $password, $email, $name, $dateOfBirth, $gender, $picture]);

    $statement = $db->prepare('SELECT * FROM Users;');
    $statement->execute();
    return $statement->errorCode(); //Returns 0 even if the insertion failed due to repeated username or email.
}

function login($username, $password) {
    global $db;

    $statement = $db->prepare('SELECT Password FROM Users WHERE Username = ?');
    $statement->execute([$username]);
    $hashed_password = $statement->fetch()['Password'];
    return password_verify($password, $hashed_password);
}

function usernameExists($username) {
    global $db;

    $statement = $db->prepare('SELECT * FROM Users WHERE Username = ?');
    $statement->execute([$username]);
    return $statement->rowCount();
}

function emailExists($email) {
    global $db;

    $statement = $db->prepare('SELECT * FROM Users WHERE Email = ?');
    $statement->execute([$email]);
    return $statement->rowCount();
}