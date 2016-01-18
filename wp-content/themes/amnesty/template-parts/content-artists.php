<?php
/**
 * Template part for displaying single posts.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package telamo_new
 */
$current_terms = get_the_terms( $post->ID, 'label' );
$labels        = get_terms( 'label', array( 'hide_empty' => false ) );

if ( $current_terms ) {
	foreach ( $current_terms as $current_term ) {
		$current_term_names[] = $current_term->name;
	}
}
global $wp_query;
?>

<header class="page-header">
	<h2 class="entry-title">Künstler</h2>

	<h3>Sortierung:</h3>

	<div class="labels">
		<?php $current = ( ! $current_term && ! is_tax( 'letters' ) ) ? ' current' : '' ?>
		<a class="more-link<?php echo $current ?>"
		   href="<?php echo get_post_type_archive_link( 'artists' ); ?>">Alle</a>
		<?php $labels = get_terms( 'label', array( 'hide_empty' => false ) );
		uasort( $labels, 'sort_myarr' );

		if ( ! empty( $labels ) && ! is_wp_error( $labels ) ) {
			foreach ( $labels as $term ) {
				$current = ( isset( $current_term->name ) && $current_term->name === $term->name ) ? ' current' : '';
				echo '<a class="more-link ' . $current . '" href="' . esc_url( get_term_link( $term ) ) . '">' . $term->name . '</a>';
			}
		} ?>
	</div>

	<div class="sorting">
		<?php displayArtistIndex(); ?>
		<?php get_search_form(); ?>
	</div>

</header>





<?php
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( has_post_thumbnail() || catch_that_image() ): ?>
		<header class="entry-header">
			<figure class="thumbnail">
				<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' )[0]; ?>
				<img src="/wp-includes/images/blank.gif" style="background-image: url(<?php echo $thumb ?>)"/>
			</figure>
		</header>
	<?php endif; ?>
	<!-- .entry-header -->

	<div class="entry-content">
		<?php the_title( '<h1 class="entry-title">', '</h1>' );
		if ( has_post_thumbnail() ) {
			the_content();
		} else {
			echo contentWithoutImg();
		}
		?>
	</div>
	<!-- .entry-content -->
</article>

<?php

//show Related News on artists page
$related_news = new WP_Query( array(
	'post_type'      => 'post',
	'posts_per_page' => 3,
	'tax_query'      => array(
		array(
			'taxonomy' => 'related_artists',
			'field'    => 'slug',
			'terms'    => $post->post_name,
		),
	),
) );
if ($related_news->have_posts()) { ?>
	<h2 class="entry-title">Verknüpfte News: </h2>


	<?php
	while ( $related_news->have_posts() ) : $related_news->the_post();
		get_template_part( 'template-parts/content', 'post' );
	endwhile;
	wp_reset_postdata();
	}
	?>

<?php

//show Other Artists on artists page
$other_artists = new WP_Query( [
	'post_type'      => 'artists',
	'posts_per_page' => - 1,
	'post__not_in'   => [ $post->ID ]
] );
if ( $other_artists->have_posts() ) : ?>
	<h2 class="entry-title">Andere Künstler</h2>
	<div class="artists-wrapper">
		<div class="artists-slideshow">
			<div class="flexgrid">
				<?php while ( $other_artists->have_posts() ) : $other_artists->the_post(); ?>
					<?php get_template_part( 'template-parts/content', '' ); ?>
				<?php endwhile; ?>
			</div>
		</div>
	</div>
<?php endif;
wp_reset_postdata(); ?>
<!-- content-artist -->

