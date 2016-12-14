<?php
include_once('../database/restaurants.php');

$restaurantId = htmlspecialchars($_GET['restaurantId']);

echo getRestaurantAverageRating($restaurantId);
