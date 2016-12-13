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

function changeGender() {
    let gender = $('#gender').attr('gender');
    $('#gender').val(gender);
}

function createListeners() {
    $(".edit_link").on('click', editListener);
}

function createGenderForm(){

    let new_tag = $(
        '<form id="change_gender_form" method="post" action="actions/edit_profile.php">' +
        '<div id="inputs">' +
        '<select name="gender" id="input_gender">' +
        '<option value=""></option><option value="M">Male</option><option value="F">Female</option></select>' +
        '</div>' +
        '<div id="edit_options">' +
        '<input id="confirm_btn" type="submit" value="Confirm">' +
        '<button id="cancel_btn">Cancel</button>' +
        '</div>' +
        '</form>');
    new_tag.css("margin-left", "100px");

    return new_tag;
}

function createPasswordForm(){
    let new_tag = $(
        '<form id="change_pw_form" method="post" action="actions/change_password.php">' +
        '<div id="inputs">' +
        '<input name="old_password" type="password" id="input_old_pw" placeholder="Current Password"/>' +
        '<input name="new_password" type="password" id="input_new_pw" placeholder="New Password"/>' +
        '<input name="confirm_password" type="password" id="input_confirm_pw" placeholder="Repeat Password"/>' +
        '</div>' +
        '<div id="edit_options">' +
        '<input id="confirm_btn" type="submit" value="Confirm">' +
        '<button id="cancel_btn">Cancel</button>' +
        '</div>' +
        '</form>');

    return new_tag;
}

function createPhotoForm(){
    let new_tag = $(
        '<form id="change_photo_form" method="post" action="../pages/actions/upload_photo.php"'
        //TODO To be continued
    )
}

function createSimpleForm(id, tag){
    let inputTag = $('<input name="' + id + '" id="input_' + id + '" class=' + tag.attr('class') + ' value="' + tag.html() + '">');

    if (id === 'dob')
        inputTag.attr('placeholder', 'yyyy-mm-dd');
    else if (id === 'email')
        inputTag.attr('type', 'email');

    let new_tag = $(
        '<form id="change-pass-form" method="post" action="actions/edit_profile.php">' +
        '<div id="inputs">' +
        '</div>' +
        '<div id="edit_options">' +
        '<input id="confirm_btn" type="submit" value="Confirm">' +
        '<input id="cancel_btn" type="reset" value="Cancel">' +
        '</div>' +
        '</form>');

    new_tag.children("#inputs").append(inputTag);

    return new_tag;
}

function editListener() {
    let tag = $(this).prev();
    let value = tag.text();
    let id = tag.parents("li").attr('id');
    console.log(id);
    let btn = $(this);
    btn.hide();

    let new_tag;

    switch(id){
        case 'gender':
            new_tag = createGenderForm();
            break;

        case 'password':
            new_tag = createPasswordForm();
            break;

        case 'photo':
            new_tag = createPhotoForm();
            break;

        default:
            new_tag = createSimpleForm(id, tag);
            break;
    }

    tag.replaceWith(new_tag);
    console.log(tag);

    let cancel_btn = $("#cancel_btn");
    console.log(cancel_btn);
    cancel_btn.on("click", function(){
        console.log("sadfasdf");
        new_tag.replaceWith(tag);
        btn.show();
    });


    // let new_btn_id = "btn_" + id;
    // let new_div = $('<span id="edit_options" > ' +
    //     '<span id="cancel_' + new_btn_id + '" class="edit_link clickable">Cancel</span> ' +
    //     '<span id="confirm_' + new_btn_id + '" class="edit_link clickable">Confirm</span>' +
    //     '</span>')
    // btn.replaceWith(new_div);
    // let new_section = $('span#edit_options');
}

function loadDocument() {
    createListeners();

    // Get the modal
    let modal = document.getElementById('change-pass-modal');

    // Get the button that opens the modal
    let btn = document.getElementById("change-pass-btn");

    // Get the <span> element that closes the modal
    let span = document.getElementsByClassName("close")[0];

    // When the user clicks on the button, open the modal
    btn.onclick = function () {
        modal.style.display = "block";
    };

    // When the user clicks on <span> (x), close the modal
    span.onclick = function () {
        modal.style.display = "none";
    };

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };

}
$(document).ready(loadDocument);
