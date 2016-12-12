<?php
include_once('../database/restaurants.php');
include_once('../database/users.php');
include_once('utils/utils.php');

$query = htmlspecialchars($_GET['query']);
?>

<script src="../js/common.js"></script>
<link rel="stylesheet" type="text/css" href="../css/search_results.min.css"/>
<script src="../js/search_results.js"></script>

<div id="body">
    <input id="search-box" type="text" name="query" value="<?php echo $query ?>" required/>
    <ul id="categories">
        <?php
        $categories = getAllCategories();

        foreach ($categories as $category) {
            echo '<li class="category-box"><label><input type="checkbox" name="categories[]" value="' . $category['ID'] . '">' . $category['Name'] . '</label></li>';
        }
        ?>
    </ul>

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
