<?php
/**
 * Template part for displaying posts.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package telamo_new
 */
$img = ( has_post_thumbnail() ) ? wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' )[0] : catch_that_image();


?>
<article data-url="<?php the_permalink(); ?>"
         rel="<?php echo get_the_title() ?>"
         id="post-<?php the_ID(); ?>" <?php post_class( ( has_post_thumbnail() || catch_that_image() ) ? 'has_post_thumbnail' : '' ); ?>>
	<header class="entry-header">
		<?php
		echo '<h1>' . get_the_date() . '</h1>';
		echo '<p>' . get_the_title() . '</p>';

		$content = contentWithoutImg( 'Mehr...' );

		echo '<a href="' . get_the_permalink() . '" class="more-link show">Mehr…</a>';
		?>
	</header>
	<!-- .entry-header -->

	<div class="entry-content">
		<a href="<?php the_permalink() ?>">
			<img src="/wp-includes/images/blank.gif" style="background-image:url(<?php echo $img ?>)">
		</a>
	</div>
	<!-- .entry-content -->
</article>
<!-- content-post.php frontsite -->
