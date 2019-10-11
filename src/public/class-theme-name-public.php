<?php
namespace Theme_Namespace;

/**
 * The public-facing functionality of the theme.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Theme_Name
 * @subpackage Theme_Name/public
 */

/**
 * The public-facing functionality of the theme.
 *
 * Defines the theme name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Fernix_License_Manager
 * @subpackage Fernix_License_Manager/public
 * @author     Your Name <email@example.com>
 */
class Theme_Name_Public
{

    /**
     * The name of this theme.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $theme_name    The name of this theme.
     */
    private $theme_name;

    /**
     * The version of this theme.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $theme_version    The current version of this theme.
     */
    private $theme_version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $theme_name       The name of the theme.
     * @param      string    $theme_version    The version of this theme.
     */
    public function __construct($theme_name, $theme_version)
    {
        $this->theme_name = $theme_name;
        $this->theme_version = $theme_version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style($this->theme_name, get_template_directory_uri() . '/public/css/theme-name-public.css', array(), $this->theme_version, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script($this->theme_name, get_template_directory_uri() . '/public/js/theme-name-public.js', array(), $this->theme_version, false);
    }
}
