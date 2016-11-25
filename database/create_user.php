<?php

if ($_POST['name'] && $_POST['password'] && $_POST['email'] && $_POST['name'] && $_POST['birthdate'] && $_POST['gender'] /* && $_POST['picture']*/) {
    $password = $_POST['password'];

    if(strlen($password) < 8)
        echo 'Password is too short.';


    echo json_encode($_POST);
}
