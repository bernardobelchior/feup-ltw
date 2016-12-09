$(document).ready(function () {
    $("#search-tabs:not(.active)").children().on('click', activateTab);
});

function activateTab(event) {
    $(this).siblings('.active').removeClass('active').on('click', activateTab);
    let tab = $(this).children().attr('href');

    $('.search-container').hide();
    $(tab).show();

    $(this).addClass('active').off('click');
}