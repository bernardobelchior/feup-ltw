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

function createGenderForm(tag){

    let inputs;
    let gender = tag.html();
    if(gender == 'M')
        inputs = '<input name="gender" type="radio" value="M" checked>Male' +
                '<input name="gender" type="radio" value="F">Female';
    else if(gender == 'F')
        inputs = '<input name="gender" type="radio" value="M">Male' +
            '<input name="gender" type="radio" value="F" checked>Female';
    else
        inputs = '<input name="gender" type="radio" value="M">Male' +
            '<input name="gender" type="radio" value="F">Female';

    let new_tag = $(
        '<form id="change_gender_form" method="post" action="../actions/edit_profile.php">' +
        '<div class="inputs">' + inputs + '</div>' +
        '<div class="edit_options">' +
        '<input class="confirm_btn" type="submit" value="Confirm">' +
        '<button class="cancel_btn" type="reset">Cancel</button>' +
        '</div>' +
        '</form>');

    new_tag.css({"margin-left":"100px", "display":"inline-block"});
    new_tag.children(".edit_options").children().css("margin-right","5px");


    return new_tag;
}

function createPasswordForm(){
    let new_tag = $(
        '<form id="change_pw_form" method="post" action="../actions/change_password.php">' +
        '<div class="inputs">' +
        '<input name="old_password" type="password" id="input_old_pw" placeholder="Current Password"/>' +
        '<input name="new_password" type="password" id="input_new_pw" placeholder="New Password"/>' +
        '<input name="confirm_password" type="password" id="input_confirm_pw" placeholder="Repeat Password"/>' +
        '</div>' +
        '<div class="edit_options">' +
        '<input class="confirm_btn" type="submit" value="Confirm">' +
        '<button class="cancel_btn" type="reset">Cancel</button>' +
        '</div>' +
        '</form>');

    new_tag.css({"margin-left":"100px", "display":"inline-block"});
    new_tag.children(".inputs").children("input").css("display", "block");
    new_tag.children(".edit_options").css("text-align","center");
    new_tag.children(".edit_options").children().css("margin-right","5px");

    return new_tag;
}

function createPhotoForm(){
    let new_tag = $(
        '<form id="change_photo_form" action="../actions/upload_photo.php" method="post" enctype="multipart/form-data">' +
        '<div class="inputs">' +
        '<input type="hidden" name="token" value="<?php echo $_SESSION[\'token\']; ?>"/>' +
        '<input type="hidden" name="id" value="<?php echo $id; ?>">' +
        '<input id="photo" type="file" name="photo" accept="image/*" required/>' +
        '<output id="filesInfo"></output>' +
        '</div>' +
        '<div class="edit_options">' +
        '<input class="confirm_btn" type="submit" value="Upload Photo">' +
        '<button class="cancel_btn" type="reset">Cancel</button>' +
        '</div>' +
    '</form>'
    );

    new_tag.css({"margin-left":"100px", "display":"inline-block"});
    new_tag.children(".edit_options").children().css("margin-right","5px");

    return new_tag;
}

function createSimpleForm(id, tag){
    let inputTag = $('<input name="' + id + '" id="input_' + id + '"  value="' + tag.html() + '">');

    if (id === 'dob')
        inputTag.attr('placeholder', 'yyyy-mm-dd');
    else if (id === 'email')
        inputTag.attr('type', 'email');

    let new_tag = $(
        '<form id="change_' + id +'_form" method="post" action="../actions/edit_profile.php">' +
        '<div class="inputs">' +
        '</div>' +
        '<div class="edit_options">' +
        '<input class="confirm_btn" type="submit" value="Confirm">' +
        '<input class="cancel_btn" type="reset" value="Cancel">' +
        '</div>' +
        '</form>');

    new_tag.children(".inputs").append(inputTag);
    new_tag.css({"margin-left":"100px", "display":"inline-block"});
    new_tag.children(".edit_options").css("text-align","center");
    new_tag.children(".edit_options").children().css("margin-right","5px");

    return new_tag;
}

function editListener() {
    let tag = $(this).prev();
    let value = tag.text();
    let id = tag.parents("li").attr('id');
    let btn = $(this);
    btn.hide();

    let new_tag;

    switch(id){
        case 'gender':
            new_tag = createGenderForm(tag);
            break;

        case 'password':
            new_tag = createPasswordForm();
            break;

        case 'photo':
            new_tag = createPhotoForm();
            break;

        default:
            new_tag = createSimpleForm(id,tag);
            break;
    }

    tag.replaceWith(new_tag);

    let cancel_btn = new_tag.find(".cancel_btn");
    cancel_btn.on("click", function(){
        new_tag.replaceWith(tag);
        btn.show();
    });
}

$(document).ready(loadDocument = function(){
    $(".edit_link").on('click', editListener);
});
