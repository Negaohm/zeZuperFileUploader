$('#upload').submit(function() {
  // First part, call backend to grab s3 details
  $.get($(this).data('s3details'))
  .done(function(data) {
    // Second part
    var form = $('#upload');

    // copy all original form input to a new hidden form
    var clonedForm = form.clone(true);

    // Remove all but the file input
    form.find('input[type!=file]').remove();
    // Update the target url to s3
    form.attr('action', data.url);
    // Set the target filename based on real filename
    form.append('<input type="hidden" name="key" value="'+form.find('input[type=file]').val().split('\\').pop()+'">');
    // Add all the other input from s3 details
    $.each(data.inputs, function(name, value) {
      form.append('<input type="hidden" name="'+name+'" value="'+value+'">');
    });

    form.unbind('submit');
    form.submit();

  })
  .fail(function() {
    alert('cannot get s3 details');
  });

  return false;
});
