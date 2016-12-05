<?php session_start(['cookie_httponly' => true]); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <script
            src="https://code.jquery.com/jquery-3.1.1.min.js"
            integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
            crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/490d8b8016.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/header.min.css"/>
    <script src="/js/header.js"></script>
</head>
<body>
<div class="overlay"></div>
<div class="top-bar">
    <ul>
        <li id="home_button"><a href="../index.php">Home</a></li>
            <?php
            if (isset($_SESSION['username'])) {
                echo '<li id="greeting">
                    Hello, <a href="profile.php?id=' . $_SESSION['userId'] . '">' . $_SESSION['name'] . '</a>!
                    </li>';
            }
            ?>
        <li id="user_action">
            <?php
            if (isset($_SESSION['username'])) {
                echo '<form id="logout_form" action="actions/logout.php">';
                echo '<button id="logout" type="submit"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</button>';
                echo '</form>';
            } else {
                echo '<span id="user_login">';
                echo '<span id="login_text">Log In</span>';
                echo '<form id="login_form" method="post" action="actions/login.php">';
                    echo '<input type="text" name="username" placeholder="Your Username"/>';
                    echo '<input type="password" name="password" placeholder="Your Password"/>';
                    echo '<button id="enter" type="submit">Enter</button>';
                echo '</form>';
                echo '</span>';
                echo '<span id="sign_up_text">Not a Member?</span>';
                echo '</form>';
            }
            ?>
        </li>
    </ul>
</div>
<div id="spacing"></div>
