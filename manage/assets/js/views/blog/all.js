$(function () {
  $('a.confirm').click(function (e) {
    e.preventDefault();
    var self = $(this);
    var url = $(this).attr('href');
    swal({
      title: 'Are you sure?',
      text: "The user will have to set this blog up again...",
      type: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Delete'
    }, function () {
      $.get(url).success(function () {
        self.parents('tr').remove();
      });
    });
    return false;
  });
});