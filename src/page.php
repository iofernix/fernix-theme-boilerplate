<?php
/**
 * Fernix Theme Boilerplate.
 *
 * @package     Theme_Name
 * @author      Your Name
 * @copyright   2020 Your Name or Company Name
 * @license     GPL-3.0+
 */

get_header();
?>
<?php
while ( have_posts() ) {
	the_post();
	the_content();
}
?>
<?php
get_footer();
