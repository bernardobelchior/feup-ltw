<?php session_start(['cookie_httponly' => true]); ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <script
                src="https://code.jquery.com/jquery-3.1.1.min.js"
                integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
                crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="/css/header.min.css"/>
    </head>
<body>

<div class="top-bar">
    <ul>
        <li id="home_button"><a href="../index.php">Home</a></li>
        <li id="greeting">
                <?php
                if (isset($_SESSION['username'])) {
                    echo 'Hello, <a href="profile.php?id=' . $_SESSION['userId'] . '">' . $_SESSION['name'] . '</a>!';
                }
                ?>
        </li>
        <li id="user_action">
                <?php
                if (isset($_SESSION['username'])) {
                    echo '<form action="actions/logout.php">';
                    echo '<input id="login" type="submit" value="Logout"/>';
                    echo '</form>';
                } else {
                    echo '<form action="login.php">';
                    echo '<input id="login" type="submit" value="Login"/>';
                    echo '</form>';
                    echo '<form action="sign_up.php">';
                    echo '<input id="sign-up" type="submit" value="Sign up"/>';
                    echo '</form>';
                }
                ?>
        </li>
    </ul>
</div>
<div id="spacing"></div>
