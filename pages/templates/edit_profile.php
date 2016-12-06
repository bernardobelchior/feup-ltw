<?php
include_once('../database/users.php');
include_once('utils/utils.php');

// Check if the user did not come from the profile page.
if ($_SESSION['token'] !== $_POST['token']) {
    header('HTTP/1.0 403 Forbidden');
    header('Location: 403.php');
    die();
}

// Generate token for the update action
$_SESSION['token'] = generateRandomToken();

$id = htmlspecialchars($_POST['id']);
// Check for permissions or if the user is editing his/hers own profile.
if (!groupIdHasPermissions($_SESSION['groupId'], 'EDIT_ANY_PROFILE') &&
    $id !== $_SESSION['userId']
) {
    header('HTTP/1.0 404 Not Found');
    header('Location: 404.php');
    die();
}
?>

<link rel="stylesheet" href="../css/edit_profile.min.css">
<link rel="stylesheet" type="text/css" href="../css/common.min.css"/>
<script type="text/javascript" src="../js/edit_profile.js"></script>

<div class="container">
    <header class="page_title"><strong>Edit Profile</strong></header>
    <div id="general_info">
        <div class="section_title">General Info</div>
    </div>
    <ul id="profile_attr_list">
        <li id="username">
            <span class="list_attr_name"><strong>Username</strong></span>
            <span class="list_attr_content"><?php echo getUserField($id, 'Username'); ?></span>
            <span class="edit_link">Edit</span>
        </li>
        <li id="name">
            <span class="list_attr_name"><strong>Name</strong></span>
            <span class="list_attr_content"><?php echo getUserField($id, 'Name'); ?></span>
            <span class="edit_link">Edit</span>
        </li>
        <li id="gender">
            <span class="list_attr_name"><strong>Gender</strong></span>
            <span class="list_attr_content"><?php echo getUserField($id, 'Gender'); ?></span>
            <span class="edit_link">Edit</span>
        </li>
        <li id="email">
            <span class="list_attr_name"><strong>e-mail</strong></span>
            <span class="list_attr_content"><?php echo getUserField($id, 'Email'); ?></span>
            <span class="edit_link">Edit</span>
        </li>
        <li id="dob">
            <span class="list_attr_name"><strong>Date of Birth</strong></span>
            <span class="list_attr_content"><?php echo getUserField($id, 'DateOfBirth'); ?></span>
            <span class="edit_link">Edit</span>
        </li>

    </ul>
    <!--    <form id="form" method="post" action="actions/edit_profile.php" onsubmit="return validateDate();">-->
    <!--        <label id="username"> --><?php //echo getUserField($id, 'Username'); ?>
    <!--        </label>-->
    <!--        <input id="name" type="text" name="name" value="--><?php //echo getUserField($id, 'Name'); ?><!--"/>-->
    <!--        <input id="email" type="email" name="email" value="-->
    <?php //echo getUserField($id, 'Email'); ?><!--"/>-->
    <!--        <input id="date" type="text" name="date" placeholder="yyyy-mm-dd"-->
    <!--               value="--><?php //echo getUserField($id, 'DateOfBirth'); ?><!--"/>-->
    <!---->
    <!--        <select id="gender" name="gender" gender=--><?php //echo getUserField($id, 'Gender'); ?><!-->
    <!--            <option value="M">Male</option>-->
    <!--            <option value="F">Female</option>-->
    <!--        </select>-->
    <!---->
    <!--        <button type="submit">Update</button>-->
    <!--        <span id="output"></span>-->
    <!--    </form>-->
    <!---->

    <form action="actions/upload_photo.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="update-token" value="<?php echo $_SESSION['token']; ?>"/>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        Photo: <input type="file" name="photo" accept="image/*" required/>
        <button type="submit">Upload Photo</button>
    </form>

    <!-- Trigger/Open The Modal -->
    <button id="change-pass-btn">Change Password</button>

    <!-- The Modal -->
    <div id="change-pass-modal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">x</span>
            <form id="change-pass-form" method="post" action="actions/change_password.php"
                  onsubmit="return validateNewPassword();">
                <input id="old-password" type="password" name="old-password" placeholder="Current Password"/>
                <input id="new-password" type="password" name="new-password" placeholder="New Password"/>
                <input id="new-password-repeat" type="password" name="new-password-repeat"
                       placeholder="Repeat New Password"/>
                <button type="submit">Change Password</button>
                <span id="password-output"/>
            </form>
        </div>
    </div>
