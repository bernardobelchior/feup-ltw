<?php
include_once('../database/restaurants.php');
include_once('../database/users.php');
include_once('../utils/utils.php');

$id = (int)htmlspecialchars($_GET['id']);

if (!groupIdHasPermissions($_SESSION['groupId'], 'EDIT_ANY_RESTAURANT') &&
    $_SESSION['userId'] !== $_SESSION['ownerId']
) {
    header('HTTP/1.0 403 Forbidden');
    header('Location: index.php?page=403.html');
    die();
}

if (!isset($id) || !restaurantIdExists($id)) {
    header('HTTP/1.0 404 Not Found');
    header('Location: 404.php');
    die();
}

$_SESSION['token'] = generateRandomToken();
$_SESSION['restaurantId'] = $id;

$restaurantInfo = getRestaurantInfo($id);
$ownerId = $restaurantInfo['OwnerID'];
$name = $restaurantInfo['Name'];
$address = $restaurantInfo['Address'];
$description = $restaurantInfo['Description'];
$costForTwo = $restaurantInfo['CostForTwo'];
$telephoneNumber = $restaurantInfo['TelephoneNumber'];

$_SESSION['ownerId'] = $ownerId;
unset($restaurantInfo);
?>

<link rel="stylesheet" href="../css/common.min.css">
<link rel="stylesheet" href="../css/edit_profile.min.css">

<script type="text/javascript" src="../js/edit_restaurant.js"></script>

<div class="page_content">
    <header class="page_title"><strong>Edit Restaurant</strong></header>
    <div id="restaurant-info">
        <div class="section_title">General Info</div>
        <!-- <input type="hidden" id="token" name="token" value="<?php echo $_SESSION['token']; ?>"/>
  <input type="hidden" id="restaurant_id" name="restaurant_id" value="<?php echo $id; ?>"/> -->
        <ul id="profile_attr_list">
            <li id="name">
                <span class="list_attr_name"><strong>Name</strong></span>
                <span class="list_attr_content"><?php echo $name; ?></span>
                <span class="edit_link">Edit</span>
            </li>
            <li id="address">
                <span class="list_attr_name"><strong>Address</strong></span>
                <span class="list_attr_content"><?php echo $address; ?></span>
                <span class="edit_link">Edit</span>
            </li>
            <li id="description">
                <span class="list_attr_name"><strong>Description</strong></span>
                <span class="list_attr_content"><?php echo $description; ?></span>
                <span class="edit_link">Edit</span>
            </li>
            <li id="cost-for-two">
                <span class="list_attr_name"><strong>Cost For Two</strong></span>
                <span class="list_attr_content"><?php echo $costForTwo; ?></span>
                <span class="edit_link">Edit</span>
            </li>
            <li id="telephone-number">
                <span class="list_attr_name"><strong>Telephone Number</strong></span>
                <span class="list_attr_content"><?php echo $telephoneNumber; ?></span>
                <span class="edit_link">Edit</span>
            </li>
            <li id="categories">
                <span class="list_attr_name"><strong>Categories</strong></span>
                <span class="list_attr_content"><?php $categories = getRestaurantCategories($id);
                    for ($i = 0; $i < count($categories); $i++) {
                        if ($i !== 0)
                            echo ', ';
                        echo $categories[$i]['Name'];
                    } ?></span>
                <span class="edit_link">Edit</span>
                <ul class="categories-list">
                    <?php
                    $categories = getAllCategories();
                    $current_categories = getRestaurantCategories($id);
                    $current_categories_names = [];
                    foreach ($current_categories as $category) {
                        array_push($current_categories_names, $category['Name']);
                    }

                    foreach ($categories as $category) {
                        if (in_array($category['Name'], $current_categories_names))
                            echo '<li class="category-box"><label><input type="checkbox" checked="true" name="categories[]" text="' . $category['Name'] . '"value="' . $category['ID'] . '">' . $category['Name'] . '</label></li>';
                        else
                            echo '<li class="category-box"><label><input type="checkbox" name="categories[]" text="' . $category['Name'] . '" value="' . $category['ID'] . '">' . $category['Name'] . '</input></label></li>';
                    }
                    ?>
                </ul>
            </li>
        </ul>
    </div>
    <div id="photos">
        <div class="section_title">Photos</div>
        <div id="upload">
            <span>Add some photos:</span>
            <form id="photos-form" method='post' action="../actions/upload_restaurant_photo.php"
                  enctype="multipart/form-data">
                <input type="hidden" id="token" name="token" value="<?= $_SESSION['token'] ?>"/>
                <input type="hidden" id="restaurant_id" name="restaurant_id" value="<?= $id ?>"/>
                <input name="photos[]" type="file" multiple="multiple"/>
                <button class="upload_photos" type="submit">Submit</button>
            </form>
        </div>

        <script src="../js/restaurant_profile.js"></script>
        <div id="restaurant-gallery">
            <?php
            $photos = getRestaurantPhotos($id);

            if (count($photos) > 0) {
                echo '<i id="left-arrow" class="fa fa-chevron-left fa-4x" aria-hidden="true"></i>';
                echo '<div>';

                foreach ($photos as $photo) {
                    echo '<img class="photo" src="' . '../' . $photo['Path'] . '" alt="Restaurant photo"></img>';
                }

                echo '</div>
          <i id="right-arrow" class="fa fa-chevron-right fa-4x" aria-hidden="true"></i>';
            }
            ?>
        </div>
        <button id="delete-photo">Delete Photo</button>
        <form id="delete-restaurant" method="post" action="../actions/delete_restaurant.php">
            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>"/>
            <input type="hidden" name="restaurant_id" value="<?= $id ?>"/>
            <button type="submit">Delete Restaurant</button>
        </form>
    </div>
