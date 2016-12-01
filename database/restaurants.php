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
    return $statement->errorCode(); //Returns 0 even if the insertion failed due to repeated username or email.
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

function getUserRestaurants($ownerId) {
    global $db;

    $statement = $db->prepare('SELECT * FROM Restaurants WHERE OwnerID = ?');
    $statement->execute([$ownerId]);
    return $statement->fetchAll();
}