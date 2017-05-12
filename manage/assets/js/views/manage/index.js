function publish(id) {
    noty({"text": "Communicating with the server", "type": "alert"})
    $.get(siteUrl + 'manage/publish/' + id, function (data) {
    });
}

function unpublish(id) {
    noty({"text": "Communicating with the server", "type": "alert"})
    $.get(siteUrl + 'manage/unpublish/' + id, function (data) {
    });
}

function reblog(id) {
    noty({"text": "Communicating with the server", "type": "alert"})
    $.get(siteUrl + 'manage/reblog/' + id, function (data) {
    });
}

function unreblog(id) {
    noty({"text": "Communicating with the server", "type": "alert"})
    $.get(siteUrl + 'manage/unreblog/' + id, function (data) {
    });
}

function remove(id) {
    noty({"text": "Communicating with the server", "type": "alert"})
    $.get(siteUrl + 'manage/remove/' + id, function (data) {
        $('#ad-' + id).remove();
    });
}