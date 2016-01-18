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
	<div class="entry-content">

		<?php
		echo '<h1 class="date">' . get_the_date() . '</h1>';
		the_title( '<h3 class="entry-title">', '</h3>' );

		the_content();
		?>

		<div class="artists-info">

			<?php
			if ( "" !== get_post_meta( $post->ID, 'is-release', true ) ) { ?>

				<div>
					<h3>Release Info:</h3>

					<table class="subinfos">
						<?php
						echo ( get_post_meta( get_the_ID(), "_album", true ) !== '' ) ? '<tr class="meta"><td>Album: </td><td>' . get_post_meta( get_the_ID(), "_album", true ) . "</td></tr>" : '';
						echo ( get_post_meta( get_the_ID(), "_date", true ) !== '' ) ? '<tr class="meta"><td>Veröffentlichungsdatum: </td><td>' . get_post_meta( get_the_ID(), "_date", true ) . "</td></tr>" : '';
						echo ( get_post_meta( get_the_ID(), "_ean", true ) !== '' ) ? '<tr class="meta"><td>EAN: </td><td>' . get_post_meta( get_the_ID(), "_ean", true ) . "</td></tr>" : '';
						?>
					</table>
				</div>

			<?php } ?>
			<div>
				<?php if ( "" !== get_post_meta( $post->ID, 'is-release', true ) ) { ?>
					<div class="links">
						<h3>Erhältlich bei:</h3><?php
						echo ( get_post_meta( get_the_ID(), "_itunes", true ) ) ? '<a class="more-link" href="' . get_post_meta( get_the_ID(), "_itunes", true ) . '">iTunes</a>' : '';
						echo ( get_post_meta( get_the_ID(), "_amazon", true ) ) ? '<a class="more-link" href="' . get_post_meta( get_the_ID(), "_amazon", true ) . '">Amazon</a>' : '';
						echo ( get_post_meta( get_the_ID(), "_s24d", true ) ) ? '<a class="more-link" href="' . get_post_meta( get_the_ID(), "_s24d", true ) . '">Shop24Direct</a>' : '';
						?>
					</div>
				<?php }

				//show related Artists
				$existing_terms = get_the_terms( $post->ID, 'related_artists' );
				if ( $existing_terms ) {
					echo '<div class="related-artists">';
					echo ' <h3>Verknüpfte Künstler:</h3>';
					foreach ( get_the_terms( $post->ID, 'related_artists' ) as $term ) {
						echo '<a class="more-link" href="' . get_permalink( get_page_by_path( $term->slug, OBJECT, 'artists' ) ) . '">' . $term->name . '</a>';
					}
					echo '</div>';
				}
				?>
			</div

		</div>
	</div>

	<!-- .entry-content -->

</article><!-- #post-(content-single.php)## -->

