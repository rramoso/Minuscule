var files;

$(function () {
    $('form.upload').on('submit', uploadFiles);
    $('form.upload input[type=file]').on('change', prepareUpload);
});

// Grab the files and set them to our variable
function prepareUpload(event) {
    files = event.target.files;
}

// Catch the form submit and upload the files
function uploadFiles(event) {
    event.stopPropagation(); // Stop stuff happening
    event.preventDefault(); // Totally stop stuff happening

    var status = $('form.upload .status');
    Minuscule.loader.show(status);

    // Create a formdata object and add the files
    var data = new FormData();
    $.each(files, function (key, value) {
        data.append(key, value);
    });

    $.ajax({
        url: siteUrl + 'file/create',
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'json',
        processData: false, // Don't process the files
        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        success: function (data, textStatus, jqXHR) {
            Minuscule.loader.hide(status);
            if (data && Object.keys(data).length > 0) {

                var ev = new CustomEvent('uploadComplete', {detail: {status: 'complete', data: data}});
                document.dispatchEvent(ev);

                $.each(data, function (id) {
                    status.append('<input type="hidden" name="file_id[]" value="' + id + '"/>').append('<div class="col s6 m3"><img src="' + siteUrl + 'assets/uploads/' + this + '"/></div>');
                });
                $(event.target)[0].reset();
            } else {
                status.html(data.text);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            // Handle errors here
            console.log('ERRORS: ' + textStatus);
            status.append(textStatus);
            Minuscule.loader.hide(status);
        }
    });
}