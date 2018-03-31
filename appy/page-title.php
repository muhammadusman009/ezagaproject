<?php
/**
 * Copyright (c) 12/7/2017.
 * Theme Name: Appy
 * Author: pranontheme
 * Website: http://pranontheme.net/
 */

global $wpbucket_theme_config;
$title_classes = '';
$page_id = get_the_ID();

// breadcrumbs
$show_breadrumbs = wpbucket_return_theme_option('show_breadcrumbs', '', '1');


$vlc_page_title = get_post_meta($page_id, 'pg_page_description', true);

if (is_archive()) {
    $vlc_page_title = get_the_archive_title();
} elseif (is_tag()) {
    $vlc_page_title = single_tag_title();
} elseif (is_category()) {
    $vlc_page_title = single_cat_title();
} elseif (is_search()) {
    $vlc_page_title = esc_html__("Search Result For: ", 'appy') . get_search_query();
} elseif (is_singular('pi_team')) {
    $vlc_page_title = esc_html(wpbucket_return_theme_option('wpbucket_team_single_title', '', 'Team Details'));
} elseif (is_singular('pi_services')) {
    $vlc_page_title = esc_html(wpbucket_return_theme_option('wpbucket_service_single_title', '', 'Service Details'));
} elseif (is_singular('pi_portfolio')) {
    $vlc_page_title = esc_html(wpbucket_return_theme_option('wpbucket_project_single_title', '', 'Project Details'));
} elseif (is_single()) {
    $vlc_page_title = get_bloginfo('name');
} elseif ($vlc_page_title == '') {
    if (is_front_page()) {
        $vlc_page_title = get_bloginfo('name');
    } elseif (is_home()){
        $vlc_page_title = get_the_title(get_option('page_for_posts'));
    }else {
        $vlc_page_title = get_the_title($page_id);
    }

}


//Background Process
$page_title_background_option = wpbucket_return_theme_option('title_background');

if ($page_title_background_option) {
    $get_bg_img = wpbucket_return_theme_option('title_background', 'background-image');
    
    
    if($get_bg_img !=""){
        $custom_css = "
        .page-head{
                background-image: url('{$get_bg_img}')!important;
                background-size: cover; background-position: 50% 50%;
                background-attachment: fixed;
        }";
    }else{
        $custom_css = "
        .page-head{
                background-image: url('http://appy.bitballoon.com/assets/img/blog-bg.jpg')!important;
                background-size: cover; background-position: 50% 50%;
                background-attachment: fixed;
        }";
    }
    wp_enqueue_style(
        'custom-style',
        get_template_directory_uri() . '/css/custom_script.css'
    );
    wp_add_inline_style('custom-style', wp_strip_all_tags($custom_css));
}else{
    $custom_css = "
                .page-head{
                    background-image: url('http://appy.bitballoon.com/assets/img/blog-bg.jpg')!important;
                    background-size: cover; background-position: 50% 50%;
                    background-attachment: fixed;
                }";
    wp_enqueue_style(
        'custom-style',
        get_template_directory_uri() . '/css/custom_script.css'
    );
    wp_add_inline_style('custom-style', wp_strip_all_tags($custom_css));
}


?>
<section class="page-head">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2><?php echo wp_kses($vlc_page_title , $wpbucket_theme_config['allowed_html_tags']); ?></h2>
                <?php wpbucket_breadcrumbs(); ?>
            </div>
        </div>
    </div>
</section>