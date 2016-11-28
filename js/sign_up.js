function validateForm() {
    let output = $('#output');
    let username = $('#username').val();

    if (username.length < 8) {
        output.html('A username needs to be at least 8 characters long.');
        return false;
    }

    let password = $('#password').val();

    if (password.length < 7) {
        output.html('A password needs to be at least 7 characters long.');
        return false;
    }

    let passwordRepeat = $('#password-repeat').val();

    if (password !== passwordRepeat) {
        output.html('The provided passwords do not match.');
        return false;
    }
}