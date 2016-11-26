<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <script
            src="https://code.jquery.com/jquery-3.1.1.min.js"
            integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
            crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="/css/header.css"/>
</head>
<body>

<div class="top-bar">
    <div class="left">
        <a href="../index.php">Home</a>
    </div>

    <div class="right">
        <?php
        if (isset($_SESSION['username'])) {
            echo '<form action="/pages/logout.php">';
            echo '<input id="login" type="submit" value="Logout"/>';
            echo '</form>';
        } else {
            echo '<form action="/pages/login.php">';
            echo '<input id="login" type="submit" value="Login"/>';
            echo '</form>';
            echo '<form action="/pages/sign_up.php">';
            echo '<input id="sign-up" type="submit" value="Sign up"/>';
            echo '</form>';
        }
        ?>
    </div>
</div>
