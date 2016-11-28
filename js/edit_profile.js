function validateDate() {
  let value = $('#date');
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

function changeGender(){
    let gender = $('#gender').attr('gender');
    $('#gender').val(gender);
}

$(document).ready(changeGender);
