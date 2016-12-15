$(document).ready(function () {
    $('.edit_link').on('click', openEditField);
    $('#delete-photo').on('click', deleteCurrentPhoto);
    $('#edit-categories').hide();

    $('#categories .cancel_btn').on('click', toggleCategoriesEditForm);

    $('#restaurant-gallery img:not(:first)').hide();
    $('#restaurant-gallery span:not(:first)').hide();

    $('#right-arrow').on('click', nextImage);
    $('#left-arrow').on('click', previousImage);
});

function nextImage() {
    let currentImage = $('#restaurant-gallery img:not(:hidden):first');
    let currentLabel = $('#restaurant-gallery span:not(:hidden):first');

    if (!currentImage.siblings('img').length)
        return;

    currentImage.hide();
    currentLabel.hide();

    let next = currentImage.next('img');
    let nextLabel = currentLabel.next('span');

    if (next.length === 0) {
        next = currentImage.siblings('img').first();
        nextLabel = currentLabel.siblings('span').first();
    }
    next.show();
    nextLabel.show();
}

function previousImage() {
    let currentImage = $('#restaurant-gallery img:not(:hidden):first');
    let currentLabel = $('#restaurant-gallery span:not(:hidden):first');

    if (!currentImage.siblings('img').length)
        return;

    currentImage.hide();
    currentLabel.hide();

    let prev = currentImage.prev('img');
    let prevLabel = currentLabel.prev('span');

    if (prev.length === 0) {
        prev = currentImage.siblings('img').last();
        prevLabel = currentLabel.siblings('span').last();
    }
    prev.show();
    prevLabel.show();
}

function deleteCurrentPhoto() {
    let token = $('input#token').val();
    let currentImage = $('#restaurant-gallery img:not(:hidden):first');

    if (currentImage.length === 0)
        return;

    let path = currentImage.attr('src').substr(3);

    $.post("../actions/delete_restaurant_photo.php", {token: token, src: path}).done(function () {
        window.location.reload(true);
    });
}

function toggleCategoriesEditForm() {
    $('#edit-categories').toggle();
    $('#categories .confirm_btn').toggle();
    $('#categories .cancel_btn').toggle();
    $('#current-categories').toggle();
    $('#categories .edit_link').toggle();
}

function openEditField() {
    let editButton = $(this);
    let currentValueTag = editButton.prev();
    let id = currentValueTag.parents("li").attr('id');

    let editTag;
    switch (id) {
        case 'working-hours':
            editTag = createHoursForm(id);
            break;
        case 'categories':
            toggleCategoriesEditForm();
            return;
        default:
            let editFieldType = 'text';

            if (id === 'cost-for-two' || id === 'telephone-number')
                editFieldType = 'number';

            editTag = createSimpleForm(id, currentValueTag, editFieldType);
            break;
    }

    editButton.hide();

    currentValueTag.replaceWith(editTag);
    editTag.find('.cancel_btn').on('click', function () {
        editTag.replaceWith(currentValueTag);
        editButton.show();
    });
}

function createSimpleForm(id, currentValueTag, editFieldType) {
    let inputTag = $('<input type="' + editFieldType + '" name="value" id="input_' + id + '"  value="' + currentValueTag.html() + '">');

    if (editFieldType === 'number')
        inputTag.attr('min', '1');

    let editTag = $(
        '<div class="edit-field">' +
        '<div class="inputs">' +
        '</div>' +
        '<div class="edit_options">' +
        '<button class="confirm_btn">Confirm</button>' +
        '<input class="cancel_btn" type="reset" value="Cancel">' +
        '</div></div>');

    editTag.children(".inputs").append(inputTag);

    return editTag;
}

function createHoursForm(id) {
    let hourSelectTag = $('<select class="select-time"></select>');

    for (let hours = 0; hours < 24; hours++) {
        hourSelectTag.append('<option value="' + hours + '">' + hours + ':00</option>');
        hourSelectTag.append('<option value="' + (hours + 0.5) + '">' + hours + ':30</option>');
    }

    let editTag = $(
        '<div class="edit-field">' +
        '<div class="inputs">' +
        '</div>' +
        '<div class="edit_options">' +
        '<button class="confirm_btn">Confirm</button>' +
        '<input class="cancel_btn" type="reset" value="Cancel">' +
        '</div></div>');

    let openingTime = parseTime($('.list_attr_content span:first').text());
    let closingTime = parseTime($('.list_attr_content span:last').text());
    let closingSelectTag = hourSelectTag.clone(true);


    hourSelectTag.attr('id', 'opening-time').attr('name', 'opening-time');
    hourSelectTag.children('option[value="' + openingTime + '"]').attr('selected', 'selected');
    editTag.children(".inputs").append(hourSelectTag);

    closingSelectTag.attr('id', 'closing-time').attr('name', 'closing-time');
    closingSelectTag.children('option[value="' + closingTime + '"]').attr('selected', 'selected');
    editTag.children(".inputs").append(closingSelectTag);

    return editTag;
}

function parseTime(time) {
    let hour = parseInt(time.substring(0, 2));
    let minutes = parseInt(time.substring(3)) / 60;
    return hour + minutes;
}
