<?php
/**
 * Fernix Theme Boilerplate.
 *
 * @package     Theme_Name
 * @author      Your Name
 * @copyright   2020 Your Name or Company Name
 * @license     GPL-3.0+
 */

namespace Theme_Namespace;

/**
 * The admin-specific functionality of the theme.
 *
 * Defines the theme name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Theme_Name
 * @subpackage Theme_Name/admin
 * @author     Fernix <info@fernix.io>
 */
class Theme_Name_Admin {

	/**
	 * The unique identifier of this theme.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $name    The string used to uniquely identify this theme.
	 */
	protected $theme_name;

	/**
	 * The current version of the theme.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the theme.
	 */
	protected $theme_version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $theme_name       The name of this theme.
	 * @param      string $theme_version    The version of this theme.
	 */
	public function __construct( $theme_name, $theme_version ) {

		$this->theme_name    = $theme_name;
		$this->theme_version = $theme_version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Theme_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Theme_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->theme_name, get_template_directory_uri() . 'css/theme-name-admin.css', array(), $this->theme_version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Theme_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Theme_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->theme_name, get_template_directory_uri() . 'js/theme-name-admin.js', array(), $this->theme_version, false );

	}

}
