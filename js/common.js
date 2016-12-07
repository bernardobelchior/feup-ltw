function openUserProfile(userId) {
    window.location.pathname = 'pages/index.php?page=profile.php&id=' + userId;
}

function openRestaurantProfile(restaurantId) {
    window.location = 'index.php?page=restaurant_profile.php&id=' + restaurantId;
}
