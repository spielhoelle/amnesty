<section id="section-<?php the_ID(); ?>" data-url="<?php the_permalink(); ?>"
         tabindex="<?php echo $post->menu_order; ?>" rel="<?php echo $post->post_title; ?>">

	<?php // special content template for front page
	if ( get_the_ID() == get_option( 'page_on_front' ) ) get_template_part( 'template-parts/content', 'home' );
	else get_template_part( 'template-parts/content', get_post_type() ); ?>

</section>
<!-- #section.php-## -->
