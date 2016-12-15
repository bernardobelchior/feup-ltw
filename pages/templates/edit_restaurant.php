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
$openingTime = $restaurantInfo['OpeningHour'];
$closingTime = $restaurantInfo['ClosingHour'];
if (isset($openingTime) && isset($closingTime)) {
    $openingHour = intval($openingTime);
    $openingMinute = ($openingTime - $openingHour) * 60;
    $closingHour = intval($closingTime);
    $closingMinute = ($closingTime - $closingHour) * 60;
}


$_SESSION['ownerId'] = $ownerId;
unset($restaurantInfo);
?>

<link rel="stylesheet" href="../css/edit_restaurant.min.css">
<script type="text/javascript" src="../js/edit_restaurant.js"></script>

<div class="page_content">
    <header class="page_title"><strong>Edit Restaurant</strong></header>
    <form id="delete-restaurant" method="post" action="../actions/delete_restaurant.php">
        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>"/>
        <input type="hidden" name="restaurant_id" value="<?= $id ?>"/>
        <button type="submit">Delete Restaurant</button>
    </form>
    <div id="restaurant-info">
        <div class="section_title">General Info</div>
        <ul id="profile_attr_list">
            <li id="name">
                <form method="post" action="../actions/edit_restaurant.php">
                    <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>"/>
                    <input type="hidden" name="restaurant_id" value="<?= $id ?>"/>
                    <input type="hidden" name="type" value="name"/>
                    <span class="list_attr_name"><strong>Name</strong></span>
                    <span class="list_attr_content"><?php echo $name; ?></span>
                    <span class="edit_link">Edit</span>
                </form>
            </li>
            <li id="address">
                <form method="post" action="../actions/edit_restaurant.php">
                    <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>"/>
                    <input type="hidden" name="restaurant_id" value="<?= $id ?>"/>
                    <input type="hidden" name="type" value="address"/>
                    <span class="list_attr_name"><strong>Address</strong></span>
                    <span class="list_attr_content"><?php echo $address; ?></span>
                    <span class="edit_link">Edit</span>
                </form>
            </li>
            <li id="description">
                <form method="post" action="../actions/edit_restaurant.php">
                    <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>"/>
                    <input type="hidden" name="restaurant_id" value="<?= $id ?>"/>
                    <input type="hidden" name="type" value="description"/>
                    <span class="list_attr_name"><strong>Description</strong></span>
                    <span class="list_attr_content"><?php echo $description; ?></span>
                    <span class="edit_link">Edit</span>
                </form>
            </li>
            <li id="cost-for-two">
                <form method="post" action="../actions/edit_restaurant.php">
                    <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>"/>
                    <input type="hidden" name="restaurant_id" value="<?= $id ?>"/>
                    <input type="hidden" name="type" value="cost-for-two"/>
                    <span class="list_attr_name"><strong>Cost For Two</strong></span>
                    <span class="list_attr_content"><?php echo $costForTwo; ?></span>
                    <span class="edit_link">Edit</span>
                </form>
            </li>
            <li id="telephone-number">
                <form method="post" action="../actions/edit_restaurant.php">
                    <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>"/>
                    <input type="hidden" name="restaurant_id" value="<?= $id ?>"/>
                    <input type="hidden" name="type" value="telephone-number"/>
                    <span class="list_attr_name"><strong>Phone Number</strong></span>
                    <span class="list_attr_content"><?php echo $telephoneNumber; ?></span>
                    <span class="edit_link">Edit</span>
                </form>
            </li>
            <li id="working-hours">
                <form method="post" action="../actions/edit_restaurant.php">
                    <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>"/>
                    <input type="hidden" name="restaurant_id" value="<?= $id ?>"/>
                    <input type="hidden" name="type" value="working-hours"/>
                    <span class="list_attr_name"><strong>Workings Hours</strong></span>
                    <span class="list_attr_content">
                    <?php
                    if (isset($openingTime) && isset($closingTime)) {
                        echo '<span>' . sprintf("%02d:%02d", $openingHour, $openingMinute) . '</span>';
                        echo '<span> - </span>';
                        echo '<span>' . sprintf("%02d:%02d", $closingHour, $closingMinute) . '</span>';
                    }
                    ?>
                    </span>
                    <span class="edit_link">Edit</span>
                </form>
            </li>
            <li id="categories">
                <form method="post" action="../actions/edit_restaurant.php">
                    <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>"/>
                    <input type="hidden" name="restaurant_id" value="<?= $id ?>"/>
                    <input type="hidden" name="type" value="categories"/>
                    <span class="list_attr_name"><strong>Categories</strong></span>
                    <div class="list_attr_content">
                        <ul class="categories-list" id="current-categories">
                            <?php
                            $current_categories = getRestaurantCategories($id);
                            foreach ($current_categories as $category)
                                echo '<li class="category-box" value=' . $category['ID'] . '>' . $category['Name'] . '</li>';
                            ?>
                        </ul>
                        <ul class="categories-list" id="edit-categories" hidden="hidden">
                            <?php
                            $categories = getAllCategories();
                            var_dump($categories);
                            var_dump($current_categories);


                            foreach ($categories as $category) {
                                if (in_array($category['ID'], $current_categories))
                                    echo '<li class="category-box"><label><input type="checkbox" checked="checked" name="categories[]" "value="' . $category['ID'] . '">' . $category['Name'] . '</label></li>';
                                else
                                    echo '<li class="category-box"><label><input type="checkbox" name="categories[]" value="' . $category['ID'] . '">' . $category['Name'] . '</input></label></li>';
                            }
                            ?>
                        </ul>
                        <button hidden="hidden" class="confirm_btn">Confirm</button>
                        <input hidden="hidden" class="cancel_btn" type="reset" value="Cancel">
                    </div>
                    <span class="edit_link">Edit</span>
                </form>
            </li>
        </ul>
    </div>
    <div id="photos">
        <div class="section_title" id="photos-header">Photos</div>
        <div id="restaurant-gallery">
            <?php
            $photos = getRestaurantPhotos($id);
            if (count($photos) > 0) {
                echo '<div class="arrow_bg" id="left_arrow_bg">
            <i id="left-arrow" class="fa fa-chevron-left fa-4x" aria-hidden="true"></i>
            </div>';

                foreach ($photos as $photo) {
                    echo '<img class="rest-photo" src ="../' . $photo['Path'] . '">';
                    if ($photo['UploaderID'] === $ownerId)
                        $photoUploader = $name;
                    else
                        $photoUploader = getUserField($photo['UploaderID'], 'Name');
                }


                echo '
            <div class="arrow_bg" id="right_arrow_bg">
            <i id="right-arrow" class="fa fa-chevron-right fa-4x" aria-hidden="true"></i>
            </div>';
            }
            ?>
        </div>
        <?php
        if (count($photos) > 0)
            echo '<div class="photo-label" > Photo added by: ' . $photoUploader . '</div>';
        ?>

        <div id="photo-management">
            <span>Add some photos:</span>
            <form id="photos-form" method='post' action="../actions/upload_restaurant_photo.php"
                  enctype="multipart/form-data">
                <input type="hidden" id="token" name="token" value="<?= $_SESSION['token'] ?>"/>
                <input type="hidden" id="restaurant_id" name="restaurant_id" value="<?= $id ?>"/>
                <input name="photos[]" type="file" multiple="multiple"/>
                <button class="upload_photos" type="submit">Submit</button>
            </form>
            <button id="delete-photo">Delete Photo</button>
        </div>

