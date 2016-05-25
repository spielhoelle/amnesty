<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package amnesty
 */
 $classes = [];
 $img =  wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' )[0];
 if($img) {
   $classes[] = 'header';
 } else {
   $classes[] = 'noheader';
 }
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <figure class="<?php echo implode(' ', $classes) ?>">
        <img src="/wp-includes/images/blank.gif" style="background-image:url(<?php echo $img ?>)">
        <figcaption>
            <?php the_title('<h1 class="entry-title">', '</h1>'); ?>

        </figcaption>
    </figure>
    <div class="wrap">
        <div class="content-wrapper">
            <?php
            the_content();

            wp_link_pages(array(
                'before' => '<div class="page-links">' . esc_html__('Pages:', 'amnesty'),
                'after'  => '</div>',
            ));
            ?>
        </div><!-- .content-wrapper -->
    </div>

</article><!--content-page.php-->
