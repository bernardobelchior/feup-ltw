<?php
include_once('../database/users.php');
include_once('../database/restaurants.php');
include_once('utils/utils.php');

if (groupIdHasPermissions($_SESSION['groupId'], 'ADD_ANY_RESTAURANT') && !groupIdHasPermissions($_SESSION['groupId'], 'ADD_ANY_RESTAURANT')) {
    header('HTTP/1.0 403 Forbidden');
    header('Location: index.php?page=403.html');
    die();
}

$_SESSION['token'] = generateRandomToken();
?>
<link rel="stylesheet" type="text/css" href="../css/common.min.css"/>
<link rel="stylesheet" type="text/css" href="../css/add_restaurant.min.css"/>
<script src="../js/add_restaurant.js"></script>

<form id="add-restaurant" class="container" action="actions/add_restaurant.php" method="post"
      enctype="multipart/form-data" onsubmit="return validateForm()">
    <input name="token" type="hidden" value="<?php echo $_SESSION['token']; ?>">
    <input name="name" type="text" placeholder="Name" required>
    <input name="address" id="address" type="text" placeholder="Address" required>
    <input name="cost-for-two" id="cost-for-two" type="number" min="1" placeholder="Cost for two">
    <input name="phone-number" id="phone-number" type="number" min="0" placeholder="Phone number">
    <textarea name="description" id="restaurant-description" placeholder="Description" rows="5" cols="55"></textarea>
    <div id="categories-label">Categories:</div>
    <ul id="categories">
        <?php
        $categories = getAllCategories();

        foreach ($categories as $category) {
            echo '<li class="category-box"><input type="checkbox" name="categories[]" value="' . $category['ID'] . '">' . $category['Name'] . '</li>';
        }
        ?>
    </ul>
    <div id="upload">
        <span>Upload some photos:</span>
        <input name="photos[]" type="file" multiple="multiple"/>
    </div>
    <button id="submit" type="submit">Submit</button>
</form>
