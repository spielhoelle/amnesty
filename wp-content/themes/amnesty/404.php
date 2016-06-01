<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package amnesty
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main wrap" role="main">
			<div class="wrap">
				<section class="error-404 not-found badge">
					<header class="page-header">
						<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'amnesty' ); ?></h1>
					</header><!-- .page-header -->

					<div class="page-content">

							<h2><?php esc_html_e( 'Nothing is worse than no donuts, cold coffee or empty search results.', 'amnesty' ); ?></h2>
							<p><?php esc_html_e( 'Please try again with some different keywords', 'amnesty' ); ?></p>

							<?php	get_search_form(); ?>
					</div><!-- .page-content -->
				</section><!-- .error-404 -->
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
