<?php
include_once('../database/search.php');
include_once('../database/restaurants.php');
include_once('../database/users.php');

$query = normalizeQuery(htmlspecialchars($_GET['query']));

//TODO: Order restaurants and users by similiarity (similar_text())
$orderedRestaurants = searchRestaurants($query);
$orderedUsers = searchUsers($query);
?>

<script src="../js/common.js"></script>
<link rel="stylesheet" type="text/css" href="../css/search_results.min.css"/>
<link rel="stylesheet" type="text/css" href="../css/common.min.css"/>
<script src="../js/search_results.js"></script>

<div id="body">
    <div id="search">
        <form action="index.php" method="get">
            <input type="hidden" id="page" name="page" value="search_results.php"/>
            <input id="search-box" type="text" name="query" value="<?php echo $query ?>" required/>
            <button type="submit">Search</button>
        </form>
    </div>

    <div id="search-results">
        <ul id="search-tabs">
            <li class="tab active" id="restaurants-tab"><a href="#restaurants">Restaurants</a></li>
            <li class="tab" id="users-tab"><a href="#users">Users</a></li>
        </ul>

        <div id="restaurants" class="search-container">
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

        <div id="users" class="search-container">
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
    </div>
</div>
