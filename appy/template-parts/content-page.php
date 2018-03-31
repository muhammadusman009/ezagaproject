<?php
/**
 * Copyright (c) 12/7/2017.
 * Theme Name: Appy
 * Author: pranontheme
 * Website: http://pranontheme.net/
 */
?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?> data-wow-duration="1s" data-wow-delay="0.2s">
     <?php if (has_post_thumbnail ()) {  ?><a href="<?php the_permalink()?>"><img src="<?php echo Wpbucket_Helpers::wpbucket_get_image_url(get_the_ID())?>" alt="" class="img-responsive alignleft"></a><?php } ?>
     <?php
            the_content();
            wp_link_pages(array(
                'before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'appy') . '</span>',
                'after' => '</div>',
                'link_before' => '<span>',
                'link_after' => '</span>',
                'pagelink' => '<span class="screen-reader-text">' . __('Page', 'appy') . ' </span>%',
                'separator' => '<span class="screen-reader-text">, </span>',
            ));
            ?>

        <?php
        edit_post_link(
            sprintf(
            /* translators: %s: Name of current post */
                __('Edit<span class="screen-reader-text"> "%s"</span>', 'appy'),
                get_the_title()
            )
        );
        ?>
    </div>