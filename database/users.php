<?php
include_once('connection.php');

/**
 * Adds the user to the database.
 * @param $username User's chosen name to use as login
 * @param $password User's password, it is assumed that it is already hashed.
 * @param $email User email
 * @param $name User real life name
 * @param $dateOfBirth User's date of birth
 * @param $gender User's gender
 * @param $picture User profile picture path.
 * @return Error code (0 if ok).
 */
function createUser($username, $password, $email, $name, $dateOfBirth, $gender, $picture) {
    global $db;

    $statement = $db->prepare('INSERT INTO Users VALUES(NULL, ?, ?, ?, ?, ?, ?, ?)');
    $statement->execute([$username, $password, $email, $name, $dateOfBirth, $gender, $picture]);

    $statement = $db->prepare('SELECT * FROM Users;');
    $statement->execute();
    return $statement->errorCode(); //Returns 0 even if the insertion failed due to repeated username or email.
}

/**
 * Check if the $username and the $password match.
 * @param $username User's chosen name to use as login
 * @param $password User's password.
 * @return bool Returns true if the $username and $password match.
 */
function login($username, $password) {
    global $db;

    $statement = $db->prepare('SELECT Password FROM Users WHERE Username = ?');
    $statement->execute([$username]);
    $hashed_password = $statement->fetch()['Password'];
    return password_verify($password, $hashed_password);
}

/** Queries the database to check if user with $username exists.
 * @param $username $username to check
 * @return bool Returns false if the username does not exist, returning true otherwise.
 */
function usernameExists($username) {
    global $db;

    $statement = $db->prepare('SELECT * FROM Users WHERE Username = ?');
    $statement->execute([$username]);
    return $statement->rowCount() > 0;
}

/** Queries the database to check if a user with $email exists.
 * @param $email $email to check
 * @return bool Returns false if the email does not exist, returning true otherwise.
 */
function emailExists($email) {
    global $db;

    $statement = $db->prepare('SELECT * FROM Users WHERE Email = ?');
    $statement->execute([$email]);
    return $statement->rowCount() > 0;
}

/** Gets ID by username
 * @param $username Username
 * @return Integer ID
 */
function getIdByUsername($username) {
    global $db;

    $statement = $db->prepare('SELECT ID FROM Users WHERE Username = ?');
    $statement->execute([$username]);
    return $statement->fetch()['ID'];
}

/** Returns the user's requested field. The field cannot be the user password.
 * @param $userId User ID
 * @param $field Field
 * @return string
 */
function getUserField($userId, $field) {
    if ($field === 'Password')
        return null;

    global $db;

    $statement = $db->prepare('SELECT * FROM Users WHERE ID = ?');
    $statement->execute([$userId]);
    return $statement->fetch()[$field];
}

/**
 * Checks if the $groupId has the specified $permission.
 * @param $groupId Group ID in the database
 * @param $permission Permission string
 * @return bool Returns true if the groupId has the given permission.
 */
function groupIdHasPermissions($groupId, $permission) {
    global $db;

    $statement = $db->prepare('SELECT * FROM GroupsPermissions, Permissions WHERE GroupID = ? AND Name = ?');
    $statement->execute([$groupId, $permission]);
    return $statement->rowCount() > 0;
}
