
function createListeners(){
  $(".edit_link").on('click', myListener);
}

function myListener(){
  let tag = $(this).prev();
  let value = tag.text();
  let id = tag.parents("li").attr('id');

  tag.replaceWith($('<input name="' + id + '" id="input_' + id + '" class=' + tag.attr('class') + ' value="' + tag.html() + '"/>'));

  let new_tag = $('input#input_' + id).first();

  let btn = $(this);
  let new_btn_id = "btn_" + id;
  btn.replaceWith($('<span id="' + new_btn_id + '" class=' + btn.attr('class') + '>Confirm</span>'));
  let btn2 = $('span#' + new_btn_id);

  btn2.on('click', function(){
    let token = $('input#token').val();
    let restaurant_id = $('input#restaurant_id').val();
    $.post("../pages/actions/edit_restaurant.php", {token: token, restaurant_id: restaurant_id, type: id, value: new_tag.val()});
    tag.text(new_tag.val());
    new_tag.replaceWith(tag);
    btn2.replaceWith(btn);
    btn.on('click', myListener);
  });
}

$(document).ready(createListeners);
