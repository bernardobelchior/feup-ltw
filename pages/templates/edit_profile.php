<?php
include_once('../database/users.php');
include_once('../utils/utils.php');

// Generate token for the update action
$_SESSION['token'] = generateRandomToken();

$id = htmlspecialchars($_GET['id']);
// Check for permissions or if the user is editing his/hers own profile.
if (!groupIdHasPermissions($_SESSION['groupId'], 'EDIT_ANY_PROFILE') &&
    $id !== $_SESSION['userId']
) {
    header('HTTP/1.0 403 Forbidden');
    header('Location: index.php?page=403.html');
    die();
}

if (!idExists($id)) {
    header('HTTP/1.0 404 Not Found');
    header('Location: index.php?page=404.html');
    die();
}

$profile_picture = getUserField($id, 'Picture');
if ($profile_picture === null)
    $profile_picture = '../profile_pictures/facebook-avatar.jpg';

?>

<link rel="stylesheet" href="../css/edit_profile.min.css">
<link rel="stylesheet" type="text/css" href="../css/common.min.css"/>
<script type="text/javascript" src="../js/edit_profile.js"></script>

<div class="page_content">
    <header class="page_title"><strong>Edit Profile</strong></header>
    <div id="general_info">
        <div class="section_title">General Info</div>
    </div>
    <ul id="profile_attr_list">
        <li id="photo">
            <form class="edit-field" action="../actions/upload_photo.php" enctype="multipart/form-data" method="post">
                <input type="hidden" name="type" value="username">
                <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['token']; ?>"/>
                <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                <span class="profile_picture_container">
                <img src="<?php echo '../' . $profile_picture ?>" alt="User's profile picture"/>
            </span>
                <span class="list_attr_content" hidden></span>
                <span id="change-photo-text" class="edit_link clickable"><i class="fa fa-pencil"></i>Change your profile picture</span>
            </form>
        </li>
        <li id="username">
            <span class="list_attr_name"><strong>Username</strong></span>
            <span class="list_attr_content"><?php echo getUserField($id, 'Username'); ?></span>
        </li>
        <li id="password">
            <form method="post" action="../actions/edit_profile.php">
                <input type="hidden" name="type" value="password">
                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>"/>
                <input type="hidden" name="profile_id" value="<?php echo $id; ?>"/>
                <span class="list_attr_name"><strong>Password</strong></span>
                <span class="list_attr_content">*****</span>
                <span class="edit_link clickable"><i class="fa fa-pencil"></i>Edit</span>
            </form>
        </li>
        <li id="name">
            <form method="post" action="../actions/edit_profile.php">
                <input type="hidden" name="type" value="name">
                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>"/>
                <input type="hidden" name="profile_id" value="<?php echo $id; ?>"/>
                <span class="list_attr_name"><strong>Name</strong></span>
                <span class="list_attr_content"><?php echo getUserField($id, 'Name'); ?></span>
                <span class="edit_link clickable"><i class="fa fa-pencil"></i>Edit</span>
            </form>
        </li>
        <li id="gender">
            <form method="post" action="../actions/edit_profile.php">
                <input type="hidden" name="type" value="gender">
                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>"/>
                <input type="hidden" name="profile_id" value="<?php echo $id; ?>"/>
                <span class="list_attr_name"><strong>Gender</strong></span>
                <span class="list_attr_content"><?php echo getUserField($id, 'Gender'); ?></span>
                <span class="edit_link clickable"><i class="fa fa-pencil"></i>Edit</span>
            </form>
        </li>
        <li id="email">
            <form method="post" action="../actions/edit_profile.php">
                <input type="hidden" name="type" value="email">
                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>"/>
                <input type="hidden" name="profile_id" value="<?php echo $id; ?>"/>
                <span class="list_attr_name"><strong>E-mail</strong></span>
                <span class="list_attr_content"><?php echo getUserField($id, 'Email'); ?></span>
                <span class="edit_link clickable"><i class="fa fa-pencil"></i>Edit</span>
                <span class="output" id="email-output"></span>
            </form>
        </li>
        <li id="dob">
            <form method="post" action="../actions/edit_profile.php">
                <input type="hidden" name="type" value="dob">
                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>"/>
                <input type="hidden" name="profile_id" value="<?php echo $id; ?>"/>
                <span class="list_attr_name"><strong>Date of Birth</strong></span>
                <span class="list_attr_content"><?php echo getUserField($id, 'DateOfBirth'); ?></span>
                <span class="edit_link clickable"><i class="fa fa-pencil"></i>Edit</span>
                <span class="output" id="dob-output"></span>
            </form>
        </li>
    </ul>
</div>
