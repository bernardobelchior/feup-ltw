<?php
include_once('connection.php');

/** Adds the restaurant to the Restaurants table.
 * @param $ownerId int Restaurant's owner ID.
 * @param $name string Restaurant name.
 * @param $address string Restaurant's address
 * @param $description string Restaurant's description.
 * @return string Returns the query error code.
 */
function addRestaurant($ownerId, $name, $address, $description) {
    global $db;

    $statement = $db->prepare('INSERT INTO Restaurants VALUES(NULL, ?, ?, ?, ?)');
    $statement->execute([$ownerId, $name, $address, $description]);
    return $statement->errorInfo(); //Returns 0 even if the insertion failed due to repeated username or email.
}

/** Get the field corresponding to $field in the Restaurant table.
 * @param $restaurantId int Restaurant ID
 * @param $field string Restaurant table field
 * @return mixed The field content
 */
function getRestaurantField($restaurantId, $field) {
    global $db;

    $statement = $db->prepare('SELECT * FROM Restaurants WHERE ID = ?');
    $statement->execute([$restaurantId]);
    return $statement->fetch()[$field];
}

/** Returns all field from the given Restaurant.
 * @param $restaurantId int Restaurant ID
 * @return array All fields from the given Restaurant.
 */
function getRestaurantInfo($restaurantId) {
    global $db;

    $statement = $db->prepare('SELECT * FROM Restaurants WHERE ID = ?');
    $statement->execute([$restaurantId]);
    return $statement->fetch();
}

/** Gets all user restaurants.
 * @param $ownerId int Owner User ID.
 * @return array Array with all the user restaurants.
 */
function getUserRestaurants($ownerId) {
    global $db;

    $statement = $db->prepare('SELECT * FROM Restaurants WHERE OwnerID = ?');
    $statement->execute([$ownerId]);
    return $statement->fetchAll();
}

/** Gets all reviews for the given restaurant.
 * @param $restaurantId int Restaurant ID number.
 * @return array Array with all the restaurant's reviews.
 */
function getAllReviews($restaurantId) {
    global $db;

    $statement = $db->prepare('SELECT * FROM Reviews WHERE RestaurantID = ?');
    $statement->execute([$restaurantId]);
    return $statement->fetchAll();
}

/** Adds a review to the database. Comments are optional. Date is calculated with time().
 * @param $restaurantId int Restaurant ID
 * @param $reviewerId int Reviewer ID
 * @param $title string Review title
 * @param $score int Score between 1 and 5.
 * @param $comment string Optional comment.
 * @return array Statement error info.
 */
function addReview($restaurantId, $reviewerId, $title, $score, $comment) {
    global $db;

    $statement = $db->prepare('INSERT INTO Reviews VALUES(NULL, ?, ?, ?, ?, ?, ?)');
    $statement->execute([$restaurantId, $reviewerId, $title, $score, time(), $comment]);
    return $statement->errorInfo();
}

/** Returns whether or not the restaurant with $restaurantId exists in the database.
 * @param $restaurantId int Restaurant ID.
 * @return boolean Returns true if there is a restaurant with $restaurantId in the database. Returns false otherwise.
 */
function restaurantIdExists($restaurantId) {
    global $db;

    $statement = $db->prepare('SELECT * FROM Restaurants WHERE ID = ?');
    $statement->execute([$restaurantId]);
    return $statement->fetch();
}

/** Searches all restaurants with any of the words present in query separated by a space.
 * The query is assumed to have been trimmed (no whitespaces at the beginning or end)
 * and only a single space between words.
 * The statement checks for lower case names, so the query MUST be lower case
 * in order to make it case insensitive.
 * @param $query string The search string.
 * @return array All results.
 */
function searchRestaurants($query) {
    global $db;

    //Prepare the query to search for each word individually
    $where = '"%' . str_replace(' ', '%" OR LOWER(Name) LIKE "%', $query) . '%"';

    // Not sure why, but using the execute([$where]) does not work, this is a workaround.
    $statement = $db->prepare('SELECT ID, Name, Address FROM Restaurants WHERE LOWER(Name) LIKE' . $where);
    $statement->execute();
    return $statement->fetchAll();
}

/** Gets the restaurant owner ID from the review ID.
 * @param $reviewId int Review ID.
 * @return array Restaurant Owner ID
 */
function getRestaurantOwnerFromReview($reviewId){
    global $db;

    $statement = $db->prepare('SELECT OwnerID FROM Reviews, Restaurants WHERE Reviews.RestaurantID = Restaurants.ID AND Reviews.ID = ?');
    $statement->execute([$reviewId]);
    return $statement->fetch()['OwnerID'];
}

/** Adds the reply to the database.
 * @param $reviewId int Review ID.
 * @param $reply string Reply text.
 * @return array Error info.
 */
function addReply($reviewId, $replierId, $reply) {
    global $db;

    $statement = $db->prepare('INSERT INTO Replies VALUES(NULL, ?, ?, ?, ?)');
    $statement->execute([$reviewId, $replierId, $reply, time()]);
    return $statement->errorInfo();
}

/** Gets all replies to the given review.
 * @param $reviewId int Review ID
 * @return array All replies
 */
function getAllReplies($reviewId) {
    global $db;

    // Possibly sort by Date? Not sure if needed because the replies are inserted
    // into the table in the same order as they should be displayed
    $statement = $db->prepare('SELECT * FROM Replies WHERE ReviewID = ?');
    $statement->execute([$reviewId]);
    return $statement->fetchAll();
}