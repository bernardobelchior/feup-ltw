<?php
session_start(['cookie_httponly' => true]);

include_once('../utils/utils.php');
include_once('../database/restaurants.php');
include_once('../database/users.php');

$restaurant_id = htmlspecialchars($_POST['restaurant_id']);

// If the user didn't come from the edit restaurant page or does not have permissions.
if ($_SESSION['token'] !== $_POST['token'] ||
    (!groupIdHasPermissions($_SESSION['groupId'], 'EDIT_ANY_RESTAURANT') &&
        $_SESSION['userId'] !== intval(getRestaurantField($restaurant_id, 'OwnerID')))
) {
    header('HTTP/1.0 403 Forbidden');
    header('Location: ../403.php');
    die();
}

$type = htmlspecialchars($_POST['type']);
$value = null;
if (isset($_POST['value']))
    $value = $_POST['value'];

for ($i = 0; $i < count($value); $i++) {
    $value[$i] = htmlspecialchars($value[$i]);
}

switch ($type) {
    case 'name' :
        updateRestaurantName($restaurant_id, $value);
        break;
    case 'address' :
        updateRestaurantAddress($restaurant_id, $value);
        break;
    case 'description' :
        updateRestaurantDescription($restaurant_id, $value);
        break;
    case 'cost-for-two' :
        updateRestaurantCostForTwo($restaurant_id, $value);
        break;
    case 'telephone-number' :
        updateRestaurantTelephoneNumber($restaurant_id, $value);
        break;
    case 'working-hours' :
        $openingHour = htmlspecialchars($_POST['opening-time']);
        $closingHour = htmlspecialchars($_POST['closing-time']);
        updateRestaurantOpeningHour($restaurant_id, $openingHour);
        updateRestaurantClosingHour($restaurant_id, $closingHour);
        break;
    case 'categories' :
        $categories = getRestaurantCategories($restaurant_id);
        $categories_ids = [];

        foreach ($categories as $category) {
            array_push($categories_ids, $category['ID']);
        }

        foreach ($value as $category) {
            if (!in_array($category, $categories_ids))
                addCategoryToRestaurant($restaurant_id, $category);
        }
        removeOtherCategoriesFromRestaurant($restaurant_id, $value);
        break;
}
header('Location: ' . $_SERVER['HTTP_REFERER']);
die();