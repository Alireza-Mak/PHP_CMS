$(document).ready(function () {
  // Editor
  $('#summernote').summernote({
    placeholder: 'Your content',
    tabsize: 2,
    height: 100,
  });

  // Checkbox
  $('#selectAllChecks').click(function () {
    if (this.checked) {
      $('.checkBoxes').each(function () {
        this.checked = true;
      });
    } else {
      $('.checkBoxes').each(function () {
        this.checked = false;
      });
    }
  });
  // Loader
  var element = "<div id='load-screen'><div id='loading'></div></div>";
  $('body').prepend(element);
  $('#load-screen')
    .delay(200)
    .fadeOut(100, function () {
      $(this).remove();
    });
function loadUsersOnline() {
  $.get('functions.php?onlineuser=result', function (data) {
    $('.userOnline').text(data);
  });
}
setInterval(() => {
  loadUsersOnline();
}, 500);
});
