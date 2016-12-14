<?php
include_once('../database/users.php');
include_once('../database/restaurants.php');
include_once('../utils/utils.php');

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

<div class="page_content">
    <div class="user_presentation">
        <div class="profile_picture_container">
            <img id="profile_picture" alt="User's Profile Picture" src="<?php echo '../' . $profile_picture; ?>"/>
        </div>
        <div id="profile" class="container">
            <ul>
                <li id="name"><?php echo $name ?>
                <?php
                if (groupIdHasPermissions((int)$_SESSION['groupId'], 'EDIT_ANY_PROFILE') || (int)$_SESSION['userId'] === $id)
                    echo '<a id="edit-profile" href="index.php?page=edit_profile.php&id=' . $id . '"><button>Edit Profile</button></a>';
                ?></li>
                <li id="email"><?php echo $email ?></li>
                <li id="username" hidden><?php echo $username ?></li>
            </ul>
        </div>
    </div>

    <div class="container" id="restaurants">
        <?php

        /* Show all the restaurant the user has. */
        if (isset($_GET['id'])) {
            $restaurants = getUserRestaurants(htmlspecialchars($_GET['id']));

            foreach ($restaurants as $restaurant) {
                echo '<div class="restaurant-container" onclick="openRestaurantProfile(' . $restaurant['ID'] . ')">';
                // echo image
                echo '<span>' . (string)$restaurant['Name'] . '</span>';
                echo '<span>' . (string)$restaurant['Address'] . '</span>';
                echo '</div>';
            }
        }

        /* Shows the add restaurant button if the user has permission to add a restaurant. */
        if ((isset($_SESSION['groupId']) && groupIdHasPermissions($_SESSION['groupId'], 'ADD_ANY_RESTAURANT')) || (isset($_SESSION['userId']) && (int)$_SESSION['userId'] === $id)) {
            $_SESSION['ownerId'] = $id;
            echo '<div class="restaurant-container">';
            echo '<a href="index.php?page=add_restaurant.php">';
            echo '<button type="submit">Add Restaurant</button>';
            echo '</a>';
            echo '</div>';
        }
        ?>
</div>
</div>

