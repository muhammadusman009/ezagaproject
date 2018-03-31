<?php

/*
 * ---------------------------------------------------------
 * MetaBox
 *
 * Custom fields registration
 * ----------------------------------------------------------
 */

/*
 * --------------------------------------------------------------------
 * MetaBox for Custom Post Types
 * --------------------------------------------------------------------
 */

function wpbucket_register_meta_boxes($meta_boxes)
{

    // Define a meta box for Pages
    $prefix = 'pg_';

    $meta_boxes [] = array(
        'title' => esc_html__('Page Options', 'appy'),
        'pages' => array(
            'page'
        ),
        // Works with Meta Box Tabs plugin
        'tabs' => array(
            'page_title' => esc_html__('Page title', 'appy'),
        ),
        'tab_wrapper' => true,
        'tab_style' => 'default',
        'fields' => array(
            array(
                'name' => esc_html__('Hide page title', 'appy'),
                'id' => "{$prefix}hide_title",
                'desc' => esc_html__('Check this to hide page title section. Only applicable for "Default Page Template".', 'appy'),
                'type' => 'checkbox',
                'std' => '0',
                'tab' => 'page_title'
            )
        )
    );
    $prefix = 'pf_';
    $meta_boxes[] = array(
        'title' => esc_html__('Item Customization', 'appy'),
        'pages' => array('pi_team', 'appy'),
        'fields' => array(
            array(
                'name' => esc_html__('Designation', 'appy'),
                'id' => "{$prefix}designation",
                'desc' => esc_html__('Enter designation of this team member.', 'appy'),
                'type' => 'text',
                'std' => 'CEO',
            ),
            array(
                'name' => esc_html__('Social Info', 'appy'),
                'id' => "{$prefix}social_info",
                'desc' => esc_html__('Enter social font-awesome class into key(left) field and add corresponding social link into value(right) field. Go to http://fontawesome.io/icons/', 'appy'),
                'type' => 'key_value',
                'clone' => true,
            ),
        )
    );
    $prefix = 'ch_';
    $meta_boxes[] = array(
        'title' => esc_html__('Causes Customization', 'appy'),
        'pages' => array('pi_cause', 'appy'),
        'fields' => array(
            array(
                'name' => esc_html__('Goal Title', 'appy'),
                'id' => "{$prefix}goal",
                'desc' => esc_html__('Enter Causes Goal Title.', 'appy'),
                'type' => 'text',
                'std' => 'Goal',
            ),
            array(
                'name' => esc_html__('Goal Amount', 'appy'),
                'id' => "{$prefix}goalam",
                'desc' => esc_html__('Enter Causes Goal Amount.', 'appy'),
                'type' => 'text',
                'std' => '12500',
            ),
            array(
                'name' => esc_html__('Raised Title', 'appy'),
                'id' => "{$prefix}raised",
                'desc' => esc_html__('Enter Causes Raised Title.', 'appy'),
                'type' => 'text',
                'std' => 'Raised',
            ),
            array(
                'name' => esc_html__('Raised Amount', 'appy'),
                'id' => "{$prefix}raisedam",
                'desc' => esc_html__('Enter Causes Raised Amount.', 'appy'),
                'type' => 'text',
                'std' => '7500',
            ),
            array(
                'name' => esc_html__('Raised Amount Percentage', 'appy'),
                'id' => "{$prefix}raisedper",
                'desc' => esc_html__('Enter Causes Raised Amount Percentage.', 'appy'),
                'type' => 'text',
                'std' => '75',
            ),
            array(
                'name' => esc_html__('Causes Time Left', 'appy'),
                'id' => "{$prefix}time",
                'desc' => esc_html__('Enter Causes Time Left.', 'appy'),
                'type' => 'text',
                'std' => '15 days left',
            ),            
        )
    );
    return $meta_boxes;
}

add_filter('rwmb_meta_boxes', 'wpbucket_register_meta_boxes');
?>
