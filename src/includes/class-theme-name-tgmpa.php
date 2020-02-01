<?php
namespace Theme_Namespace;

/**
 * The admin-specific functionality of the theme.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Fernix
 * @subpackage Fernix/admin
 * @author     Fernix <info@fernix.io>
 */
class Theme_Name_TGMPA {
    /**
     * Array of plugins. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     *
     * @var Array  Plugins required for the theme.
     */
    protected $plugins;

    /**
  	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
  	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
  	 * sending in a pull-request with .po file(s) with the translations.
  	 *
  	 * Only uncomment the strings in the config array if you want to customize the strings.
     *
     * @var Array  Array of configuration settings.
  	 */
  	protected $config;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct()
    {
        $this->config = array(
      		'id'           => 'theme-name',            // Unique ID for hashing notices for multiple instances of TGMPA.
      		'default_path' => '',                      // Default absolute path to bundled plugins.
      		'menu'         => 'tgmpa-install-plugins', // Menu slug.
      		'parent_slug'  => 'themes.php',            // Parent menu slug.
      		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
      		'has_notices'  => true,                    // Show admin notices or not.
      		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
      		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
      		'is_automatic' => true,                    // Automatically activate plugins after installation or not.
      		'message'      => '',                      // Message to output right before the plugins table.
      	);

        $this->plugins = array(
          array(
          	'name'               => 'WPBakery',                                             // The plugin name.
          	'slug'               => 'js_composer',                                          // The plugin slug (typically the folder name).
          	'source'             => get_template_directory() . '/plugins/js_composer.zip',  // The plugin source.
          	'required'           => true,                                                   // If false, the plugin is only 'recommended' instead of required.
          	'version'            => '6.0.3',                                                // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
          	'force_activation'   => false,                                                  // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
          	'force_deactivation' => false,                                                  // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
          	'external_url'       => '',                                                     // If set, overrides default API URL and points to an external URL.
          	'is_callable'        => '',                                                     // If set, this callable will be be checked for availability to determine if a plugin is active.
          )
      	);

        require_once get_template_directory() . '/vendors/class-tgm-plugin-activation.php';
    }

    public function required_plugins()
    {
        tgmpa( $this->plugins, $this->config );
    }
}
