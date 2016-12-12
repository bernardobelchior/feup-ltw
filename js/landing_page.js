$(document).ready(function () {
    $('#search-box').on('input', searchStarted);
    console.log(window.location);
});

function searchStarted() {
    window.location.search = '?page=search_results.php&query=' + $('#search-box').val();
}