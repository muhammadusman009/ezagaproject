<?php

/* ---------------------------------------------------------
 * Enqueue
 *
 * Class for including Javascript and CSS files
  ---------------------------------------------------------- */

class Wpbucket_Enqueue {

    public static $css;
    public static $js;
    public static $admin_css;

    /**
     * Configuration array for stylesheet that will be loaded
     */
    static function wpbucket_load_css() {

        // array with CSS file to load

        static::$css = array(
            
			'wpbucket-bootstrap'=>'css/bootstrap.min.css',
            'wpbucket-animate'=>'css/animate.css',
            'wpbucket-fontawesome'=>'css/font-awesome.css',
            'wpbucket-owl-carousel'=>'css/owl.carousel.css',
            'wpbucket-owl-theme'=>'css/owl.theme.default.min.css',
            'wpbucket-aos'=>'css/aos.css',
            'wpbucket-lity'=>'css/lity.min.css',
            'parent-main'=>'css/main.css',
            'parent-style'=>'style.css',
		);

        // enqueue files
        Wpbucket_Enqueue::wpbucket_enqueue_css();
    }

    /**
     * Configuration array for Javascript files that will be loaded
     */
    static function wpbucket_load_js() {

      
        static::$js = array(
            'wpbucket-bootstrap' => 'js/bootstrap.min.js',
            'wpbucket-waypoints' => 'js/waypoints.min.js',
            'wpbucket-jquery-counterup' => 'js/jquery.counterup.min.js',
            'wpbucket-owl-carousel' => 'js/owl.carousel.js',
            'wpbucket-aos' => 'js/aos.js',
            'wpbucket-lity' => 'js/lity.min.js',
            'wpbucket-main' => 'js/main.js',

        );

        // We add some JavaScript to pages with the comment form 
        // to support sites with threaded comments (when in use).         
        if ( is_singular() && get_option( 'thread_comments' ) ) {
            static::$js['comment-reply'] = '';
        }

        // enqueue files
        Wpbucket_Enqueue::wpbucket_enqueue_js();
    }

    /**
     * Enqueue Javascript and CSS file to admin
     */
    static function wpbucket_load_admin_css_js() {

        // array with admin css files
        static::$admin_css = array(
            'font-awesome' => WPBUCKET_TEMPLATEURL . '/css/font-awesome.css',
            'admin' => WPBUCKET_TEMPLATEURL . '/css/admin.css'
        );

        // enqueue files
        Wpbucket_Enqueue::wpbucket_enqueue_admin_css_js();
    }

    /**
     * Enqueue CSS files
     */
    static function wpbucket_enqueue_css() {

        // concate full url to file by add url prefix to css dir
        static::$css = array_map( 'wpbucket_enqueue_css_prefix', static::$css );

        // allow modifiying array of css files that will be loaded
        static::$css = apply_filters( 'wpbucket_css_files', static::$css );

        // loop through files and enqueue
        foreach ( static::$css as $key => $value ) {

            // if value is array it means dependency and $media might be set
            if ( is_array( $value ) ) {
                $file = isset( $value[0] ) ? $value[0] : '';
                $dependency = isset( $value[1] ) ? $value[1] : '';
                $media = isset( $value[2] ) ? $value[2] : 'all';

                wp_enqueue_style( $key, $file, $dependency, '', $media );
            } else {
                wp_enqueue_style( $key, $value, '', '' );
            }
        }

        wp_register_style( 'google-font-spen-sans', '//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i' );
        wp_enqueue_style( 'google-font-spen-sans' );
    }

    /**
     * Enqueue Javascript files
     */
    static function wpbucket_enqueue_js() {

        // concate full url to file by add url prefix to js dir
        static::$js = array_map( 'wpbucket_enqueue_js_prefix', static::$js );

        // allow modifiying array of javascript files that will be loaded
        static::$js = apply_filters( 'wpbucket_js_files', static::$js );

        // Enqueue Javascript
        wp_enqueue_script( 'jquery' );

        // loop through files and enqueue
        foreach ( static::$js as $key => $value ) {

            // if value is array it means dependency and $in_footer might be set
            if ( is_array( $value ) ) {
                $file = isset( $value[0] ) ? $value[0] : '';
                $dependency = isset( $value[1] ) ? $value[1] : '';
                $in_footer = isset( $value[2] ) ? $value[2] : true;

                wp_enqueue_script( $key, $file, $dependency, '', $in_footer );
            } else {
                wp_enqueue_script( $key, $value, '', '', true );
            }
        }
    }

    /**
     * Enqueue Javascript and CSS file to admin
     */
    static function wpbucket_enqueue_admin_css_js() {

        // allow modifiying array of css files that will be loaded
        static::$admin_css = apply_filters( 'wpbucket_admin_css_files', static::$admin_css );

        // loop through array of admin css files and load them
        foreach ( static::$admin_css as $key => $value ) {

            wp_enqueue_style( $key, $value );
        }
    }

    /**
     * Make certain options available on front-end
     */
    static function wpbucket_localize_script() {

       
    }

}
