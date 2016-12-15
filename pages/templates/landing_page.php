<?php
include_once('../database/restaurants.php');
include_once('../database/users.php');
include_once('../utils/utils.php');

$query = '';
if (isset($_GET['query']))
    $query = htmlspecialchars($_GET['query']);
?>

<link rel="stylesheet" type="text/css" href="../css/landing_page.min.css"/>
<div id="logo">
    <img alt="logo" src="../res/eatr.png">
</div>

<form id="search-form" action="index.php" method="get">
    <input hidden="hidden" type="text" name="page" value="search_results.php">
    <input id="search-box" type="text" name="query" placeholder="Search for a restaurant or an user!" value="<?= $query ?>"/>

    <button id="search-button">Search!</button>
</form>
