<?php
/**
 * Fernix Theme Boilerplate.
 *
 * @package     Theme_Name
 * @author      Your Name
 * @copyright   2020 Your Name or Company Name
 * @license     GPL-3.0+
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta http-equiv="X-UA-Compatible" content="ie=edge,chrome=1">
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<title><?php wp_title( '|', true, 'right' ); ?> <?php bloginfo( 'name' ); ?></title>

		<link href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/icons/favicon.ico" rel="shortcut icon">
		<link href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/icons/touch.png" rel="apple-touch-icon-precomposed">

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?php bloginfo( 'description' ); ?>">

		<?php wp_head(); ?>

	</head>
	<body <?php body_class(); ?>>
