$(function () {
    var regex = /(?=.*\d)(?=.*\W)(?=.*[a-z])(?=.*[A-Z]).{8,}/;
    $('input[name=password]').bind('keyup', function (e) {
        if (regex.test($(this).val())) {
            $(this).addClass('valid');
            $(this).removeClass('error');
        } else {
            $(this).removeClass('valid');
            $(this).addClass('error');
        }
    });
    $('input[name="confirm-password"]').bind('keyup', function (e) {
        if (regex.test($(this).val()) && $(this).val() == $('input[name=password]').val()) {
            $('button[type=submit]').removeAttr('disabled', '');
            $(this).addClass('valid');
            $(this).removeClass('error');
        } else {
            $('button[type=submit]').attr('disabled', 'disabled');
            $(this).removeClass('valid');
            $(this).addClass('error');
        }
    });

});