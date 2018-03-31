<?php

/*
 * ---------------------------------------------------------
 * Partials
 *
 * Class for functions that return text / HTML content
 * ----------------------------------------------------------
 */

class Wpbucket_Partials
{

    /**
     * Echo logo image HTML
     *
     * @global bool $vlc_is_retina
     * @param array $args
     * @return string
     */
    static function wpbucket_get_logo_image_html($args = array())
    {
        global $vlc_is_retina;

        $website_name = get_bloginfo('name');
        $logo_width = '';
        $styles = '';

        $logo = wpbucket_return_theme_option('logo', 'url');
       
        $retina_logo = wpbucket_return_theme_option('retina_logo', 'url');

        if ($vlc_is_retina && !empty($retina_logo)) {
            $logo = $retina_logo;
            $logo_width = wpbucket_return_theme_option('logo', 'width');
        } else if (!empty($logo)) {
            $logo_width = wpbucket_return_theme_option('logo', 'width');
        }else{
            $logo = WPBUCKET_TEMPLATEURL . "/images/logo.png";
            $logo_width = "85";
        }

        if (!empty($args) && $args ['float']) {
            $float = $args ['float'];
            $styles = "style='float: {$float};'";
        }

        $logo = esc_url_raw($logo);
        $logo_img = "<img src='{$logo}' alt='{$website_name}' width='{$logo_width}' {$styles}/>";

        return $logo_img;
    }

    /**
     * Returns HTML for logo
     *
     * @return string
     */
    static function wpbucket_generate_logo_html()
    {
        ob_start();
        ?>
        <!-- .logo start -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="navbar-brand scroll-section">
            <?php
            echo static::wpbucket_get_logo_image_html();
            ?>
        </a>
        <!-- logo end -->
        <?php
        return ob_get_clean();
    }
static function wpbucket_get_footer_logo_image_html($args = array())
    {
       
        $footer_logo = wpbucket_return_theme_option('footer_logo', 'url');

        if (!empty($footer_logo)) {
            $footer_logo = wpbucket_return_theme_option('footer_logo', 'url');
        }else{
            $footer_logo = WPBUCKET_TEMPLATEURL . "/images/footer-logo.png";
        }


        $footer_logo = esc_url_raw($footer_logo);
        $footer_logo_img = "<img src='{$footer_logo}' alt='logo'/>";

        return $footer_logo_img;
    }

    /**
     * Returns HTML for logo
     *
     * @return string
     */
    static function wpbucket_generate_footer_logo_html()
    {
        ob_start();
        echo static::wpbucket_get_footer_logo_image_html();
        return ob_get_clean();
    }

    /**
     * Blog content search form
     *
     * @return string
     */
    static function wpbucket_get_content_search_form()
    {
        $form = '<form action="' . esc_url(home_url('/')) . '" method="get" id="header_form">
                     <input class="form-control" name="s" type="text" placeholder="Type to Search" />
                     <button class="btn btn-default" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                 </form>';

        return $form;
    }

    /**
     * Renders main menu in header.
     *
     * @return type string
     */
    static function wpbucket_generate_menu_html()
    {
        ob_start();

        wp_nav_menu(array(
            'theme_location' => apply_filters('wpbucket_main_menu_location', 'primary'),
            'menu' => 'Primary Menu',
            'container' => false,
            'menu_class' => 'nav navbar-nav navbar-right',
            'echo' => true,
            'fallback_cb' => false,
            'before' => '',
            'after' => '',
            'link_before' => '',
            'link_after' => '',
            'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            'depth' => 0,
            'walker' => new Wpbucket_Theme_Menu_Walker (),
        ));

        return ob_get_clean();
    }

   
    static function wpbucket_generate_copyright_text_html()
    {
        global $wpbucket_theme_config;
        ob_start();
        $footer_copyright = wpbucket_return_theme_option('copyright_text');
        echo wp_kses($footer_copyright , $wpbucket_theme_config['allowed_html_tags']);
        return ob_get_clean();
    }

    /**
     * Paginate function for Blog and Portfolio
     *
     * @global object $wp_query
     * @global object $wp_rewrite
     * @param string $location
     */
    static function wpbucket_pagination()
    {
        global $wp_query, $wp_rewrite ,$wpbucket_theme_config;

        $pages = '';
        $pagination = '';
        $max = $wp_query->max_num_pages;

        // if variable paged isn't set
        if (!$current = get_query_var('paged'))
            $current = 1;

        // set parameters
        $args = array(
            'base' => str_replace(999999999, '%#%', get_pagenum_link(999999999)),
            'format' => '',
            'total' => $max,
            'current' => $current,
            'show_all' => true,
            'type' => 'array',
            'prev_text' => '&larr;',
            'next_text' => '&rarr;',
            'prev_next' => false,
            'mid_size' => 3,
            'end_size' => 1
        );

       

        $previous_label = esc_html__('&#60; Previous', 'appy');
        $next_label = esc_html__('Next &#62;', 'appy');

        // previous and next links html
        $prev_page_link = $current == $max ? "" : "<li><a href='" . get_pagenum_link($current - 1) . "' aria-label='Previous'><i class='fa fa-angle-left' aria-hidden='true'></i></a></li>";
        $next_page_link = $current == $max ? "" : "<li><a href='" . get_pagenum_link($current + 1) . "' aria-label='Next'><i class='fa fa-angle-right' aria-hidden='true'></i></a></li>";

        // get page link
        $pagination_links = paginate_links($args);

        // loop through pages
        if (!empty($pagination_links)) {
            foreach ($pagination_links as $index => $link) {

                $link = str_replace('</span>', '</a>', $link);
                $link = str_replace('<span', '<a', $link);
                if(($index + 1 == $current)){
                    $link = str_replace('current', 'active', $link);
                }

                $pagination .= "<li>" . $link . "</li>";
            }
        }

        // if there is more then one page send html to browser
        if ($max > 1) {
            
            $pagination_html = "<ul class='pagination'>
                        
                        {$prev_page_link}
                        {$pagination}
                        {$next_page_link}
                        
                      </ul>";

            
                echo wp_kses($pagination_html , $wpbucket_theme_config['allowed_html_tags']);
            
        }
    }

    

    /**
     * Template for comments and pingbacks.
     *
     * @param object $comment
     * @param array $args
     * @param int $depth
     */
    static function wpbucket_render_comments($comment, $args, $depth)
    {
        $GLOBALS ['comment'] = $comment;
        switch ($comment->comment_type) {
            case 'pingback' :
            case 'trackback' :
                ?>
                <li class="post pingback">
                <p>
                    <?php esc_html_e('Pingback', 'appy'); ?><?php comment_author_link(); ?><?php edit_comment_link(esc_html__('Edit', 'appy'), '<span class="edit-link">', '</span>'); ?>
                </p>
                <?php
                break;
            default :
                ?>

            <li id="li-comment-<?php comment_ID(); ?>">
                <div id="comment-<?php comment_ID(); ?>" class="comment">
                    <?php
                        $avatar_size = 80;
                        echo get_avatar($comment, $avatar_size, false, get_comment_author());
                    ?>
                    <div class="comment_body">
                        <h4 class="clearfix">
                            <?php comment_author(); ?><span><?php
                                echo get_comment_date() . " at ";
                                comment_time();
                            ?>
                            <div class="pull-right"><?php comment_reply_link(array_merge($args, array('reply_text' => esc_html__('Reply', 'appy'), 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?></div>
                            
                        </h4>
                        <p>
                            <?php
                                comment_text();
                            ?>
                        </p>
                    </div>
                </div>
                </li>
                <?php
                break;
        }
    }


    /**
     * Template for categories dropdown.
     */
    static function wpbucket_get_categories_dropdown()
    {
        global $wpbucket_theme_config;
        $categories = get_categories(array(
            'hide_empty' => false
        ));

        $html = '<ul class="dropdown-menu" aria-labelledby="categoriesDropdown"><li class="widget widget_categories"><ul>';
        foreach ($categories as $category) {
            $html .= '<li><a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_attr($category->name) . '</a></li>';
        }
        $html .= '</ul></li></ul>';

        return wp_kses($html , $wpbucket_theme_config['allowed_html_tags']);
    }

    /**
     * Template for categories lists.
     *
     * @param $post_id
     * @param $no_icon for fontawesome control
     * @param $taxonomy for custom taxonomy
     */
    static function wpbucket_get_categories_lists($post_id, $no_icon = NULL, $taxonomy = null)
    {
        global $wpbucket_theme_config;
        if ($taxonomy == null) {
            $getCats = get_the_category($post_id);
        } else {
            $getCats = get_the_terms($post_id, $taxonomy);
        }

        if (is_array($getCats)) {
            if ($no_icon == null) {
                $html = '';
                foreach ($getCats as $key => $cat) {
                    $html .= ' <small><a href="' . get_category_link($cat->term_id) . '"><i class="fa fa-folder-open-o"></i> ' . " " . esc_attr($cat->name) . ' </a> </small>';
                }
                $html .= '</ul>';
            }elseif($no_icon == 'appy_project'){
                $html = '';
                foreach ($getCats as $key => $cat) {
                    $html .= $cat->name ;
                }
            } else {
                $html = '<ul class="article-meta">';
                foreach ($getCats as $key => $cat) {
                    $html .= '<li>' . esc_attr($cat->name) . '</li>';
                }
                $html .= '</ul>';
            }
        } else {
            $html = "";
        }

        return wp_kses($html , $wpbucket_theme_config['allowed_html_tags']);
    }

    /**
     * Template for tags lists.
     *
     * @param $post_id
     */
    static function wpbucket_get_tags_lists($post_id)
    {
        global $wpbucket_theme_config;

        $getTerms = wp_get_post_terms($post_id);
        $count = count($getTerms);
        $html = '';
        if ($count > 0) {
            $html .= '';
            foreach ($getTerms as $key => $value) {
                $html .= ' <a href="' . get_tag_link($value->term_id) . '">' . trim($value->name) . '</a>';
            }
            $html .= '</ul>';
        }
        return wp_kses($html , $wpbucket_theme_config['allowed_html_tags']);
    }

}
    