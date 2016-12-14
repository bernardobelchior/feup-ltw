$(document).ready(function () {
    $("#sign_up_text").on('click', openSignUpModal);

    $('.overlay').on('click', function (event) {
        if (event.target === event.delegateTarget) {
            closeSignUpModal()
            event.stopPropagation();
        }
    });
});

function openSignUpModal() {
    $(".overlay").fadeIn('fast');
}

function closeSignUpModal() {
    $(".overlay").fadeOut('fast');
}