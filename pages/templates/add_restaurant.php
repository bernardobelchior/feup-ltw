<?php
include_once('../database/users.php');
include_once('utils/utils.php');

if (groupIdHasPermissions($_SESSION['groupId'], 'ADD_ANY_RESTAURANT')) {
    header('HTTP/1.0 403 Forbidden');
    header('Location: 403.php');
    die();
}

$_SESSION['token'] = generateRandomToken();
?>
<link rel="stylesheet" type="text/css" href="../css/common.min.css"/>

<form id="add-restaurant" class="container" action="actions/add_restaurant.php" method="post">
    <input name="token" type="hidden" value="<?php echo $_SESSION['token']; ?>">
    <input name="name" type="text" placeholder="Name" required>
    <input name="address" type="text" placeholder="Address" required>
    <textarea name="description" placeholder="Description"></textarea>
    <button type="submit">Submit</button>
</form>