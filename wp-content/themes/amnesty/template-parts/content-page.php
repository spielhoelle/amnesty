<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package amnesty
 */
$img = (has_post_thumbnail()) ? wp_get_attachment_image_src(get_post_thumbnail_id(), 'full')[0] : '';

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if($img !== ''){ ?>
        <figure class="header">
        <img src="/wp-includes/images/blank.gif" style="background-image:url(<?php echo $img ?>)">
    </figure>
    <?php } ?>
    <div class="wrap">
        <header class="entry-header">
            <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
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

</article><!-- #post-## -->
