<link rel="stylesheet" href="../css/edit_profile.min.css">
<link rel="stylesheet" type="text/css" href="../css/common.min.css"/>
<?php
include_once('../database/users.php');
if (groupIdHasPermissions($_SESSION['groupId'], 'EDIT_ANY_PROFILE') ||
    !isset($_GET['id']) || $_GET['id'] === $_SESSION['userId']
)
    $id = $_GET['id'];
else {
    header('HTTP/1.0 404 Not Found');
    header('Location: 404.php');
}
?>
<script type="text/javascript" src="../js/edit_profile.js"></script>

<div class="page_content">
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
<!--        <input id="email" type="email" name="email" value="--><?php //echo getUserField($id, 'Email'); ?><!--"/>-->
<!--        <input id="date" type="text" name="date" placeholder="yyyy-mm-dd"-->
<!--               value="--><?php //echo getUserField($id, 'DateOfBirth'); ?><!--"/>-->
<!---->
<!--        <select id="gender" name="gender" gender=--><?php //echo getUserField($id, 'Gender'); ?><!-->-->
<!--            <option value="M">Male</option>-->
<!--            <option value="F">Female</option>-->
<!--        </select>-->
<!---->
<!--        <button type="submit">Update</button>-->
<!--        <span id="output"></span>-->
<!--    </form>-->
<!---->
<!--    <button id="change_password">Change Password</button>-->
</div>
