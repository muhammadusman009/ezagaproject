<?php

/* ---------------------------------------------------------
 * WPBUCKET FRAMEWORK
 * WordPress framework for creating themes.
 * 
 * Author: Pixel Industry
 * Website: www.pixel-industry.com
 * 
 * Version: 2.2
  ---------------------------------------------------------- */

/*
 * MAIN FILE FOR INCLUDING CORE FEATURES
 */

global $wpbucket_theme_config;

// Include helper functions
// Load from Child theme is file is available
if ( file_exists( get_stylesheet_directory() . '/core/libs/plugins.php' ) ) {

    require_once get_stylesheet_directory() . '/core/libs/plugins.php';
}
// Load from Parent theme is file is available
else if ( file_exists( WPBUCKET_THEME_DIR . '/core/libs/plugins.php' ) ) {

    require_once WPBUCKET_THEME_DIR . '/core/libs/plugins.php';
}

// Include helper functions
// Load from Child theme is file is available
if ( file_exists( get_stylesheet_directory() . '/core/libs/helper.php' ) ) {

    require_once get_stylesheet_directory() . '/core/libs/helper.php';
}
// Load from Parent theme is file is available
else if ( file_exists( WPBUCKET_THEME_DIR . '/core/libs/helper.php' ) ) {

    require_once WPBUCKET_THEME_DIR . '/core/libs/helper.php';
}

// Include custom styles class
// Load from Child theme is file is available
if ( file_exists( get_stylesheet_directory() . '/core/libs/custom-styles.php' ) ) {

    require_once get_stylesheet_directory() . '/core/libs/custom-styles.php';
}
// Load from Parent theme is file is available
else if ( file_exists( WPBUCKET_THEME_DIR . '/core/libs/custom-styles.php' ) ) {

    require_once WPBUCKET_THEME_DIR . '/core/libs/custom-styles.php';
}


// Include core functions
// Load from Child theme is file is available
if ( file_exists( get_stylesheet_directory() . '/core/libs/core.php' ) ) {

    require_once get_stylesheet_directory() . '/core/libs/core.php';
}
// Load from Parent theme is file is available
else if ( file_exists( WPBUCKET_THEME_DIR . '/core/libs/core.php' ) ) {

    require_once WPBUCKET_THEME_DIR . '/core/libs/core.php';
}


// Load file with Icon Font functions
// Load from Child theme is file is available
if ( file_exists( get_stylesheet_directory() . '/core/libs/icon-fonts.php' ) ) {

    require_once get_stylesheet_directory() . '/core/libs/icon-fonts.php';
}
// Load from Parent theme is file is available
else if ( file_exists( WPBUCKET_THEME_DIR . '/core/libs/icon-fonts.php' ) ) {

    require_once WPBUCKET_THEME_DIR . '/core/libs/icon-fonts.php';
}

if ( is_admin() ) {

    // create admin menu
    // Load One click installer from Child theme is file is available
    if ( file_exists( get_stylesheet_directory() . '/core/libs/admin-menu.php' ) ) {

        require_once get_stylesheet_directory() . '/core/libs/admin-menu.php';
    }
    // Load One click installer from Parent theme is file is available
    else if ( file_exists( WPBUCKET_THEME_DIR . '/core/libs/admin-menu.php' ) ) {

        require WPBUCKET_THEME_DIR . '/core/libs/admin-menu.php';
    }

    // one click installer
    if ( !isset( $wpbucket_theme_config['include']['one_click_installer'] ) || $wpbucket_theme_config['include']['one_click_installer'] == '1' ) {

        // filter config files directory
        $wpbucket_config_files_dir = apply_filters( 'wpbucket_config_files_dir', '' );

        // check if value is filtered
        if ( !empty( $wpbucket_config_files_dir ) ) {
            $file_url = trailingslashit( $wpbucket_config_files_dir ) . 'one-click-install.php';

            if ( file_exists( $file_url ) ) {
                require_once $file_url;
            }
        }
        // Load One click installer from Child theme is file is available
        else if ( file_exists( get_stylesheet_directory() . '/includes/one-click-install.php' ) ) {

            require_once get_stylesheet_directory() . '/includes/one-click-install.php';
        }
        // Load One click installer from Parent theme is file is available
        else if ( file_exists( WPBUCKET_THEME_DIR . '/includes/one-click-install.php' ) ) {

            require_once WPBUCKET_THEME_DIR . '/includes/one-click-install.php';
        }
    }
}

// Load Redux files
if ( !isset( $wpbucket_theme_config['include']['theme_options'] ) || $wpbucket_theme_config['include']['theme_options'] == '1' ) {

    // Load from Child theme is file is available
    if ( file_exists( get_stylesheet_directory() . '/core/theme-options/loader.php' ) ) {

        require_once get_stylesheet_directory() . '/core/theme-options/loader.php';
    }
    // Load from Parent theme is file is available
    else if ( file_exists( WPBUCKET_THEME_DIR . '/core/theme-options/loader.php' ) ) {

        require_once WPBUCKET_THEME_DIR . '/core/theme-options/loader.php';
    }
}

// Load MetaBox registration fields
if ( !isset( $wpbucket_theme_config['include']['metabox'] ) || $wpbucket_theme_config['include']['metabox'] == '1' ) {

    // filter config files directory
    $wpbucket_config_files_dir = apply_filters( 'wpbucket_config_files_dir', '' );

    // check if value is filtered
    if ( !empty( $wpbucket_config_files_dir ) ) {
        $file_url = trailingslashit( $wpbucket_config_files_dir ) . 'post-metabox.php';

        if ( file_exists( $file_url ) ) {
            require_once $file_url;
        }
    }
    // Load from Child theme is file is available
    else if ( file_exists( get_stylesheet_directory() . '/includes/post-metabox.php' ) ) {

        require_once get_stylesheet_directory() . '/includes/post-metabox.php';
    }
    // Load from Parent theme is file is available
    else if ( file_exists( WPBUCKET_THEME_DIR . '/includes/post-metabox.php' ) ) {

        require_once WPBUCKET_THEME_DIR . '/includes/post-metabox.php';
    }
}

// Include the script for plugin version checking
if ( !isset( $wpbucket_theme_config['include']['tgmpa'] ) || $wpbucket_theme_config['include']['tgmpa'] == '1' ) {

    // filter config files directory
    $wpbucket_config_files_dir = apply_filters( 'wpbucket_config_files_dir', '' );

    // check if value is filtered
    if ( !empty( $wpbucket_config_files_dir ) ) {
        $file_url = trailingslashit( $wpbucket_config_files_dir ) . 'plugin-list.php';

        if ( file_exists( $file_url ) ) {
            require_once $file_url;
        }
    }
    // Load from Child theme is file is available
    else if ( file_exists( get_stylesheet_directory() . '/includes/plugin-list.php' ) ) {

        require_once get_stylesheet_directory() . '/includes/plugin-list.php';
    }
    // Load from Parent theme is file is available
    else if ( file_exists( WPBUCKET_THEME_DIR . '/includes/plugin-list.php' ) ) {

        include_once WPBUCKET_THEME_DIR . '/includes/plugin-list.php';
    }
}

// Include the Mobile Detect script
if ( !isset( $wpbucket_theme_config['include']['mobile_detect'] ) || $wpbucket_theme_config['include']['mobile_detect'] == '1' ) {

    // Load from Child theme is file is available
    if ( file_exists( get_stylesheet_directory() . '/core/libs/external/Mobile_Detect.php' ) ) {

        require_once get_stylesheet_directory() . '/core/libs/external/Mobile_Detect.php';
    }
    // Load from Parent theme is file is available
    else if ( file_exists( WPBUCKET_THEME_DIR . '/core/libs/external/Mobile_Detect.php' ) ) {

        include_once WPBUCKET_THEME_DIR . '/core/libs/external/Mobile_Detect.php';
    }
}

// Include the Wpbucket Thumb image resizer
if ( !isset( $wpbucket_theme_config['include']['wpbucket_thumb'] ) || $wpbucket_theme_config['include']['wpbucket_thumb'] == '1' ) {

    // Load from Child theme is file is available
    if ( file_exists( get_stylesheet_directory() . '/core/libs/external/Wpbucket_Thumb.php' ) ) {

        require_once get_stylesheet_directory() . '/core/libs/external/Wpbucket_Thumb.php';
    }
    // Load from Parent theme is file is available
    else if ( file_exists( WPBUCKET_THEME_DIR . '/core/libs/external/Wpbucket_Thumb.php' ) ) {

        include_once WPBUCKET_THEME_DIR . '/core/libs/external/Wpbucket_Thumb.php';
    }
}

// include Content Maker's registration script
// Load from Child theme is file is available
if ( file_exists( get_stylesheet_directory() . '/core/content-maker/setup.php' ) ) {

    require_once get_stylesheet_directory() . '/core/content-maker/setup.php';
}
// Load from Parent theme is file is available
else if ( file_exists( WPBUCKET_THEME_DIR . '/core/content-maker/setup.php' ) ) {

    require WPBUCKET_THEME_DIR . '/core/content-maker/setup.php';
}


// include Breadcrumbs script
// Load from Child theme is file is available
if ( file_exists( get_stylesheet_directory() . '/core/libs/breadcrumbs.php' ) ) {

    require_once get_stylesheet_directory() . '/core/libs/breadcrumbs.php';
}
// Load from Parent theme is file is available
else if ( file_exists( WPBUCKET_THEME_DIR . '/core/libs/breadcrumbs.php' ) ) {

    require WPBUCKET_THEME_DIR . '/core/libs/breadcrumbs.php';
}


// include Menus script
// Load from Child theme is file is available
if ( file_exists( get_stylesheet_directory() . '/core/libs/menus.php' ) ) {

    require_once get_stylesheet_directory() . '/core/libs/menus.php';
}
// Load from Parent theme is file is available
else if ( file_exists( WPBUCKET_THEME_DIR . '/core/libs/menus.php' ) ) {

    require WPBUCKET_THEME_DIR . '/core/libs/menus.php';
}
