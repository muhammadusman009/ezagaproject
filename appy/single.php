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
    <section class="single-blog padding-100 blogs">
        <div class="container">
            <div class="row">

                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="blog-box">
                                <?php if (have_posts()): the_post(); ?>
                                
                                    <?php if (has_post_thumbnail ()) {  ?>
                                        <div class="blog-img">
                                            <img class="img-responsive" src="<?php echo Wpbucket_Helpers::wpbucket_get_image_url(get_the_ID()) ?>" alt="">
                                        </div>
                                    <?php } ?>
                                    <div class="blog-details">
                                        <h3><?php the_title()?></h3>
                                        <ul class="list-inline meta">
                                            <li><a href="#">John Doe</a></li>
                                            <li><a href="#"><?php echo get_the_date();?></a></li>
                                            <li><a href="#">25 comments</a></li>
                                            <li><a href="#">37 Views</a></li>
                                        </ul>
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

                                <?php endif; ?>
                                <?php
                                    if (comments_open() || get_comments_number()) {
                                        comments_template();
                                    }
                                ?>  
                            </div>
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
