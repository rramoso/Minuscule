$(function () {
    bind();
    refresh();
});

function refresh() {
    Minuscule.loader.show($('#configured'));
    $.get(siteUrl + 'blog/load/configured', function (data) {
        Minuscule.loader.hide($('#configured'));
        $('#configured').empty();
        $.each(data, function (index) {
            $('#configured').append(data[index]);
        });
        bind();
    });
    Minuscule.loader.show($('#unconfigured'));
    $.get(siteUrl + 'blog/load/unconfigured', function (data) {
        Minuscule.loader.hide($('#unconfigured'));
        $('#unconfigured').empty();
        $.each(data, function (index) {
            $('#unconfigured').append(data[index]);
        });
        bind();
    });
}

function bind() {
    $('form').unbind('submit');
    $('form').submit(function (e) {
        var $form = $(this);
        $.post(siteUrl + "blog", $form.serialize(), function (data) {
            refresh();
        });
        e.preventDefault();
        return false;
    });

    var range = $('.range-field input');
    range.each(function () {
        var val = $(this).val();
        var parent = $(this).parents('p');
        $("<div/>", {class: "tooltip", text: val}).appendTo(parent);
    });

    range.unbind().on('input', function () {
        var val = $(this).val();
        var parent = $(this).parents('p');
        parent.find('.tooltip').text(val);
    });
}

