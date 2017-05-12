$(function () {
    document.addEventListener('uploadComplete', function (e) {
        if (e.detail.data) {
            $.each(e.detail.data, function (id) {
                $('form[name=create]').append('<input type="hidden" name="file_ids[]" value="' + id + '" />');
            });
        }
    });
});

function create() {
    $.post(siteUrl + "advertisement/create", $('form[name=create]').serialize(), function (data) {
        console.log(data);
    });
}
