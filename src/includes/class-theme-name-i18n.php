<?php
namespace Theme_Namespace;

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this theme
 * so that it is ready for translation.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Theme_Name
 * @subpackage Theme_Name/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this theme
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Theme_Name
 * @subpackage Theme_Name/includes
 * @author     Your Name <email@example.com>
 */
class Theme_Name_i18n {

	/**
	 * Load the theme text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_theme_textdomain()
	{
			load_theme_textdomain('fernix', get_template_directory() . '/languages');
	}

}
