<?php session_start(['cookie_httponly' => true]);
include_once '../utils/utils.php';
$_SESSION['signup-token'] = generateRandomToken(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <script
            src="https://code.jquery.com/jquery-3.1.1.min.js"
            integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
            crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="../css/header.min.css"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway|Roboto">
    <link rel="stylesheet" type="text/css" href="../font-awesome-4.7.0/css/font-awesome.min.css"/>
    <script src="../js/header.js"></script>
    <script src="../js/sign_up.js"></script>
</head>
<body>
<div class="top-bar">
    <ul>
        <li id="home_button"><a href="../index.php">
                <img src="../res/eatr.png" alt="Eatr logo"> </a>
        </li>
        <li id="user-zone">
            <ul>
                <li id="user_header">
                    <?php
                    if (isset($_SESSION['username'])) {
                        echo '<span id="greeting">
                    Hello, <a href="index.php?page=profile.php&id=' . $_SESSION['userId'] . '">
                    <strong>' . $_SESSION['name'] . '</strong></a>!
                    </span>';
                    }
                    ?>
                </li>
                <li id="user_action">
                    <?php
                    if (isset($_SESSION['username'])) {
                        echo '<form id="logout_form" action="../actions/logout.php">';
                        echo '<button id="logout" class="form-button" type="submit"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</button>';
                        echo '</form>';
                    } else {
                        echo '<div id="user_login">';
                        echo '<span id="login_text">Log In</span>';
                        echo '<form id="login_form" method="post" action="../actions/login.php">';
                        echo '<input class="form-textbox" type="text" name="username" placeholder="Your Username"/>';
                        echo '<input class="form-textbox" type="password" name="password" placeholder="Your Password"/>';
                        echo '<button class="form-button" id="enter" type="submit">Enter</button>';
                        echo '</form>';
                        echo '</div>';
                        echo '<span class="divider">|</span>';
                        echo '<span id="sign_up_text">Not a Member?</span>';
                    }
                    ?>
                </li>
            </ul>
        </li>
    </ul>
</div>

<div class="spacing" style="margin-bottom: 4em"></div>

<div class="overlay" hidden="hidden">
    <div id="sign_up_overlay">
        <div id="signup_form">
            <h1>Sign Up</h1>
            <form id="sign_up_form">
                <input type="hidden" id="signup-token" value="<?= $_SESSION['signup-token'] ?>">
                <label id="username-label" for="username">Username</label>
                <input id="username" type="text" name="username" placeholder="Username" required tabindex="10"/>
                <div class="columns">
                    <div class="column">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" placeholder="Password" required
                               tabindex="11"/>

                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" placeholder="Email" required tabindex="13"/>
                        <button id="sign_up_cancel" class="form-button" type="button" onclick="closeSignUpModal()">
                            Cancel
                        </button>
                    </div>
                    <div class="column">
                        <label for="password-repeat">Repeat password</label>
                        <input id="password-repeat" type="password" name="password-repeat"
                               placeholder="Repeat your Password"
                               required tabindex="12"/>

                        <label for="name">Name</label>
                        <input id="name" type="text" name="name" placeholder="Name" required tabindex="14"/>
                        <button id="sign_up_submit" class="form-button" type="button">Sign Up!</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
