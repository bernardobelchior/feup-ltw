<?php
include_once('../database/restaurants.php');
include_once('../database/users.php');

/** Normalizes the query by trimming whitespaces, making everything lower case and
 * substituting newlines, tabs and multiple spaces by a single space.
 * @param $query string Input query
 * @return string
 */
function normalizeQuery($query) {
    // Remove whitespace at the beginning and end of the query.
    $normalizedQuery = trim($query);

    // Substitutes multiple spaces, tabs and newlines for a unique space.
    $normalizedQuery = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $normalizedQuery);

    // Make the query lower cased, as the search functions need a lower case query.
    return strtolower($normalizedQuery);
}


$query = htmlspecialchars($_GET['query']);
$categories = null;
if (isset($_GET['prices'])) {
    $prices = $_GET['prices'];

    foreach ($prices as $price)
        $price = htmlspecialchars($price);
}

if (isset($_GET['categories'])) {
    $categories = $_GET['categories'];

    foreach ($categories as $category)
        $category = htmlspecialchars($category);
}

$query = normalizeQuery($query);


$restaurants = searchRestaurants($query, $categories, $prices);
$users = searchUsers($query);

echo json_encode(['restaurants' => $restaurants, 'users' => $users]);


