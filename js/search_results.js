import openRestaurantProfile from 'profile.js';

function openUserProfile(userId) {
    window.location.pathname = 'pages/profile.php?id=' + userId;
}
