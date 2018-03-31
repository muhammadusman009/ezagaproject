<?php

/* ---------------------------------------------------------
 * One click installer
 *
 * Class for registering one click installer files
  ---------------------------------------------------------- */

require_once WPBUCKET_THEME_DIR . '/core/importer/wpbucket-importer.php'; //load admin theme data importer

class Wpbucket_Theme_Demo_Data_Importer extends Wpbucket_Theme_Importer {

    /**
     * Holds a copy of the object for easy reference.
     *
     * @since 0.0.1
     *
     * @var object
     */
    private static $instance;

    /**
     * Set the key to be used to store theme options
     *
     * @since 0.0.2
     *
     * @var object
     */
    public $theme_option_name = 'wpbucket_options'; //set theme options name here 

    /**
     * Holds demo content file names for each content type
     * 
     * CUSTOM POST TYPES
     * Key 'cpts' holds all custom post types registered in theme
     * 
     * SLIDERS
     * Rappylution slider key: slider
     * Master slider key: master_slider
     * 
     * @since 0.0.2
     * 
     * @var type array
     */
    public $demo_files = array(
        'pages' => 'pages.xml',
        'posts' => 'posts.xml',
		'attachments' => 'media.xml',
		'portfolio' => 'portfolio.xml',
		'service' => 'service.xml',
		'team' => 'team.xml',
		'menu' => 'menu.xml',
        'contact' => 'contact-form.xml',
        'slider' => array('revslider.zip'),
        'widgets' => 'widgets.wie',
        'newsletter_forms' => '1'
    );

    /**
     * Importer settings
     * 
     * Usage:
     * key (must not be changed) => value (name of the page to assign)
     * 
     * @since 0.0.3
     * 
     * @var type array
     */
    public $settings = array(
        'home' => 'Home', // name of Home page
        'blog' => 'Blog' // name of Blog page
    );
    
    /**
     * Menu locations
     * location => Menu name
     * 
     * @var type array
     */
    public $menu_locations = array(
        'primary' => 'Appy main menu',
    );

    /**
     * Holds a copy of the widget settings 
     *
     * @since 0.0.2
     *
     * @var object
     */
    public $widget_import_results;

    /**
     * Constructor. Hooks all interactions to initialize the class.
     *
     * @since 0.0.1
     */
    public function __construct() {

        $this->demo_files_path = WPBUCKET_THEME_DIR . '/includes/demo-files/';

        self::$instance = $this;
        parent::__construct();
    }

}

new Wpbucket_Theme_Demo_Data_Importer;
