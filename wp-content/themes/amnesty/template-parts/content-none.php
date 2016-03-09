<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package amnesty
 */

?>

<section class="no-results not-found badge">
	<div>
		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'amnesty' ); ?></h1>
		</header><!-- .page-header -->

		<div class="page-content">
			<?php
			if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

				<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'amnesty' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

			<?php elseif ( is_search() ) : ?>

				<p><?php esc_html_e( 'Nothing is worse than no donuts, cold coffee or empty search results.  Please try again with some different keywords.', 'amnesty' ); ?></p>


				<?php
					get_search_form();

			else : ?>

				<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'amnesty' ); ?></p>

				<?php
					get_search_form();

			endif; ?>
		</div><!-- .page-content -->
	</div><!-- .page-content -->
</section><!-- .no-results -->
