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