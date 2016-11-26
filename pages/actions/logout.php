<?php
echo 'Hello!';
if(isset($_SESSION['username'])) {
    unset($_SESSION['username']);
    session_destroy();
    header('Location: ../logout.php');
}
