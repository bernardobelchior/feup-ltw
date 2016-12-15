<?php
include_once('../database/restaurants.php');
include_once('../database/users.php');
include_once('../utils/utils.php');

$query = '';
if (isset($_GET['query']))
    $query = htmlspecialchars($_GET['query']);
?>

<link rel="stylesheet" type="text/css" href="../css/search_results.min.css"/>
<link rel="stylesheet" type="text/css" href="../css/nouislider.min.css"/>

<script src="../js/common.js"></script>
<script src="../js/search_results.js"></script>
<script src="../js/nouislider.min.js"></script>

<div id="body">
    <input id="search-box" type="text" name="query" value="<?= $query ?>"/>
    <ul id="categories">
        <?php
        $categories = getAllCategories();

        foreach ($categories as $category) {
            echo '<li class="category-box"><label><input type="checkbox" name="categories[]" value="' . $category['ID'] . '">' . $category['Name'] . '</label></li>';
        }
        ?>
    </ul>
    <div id="slider">

    </div>

    <div id="search-results">
        <ul id="search-tabs">
            <li class="tab active" id="restaurants-tab"><a href="#restaurants">Restaurants</a></li>
            <li class="tab" id="users-tab"><a href="#users">Users</a></li>
        </ul>

        <div id="restaurants" class="search-container">
        </div>

        <div id="users" class="search-container">
        </div>
    </div>
</div>
