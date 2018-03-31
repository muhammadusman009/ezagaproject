<?php

/* ---------------------------------------------------------
 * Ations
 *
 * Class for registering filters
  ---------------------------------------------------------- */

class Wpbucket_Theme_Filters
{

    static $hooks = array();

    /**
     * Initialize filters
     */
    static function init()
    {

        /**
         * Array of filter hooks
         *
         * When 'callback' value is empty (non-array) or any of values ommited,
         * default priority and accepted args will be used
         *
         * e.g.
         * priority = 10
         * accepted_args = 1
         */
        static::$hooks = array(
            // WORDPRESS FILTERS
            'admin_body_class' => array(
                'Wpbucket_Theme_Filters::wpbucket_admin_body_class'
            ),
            'excerpt_length' => array(
                'Wpbucket_Theme_Filters::wpbucket_excerpt_length'
            ),
            'wp_page_menu_args' => array(
                'Wpbucket_Theme_Filters::wpbucket_page_menu_args'
            ),
            'comment_form_defaults' => array(
                'Wpbucket_Theme_Filters::wpbucket_get_comment_form'
            ),
            'tiny_mce_before_init' => array(
                'Wpbucket_Theme_Filters::wpbucket_add_tinymce_tables'
            ),
            'override_load_textdomain' => array(
                'Wpbucket_Theme_Filters::wpbucket_override_load_textdomain' => array(5, 3)
            ),
            // THEME AND FRAMEWORK FILTERS
            'vcpt_register_custom_post_types' => array(
                'Wpbucket_Theme_Filters::wpbucket_register_custom_post_types'
            ),
            'wpbucket_blog_style' => array(
                'Wpbucket_Theme_Filters::wpbucket_search_page_blog_style'
            ),
            'wpbucket_main_menu_location' => array(
                'Wpbucket_Theme_Filters::wpbucket_main_menu_name'
            ),
            'masterslider_disable_auto_update' => array(
                'Wpbucket_Theme_Filters::wpbucket_disable_master_slider_update_notifications'
            ),
            'wp_list_categories' => array(
                'Wpbucket_Theme_Filters::wpbucket_wp_list_categories'
            ),
            'get_archives_link' => array(
                'Wpbucket_Theme_Filters::wpbucket_get_archives_link'
            ),
            'get_search_form' => array(
                'Wpbucket_Theme_Filters::wpbucket_get_search_form'
            )
        );

        if (shortcode_exists('ssba')) {
            static::$hooks['ssba_html_output'] = array(
                'Wpbucket_Theme_Filters::remove_ssba_from_content' => array(10, 2)
            );
        }

        // register filters
        wpbucket_register_hooks(static::$hooks, 'filter');
    }

    /**
     * Filter post types configuration where we register
     * post types that are needed in theme
     *
     * @param array $post_types_config Array with post types
     * @return array Array with configuration
     */
    static function wpbucket_register_custom_post_types($post_types_config)
    {

        $post_types_config = array(
            'pi_team' => array(
                'cpt' => '1',
                'taxonomy' => '1'
            ),
            
        );

        return $post_types_config;
    }

    /**
     * Title customization
     *
     * @global int $page
     * @global int $paged
     * @global object $post
     * @param string $title
     * @param string $sep
     * @return string
     */
    static function wpbucket_wp_title($title, $sep)
    {
        if (is_feed()) {
            return $title;
        }

        global $page, $paged, $post;

        $title_name = get_bloginfo('name', 'display');
        $site_description = get_bloginfo('description', 'display');

        if ($site_description && (is_home() || is_front_page())) {
            $title = "$title_name $sep $site_description";
        } elseif (is_page()) {
            $title = get_the_title($post->ID);
            if (($paged >= 2 || $page >= 2) && !is_404()) {
                $title .= " $sep " . sprintf(esc_html__('Page %s', 'appy'), max($paged, $page));
            }
        } elseif (($paged >= 2 || $page >= 2) && !is_404()) {
            $title = "$title_name $sep " . sprintf(esc_html__('Page %s', 'appy'), max($paged, $page));
        } elseif (is_author()) {
            $author = get_queried_object();
            $title = $author->display_name;
        } elseif (is_search()) {
            $title = 'Search results for: ' . get_search_query() . '';
        }

        return $title;
    }

    /**
     * Overrides the load textdomain functionality when 'appy' is the domain in use.  The purpose of
     * this is to allow theme translations to handle the framework's strings.  What this function does is
     * sets the 'appy' domain's translations to the theme's.
     *
     * @global type $l10n
     * @param boolean $override
     * @param type $domain
     * @param type $mofile
     * @return boolean
     */
    static function wpbucket_override_load_textdomain($override, $domain, $mofile)
    {

        if ($domain == 'appy') {
            global $l10n;

            $theme_text_domain = wpbucket_get_theme_textdomain();

            // If the theme's textdomain is loaded, use its translations instead.
            if ($theme_text_domain && isset($l10n[$theme_text_domain]))
                $l10n[$domain] = $l10n[$theme_text_domain];

            // Always override.  We only want the theme to handle translations.
            $override = true;
        }

        return $override;
    }

    /**
     * Enable Menu Name
     *
     * @return Menu Name
     */
    static function wpbucket_main_menu_name()
    {

        return 'primary';
    }

    /**
     * Add class "wpbucket-portfolio-not-active" to create/edit page screen if
     * Custom Post Types plugin isn't active
     *
     * @global type $pagenow
     * @global type $typenow
     * @param string $classes Body classes to filter
     * @return string All body classes
     */
    static function wpbucket_admin_body_class($classes)
    {
        global $pagenow, $typenow;

        if (!WPBUCKET_CPTS && is_admin() && ($pagenow == 'post-new.php' || $pagenow == 'post.php') && $typenow == 'page') {
            $classes .= 'wpbucket-cpts-not-active';
        }

        return $classes;
    }

    /**
     * Sets the post excerpt length to 40 words.
     *
     * To override this length in a child theme, remove the filter and add your own
     * function tied to the excerpt_length filter hook.
     *
     * @param int $length
     * @return int
     */
    static function wpbucket_excerpt_length($length)
    {
        return 40;
    }

    /**
     * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
     *
     * @param array $args
     * @return boolean
     */
    static function wpbucket_page_menu_args($args)
    {
        $args['show_home'] = true;
        return $args;
    }

    /**
     * Tags widget customizations
     *
     * @param array $args
     * @return array
     */
    static function wpbucket_tag_cloud_args($args)
    {
        $args['smallest'] = 11;
        $args['largest'] = 11;
        $args['unit'] = "px";
        return $args;
    }

    /**
     * Comment Form styling
     *
     * @param array $fields
     * @return array
     */
    static function wpbucket_get_comment_form($fields)
    {

        // get current commenter data
        $commenter = wp_get_current_commenter();

        // check if field is required
        $req = get_option('require_name_email');
        $aria_req = ($req ? " aria-required='true' required" : '');

        // change fields style
        $fields['fields']['author'] = '<fieldset class="name-container"><label for="comment-name">' . esc_html__('Name:', 'appy') . ($req ? ' <span class="text-color">*</span>' : '') . '</label>' .
            '<span class="comment-name-container comment-input-container"><input type="text" name="author" class="name" id="comment-name" value="' . esc_attr($commenter['comment_author']) . '" size="22" tabindex="1"' . $aria_req . '/></span></fieldset>';

        $fields['fields']['email'] = '<fieldset class="email-container"><label for="comment-email">' . esc_html__('E-Mail:', 'appy') . ($req ? ' <span class="text-color">*</span>' : '') . '</label>' .
            '<span class="comment-email-container comment-input-container"><input type="email" name="email" class="email" id="comment-email" value="' . esc_attr($commenter['comment_author_email']) . '" size="22" tabindex="2" ' . $aria_req . '/></span></fieldset>';

        $fields['fields']['url'] = '';

        $fields['comment_field'] = '<fieldset class="message"><label for="comment-message">' . esc_html__('Message:', 'appy') . ($req ? ' <span class="text-color">*</span>' : '') . '</label><span class="comment-message-container comment-input-container"><textarea name="comment" class="comment-text" id="comment-message" rows="8" tabindex="4" aria-required="true" required></textarea></span></fieldset>';

        $fields['comment_notes_before'] = '';
        $fields['comment_notes_after'] = '<p class="reguired-fields">' . esc_html__('Required fields are marked ', 'appy') . '<span class="text-color">*</span></p>';
        $fields['cancel_reply_link'] = ' - ' . esc_html__('Cancel reply', 'appy');
        $fields['title_reply'] = esc_html__('Leave a comment', 'appy');
        $fields['id_submit'] = 'comment-reply';
        $fields['label_submit'] = esc_html__('Submit', 'appy');

        return $fields;
    }

    /**
     * Intercept Simple Share Buttons Adder output.
     *
     * @param string $content
     * @param bool $using_shortcode
     * @return string
     */
    static function wpbucket_remove_ssba_from_content($content, $using_shortcode)
    {

        if (!$using_shortcode && (is_page() || is_singular('pi_portfolio'))) {
            $content = "<section class='page-content'>"
                . "<section class='container'>"
                . "<div class='row'>"
                . "<div class='col-md-12'>"
                . $content
                . "</div></seection></section>";
        }

        return $content;
    }

    /**
     * Edit Tinymce settings i.e. add custom classes for Tables in Editor
     *
     * @param array $settings Tinymce settings
     * @return array
     */
    static function wpbucket_add_tinymce_tables($settings)
    {
        $new_styles = array(
            array(
                'title' => 'None',
                'value' => ''
            ),
            array(
                'title' => 'Events',
                'value' => 'events-table',
            )
        );
        $settings['table_class_list'] = json_encode($new_styles);
        return $settings;
    }

    /**
     * Set blog style to "Large" for Search results page
     *
     * @param string $style Blog style
     * @return string
     */
    static function wpbucket_search_page_blog_style($style)
    {

        // set Large blog style
        if (is_search()) {
            $style = 'blog-post-large';
        }

        return $style;
    }

    /**
     * Disabled Master Slider update notifications
     * because user needs to have valid purchase code
     *
     * @return string
     */
    static function wpbucket_disable_master_slider_update_notifications()
    {
        return true;
    }

    /**
     * Widget categories and archive count html change
     *
     * @param string $links
     * @return string
     */
    static function wpbucket_wp_list_categories($links)
    {
        $links = str_replace('</a> (', '<span class="cat-count">(', $links);
        $links = str_replace(')', ')</span></a>', $links);
        return $links;
    }

    /**
     * Widget archive modification
     *
     * @param string $links
     * @return string
     */
    static function wpbucket_get_archives_link($links)
    {
        $links = str_replace('</a>&nbsp;(', '<span class="cat-count">(', $links);
        $links = str_replace(')', ')</span></a>', $links);
        return $links;
    }

    /**
     * Return search form HTML
     * @param bool $echo
     * @return string
     */
    static function wpbucket_get_search_form($echo = true)
    {
        $format = current_theme_supports('html5', 'search-form') ? 'html5' : 'xhtml';
        $format = apply_filters('search_form_format', $format);


            $form = '
                <form action="' . esc_url(home_url('/')) . '" method="get" id="header_form">
                    <div class="search-form">
                     <input class="form-control" name="s" value="' . get_search_query() . '" type="text" placeholder="Type to Search" />
                     <button class="btn btn-default" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                     </div>
                 </form>';
        

        return $form;
    }
}

Wpbucket_Theme_Filters::init();
