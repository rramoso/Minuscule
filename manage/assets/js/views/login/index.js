$(function () {
    $('#register-form').submit(function (e) {
        e.preventDefault();
        register();
    });
    $('#login-form').submit(function (e) {
        e.preventDefault();
        login();
    });
});

function login() {
    $('login-container').addClass('fadeOutUp');
    Minuscule.loader.show($('#loader'));
    $.post(siteUrl + 'login', $('#login-form').serialize(), function (data) {
        if (data) {
            Minuscule.loader.hide($('#register'));
            setTimeout(function () {
                window.location = siteUrl;
            }, 500);
        } else {
            Minuscule.loader.hide($('#login'));
            $('#login-form').removeClass('fadeOutUp');
            noty({text: "There was an error with your login, check your username and password.", type: "error"});
        }
    });
}

function register() {
    $('#register-form').addClass('fadeOutUp');
    Minuscule.loader.show($('#register'));
    $.post(siteUrl + 'login/register', $('#register-form').serialize(), function (data) {
        if (data) {
            Minuscule.loader.hide($('#register'));
            setTimeout(function () {
                window.location = siteUrl;
            }, 500);
        } else {
            Minuscule.loader.hide($('#register'));
            $('#register').removeClass('fadeOutUp');
            noty({text: "There was an error with your registration, please try again later.", type: "error"});
        }
    });
}