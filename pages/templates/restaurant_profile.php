<?php
include_once('../database/restaurants.php');

$id = (int) htmlspecialchars($_GET['id']);

if (!isset($id)) {
    header('HTTP/1.0 404 Not Found');
    header('Location: 404.php');
    die();
}

$restaurantInfo = getRestaurantInfo($id);
$ownerId = $restaurantInfo['OwnerID'];
$name = $restaurantInfo['Name'];
$address = $restaurantInfo['Address'];
$description = $restaurantInfo['Description'];
unset($restaurantInfo);
?>

<link rel="stylesheet" href="../css/common.min.css">

<div id="restaurant-profile" class="container">
    <!-- photo -->
    <div>
        <?php echo $name; ?>
    </div>

    <div>
        <?php echo $address; ?>
    </div>

    <div>
        <?php echo $description; ?>
    </div>
</div>


