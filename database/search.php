<?php
include_once('restaurants.php');
include_once('users.php');
include_once('search_utils.php');

$query = htmlspecialchars($_GET['query']);
$categories = $_GET['categories'];

if (isset($categories)) {
    foreach ($categories as $category)
        $category = htmlspecialchars($category);
}

$query = normalizeQuery($query);

$restaurants = searchRestaurants($query, $categories);
$users = searchUsers($query);

echo json_encode(['restaurants' => $restaurants, 'users' => $users]);
