$(function () {
    Minuscule.menu.bindHover();
    Minuscule.menu.setActive();
    $('select').material_select();

    $('.datepicker').pickadate({
        selectMonths: true,
        selectYears: 15
    });
    $('input.time').timepicker({'scrollDefault': 'now', 'step': 15, 'timeFormat': 'h:i:s A'});
});

$(window).ajaxComplete(function (event, xhr, request) {
    Minuscule.message.parse(xhr);
    $('select').material_select();

    $('.datepicker').pickadate({
        selectMonths: true,
        selectYears: 15
    });
    $('input.time').timepicker({'scrollDefault': 'now', 'step': 15, 'timeFormat': 'h:i:s A'});
});

var Minuscule = {} || Minuscule;

Minuscule.loader = {
    show: function ($parent) {
        $parent.parent().css('position', 'relative');
        $parent.css('min-height', '300px');
        $parent.append('<div class="loader"><div class="loader-inner line-scale"><div></div><div></div><div></div><div></div><div></div></div></div>')
    },
    hide: function ($parent) {
        $parent.css('min-height', 'auto');
        $parent.find('.loader-inner').fadeOut(function () {
            $(this).remove();
        });
    }
};

Minuscule.message = {
    parse: function (xhr) {
        if (xhr) {
            try {
                var json = JSON.parse(xhr.responseText);
                if (json.redirect) {
                    window.location = json.redirect;
                }
                else if (json.text && json.type) {
                    noty({text: json.text, type: json.type});
                }
            } catch (e) {
                return false;
            }
        }
        return false;
    }
};

Minuscule.menu = {
    bindHover: function () {
        $('#main-menu').hover(function (event) {
            $(this).toggleClass('small');
        }, function (event) {
            $(this).toggleClass('small');
        });
    },
    setActive: function () {
        var path = window.location.pathname.split('/');
        $.each($('#main-menu a'), function () {
            var url = $(this).attr('href').split('/');
            if (path.indexOf(url[url.length - 1]) == path.length - 1) {
                $(this).parent().addClass('active');
            }
        });
    }
}