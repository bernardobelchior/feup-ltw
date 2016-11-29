<?php
$id = (int)$_GET['id'];

if (groupIdHasPermissions($_SESSION['groupId'], 'ADD_ANY_RESTAURANT') ||
    !isset($id) || (int)$_SESSION['userId'] === $id
) {
    header('HTTP/1.0 404 Not Found');
    header('Location: 404.php');
} else
    $_POST['ownerId'] = $id;
?>
<form id="add-restaurant" action="actions/add_restaurant.php" method="post">
    <input name="name" type="text" placeholder="Name" required>
    <input name="address" type="text" placeholder="Address" required>
    <textarea name="description" placeholder="Description"></textarea>
    <button type="submit">Submit</button>
</form>