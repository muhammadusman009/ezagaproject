<?php
/**
 * Copyright (c) 12/7/2017.
 * Theme Name: Appy
 * Author: pranontheme
 * Website: http://pranontheme.net/
 */

/*
 * Template name: Blog Standard
 */

defined('ABSPATH') or die("No script kiddies please!");

get_header();
get_template_part('menu-section');
get_template_part('page-title');
$counter = 1;
?>

    <section class="all_blogs padding-100 blogs">
        <div class="container">
            <div class="row">
                <!-- Start All Blogs -->
                <div class="col-md-8">
           
            <!-- End Blog List One -->

            <?php if (have_posts()) : ?>

            <?php
            $paged = get_query_var('paged') ? intval(get_query_var('paged')) : 1;

            $args = array(
                'posts_per_page' => get_option('posts_per_page'),
                'paged' => $paged
            );

            $wp_query = new WP_Query($args);
            // Start the loop.
            while ($wp_query->have_posts()) :
                $wp_query->the_post();

                    /*
                     * Include the Post-Format-specific template for the content.
                     * If you want to override this in a child theme, then include a file
                     * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                     */
                    get_template_part('template-parts/content', get_post_format());

                    // End the loop.
                endwhile;

                // If no content, include the "No posts found" template.
                else :
                    get_template_part('template-parts/content', 'none');

                endif;
                ?>

                <div class="blog-pager pt-60">
                   <?php echo Wpbucket_Partials::wpbucket_pagination('blog'); ?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="sidebar">
                    <?php get_sidebar();; ?>
                </div>
            </div>
        </div>
    </div>
</section>

                
<?php
get_footer();
?>
