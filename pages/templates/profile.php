<link rel="stylesheet" href="../css/profile.min.css">

<?php
include_once('../database/users.php');

$id = (int)$_GET['id'];

if (!idExists($id)) {
    echo '<p> User not found </p>';
    die();
}

$username = getUserField($id, 'Username');
$email = getUserField($id, 'Email');
$name = getUserField($id, 'Name');

?>
<div id="profile">
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
            echo '<form>';
            echo '<button type="submit" formaction="edit_profile.php">Edit Profile</button>';
            echo '</form>';
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
