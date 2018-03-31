<?php

/*
 * ---------------------------------------------------------
 * Redux
 *
 * ReduxFramework Config File
 * ----------------------------------------------------------
 */
if (!class_exists('Redux')) {
    return;
}

// This is your option name where all the Redux data is stored.
$opt_name = "wpbucket_options";

$theme = wp_get_theme(); // For use with some settings. Not necessary.

$args = array(
    // TYPICAL -> Change these values as you need/desire
    'opt_name' => 'wpbucket_options',
    // This is where your data is stored in the database and also becomes your global variable name.
    'display_name' => $theme->get('Name'),
    // Name that appears at the top of your panel
    'display_version' => $theme->get('Version'),
    // Version that appears at the top of your panel
    'menu_type' => 'app_theme_page',
    // Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
    'allow_sub_menu' => true,
    // Show the sections below the admin menu item or not
    'menu_title' => esc_html__('Theme Options', 'appy'),
    'page_title' => esc_html__('Theme Options', 'appy'),
    // You will need to generate a Google API key to use this feature.
    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
    'google_api_key' => '',
    // Set it you want google fonts to update weekly. A google_api_key value is required.
    'google_update_weekly' => false,
    // Must be defined to add google fonts to the typography module
    'async_typography' => true,
    // Use a asynchronous font on the front end or font string
    // 'disable_google_fonts_link' => true, // Disable this in case you want to create your own google fonts loader
    'admin_bar' => true,
    // Show the panel pages on the admin bar
    'admin_bar_icon' => 'dashicons-portfolio',
    // Choose an icon for the admin bar menu
    'admin_bar_priority' => 50,
    // Choose an priority for the admin bar menu
    'global_variable' => '',
    // Set a different name for your global variable other than the opt_name
    'dev_mode' => false,
    // Show the time the page took to load, etc
    'update_notice' => true,
    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
    'customizer' => false,
    // Enable basic customizer support
    // 'open_expanded' => true, // Allow you to start the panel in an expanded way initially.
    // 'disable_save_warn' => true, // Disable the save warning when a user changes a field
    // OPTIONAL -> Give you extra features
    'page_priority' => null,
    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
    'page_parent' => "wpbucket_options",
    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
    'page_permissions' => 'manage_options',
    // Permissions needed to access the options panel.
    'menu_icon' => '',
    // Specify a custom URL to an icon
    'last_tab' => '',
    // Force your panel to always open to a specific tab (by id)
    'page_icon' => 'icon-themes',
    // Icon displayed in the admin panel next to your menu_title
    'page_slug' => '',
    // Page slug used to denote the panel
    'save_defaults' => true,
    // On load save the defaults to DB before user clicks save or not
    'default_show' => false,
    // If true, shows the default value next to each field that is not the default value.
    'default_mark' => '',
    // What to print by the field's title if the value shown is default. Suggested: *
    'show_import_export' => true,
    // Shows the Import/Export panel when not used as a field.
    // CAREFUL -> These options are for advanced use only
    'transient_time' => 60 * MINUTE_IN_SECONDS,
    'output' => true,
    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
    'output_tag' => true,
    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
    // 'footer_credit' => '', // Disable the footer credit of Redux. Please leave if you can help it.
    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
    'database' => '',
    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
    'system_info' => false
);

// SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
$args ['share_icons'] [] = array(
    'url' => 'https://github.com/pixel-industry/',
    'title' => 'Visit us on GitHub',
    'icon' => 'el-icon-github'
);
// 'img' => '', // You can use icon OR img. IMG needs to be a full URL.

$args ['share_icons'] [] = array(
    'url' => 'https://www.facebook.com/themebasket',
    'title' => 'Like us on Facebook',
    'icon' => 'el-icon-facebook'
);
$args ['share_icons'] [] = array(
    'url' => 'https://twitter.com/themebasket',
    'title' => 'Follow us on Twitter',
    'icon' => 'el-icon-twitter'
);
$args ['share_icons'] [] = array(
    'url' => 'http://www.linkedin.com/company/themebasket',
    'title' => 'Find us on LinkedIn',
    'icon' => 'el-icon-linkedin'
);
$args ['share_icons'] [] = array(
    'url' => 'http://dribbble.com/themebasket',
    'title' => 'Our Work on Dribbble',
    'icon' => 'el-icon-dribbble'
);

Redux::setArgs($opt_name, $args);

/*
 *
 * ---> START SECTIONS
 *
 */

// ACTUAL DECLARATION OF SECTIONS

Redux::setSection($opt_name, array(
    'icon' => 'el-icon-tint',
    'title' => esc_html__('Appearance', 'appy'),
    'fields' => array(

        
        array(
            'id' => 'custom_css',
            'type' => 'ace_editor',
            'title' => esc_html__('Custom CSS', 'appy'),
            'subtitle' => esc_html__('Quickly add some CSS to your theme by adding it to this block.', 'appy'),
            'mode' => 'css',
            'compiler' => true,
            'options' => array(
                'minLines' => 15
            )
        )
    )
));

Redux::setSection($opt_name, array(
    'icon' => 'el-icon-cogs',
    'title' => esc_html__('Header', 'appy'),
    'fields' => array(
        array(
            'id' => 'logo',
            'type' => 'media',
            'title' => esc_html__('Logo', 'appy'),
            'compiler' => 'true',
            'subtitle' => esc_html__('Upload logo for your website.', 'appy')
        ),
    )
));
Redux::setSection($opt_name, array(
    'icon' => 'el-icon-tint',
    'title' => esc_html__('Page title', 'appy'),
    'fields' => array(
        array(
            'id' => 'show_breadcrumbs',
            'type' => 'switch',
            'title' => esc_html__('Breadcrumbs', 'appy'),
            'subtitle' => esc_html__('Set breadcrumbs visibility.', 'appy'),
            "default" => 1,
            'on' => esc_html__('Show', 'appy'),
            'off' => esc_html__('Hide', 'appy')
        ),
        array(
            'id' => 'breadcrumbs_navigation_label',
            'type' => 'checkbox',
            'required' => array(
                'show_breadcrumbs',
                '=',
                '1'
            ),
            'title' => esc_html__('Breadcrumbs Text', 'appy'),
            'subtitle' => esc_html__('Show navigation label instead page/post title.', 'appy'),
            'default' => '0'
        ), // 1 = on | 0 = off
        array(
            'id' => 'breadcrumbs_length',
            'type' => 'text',
            'required' => array(
                'show_breadcrumbs',
                '=',
                '1'
            ),
            'title' => esc_html__('Breadcrumbs Length', 'appy'),
            'desc' => esc_html__('Breadcrumbs will be cut by number of characters entered here.', 'appy'),
            'validate' => 'numeric',
            'default' => 25
        ),
        array(
            'id' => 'breadcrumbs_prefix',
            'type' => 'text',
            'required' => array(
                'show_breadcrumbs',
                '=',
                '1'
            ),
            'title' => esc_html__('Breadcrumbs Prefix', 'appy'),
            'desc' => esc_html__('Text that will be added before breadcrumbs.', 'appy'),
            'default' => esc_html__('You are here: ', 'appy'),
        ),
        
        array(
            'id' => 'wpbucket_post_single_title',
            'type' => 'text',
            'title' => esc_html__('Post Detail Page Title', 'appy'),
            'desc' => esc_html__('Select post single page title.', 'appy'),
            'default' => esc_html__('Post details', 'appy'),
        ),
        array(
            'id' => 'title_background',
            'type' => 'background',
            'title' => esc_html__('Background', 'appy'),
            'compiler' => 'true',
            'background-color' => 'false',
            'subtitle' => esc_html__('Set Page title background options.', 'appy'),
            'output' => array('.page-heading-back'),
        ),

    )
));

Redux::setSection($opt_name, array(
    'icon' => 'el-icon-font',
    'title' => esc_html__('Typography', 'appy'),
    'fields' => array(
        array(
            'id' => 'body_font2',
            'type' => 'typography',
            'title' => esc_html__('Body Font', 'appy'),
            'subtitle' => esc_html__('Specify the body font properties.', 'appy'),
            'google' => true,
            'line-height' => false,
            'default' => array(
                'color' => '#333',
                'font-size' => '14px',
                'font-family' => '"Lato",sans-serif',
                'font-weight' => 'Normal',
            ),
            'output' => array(
                'body'
            )
        ),
        array(
            'id' => 'paragraphs',
            'type' => 'typography',
            'title' => esc_html__('Paragraph Font', 'appy'),
            'subtitle' => esc_html__('Specify the paragraph font properties.', 'appy'),
            'google' => true,
            'default' => array(
                'color' => '#fff',
                'font-family' => '"Lato", sans-serif',
                'font-weight' => 'Normal',
                'line-height' => '32px'
            ),
            'output' => array(
                'p'
            )
        ),
        array(
            'id' => 'heading_h1',
            'type' => 'typography',
            'title' => esc_html__('H1 Heading', 'appy'),
            'subtitle' => esc_html__('Specify the body font properties.', 'appy'),
            'google' => true,
            'output' => array(
                'h1'
            ),
            'default' => array(
                'color' => '#161d27',
                'font-size' => '60px',
                'font-family' => 'Montserrat',
                'line-height' => '60px'
            )
        ),
        array(
            'id' => 'heading_h2',
            'type' => 'typography',
            'title' => esc_html__('H2 Heading', 'appy'),
            'subtitle' => esc_html__('Specify the properties for H2.', 'appy'),
            'google' => true,
            'output' => array(
                'h2'
            ),
            'default' => array(
                'color' => '#161d27',
                'font-size' => '44px',
                'font-family' => 'Montserrat',
                'line-height' => '44px'
            )
        ),
        array(
            'id' => 'heading_h3',
            'type' => 'typography',
            'title' => esc_html__('H3 Heading', 'appy'),
            'subtitle' => esc_html__('Specify the properties for H3.', 'appy'),
            'google' => true,
            'output' => array(
                'h3'
            ),
            'default' => array(
                'color' => '#161d27',
                'font-size' => '36px',
                'font-family' => 'Montserrat',
                'line-height' => '36px'
            )
        ),
        array(
            'id' => 'heading_h4',
            'type' => 'typography',
            'title' => esc_html__('H4 Heading', 'appy'),
            'subtitle' => esc_html__('Specify the properties for H4.', 'appy'),
            'google' => true,
            'output' => array(
                'h4'
            ),
            'default' => array(
                'color' => '#161d27',
                'font-size' => '27px',
                'font-family' => 'Montserrat',
                'line-height' => '28px'
            )
        ),
        array(
            'id' => 'heading_h5',
            'type' => 'typography',
            'title' => esc_html__('H5 Heading', 'appy'),
            'subtitle' => esc_html__('Specify the properties for H5.', 'appy'),
            'google' => true,
            'output' => array(
                'h5'
            ),
            'default' => array(
                'color' => '#161d27',
                'font-size' => '18px',
                'font-family' => 'Montserrat',
                'line-height' => '24px',
                'text-transform' => 'uppercase'
            )
        ),
        array(
            'id' => 'heading_h6',
            'type' => 'typography',
            'title' => esc_html__('H6 Heading', 'appy'),
            'subtitle' => esc_html__('Specify the properties for H6.', 'appy'),
            'google' => true,
            'output' => array(
                'h6'
            ),
            'default' => array(
                'color' => '#161d27',
                'font-size' => '15px',
                'font-family' => 'Montserrat',
                'line-height' => '15px'
            )
        )
    )
));
Redux::setSection($opt_name, array(
    'icon' => 'el-icon-adjust-alt',
    'title' => esc_html__('404', 'appy'),
    'fields' => array(
        array(
            'id' => '404_main_heading',
            'type' => 'text',
            'title' => esc_html__('404 Heading', 'appy'),
            'subtitle' => esc_html__('Enter 404 page heading.', 'appy'),
            'default' => esc_html__('Page Not Found', 'appy'),
        ),
        array(
            'id' => '404_description',
            'type' => 'textarea',
            'title' => esc_html__('404 Description', 'appy'),
            'subtitle' => esc_html__('Enter description text.', 'appy'),
            'validate' => 'html',
            'default' => esc_html__('THE PAGE YOU ARE LOOKING FOR SEEMS TO BE MISSING', 'appy'),
        ),
    )
));
Redux::setSection($opt_name, array(
    'icon' => 'el-icon-adjust-alt',
    'title' => esc_html__('Footer', 'appy'),
    'fields' => array(
        array(
            'id' => 'copyright_text',
            'type' => 'textarea',
            'title' => esc_html__('Copyright Text', 'appy'),
            'subtitle' => esc_html__('Enter copyright text.', 'appy'),
            'validate' => 'html',
            'default' => esc_html__('Copyright © 2017 appy, Design & Develop by MK', 'appy'),
        ),
    )
));




