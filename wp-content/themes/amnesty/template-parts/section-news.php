<section id="section-<?php the_ID(); ?>" data-url="<?php the_permalink(); ?>"
         tabindex="<?php echo $post->menu_order; ?>" rel="<?php echo $post->post_title; ?>">
	<header class="entry-header">
		<h2 class="entry-title"><?php the_title() ?></h2>
	</header>

		<?php // switch WP to page for posts
		$blog = new WP_Query( 'posts_per_page=5, page_id=' . get_option( 'page_for_posts' ) );

		// loop through posts
		while ( $blog->have_posts() ) : $blog->the_post();
			get_template_part( 'template-parts/content', 'post' );
		endwhile; ?>

		<?php // restore original post data
		wp_reset_postdata(); ?>

	<a class="more-link show" href="<?php echo get_permalink( get_page_by_path( 'alle-news' ) ) ?>">Mehr...</a>
</section>
<!-- #section-news.php-## -->
