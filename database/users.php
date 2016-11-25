<?php
include_once('connection.php');

function createUser($username, $password, $email, $name, $dateOfBirth, $gender, $picture) {
    global $db;

    //FIXME: Check if username is already on the db.

    $statement = $db->prepare('INSERT INTO Users VALUES(NULL, ?, ?, ?, ?, ?, ?, ?)');
    $password = password_hash($password, PASSWORD_DEFAULT);
    $statement->execute([$username, $password, $email, $name, $dateOfBirth, $gender, $picture]);

    $statement = $db->prepare('SELECT * FROM Users;');
    $statement->execute();
//    echo json_encode($statement->fetchAll());
}
