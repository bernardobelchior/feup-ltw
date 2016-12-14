$(document).ready(function () {
    $('.edit_link').on('click', onEdit);
    $('#delete-photo').on('click', deleteCurrentPhoto);
});

function deleteCurrentPhoto() {
    let token = $('input#token').val();
    let currentImage = $('#restaurant-gallery img:not(:hidden):first');

    if (currentImage.length === 0)
        return;

    let path = currentImage.attr('src').substr(3);

    console.log('Called');
    $.post("../actions/delete_restaurant_photo.php", {token: token, src: path}).done(function () {
        window.location.reload(true);
    });
}

function onEdit() {
    let tag = $(this).prev();
    let value = tag.text();
    let id = tag.parents("li").attr('id');

    let new_tag = $('<input name="' + id + '" id="input_' + id + '" class=' + tag.attr('class') + ' value="' + tag.html() + '"/>')
    if (id === 'categories') {
        categoriesListener(this);
        return;
    }
    tag.replaceWith(new_tag);
    if (id === 'telephone-number') {
        new_tag.attr('type', 'number');
        new_tag.attr('min', '0');
    }
    else if (id === 'cost-for-two') {
        new_tag.attr('type', 'number');
        new_tag.attr('min', 1);
    }

    let btn = $(this);
    let new_btn_id = "btn_" + id;
    btn.replaceWith($('<span id="' + new_btn_id + '" class=' + btn.attr('class') + '>Confirm</span>'));
    let new_btn = $('span#' + new_btn_id);

    new_btn.on('click', function () {
        let token = $('input#token').val();
        let restaurant_id = $('input#restaurant_id').val();
        let new_value = new_tag.val();
        if (new_value !== value)
            $.post("../actions/edit_restaurant.php", {
                token: token,
                restaurant_id: restaurant_id,
                type: id,
                value: new_value
            });
        tag.text(new_value);
        new_tag.replaceWith(tag);
        new_btn.replaceWith(btn);
        btn.on('click', onEdit);
    });
}

function categoriesListener(target) {
    let tag = $(target).prev();
    let id = tag.parents("li").attr('id');

    $('.categories-list > li').show();
    let old_text = tag.text();
    tag.text('');

    let btn = $(target);
    let new_btn_id = "btn_" + id;
    btn.replaceWith($('<span id="' + new_btn_id + '" class=' + btn.attr('class') + '>Confirm</span>'));
    let new_btn = $('span#' + new_btn_id);

    new_btn.on('click', function () {
        let token = $('input#token').val();
        let restaurant_id = $('input#restaurant_id').val();
        let categories = [];
        let category_names = [];
        $('.categories-list label input').each(function () {
            if ($(this).is(':checked')) {
                categories.push($(this).val());
                category_names.push($(this).attr('text'));
            }
        });
        $('.categories-list > li').hide();
        if (category_names.join(', ') !== old_text)
            $.post("../actions/edit_restaurant.php", {
                token: token,
                restaurant_id: restaurant_id,
                type: id,
                picked_categories: categories
            });
        tag.text(category_names.join(', '));
        new_btn.replaceWith(btn);
        btn.on('click', onEdit);
    });
}
