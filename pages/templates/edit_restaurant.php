<?php
include_once('../database/restaurants.php');
include_once('../database/users.php');
include_once('../utils.php');

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
if(isset($openingTime) && isset($closingTime)){
  $openingHour = intval($openingTime);
  $openingMinute = ($openingTime - $openingHour) * 60;
  $closingHour = intval($closingTime);
  $closingMinute = ($closingTime - $closingHour) * 60;
}


$_SESSION['ownerId'] = $ownerId;
unset($restaurantInfo);
?>

<link rel="stylesheet" href="../css/common.min.css">
<link rel="stylesheet" href="../css/restaurant_profile.min.css">

<script type="text/javascript" src="../js/edit_restaurant.js"></script>

<div id="restaurant-profile" class="container">
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
            <span class="list_attr_name"><strong>TelephoneNumber</strong></span>
            <span class="list_attr_content"><?php echo $telephoneNumber; ?></span>
            <span class="edit_link">Edit</span>
        </li>
        <li class="hour" id="opening">
            <span class="list_attr_name"><strong>Opening Hour</strong></span>
              <select class="select-time" id="opening-time">
                <?php
                for ($i=0; $i<24; $i++){
                  for($j=0;$j<2;$j++){
                    if($i + $j * 0.5 == $openingTime)
                      echo sprintf('<option selected="selected" value="%d">%02d:%02d</option>', $i*10+$j*5, $i, $j*30);
                    else
                      echo sprintf('<option value="%d">%02d:%02d</option>', $i*10+$j*5, $i, $j*30);
                  }
                }
                ?>
            </select>
            <span class="list_attr_content"><?php if(isset($openingHour)) echo sprintf("%02d:%02d", $openingHour, $openingMinute); ?></span>
            <span class="edit_link">Edit</span>
        </li>
        <li class="hour" id="closing">
            <span class="list_attr_name"><strong>Closing Hour</strong></span>
            <select class="select-time" id="closing-time">
              <?php
              for ($i=0; $i<24; $i++){
                for($j=0;$j<2;$j++){
                  if($i + $j * 0.5 == $closingTime)
                    echo sprintf('<option selected="selected" value="%d">%02d:%02d</option>', $i*10+$j*5, $i, $j*30);
                  else
                    echo sprintf('<option value=%d>%02d:%02d</option>', $i*10+$j*5, $i, $j*30);
                }
              }
              ?>
            </select>
            <span class="list_attr_content"><?php if(isset($closingHour)) echo sprintf("%02d:%02d", $closingHour, $closingMinute); ?></span>
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
        <li id="photos">
            <span class="list_attr_name"><strong>Photos</strong></span>
            <script src="../js/restaurant_profile.js"></script>

            <div id="restaurant-gallery">
                <?php
                $photos = getRestaurantPhotos($id);

                if (count($photos) > 0) {
                    echo '<i id="left-arrow" class="fa fa-chevron-left fa-4x" aria-hidden="true"></i>
                          <div>';

                    foreach ($photos as $photo) {
                        echo '<img class="photo" src="' . '../' . $photo['Path'] . '" alt="Restaurant photo"></img>';
                    }

                    echo '</div>
                          <i id="right-arrow" class="fa fa-chevron-right fa-4x" aria-hidden="true"></i>';
                }
                ?>
            </div>
            <button id="delete-photo">Delete Photo</button>
</div>
<form id="delete-restaurant" method="post" action="../actions/delete_restaurant.php">
    <input type="hidden" id="token" name="token" value="<?= $_SESSION['token'] ?>"/>
    <input type="hidden" id="restaurant_id" name="restaurant_id" value="<?= $id ?>"/>
    <button type="submit">Delete Restaurant</button>
</form>
