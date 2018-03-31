<?php
/**
 * Copyright (c) 12/7/2017.
 * Theme Name: Appy
 * Author: pranontheme
 * Website: http://pranontheme.net/
 */

defined('ABSPATH') or die();

get_header();
$main_title = wpbucket_return_theme_option('404_main_heading', '', 'Oops, This Page Could Not Be Found!');
$description = wpbucket_return_theme_option('404_description', '', 'We couldn\'t find the page you were looking for.');
$logo_image_html = Wpbucket_Partials::wpbucket_get_logo_image_html();
?>

<section class="page-head">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2><?php echo esc_html__('404', 'appy') ?></h2>
                <p class="text-white"><?php echo esc_html__('Page Not Found', 'appy') ?></p>
            </div>
        </div>
    </div>
</section>
<div class="text-center mt-20 mb-20 pb-100">
	<h3><?php echo wp_kses($main_title , $wpbucket_theme_config['allowed_html_tags']); ?></h3>
    <h5><?php echo wp_kses($description , $wpbucket_theme_config['allowed_html_tags']); ?></h5>
    <a href="<?php echo home_url('/') ?>" class="button button-simple mt-20 mb-20"><?php echo esc_html__('Back to the Home', 'appy') ?></a>
</div>
<?php get_footer(); ?>
</body>
</html>