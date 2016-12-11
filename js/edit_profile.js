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

function validateNewPassword(){
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

function changeGender(){
    let gender = $('#gender').attr('gender');
    $('#gender').val(gender);
}

function createListeners(){
  $(".edit_link").on('click', myListener);
}

function myListener(){
  let tag = $(this).prev();
  let value = tag.text();
  let id = tag.parents("li").attr('id');

  let new_tag;

  if(id === 'gender'){
    new_tag = $('<select name="' + id + '" id="input_' + id + '"> <option value=""></option><option value="M">Male</option><option value="F">Female</option></select>');
    new_tag.val(tag.text());
  }
  else
    new_tag = $('<input name="' + id + '" id="input_' + id + '" class=' + tag.attr('class') + ' value="' + tag.html() + '"/>');
  if(id === 'dob')
    new_tag.attr('placeholder', 'yyyy-mm-dd');
  else if(id === 'email')
    new_tag.attr('type', 'email');

  tag.replaceWith(new_tag);

  let btn = $(this);
  let new_btn_id = "btn_" + id;
  btn.replaceWith($('<span id="' + new_btn_id + '" class=' + btn.attr('class') + '>Confirm</span>'));
  let new_btn = $('span#' + new_btn_id);

  new_btn.on('click', function(){
    let token = $('input#token').val();
    let profile_id = $('input#profile_id').val();
    if(new_tag.val() !== tag.text()) {
      if(id === "dob"){
        if(!validateDate(new_tag.val())){
          $('#dob-output').html("Invalid date");
          return;
        }
      }
      else if(id === 'email'){
        if(!validateEmail(new_tag.val())){
          $('#email-output').html("Invalid email");
          return;
        }
      }
      $.post("../pages/actions/edit_profile.php",
            {token: token,
             profile_id: profile_id,
             type: id,
             value: new_tag.val()
            }).fail(function(){
              $('#email-output').html("Email already exists!");
            }).done(function(){
              tag.text(new_tag.val());
              new_tag.replaceWith(tag);
              new_btn.replaceWith(btn);
              $('#' + id + '-output').html("");
              btn.on('click', myListener);
            });
    }
    else{
      new_tag.replaceWith(tag);
      new_btn.replaceWith(btn);
      $('#' + id + '-output').html("");
      btn.on('click', myListener);
    }
  });
}

function loadDocument(){
  createListeners();

  // Get the modal
  let modal = document.getElementById('change-pass-modal');

  // Get the button that opens the modal
  let btn = document.getElementById("change-pass-btn");

  // Get the <span> element that closes the modal
  let span = document.getElementsByClassName("close")[0];

  // When the user clicks on the button, open the modal
  btn.onclick = function() {
      modal.style.display = "block";
  };

  // When the user clicks on <span> (x), close the modal
  span.onclick = function() {
      modal.style.display = "none";
  };

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
      if (event.target == modal) {
          modal.style.display = "none";
      }
};

}
$(document).ready(loadDocument);
