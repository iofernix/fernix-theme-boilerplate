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

	<main role="main">
		<!-- section -->
		<section>

			<!-- article -->
			<article id="post-404">
				<h1><?php esc_html_e( 'Page not found', 'fernix' ); ?></h1>
				<h2>
					<a href="<?php echo esc_url( home_url() ); ?>"><?php esc_html_e( 'Return home?', 'fernix' ); ?></a>
				</h2>

			</article>
			<!-- /article -->

		</section>
		<!-- /section -->
	</main>

<?php get_footer(); ?>
