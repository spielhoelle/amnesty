<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package amnesty
 */
$img = '';
$classes = [];
if (has_post_thumbnail()) {
    $img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full')[0];
    $classes[] = 'header';
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
        <header class="entry-header">
        </header><!-- .entry-header -->

        <div class="entry-content">
            <?php
            the_content();

            wp_link_pages(array(
                'before' => '<div class="page-links">' . esc_html__('Pages:', 'amnesty'),
                'after'  => '</div>',
            ));
            ?>
        </div><!-- .entry-content --></div>

</article><!--content-page.php-->
