<link rel="stylesheet" href="../css/profile.min.css">

<?php
include_once('../database/users.php');

$id = (int)$_GET['id'];

if (!idExists($id)) {
    header('HTTP/1.0 404 Not Found');
    header('Location: 404.php');
}

$username = getUserField($id, 'Username');
$email = getUserField($id, 'Email');
$name = getUserField($id, 'Name');

?>
<div id="profile" class="container">
    <div id="profile-header">
        <div id="user-identification">
            <span id="name">
                <?php echo $name; ?>
            </span>
            <span id="username">
                (<?php echo $username; ?>)
            </span>
        </div>

        <?php
        if (groupIdHasPermissions((int)$_SESSION['groupId'], 'EDIT_ANY_PROFILE') || (int)$_SESSION['userId'] === $id) {
            echo '<div id="edit-profile">';
            echo '<a href="edit_profile.php?id=' . $id . '"><button>Edit Profile</button></a>';
            echo '</div>';
        }
        ?>
    </div>

    <div>
        <span id="email">Email: </span>
        <span> <?php echo $email; ?></span>
    </div>

    <div class="image">
        <img src="" alt="User profile picture"/>
    </div>

</div>

<div class="container" id="restaurants">
    <?php
    if (groupIdHasPermissions($_SESSION['groupId'], 'ADD_ANY_RESTAURANT') || (int)$_SESSION['userId'] === $id) {
        echo '<a href="add_restaurant.php?id=' . $id . '">';
        echo '<button type="submit">Add Restaurant</button>';
        echo '</a>';
    }
    ?>
</div>
