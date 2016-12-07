<?php
include_once('templates/header.php');

if($_GET['page'] === 'add_restaurant.php') include_once('templates/add_restaurant.php');
else if($_GET['page'] === 'edit_profile.php') include_once('templates/edit_profile.php');
else if($_GET['page'] === 'landing_page.php') include_once('templates/landing_page.php');
else if($_GET['page'] === 'login.php') include_once('templates/login.php');
else if($_GET['page'] === 'profile.php') include_once('templates/profile.php');
else if($_GET['page'] === 'restaurant_profile.php') include_once('templates/restaurant_profile.php');
else if($_GET['page'] === 'search_results.php') include_once('templates/search_results.php');
else if($_GET['page'] === 'sign_up.php') include_once('templates/sign_up.php');
else if($_GET['page'] === '403.html') include_once('templates/403.html');
else include_once('templates/404.html');

include_once('templates/footer.html');
