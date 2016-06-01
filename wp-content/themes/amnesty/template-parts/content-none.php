<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package amnesty
 */

?>
<div class="wrap">
	<section class="no-results not-found badge">
		<div>
			<header class="page-header">
				<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'amnesty' ); ?></h1>
			</header><!-- .page-header -->

			<div class="page-content">
				
					<p><?php esc_html_e( 'Nothing is worse than no donuts, cold coffee or empty search results.', 'amnesty' ); ?></p>
					<p><?php esc_html_e( 'Please try again with some different keywords', 'amnesty' ); ?></p>


					<?php	get_search_form(); ?>
			</div><!-- .page-content -->
		</div><!-- .page-content -->
	</section><!-- .no-results -->
</div>
