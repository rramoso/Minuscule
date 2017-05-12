function publish(id) {
    $.get(siteUrl + 'advertisement/publish/' + id, function (data) {
        console.log(data);
    });
}

function reblog(id) {
    $.get(siteUrl + 'advertisement/reblog/' + id, function (data) {
        console.log(data);
    });
}

function unreblog(id) {
    $.get(siteUrl + 'advertisement/unreblog/' + id, function (data) {
        console.log(data);
    });
}

function remove(id) {
    $.get(siteUrl + 'advertisement/remove/' + id, function (data) {
        console.log(data);
    });
}