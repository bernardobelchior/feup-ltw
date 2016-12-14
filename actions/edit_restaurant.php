<?php
session_start(['cookie_httponly' => true]);

include_once('../utils.php');
include_once('../database/restaurants.php');

// If the user didn't come from the edit restaurant page.
if ($_SESSION['token'] !== $_POST['token']) {
    header('HTTP/1.0 403 Forbidden');
    header('Location: ../403.php');
    die();
}

$restaurant_id = htmlspecialchars($_POST['restaurant_id']);
$type = htmlspecialchars($_POST['type']);
$picked_categories = $_POST['picked_categories'];

for($i = 0; $i < count($picked_categories); $i++){
  $picked_categories[$i] = htmlspecialchars($picked_categories[$i]);
}

if ($type === 'name')
    return updateRestaurantName($restaurant_id, $value);
else if ($type === 'address')
    return updateRestaurantAddress($restaurant_id, $value);
else if ($type === 'description')
    return updateRestaurantDescription($restaurant_id, $value);
else if ($type === 'cost-for-two')
    return updateRestaurantCostForTwo($restaurant_id, $value);
else if ($type === 'telephone-number')
    return updateRestaurantTelephoneNumber($restaurant_id, $value);
else if ($type === 'categories') {
    $categories = getRestaurantCategories($restaurant_id);
    $categories_ids = [];

    foreach ($categories as $category) {
        array_push($categories_ids, $category['ID']);
    }

    foreach ($picked_categories as $category) {
        if (!in_array($category, $categories_ids))
            addCategoryToRestaurant($restaurant_id, $category);
    }
    removeOtherCategoriesFromRestaurant($restaurant_id, $picked_categories);
}
