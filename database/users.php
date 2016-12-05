<?php
include_once('connection.php');
$USER_GROUP_ID = 3; //Regular user group ID.
//FIXME: All statements that return errorCode() should return errorInfo() as it gives more information.

/**
 * Adds the user to the database. The user is created in the USER group.
 * @param $username string User's chosen name to use as login
 * @param $password string User's password, it is assumed that it is already hashed.
 * @param $email string User email
 * @param $name string User real life name
 * @return array Error info.
 */
function createUser($username, $password, $email, $name) {
    global $db;
    global $USER_GROUP_ID;

    $statement = $db->prepare('INSERT INTO Users VALUES(NULL, ?, ?, ?, ?, ?, NULL, NULL, NULL)');
    $statement->execute([$username, $password, $email, $name, $USER_GROUP_ID]);
    return $statement->errorInfo(); //Returns 0 even if the insertion failed due to repeated username or email.
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
    return $statement->errorCode();
}

/** Updates the user password
 * @param $userId int User ID
 * @param $password string User password. Not hashed.
 * @return string Returns error code.
 */
function updateUserPassword($userId, $password) {
  global $db;

  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  $statement = $db->prepare('UPDATE Users SET Password = ? WHERE id = ?');
  $statement->execute([$hashed_password, $userId]);
  return $statement->errorCode();
}

/**
 * @param $userId int User ID
 * @param $picturePath string Picture path
 * @return array Statement error info.
 */
function changeProfilePicture($userId, $picturePath) {
   global $db;

   $statement = $db->prepare('UPDATE Users SET Picture = ? WHERE ID = ?;');
   $statement->execute([$picturePath, $userId]);
   return $statement->errorInfo();
}

/** Searches all users with any of the words present in query separated by a space.
 * The query is assumed to have been trimmed (no whitespaces at the beginning or end)
 * and only a single space between words.
 * The statement checks for lower case names, so the query MUST be lower case
 * in order to make it case insensitive.
 * @param $query string The search string.
 * @return array All results.
 */
function searchUsers($query) {
    global $db;

    //Prepare the query to search for each word individually
    $nameWhere = '"%' . str_replace(' ', '%" OR LOWER(Name) LIKE "%', $query) . '%"';
    $usernameWhere = '"%' . str_replace(' ', '%" OR LOWER(Username) LIKE "%', $query) . '%"';

    // Not sure why, but using the execute([$where]) does not work, this is a workaround.
    $statement = $db->prepare('SELECT ID, Username, Name FROM Users WHERE LOWER(Name) LIKE' . $nameWhere . ' OR LOWER(Username) LIKE' . $usernameWhere);
    $statement->execute();
    return $statement->fetchAll();
}
