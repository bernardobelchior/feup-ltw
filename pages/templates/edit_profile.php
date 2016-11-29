<p>
    Edit profile
</p>

<link rel="stylesheet" href="../css/edit_profile.min.css">
<?php session_start(); include_once('../database/users.php'); ?>
<script type="text/javascript" src="../js/edit_profile.js"></script>

<form id="change-profile-form" method="post" action="actions/edit_profile.php" onsubmit="return validateDate();">
  <label id="username"> <?php echo $_SESSION['username'];?> </label>
  <input id="name" type="text" name="name" value=<?php echo getUserField($_SESSION['userId'], 'Name');?> />
  <input id="email" type="email" name="email" value=<?php echo getUserField($_SESSION['userId'], 'Email');?> />
  <input id="date" type="text" name="date" placeholder="yyyy-mm-dd"><?php echo getUserField($_SESSION['userId'], 'DateOfBirth');?></input>

    <select id="gender" name="gender" gender=<?php echo getUserField($_SESSION['userId'], 'Gender');?>>
        <option value="">Undefined</option>
        <option value="M">Male</option>
        <option value="F">Female</option>
    </select>

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
