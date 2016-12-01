<?php
include_once('connection.php');
$USER_GROUP_ID = 3; //Regular user group ID.

/**
 * Adds the user to the database. The user is created in the USER group.
 * @param $username string User's chosen name to use as login
 * @param $password string User's password, it is assumed that it is already hashed.
 * @param $email string User email
 * @param $name string User real life name
 * @param $dateOfBirth string User's date of birth
 * @param $gender string User's gender
 * @param $picture string User profile picture path.
 * @return Error code (0 if ok).
 */
function createUser($username, $password, $email, $name, $dateOfBirth, $gender, $picture) {
    global $db;
    global $USER_GROUP_ID;

    $statement = $db->prepare('INSERT INTO Users VALUES(NULL, ?, ?, ?, ?, ?, ?, ?, ?)');
    $statement->execute([$username, $password, $email, $name, $USER_GROUP_ID, $dateOfBirth, $gender, $picture]);
    return $statement->errorCode(); //Returns 0 even if the insertion failed due to repeated username or email.
}

/**
 * Check if the $username and the $password match.
 * @param $username string User's chosen name to use as login
 * @param $password string User's password.
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
 * @param $username string $username to check
 * @return bool Returns false if the username does not exist, returning true otherwise.
 */
function usernameExists($username) {
    global $db;

    $statement = $db->prepare('SELECT * FROM Users WHERE Username = ?');
    $statement->execute([$username]);
    return $statement->fetch();
}

/** Queries the database to check if a user with $email exists.
 * @param $email string $email to check
 * @return bool Returns false if the email does not exist, returning true otherwise.
 */
function emailExists($email) {
    global $db;

    $statement = $db->prepare('SELECT * FROM Users WHERE Email = ?');
    $statement->execute([$email]);
    return $statement->fetch();
}

/** Gets ID by username
 * @param $username string Username
 * @return int ID
 */
function getIdByUsername($username) {
    global $db;

    $statement = $db->prepare('SELECT ID FROM Users WHERE Username = ?');
    $statement->execute([$username]);
    return $statement->fetch()['ID'];
}

/** Returns the user's requested field. The field cannot be the user password.
 * @param $userId int User ID
 * @param $field string Field
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
 * @param $groupId int Group ID in the database
 * @param $permission string Permission string
 * @return bool Returns true if the groupId has the given permission.
 */
function groupIdHasPermissions($groupId, $permission) {
    global $db;

    if (!isset($groupId))
        $groupId = 1;

    $statement = $db->prepare('SELECT GroupID, PermissionsID, Name FROM GroupsPermissions, Permissions WHERE PermissionsID = Permissions.ID AND GroupID = ? AND Name = ?');
    $statement->execute([$groupId, $permission]);
    return $statement->fetch();
}

/** Returns whether the id exists or not.
 * @param $userId int User id to search for.
 * @return bool Returns true if the id exists in the database, returning false otherwise.
 */
function idExists($userId) {
    global $db;

    if (!isset($userId))
        return false;

    $statement = $db->prepare('SELECT ID FROM Users WHERE ID = ?');
    $statement->execute([$userId]);
    return $statement->fetch();
}

/** Updates the user profile.
 * @param $userId int User ID
 * @param $name string User name
 * @param $email string User email
 * @param $date string Date of birth
 * @param $gender string User gender
 * @return string Returns the query error code.
 */
function updateUser($userId, $name, $email, $date, $gender) {
    global $db;

    $statement = $db->prepare('UPDATE Users SET Name = ?, Email = ?, Gender = ?, DateOfBirth = ? WHERE id = ?');
    $statement->execute([$name, $email, $gender, $date, $userId]);
    /*  $statement = $db->prepare('UPDATE Users SET Name = :name, Email = :email, Gender = :gender, DateOfBirth = :date WHERE id = :id');
      $statement->bindParam(':name', $name);
      $statement->bindParam(':email', $email);
      $statement->bindParam(':gender', $gender);
      $statement->bindParam(':date', $date);
      $statement->bindParam(':id', $userId);

      $statement->execute();*/
    return $statement->errorCode();
}

function updateUserPassword($userId, $password) {
  global $db;

  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  $statement = $db->prepare('UPDATE Users SET Password = :password WHERE id = :id');
  $statement->bindParam(':password', $hashed_password);
  $statement->bindParam(':id', $userId);
  $statement->execute();
  return $statement->errorCode();
}
