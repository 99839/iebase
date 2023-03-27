(function ($) {
  "use strict";

  /* WordPress Media Uploader
  -------------------------------------------------------*/
  function widgetMediaUpload(type) {
    if (mediaUploader) {
      mediaUploader.open();
    }

    var mediaUploader = wp.media.frames.file_frame = wp.media({
      title: 'Select an Image',
      button: {
        text: 'Use This Image'
      },
      multiple: false
    });

    mediaUploader.on('select', function () {
      var attachment = mediaUploader.state().get('selection').first().toJSON();
      $('.ie-' + type + '-hidden-input').val(attachment.url).trigger('change');
      $('.ie-' + type + '-media').attr('src', attachment.url);
    });
    mediaUploader.open();
  }


  // Logo Upload
  $('body').on('click', '.ie-logo-upload-button', function () {
    widgetMediaUpload('logo');
  });

  $('body').on('click', '.ie-logo2x-upload-button', function () {
    widgetMediaUpload('logo2x');
  });


  // Logo Delete
  $('body').on('click', '.ie-logo-delete-button', function () {
    $('.ie-logo-hidden-input').val('').trigger('change');
    $('.ie-logo-media').attr('src', '');
  });

  $('body').on('click', '.ie-logo2x-delete-button', function () {
    $('.ie-logo2x-hidden-input').val('').trigger('change');
    $('.ie-logo2x-media').attr('src', '');
  });

})(jQuery);