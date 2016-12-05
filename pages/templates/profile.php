<link rel="stylesheet" href="../css/profile.min.css">
<link rel="stylesheet" href="../css/common.min.css">
<script type="application/javascript" src="../js/profile.js"></script>

<?php
include_once('../database/users.php');
include_once('../database/restaurants.php');
include_once('utils/utils.php');

$_SESSION['token'] = generateRandomToken();
$id = (int)htmlspecialchars($_GET['id']);

if (!idExists($id)) {
    header('HTTP/1.0 404 Not Found');
    header('Location: 404.php');
    die();
}

$username = getUserField($id, 'Username');
$email = getUserField($id, 'Email');
$name = getUserField($id, 'Name');
$profile_picture = getUserField($id, 'Picture');

if($profile_picture === null)
    $profile_picture = 'profile_pictures/facebook-avatar.jpg';

?>
<div class="page_content">
    <header>
        <span id="user_picture"></span>
        <div id="user_realname">
            <strong>
                <?php echo $name ?>
            </strong>
        </div>
        <div id="user_username">
            <?php echo $username ?>
        </div>
    </header>
    <div id="profile" class="container">
        <div id="profile-header">
            <?php
            if (groupIdHasPermissions((int)$_SESSION['groupId'], 'EDIT_ANY_PROFILE') || (int)$_SESSION['userId'] === $id) {
                echo '<form id="edit-profile" action="edit_profile.php" method="post">';
                echo '<input type="hidden" name="id" value="' . $id . '">';
                echo '<input type="hidden" name="token" value="' . $_SESSION['token'] . '">';
                echo '<button type="submit">Edit Profile</button>';
                echo '</form>';
            }
            ?>
        </div>
    </div>
    <div>
        <span id="email">Email: </span>
        <span> <?php echo $email; ?></span>
    </div>

    <div class="image">
        <img src="<?php echo '../' . $profile_picture; ?>" alt="User profile picture"/>
    </div>

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
        echo '<a href="add_restaurant.php">';
        echo '<button type="submit">Add Restaurant</button>';
        echo '</a>';
        echo '</div>';
    }
    ?>
</div>
