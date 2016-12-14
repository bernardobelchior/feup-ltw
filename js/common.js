function openUserProfile(userId) {
    window.location.search = '?page=profile.php&id=' + userId;
}

function openRestaurantProfile(restaurantId) {
    window.location.search = '?page=restaurant_profile.php&id=' + restaurantId;
}
