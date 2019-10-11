<?php
namespace Theme_Namespace;

/**
 * The file that defines the core theme class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Theme_Name
 * @subpackage Theme_Name/includes
 */

/**
 * The core theme class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this theme as well as the current
 * version of the theme.
 *
 * @since      1.0.0
 * @package    Theme_Name
 * @subpackage Theme_Name/includes
 * @author     Your Name <email@example.com>
 */
class Theme_Name {

	/**
	 * Static variable of the singleton instance class.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      object    $instance
	 */
	protected static $instance;

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the theme.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Theme_Name_Loader    $loader    Maintains and registers all hooks for the theme.
	 */
	protected $loader;

	/**
	 * The metadata information of this theme.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      mixed    $theme_data
	 */
	protected $theme_data;

	/**
	 * Define the core functionality of the theme.
	 *
	 * Set the theme name and the theme version that can be used throughout the theme.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->load_dependencies();

		$this->set_data();
		$this->set_locale();

		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_update_hooks();

	}

	/**
	 * Load the required dependencies for this theme.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		$this->loader = new Theme_Name_Loader();

		$theme_tgmpa = new Theme_Name_TGMPA();
		$this->loader->add_action('tgmpa_register', $theme_tgmpa, 'required_plugins' );

	}

	/**
	 * Define the metadata for this theme.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_data() {

		$this->theme_data = wp_get_theme(THEME_DIR);

	}

	/**
	 * Define the locale for this theme for internationalization.
	 *
	 * Uses the Theme_Name_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$theme_i18n = new Theme_Name_i18n();

		$this->loader->add_action( 'wp_loaded', $theme_i18n, 'load_theme_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the theme.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
			$theme_admin = new Theme_Name_Admin( $this->get_theme_name(), $this->get_theme_version() );

			$this->loader->add_action( 'admin_enqueue_scripts', $theme_admin, 'enqueue_styles' );
			$this->loader->add_action( 'admin_enqueue_scripts', $theme_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the theme.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

			$theme_public = new Theme_Name_Public( $this->get_theme_name(), $this->get_theme_version() );

			$this->loader->add_action( 'wp_enqueue_scripts', $theme_public, 'enqueue_styles' );
			$this->loader->add_action( 'wp_enqueue_scripts', $theme_public, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the update functionality
	 * of the theme.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_update_hooks() {

		$theme_update = new Theme_Name_Update( $this->get_theme_data() );

		$this->loader->add_filter( 'pre_set_site_transient_update_themes', $theme_update, 'check_for_update' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {

		$this->loader->run();

	}

	/**
	 * Theme_Name Class Singleton
	 *
	 * @since     1.0.0
	 * @return    mixed
	 */
	public static function get_instance() {
		if ( !isset(self::$instance) ) {
    	self::$instance = new Theme_Name();
    }

    return self::$instance;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the theme.
	 *
	 * @since     1.0.0
	 * @return    Theme_Name_Loader    Orchestrates the hooks of the theme.
	 */
	public function get_loader() {

		return $this->loader;

	}

	/**
	 * The theme object with theme information.
	 *
	 * @since     1.0.0
	 * @return    object    Object with theme information.
	 */
	public function get_theme_data() {

		return $this->theme_data;

	}

	/**
	 * The name of the theme used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the theme.
	 */
	public function get_theme_name() {

		return $this->theme_data->get('Name');

	}

	/**
	 * Retrieve the version number of the theme.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the theme.
	 */
	public function get_theme_version() {

		return $this->theme_data->get('Version');

	}

}
