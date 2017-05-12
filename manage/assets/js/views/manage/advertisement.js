function reblog(id) {
    noty({"text": "Communicating with the server", "type": "alert"})
    $.get(siteUrl + 'manage/reblog/' + id, function (data) {
        document.location.reload();
    });
}

function unreblog(id) {
    noty({"text": "Communicating with the server", "type": "alert"})
    $.get(siteUrl + 'manage/unreblog/' + id, function (data) {
        document.location.reload();
    });
}