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

<p>
    Edit profile
</p>

<form id="form" method="post" action="actions/edit_profile.php" onsubmit="return validateDate();">
    <label id="username"> <?php echo getUserField($id, 'Username'); ?>
    </label>
    <input id="name" type="text" name="name" value="<?php echo getUserField($id, 'Name'); ?>"/>
    <input id="email" type="email" name="email" value="<?php echo getUserField($id, 'Email'); ?>"/>
    <input id="date" type="text" name="date" placeholder="yyyy-mm-dd"
           value="<?php echo getUserField($id, 'DateOfBirth'); ?>"/>

    <select id="gender" name="gender" gender=<?php echo getUserField($id, 'Gender'); ?>>
        <option value="">Undefined</option>
        <option value="M">Male</option>
        <option value="F">Female</option>
    </select>

    <button type="submit">Update</button>
    <span id="output"></span>
</form>

<button id="change_password">Change Password</button>
