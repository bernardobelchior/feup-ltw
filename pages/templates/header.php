<?php session_start(['cookie_httponly' => true]);
include_once('../utils.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <script
            src="https://code.jquery.com/jquery-3.1.1.min.js"
            integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
            crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="../css/header.min.css"/>
    <link rel="stylesheet" type="text/css" href="../font-awesome-4.7.0/css/font-awesome.min.css"/>
    <script src="../js/header.js"></script>
    <script src="../js/sign_up.js"></script>
</head>
<body>

<div id="wrapper">
    <div class="top-bar">
        <ul>
            <li id="home_button"><a href="../index.php">Home</a></li>
            <?php
            if (isset($_SESSION['username'])) {
                echo '<li id="greeting">
                    Hello, <a href="index.php?page=profile.php&id=' . $_SESSION['userId'] . '">' . $_SESSION['name'] . '</a>!
                    </li>';
            }
            ?>
            <li id="user_action">
                <?php
                if (isset($_SESSION['username'])) {
                    echo '<form id="logout_form" action="../actions/logout.php" method="post">';
                    echo '<button id="logout" type="submit"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</button>';
                    echo '</form>';
                } else {
                    echo '<div id="user_login">';
                    echo '<span id="login_text">Log In</span>';
                    echo '<form id="login_form" method="post" action="../actions/login.php">';
                    echo '<input type="text" name="username" placeholder="Your Username"/>';
                    echo '<input type="password" name="password" placeholder="Your Password"/>';
                    echo '<button id="enter" type="submit">Enter</button>';
                    echo '</form>';
                    echo '</div>';
                    echo '<span id="sign_up_text">Not a Member?</span>';
                }
                ?>
            </li>
        </ul>
    </div>

    <!-- TODO: Check for $_SESSION['signup-error'].
     If it is set, then there was an error in signup and the signup form should open
     immediately.
    Don't forget to unset it afterwards.
     -->
    <div class="overlay" hidden="hidden">
        <div id="sign_up_overlay">
            <?php $_SESSION['signup-token'] = generateRandomToken(); ?>

            <div id="signup_form">
                <div class="overlay_title"><strong>Sign Up</strong></div>
                <form id="sign_up_form" method="post" action="../actions/sign_up.php" onsubmit="return validateForm();">
                    <input id="username" type="text" name="username" placeholder="Username" required/>
                    <input id="password" type="password" name="password" placeholder="Password" required/>
                    <input id="password-repeat" type="password" name="password-repeat"
                           placeholder="Repeat your Password"
                           required/>
                    <input id="email" type="email" name="email" placeholder="Email" required/>
                    <input id="name" type="text" name="name" placeholder="Name" required/>

                    <!-- Upload picture -->
                    <input type="hidden" name="signup-token" value="<?php echo $_SESSION['signup-token']; ?>">
                    <button type="submit">Submit</button>
                    <span id="output"></span>
                </form>
            </div>
        </div>
    </div>

