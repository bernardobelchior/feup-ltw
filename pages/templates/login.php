<link rel="stylesheet" type="text/css" href="/css/common.min.css"/>

<form method="post" action="actions/login.php">
    <input type="text" name="username" placeholder="Username"/>
    <input type="password" name="password" placeholder="Password"/>
    <?php
    if ($_SESSION['login-error'])
        echo '<span id="output">' . $_SESSION['login-error'] . '</span>';
        unset($_SESSION['login-error']);
    ?>
    <button type="submit">Login</button>
</form>
