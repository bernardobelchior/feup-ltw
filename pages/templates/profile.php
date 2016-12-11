<?php
include_once('../database/users.php');
include_once('../database/restaurants.php');
include_once('utils/utils.php');

$id = (int)htmlspecialchars($_GET['id']);

if (!idExists($id)) {
    header('HTTP/1.0 404 Not Found');
    header('Location: index.php?page=404.html');
    die();
}

$username = getUserField($id, 'Username');
$email = getUserField($id, 'Email');
$name = getUserField($id, 'Name');
$profile_picture = getUserField($id, 'Picture');

if ($profile_picture === null)
    $profile_picture = 'profile_pictures/facebook-avatar.jpg';

?>

<link rel="stylesheet" href="../css/profile.min.css">
<link rel="stylesheet" href="../css/common.min.css">
<script type="application/javascript" src="../js/common.js"></script>

<div id="profile" class="container">
    <div>
        <div id="name">
            <?php echo $name ?>
        </div>

        <div id="username">
            <?php echo $username ?>
        </div>

        <span id="email">Email: </span>
        <span> <?php echo $email; ?></span>
    </div>

    <div>
        <?php
        if (groupIdHasPermissions((int)$_SESSION['groupId'], 'EDIT_ANY_PROFILE') || (int)$_SESSION['userId'] === $id)
            echo '<a id="edit-profile" href="index.php?page=edit_profile.php&id=' . $id . '"><button>Edit Profile</button></a>';
        ?>

        <img id="profile-picture" src="<?php echo '../' . $profile_picture; ?>" alt="User profile picture"/>
    </div>
</div>

<div class="container" id="restaurants">
    <?php

    /* Show all the restaurant the user has. */
    $restaurants = getUserRestaurants($_SESSION['userId']);

    foreach ($restaurants as $restaurant) {
        echo '<div class="restaurant-container" onclick="openRestaurantProfile(' . $restaurant['ID'] . ')">';
        // echo image
        echo '<span>' . (string)$restaurant['Name'] . '</span>';
        echo '<span>' . (string)$restaurant['Address'] . '</span>';
        echo '</div>';
    }

    /* Shows the add restaurant button if the user has permission to add a restaurant. */
    if (groupIdHasPermissions($_SESSION['groupId'], 'ADD_ANY_RESTAURANT') || (int)$_SESSION['userId'] === $id) {
        $_SESSION['ownerId'] = $id;
        echo '<div class="restaurant-container">';
        echo '<a href="index.php?page=add_restaurant.php">';
        echo '<button type="submit">Add Restaurant</button>';
        echo '</a>';
        echo '</div>';
    }
    ?>
</div>
