$(document).ready(function () {
    $('#search-box').on('input', searchStarted);
});

function searchStarted() {
    window.location.assign(window.location.origin + '/pages/index.php?page=search_results.php&query=' + $('#search-box').val());
}