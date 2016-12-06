function openUserProfile(userId) {
    window.location.pathname = 'pages/profile.php?id=' + userId;
}

function openRestaurantProfile(restaurantId) {
    window.location = 'restaurant_profile.php?id=' + restaurantId;
}
