
function createListeners(){
  $(".edit_link").on('click', myListener);
}

function myListener(){
  let tag = $(this).prev();
  let value = tag.text();
  let id = tag.parents("li").attr('id');

  let new_tag = $('<input name="' + id + '" id="input_' + id + '" class=' + tag.attr('class') + ' value="' + tag.html() + '"/>')
  if(id === 'categories') {
        $('.categories-list > li').show();
        tag.text('');
  }
  else{
  tag.replaceWith(new_tag);
  if(id === 'telephone-number'){
    new_tag.attr('type', 'number');
    new_tag.attr('min', '0');
  }
  else if(id === 'cost-for-two'){
      new_tag.attr('type', 'number');
      new_tag.attr('min', 1);
  }
}
  let btn = $(this);
  let new_btn_id = "btn_" + id;
  btn.replaceWith($('<span id="' + new_btn_id + '" class=' + btn.attr('class') + '>Confirm</span>'));
  let new_btn = $('span#' + new_btn_id);

  new_btn.on('click', function(){
    let token = $('input#token').val();
    let restaurant_id = $('input#restaurant_id').val();
    let new_value = new_tag.val();
    if(id === 'categories') {
      let categories = [];
      $('.categories-list label input').each(function () {
          if ($(this).is(':checked')) {
              categories.push($(this).val());
              //names.push($(this).parent())
            }
      });
      $('.categories-list > li').hide();
      new_value = categories;
    }
    $.post("../pages/actions/edit_restaurant.php", {token: token, restaurant_id: restaurant_id, type: id, value: new_value});
    if(id === 'categories') new_value = ' ';
    tag.text(new_value);
    new_tag.replaceWith(tag);
    new_btn.replaceWith(btn);
    btn.on('click', myListener);
  });
}

$(document).ready(createListeners);
