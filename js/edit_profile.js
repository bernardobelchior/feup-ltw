function validateDate(value) {
    // let value = $('#date');
    let userFormat = 'yyyy-mm-dd', // default format
        delimiter = /[^mdy]/.exec(userFormat)[0],
        theFormat = userFormat.split(delimiter),
        theDate = value.split(delimiter),

        isDate = function (date, format) {
            let m, d, y;
            for (var i = 0, len = format.length; i < len; i++) {
                if (/m/.test(format[i])) m = date[i];
                if (/d/.test(format[i])) d = date[i];
                if (/y/.test(format[i])) y = date[i];
            }
            return (
                m > 0 && m < 13 &&
                y && y.length === 4 &&
                d > 0 && d <= (new Date(y, m, 0)).getDate()
            );
        };
    return isDate(theDate, theFormat);
}

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function validateNewPassword() {
    let output = $('#password-output');
    let newPassword = $('#new-password').val();
    let newPasswordRepeat = $('#new-password-repeat').val();

    if (newPassword.length < 7) {
        output.html('A password needs to be at least 7 characters long.');
        return false;
    }

    if (newPassword !== newPasswordRepeat) {
        output.html('The provided passwords do not match.');
        return false;
    }

    return true;
}

function createGenderForm(currentValueTag) {
    let inputs;
    let gender = currentValueTag.html();
    if (gender == 'M')
        inputs = '<input name="value" type="radio" value="M" checked>Male' +
            '<input name="value" type="radio" value="F">Female';
    else if (gender == 'F')
        inputs = '<input name="value" type="radio" value="M">Male' +
            '<input name="value" type="radio" value="F" checked>Female';
    else
        inputs = '<input name="value" type="radio" value="M">Male' +
            '<input name="value" type="radio" value="F">Female';

    let editFieldTag = $(
        '<div class="edit-field">' +
        '<div class="inputs">' + inputs + '</div>' +
        '<div class="edit_options">' +
        '<button class="confirm_btn">Confirm</button>' +
        '<button class="cancel_btn" type="reset">Cancel</button>' +
        '</div></div>');

    return editFieldTag;
}

function createPasswordForm() {
    let editFieldTag = $(
        '<div class="edit-field">' +
        '<div class="inputs">' +
        '<input name="old_password" type="password" id="input_old_pw" placeholder="Current Password"/>' +
        '<input name="new_password" type="password" id="input_new_pw" placeholder="New Password"/>' +
        '<input name="confirm_password" type="password" id="input_confirm_pw" placeholder="Repeat Password"/>' +
        '</div>' +
        '<div class="edit_options">' +
        '<button class="confirm_btn">Confirm</button>' +
        '<button class="cancel_btn" type="reset">Cancel</button>' +
        '</div></div>');

    editFieldTag.children(".inputs").children("input").css("display", "block");

    return editFieldTag;
}

function createPhotoForm() {
    return $(
        '<div class="edit-field">' +
        '<input type="hidden" name="token" value="' + $('#token').val() + '">' +
        '<input type="hidden" name="profile_id" value="' + $('#profile_id').val() + '">' +
        '<div class="inputs">' +
        '<input id="photo" type="file" name="photo" accept="image/*" required/>' +
        '<output id="filesInfo"></output>' +
        '</div>' +
        '<div class="edit_options">' +
        '<button class="confirm_btn">Upload Photo</button>' +
        '<button class="cancel_btn" type="reset">Cancel</button>' +
        '</div></div>');
}

function createSimpleForm(id, currentValueTag) {
    let inputTag = $('<input name="value" id="input_' + id + '"  value="' + currentValueTag.html() + '">');

    if (id === 'dob')
        inputTag.attr('placeholder', 'yyyy-mm-dd');
    else if (id === 'email')
        inputTag.attr('type', 'email');

    let editFieldTag = $(
        '<div class="edit-field">' +
        '<div class="inputs">' +
        '</div>' +
        '<div class="edit_options">' +
        '<button class="confirm_btn">Confirm</button>' +
        '<input class="cancel_btn" type="reset" value="Cancel">' +
        '</div></div>');

    editFieldTag.children(".inputs").append(inputTag);

    return editFieldTag;
}

function editListener() {
    let currentValueTag = $(this).prev();
    let fieldId = currentValueTag.closest("li").attr('id');
    let editButton = $(this);
    editButton.hide();

    let fieldEditTag;

    switch (fieldId) {
        case 'gender':
            fieldEditTag = createGenderForm(currentValueTag);
            break;

        case 'password':
            fieldEditTag = createPasswordForm();
            break;

        case 'photo':
            fieldEditTag = createPhotoForm();
            break;

        default:
            fieldEditTag = createSimpleForm(fieldId, currentValueTag);
            break;
    }

    currentValueTag.replaceWith(fieldEditTag);

    fieldEditTag.find(".cancel_btn").on("click", function () {
        fieldEditTag.replaceWith(currentValueTag);
        editButton.show();
    });
}

$(document).ready(loadDocument = function () {
    $(".edit_link").on('click', editListener);
});
