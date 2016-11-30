<link rel="stylesheet" href="../css/profile.min.css">
<link rel="stylesheet" href="../css/common.min.css">

<?php
include_once('../database/users.php');
include_once('utils/utils.php');

$_SESSION['token'] = generate_random_token();
$id = (int)htmlspecialchars($_GET['id']);

if (!idExists($id)) {
    header('HTTP/1.0 404 Not Found');
    header('Location: 404.php');
    die();
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
            $_POST['token'] = $_SESSION['token'];
            var_dump($_POST['token']);
            echo '<form id="edit-profile" action="edit_profile.php" method="post">';
            echo '<input type="hidden" name="id" value="' . $id . '">';
            echo '<input type="hidden" name="token" value="' . $_SESSION['token'] . '">';
            echo '<button type="submit">Edit Profile</button>';
            echo '</form>';
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
        $_SESSION['ownerId'] = $id;
        echo '<a href="add_restaurant.php">';
        echo '<button type="submit">Add Restaurant</button>';
        echo '</a>';
    }
    ?>
</div>
