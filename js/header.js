$(document).ready(function () {
    $("#sign_up_text").on('click', signUpAction);

    $('.overlay').on('click', function (event) {
        if (event.target === event.delegateTarget) {
            $('.overlay').hide();
            event.stopPropagation();
        }
    });
});

function signUpAction() {
    $(".overlay").show();
}