<p>
    User profile
</p>

<?php include_once('../database/users.php'); ?>

<form id="form" method="post" action="actions/update_profile.php" onsubmit="return validateForm();">
    <input id="username" type="text" name="username" value=<?php echo $_SESSION['username'];?> />
    <input id="password" type="password" name="password" placeholder="Password"/>
    <input id="password-repeat" type="password" name="password-repeat" placeholder="Repeat your Password"/>
    <input id="email" type="email" name="email" value=<?php echo getUserField($_SESSION['username'], 'Email');?> />
    <input id="name" type="text" name="name" value=<?php echo getUserField($_SESSION['username'], 'Name');?> />
    <input id="date" type="date" name="birthdate" value=<?php echo getUserField($_SESSION['username'], 'DateOfBirth');?> />

    <select id="gender" name="gender">
        <option value="M">Male</option>
        <option value="F">Female</option>
    </select>

    <button type="submit">Update</button>
    <span id="output"></span>
</form>
