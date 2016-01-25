<?php
/**
 * Template part for displaying single posts.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package telamo_new
 */

?>

<header class="page-header">
	<h2 class="entry-title">News</h2>
</header>

<article id="post-<?php the_ID(); ?>" <?php post_class( ( get_the_ID() % 2 === 0 ) ? ' black' : '' ); ?>>
	<?php
	$img = (has_post_thumbnail()) ? wp_get_attachment_image_src(get_post_thumbnail_id(), 'full')[0] : '';
	$content = get_post_field('post_content', get_the_ID());
	$content_parts = get_extended($content);
	?>

	<figure>
		<a href="<?php the_permalink() ?>">
			<img src="/wp-includes/images/blank.gif" style="background-image:url(<?php echo $img ?>)">
		</a>

		<figcaption class="bubble">
			<h1 class="entry-title"><?php echo get_the_title() ?></h1>';
			<h2><?php echo $content_parts['main'] ?></h2>
			<a class="more-link" href="<?php the_permalink() ?>"> Mehr... </a>
		</figcaption>
	</figure>
	<div class="entry-content">

		<?php
		echo '<h1 class="date">' . get_the_date() . '</h1>';
		the_title( '<h3 class="entry-title">', '</h3>' );

		the_content();
		?>

	</div>

	<!-- .entry-content -->

</article><!-- #post-(content-single.php)## -->

