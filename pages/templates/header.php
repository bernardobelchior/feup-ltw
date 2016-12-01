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
                echo '<button id="logout" type="submit"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</button>';
                echo '</form>';
            } else {
                echo '<form action="login.php">';
                echo '<button id="login" type="submit"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</button>';
                echo '</form>';
                echo '<form action="sign_up.php">';
                echo '<button id="sign-up" type="submit"><i class="fa fa-sign-up" aria-hidden="true"></i> Sign Up</button>';
                echo '</form>';
            }
            ?>
        </li>
    </ul>
</div>
<div id="spacing"></div>
