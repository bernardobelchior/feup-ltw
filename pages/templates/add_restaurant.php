<?php
include_once('../database/users.php');
include_once('../database/restaurants.php');
include_once('../utils/utils.php');

if (groupIdHasPermissions($_SESSION['groupId'], 'ADD_ANY_RESTAURANT') && !groupIdHasPermissions($_SESSION['groupId'], 'ADD_ANY_RESTAURANT')) {
    header('HTTP/1.0 403 Forbidden');
    header('Location: index.php?page=403.html');
    die();
}

$_SESSION['token'] = generateRandomToken();
?>
<link rel="stylesheet" type="text/css" href="../css/common.min.css"/>
<link rel="stylesheet" type="text/css" href="../css/add_restaurant.min.css"/>

<div class="page_content">
    <div class="page_title"><strong>Add a New Restaurant</strong></div>
    <form id="add-restaurant" class="container" action="../actions/add_restaurant.php" method="post"
          enctype="multipart/form-data">
        <div id="general-info">
            <div class="section_title">General Information</div>
            <input name="token" type="hidden" value="<?php echo $_SESSION['token']; ?>">
            <input name="name" type="text" placeholder="Name" required>
            <input name="address" id="address" type="text" placeholder="Address" required>
            <input name="cost-for-two" id="cost-for-two" type="number" min="1" placeholder="Cost for two">
            <input name="phone-number" id="phone-number" type="number" min="0" placeholder="Phone number"><br>
            <a>Open from</a>
            <select name="opening-time">
                <?php
                for ($i = 0; $i < 24; $i++) {
                    for ($j = 0; $j < 2; $j++) {
                        echo sprintf('<option value="%d">%02d:%02d</option>', $i * 10 + $j * 5, $i, $j * 30);
                    }
                }
                ?>
            </select>
            <a> to </a>
            <select name="closing-time">
                <?php
                for ($i = 0; $i < 24; $i++) {
                    for ($j = 0; $j < 2; $j++) {
                        echo sprintf('<option value="%d">%02d:%02d</option>', $i * 10 + $j * 5, $i, $j * 30);
                    }
                }
                ?>
            </select>

            <textarea name="description" id="restaurant-description" placeholder="Description" rows="5"
                      cols="55"></textarea>
        </div>
        <div id="categories-div">
            <div class="section_title">Categories</div>
            <ul id="categories">
                <?php
                $categories = getAllCategories();

                foreach ($categories as $category) {
                    echo '<li class="category-box"><label><input type="checkbox" name="categories[]" value="' . $category['ID'] . '">' . $category['Name'] . '</label></li>';
                }
                ?>
            </ul>
        </div>
        <div id="photos-div">
            <div class="section_title">Photos</div>
            <div id="upload">
                <span>Upload some photos:</span>
                <input name="photos[]" type="file" multiple="multiple"/>
            </div>
            <button id="submit" type="submit">Submit</button>
        </div>
    </form>
</div>
