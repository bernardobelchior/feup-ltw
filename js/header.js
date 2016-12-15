$(document).ready(function () {
    $("#sign_up_text").on('click', openSignUpModal);

    $('.overlay').on('click', function (event) {
        if (event.target === event.delegateTarget) {
            closeSignUpModal()
            event.stopPropagation();
        }
    });

    $('#sign_up_submit').on('click', checkFields);
});

function openSignUpModal() {
    $(".overlay").fadeIn('fast');
}

function closeSignUpModal() {
    $(".overlay").fadeOut('fast');
}

function checkFields() {
    let token = $('#signup-token').val();
    let username = $('#username').val();
    let password = $('#password').val();
    let passwordRepeat = $('#password-repeat').val();
    let email = $('#email').val();
    let name = $('#name').val();

    $('#sign_up_form').find('span').remove();

    let errors = [];
    if (username.length < 8)
        errors.push({
            'error': 'username',
            'message': 'A username must be least 8 characters long.'
        });

    if (password.length < 7)
        errors.push({
            'error': 'password',
            'message': 'A password must be at least 7 characters long.'
        });

    if (password !== passwordRepeat)
        errors.push({
            'error': 'password-repeat',
            'message': 'Passwords do not match.'
        });

    if (!email.length)
        errors.push({
            'error': 'email',
            'message': 'An email field must be provided.'
        });

    if (!name.length)
        errors.push({
            'error': 'name',
            'message': 'A name must be provided'
        });

    /* Check for client side errors. Only submit form if there are no such errors */
    if (errors.length) {
        showErrors(errors);
        return;
    }

    $.ajax('../actions/sign_up.php', {
        data: {
            'signup-token': token,
            'username': username,
            'password': password,
            'password-repeat': passwordRepeat,
            'email': email,
            'name': name
        },
        method: 'POST',
        dataType: 'json'
    }).done(function (response) {
        if (response === true)
            window.location.reload(true);
        else {
            showErrors(response);
        }
    });
}

function showErrors(errors) {
    for (let error of errors) {
        switch (error['error']) {
            case 'username':
                $('#username').after('<span class="error"><i class="fa fa-times"></i>' + error['message'] + '</span>');
                break;
            case 'password' :
                $('#password').after('<span class="error"><i class="fa fa-times"></i>' + error['message'] + '</span>');
                break;
            case 'password-repeat':
                $('#password-repeat').after('<span class="error"><i class="fa fa-times"></i>' + error['message'] + '</span>');
                break;
            case 'email':
                $('#email').after('<span class="error"><i class="fa fa-times"></i>' + error['message'] + '</span>');
                break;
            case 'name':
                $('#name').after('<span class="error"><i class="fa fa-times"></i>' + error['message'] + '</span>');
                break;
        }
    }

    let rows = $('.column:first').find('input').length;

    for (let i = 0; i < rows; i++) {
        if ($('.column').find('input:nth-of-type(' + i + ')').next('span').length === 1)
            $('.column').find('input:nth-of-type(' + i + ') + :not(span)').before('<span><br></span>');
    }
}
