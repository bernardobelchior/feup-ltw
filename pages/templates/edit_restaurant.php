<?php
include_once('../database/restaurants.php');
include_once('../database/users.php');
include_once('utils/utils.php');

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
<link rel="stylesheet" href="../css/restaurant_profile.min.css">

<script type="text/javascript" src="../js/edit_restaurant.js"></script>

<div id="restaurant-profile" class="container">
  <input type="hidden" id="token" name="token" value="<?php echo $_SESSION['token']; ?>"/>
  <input type="hidden" id="restaurant_id" name="restaurant_id" value="<?php echo $id; ?>"/>
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
      <li id="categories">
        <span class="list_attr_name"><strong>Categories</strong></span>
        <span class="list_attr_content"><?php $categories = getRestaurantCategories($id);
                  for($i=0; $i < count($categories); $i++){
                    if($i !== 0)
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
              if(in_array($category['Name'], $current_categories_names))
                echo '<li class="category-box"><label><input type="checkbox" checked="true" name="categories[]" value="' . $category['ID'] . '">' . $category['Name'] . '</label></li>';
              else
                echo '<li class="category-box"><label><input type="checkbox" name="categories[]" value="' . $category['ID'] . '">' . $category['Name'] . '</input></label></li>';
            }
            ?>
        </ul>

      </div>
