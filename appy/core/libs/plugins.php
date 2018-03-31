<?php

/* ---------------------------------------------------------
 * Plugins
 *
 * Class with functions related to plugins 
 * necesarry for proper theme work
  ---------------------------------------------------------- */

class Wpbucket_Core_Plugins {

    /**
     * Check if required plugins are loaded
     */
    static function plugins_loaded() {

        if ( !function_exists( 'is_plugin_active' ) ) {
            require_once ABSPATH . '/wp-admin/includes/plugin.php';
        }

        // check if MetaBox plugin is loaded
        if ( is_plugin_active( 'meta-box/meta-box.php' ) ) {
            define( 'WPBUCKET_META_BOX', true );
        } else {
            define( 'WPBUCKET_META_BOX', false );
        }

        // check if MetaBox plugin is loaded
        if ( is_plugin_active( 'volcanno-custom-post-types/volcanno-custom-post-types.php' ) ) {
            define( 'WPBUCKET_CPTS', true );
        } else {
            define( 'WPBUCKET_CPTS', false );
        }

        // check if MetaBox plugin is loaded
        if ( is_plugin_active( 'revslider/revslider.php' ) ) {
            define( 'WPBUCKET_REVSLIDER', true );
        } else {
            define( 'WPBUCKET_REVSLIDER', false );
        }

        // check if MetaBox plugin is loaded
        if ( is_plugin_active( 'masterslider/masterslider.php' ) )
            define( 'WPBUCKET_MASTER_SLIDER', true );
        else
            define( 'WPBUCKET_MASTER_SLIDER', false );

        // check if MetaBox plugin is loaded
        if ( is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
            define( 'WPBUCKET_CF7', true );
        } else {
            define( 'WPBUCKET_CF7', false );
        }

        if ( is_plugin_active( 'megamenu/megamenu.php' ) ) {
            define( 'WPBUCKET_MAGA_MENU', true );
        } else {
            define( 'WPBUCKET_MAGA_MENU', false );
        }
        
        if(is_plugin_active('simple-share-buttons-adder/simple-share-buttons-adder.php')){
        	define( 'WPBUCKET_SHARE_BUTTON', true );
        }else{
        	define( 'WPBUCKET_SHARE_BUTTON', false );
        }

        if(is_plugin_active('js_composer/js_composer.php')){
        	define( 'WPBUCKET_VC', true );
        }else{
        	define( 'WPBUCKET_VC', false );
        }

        if(is_plugin_active('woocommerce/woocommerce.php')){
        	define( 'WPBUCKET_WOOCOMMERCE', true );
        }else{
        	define( 'WPBUCKET_WOOCOMMERCE', false );
        }
    }

}

Wpbucket_Core_Plugins::plugins_loaded();
