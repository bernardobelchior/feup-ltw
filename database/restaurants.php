<?php
include_once('connection.php');

/** Adds the restaurant to the Restaurants table.
 * @param $ownerId int Restaurant's owner ID.
 * @param $name string Restaurant name.
 * @param $address string Restaurant's address.
 * @param $description string Restaurant's description.
 * @param $costForTwo integer Cost for two
 * @param $phoneNumber integer Phone number
 * @param $openingTime float Opening time
 * @param $closingTime float Closing time
 * @return string Returns the query error code.
 * @internal param float $lat Latitude
 * @internal param float $long Longitude
 */
function addRestaurant($ownerId, $name, $address, $description, $costForTwo, $phoneNumber, $openingTime, $closingTime) {
    global $db;

    $statement = $db->prepare('INSERT INTO Restaurants VALUES(NULL, ?, ?, ?, ?, ?, ?, ?, ?)');
    $statement->execute([$ownerId, $name, $address, $description, $costForTwo, $phoneNumber, $openingTime, $closingTime]);
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
 * @param $categories array Optional categories to restrict the search.
 * @return array All results.
 */
function searchRestaurants($query, $categories) {
    global $db;

    //Prepare the query to search for each word individually
    if ($query === '')
        $where = '"%"';
    else
        $where = '"%' . str_replace(' ', '%" OR LOWER(Name) LIKE "%', $query) . '%"';

    if (isset($categories) && is_array($categories)) {
        $categoryQuery = ' AND (';

        $i = 0;
        for (; $i < count($categories) - 1; $i++) {
            $categoryQuery .= 'CategoryID = ' . $categories[$i] . ' OR ';
        }

        $categoryQuery .= 'CategoryID = ' . $categories[$i] . ')';
        $statement = $db->prepare('SELECT Restaurants.ID, Name, Address FROM Restaurants INNER JOIN RestaurantsCategories ON Restaurants.ID = RestaurantID WHERE LOWER(Name) LIKE ' . $where . $categoryQuery);
    } else
        $statement = $db->prepare('SELECT ID, Name, Address FROM Restaurants WHERE LOWER(Name) LIKE ' . $where);

    // Not sure why, but using the execute([$where]) does not work, this is a workaround.
    $statement->execute();
    return $statement->fetchAll();
}

/** Gets the restaurant owner ID from the review ID.
 * @param $reviewId int Review ID.
 * @return array Restaurant Owner ID
 */
function getRestaurantOwnerFromReview($reviewId) {
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

/** Returns the restaurant ID with the given name.
 * @param $restaurantName string Restaurant name
 * @return mixed ID if the restaurant is found, null otherwise.
 */
function getRestaurantByName($restaurantName) {
    global $db;

    $statement = $db->prepare('SELECT ID FROM Restaurants WHERE Name = ?');
    $statement->execute([$restaurantName]);
    return $statement->fetch()['ID'];
}

/** Adds the photo provided to the respective restaurant.
 * @param $restaurantId int Restaurant ID.
 * @param $uploaderId int Uploader ID
 * @param $photoPath string Path to photo.
 * @return array Statement's error info.
 */
function addPhoto($restaurantId, $uploaderId, $photoPath) {
    global $db;

    $statement = $db->prepare('INSERT INTO RestaurantPhotos VALUES (NULL, ?, ?, ?)');
    $statement->execute([$restaurantId, $uploaderId, $photoPath]);
    return $statement->errorInfo();
}

/** Gets all photos related to that restaurant.
 * @param $restaurantId int Restaurant ID.
 * @return array Array of photos info.
 */
function getRestaurantPhotos($restaurantId) {
    global $db;

    $statement = $db->prepare('SELECT * FROM RestaurantPhotos WHERE RestaurantID = ?');
    $statement->execute([$restaurantId]);
    return $statement->fetchAll();
}

/** Gets the average restaurant rating.
 * @param $restaurantId Restaurant ID.
 * @return float Average rating
 */
function getRestaurantAverageRating($restaurantId) {
    global $db;

    $statement = $db->prepare('SELECT AVG(Score) FROM Reviews WHERE RestaurantID = ?');
    $statement->execute([$restaurantId]);
    return $statement->fetch()['AVG(Score)'];
}

/** Gets all categories
 * @return array All categories
 */
function getAllCategories() {
    global $db;

    $statement = $db->prepare('SELECT * FROM Categories');
    $statement->execute();
    return $statement->fetchAll();
}

/** Adds category to restaurant
 * @param $restaurantId int Restaurant ID
 * @param $categoryId int Category ID
 * @return array Statement error info
 */
function addCategoryToRestaurant($restaurantId, $categoryId) {
    global $db;

    $statement = $db->prepare('INSERT INTO RestaurantsCategories VALUES (NULL, ?, ?)');
    $statement->execute([$restaurantId, $categoryId]);
    return $statement->errorInfo();
}

/** Gets all categories that the given restaurant belongs to.
 * @param $restaurantId int Restaurant ID.
 * @return array Array of categories.
 */
function getRestaurantCategories($restaurantId) {
    global $db;

    $statement = $db->prepare('SELECT * FROM RestaurantsCategories INNER JOIN Categories ON RestaurantsCategories.CategoryID = Categories.ID WHERE RestaurantsCategories.RestaurantID = ? ORDER BY Categories.ID');
    $statement->execute([$restaurantId]);
    return $statement->fetchAll();
}

/** Removes the review and its replies from the database.
 * @param $reviewId int Review Id
 */
function removeReview($reviewId) {
    global $db;

    $statement = $db->prepare('DELETE FROM Replies WHERE ReviewID = ?');
    $statement->execute([$reviewId]);
    $statement = $db->prepare('DELETE FROM Reviews WHERE ID = ?');
    $statement->execute([$reviewId]);
}

/** Deletes reply
 * @param $replyId int Reply id
 */
function deleteReply($replyId) {
    global $db;

    $statement = $db->prepare('DELETE FROM Replies WHERE ID = ?');
    $statement->execute([$replyId]);
}

/**
 * Updates the Name field of a given restaurant
 * @param $id int Restaurant Id
 * @param $value string New name for the restaurant
 */
function updateRestaurantName($id, $value){
  return updateRestaurantField($id, 'Name', $value);
}

/**
 * Updates the Address field of a given restaurant
 * @param $id int Restaurant Id
 * @param $value string New address for the restaurant
 */
function updateRestaurantAddress($id, $value){
  return updateRestaurantField($id, 'Address', $value);
}

/**
 * Updates the Description field of a given restaurant
 * @param $id int Restaurant Id
 * @param $value string New description for the restaurant
 */
function updateRestaurantDescription($id, $value){
  return updateRestaurantField($id, 'Description', $value);
}

/**
 * Updates the Cost For Two field of a given restaurant
 * @param $id int Restaurant Id
 * @param $value int New Cost For Two for the restaurant
 */
function updateRestaurantCostForTwo($id, $value){
  return updateRestaurantField($id, 'CostForTwo', $value);
}

/**
 * Updates the Telephone Number field of a given restaurant
 * @param $id int Restaurant Id
 * @param $value int New Telephone Number for the restaurant
 */
function updateRestaurantTelephoneNumber($id, $value){
  return updateRestaurantField($id, 'TelephoneNumber', $value);
}

/**
 * Updates the Opening Hour field of a given restaurant
 * @param $id int Restaurant Id
 * @param $value float New Opening hour for the restaurant
 */
function updateRestaurantOpeningHour($id, $value){
  return updateRestaurantField($id, 'OpeningHour', $value);
}

/**
 * Updates the Closing Hour field of a given restaurant
 * @param $id int Restaurant Id
 * @param $value float New Closing hour for the restaurant
 */
function updateRestaurantClosingHour($id, $value){
  return updateRestaurantField($id, 'ClosingHour', $value);
}

/**
 * Updates the given field of a given restaurant
 * @param $id int Restaurant Id
 * @param $field string given field to change
 * @param $value string New address for the restaurant
 */
function updateRestaurantField($id, $field, $value){
  global $db;

  $statement = $db->prepare('UPDATE Restaurants SET ' . $field . ' = ? WHERE id = ?');
  $statement->execute([$value, $id]);
  return $statement->errorInfo();
}

/**
 * Removes the given category of the given restaurant
 * @param $id int Restaurant Id
 * @param $category_id int id of the given field to remove
 * @return error information
 */
function removeCategoryFromRestaurant($restaurant_id, $category_id){
  global $db;

  $statement = $db->prepare('DELETE FROM RestaurantsCategories WHERE RestaurantID = ? AND CategoryID = ?');
  $statement->execute([$restaurant_id, $category_id]);

  return $statement->errorInfo();
}

/**
 * Removes all other categories of the given restaurant
 * @param $id int Restaurant Id
 * @param $final_categories array of int ids of the categories to keep
 */
function removeOtherCategoriesFromRestaurant($restaurant_id, $final_categories){
  global $db;

  $current_categories = getRestaurantCategories($restaurant_id);

  foreach ($current_categories as $category) {
    if(!in_array($category['ID'], $final_categories))
      removeCategoryFromRestaurant($restaurant_id, $category['ID']);
  }
}

/**
 * Gets the last number used in a photo name for the given restaurant
 * @param $id int Restaurant Id
 * @return int last number used for photo name, 0 if none
 */
function getMaxPhotoName($id) {
    global $db;

    $statement = $db->prepare('SELECT max(Path) FROM RestaurantPhotos WHERE RestaurantID = ?');
    $statement->execute([$id]);
    $str = $statement->fetch()[0];

    if($str){
      list($my_val) = sscanf($str, 'restaurant_pictures/' . $id . '/%d.jpg');
      return $my_val;
    }
    else
      return 0;
}

/**
 * Removes the given photo of the a restaurant
 * @param $photo_src string path of the given photo to remove
 * @return error information
 */
function deleteRestaurantPhoto($photo_src) {
    global $db;

    $statement = $db->prepare('DELETE FROM RestaurantPhotos WHERE Path = ?');
    $statement->execute([$photo_src]);

    return $statement->errorInfo();
}

/**
 * Removes the the given restaurant of the restaurants table
 * @param $id int Restaurant Id
 * @return error information
 */
function deleteRestaurant($id) {
    global $db;

    $statement = $db->prepare('DELETE FROM Restaurants WHERE ID = ?');
    $statement->execute([$id]);

    $statement = $db->prepare('DELETE FROM RestaurantsCategories WHERE RestaurantID = ?');
    $statement->execute([$id]);

    $statement = $db->prepare('DELETE FROM RestaurantPhotos WHERE RestaurantID = ?');
    $statement->execute([$id]);

    return $statement->errorInfo();
}
