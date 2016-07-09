<?php
/**
 * Template part for displaying posts.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package telamo_new
 */


$img = get_thumbnail('grid');
$classes= array();
if(strpos($img, 'fallback')) {
  $classes[] = 'fallback';
}

$content = get_post_field('post_content', get_the_ID());
$content_parts = get_extended($content);

?>
<article data-url="<?php the_permalink(); ?>" id="post-<?php the_ID(); ?>" <?php post_class($classes); ?>>

     <figure class="gridfigure">

        <a href="<?php the_permalink() ?>">
            <img src="/wp-includes/images/blank.gif" style="background-image:url(<?php echo $img ?>)">
        </a>

        <span class="icons gridicon"><?php icons(true, true); ?></span>
        <figcaption>
          <div>
            <h1 class="entry-title">
              <?php echo get_the_title() ?></h1>
          </div>
        </figcaption>
    </figure>

    <!-- content.php grid-->
</article>
