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
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			?>

		<!-- article -->
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<!-- post thumbnail -->
			<?php if ( has_post_thumbnail() ) : // Check if Thumbnail exists. ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					<?php the_post_thumbnail(); // Fullsize image for the single post. ?>
				</a>
			<?php endif; ?>
			<!-- /post thumbnail -->

			<!-- post title -->
			<h1>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
			</h1>
			<!-- /post title -->

			<!-- post details -->
			<span class="date"><?php the_time( 'F j, Y' ); ?> <?php the_time( 'g:i a' ); ?></span>
			<span class="author"><?php esc_html_e( 'Published by', 'fernix' ); ?> <?php the_author_posts_link(); ?></span>
			<span class="comments">
			<?php
			if ( comments_open( get_the_ID() ) ) {
				comments_popup_link( __( 'Leave your thoughts', 'fernix' ), __( '1 Comment', 'fernix' ), __( '% Comments', 'fernix' ) );}
			?>
			</span>
			<!-- /post details -->

					<?php
					the_content(
						sprintf(
							wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
								__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentynineteen' ),
								array(
									'span' => array(
										'class' => array(),
									),
								)
							),
							get_the_title()
						)
					);
					?>

					<?php the_tags( __( 'Tags: ', 'fernix' ), ', ', '<br>' ); // Separated by commas with a line break at the end. ?>

			<p>
			<?php
			esc_html_e( 'Categorised in: ', 'fernix' );
			the_category( ', ' ); // Separated by commas.
			?>
		</p>

			<p>
			<?php
			esc_html_e( 'This post was written by ', 'fernix' );
			the_author();
			?>
		</p>

			<?php edit_post_link(); // Always handy to have Edit Post Links available. ?>

			<?php comments_template(); ?>

		</article>
		<!-- /article -->

	<?php endwhile; ?>

	<?php else : ?>

		<!-- article -->
		<article>

			<h1><?php esc_html_e( 'Sorry, nothing to display.', 'fernix' ); ?></h1>

		</article>
		<!-- /article -->

	<?php endif; ?>

	</section>
	<!-- /section -->
	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
