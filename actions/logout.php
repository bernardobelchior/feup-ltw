<?php
session_start(['cookie_httponly' => true]);

if (isset($_SESSION['username'])) {
    $_SESSION = array();
    session_regenerate_id(true);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die();
}
