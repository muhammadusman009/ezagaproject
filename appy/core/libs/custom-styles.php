<?php

/**
 * Manage custom css files
 */
class Wpbucket_Core_Custom_Styles
{

    private static $file_path;
    private static $file_url;
    private static $chmod_file;
    private static $chmod_dir;
    private static $custom_css_file_name = 'custom.css';
    private static $custom_color_file_name = 'color.css';
    private static $file_system_error = array();
    private static $processing;

    static function init()
    {

        // hooks
        add_filter('redux/options/wpbucket_options/compiler', 'Wpbucket_Core_Custom_Styles::redux_css_compiler', 10, 3);

        // load custom color css file
        add_filter('wpbucket_css_files', 'Wpbucket_Core_Custom_Styles::load_custom_color_css');

        // load custom css file
        add_filter('wpbucket_css_files', 'Wpbucket_Core_Custom_Styles::load_custom_css');

        static::file_location();
    }

    /**
     * Set file path and url in local variables
     */
    static function file_location()
    {

        // sanitize theme name for name of the directory
        $dir_name = sanitize_file_name(sanitize_title(WPBUCKET_THEME_NAME));

        // get uploads dir
        $upload = wp_upload_dir();

        // uploads directory
        $uploads_dir = $upload['basedir'];
        $uploads_dir = trailingslashit($uploads_dir) . trailingslashit($dir_name);
        static::$file_path = $uploads_dir;

        // uploads url
        $uploads_url = $upload['baseurl'];
        $uploads_url = trailingslashit($uploads_url) . trailingslashit($dir_name);
        static::$file_url = $uploads_url;
    }

    /**
     * Callback for Redux compiler hook that stores custom.css file to
     * uploads directory. Script will also create sub-directory with name
     * of the theme.
     *
     * @global type $wp_filesystem
     * @param array $options
     * @param string $css
     * @param array $changed_values
     * @return void
     */
    static function redux_css_compiler($options, $css, $changed_values)
    {

        global $wp_filesystem, $wpbucket_theme_config;

        // if CSS field or custom color fields aren't modified, stop processing
        if (isset($changed_values['custom_css']) || isset($changed_values['custom_color_style'])) {
            self::$processing = true;
        } else {
            return;
        }

        // prepare filesystem
        Wpbucket_Core_Custom_Styles::prepare_filesystem();

        // try to create new directory with the name of theme in uploads dir
        if ($wp_filesystem) {
            $file_path = self::$file_path;

            if (!is_dir(self::$file_path)) {

                // try to create dir using Filesystem API
                $res = $wp_filesystem->mkdir(self::$file_path);

                // if Filesystem API fails, try using WP function
                if (!$res) {
                    $res = wp_mkdir_p(self::$file_path);

                    // if WP function fails, try with PHP function
                    if (!$res) {

                        // set error flags
                        self::$file_system_error['dir'] = '1';
                    } else {
                        self::$file_system_error['dir'] = '0';
                    }
                }
            }
        }

        // loop through all values that has changed
        foreach ($changed_values as $field => $value) {

            // check if field we watch are changed
            if ($field == 'custom_css') {
                $filename = self::$file_path . self::$custom_css_file_name;

                // get new value of custom_css field
                $css = wpbucket_return_theme_option('custom_css');
            } else if ($field == 'custom_color_style') {

                $filename = self::$file_path . self::$custom_color_file_name;

                // get new value of custom_css field

                $css = wpbucket_return_theme_option('custom_color_style', '', $wpbucket_theme_config['main_color']);
                $hover = wpbucket_return_theme_option('custom_color_style_hover', '', $wpbucket_theme_config['hover_color']);
                $border = wpbucket_return_theme_option('custom_color_style_border', '', $wpbucket_theme_config['border_color']);

                // check if custom color is set and store it to database
                // in case custom color is not set, remove database record and file from disk
                if (!empty($css)) {
                    $css = self::get_color_style_css($css, $hover, $border);
                    update_option('wpbucket_color_style_compiled_css', $css);
                } else {
                    Wpbucket_Core_Custom_Styles::clean_custom_color_style_records($filename);
                    continue;
                }
            } else {
                continue;
            }

            // try to create new directory with the name of theme in uploads dir
            if ($wp_filesystem && !isset(self::$file_system_error['dir'])) {

                // create file
                $res = $wp_filesystem->put_contents(
                    $filename, $css, self::$chmod_file // predefined mode settings for WP files
                );
                // verify that file is successfully created
                if (!$res) {
                    self::$file_system_error[$field] = '1';
                } else {
                    self::$file_system_error[$field] = '0';
                }
            } else {
                self::$file_system_error['filesystem'] = '1';
            }

            // if errors occured, store that in database
            Wpbucket_Core_Custom_Styles::update_filesystem_errors();
        }
    }

    /**
     * Filter array with CSS files that will be loaded and insert custom.css file
     *
     * @param array $css
     * @return array
     */
    static function load_custom_css($css)
    {
        global $wpbucket_theme_config;

        // load custom CSS file
        $file_exists = static::css_file_exists('css');

        /*
         * Load CSS in <head>
         * 
         * CONDITIONS:
         * File doesn't exists AND value is set in theme options - saving file failed probably due to bad permission configuration
         * OR
         * File exists AND filesystem error is set - file was already saved before but additional saving failed
         */

        $custom_css = wpbucket_return_theme_option('custom_css');

        if ((empty($file_exists) && !empty($custom_css)) || (!empty($file_exists) && Wpbucket_Core_Custom_Styles::is_filesystem_error('custom_css'))) {

            add_action('wp_enqueue_scripts', 'Wpbucket_Core_Custom_Styles::add_custom_css_inline_css', 16);

            // if file exists, inject file url to array
        } else if (!empty($file_exists) && !empty($custom_css)) {
            $filename = self::$file_url . self::$custom_css_file_name;

            $css['wpbucket-custom-css'] = array($filename, 'parent-style');
        }

        return $css;
    }

    /**
     * Filter array with CSS files that will be loaded and insert color.css file
     *
     * @param array $css
     * @return array
     */
    static function load_custom_color_css($css)
    {
        global $wpbucket_theme_config;

        /*
         * Load CSS in <head>
         * 
         * CONDITIONS:
         * File doesn't exists AND value is set in theme options - saving file failed probably due to bad permission configuration
         * OR
         * File exists AND filesystem error is set - file was already saved before but additional saving failed
         */
        $custom_color_style = wpbucket_return_theme_option('custom_color_style');
        $predefined_color_style = wpbucket_return_theme_option('predefined_color_style');
        if ($predefined_color_style != 'custom') {
            Wpbucket_Core_Custom_Styles::prepare_filesystem();
            $filename = self::$file_path . self::$custom_color_file_name;
            Wpbucket_Core_Custom_Styles::clean_custom_color_style_records($filename);
        }
        // load custom CSS file
        $file_exists = static::css_file_exists('color');
        if (empty($file_exists) && !empty($custom_color_style) || (!empty($file_exists) && Wpbucket_Core_Custom_Styles::is_filesystem_error('custom_color_style'))) {
            add_action('wp_enqueue_scripts', 'Wpbucket_Core_Custom_Styles::add_custom_color_inline_css', 15);
        } else if (!empty($file_exists)) {

            $filename = self::$file_url . self::$custom_color_file_name;

            // inject url to file
            $css['wpbucket-color'] = array($filename, 'parent-style');

            // if predefined color option is set, inject that color file
        } else if (!empty($predefined_color_style)) {

            $filename = trailingslashit(WPBUCKET_TEMPLATEURL) . 'css/' . $predefined_color_style . '.css';

            // inject url to file
            $css['wpbucket-color'] = array($filename, 'parent-style');

            // otherwise load default css file
        } else {

            if (class_exists("ReduxFrameworkInstances")) {
                // get Redux instance and default color
                $redux = ReduxFrameworkInstances::get_instance('wpbucket_options');
                $default_color = $redux->get_default_value('predefined_color_style');
                if ($default_color == '') {
                    $default_color = isset($wpbucket_theme_config['default_color']) ? $wpbucket_theme_config['default_color'] : false;
                }
            } else {
                $default_color = isset($wpbucket_theme_config['default_color']) ? $wpbucket_theme_config['default_color'] : false;
            }

            if (!empty($default_color)) {
                $filename = trailingslashit(WPBUCKET_TEMPLATEURL) . 'css/' . $default_color . '.css';
                // inject url to file
                $css['wpbucket-color'] = array($filename, 'parent-style');
            }
        }

        return $css;
    }

    /**
     * Load CSS for custom color to <head> instead of loading a file
     */
    static function add_custom_color_inline_css()
    {

        $custom_color = get_option('wpbucket_color_style_compiled_css');

        if (!empty($custom_color)) {
            wp_add_inline_style('parent-style', $custom_color);
        }
    }

    /**
     * Load CSS for custom CSS to <head> instead of loading a file
     * when unable to write to filesystem
     */
    static function add_custom_css_inline_css()
    {

        // get CSS from Theme Options
        $custom_css = wpbucket_return_theme_option('custom_css');

        if (!empty($custom_css)) {
            wp_add_inline_style('parent-style', $custom_css);
        }
    }

    /**
     * Verify if custom.css file exists in uploads directory
     *
     * @return bool
     */
    static function css_file_exists($type)
    {
        if ($type == 'css') {
            $filename = self::$file_path . self::$custom_css_file_name;
        } else if ($type == 'color') {
            $filename = self::$file_path . self::$custom_color_file_name;
        }

        return file_exists($filename);
    }

    /**
     * Get compiled custom color CSS
     *
     * @param string $custom_color
     * @return string
     */
    static function get_color_style_css($custom_color, $hover, $border)
    {
        include WPBUCKET_THEME_DIR . '/includes/configuration/color-style.php';

        return Wpbucket_Color_Style::get_compiled_css($custom_color, $hover, $border);
    }

    /**
     * Prepare Filesystem API
     *
     * @global type $wp_filesystem
     */
    static function prepare_filesystem()
    {
        global $wp_filesystem;

        // check if we have access to filesystem
        if (empty($wp_filesystem)) {
            require_once(ABSPATH . '/wp-admin/includes/file.php');
            WP_Filesystem();
        }

        // file permission
        if (defined('FS_CHMOD_FILE')) {
            self::$chmod_file = FS_CHMOD_FILE;
        } else {
            self::$chmod_file = 0644;
        }

        if (defined('FS_CHMOD_DIR')) {
            self::$chmod_dir = FS_CHMOD_DIR;
        } else {
            self::$chmod_dir = 0755;
        }
    }

    /**
     * In case of errors during the process of creating directories or saving files
     * save array with error logs in database for future use.
     *
     * We will use this array to determin if local CSS file should be loaded or
     * CSS should be rendered in <head>.
     *
     * In case when file couldn't be written to disk, CSS will be loaded to <head>
     */
    static function update_filesystem_errors()
    {

        // get errors array from database
        $file_system_errors = get_option('wpbucket_color_style_filesystem_error');

        // update errors status and store to database again
        if (!empty($file_system_errors)) {
            $merged = array_merge($file_system_errors, self::$file_system_error);
            update_option('wpbucket_color_style_filesystem_error', $merged);
        } else {
            update_option('wpbucket_color_style_filesystem_error', self::$file_system_error);
        }
    }

    /**
     * Verify if errors for specific taks occured.
     * For example we can verify if error appeared while creating directory on disk.
     * Available values: dir, filesystem, custom_css, custom_color_style
     *
     * @param type $type Type of error to verify
     * @return boolean Error appeared or not
     */
    static function is_filesystem_error($type)
    {
        $filesystem_error = get_option('wpbucket_color_style_filesystem_error');

        if (!empty($type)) {
            if (isset($filesystem_error[$type]) && $filesystem_error[$type] == '1') {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }

    /**
     * Remove custom color records from database and remove file
     * from uploads directory
     *
     * @global type $wp_filesystem
     * @param type $filename Path to the file to delete
     */
    static function clean_custom_color_style_records($filename)
    {
        global $wp_filesystem;

        // delete color style from database
        delete_option('wpbucket_color_style_compiled_css');

        // remove file from disk
        $res = $wp_filesystem->delete($filename);

        // verify that file is successfully removed and raise an error if not
        if (!$res) {
            self::$file_system_error['custom_color_style'] = '1';
        }
    }

}

Wpbucket_Core_Custom_Styles::init();
?>