<?php
/**
 * Copyright (c) 12/7/2017.
 * Theme Name: Appy
 * Author: pranontheme
 * Website: http://pranontheme.net/
 */
defined('ABSPATH') or die();

get_header();
get_template_part('page-title');
?>
<section class="all_blogs padding-100 blogs">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                <?php if (have_posts()) : ?>

                <?php
                // Start the loop.
                while (have_posts()) : the_post();

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
                </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <nav aria-label="Page navigation">
                                <?php echo Wpbucket_Partials::wpbucket_pagination(); ?>
                            </nav>
                        </div>
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
