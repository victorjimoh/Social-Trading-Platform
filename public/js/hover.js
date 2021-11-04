
$(document).ready(function() {
  $('#submit').prop('disabled', true);
    $('#body').on('input change', function() {
        if($(this).val() != '') {
            $('#submit').prop('disabled', false);
        } else {
            $('#submit').prop('disabled', true);
        }
    });
});
