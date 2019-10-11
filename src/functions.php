<?php
use Theme_Namespace\Theme_Name;

/** The reference of the theme name */
define( 'THEME_DIR', __DIR__ );

$mapping = array(
  'Theme_Namespace\Theme_Name' => get_template_directory() . '/includes/class-theme-name.php',
  'Theme_Namespace\Theme_Name_Admin' => get_template_directory() . '/admin/class-theme-name-admin.php',
  'Theme_Namespace\Theme_Name_i18n' => get_template_directory() . '/includes/class-theme-name-i18n.php',
  'Theme_Namespace\Theme_Name_Loader' => get_template_directory() . '/includes/class-theme-name-loader.php',
  'Theme_Namespace\Theme_Name_Public' => get_template_directory() . '/public/class-theme-name-public.php',
  'Theme_Namespace\Theme_Name_TGMPA' => get_template_directory() . '/includes/class-theme-name-tgmpa.php',
  'Theme_Namespace\Theme_Name_Update' => get_template_directory() . '/includes/class-theme-name-update.php',
);

spl_autoload_register(function ($class) use ($mapping) {
    if (isset($mapping[$class])) {
        require $mapping[$class];
    }
}, true);

/**
 * Begins execution of the theme.
 *
 * Since everything within the theme is registered via hooks,
 * then kicking off the theme from this point in the file does
 * not affect the page life cycle.
 *
 */
function run_theme_name()
{
    $theme = Theme_Name::get_instance();
    $theme->run();
}

run_theme_name();
