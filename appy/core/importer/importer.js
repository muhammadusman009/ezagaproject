jQuery(function ($) {
    $('.table-fields .import-button').on('click', function () {
        var id = $(this).attr('id');
        
        // add message to results field
        $('.results-field').html('<p>Please wait while uploading...</p>');

        // add class animate that will start loading animation
        $(this).closest('td').addClass('loading').append($('#circularG'));

        // disable all buttons
        $('.table-fields .import-button').prop('disabled', true);
        
        // ajax request
        $.get(ajaxurl, {action: 'vlc_import_demo', content_id: id, security: $('.fields-container #demo-nonce').val()}, function (data) {
            // add log to field
            $('.results-field').html(data);
            
            // disable all buttons
            $('.table-fields .import-button').prop('disabled', false);
            
            $("#" + id).closest('td').addClass('imported').removeClass('loading');
            
        });

    });

});