<?php
include_once('restaurants.php');

$restaurantId = htmlspecialchars($_GET['restaurantId']);

echo getRestaurantAverageRating($restaurantId);
