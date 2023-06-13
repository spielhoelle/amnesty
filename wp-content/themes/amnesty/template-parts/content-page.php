<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package amnesty
 */
 $classes = [];
 var_dump($post);
 $img =  wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' )[0];
 if($img) {
   $classes[] = 'header';
 } else {
   $classes[] = 'noheader';
 }
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if(get_the_title() !== '') { ?>
      <figure class="<?php echo implode(' ', $classes) ?>">
        <?php if($img){ ?>
          <img alt="<?php echo get_post(get_post_thumbnail_id($post->ID))->post_title ?>" src="/wp-includes/images/blank.gif" style="background-image:url(<?php echo $img ?>)">
        <?php } ?>

        <figcaption>
            <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
        </figcaption>

      </figure>
    <?php } ?>
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
