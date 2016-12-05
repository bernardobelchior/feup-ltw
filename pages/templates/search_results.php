<?php
include_once('../database/search.php');
include_once('../database/restaurants.php');
include_once('../database/users.php');

$query = normalizeQuery(htmlspecialchars($_GET['query']));

//TODO: Order restaurants and users by similiarity (similar_text())
$orderedRestaurants = searchRestaurants($query);
$orderedUsers = searchUsers($query);
?>

<script src="../js/search_results.js"></script>
<link rel="stylesheet" type="text/css" href="../css/search_results.min.css"/>

<div id="restaurants" class="container">
    <?php
    if (count($orderedRestaurants) > 0) {
        foreach ($orderedRestaurants as $restaurant) {
            echo '
       <div class="container search-result" onclick="openRestaurantProfile(' . $restaurant['ID'] . ')">
            <span>' . $restaurant['Name'] . '</span> 
            <span>' . $restaurant['Address'] . '</span>
       </div>';
        }
    } else {
        echo '<span>No results found.</span>';
    }
    ?>
</div>

<div id="users" class="container">
    <?php
    if (count($orderedUsers) > 0) {
        foreach ($orderedUsers as $user) {
            echo '
       <div class="container search-result" onclick="openUserProfile(' . $user['ID'] . ')">
            <span>' . $user['Name'] . '</span> 
            <span>' . $user['Username'] . '</span>
       </div>';
        }
    } else {
        echo '<span>No results found.</span>';
    }
    ?>
</div>
