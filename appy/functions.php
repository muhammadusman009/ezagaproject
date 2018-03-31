<?php
/**
 * Copyright (c) 12/7/2017.
 * Theme Name: Appy
 * Author: pranontheme
 * Website: http://pranontheme.net/
 */
define( 'WPBUCKET_THEME_NAME', "Appy" );
define( 'WPBUCKET_TEMPLATEURL', get_template_directory_uri() );
define( 'WPBUCKET_THEME_DIR', get_template_directory() );
global $wpbucket_theme_config;
/* --------------------------------------------------------------------
 * Array with configurations for current theme
 * -------------------------------------------------------------------- */

$wpbucket_theme_config = array(
    'allowed_html_tags' => array(
        'h1' => array(
            'class' => array(),
            'id' => array()
        ),
        'h2' => array(
            'class' => array(),
            'id' => array()
        ),
        'h3' => array(
            'class' => array(),
            'id' => array()
        ),
        'h4' => array(
            'class' => array(),
            'id' => array()
        ),
        'h5' => array(
            'class' => array(),
            'id' => array()
        ),
        'h6' => array(
            'class' => array(),
            'id' => array()
        ),
        'p' => array(
            'class' => array(),
            'id' => array()
        ),
        'ul' => array(
            'class' => array(),
            'id' => array()
        ),
        'li' => array(
            'class' => array(),
            'id' => array()
        ),
        'div' => array(
            'class' => array(),
            'id' => array()
        ),
        'i' => array(
            'class' => array(),
        ),
        'a' => array(
            'href' => array(),
            'title' => array(),
            'class' => array(),
            'target' => array()
        ),
        'img' => array(
            'src' => array(),
            'alt' => array(),
            'class' => array(),
        ),
        'br' => array(),
        'em' => array(),
        'strong' => array(),
        'span' => array( 'class' => array() )
    ),
    'menu_caret' => '1',
    'text_domain' => 'appy',
    'default_color' => 'color/blue-2',
    'main_color'=>'#209de2',
    'hover_color'=>'#209de2',
    'border_color'=>'#209de2'
);

$wpbucket_theme_config = apply_filters( 'wpbucket_theme_config', $wpbucket_theme_config );
function wpbucket_config_files_dir() {
    return trailingslashit( WPBUCKET_THEME_DIR ) . 'includes/configuration';
}

add_filter( 'wpbucket_config_files_dir', 'wpbucket_config_files_dir' );


if ( ! function_exists( 'wpbucket_widgets_init' ) ) :

    function wpbucket_widgets_init() {
        register_sidebar( array(
            'name' => esc_html__( 'Main Sidebar', 'appy' ),
            'id' => 'blog-sidebar-id',
            'description' => esc_html__( 'Appy Main Sidebar', 'appy' ),
            'class' => 'widget',
           'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4>',
            'after_title' => '</h4>'
        ) );
    }
endif;
add_action( 'widgets_init', 'wpbucket_widgets_init' );

if ( ! function_exists( 'wpbucket_widgets_init' ) ) :
function wpbucket_override_mce_options($initArray) {
    $opts = '*[*]';
    $initArray['valid_elements'] = $opts;
    $initArray['extended_valid_elements'] = $opts;
    return $initArray;
} 
endif;
//add_filter('tiny_mce_before_init', 'wpbucket_override_mce_options');



function wpbucket_import_files() {
  return array(
    array(
      'import_file_name'           => 'Demo Import',
      'import_file_url'            => trailingslashit( get_template_directory_uri() ) . 'includes/demo-files/demo-data.xml',
      'import_redux'               => array(
        array(
          'file_url'    => trailingslashit( get_template_directory_uri() ) . 'includes/demo-files/redux_options.json',
          'option_name' => 'wpbucket_options',
        ),
      ),
      'import_notice'              => __( 'After you import this demo, you will have to setup the Menu separately.', 'evo' )
    ),
  );
}
add_filter( 'pt-ocdi/import_files', 'wpbucket_import_files' );


require_once WPBUCKET_THEME_DIR . '/core/core-includes.php';
include_once WPBUCKET_THEME_DIR . '/includes/wpbucket-partials.php';
include_once WPBUCKET_THEME_DIR . '/includes/wpbucket-actions.php';
include_once WPBUCKET_THEME_DIR . '/includes/wpbucket-filters.php';