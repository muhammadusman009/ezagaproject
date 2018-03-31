<?php

/**
 * Setup Wpbucket Framework
 */
function wpbucket_setup_framework() {
    load_textdomain( 'appy', '' );
}

add_action( 'after_setup_theme', 'wpbucket_setup_framework', 12 );

/**
 * Returns theme text domain
 * 
 * @global type $wpbucket_theme_config
 * @return type string
 */
function wpbucket_get_theme_textdomain() {
    global $wpbucket_theme_config;

    // If the global textdomain isn't set, define it. Plugin/theme authors may also define a custom textdomain.
    if ( !isset( $wpbucket_theme_config['text_domain'] ) || empty( $wpbucket_theme_config['text_domain'] ) ) {
        $theme = wp_get_theme( get_template() );
        $textdomain = $theme->get( 'TextDomain' ) ? $theme->get( 'TextDomain' ) : get_template();
        $wpbucket_theme_config['text_domain'] = sanitize_key( apply_filters( 'wpbucket_theme_textdomain', $textdomain ) );
    }
    // Return the expected textdomain of the parent theme.
    return $wpbucket_theme_config['text_domain'];
}

/**
 * Check if user is on device with Retina display
 * 
 * @global type $vlc_is_retina
 */
function wpbucket_is_retina_device_check() {
    global $vlc_is_retina;

    $theme_name_clean = sanitize_title( WPBUCKET_THEME_NAME );
    $cookie_name = $theme_name_clean . "_device_pixel_ratio";

    // verify that user is on device with retina display
    if ( isset( $_COOKIE[$cookie_name] ) && wpbucket_return_theme_option( 'retina' ) == '1' ) {
        $vlc_is_retina = ( $_COOKIE[$cookie_name] >= 2 );
    }
}

add_action( 'init', 'wpbucket_is_retina_device_check', 11 );

/**
 * Check if user is on device and double the size of the images
 * 
 * @global type $vlc_is_retina
 * @param type $params
 * @return type array
 */
function wpbucket_retina_filter_image_size( $params ) {
    global $vlc_is_retina;

    if ( $vlc_is_retina ) {
        $params = array();

        if ( isset( $params['width'] ) ) {
            $width = $params['width'];

            $params['width'] = $width * 2;
        }

        if ( isset( $params['height'] ) ) {
            $height = $params['height'];

            $params['height'] = $height * 2;
        }
    }

    return $params;
}

add_filter( 'cma_element_image_dimensions', 'wpbucket_retina_filter_image_size', 10, 2 );
add_filter( 'wpbucket_cpt_image_dimensions', 'wpbucket_retina_filter_image_size' );

if ( !function_exists( 'wpbucket_verify_audio_post_format_files' ) ) {

    /**
     * Verify audio file type
     * 
     * @param type $audio_string
     * @return type array
     */
    function wpbucket_verify_audio_post_format_files( $audio_string ) {
        $audio_urls = preg_split( '/\r\n|[\r\n]/', $audio_string[0] );
        $allowed_formats = array( 'm4a', 'webma', 'oga', 'fla', 'wav', 'ogg' );
        $valid_urls = array();
        foreach ( $audio_urls as $url ) {
            $audio_format = substr( $url, strrpos( $url, '.' ) + 1 );
            if ( in_array( $audio_format, $allowed_formats ) ) {
                if ( $audio_format == 'ogg' )
                    $audio_format = 'oga';
                $valid_urls[$audio_format] = esc_url_raw( $url );
            }
        }
        return $valid_urls;
    }

}
add_filter( 'wpbucket_verify_post_audio', 'wpbucket_verify_audio_post_format_files' );

/**
 * Check if all required plugins are loaded for Portfolio and Gallery templates
 * 
 * @global string $vlc_page_title
 * @global type $wpbucket_theme_config
 */
function wpbucket_portofolio_gallery_required_plugins_loaded() {
    global $vlc_page_title, $wpbucket_theme_config;

    if ( !VOLCANNO_CPTS || !VOLCANNO_META_BOX ) {

        $vlc_page_title = 'Plugin activation required!';

        // include page title if portfolio/gallery single is loaded
        if ( is_singular( 'pi_portfolio' ) || is_singular( 'pi_gallery' ) || is_singular( 'architecture_portfolio' ) ) {
            if ( file_exist( VOLCANNO_THEME_DIR . "/page-title.php" ) ) {
                get_template_part( 'page', 'title' );
            } else {
                get_template_part( 'section', 'title' );
            }
        }
        ?>
        <section class="page-content">
            <!-- container start -->
            <div class="container">
                <!-- .row start -->
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        echo wp_kses( __( 'Please activate <strong>Custom post types</strong> and <strong>MetaBox</strong> plugins.', 'appy' ), $wpbucket_theme_config['allowed_html_tags'] );
                        ?>
                    </div>
                </div><!-- .row end -->
            </div><!-- .container end -->
        </section>

        <?php
        // footer
        get_footer();

        exit;
    }
}

// hooks on CPT pages before items are rendered
add_action( 'wpbucket_pre_cpt_items_render', 'wpbucket_portofolio_gallery_required_plugins_loaded' );


if ( !function_exists( 'wpbucket_register_hooks' ) ) {

    /**
     * Helper function for registering hooks
     * 
     * @param array $hooks_callbacks
     * @param string $hook_name
     */
    function wpbucket_register_hooks( $hooks, $type ) {

        // allow filtering the array with registered filters / actions
        if ( $type == 'filter' ) {
            $hooks = apply_filters( 'wpbucket_theme_filters', $hooks );
        } else if ( $type == 'action' ) {
            $hooks = apply_filters( 'wpbucket_theme_actions', $hooks );
        }

        foreach ( $hooks as $hook_name => $params ) {

            foreach ( $params as $callback => $val ) {

                if ( is_array( $val ) ) {

                    if ( count( $val ) == 2 ) {

                        $priority = $val[0];
                        $args = $val[1];
                    } else if ( count( $val ) == 1 ) {
                        $priority = $val[0];
                        $args = 1;
                    }

                    if ( $type == 'action' ) {
                        add_action( $hook_name, $callback, $priority, $args );
                    } else if ( $type == 'filter' ) {
                        add_filter( $hook_name, $callback, $priority, $args );
                    }
                } else {
                    if ( $type == 'action' ) {
                        add_action( $hook_name, $val );
                    } else if ( $type == 'filter' ) {
                        add_filter( $hook_name, $val );
                    }
                }
            }
        }

        // additional hook to allow changes after filters / actions are registered
        if ( $type == 'filter' ) {
            do_action( 'wpbucket_after_filters_setup' );
        } else if ( $type == 'action' ) {
            do_action( 'wpbucket_after_actions_setup' );
        }
    }

}

if ( !function_exists( 'wpbucket_return_theme_option' ) ) {

    /**
     * Method that returns option from theme options
     * 
     * @global array $wpbucket_options
     * @param string $string
     * @param string $str
     * @return string
     */
    function wpbucket_return_theme_option( $string, $str = null, $default = null ) {
        global $wpbucket_options;

        // check if redux option object is empty and default value is set
        if ( empty( $wpbucket_options ) && !empty( $default ) ) {
            return $default;
            // check that Redux framework is activated and options object exists
        } else {
            if ( $str != null ) {
                return isset( $wpbucket_options ['' . $string . ''] ['' . $str . ''] ) ? $wpbucket_options ['' . $string . ''] ['' . $str . ''] : null;
            } else {
                return isset( $wpbucket_options ['' . $string . ''] ) ? $wpbucket_options ['' . $string . ''] : null;
            }
        }

        return null;
    }

}
