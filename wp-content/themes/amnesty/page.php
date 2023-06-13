<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package phytocomm
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php // get sub pages
		$subPages = get_pages( array(
			'child_of' => get_the_ID(),
			'sort_column' => 'menu_order,post_title',
			'post_type' => 'page',
			'post_status' => 'publish',
			'echo' => 0,
		) );

		// get parent's sub pages
		if ( $post->post_parent ) {
			$parentPage = new WP_Query( 'page_id=' . $post->post_parent );

			$parentSubPages = get_pages( array(
				'child_of' => $post->post_parent,
				'exclude' => get_the_ID(),
				'sort_column' => 'menu_order,post_title',
				'post_type' => 'page',
				'post_status' => 'publish',
				'echo' => 0,
			) );
		} ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php // onepage ... wrap in sections
			if ( $subPages || ! empty( $parentSubPages ) ) {
				get_template_part( 'template-parts/section', $post->post_name );
			} // default single page
			else {
				get_template_part( 'template-parts/content', get_post_type() );
			}
			?>

		<?php endwhile;

		// loop sub pages
		if ( $subPages ) {
			foreach ( $subPages as $subPage ) {

				// special section template for page for posts
				if ( $subPage->ID == get_option( 'page_for_posts' ) ) {
					get_template_part( 'template-parts/section', 'blog' );
				} else {
					$subPage = new WP_Query( 'page_id=' . $subPage->ID );

					while ( $subPage->have_posts() ) : $subPage->the_post();
						get_template_part( 'template-parts/section', $post->post_name );
					endwhile;
				}
			}

			// restore original post data
			wp_reset_postdata();
		}


		// loop parent's sub pages
		if ( ! empty( $parentSubPages ) ) :
			// display parent page
			while ( $parentPage->have_posts() ) : $parentPage->the_post();
				get_template_part( 'template-parts/section', $post->post_name );
			endwhile; // End of the loop.

			// display parent's sub pages
			foreach ( $parentSubPages as $subPage ) {
				// special section template for page for posts
				if ( $subPage->ID == get_option( 'page_for_posts' ) ) {
					get_template_part( 'template-parts/section', 'blog' );
				} else {
					$subPage = new WP_Query( 'page_id=' . $subPage->ID );

					while ( $subPage->have_posts() ) : $subPage->the_post();
						get_template_part( 'template-parts/section', $post->post_name );
					endwhile; // End of the loop.
				}
			}

			// restore original post data
			wp_reset_postdata();

		endif; ?>

	</main>
	<!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
