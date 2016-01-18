<?php
$labels = get_terms( 'label', array( 'hide_empty' => false ) );
uasort( $labels, 'sort_myarr' );
?>

<section id="section-<?php the_ID(); ?>" data-url="<?php the_permalink(); ?>"
         tabindex="<?php echo $post->menu_order; ?>" rel="<?php echo $post->post_title; ?>">
	<article>
		<header class="entry-header">
			<h2 class="entry-title">Label</h2>
		</header>


		<div class="entry-content">
			<?php
			if ( ! empty( $labels ) && ! is_wp_error( $labels ) ) {
				uasort( $labels, 'sort_myarr' );

				foreach ( $labels as $term ) { ?>
					<figure class="bubble gradient" href="<?php echo esc_url( get_term_link( $term ) ) ?>">
						<?php if ( $term->term_image ) {
							$term_link = get_term_link( $term );
							?>
							<a href="<?php echo esc_url( $term_link ) ?>">
								<img src="/wp-includes/images/blank.gif"
								     style="background-image: url(<?php echo wp_get_attachment_image_src( $term->term_image, 'full' )[0]; ?>)"/>
							</a>

						<?php } ?>
						<figcaption class="labeltitle">
							<h1><?php echo $term->name ?></h1>
						</figcaption>
					</figure>
				<?php }
			} ?>
		</div>

	</article>
</section>
<!-- #section-label.php## -->
