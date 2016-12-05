<form method="post" action="actions/login.php">
    <input type="text" name="username" placeholder="Username"/>
    <input type="password" name="password" placeholder="Password"/>
    <?php
    if ($_SESSION['error'])
        echo '<span id="output">' . $_SESSION['error'] . '</span>';
        unset($_SESSION['error']);
    ?>
    <button type="submit">Login</button>
</form>
