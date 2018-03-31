<?php

/* ---------------------------------------------------------
 * Actions
 *
 * Class for registering actions
  ---------------------------------------------------------- */

class Wpbucket_Theme_Actions
{

    static $hooks = array();

    /**
     * Setup all theme actions
     */
    static function init()
    {

        do_action('wpbucket_before_actions_setup');

        include_once WPBUCKET_THEME_DIR . '/includes/wpbucket-helpers.php';
        include_once WPBUCKET_THEME_DIR . '/includes/wpbucket-enqueue.php';
        include_once WPBUCKET_THEME_DIR . '/includes/wpbucket-sidebars.php';
        /**
         * Array of action hooks
         *
         *
         * When 'callback' value is empty (non-array) or any of values ommited,
         * default priority and accepted args will be used
         *
         * e.g.
         * priority = 10
         * accepted_args = 1
         */
        static::$hooks = array(
            'after_setup_theme' => array(
                'Wpbucket_Theme_Actions::wpbucket_content_width',
                'Wpbucket_Theme_Actions::wpbucket_theme_support',
                'Wpbucket_Theme_Actions::wpbucket_theme_support_woocommerce',
                'Wpbucket_Theme_Actions::wpbucket_register_nav_menu',
                'Wpbucket_Theme_Actions::wpbucket_theme_textdomain',
            ),
            'wp_enqueue_scripts' => array(
                'Wpbucket_Enqueue::wpbucket_load_css',
                'Wpbucket_Enqueue::wpbucket_load_js',
                'Wpbucket_Enqueue::wpbucket_localize_script',
            ),
            'admin_enqueue_scripts' => array(
                'Wpbucket_Enqueue::wpbucket_load_admin_css_js',
            ),
            'widgets_init' => array(
                'Wpbucket_Sidebars::wpbucket_custom_sidebar',
                'Wpbucket_Sidebars::wpbucket_footer_sidebar',
            ),
            'pre_get_posts' => array(
                'Wpbucket_Theme_Actions::wpbucket_portfolio_set_posts_per_page',
            ),
            'after_switch_theme' => array(
                'Wpbucket_Theme_Actions::wpbucket_themes_active',
            )
        );

        // register actions
        wpbucket_register_hooks(static::$hooks, 'action');
    }

    /**
     * Redirect to One click installer after activation
     */
    static function wpbucket_themes_active()
    {
    }

    static function wpbucket_theme_support_woocommerce()
    {
        if (WPBUCKET_WOOCOMMERCE) {
            add_theme_support('woocommerce');
        } else {
       
        }
    }

    /**
     * Enable all required features for proper theme work
     */
    static function wpbucket_theme_support()
    {

        // Add default posts and comments RSS feed links to <head>.
        add_theme_support('automatic-feed-links');

        // title tag
        add_theme_support('title-tag');

        // Add support for Shortcodes in Widgets
        add_filter('widget_text', 'do_shortcode');

        // Add support for custom header
        add_theme_support("custom-header");

        //Add support for custom background
        add_theme_support("custom-background");

        // ADD POST THUMBNAIL SUPPORT
        add_theme_support('post-thumbnails');

        // This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
        add_theme_support('post-thumbnails', array('post', 'pi_catering', 'pi_gallery', 'pi_menus'));
    }

    /*
     *
     * WIDGWT INITIALIZE
     * */
    static function wpbucket_widget_initialize()
    {
        register_widget( 'Wpbucket_Widget_Info' );
    }

    /**
     * Register all theme menus
     */
    static function wpbucket_register_nav_menu()
    {
        // Registering Main menu
        register_nav_menu('primary', 'Primary Menu');
       
    }

    /**
     * Make theme available for translation
     */
    static function wpbucket_theme_textdomain()
    {

        $theme_name = sanitize_title(WPBUCKET_THEME_NAME);

        // Make theme available for translation
        load_theme_textdomain($theme_name, WPBUCKET_THEME_DIR . '/languages');
        $locale = get_locale();
        $locale_file = WPBUCKET_THEME_DIR . "/languages/$locale.php";
        if (is_readable($locale_file))
            require_once $locale_file;
    }

    /**
     * Set the content width based on the theme's design and stylesheet.
     */
    static function wpbucket_content_width()
    {

        if (!isset($content_width))
            $content_width = 1140;
    }

    /**
     * Portfolio taxonomy archive.
     * Set posts_per_page variable based on value from Theme options.
     *
     * @param object $query
     * @return object
     */
    static function wpbucket_portfolio_set_posts_per_page($query)
    {
        if (!is_admin() && $query->is_tax() && ($query->is_archive())) {
            $taxonomy_vars = $query->query_vars;
            if (isset($taxonomy_vars['portfolio-category']))
                $tax = 'portfolio';

            if (!empty($tax)) {
                $posts_per_page = wpbucket_return_theme_option('portfolio_pagination');
                $query->set('posts_per_page', $posts_per_page);
                $query->set('post_type', "pi_" . $tax);
            }
        }

        return $query;
    }

}

Wpbucket_Theme_Actions::init();
