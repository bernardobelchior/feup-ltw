<p>
    Edit profile
</p>

<!-- <link rel="stylesheet" href="../css/sign_up.css"> -->
<?php session_start(); include_once('../database/users.php'); ?>
<script type="text/javascript" src="../js/edit_profile.js"></script>

<form id="form" method="post" action="actions/edit_profile.php" onsubmit="return validateDate();">
  <label id="username"> <?php echo $_SESSION['username'];?> </label>
  <input id="name" type="text" name="name" value=<?php echo getUserField($_SESSION['username'], 'Name');?> />
  <input id="email" type="email" name="email" value=<?php echo getUserField($_SESSION['username'], 'Email');?> />
  <input id="date" type="text" name="date" placeholder="yyyy-mm-dd" value=<?php echo getUserField($_SESSION['username'], 'DateOfBirth');?> />

    <select id="gender" name="gender" gender=<?php echo getUserField($_SESSION['username'], 'Gender');?>>
        <option value="">Undefined</option>
        <option value="M">Male</option>
        <option value="F">Female</option>
    </select>

    <button type="submit">Update</button>
    <span id="output"></span>
</form>

<button id="change_password">Change Password</button>
