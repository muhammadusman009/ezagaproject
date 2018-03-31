<?php

/*
 * ---------------------------------------------------------
 * Color style
 *
 * Class for custom color style rendering
 * ----------------------------------------------------------
 */

class Wpbucket_Color_Style
{
    static function get_compiled_css($color_style, $color_style_hover, $color_style_border)
    {
        $lighter_color = wpbucket_adjust_color_brightness($color_style, 4);

        ob_start();
        ?>
        .spin{
        color:<?php echo wp_kses($color_style, array()); ?>;
        }
        .navbar-stark .nav li ul li:hover a{
        color:<?php echo wp_kses($color_style_hover, array()); ?>;
        }
        .navbar-sticky-bottom .nav li ul li a:hover{
        color: <?php echo wp_kses($color_style_hover, array()); ?>!important;
        }
        .stark-nav-collapse .navbar-nav > li > a:hover {
        color: <?php echo wp_kses($color_style_hover, array()); ?> !important;
        }
        .stark-nav-collapse .navbar-nav > li.active > a {
        color: <?php echo wp_kses($color_style, array()); ?>!important;
        }
        .navbar-stark .navbar-nav > li > a:hover {
        color: <?php echo wp_kses($color_style_hover, array()); ?>;
        }
        .navbar-stark .navbar-nav > li.active > a {
        color: <?php echo wp_kses($color_style, array()); ?>;
        }
        .service-box:hover .service-box-detail h4:before{
        background: <?php echo wp_kses($color_style, array()); ?>;
        }
        .service-box:hover figcaption{
        background: rgba(51, 161, 221, 0.92);
        }
        .blue-back{
        background:<?php echo wp_kses($color_style, array()); ?>;
        }
        .small-header-2:after{
        background:<?php echo wp_kses($color_style, array()); ?>;
        }
        .offer-left{
        background:<?php echo wp_kses($color_style, array()); ?>;
        }
        .nav-top-right ul li a:hover{
        color:<?php echo wp_kses($color_style_hover, array()); ?>;
        }
        @media only screen and (max-width:992px) {
        .toggle.menu .line {
        background-color: <?php echo wp_kses($color_style, array()); ?>;
        }
        #menu-handler:checked ~ .mobile-nav .stark-nav-collapse .toggle.menu .line {
        background-color: <?php echo wp_kses($color_style, array()); ?>!important;
        }
        }
        .footer-1 ul li:hover{
        background: <?php echo wp_kses($color_style_hover, array()); ?>;
        }
        .footer-2 ul li a:hover{
        color: <?php echo wp_kses($color_style_hover, array()); ?>;
        }
        .footer-2 ul li a:hover:after {
        border-bottom: 1px solid <?php echo wp_kses($color_style_border, array()); ?>;
        }
        .footer-bottom-right p i{
        color:<?php echo wp_kses($color_style, array()); ?>;
        }
        .service-box:hover .service-box-detail{
        border-bottom:3px solid <?php echo wp_kses($color_style_border, array()); ?>;
        }
        .service-box:hover .service-box-detail h4:before{
        background: <?php echo wp_kses($color_style_border, array()); ?>;
        }
        .advisor-content{
        border-bottom:3px solid <?php echo wp_kses($color_style_border, array()); ?>;
        }
        .finance-content .btn-default{
        background:<?php echo wp_kses($color_style, array()); ?>;
        border:1px solid <?php echo wp_kses($color_style_border, array()); ?>;
        }
        .quote-back{
        background:<?php echo wp_kses($color_style, array()); ?>;
        }
        .main-header:after{
        background:<?php echo wp_kses($color_style, array()); ?>;
        }
        .member-title span:before{
        background:<?php echo wp_kses($color_style, array()); ?>;
        }
        .small-header-3:after{
        background:<?php echo wp_kses($color_style, array()); ?>;
        }
        .fun-number{
        color:<?php echo wp_kses($color_style, array()); ?>;
        }
        .latest-news:hover .news-content a,
        .latest-news-1:hover .news-content a{
        color: <?php echo wp_kses($color_style_hover, array()); ?>;
        }
        .latest-news:hover .news-content a:after {
        border-bottom: 1px solid <?php echo wp_kses($color_style_border, array()); ?>;
        }
        .form-btn{
        background:<?php echo wp_kses($color_style, array()); ?>;
        border: 1px solid <?php echo wp_kses($color_style_border, array()); ?>;
        }
        .form-btn:hover{
        background:<?php echo wp_kses($color_style, array()); ?>;
        border: 1px solid <?php echo wp_kses($color_style_border, array()); ?>;
        }
        .form-btn:active{
        background:<?php echo wp_kses($color_style, array()); ?>;
        border: 1px solid <?php echo wp_kses($color_style_border, array()); ?>;
        }
        .address ul li i{
        color:<?php echo wp_kses($color_style, array()); ?>;
        }
        .page-heading h2:after{
        background:<?php echo wp_kses($color_style_border, array()); ?>;
        }
        .project-box:hover .project-box-detail{
        border-bottom:3px solid <?php echo wp_kses($color_style_border, array()); ?>;
        }
        .project-box:hover .project-box-detail a.left-border:before{
        background: <?php echo wp_kses($color_style_border, array()); ?>;
        }
        .project-box:hover .project-box-detail a{
        color:<?php echo wp_kses($color_style, array()); ?>;
        }
        .single-project-link a{
        color:<?php echo wp_kses($color_style, array()); ?>;
        }
        .owl-theme .owl-controls .owl-page.active span, .owl-theme .owl-controls .owl-page:hover span{
        background:<?php echo wp_kses($color_style, array()); ?>!important;
        }
        .service-middle ul li:hover i{
        color:<?php echo wp_kses($color_style, array()); ?>;
        }
        .service-category ul li:hover{
        border-bottom:1px solid <?php echo wp_kses($color_style_border, array()); ?>;
        }
        .service-category ul li:hover a{
        color:<?php echo wp_kses($color_style, array()); ?>;
        }
        .category-bottom{
        background:<?php echo wp_kses($color_style, array()); ?>;
        }
        .blog-category-bottom{
        background:<?php echo wp_kses($color_style, array()); ?>;
        }
        .appy-comment-btn{
        background:<?php echo wp_kses($color_style, array()); ?>;
        border: 1px solid <?php echo wp_kses($color_style_border, array()); ?>;
        }

        <?php
        $css = ob_get_clean();

        return $css;
    }
}
