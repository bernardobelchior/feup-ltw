function openUserProfile(userId) {
    window.location.pathname = 'pages/profile.php?id=' + userId;
}

function openRestaurantProfile(restaurantId) {
    console.log('oi');
    window.location.pathname = 'pages/restaurant_profile.php?id=' + restaurantId;
}