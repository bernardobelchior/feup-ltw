$(document).ready(function () {
    // Make the checkbox clickable on the label
    $('.category-box').on('click', $(this).children().trigger('click'));
});

function validateForm() {
    $.ajax('https://maps.googleapis.com/maps/api/geocode/json', {
        async: false,
        data: {
            address: $('#address').val(),
            key: 'AIzaSyD7KJgIHnXcB3sJkzMPMz4PsGTqvWpEByA'
        }
    }).done(function (data) {
        return data.status === 'OK';
    });

    return true;
}