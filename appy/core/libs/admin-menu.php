<?php
function wpbucket_register_my_custom_menu_page() {
    add_menu_page(WPBUCKET_THEME_NAME, WPBUCKET_THEME_NAME, 'manage_options', "wpbucket_options", 'wpbucket_custom_theme_page', '', 81);
}
add_action('admin_menu', 'wpbucket_register_my_custom_menu_page', 9);
// enqueue stylesheets
function wpbucket_admin_menu_enqueue_stylesheet($hook) {
    wp_enqueue_style('wpbucket_admin_menu', WPBUCKET_TEMPLATEURL . '/core/assets/css/admin-menu.css', array(), '1.0', 'screen');
}

add_action('admin_enqueue_scripts', 'wpbucket_admin_menu_enqueue_stylesheet');

// template description page
function wpbucket_custom_theme_page() {
    global $wpbucket_theme_config;

    // get all installed themes
    $themes = wp_get_themes();
    
    // get current theme object
    $current_theme = wp_get_theme();
    ?>
    <div class="wpbucket-theme-page">
        <div class="page-header">    
            <h2><?php echo esc_html($current_theme->get('Name')) ?></h2>
            <small><?php echo esc_html($current_theme->get('Description')) ?></small>
        </div>

        <div class="page-content">
            <div class="theme-image">
                <?php
                
                // get theme screenshot
                $screenshot = $current_theme->get_screenshot();

                // in case Child theme is activated and screenshot is not set
                // use parent theme screenshot
                if (is_child_theme() && empty($screenshot)) {
                    
                    // get parent theme name
                    $template = $current_theme->Template;

                    // get theme object
                    $theme = $themes[$template];
                    
                    // get screenshot
                    $screenshot = $theme->get_screenshot();                    
                }

                // output theme screenshot
                echo '<img src="' . esc_url($screenshot) . '" alt="theme screenshot"/>';
                ?>
            </div>
            
            <!-- Theme description -->
            <div class="theme-info">                
                <h2><?php echo esc_html($current_theme->get('Name')) ?></h2>
                <label><?php esc_html_e('Description:', 'appy') ?></label>
                <p><?php echo esc_html($current_theme->get('Description')) ?></p>
                <label><?php esc_html_e('Tags:', 'appy') ?></label>
                <p><?php echo join(", ", $current_theme->get('Tags')) ?></p>
                <label><?php esc_html_e('Version:', 'appy') ?></label>
                <p><?php echo esc_html($current_theme->get('Version')) ?></p>
            </div>

            <!-- Documentation section -->
            <div class="theme-documentation">
                <h2><?php esc_html_e('Documentation', 'appy') ?></h2>
                <p><?php esc_html_e('Theme comes with Documentation where you can find how to Setup and use the theme. Documentation can be found in archive downloaded from ThemeForest.', 'appy') ?></p>            
            </div>

            <!-- Support section -->
            <div class="theme-support">
                <h2><?php esc_html_e('Support', 'appy') ?></h2>
                <p><?php echo wp_kses(__("If you can't find answer to your problem in Documentation please register on our <a href='//support.pixel-industry.com' target='_BLANK'>support forum</a>.
                    We have dedicated team that will help you with your problem.", 'appy'), $wpbucket_theme_config['allowed_html_tags']) ?><br/>
                    <?php echo wp_kses(__("Note that before registering you will need to obtain Purchase code from ThemeForest. Read <a href='//pixel-industry.com/how-to-obtain-purchase-code/' target='_BLANK'>here</a> how to obtain key.", 'appy'), $wpbucket_theme_config['allowed_html_tags']) ?>

                </p>
            </div>

           <!-- <div class="theme-updates">
                <h2><?php /*esc_html_e('Updates:', 'appy') */?></h2>
                <p><?php /*esc_html_e('To receive notification for theme updates please install official ThemeForest plugin for updates:', 'appy') */?> <a href="<?php /*echo esc_url(admin_url('admin.php?page=install-required-plugins')); */?>#updates"><?php /*esc_html_e('Envato Market - Updates.', 'appy') */?></a></p>
            </div>-->
        </div>

    </div>
    <?php
}
