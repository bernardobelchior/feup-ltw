<?php
include_once ('connection.php');

function createUser($username, $password, $email, $name, $dateOfBirth, $gender, $picture) {
   global $db;
    $statement = $db->prepare('INSERT INTO Users VALUES(NULL, ?, ?, ?, ?, ?, ?, ?)');
    $password = password_hash($password, PASSWORD_DEFAULT);
    $statement->execute([$username, $password, $email, $name, $dateOfBirth, $gender, $picture]);
}
