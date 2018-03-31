<?php
/**
 * Copyright (c) 24/10/2016.
 * Theme Name: Gardener
 * Author: wpbucket
 * Website: http://wordpressbucket.com/
 */
?>


<div id="post-<?php the_ID(); ?>" <?php post_class('col-md-12 col-sm-12'); ?>>
    <div class="blog-box">
        
        <?php if (has_post_thumbnail ()) {  ?>
        <div class="blog-img">
            <a href="single-blog.html"><img src="<?php echo Wpbucket_Helpers::wpbucket_get_image_url(get_the_ID())?>" class="img-responsive" alt=""></a>
        </div>
        <?php } ?>
        <div class="blog-details">
            <h3 class="blog-title"><a href="<?php the_permalink()?>"><?php the_title()?></a></h3>
            <ul class="list-inline meta">
                <li><a href="#">John Doe</a></li>
                <li><a href="#"><?php echo get_the_date();?></a></li>
                <li><a href="#">25 comments</a></li>
                <li><a href="#">37 Views</a></li>
            </ul>
            <?php

                if (is_single()) {
                    the_content();
                    wp_link_pages(array('before' => '<p class="wp-link-pages">Pages: ', 'after' => '</p>'));
                } else {
                // if user inserts more tag get regular content instead excerpt
                    if (preg_match('/<!--more(.*?)?-->/', $post->post_content)) {
                        the_content();
                    } else {
                        the_excerpt();
                    }

                    wp_link_pages(array(
                    'before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'appy') . '</span>',
                    'after' => '</div>',
                    'link_before' => '<span>',
                    'link_after' => '</span>',
                    'pagelink' => '<span class="screen-reader-text">' . __('Page', 'appy') . ' </span>%',
                    'separator' => '<span class="screen-reader-text">, </span>',
                    ));
                }?>
                <a class="btn btn-default blue" href="<?php the_permalink()?>" role="button"><?php echo esc_html__('Read More','appy')?></a>
                <div class="pull-right"><?php
                    edit_post_link(
                    sprintf(
                    /* translators: %s: Name of current post */
                    __( 'Edit<span class="screen-reader-text"> "%s"</span>', 'appy' ),
                    get_the_title()
                    )
                    );
                    ?>    </div>
                      
        </div>
    </div>
</div>