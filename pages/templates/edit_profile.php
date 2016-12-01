<link rel="stylesheet" href="../css/edit_profile.min.css">
<link rel="stylesheet" type="text/css" href="../css/common.min.css"/>
<?php
include_once('../database/users.php');
include_once('utils/utils.php');

// Check if the user did not come from the profile page.
if ($_SESSION['token'] !== $_POST['token']) {
    header('HTTP/1.0 403 Not Found');
    header('Location: 403.php');
    die();
}

// Generate token for the update action
$_SESSION['update-token'] = generateRandomToken();

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
<script type="text/javascript" src="../js/edit_profile.js"></script>

<header id="page_title">
    Edit Profile
</header>
<div id="general_info">
    <div class="section_title">General Info</div>
</div>
<form id="form" method="post" action="actions/edit_profile.php" onsubmit="return validateDate();">
    <label id="username"> <?php echo getUserField($id, 'Username'); ?>
    </label>
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <input id="name" type="text" name="name" value="<?php echo getUserField($_SESSION['userId'], 'Name');?>"/>
    <input id="email" type="email" name="email" value="<?php echo getUserField($id, 'Email'); ?>"/>
    <input id="date" type="text" name="date" placeholder="yyyy-mm-dd"
           value="<?php echo getUserField($id, 'DateOfBirth'); ?>"/>

    <select id="gender" name="gender" gender=<?php echo getUserField($id, 'Gender'); ?>>
        <option value="M">Male</option>
        <option value="F">Female</option>
    </select>

    <input type="hidden" name="update-token" value="<?php echo $_SESSION['update-token']; ?>">
    <button type="submit">Update</button>
    <span id="output"></span>
</form>

<!-- Trigger/Open The Modal -->
<button id="change-pass-btn">Change Password</button>

<!-- The Modal -->
<div id="change-pass-modal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">x</span>
    <form id="change-pass-form" method="post" action="actions/change_password.php" onsubmit="return validateNewPassword();">
      <input id="old-password" type="password" name="old-password" placeholder="Current Password"/>
      <input id="new-password" type="password" name="new-password" placeholder="New Password"/>
      <input id="new-password-repeat" type="password" name="new-password-repeat" placeholder="Repeat New Password"/>
      <button type="submit">Change Password</button>
      <span id="password-output"/>
    </form>
  </div>

</div>
