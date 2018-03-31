<?php
/**
 * Copyright (c) 12/7/2017.
 * Theme Name: Appy
 * Author: pranontheme
 * Website: http://pranontheme.net/
 */
defined('ABSPATH') or die();

get_header();
$hide_page_title = get_post_meta(get_the_ID(),'pg_hide_title',true);
if (!is_front_page() && $hide_page_title!=1) {
    get_template_part('page-title');
}
?>



<?php if (have_posts()) : ?>

    <?php
    // Start the loop.
    while (have_posts()) : the_post();

        /*
         * Include the Post-Format-specific template for the content.
         * If you want to override this in a child theme, then include a file
         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
         */
        the_content();
        
        edit_post_link(
            sprintf(
            /* translators: %s: Name of current post */
                __('Edit<span class="screen-reader-text"> "%s"</span>', 'appy'),
                get_the_title()
            )
        );
        
        // End the loop.
    endwhile;

// If no content, include the "No posts found" template.
else :
    get_template_part('template-parts/content', 'none');

endif;
?>

<?php
if (comments_open() || get_comments_number()) {
    comments_template();
}
?>


<?php
get_footer();
?>