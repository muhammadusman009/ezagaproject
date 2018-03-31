<?php
/**
 * Copyright (c) 12/7/2017.
 * Theme Name: Appy
 * Author: pranontheme
 * Website: http://pranontheme.net/
 */

if (post_password_required()) : ?>
    <p class="nopassword"><?php esc_html_e('This post is password protected. Enter the password to view any comments.', 'appy'); ?></p>

    <?php
    /*
     * Stop the rest of comments.php from being processed,
     * but don't kill the script entirely -- we still have
     * to fully load the template.
     */
    return;


endif;
?>
<div class="comment_area">
    <?php if (have_comments()) : ?>
    <div class="comments-container">
        <h3><?php echo esc_html__('Comments','appy'); ?></h3>
        <div class="comments">
            <ul class="list-unstyled comments-list">
                <?php
                /*
                 * Loop through and list the comments.
                 */
                wp_list_comments(array(
                    'callback' => 'Wpbucket_partials::wpbucket_render_comments'
                ));
                ?>
                <?php if (get_comment_pages_count() > 1 && get_option('page_comments')): ?>
                    <li class="comments-pagination">
                        <?php paginate_comments_links(); ?>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>



    <?php
elseif (!comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) :
    ?>
    <div class="col-md-12">
        <p class="nocomments"><?php esc_html_e('Comments are closed.', 'appy'); ?></p>
    </div>
    <?php
endif;
?>

<?php if (comments_open()) : ?>
    <div class="comments-form">
        <h3><?php comment_form_title('Leave Your Comments', 'Submit Your Comment To %s'); ?></h3>
        <div id="respond">
            <div class="cancel-comment-reply reply">
                <?php cancel_comment_reply_link(); ?>
            </div>


                <?php if (get_option('comment_registration') && !is_user_logged_in()) : ?>
                    <div class="col-md-12 col-sm-12">
                        <p>
                            <?php esc_html_e('You must be', 'appy') ?> <a
                                href="<?php echo esc_url(wp_login_url(get_permalink())); ?>"><?php esc_html_e('logged in', 'appy') ?></a> <?php esc_html_e('to post a comment', 'appy') ?>
                            .
                        </p>
                    </div>
                <?php else : ?>
                    <form
                        action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php"
                        method="post" name="comments-form" class="primary-form comment_box clearfix">
                        <?php if (is_user_logged_in()) : ?>
                            
                            <p class="comment-notes">
                                <?php esc_html_e('Logged in as', 'appy') ?> <a
                                href="<?php echo esc_url(get_option('siteurl')); ?>/wp-admin/profile.php"><?php echo esc_html($user_identity); ?>
                                </a>. <a href="<?php echo esc_url(wp_logout_url(get_permalink())); ?>"
                                title="<?php esc_html_e('Log out from this account', 'appy'); ?>"><?php esc_html_e('Logged in as', 'appy') ?> &raquo;</a>
                            </p>
                        <?php else : ?>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6">
                                    <div class="form-group">
                                        <input class="form-control" type="text" id="yourname" placeholder="<?php esc_html_e('Enter Your Name', 'appy') ?>" name="author" required>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="youremail" name="email" placeholder="<?php esc_html_e('Enter Your Email', 'appy') ?>" required>
                                    </div>
                                </div>
                            </div>
                            
                        <?php endif; ?>
                        <div class="form-group">
                            <textarea class="form-control" id="yourmessage" rows="6"  name="message" placeholder="<?php esc_html_e('Enter Your Comment', 'appy') ?>"  required></textarea>
                        </div>
                        <button type="submit" class="btn btn-default center-block"><?php esc_html_e('Post Comment', 'appy') ?></button>
                        <?php comment_id_fields(); ?>

                        <?php do_action('comment_form', $post->ID); ?>
                    </form>
                <?php endif; ?>

            </div>
        </div>
<?php endif; ?>
</div>

