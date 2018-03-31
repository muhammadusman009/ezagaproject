<?php
/**
 * Copyright (c) 12/7/2017.
 * Theme Name: Appy
 * Author: pranontheme
 * Website: http://pranontheme.net/
 */

defined('ABSPATH') or die();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta charset="<?php bloginfo('charset'); ?>"/>

    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php
    wp_head();
    ?>
</head>
<body <?php body_class(); ?>>
    <div class="preloader">
        <div class="spinner">
            <div class="cube1"></div>
            <div class="cube2"></div>
        </div>
    </div>

    <header>

        <nav class="navbar navbar-default appy-menu" data-spy="appy-menu">
            <div class="container">

                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main_menu" aria-expanded="false">
                        <span class="sr-only"><?php esc_html_e('Toggle navigation','appy');?></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <?php echo Wpbucket_Partials::wpbucket_generate_logo_html(); ?>
                </div>

                <div class="collapse navbar-collapse" id="main_menu">
                    <?php echo Wpbucket_Partials::wpbucket_generate_menu_html(); ?>
                </div>

            </div>

        </nav>
    </header>

    