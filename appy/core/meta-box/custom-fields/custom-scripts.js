jQuery(function ($) {
    /*
     * Change MetaBox fields visibility based on Page template value.
     */

    (function () {
        // if custom post types are not available, remove templates from list
        if ($('body').hasClass('volcanno-cpts-not-active')) {
            $('#page_template option').filter(function () {
                if (($(this).attr('value') == "gallery-template.php" || $(this).attr('value') == "portfolio-template.php")) {
                    $(this).remove();
                    return false;
                }

            });
        }

        var selectedVal = $('#page_template').val();

        volcannoPageTemplateFieldVisibility(selectedVal);
    })();

    $(document).on('change', '#page_template', function () {
        var selectedVal = $('#page_template').val();

        volcannoPageTemplateFieldVisibility(selectedVal);
    });

    function volcannoPageTemplateFieldVisibility(selectedVal) {

        if (selectedVal == 'portfolio-template.php') {

            $('.rwmb-tab-portfolio, .rwmb-tab-single, .rwmb-tab-common').show();
            $('.rwmb-tab-portfolio a').click();
            $('.rwmb-tab-gallery').hide();
        } else if (selectedVal == 'gallery-template.php') {

            $('.rwmb-tab-gallery, .rwmb-tab-single, .rwmb-tab-common').show();
            $('.rwmb-tab-gallery a').click();
            $('.rwmb-tab-portfolio').hide();
        } else if (selectedVal == 'vehicles-template.php') {

            $('.rwmb-tab-vehicles, .rwmb-tab-call_to_action').show();
            $('.rwmb-tab-vehicles a').click();            
        } else {
            $('.rwmb-tab-portfolio, .rwmb-tab-gallery, .rwmb-tab-single, .rwmb-tab-common, .rwmb-tab-vehicles, .rwmb-tab-call_to_action').hide();
            $('.rwmb-tab-page_title a').click();
        }
    }

    /*
     * Change MetaBox fields visibility based on post format value.
     */

    (function () {
        var selectedVal = $('#post-formats-select .post-format:checked').val();
        if (selectedVal == '0') {
            $('#pt_video_url, #pt_quote_text, #pt_quote_author, #pt_audio_files, #pt_gallery_images_description, #pt_link_title, #pt_link_url').closest('.rwmb-field').hide();
        } else if (selectedVal == 'video') {
            $('#pt_quote_text, #pt_audio_files, #pt_quote_author, #pt_gallery_images_description, #pt_link_title, #pt_link_url, .rwmb-heading-wrapper h4').closest('.rwmb-field').hide();
        } else if (selectedVal == 'quote') {
            $('#pt_video_url, #pt_audio_files, #pt_gallery_images_description, #pt_link_title, #pt_link_url, .rwmb-heading-wrapper h4').closest('.rwmb-field').hide();
        } else if (selectedVal == 'audio') {
            $('#pt_video_url, #pt_quote_text, #pt_quote_author, #pt_gallery_images_description, #pt_link_title, #pt_link_url, .rwmb-heading-wrapper h4').closest('.rwmb-field').hide();
        } else if (selectedVal == 'gallery') {
            $('#pt_video_url, #pt_quote_text, #pt_quote_author, #pt_audio_files, #pt_link_title, #pt_link_url, .rwmb-heading-wrapper h4').closest('.rwmb-field').hide();
        } else if (selectedVal == 'link') {
            $('#pt_video_url, #pt_quote_text, #pt_quote_author, #pt_audio_files, #pt_gallery_images_description, .rwmb-heading-wrapper h4').closest('.rwmb-field').hide();
        }
    })();

    $('#post-formats-select .post-format').change(function () {
        var selectedVal = $(this).val();
        if (selectedVal == '0') {
            $('#pt_video_url, #pt_quote_text, #pt_quote_author, #pt_audio_files, #pt_gallery_images_description, #pt_link_title, #pt_link_url').closest('.rwmb-field').hide();
            $('.rwmb-heading-wrapper h4').closest('.rwmb-field').show();
        } else if (selectedVal == 'video') {
            $('#pt_video_url, #pt_quote_text, #pt_quote_author, #pt_audio_files, #pt_gallery_images_description, #pt_link_title, #pt_link_url, .rwmb-heading-wrapper h4').closest('.rwmb-field').hide();
            $('#pt_video_url').closest('.rwmb-field').show();
        } else if (selectedVal == 'quote') {
            $('#pt_video_url, #pt_quote_text, #pt_audio_files, #pt_gallery_images_description, #pt_link_title, #pt_link_url, .rwmb-heading-wrapper h4').closest('.rwmb-field').hide();
            $('#pt_quote_text, #pt_quote_author').closest('.rwmb-field').show();
        } else if (selectedVal == 'audio') {
            $('#pt_video_url, #pt_quote_text, #pt_quote_author, #pt_audio_files, #pt_gallery_images_description, #pt_link_title, #pt_link_url, .rwmb-heading-wrapper h4').closest('.rwmb-field').hide();
            $('#pt_audio_files').closest('.rwmb-field').show();
        } else if (selectedVal == 'gallery') {
            $('#pt_video_url, #pt_quote_text, #pt_quote_author, #pt_audio_files, #pt_gallery_images_description, #pt_link_title, #pt_link_url, .rwmb-heading-wrapper h4').closest('.rwmb-field').hide();
            $('#pt_gallery_images_description').closest('.rwmb-field').show();
        } else if (selectedVal == 'link') {
            $('#pt_video_url, #pt_quote_text, #pt_quote_author, #pt_audio_files, #pt_gallery_images_description, .rwmb-heading-wrapper h4').closest('.rwmb-field').hide();
            $('#pt_link_title, #pt_link_url').closest('.rwmb-field').show();
        }
    });

    /*
     * Enable/Disable MetaBox fields on Portfolio page based on checkbox state.
     */

    (function () {
        if ($("#pf_theme_options_override").prop('checked')) {
            $("#pf_theme_options_override").closest('.rwmb-tabs').find('.rwmb-tab-content, .rwmb-tab-slider').removeClass('disabled');
        } else {
            $("#pf_theme_options_override").closest('.rwmb-tabs').find('.rwmb-tab-content, .rwmb-tab-slider').addClass('disabled');
        }
    })();

    $('#pf_theme_options_override').change(function () {
        if ($("#pf_theme_options_override").prop('checked')) {
            $("#pf_theme_options_override").closest('.rwmb-tabs').find('.rwmb-tab-content, .rwmb-tab-slider').removeClass('disabled');
        } else {
            $("#pf_theme_options_override").closest('.rwmb-tabs').find('.rwmb-tab-content, .rwmb-tab-slider').addClass('disabled');
        }
    });

    $('.rwmb-tab-nav li').on('click', 'a', function (e) {
        if ($(this).parent().hasClass('disabled')) {
            return false;
        }

    });
});